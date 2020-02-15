<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('zipcode'))
{
	function zipcode($zipcode, $api_name ,$minimumradius = 0 , $maximumradius = 50)
	{
		$api_key = '9PXXXXXXXXXXXXXXXXXX';

		//API Url
		$baseurl = 'https://api.zip-codes.com/ZipCodesAPI.svc/1.0/';


		// $api_name = 'FindZipCodesInRadius?';
		if ($api_name == 'FindZipCodesInRadius?') {

			// If you need zipcode withing some radius
			$url = $baseurl.$api_name.'zipcode='.$zipcode.'&minimumradius='.$minimumradius.'&maximumradius='.$maximumradius.'&key='.$api_key;
		} else if ($api_name == 'QuickGetZipCodeDetails') {

			// zipcode details from zipcode
			$url = $baseurl.$api_name.'/'.$zipcode.'?key='.$api_key;
		} else {
			exit;
		}
		
		//  Initiate curl
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL,$url);
		// Execute
		$result=curl_exec($ch);
		// Closing
		curl_close($ch);
		// $result = file_get_contents($url);
		$result = preg_replace(
					  '/
					    ^
					    [\pZ\p{Cc}\x{feff}]+
					    |
					    [\pZ\p{Cc}\x{feff}]+$
					   /ux',
					  '',
					  $result
					);
		// Will dump a beauty json :3
		return json_decode($result,true);
	}
}