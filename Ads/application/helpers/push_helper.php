<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

////////////////////
// USO COMUN /////
///////////////////


////////////////////////
/// PUSH
///////////////////////

function push_mensaje_device($receptor_id, $titulo="", $message="")
{
    $CI =& get_instance();

    $CI->load->model('devices_model');
    $usr_push = $CI->devices_model->get_items(FALSE, $receptor_id);

    if($usr_push && $usr_push['dev_push'] != "")
    {
            if($usr_push['dev_plataforma'] == "APN")
            {
                //print_r($usr_push);
                //echo "<br>";
                //echo "http://www.3ddos.com.ar/wineon_push/enviar.php?us_token=".$receptor_id."&titulo=".$titulo."&message=".$message;
                //$result = file_get_contents("http://www.3ddos.com.ar/wineon_push/enviar.php?us_token=".$receptor_id."&titulo=".$titulo."&message=".$message);
                
                $ctx = stream_context_create();
                stream_context_set_option($ctx, 'ssl', 'local_cert', './assets/aps.pem');
                stream_context_set_option($ctx, 'ssl', 'passphrase', "3ddos");
                
                // Open a connection to the APNS server
                $fp = stream_socket_client(
                    'ssl://gateway.push.apple.com:2195', $err,
                    $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
                
                if (!$fp)
                {
                    $result = false;
                    $data[] = "Failed to connect: $err $errstr";
                }
                else
                {
                    // Create the payload body 
                    // ejemplo https://developer.apple.com/library/ios/documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/Chapters/ApplePushService.html
                    $body['aps'] = array(
                        'alert' => array('title' => $titulo, 'body' => $message),
                        'sound' => 'default',
                        'badge' => 1
                    );

                    // Encode the payload as JSON
                    $payload = json_encode($body);
                    
                    // Build the binary notification
                    $msg = chr(0) . pack('n', 32) . pack('H*', $usr_push['dev_push']) . pack('n', strlen($payload)) . $payload;

                    // Send it to the server
                    $result = fwrite($fp, $msg, strlen($msg));

                    //if (!$result)
                        //$result = 'Message not delivered';
                    //else
                        //$result = 'Message successfully delivered';
                      
                    fclose($fp);
                }
                
            }
            else
            {
                $registatoin_ids = array();
                $registatoin_ids[] = $usr_push['dev_push'];
                
                $gcm = new GCM();
                $result = $gcm->send_notification($registatoin_ids, array("title" => $titulo, "message" => $message));
            }
    }
    else
    {
        $result = false;
    }
    
    return $result;
}

function push_mensaje_token($usr_push, $titulo="", $message="")
{
    $CI =& get_instance();

    if($usr_push['us_token'] != "")
    {
        if($usr_push['us_service'] == "APN")
        {
            //echo "http://www.3ddos.com.ar/wineon_push/enviar.php?us_token=".$usr_push['us_token']."&titulo=".$titulo."&message=".urlencode($message);
            //$result = file_get_contents("http://www.3ddos.com.ar/wineon_push/enviar.php?us_token=".$usr_push['us_token']."&titulo=".$titulo."&message=".urlencode($message));
            
            $ctx = stream_context_create();
            stream_context_set_option($ctx, 'ssl', 'local_cert', './assets/aps.pem');
            stream_context_set_option($ctx, 'ssl', 'passphrase', "3ddos");
            
            // Open a connection to the APNS server
            $fp = stream_socket_client(
                'ssl://gateway.push.apple.com:2195', $err,
                $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
            
            if (!$fp)
            {
                $result = false;
                $data[] = "Failed to connect: $err $errstr";
            }
            else
            {
                // Create the payload body 
                // ejemplo https://developer.apple.com/library/ios/documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/Chapters/ApplePushService.html
                $body['aps'] = array(
                    'alert' => array('title' => $titulo, 'body' => $message),
                    'sound' => 'cork.aiff',
                    'badge' => 2
                    );

                // Encode the payload as JSON
                $payload = json_encode($body);
                
                // Build the binary notification
                $msg = chr(0) . pack('n', 32) . pack('H*', $usr_push['us_token']) . pack('n', strlen($payload)) . $payload;

                // Send it to the server
                $result = fwrite($fp, $msg, strlen($msg));

                
                //if (!$result)
                    //echo 'Message not delivered';
                //else
                    //echo 'Message successfully delivered';
                
                  
                fclose($fp);
            }
            
        }
        else
        {
            $registatoin_ids = array();
            $registatoin_ids[] = $usr_push['us_token'];
            
            $gcm = new GCM();
            $result = $gcm->send_notification($registatoin_ids, array("title" => $titulo, "message" => $message));
        }
    }
    else
    {
        $result = false;
    }
    
    return $result;
}

class GCM {
 
    //put your code here
    // constructor
    function __construct() {
         
    }
 
    public function send_notification($registatoin_ids, $message) {
 
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';
 
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );
 
        $headers = array(
            'Authorization: key=AIzaSyCkfMtIPc54vZy2ZdsHrJnvpPuCrgeyFpA',
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
        return $result;
    }
 
}