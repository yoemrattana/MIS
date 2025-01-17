<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['Contact'])) redirect('/Home');

		$data['title'] = 'Contact';
		$data['main'] = 'contact_view';
		$this->load->view('layout', $data);
	}

	public function getData()
	{
		$rs = $this->db->get('tblCNMUnit')->result();
		$data['unit'] = $rs;

		$rs = $this->db->get('tblContact')->result();
		$data['contact'] = $rs;

		$this->output->set_output(json_encode($data));
	}
}