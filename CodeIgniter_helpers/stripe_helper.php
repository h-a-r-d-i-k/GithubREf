<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('stripe'))
{
	function stripe($url, $code = null)
	{
		$client_secret = constant('stripe_secret_key');
  		$ch = curl_init();
		$curlConfig = array(
		    CURLOPT_URL            => $url,
		    CURLOPT_POST           => true,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_POSTFIELDS     => array(
		        'grant_type' => 'authorization_code',
		        'client_secret' => $client_secret,
		        'code' => $code,
		    )
		);
		curl_setopt_array($ch, $curlConfig);
		$result = curl_exec($ch);
		curl_close($ch);

		// Will dump a beauty json :3
		return json_decode($result,true);
	}
}