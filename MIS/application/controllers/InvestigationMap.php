<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InvestigationMap extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['Investigation Map'])) redirect('Home');

		$data['title'] = 'Investigation Map';
		$data['main'] = 'investigationmap_view';
		$this->load->view('layout', $data);
	}

	public function getData()
	{
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$species = $this->input->post('species');

		$rs = $this->db->query("SP_InvMap_HCData '$from','$to','$species'")->result();
		$this->output->set_output(json_encode($rs));
	}

	public function getVillage()
	{
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$hccode = $this->input->post('hccode');
		$species = $this->input->post('species');

		$rs = $this->db->query("SP_InvMap_VLData '$from','$to','$hccode','$species'")->result();
		$this->output->set_output(json_encode($rs));
	}

	public function getHouse()
	{
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$hccode = $this->input->post('hccode');
		$vlcode = $this->input->post('vlcode');
		$species = $this->input->post('species');

		$rs = $this->db->query("SP_InvMap_HouseData '$from','$to','$hccode','$vlcode','$species'")->result();
		$this->output->set_output(json_encode($rs));
	}
}