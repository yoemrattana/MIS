<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class HCFollowup extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function update_post()
	{
		$data = $this->post('followup');
		$where['Rec_ID'] = $data['Rec_ID'];
		unset($data['Rec_ID']);

		if(empty($where['Rec_ID'])){
			$this->db->insert('tblHCFollowup', $data);
		}else{
			$this->db->update('tblHCFollowup', $data, $where);
		}

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

		$data = $this->db->query("SP_API_G6PDInv '$hf', $year, $month")->result_array();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
	}

	public function fs()
	{
		
	}
}