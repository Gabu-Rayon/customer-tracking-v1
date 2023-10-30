<?php
include("config.php");

require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$pdo; 
$apiUrl = 'https://api.sms-service-provider.com/send-sms';
$apiUsername ="";
$apiPassword ="";
$senderId ="";
$emailUsername ="";
$emailPassword ="";
$smtpHost ="";
$smtpPort = 465;
$customerCareEmail = "";
$customerCarePhone = "";

// Calculate the timestamp for two hours ago
$twoHoursAgo = date("Y-m-d H:i:s", strtotime("-2 hours"));

// Fetch inactive users who signed up more than two hours ago
$sql = "SELECT id, email, phone FROM moreusers WHERE created_at < :twoHoursAgo";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':twoHoursAgo', $twoHoursAgo, PDO::PARAM_STR);
$stmt->execute();
$inactiveUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($inactiveUsers as $user) {
    $userId = $user['id'];
    $userEmail = $user['email'];
    $userPhone = $user['phone'];

    $message = 'Reminder: Make Listings';

    // Send SMS reminder to the user
    $smsSent = sendSMS($apiUrl, $apiUsername, $apiPassword, $senderId, $userPhone, $message);

    // Send Email reminder to the user
    $emailSent = sendEmail($emailUsername, $emailPassword, $smtpHost, $smtpPort, $userEmail, 'Listing Reminder', 'Please make new listings');

    if ($smsSent && $emailSent) {
        echo "Reminders sent to user $userId via SMS and Email.\n";
    } else {
        echo "Failed to send reminders to user $userId.\n";

        // If reminders were not sent successfully, send a message to customer care
        $customerCareMessage = "User $userId is having difficulty making listings. Please provide assistance.";
        $customerCareSmsSent = sendCustomerCareSms($apiUrl, $apiUsername, $apiPassword, $senderId, $customerCarePhone, $customerCareMessage);
        $customerCareEmailSent = sendCustomerCareEmail($customerCareEmail, 'Customer Care Request', $customerCareMessage);

        if ($customerCareSmsSent && $customerCareEmailSent) {
            echo "Customer care notified about user $userId's issue.\n";
        } else {
            echo "Failed to notify customer care about user $userId's issue.\n";
        }
    }
}
$pdo = null;

function sendSMS($apiUrl, $apiUsername, $apiPassword, $senderId, $phone, $message) {
    $postData = [
        'username' => $apiUsername,
        'password' => $apiPassword,
        'sender_id' => $senderId,
        'phone' => $phone,
        'message' => $message,
    ];

    $ch = curl_init($apiUrl);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $response = curl_exec($ch);
    if ($response === false) {
        return false; 
    }
    curl_close($ch);
    return true;
}

function sendEmail($username, $password, $host, $port, $to, $subject, $message) {
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $port;

        $mail->setFrom($username, 'Your Name');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function sendCustomerCareSms($apiUrl, $apiUsername, $apiPassword, $senderId, $customerCarePhone, $message) {
    $array = [
        'username' => $apiUsername,
        'password' => $apiPassword,
        'sender_id' => $senderId,
        'phone' => $customerCarePhone,
        'message' => $message,
    ];
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $array);
    $response = curl_exec($ch);
    if ($response === false) {
        return false;
    }
    curl_close($ch);
    return true; 
}

function sendCustomerCareEmail($customerCareEmail,$emailUsername,$emailPassword,$smtpHost,$smtpPort,$subject, $message) {
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host = $smtpHost; 
        $mail->SMTPAuth = true;
        $mail->Username = $emailUsername; 
        $mail->Password = $emailPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $smtpPort;

        $mail->setFrom($emailUsername, 'Your Name');
        $mail->addAddress($customerCareEmail);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
