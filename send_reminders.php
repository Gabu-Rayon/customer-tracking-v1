<?php

require_once("config.php");


// Calculate the timestamp for 2 hours ago
$twoHoursAgo = date('Y-m-d H:i:s', strtotime('-2 hours'));

$sql = "SELECT * FROM moreusers WHERE created_at >= :twoHoursAgo";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':twoHoursAgo', $twoHoursAgo, PDO::PARAM_STR);
$stmt->execute();
$newUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Send reminder messages to new users
foreach ($newUsers as $user) {
    // Prepare the message content
    $message = "Hello, " . $user['username'] . "! Don't forget to Do your listing.";

    // Set up cURL for sending SMS
    $baseurl = "https://api.africastalking.com/sms/send";
    $ch = curl_init($baseurl);
    $data = array(
        "username" => "ASE1001",
        "to" => $user['phone'],
        "message" => $message,
    );
    $payload = json_encode($data);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Api-Key: da0fcf13aed9eb509cd47c9c52f6969a909f435638a1dcd2289561aa914ee28a'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = json_decode(curl_exec($ch), true);
    
    // Log the cURL response
    error_log('cURL Response: ' . print_r($result, true));

    curl_close($ch);
}

$pdo = null;

    //ErroR lOG File FOR CURL
    $logFile = 'log.php';
    $logHandle = fopen($logFile, 'a');
    if ($logHandle) {
        $logEntry = date('Y-m-d H:i:s') . ' - ';
        if ($result !== null) {
            $logEntry .= 'cURL Response: ' . print_r($result, true) . PHP_EOL;
        } else {
            $logEntry .= 'No cURL Response Received.' . PHP_EOL;
        }
        fwrite($logHandle, $logEntry);
        fclose($logHandle);
    }
