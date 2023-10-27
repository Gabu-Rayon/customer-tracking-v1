<?php
session_start();
require_once("config.php");
if (empty($_SESSION['id'])) {
    header("Location: sign-in.php");
} else {

    $id = $_SESSION['id'];
    $sql = $pdo->prepare("SELECT * FROM `users` WHERE `id`='$id'");
    $sql->execute();
    $fetch = $sql->fetch();
    $user_name = $fetch['username'];
    /**
     * This Code Work Only if your are using Curl with correct Username,Sender Id and ApiKey
    if (isset($_POST['submit'])) {
        // $api_url = "https://api.africastalking.com/version1/messaging"; 
        // $sender_id = "MORE-INFO"; 
        // $ch = curl_init($api_url);
        // $data = array(
        //     "username" => "MORE_INFO", 
        //     "to" => $_POST['phone'],
        //     "message" => $_POST['message'],
        //     "from" => $sender_id,
        // );
        $baseurl = "https://api.africastalking.com/version1/messaging";
        $ch = curl_init($baseurl);
        $data = array(
            "username" => "MORE_INFO",
            "to" => $_POST['phone'],
            "message" => $_POST['message'],
            "from" => "MORE_INFO"
        );
        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Api-Key: 71dcedd103b9c5dc871779ae3b3a5eed722dab1f03da68ba7542fb1a45b1bb8a'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch), true);
        // Log the cURL response
        error_log('cURL Response: ' . print_r($result, true));
        curl_close($ch);

        // Check the response
        // Check if $result is not null
        if ($result !== null) {
            if (isset($result['SMSMessageData']['Message'])) {
                if ($result['SMSMessageData']['Message'] == "Sent to 1/1 Total Cost: KES 1.0000") {

                    echo '<script>alert("Message sent successfully.");</script>';
                } else {
                    echo '<script>alert("Failed to send the message. Error: ' . $result['SMSMessageData']['Message'] . '");</script>';
                }
            } else {
                echo '<script>alert("Failed to send the message. No message data received.");</script>';
            }
        } else {
            echo '<script>alert("Failed to send the message. No response data received.");</script>';
        }

        //ErroR lOG File FOR CURL
        $logFile = 'log-files/sms_error_log.php';
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
    }
     */


    include("inc/header.php");
    include("inc/sidebar.php");
?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Send SMS</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Send User SMS</li>
                </ol>

                <?php
                if (isset($_POST['submit'])) {
                    require_once 'sms.php';
                    $livesms = new SMS();
                    @$phone = $_POST['phone'];
                    @$message = $_POST['message'];
                    @$result = $livesms->send($phone, $message);
                }
                if (@$result['success'] && !empty($result['message'])) {
                    echo '<div class="alert alert-primary" role="alert">
            ' . @$result['message'] . '
            </div>';
                } elseif (!@$result['success'] && !empty($result['message'])) {
                    echo '<div class="alert alert-danger" role="alert">
            ' . @$result['message'] . '
            </div>';
                }
                ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        More Classifieds Send SMS
                    </div>
                    <div class="card-body">
                        <form class="form" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                            <!-- <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <select class="form-select" name="phone" id="phone" required>
                                            <option value="" disabled selected>Select a phone</option>
                                            <?php
                                            // $twoHoursAgo = date("Y-m-d H:i:s", strtotime('-2 hours'));
                                            // $sql = $pdo->prepare("SELECT phone,name FROM moreusers WHERE created_at <= :twoHoursAgo");
                                            // $sql->bindParam(':twoHoursAgo', $twoHoursAgo);
                                            // $sql->execute();
                                            // $phoneUserArray = array();

                                            // while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                                            //     $phone = $row['phone'];
                                            //     $name = $row['name'];
                                            //     $phoneUserArray[$phone] = $name;
                                            // }

                                            // foreach ($phoneUserArray as $phone => $name) {
                                            //     echo '<option value="' . $phone . '">' . $phone . ' - ' . $name . '</option>';
                                            // }
                                            ?>
                                        </select>
                                        <label class="form-check-label" for="phone">Phone:</label>
                                    </div>
                                </div>
                            </div>-->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number">
                                        <label for="phone">Phone</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <textarea class="form-control" type="text" cols="10" id="message" name="message" placeholder="Enter your Message:" required>
                                            </textarea>
                                        <label class="form-check-label" for="to">Message:</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 mb-0">
                                <div class="d-grid"><button class="btn btn-primary btn-block" name="submit">Send Message</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    <?php
    include("inc/footer.php");
}
