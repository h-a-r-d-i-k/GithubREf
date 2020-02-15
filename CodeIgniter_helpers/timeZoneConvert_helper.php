<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('timeZoneConvert'))
{
	function timeZoneConvert($fromTime, $fromTimezone, $toTimezone,$format = 'Ymd\\THi00\\Z') {
	     // create timeZone object , with fromtimeZone
	    $from = new DateTimeZone($fromTimezone);
	     // create timeZone object , with totimeZone
	    $to = new DateTimeZone($toTimezone);
	    // read give time into ,fromtimeZone
	    $orgTime = new DateTime($fromTime, $from);
	    // fromte input date to ISO 8601 date (added in PHP 5). the create new date time object
	    $toTime = new DateTime($orgTime->format("c"));
	    // set target time zone to $toTme ojbect.
	    $toTime->setTimezone($to);
	    // return reuslt.
	    return $toTime->format($format);
	}
}