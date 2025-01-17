<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Foci extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput('api_input_cmi.txt');
	}

	public function list_post()
	{
		$where['Us'] = $this->post('user');
		$prov = $this->db->get_where('MIS_User', $where)->row('Code_Prov');

		$rs = $this->db->query("SP_Dashboard_MapFoci null,null,null,'$prov'")->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function number_classification_get()
	{
		$rs = $this->db->query("SP_Dashboard_MapFoci null,null,null,''")->result();

		$data['Active'] = 0;
		$data['Residual'] = 0;
		$data['Cleared'] = 0;

		foreach ($rs as $r)
		{
			$data[$r->CurrentStatus] += 1;
		}

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => [$data]
		];
		$this->response($response);
	}
}