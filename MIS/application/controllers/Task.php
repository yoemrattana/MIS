<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends MY_Controller
{
	public function index()
	{
        if ($_SESSION['role'] != 'AU') redirect('Home');

		$data['title'] = 'Task';
		$data['main'] = 'task_view';
		$this->load->view('layout', $data);
	}

	public function getData()
	{
		$year = $this->input->post('year');

		$sql = "select * from tblTask where year(DateFrom) = $year";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}
}