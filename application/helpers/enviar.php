<?php

//Recibe us_token, titulo, message

extract($_GET);
extract($_POST);

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'aps.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', "3ddos");

// Open a connection to the APNS server
$fp = stream_socket_client(
    'ssl://gateway.sandbox.push.apple.com:2195', $err,
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
        'alert' => array('title'=>$titulo, 'body'=>$message),
        'sound' => 'cork.aiff',
        'badge' => 1
        );

    // Encode the payload as JSON
    $payload = json_encode($body);
    
    // Build the binary notification
    $msg = chr(0) . pack('n', 32) . pack('H*', $us_token) . pack('n', strlen($payload)) . $payload;

    // Send it to the server
    $result = fwrite($fp, $msg, strlen($msg));

    
    if (!$result)
    {
        $return["error"] = TRUE;
        $return["data"] = "El mensaje no fue enviado.";
    }
    else
    {
        $return["error"] = FALSE;
        $return["data"] = "El mensaje fue enviado.";
    }
    
      
    fclose($fp);
}



echo json_encode($return);