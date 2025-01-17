<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class HFFollowup extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function update_post()
	{
		$q = $this->post('followup');

		$where['PatientCode'] = $q['PatientCode'];
		$where['Day'] = $q['Day'];
		$where['Case_ID'] = str_replace('HC_', '', $q['Case_ID']);

		if ($q['Day'] == 'D3') $q['Day'] = 'Day3';
		if ($q['Day'] == 'D7') $q['Day'] = 'Day7';

		$q['IsMobileEntry'] = 1;
		$q['InitTime'] = sqlNow();

		$this->db->delete('tblHFFollowup', $where);
		$this->db->insert('tblHFFollowup', $q);

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);
	}

	public function list_get()
	{
		$year = $this->get('year');
	    $month = $this->get('month');
	    $hf = $this->get('hc_code');
		$patientCode = $this->get('patient_code');

		$data = $this->db->query("SP_API_FollowUp '$hf', '$year', '$month', '$patientCode'")->result_array();

		array_walk($data, function (&$a, $k) {
			unset($a['Rec_ID']);
		});

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
	}

	public function detail_get()
	{
		$patienCode = $this->get('patient_code');
		$day = $this->get('day');
		$caseID = $this->get('case_id');

		$sql = "select * from tblHFFollowup where PatientCode = '{$patienCode}' and Day = '{$day}' and Case_ID = '{$caseID}'";
		$rs = $this->db->query($sql)->row_array();

		$arr = $this->db->field_data('tblHFFollowup');
		$model = [];
		foreach ($arr as $v) {
			$model[$v->name] = $v->type == 'nvarchar' ? '' : null;
		}

		unset($model['Rec_ID']);

		$rs = empty($rs) ? $model : $rs;

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function search_get()
	{
		$patientCode = $this->get('patient_code');

		$data = $this->db->query("SP_API_FollowUp '', '', '', '$patientCode'")->result_array();

		array_walk($data, function (&$a, $k) {
			unset($a['Rec_ID']);
		});

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
	}

}