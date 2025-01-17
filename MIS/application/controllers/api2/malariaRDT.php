<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class MalariaRDT extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	function malaria_rdt_post()
	{
		$data = $this->post();

		$where['post_id'] = $data['post_id'];

		$this->db->trans_start();

		if ($data['image'] != null) {
			$dir = FCPATH.'/media/MalariaRDT';
			if (!file_exists($dir)) mkdir($dir);
			$filename = $data['image_file_name'];
			file_put_contents($dir.'/'.$filename, base64_decode($data['image']));
			$data['image'] = $filename;
		}

		if(!is_numeric($data['test_start_time'])) {
			$this->errorMsg('Test Sart time must be numeric', 400);
		}

		if(!is_numeric($data['scan_time'])) {
			$this->errorMsg('Test Scan Time must be numeric', 400);
		}

		$this->db->delete('tblMalariaRDT', $where);
		$data['InitTime'] = sqlNow();
		//$d = array_flatten($data);
		$this->db->insert('tblMalariaRDT', $data);
		$this->db->trans_complete();
		if ($this->db->trans_status()) {
			$sql = "select post_id,patient_id,operator_name,test_start_time,scan_time,
				LOINC_code_test_id,LOINC_test_answer_list_code,LOINC_Answer_ID,rdt_type,
				image,image_file_name, device_id, app_version, probabilities,test_type,error
				from tblMalariaRDT where post_id = '{$data['post_id']}'";

			$rs = $this->db->query($sql)->row_array();

			$rs['test_results'] = [
				'LOINC_code_test_id' => $rs['LOINC_code_test_id'],
				'LOINC_test_answer_list_code' => $rs['LOINC_test_answer_list_code'],
				'LOINC_Answer_ID' => $rs['LOINC_Answer_ID'],
			];

			unset($rs['LOINC_code_test_id']);
			unset($rs['LOINC_test_answer_list_code']);
			unset($rs['LOINC_Answer_ID']);

			$rs['image'] = $_SERVER['SERVER_NAME'] . '/media/MalariaRDT/' . $rs['image'];
		    $response = [
		        "status" => "success",
		        "result" => $rs
		    ];
		    $this->response($response, 200);
		} else {
			$this->errorMsg('Cannot insert data', 400);
		}
	}

	private function errorMsg($msg, $errorCode)
	{
		$response = [
		    "status" => "false",
		    "message" => "Error! " . $msg
		];
		$this->response($response, $errorCode);
	}

	function get_find_rdt_get()
	{
		$sql = "select post_id,patient_id,operator_name,test_start_time,scan_time,
				LOINC_code_test_id,LOINC_test_answer_list_code,LOINC_Answer_ID,rdt_type,
				image,image_file_name, device_id, app_version, probabilities,test_type,error
				from tblMalariaRDT order by InitTime Desc";

		$rs = $this->db->query($sql)->result_array();

		for ($i = 0; $i < count($rs); $i++) {
			$result = [];
			foreach($rs[$i] as $k => $v){
				if ($k == 'LOINC_code_test_id' || $k == 'LOINC_test_answer_list_code' || $k == 'LOINC_Answer_ID') {
					$result[$k] = $v;
				}
			}
			$rs[$i]['image'] = $_SERVER['SERVER_NAME'] . '/media/MalariaRDT/' . $rs[$i]['image'];
			$rs[$i]['test_results'] = $result;
			unset($rs[$i]['LOINC_code_test_id']);
			unset($rs[$i]['LOINC_test_answer_list_code']);
			unset($rs[$i]['LOINC_Answer_ID']);
		}

		$response = [
			"status" => "success",
			"result" => $rs
		];

		$this->response($response);
	}
}