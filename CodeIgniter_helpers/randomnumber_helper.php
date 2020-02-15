<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('randomnumber'))
{
	function randomnumber($digits_needed=10)
	{
			$random_number=''; // set up a blank string
			$count=0;
			while ( $count < $digits_needed ) {
				$random_digit = mt_rand(0, 9);
				$random_number .= $random_digit;
				$count++;
			}
			return $random_number;
	}
}