<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MEAFIndicator extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['MEAF Indicators'])) redirect('/Home');

		$data['title'] = 'MEAF Indicators';
		$data['main'] = 'meafindicator_view';
		$this->load->view('layout', $data);
	}

	public function getData()
	{
		$rs = $this->db->get('tblMEAFIndicator')->result();

		$this->output->set_output(json_encode($rs));
	}
}