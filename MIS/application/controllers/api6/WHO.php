<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class WHO extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
        ini_set('memory_limit', '-1');
		writeApiInput();
	}

    public function endemic_get()
    {
        $year = $this->get('year');
        $monthFrom = $this->get('month_from');
        $mothTo = $this->get('month_to');

        $from = $year .'-'. $monthFrom;
        $to = $year .'-'. $mothTo;

        $data = $this->db->query("SP_Export_DataForWHO '$from', '$to', '', '',0")->result_array();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
    }

    public function non_endemic_get()
    {
        $year = $this->get('year');
        $monthFrom = $this->get('month_from');
        $mothTo = $this->get('month_to');

        $from = $year .'-'. $monthFrom;
        $to = $year .'-'. $mothTo;

        $data = $this->db->query("SP_Export_DataForWHONonEndemic '$from', '$to', '', '',0")->result_array();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
    }
}