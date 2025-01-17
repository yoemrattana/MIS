<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class ReactiveCase extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function list_get()
	{
		$hf =  $this->get('HC_Code');
		$month = $this->get('month');
		$year = $this->get('year');

		$rs = $this->db->query("SP_API_Reactive '$hf', $year, $month")->result_array();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function detail_get()
	{
		$id = $this->get('Passive_Case_Id');

		$sql = "select a.*, Code_Prov_N as Code_Prov_T, Code_OD_T, Code_Facility_T
				from tblReactive2 as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				where Passive_Case_Id = '$id'";
		$rs = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function update_post()
	{
		$list = $this->post('Reactive_Activity_Cases');

		if (count($list) > 0) {
			$where['Passive_Case_Id'] = $list[0]['Passive_Case_Id'];
			$this->db->delete('tblReactive2', $where);
		}

		$sql = "select COLUMN_NAME, DATA_TYPE from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'tblReactive2' and COLUMN_NAME not in ('Rec_ID','InitTime')";
		$arr = $this->db->query($sql)->result();

		$datatype = [];
		foreach ($arr as $v) $datatype[$v->COLUMN_NAME] = $v->DATA_TYPE;

		for ($i = 0; $i < count($list); $i ++)
		{
		    $row = $list[$i];
		    $r = [];
		    foreach ($row as $k => $v)
		    {
		        if (!isset($datatype[$k])) continue;
		        $r[$k] = $datatype[$k] == 'nvarchar' ? $row[$k] : $row[$k];
		    }
		    $this->db->insert('tblReactive2', $r);
		}

		$this->response(['inserted_row' => 1]);

		//$response = [
		//    "code" => 200,
		//    "message" => "success",
		//    "data" => []
		//];

		//$this->response($response);
	}

}