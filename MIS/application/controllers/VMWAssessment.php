<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VMWAssessment extends MY_Controller
{
	public function index()
	{
		$data['main'] = 'vmwassessment_view';
		$this->load->view('layout', $data);
	}

	public function getData()
	{
		$sql = "select Name_Prov_E, Name_OD_E, Name_Facility_E, Name_Vill_E, Code_Prov_N, Code_OD_T, Code_Facility_T, a.*
				from tblVMWAssessment as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				order by Name_Prov_E, Name_OD_E, Name_Facility_E, Name_Vill_E";
		$rs = $this->db->query($sql)->result();

		$this->output->json($rs);
	}

	public function getDetail()
	{
		$rs = $this->db->get_where('tblVMWAssessmentDetail', $this->submit)->result();

		$this->output->json($rs);
	}

	public function save()
	{
		$master = $this->submit->master;
		$id = $master->Rec_ID;

		unset($master->Rec_ID);

		if ($id == 0) {
			$this->db->insert('tblVMWAssessment', $master);
			$id = $this->db->insert_id();
		} else {
			$this->db->update('tblVMWAssessment', $master, ['Rec_ID' => $id]);
		}

		$this->db->delete('tblVMWAssessmentDetail', ['ParentId' => $id]);

		foreach ($this->submit->detail as $value)
		{
			$value->ParentId = $id;
			$this->db->insert('tblVMWAssessmentDetail', $value);
		}
	}

	public function delete()
	{
		$this->db->delete('tblVMWAssessment', $this->submit);
	}
}