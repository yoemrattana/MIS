<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Followup extends REST_Controller
{
	function update_question_post()
	{
		$q = $this->post();

		$where['PatientCode'] = $q['PatientCode'];
		$where['Day'] = $q['Day'];

		$this->db->delete('tblFollowUp', $where);
		$this->db->insert('tblFollowUp', $q);

		$this->response('Success');
	}

	function get_followup_post()
	{
		$codePlace = $this->post('CodePlace');

		$sql = " select PatientCode, Day4Date, Day8Date, Day15Date, sum(iif(Day is null, 0 ,1)) as FollowedUp from
				 (
					select a.PatientCode, Day4Date, Day8Date, Day15Date, b.Day from tblNotification as a
					left join tblFollowUp as b on b.PatientCode = a.PatientCode
					where a.CodePlace = '{$codePlace}'
				 ) as s
				 group by PatientCode, Day4Date, Day8Date, Day15Date";

		$rs = $this->db->query($sql)->result();

		$this->response($rs);
	}

	function get_by_hf_post()
	{
		$code_hc = $this->post('code_hc');

		$sql = "select * from
		(
			select Code_Facility_T, b.Code_Vill_t as Code_Vill_T,  a.PatientCode,
			NameK, a.DateCase, Diagnosis, PatientPhone, Year, Month, e.Day from tblNotification as a
			join tblHFActivityCases as b on b.PatientCode = a.PatientCode
			join tblCensusVillage as c on c.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS = b.Code_Vill_t
			join tblHFCodes as d on d.Code_Facility_T = b.ID
			left join tblFollowUp as e on e.PatientCode = a.PatientCode
		) as sub
		pivot (
			count(Day)
			for day in
			(
				[Day4], [Day8], [Day15]
			)
		) as p
		where Code_Facility_T = '{$code_hc}'";

		$rs = $this->db->query($sql)->result();

		$this->response($rs);
	}

	function get_by_vmw_post()
	{
		$code_village = $this->post('code_village');

		$sql = "select * from
		(
			select Code_Facility_T, b.Code_Vill_t as Code_Vill_T, a.PatientCode,
			NameK, a.DateCase, Diagnosis, PatientPhone, Year, Month, e.Day from tblNotification as a
			join tblHFActivityCases as b on b.PatientCode = a.PatientCode
			join tblCensusVillage as c on c.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS = b.Code_Vill_t
			join tblHFCodes as d on d.Code_Facility_T = b.ID
			left join tblFollowUp as e on e.PatientCode = a.PatientCode
		) as sub
		pivot (
			count(Day)
			for day in
			(
				[Day4], [Day8], [Day15]
			)
		) as p
		where Code_Vill_T = '{$code_village}'";

		$rs = $this->db->query($sql)->result();

		$this->response($rs);
	}

	function get_detail_post()
	{
		$patienCode = $this->post('patient_code');
		$day = $this->post('day');

		$sql = "select * from tblFollowUp where PatientCode = '{$patienCode}' and Day = '{$day}'";
		$rs = $this->db->query($sql)->row_array();

		$arr = $this->db->field_data('tblFollowUp');
		$model = [];
		foreach ($arr as $v) {
			$model[$v->name] = $v->type == 'nvarchar' ? '' : null;
		}

		unset($model['Rec_ID']);

		$rs = empty($rs) ? $model : $rs;

		$this->response(['detail' => $rs]);
	}
}