<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LastmileDashboard extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['Lastmile'])) redirect('Home');

		$data['title'] = 'Lastmile Dashboard';
		$data['main'] = 'lastmile_dashboard_view';

		$this->load->view('layout', $data);
	}

	public function getData()
	{
		$year = $this->input->post('year');
		$mf = $this->input->post('mf');
		$mt = $this->input->post('mt');

		$rs['countVillage'] = $this->db->query("SP_LastmileDashboard_CountVillage '$year','$mf','$mt'")->result();
		$rs['countHouse'] = $this->db->query("SP_LastmileDashboard_CountHouse '$year','$mf','$mt'")->result();
		$rs['peoplePositive'] = $this->db->query("SP_LastmileDashboard_PeoplePositive '$year','$mf','$mt'")->result();
		$rs['percentIPTTDA'] = $this->db->query("SP_LastmileDashboard_PercentIPTTDA '$year','$mf','$mt'")->result();
		$rs['numberIPTTDA'] = $this->db->query("SP_LastmileDashboard_NumberIPTTDA '$year','$mf','$mt'")->result();
		$rs['table'] = $this->db->query("SP_LastmileDashboard_Table '$year','$mf','$mt'")->result();

		$this->output->set_output(json_encode($rs));
	}
}