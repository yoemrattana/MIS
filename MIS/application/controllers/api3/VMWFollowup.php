<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class VMWFollowup extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('MPatient');

		writeApiInput();
	}

	function update_post()
	{
		$q = $this->post('followup');

		$q['IsMobileEntry'] = 1;
		$q['InitTime'] = sqlNow();

		if ($q['Day'] == 'D3') $q['Day'] = 'Day3';
		if ($q['Day'] == 'D7') $q['Day'] = 'Day7';
		if ($q['Day'] == 'Week2') $q['Day'] = 'W2';
		if ($q['Day'] == 'Week3') $q['Day'] = 'W3';
		if ($q['Day'] == 'Week4') $q['Day'] = 'W4';
		if ($q['Day'] == 'Week5') $q['Day'] = 'W5';
		if ($q['Day'] == 'Week6') $q['Day'] = 'W6';
		if ($q['Day'] == 'Week7') $q['Day'] = 'W7';
		if ($q['Day'] == 'Week8') $q['Day'] = 'W8';

		$where['PatientCode'] = $q['PatientCode'];
		$where['Day'] = $q['Day'];
		[$prefix, $rec_id] = explode('_', $q['Case_ID']);
		$where['Case_ID'] = $rec_id;
		$p = $this->MPatient->search($where['Case_ID'], $where['PatientCode']);

		$where['Case_ID'] = $p['Case_ID'];
		$q['Case_ID'] = $p['Case_ID'];

		$this->db->delete('tblVMWFollowUp', $where);
		$this->db->insert('tblVMWFollowUp', $q);

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);
	}

	function list_get()
	{
		$code_village = $this->get('code_village');
		$year = $this->get('year');
		$month = $this->get('month');

		$sql = "select * from
				(
					select b.Year, b.Month, b.Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS as Code_Vill_T, c.Name_Vill_K, a.PatientCode, b.NameK, b.Sex, b.Age,
					a.DateCase, Day3, Day3Date, Day7, Day7Date, Day14, Day14Date, a.CodeCase as Case_ID from tblVMWNotification as a
					join tblHFActivityCases as b on 'HC_' + CONVERT(varchar, b.Rec_ID) = a.CodeCase
					join tblCensusVillage as c on c.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS = b.Code_Vill_t
					where Primaquine15 > 0 or Primaquine75 > 0

					union all

					select b.Year, b.Month, b.ID as Code_Vill_T, c.Name_Vill_K, a.PatientCode, b.NameK, b.Sex, b.Age,
					a.DateCase, Day3, Day3Date, Day7, Day7Date, Day14, Day14Date, a.CodeCase as Case_ID from tblVMWNotification as a
					join tblVMWActivityCases as b on 'VMW_' + CONVERT(varchar, b.Rec_ID) = a.CodeCase
					join tblCensusVillage as c on c.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS = b.ID
					where Primaquine15 > 0 or Primaquine75 > 0
				) as a
				where a.Code_Vill_T = '{$code_village}' and Month = '{$month}' and Year = '{$year}'";

		$rs = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	function detail_get()
	{
		$patienCode = $this->get('patient_code');
		$day = $this->get('day');
		if ($day == 'D3') $day = 'Day3';
		if ($day == 'D7') $day = 'Day7';

		$caseID = $this->get('case_id');

		$sql = "select * from tblVMWFollowUp where PatientCode = '{$patienCode}' and Day = '{$day}' and Case_ID = '{$caseID}'";
		$rs = $this->db->query($sql)->row_array();

		unset($rs['PrimaquineDose']);
		unset($rs['VeryDarkUrine']);
		unset($rs['VeryFastHeartBeat']);

		$arr = $this->db->field_data('tblVMWFollowUp');
		$model = [];
		foreach ($arr as $v) {
			$model[$v->name] = $v->type == 'nvarchar' ? '' : null;
		}

		unset($model['Rec_ID']);
		unset($model['PrimaquineDose']);
		unset($model['VeryDarkUrine']);
		unset($model['VeryFastHeartBeat']);

		$rs = empty($rs) ? $model : $rs;

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}
}