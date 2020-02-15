<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('sendMail'))
{
	function sendMail($data,$message)
	{
		$CI =& get_instance();

		// print_r($data);exit();
		$CI->load->library('email');
		$config['protocol'] 	= $CI->config->item('protocol');
		$config['smtp_host'] 	= $CI->config->item('smtp_host');
		$config['smtp_port'] 	= $CI->config->item('smtp_port');
		$config['smtp_user'] 	= $CI->config->item('smtp_user');
		$config['smtp_pass'] 	= $CI->config->item('smtp_pass');
		$config['charset'] 		= $CI->config->item('charset');
		// $config['newline'] 		= $CI->config->item('newline');
		$config['mailtype'] 	= $CI->config->item('mailtype');
		// $config['smtp_debug'] 	= $CI->config->item('smtp_debug');
		$config['wordwrap'] 	= $CI->config->item('wordwrap');
		
		$config['smtp_crypto'] = 'tls'; 

		$config['_smtp_auth'] = TRUE;

		$config['send_multipart'] = TRUE;

		$CI->email->initialize($config);

		$CI->email->set_newline("\r\n");

		$CI->email->from($config['smtp_user'], $CI->config->item('project_name'));
		$CI->email->to($data['to_email']);

		$message = $CI->load->view('Emails/header','',TRUE);
		$message .= $CI->load->view('Emails/'.$data['email_template'],array('data' => $data),true);

		$message .= $CI->load->view('Emails/footer','' ,true);
		//echo $message;exit();

		$CI->email->subject($data['subject']);
		$CI->email->message($message);

		$is_send = $CI->email->send();

		if($is_send){
			$response=array("success"=>"1","message"=>"Mail Sent Successfully");
		} else {
			$response=array("success"=>"0","message"=>$CI->email->print_debugger());
			print_r($response);
			$response=array("success"=>"0","message"=>"Email sending failure, please try again!");
		}
		return $response;
	}
}


