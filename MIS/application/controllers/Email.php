<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller
{
	public function index()
	{
		if ($_SESSION['role'] != 'AU') redirect('Home');

		$data['title'] = "Email Configuration";
		$data['main'] = 'email_view';

		$this->load->view('layoutV3', $data);
	}

	public function getData()
	{
		$rs = $this->db->get('tblEmailConfig')->row_array();
		$this->output->set_output(json_encode($rs));
	}

	public function save()
	{
		$submit = $this->input->post('submit');
		$submit = json_decode($submit, true);
		$this->db->update('tblEmailConfig', $submit);
	}

	public function send()
	{
        $recaptchaResponse = trim($this->input->post('g-recaptcha-response'));

        $userIp=$this->input->ip_address();

        $secret = $this->config->item('google_secret');

        $url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $status= json_decode($output, true);

        if ($status['success']) {
            $submit = $this->input->post('submit');
            $submit = json_decode($submit, true);

            $this->load->library('email');

            $param = $this->getConfig();

            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'smtp.gmail.com';
            $config['smtp_port'] = '587';
            $config['smtp_crypto'] = 'tls';
            $config['smtp_user'] = trim($param['smtp_user']); // pass login email: Adm!n123
            $config['smtp_pass'] = trim($param['smtp_pass']); //app password
            //hutrevccelvxyoyz
            $config['mailtype'] = 'html';
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE;
            $config['newline'] = "\r\n"; //use double quotes
            $this->email->initialize($config);

            $this->email->set_mailtype('html');
            $this->email->from($submit['email'], $submit['name']);
            $this->email->to($param['to']);
            $this->email->cc($param['cc']);
            $this->email->subject('MIS: ' . $submit['subject']);

            $message = '<p> ' . $submit['message'] . ',</p>';

            $this->email->message($message);
            $this->email->send();
        }else{
            die($status);
        }

		//$rs =  $this->email->print_debugger();
		//file_put_contents('C:\Note.txt', print_r($rs, true));
	}

	public function getConfig()
	{
		return $this->db->get('tblEmailConfig')->row_array();
	}
}