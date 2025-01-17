<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Bednet extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput('api_input_cmi.txt');
	}

	public function bednet_get()
	{
		$year = date('Y');
		$from = date('m');
		$to = date('m');

		$rs = $this->db->query("SP_Dashboard_OverviewNet $year, $from, $to,''")->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}
}