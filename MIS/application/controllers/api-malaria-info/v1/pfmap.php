<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class PfMap extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput('api_input_cmi.txt');
	}

	public function list_post()
	{
		$prov = $this->post('province');
		$year = $this->post('year');
		$mf = $this->post('month_from');
		$mt = $this->post('month_to');

		$rs = $this->db->query("SP_Dashboard_PFMap $year,$mf,$mt,'$prov'")->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];
		$this->response($response);
	}
}