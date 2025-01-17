<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VMWFollowupData extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['VMW Followup Patient'])) redirect('Home');

		$data['title'] = "VMW follow up data";
		$data['main'] = 'vmwfollowup_data_view';

		$this->load->view('layoutV3', $data);
	}

	public function getData()
	{
		$province = $this->input->post( 'province' );
		$year = $this->input->post( 'year' );
		$month = $this->input->post( 'month' );

		$where = empty( $month ) ? ' ' : " and Month = '{$month}'";

		$sql = "with t as
				(
					select b.HCCode as Code_Facility_T, ID as Code_Vill_T,
					NameK, Age, Sex, PatientCode, Diagnosis, concat('VMW_', Rec_ID) as Case_ID, Year, Month
					from tblVMWActivityCases as a
					join tblCensusVillage as b on a.ID = b.Code_Vill_T
					where Diagnosis in ('V', 'M') and (PQTreatment = 'ASMQ + 14 days PQ' or Primaquine75 > 0 or Primaquine15 >0)

					union all

					select ID as Code_Facility_T, Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS,
					NameK, Age, Sex, PatientCode, Diagnosis, concat('HC_', Rec_ID) as Case_ID, Year, Month
					from tblHFActivityCases
					where Diagnosis in ('V', 'M') and (PQTreatment = 'ASMQ + 14 days PQ' or Primaquine75 > 0 or Primaquine15 > 0)
				),
				f as
				(
					select distinct Case_ID, PatientCode, Day from tblVMWFollowUp
				)

				select * from
				(
					select t.Case_ID, t.PatientCode,f.Day, NameK, Age, Sex, a.Name_Vill_E,a.Code_Vill_T,
					b.Name_Facility_E, b.Code_Facility_T, b.Name_OD_E, b.Code_OD_T, Name_Prov_E, Code_Prov_N
					from t
					join f on f.Case_ID = t.Case_ID
					join tblCensusVillage as a on a.Code_Vill_T = t.Code_Vill_T
					join tblHFCodes as b on t.Code_Facility_T = b.Code_Facility_T
					join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
					where b.Code_Prov_N = '{$province}' and Year = '{$year}' {$where}
				) as sub
				pivot (
					count(Day)
					for day in
					(
						[Day3], [Day7], [Day14]
					)
				) as p
				";

		$rs = $this->db->query( $sql )->result();
		$this->output->set_output( json_encode( $rs ) );
	}

	public function getFollowup()
	{
		$caseId = $this->input->post('case_id');
		$day = $this->input->post('day');

		$sql = "select * from tblVMWFollowUp where Day = '{$day}' and Case_ID = '{$caseId}' ";
		$rs = $this->db->query($sql)->row();

		$data['followup'] = $rs;

		$this->output->set_output(json_encode($data));
	}
}