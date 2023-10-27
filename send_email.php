<?php
require_once __DIR__ . '/vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$to = $_POST['to'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// Create a new PHPMailer instance
$mail = new PHPMailer();

$mail->SMTPDebug = SMTP::DEBUG_SERVER;
/**
Incoming Server:	mail.more.co.ke
IMAP Port: 993 POP3 Port: 995
Outgoing Server:	mail.more.co.ke
SMTP Port: 465
*/
$mail->isSMTP();
$mail->Host = 'mail.more.co.ke';
$mail->SMTPAuth = true;
$mail->Username = 'more2023'; 
$mail->Password = 'TbEKED$81t{d'; 
$mail->SMTPSecure = 'tls';
$mail->Port = 465;

// Sender information
$mail->setFrom('gibson@more.co.ke', 'Gibson');
$mail->addAddress($to);

// Email content
$mail->isHTML(false);
$mail->Subject = $subject;
$mail->Body = $message;


// Send the email
if ($mail->send()) {
    echo 'Email sent successfully!';
} else {
    echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    $errorLog = 'log-files/email_error_log.php';
    $logMessage = '[' . date('Y-m-d H:i:s') . '] ' . $mail->ErrorInfo . "\n";
    error_log($logMessage, 3, $errorLog); 
}
?>