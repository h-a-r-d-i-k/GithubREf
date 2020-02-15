<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('mydate'))
{
	function mydate($date)
	{
		// Formating date from date string
		$updateddate = str_replace(' / ', '-', $date);
		$updateddate = str_replace('/', '-', $updateddate);
		$updateddate = explode('-', $updateddate);
		$updateddate = $updateddate[1] . '-' . $updateddate[0] . '-' . $updateddate[2];
		return date('Y-m-d', strtotime($updateddate));
	}
}