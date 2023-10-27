<?php


/**********When I Use With inputing the SENDER ID THE CODE IS NOT Working AND WORKING ************/

$action = $_POST['submit'];
$phone = $_POST['phone'];
$msg = $_POST['message'];

$senderId = 'MORE-INFO';

function sendSMS($message, $phone, $senderId) {
    $baseUrl = "https://api.africastalking.com/version1/messaging";

    $data = array(
        'username' => 'MORE_INFO',
        'to' => $phone,
        'message' => $message,
        'from' => $senderId, 
    );

    $ch = curl_init($baseUrl);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $headers = array(
        'ApiKey: 71dcedd103b9c5dc871779ae3b3a5eed722dab1f03da68ba7542fb1a45b1bb8a', 
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);

    if ($result === false) {
        echo "cURL error: " . curl_error($ch);
    } else {
        echo "Result: " . $result;
    }

    curl_close($ch);
}

switch ($action) {
    case 'single':
        sendSMS($msg, $phone, $senderId);
        break;
}



/**********When I Use Without inputing the SENDER ID THE CODE IS FINE AND WORKING ************/

// $action = $_POST['submit'];
// $phone = $_POST['phone'];
// $msg = $_POST['message'];

// function sendSMS($message, $phone) {
//     $baseUrl = "https://api.africastalking.com/version1/messaging";

//     $data = array(
//         'username' => 'MORE_INFO', 
//         'to' => $phone,
//         'message' => $message,
//     );

    
//     $ch = curl_init($baseUrl);
    
//     curl_setopt($ch, CURLOPT_POST, 1);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    
//     $headers = array(
//         'ApiKey: 71dcedd103b9c5dc871779ae3b3a5eed722dab1f03da68ba7542fb1a45b1bb8a',
//     );
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//     $result = curl_exec($ch);

//     if ($result === false) {
//         echo "cURL error: " . curl_error($ch);
//     } else {
//         echo "Result: " . $result;
//     }

//     curl_close($ch);
// }

// switch ($action) {
//     case 'single':
//         sendSMS($msg, $phone);
//         break;
// }

