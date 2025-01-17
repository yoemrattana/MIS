<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class PvMap extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput('api_input_cmi.txt');
	}

	public function list_post()
	{
		$pv = $this->post('Code_Prov_T');
		$od = $this->post('Code_OD_T');
		$from = $this->post('from');
		$to = $this->post('to');

		$rs = $this->db->query("SP_PvMap '$pv','$od','$from','$to'")->result();

		foreach ($rs as $r)
		{
			$r->Day3 = $r->Primaquine == 0 ? 100 : round($r->Day3 * 100 / $r->Primaquine);
			$r->Day7 = $r->Primaquine == 0 ? 100 : round($r->Day7 * 100 / $r->Primaquine);
			$r->Day14 = $r->Primaquine == 0 ? 100 : round($r->Day14 * 100 / $r->Primaquine);
			$r->Primaquine = $r->G6PD == 0 ? 100 : round($r->Primaquine * 100 / $r->G6PD);
		}

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];
		$this->response($response);
	}

	public function detail_post()
	{
		$hc = $this->post('Code_Facility_T');
		$from = $this->post('from');
		$to = $this->post('to');

		$rs = $this->db->query("SP_PvMap_Detail '$hc','$from','$to'")->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];
		$this->response($response);
	}
}