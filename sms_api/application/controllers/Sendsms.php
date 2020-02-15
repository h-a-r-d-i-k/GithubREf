<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sendsms extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('send_sms');
	}
	public function sendMySms()
	{
		$this->load->helper('sendSms');
		$mobile = $this->input->post('mobile');
		$message = $this->input->post('message');
		$data = ['phone' => '+1'.$mobile, 'text' => $message];
		sendSMS($data);
		redirect('/');
	}
}
