<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VMWSurvey extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['VMW Survey'])) redirect('Home');

		$data['title'] = 'VMW Survey';
		$data['main'] = 'vmwsurvey_view';
		$this->load->view('layout', $data);
	}

	public function getData($id = 0)
	{
		$pv = $_SESSION['prov'];
		$od = $_SESSION['code_od'];

		$sql = "select Code_Prov_N, Name_Prov_E, Code_OD_T, Name_OD_E, Code_Facility_T, Name_Facility_E, Name_Vill_E, a.*
				from tblVMWSurvey as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				where ($id = 0 or a.Rec_ID = $id) and ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or Code_OD_T = '$od')";
		$rs = $this->db->query($sql)->result();

		if ($id == 0) {
			$this->output->set_output(json_encode($rs));
			return true;
		}

		return $rs[0];
	}

	public function getDetail()
	{
		$where['ParentId'] = $this->input->post('id');

		$rs = $this->db->get_where('tblVMWSurveyDetail', $where)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function save()
	{
		$master = json_decode($this->input->post('master'), true);
		$details = json_decode($this->input->post('details'), true);

		$id = $master['Rec_ID'];
		unset($master['Rec_ID']);

		if ($id == 0) {
			$master['InitUser'] = $_SESSION['username'];
			$this->db->insert('tblVMWSurvey', $master);
			$id = $this->db->insert_id();
		} else {
			$master['ModiUser'] = $_SESSION['username'];
			$master['ModiTime'] = sqlNow();
			$this->db->update('tblVMWSurvey', $master, ['Rec_ID' => $id]);
		}

		$this->db->delete('tblVMWSurveyDetail', ['ParentId' => $id]);

		foreach ($details as $value)
		{
			foreach ($value as $k => $v) $value[$k] = $v;
			$value['ParentId'] = $id;
			$this->db->insert('tblVMWSurveyDetail', $value);
		}

		$this->output->set_output(json_encode($this->getData($id)));
	}

	public function exportExcel()
	{
		$sql = "select Name_Prov_E, Name_OD_E, Name_Facility_E, Name_Vill_E, AuditorName, AuditDate, VMWName, VMWDate, b.*
				from tblVMWSurvey as a
				join tblVMWSurveyDetail as b on a.Rec_ID = b.ParentId
				join tblCensusVillage as c on a.Code_Vill_T = c.Code_Vill_T
				join tblHFCodes as d on c.HCCode = d.Code_Facility_T
				join tblProvince as e on d.Code_Prov_N = e.Code_Prov_T
				order by AuditDate";

		ExportExcel($sql);
	}
}