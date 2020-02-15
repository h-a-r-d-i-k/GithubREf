<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('stripev1'))
{
	function stripev1($url, $code = null)
	{
		$client_secret = constant('stripe_secret_key');
		$authorization = "Authorization: Bearer  ".constant('stripe_secret_key');
  		$ch = curl_init();

		$curlConfig = array(
		    CURLOPT_URL            => $url,
		  	CURLOPT_HTTPHEADER     => array('Content-Type: application/json' , $authorization )
		);
		// curl_setopt($ch, CURLOPT_HTTPHEADER, );
		curl_setopt_array($ch, $curlConfig);
		$result = curl_exec($ch);
		curl_close($ch);

		// Will dump a beauty json :3
		return json_decode($result,true);
	}
}