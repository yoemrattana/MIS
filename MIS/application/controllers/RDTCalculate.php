<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RDTCalculate extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['RDT Calculate'])) redirect('/Home');

		$data['title'] = 'RDT Calculate';
		$data['main'] = 'rdtcalculate_view';
		$this->load->view('layout', $data);
	}
}