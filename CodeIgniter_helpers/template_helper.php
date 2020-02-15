<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('template'))
{
	function template($layout, $data=null, $left_nav=null)
	{
		$CI =& get_instance();
		if(!$CI->session->userdata('current_user_client')){
			$h = 'Elements/header';
		} else {
			$h = 'Elements/p_header';
		}
		$template = (isset($layout['template']))? $layout['template'] : 'Elements/template';
		$header = (isset($layout['header']))? $layout['header'] : $h;
		$footer = (isset($layout['footer']))? $layout['footer'] : 'Elements/footer';
		$layoutname = (isset($layout['layoutname']))? $layout['layoutname'] : 'errors/html/error_404';


		$CI->load->view($template, array('partial' => $layoutname, 'header' => $header,'footer' => $footer, 'data' => $data));
	}
}