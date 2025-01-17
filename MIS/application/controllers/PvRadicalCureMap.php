<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PvRadicalCureMap extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['Pv Radical Cure Map'])) redirect('Home');

		$data['cso'] = $this->getCSO();
        $data['hf'] = $this->getHF();

		$data['title'] = 'Pv Radical Cure Map';
		$data['main'] = 'pvradicalcuremap_view';
		$this->load->view('layout', $data);
	}

    private function getCSO()
    {
        $sql = "select distinct Code_OD_T, CSO2021 as CSO
				from tblHFCodes as a
				join tblProvince as b on a.Code_Prov_N = b.Code_Prov_T
				where a.IsTarget = 1";
		return $this->db->query($sql)->result();
    }

    private function getHF()
    {
        $sql = "select Name_Facility_E, Name_OD_E, Lat, Long
                from tblHFCodes as a
                where a.IsTarget=1 and IsReminder = 1";
		return $this->db->query($sql)->result();
    }

	public function getData()
	{
		$pv = $this->input->post('pv');
		$od = $this->input->post('od');
		$from = $this->input->post('from');
		$to = $this->input->post('to');

		$rs = $this->db->query("SP_PvMap '$pv','$od','$from','$to'")->result();
		$this->output->set_output(json_encode($rs));
	}

	public function getDetail()
	{
		$hc = $this->input->post('hc');
		$from = $this->input->post('from');
		$to = $this->input->post('to');

		$rs = $this->db->query("SP_PvMap_Detail '$hc','$from','$to'")->result();
		$this->output->set_output(json_encode($rs));
	}
}