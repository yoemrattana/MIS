<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VMWFollowup extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['VMW Followup Patient'])) redirect('Home');

		$data['title'] = "VMW Follow up";
		$data['main'] = 'vmwfollowup_view';

		$this->load->view('layoutV3', $data);
	}

	public function getData()
	{
		//$where = '';
		//if ($_SESSION['code_od'] != '') $where = "where Code_OD_T = '{$_SESSION['code_od']}'";
		//elseif ($_SESSION['code_prov'] != '') $where = "where Code_Prov_N in ('{$_SESSION['code_prov']}')";

		$prov = $this->input->post('prov');
		$od = $this->input->post('od');
		$y = $this->input->post('y');

		$where = '';
		if ( empty( $od ) ) $where = " where Code_Prov_N = '{$prov}'";
		else $where = " where Code_OD_T = '{$od}'";

		$sql = "with cases as (
					select ID as Code_Facility_T, a.Code_Vill_t as Code_Vill_T, PatientCode,
					NameK, DateCase, Diagnosis, PatientPhone, Year, Month, concat('HC_',a.Rec_ID) as Case_ID, PrimaquineDate
					from tblHFActivityCases as a
					join tblCensusVillage as b on a.Code_Vill_t = b.Code_Vill_T and HaveVMW = 0
					where Diagnosis in ('V', 'M', 'O') and Year = '{$y}' and (Primaquine15 > 0 or Primaquine75 > 0)

					union all

					select HCCode as Code_Facility_T, ID as Code_Vill_T, PatientCode,
					NameK, DateCase, Diagnosis, PatientPhone, Year, Month, concat('VMW_',a.Rec_ID) as Case_ID, PrimaquineDate
					from tblVMWActivityCases as a
					join tblCensusvillage as b on b.Code_Vill_T = a.ID
					where Diagnosis in ('V', 'M', 'O') and Year = '{$y}' and (Primaquine15 > 0 or Primaquine75 > 0)
				)

				select * from
				(
					select a.*, IsReminder, Code_OD_T, b.Code_Prov_N, Day,
					DATEADD(DAY, 3, PrimaquineDate) as Day3Date, DATEADD(DAY, 7, PrimaquineDate) as Day7Date,
					DATEADD(WEEK, 2, PrimaquineDate) as W2Date, DATEADD(WEEK, 3, PrimaquineDate) as W3Date,
					DATEADD(WEEK, 4, PrimaquineDate) as W4Date, DATEADD(WEEK, 5, PrimaquineDate) as W5Date,
					DATEADD(WEEK, 6, PrimaquineDate) as W6Date, DATEADD(WEEK, 7, PrimaquineDate) as W7Date,
					DATEADD(WEEK, 8, PrimaquineDate) as W8Date
					from cases as a
					join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
					left join tblVMWFollowup as c on CAST(a.Case_ID as varchar) = CAST(c.Case_ID as varchar)
				) as sub
				pivot (
					count(Day) for day in ([Day3], [D3], [D7], [Day7], [Day14], [W2], [W3], [W4], [W5], [W6], [W7],[W8])
				) as p
				$where order by DateCase";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getDetail()
	{
		//$patienCode = $this->input->post('patientCode');
		$day = $this->input->post('day');
		$caseID = $this->input->post('caseID');

		$d = '';
		if ($day == 'Day3') $d = 'D3';
		if ($day == 'Day7') $d = 'D7';

		$sql = "select * from tblVMWFollowUp where Day in ('{$day}', '{$d}') and Case_ID = '{$caseID}'";
		$rs = $this->db->query($sql)->row();

		$data['followup'] = $rs;
		$data['patient'] = $this->getPatient($caseID);

		$this->output->set_output(json_encode($data));
	}

	private function getPatient($caseID)
	{
		$sql = "with T as
				(
					select concat('HC_', Rec_ID) as Case_ID, PatientCode, NameK,Age, Sex, Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS as Code_Vill_T
					from tblHFActivityCases

					union all

					select concat('VMW_', Rec_ID) as Case_ID, PatientCode, NameK, Age, Sex, ID as Code_Vill_T
					from tblVMWActivityCases
				)

				select a.*, b.Name_Vill_K, Name_Facility_K, Name_OD_K from T as a
				join tblCensusVillage as b on b.Code_Vill_T = a.Code_Vill_T
				join tblHFCodes as c on c.Code_Facility_T = b.HCCode
				where a.Case_ID = '{$caseID}'";

		return $this->db->query($sql)->row();
	}

	public function save()
	{
		$value = json_decode($this->input->post('submit'), true);

		$id = $value['Rec_ID'];
		unset($value['Rec_ID']);
		$caseID = $value['Case_ID'];

		if ( empty( $id ) ) {
			$value['IsMobileEntry'] = 0;
			$value['InitUser'] = $_SESSION['username'];
			$value['InitTime'] = sqlNow();
			$this->db->insert('tblVMWFollowUp', $value);
			$id = $this->db->insert_id();
		} else {
			$value['ModiUser'] = $_SESSION['username'];
			$value['ModiTime'] = sqlNow();
			$where['Rec_ID'] = $id;
			$this->db->update('tblVMWFollowUp', $value, $where);
		}

		$rs = $this->getFollowup($caseID);

		$this->output->set_output(json_encode($rs));
	}

	public function delete()
	{
		$value = json_decode($this->input->post('submit'), true);

        $this->load->model('Log_model');
        $this->Log_model->deleteFollowup('tblVMWFollowup', $value['Rec_ID']);

		$this->db->delete('tblVMWFollowUp', ['Rec_ID' => $value['Rec_ID']]);

		$rs = $this->getFollowup($value['Case_ID']);

		$this->output->set_output(json_encode($rs));
	}

	private function getFollowup($caseID)
	{
		$sql = "WITH T as
				(
					select ID as Code_Facility_T, Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS as Code_Vill_T, PatientCode,
					NameK, DateCase, Diagnosis, PatientPhone, Year, Month, concat('HC_', Rec_ID) as Case_ID
					from tblHFActivityCases
					where Diagnosis in ('V', 'M') and Year = 2021
					and (G6PD = 'Normal' or Primaquine15 > 0 or Primaquine75 > 0)

					union all

					select HCCode as Code_Facility_T, ID as Code_Vill_T, PatientCode,
					NameK, DateCase, Diagnosis, PatientPhone, Year, Month, concat('VMW_', Rec_ID) as Case_ID
					from tblVMWActivityCases as a
					join tblCensusVillage as b on a.ID = b.Code_Vill_T
					where Diagnosis in ('V', 'M') and Year = 2021
					and ((G6PD = 'Normal' and PQTreatment = 'ASMQ + 14 days PQ') or Primaquine15 > 0 or Primaquine75 > 0)
				)

				select * from
				(
					select a.Code_Facility_T, a.Code_Vill_T, Code_OD_T, c.Code_Prov_N, a.PatientCode,
							NameK, a.DateCase, case when Diagnosis = 'V' then 'Pv' when Diagnosis = 'F' then 'Pf' else 'Mix' end as Diagnosis, PatientPhone, Year, Month, Day, a.Case_ID
					from T as a
					join tblVMWNotification as b on a.Case_ID = b.CodeCase
					join tblHFCodes as c on a.Code_Facility_T = c.Code_Facility_T
					left join tblVMWFollowUp as d on a.PatientCode = d.PatientCode or cast(a.Case_ID as varchar) = cast(d.Case_ID as varchar)
					where a.Case_ID = '{$caseID}'
				) as sub
				pivot (
					count(Day)
					for day in
					(
						[Day3], [Day7], [Day14]
					)
				) as p";
		return $this->db->query($sql)->row();
	}
}