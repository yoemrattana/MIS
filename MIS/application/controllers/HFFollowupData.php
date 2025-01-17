<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HFFollowupData extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['HF Followup Patient'])) redirect('Home');

		$data['title'] = "HF follow up data";
		$data['main'] = 'hffollowup_data_view';

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
					select ID as Code_Facility_T, NameK, Age, Sex, Diagnosis,PatientCode, a.Rec_ID, Year, Month, Name_Vill_E
					from tblHFActivityCases as a
					join tblCensusVillage as b on b.Code_Vill_T = a.Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS and b.HaveVMW = 0
					where Diagnosis in ('V', 'M') and (G6PD = 'Normal' or Primaquine15 > 0 or Primaquine75 > 0)

					union all

					select ID as Code_Facility_T, NameK, Age, Sex, Diagnosis,PatientCode, a.Rec_ID, Year, Month, Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS as Name_Vill_E
					from tblHFActivityCases as a
					where Diagnosis in ('V', 'M') and (G6PD = 'Normal' or Primaquine15 > 0 or Primaquine75 > 0) and (ISNUMERIC(Code_Vill_t) = 0 or len(Code_Vill_t) < 10)
				),
				f as
				(
					select distinct Case_ID, PatientCode, Day from tblHFFollowup
				)

				select * from
				(
					select t.Rec_ID as Case_ID, t.PatientCode, f.Day, NameK, Age, Sex, Name_Vill_E,
					b.Name_Facility_E, b.Code_Facility_T, b.Name_OD_E, b.Code_OD_T, Name_Prov_E, Code_Prov_N
					from t
					join f on f.Case_ID = t.Rec_ID
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

		$sql = "select * from tblHFFollowUp where Day = '{$day}' and Case_ID = '{$caseId}' ";
		$rs = $this->db->query($sql)->row();

		$data['followup'] = $rs;

		$this->output->set_output(json_encode($data));
	}
}