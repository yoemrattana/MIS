<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportPolice extends MY_Controller
{
	public function index()
	{
        if (!isset($_SESSION['permiss']['Reports Police'])) redirect('/Home');

		$data['title'] = "Reports For Police";
		$data['main'] = 'reportpolice_view';
		$this->load->view('layout', $data);
	}

	public function getPlace()
	{
		$sql = "select Code_Troop_T as code, Name_Troop_E as name, Name_Troop_K as nameK, Code_Prov_T as pvcode from tblPLTroopCodes order by Name_Troop_K";
		$rs['tp'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getReport($report)
	{
		$submit = $this->input->post();
		$submit = join("','", array_values($submit));
		$rs = $this->db->query("$report '$submit'")->result_array();
		$this->output->set_output(json_encode($rs));
	}
}