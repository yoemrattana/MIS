<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PPMReferralSlip extends MY_Controller
{
	public function index($v = '')
	{
		if (!isset($_SESSION['permiss']['PPM Referral Slip'])) redirect('Home');

		$data['main'] = 'ppm_referral_slip_view';
		$this->load->view('layout', $data);
	}

	public function getReport()
	{
		$year = $this->input->post('year');
		$od = $this->input->post('od');

		$sql = "select a.Code_Facility_T, Name_Facility_E, Name_Facility_K, Month
				from tblHFCodes as a
				join V_HFLog as b on a.Code_Facility_T = b.Code_Facility_T and b.Year = '$year'
				where Type_Facility = 'HC' and Code_OD_T = '$od'
				order by Name_Facility_E";
		$rs['hfs'] = $this->db->query($sql)->result();

		$sql = "select b.Code_Facility_T, b.Month
				from tblHFCodes as a
				join tblPPMReferralSlip as b on a.Code_Facility_T = b.Code_Facility_T
				where a.Code_OD_T = '$od' and Year = '$year'";
		$rs['reports'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getList()
	{
		$where = $this->input->post();

		$rs = $this->db->get_where('tblPPMReferralSlip', $where)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function save()
	{
		$value = $this->input->post();

		$id = $value['Rec_ID'];
		unset($value['Rec_ID']);

	    if ($id == 0) {
	        $value['InitUser'] = $_SESSION['username'];
	        $this->db->insert('tblPPMReferralSlip', $value);
	        $id = $this->db->insert_id();
	    } else {
	        $value['ModiUser'] = $_SESSION['username'];
	        $value['ModiTime'] = sqlNow();
	        $where['Rec_ID'] = $id;
	        $this->db->update('tblPPMReferralSlip', $value, $where);
	    }

	    $this->output->set_output(json_encode($id));
	}

	public function exportExcel()
	{
		$sql = "select Year
					  ,Month
					  ,Card
					  ,ServicePerson
					  ,PrivateService
					  ,c.Name_Prov_E as Province
					  ,Name_Dist_E as District
					  ,Name_Comm_E as Commune
					  ,Name_Vill_E as Village
					  ,g.Name_Prov_E as NearbyProvince
					  ,Name_OD_E as NearbyOD
					  ,NearbyHF
					  ,PatientName
					  ,Sex
					  ,Age
					  ,Pregnant
					  ,Symptom
					  ,OtherSymptom
					  ,ReferredHFType
					  ,ReferredHFName
					  ,ReferredDate
					  ,ReferredTime
					  ,SymptomDate
					  ,MedicineName
				from tblPPMReferralSlip as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblProvince as c on b.Code_Prov_T = c.Code_Prov_T
				join tblDistrict as d on b.Code_Dist_T = d.Code_Dist_T
				join tblCommune as e on b.Code_Comm_T = e.Code_Comm_T
				join tblOD as f on a.Code_OD_T = f.Code_OD_T
				join tblProvince as g on f.Code_Prov_T = g.Code_Prov_T";

		ExportExcel($sql);
	}
}