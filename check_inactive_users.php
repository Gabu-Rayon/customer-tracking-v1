<?php
include("config.php");

require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$twoHoursAgo = date("Y-m-d H:i:s", strtotime("-2 hours"));


$sql = "SELECT id, email, phone FROM moreusers WHERE created_at < :twoHoursAgo";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':twoHoursAgo', $twoHoursAgo, PDO::PARAM_STR);
$stmt->execute();
$inactiveUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);


$smsApiKey = '';
$apiUrl = 'https://api.sms-service-provider.com/send-sms';
$apiUsername = '';  
$apiPassword = ''; 
$senderId = '';


$emailApiKey = '';
$emailApiEndpoint = 'https://api.email-service-provider.com/send-email';
$emailUsername = ''; 
$emailPassword = '';  
$smtpHost = ''; 
$smtpPort = 465;  

foreach ($inactiveUsers as $user) {
    $userId = $user['id'];
    $userEmail = $user['email'];
    $userPhone = $user['phone'];

    
    $message = 'Reminder: Make Listings';
    $smsSent = sendSMS($apiUrl, $apiUsername, $apiPassword, $senderId, $userPhone, $message);

    
    $emailSent = sendEmail($emailUsername, $emailPassword, $smtpHost, $smtpPort, $userEmail, 'Listing Reminder', 'Please make new listings.');

    // Log that reminders were sent to this user
    // You can log this in your database or a log file
    // Example: logRemindersSent($userId);

    if ($smsSent && $emailSent) {
        echo "Reminders sent to user $userId via SMS and Email.\n";
    } else {
        echo "Failed to send reminders to user $userId.\n";
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

    // Send SMS  cURL
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

        //Recipient
        $mail->setFrom($username, 'Your Name');
        $mail->addAddress($to);

        // Content
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
