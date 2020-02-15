<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require $_SERVER['DOCUMENT_ROOT'] . '/sms_api/vendor/autoload.php';

use Twilio\Rest\Client;

if (!function_exists('sendsms'))
{
	function sendsms($data)
	{
		// twillio sms test
		$sid = 'ACXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
	 	$token = '44XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
	    

	    $client = new Client($sid, $token);

	    // Use the client to do fun stuff like send text messages!
	    try
	    {
	    	$message = $client->messages->create(
	        // the number you'd like to send the message to
	        $data['phone'],
	        array(
	            // A Twilio phone number you purchased at twilio.com/console
	            "from" => "+1830XXXXXXX",

	            // the body of the text message you'd like to send
                "AccountSid"=> "MyXXXXXXXX",

	            'body' => $data['text']
	        )
	    	);
	    }  catch (Twilio\Exceptions\EnvironmentException $e) {
			print_r($e);
		}

		print_r($message->sid);
	}
}