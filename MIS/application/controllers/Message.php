<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends MY_Controller
{
	public function index()
	{
		if ($_SESSION['role'] != 'AU') redirect('Home');

		$data['title'] = 'Messager';
		$data['main'] = 'message_view';

		$this->load->view('layoutV3', $data);
	}

	public function getList()
	{
		$rs = $this->db->get('tblMessage')->result();
		$this->output->set_output(json_encode($rs));
	}

	public function reply()
	{
		$submit = $this->input->post('submit');
		$submit = json_decode($submit, true);
		$submit['InitTime'] = sqlNow();
		unset($submit['Place'], $submit['Rec_ID'], $submit['Label'],$submit['isCNM']);
		$this->db->insert('tblMessage', $submit);
	}
}