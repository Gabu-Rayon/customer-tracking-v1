<?php

$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


// Create a new PHPMailer instance
$mail = new PHPMailer(true);

$mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = '';
$mail->SMTPSecure = PHPMAILER::ENCRYPTION_STARTTLS; // and port 587 is (tls)
$mail->Port = 465; 

$mail->Username = ''; 
$mail->Password = ''; 


// Sender information
$mail->setFrom($email, $name);

//Receipt information
$mail->addAddress("gibson@more.co.ke","Gibson");

// Email content
$mail->isHTML(false);
$mail->Subject = $subject;
$mail->Body = $message;

$mail->send();

echo "Mail Sent";
// Send the email
if ($mail->send()) {
    echo "<script>alert('Email sent successfully!')</script>";
    header("Location: bulky_sms.php");
    exit;
} else {
    echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    $errorLog = 'log-files/email_error_log.php';
    $logMessage = '[' . date('Y-m-d H:i:s') . '] ' . $mail->ErrorInfo . "\n";
    error_log($logMessage, 3, $errorLog); 
}
?>