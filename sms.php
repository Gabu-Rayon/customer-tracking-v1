<?php
    require 'vendor/autoload.php';
    require 'constants.php';
    use AfricasTalking\SDK\AfricasTalking;

class SMS{
    public function send($to, $message){ 
        if (isset($to) && isset($message)) {  
            $response = array();
            $AT = new AfricasTalking(USERNAME, APIKEY); 
            if (empty($to)) { 
                $response["message"] = "Phone number cannot be empty";
                $response["success"] = false;
                return $response;
            }
            if (empty($message)) { 
                $response["message"] = "Message cannot be empty";
                $response["success"] = false;
                return $response;
            }
            $sms      = $AT->sms();
            
            try {
                // Use the service
                $result = '';
                $result   = $sms->send([
                        'to'      => $to,
                        'message' => $message,
                        'from' => SENDERID
                    ]);
            $response["message"] = "Message sent successfully";
            $response["success"] = true;   
            return $response;
            } catch (\Throwable $th) {
                $response["message"] = "Error ".$th;
                $response["success"] = false;
                return $response;
            }
            
        }else{ 
            $response["message"] = "Number and message required";
            $response["success"] = false;
            return $response;
        }
    }
 }

?>