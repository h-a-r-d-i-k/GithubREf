<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('csvgenerator'))
{
	function csvgenerator($data)
	{
		$max = max($data);

		$filename = "csv_".date("Y-m-d_H-i-s",time()).".csv";

		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");

		$csv_filename = FCPATH."assets/csv/".$filename;
		// echo $csv_filename;
		if (!empty($data)) {
			$file = fopen($csv_filename, 'w');

			$keys = array();
			foreach ($max as $key=>$line){ 
				array_push($keys, $key);
			}
			fputcsv($file, $keys);

			foreach ($data as $key=>$line){ 
				fputcsv($file,$line); 
			}
			fclose($file); 
		}

		$resp = array('fullpath' => $csv_filename, 'filename' => $filename);
		return $resp;
	}
}