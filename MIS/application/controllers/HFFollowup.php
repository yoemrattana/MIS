<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HFFollowup extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['HF Followup Patient'])) redirect('Home');

		$data['title'] = "HF Follow up";
		$data['main'] = 'hffollowup_view';

		$this->load->view('layoutV3', $data);
	}

	public function getData()
	{
		$prov = $this->input->post('prov');
		$od = $this->input->post('od');
		$y = $this->input->post('y');

		$where = '';
		if (empty($od)) $where = " where Code_Prov_N = '{$prov}'";
		else $where = " where Code_OD_T = '{$od}'";

		$sql = "with cases as (
	            select ID as Code_Facility_T, a.Code_Vill_t as Code_Vill_T, PatientCode,
	            NameK, DateCase, Diagnosis, PatientPhone, Year, Month, Rec_ID as Case_ID, PrimaquineDate
	            from tblHFActivityCases as a
	            join tblCensusVillage as b on a.Code_Vill_t = b.Code_Vill_T and HaveVMW = 0
	            where Diagnosis in ('V', 'M', 'O') and Year = '{$y}' and (Primaquine15 > 0 or Primaquine75 > 0)

	            union all

	            select ID as Code_Facility_T, Code_Vill_t as Code_Vill_T, PatientCode,
	            NameK, DateCase, Diagnosis, PatientPhone, Year, Month, Rec_ID as Case_ID, PrimaquineDate
	            from tblHFActivityCases as a
	            where Diagnosis in ('V', 'M', 'O') and Year = '{$y}' and (Primaquine15 > 0 or Primaquine75 > 0)
	            and (ISNUMERIC(Code_Vill_t) = 0 or (ISNUMERIC(Code_Vill_t) = 1 and LEN(Code_Vill_t) < 10) )
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
            left join tblHFFollowup as c on CAST(a.Case_ID as varchar) = CAST(c.Case_ID as varchar)
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
		$caseId = $this->input->post('caseID');

		$d = '';
		if($day == 'Day3') $d = 'D3';
		if($day == 'Day7') $d = 'D7';


		$sql = "select * from tblHFFollowup where Day in ('{$day}' , '{$d}') and Case_ID = '{$caseId}'";
		$rs = $this->db->query($sql)->row();

		$data['followup'] = $rs;
		$data['patient'] = $this->getPatient($caseId);

		$this->output->set_output(json_encode($data));
	}

	private function getPatient($caseId)
	{
		$sql = "with T as
				(
					select Rec_ID, PatientCode, NameK,Age, Sex, Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS as Code_Vill_T
					from tblHFActivityCases
				)

				select a.*, b.Name_Vill_K, Name_Facility_K, Name_OD_K from T as a
				join tblCensusVillage as b on b.Code_Vill_T = a.Code_Vill_T
				join tblHFCodes as c on c.Code_Facility_T = b.HCCode
				where a.Rec_ID = '{$caseId}'";

		return $this->db->query($sql)->row();
	}

	public function save()
	{
		$value = json_decode($this->input->post('submit'), true);

		$id = $value['Rec_ID'];
		unset($value['Rec_ID']);
		$patientCode = $value['PatientCode'];
		$caseId = $value['Case_ID'];

		$value['TabletRemain'] = in_array($value['Day'], ['Day3', 'Day7']) ? null : $value['TabletRemain'];

		if (empty($id)) {
			$value['IsMobileEntry'] = 0;
			$value['InitUser'] = $_SESSION['username'];
			$value['InitTime'] = sqlNow();
			$this->db->insert('tblHFFollowUp', $value);
			$id = $this->db->insert_id();
		} else {
			$value['ModiUser'] = $_SESSION['username'];
			$value['ModiTime'] = sqlNow();
			$where['Rec_ID'] = $id;
			$this->db->update('tblHFFollowUp', $value, $where);
		}

		$rs = $this->getFollowup($caseId);
		$this->output->set_output(json_encode($rs));
	}

	public function delete()
	{
		$value = json_decode($this->input->post('submit'), true);
		$caseId = $value['followup']['Case_ID'];

        $this->load->model('Log_model');
        $this->Log_model->deleteFollowup('tblHFFollowup', $value['followup']['Rec_ID']);

		$this->db->delete('tblHFFollowup', ['Rec_ID' => $value['followup']['Rec_ID']]);

		$rs = $this->getFollowup($caseId);

		$this->output->set_output(json_encode($rs));
	}

	private function getFollowup($caseId)
	{
		$sql = "select * from
                (
	                select a.Code_Facility_T, a.Code_Vill_T, Code_OD_T, c.Code_Prov_N as Code_Prov_T, a.PatientCode,
	                NameK, a.DateCase, Diagnosis,
	                PatientPhone, Year, Month, Day, a.Case_ID
	                from
	                (
		                select ID as Code_Facility_T, Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS as Code_Vill_T, PatientCode, NameK, DateCase, Diagnosis, PatientPhone, Year, Month, Rec_ID as Case_ID
		                from tblHFActivityCases
		                where Diagnosis in ('V', 'M', 'O') and Rec_ID = '{$caseId}'
	                ) as a
	                join tblHFCodes as c on a.Code_Facility_T = c.Code_Facility_T
	                left join tblHFFollowUp as d on CAST(a.Case_ID as varchar) = CAST(d.Case_ID as varchar)
                ) as sub
                pivot (
	                count(Day)
	                for day in
	                (
		                [Day3], [Day7], [W2], [W3], [W4], [W5], [W6], [W7],[W8]
	                )
                ) as p
				";
		return $this->db->query($sql)->row();
	}
}