<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WhoExport extends MY_Controller
{
	public function index()
	{
		$data['main'] = 'whoexport_view';
		$this->load->view('layout', $data);
	}

	public function getList()
	{
		$rs = array_slice(scandir('C:/MIS/Who Data'), 2);
		$this->output->set_output(json_encode($rs));
	}

	public function export()
	{
		$filename = $this->input->post('filename');
		$path = "C:/MIS/Who Data/$filename";

		$this->output->set_header('Content-Length: ' . filesize($path));
		$this->output->set_content_type('xlsx');
		$this->output->set_output(file_get_contents($path));
	}
}