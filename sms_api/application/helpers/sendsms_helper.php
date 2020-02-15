<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require $_SERVER['DOCUMENT_ROOT'] . '/sms_api/vendor/autoload.php';

use Twilio\Rest\Client;

function sendSMS($data) {
  	// Your Account SID and Auth Token from twilio.com/console
    $sid = 'ACXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
    $token = '13XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
    $client = new Client($sid, $token);


    // Use the client to do fun stuff like send text messages!
    try
    {
    	$client->messages->create(
        // the number you'd like to send the message to
        $data['phone'],
        array(
            // A Twilio phone number you purchased at twilio.com/console
            "from" => "+16XXXXXXXXX",
            // the body of the text message you'd like to send
            'body' => $data['text']
        )
    	);
    }  catch (Twilio\Exceptions\EnvironmentException $e) {
	   return false;
	}
	return true;

     
}


?>