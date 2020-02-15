<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('readpost'))
{
	function readpost()
	{
		// reading ajax json post request
		return json_decode(file_get_contents('php://input'), true);
	}
}