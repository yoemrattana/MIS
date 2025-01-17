<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportMilitary extends MY_Controller
{
	public function index()
	{
        if (!isset($_SESSION['permiss']['Reports MMP'])) redirect('/Home');

		$data['title'] = "Reports For MMP";
		$data['main'] = 'reportmilitary_view';
		$this->load->view('layout', $data);
	}

	public function getReport($report)
	{
		$submit = $this->input->post();
		$submit = join("','", array_values($submit));
		$rs = $this->db->query("$report '$submit'")->result_array();
		$this->output->set_output(json_encode($rs));
	}
}