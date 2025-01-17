<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class HF extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput('api_input_cmi.txt');
	}

	public function hf_worker_get()
	{
		$year = date('Y');

		$data = [];

		$sql = "select sum(Pop) PopAtRisk from V_PopByVillages as a
				join tblCensusVillage as b on b.Code_Vill_T = a.Code_Vill_T
				join tblHFCodes as c on Code_Facility_T = b.HCCode
				where IsTarget = 1 and Year = {$year}";

		$data[] = $this->db->query($sql)->row_array();

		$sql = "select count(*) Village from tblCensusVillage as a
				join tblHFCodes as b on b.Code_Facility_T = a.HCCode
				where IsTarget = 1 and (Name_Vill_E not like '%(M)%' or Name_Vill_K not like '%(M)%')";

		$data[] = $this->db->query($sql)->row_array();

		$sql = "select count(*) as MMW from tblCensusVillage as a
				join tblHFCodes as b on a.HCCode =  b.Code_Facility_T
				where HaveVMW = 1 and IsTarget = 1
				and (Name_Vill_E like '%(M)%')";

		$data[] = $this->db->query($sql)->row_array();

		$sql = "select count(*) as VMW from tblCensusVillage as a
				join tblHFCodes as b on a.HCCode =  b.Code_Facility_T
				where HaveVMW = 1 and IsTarget = 1
				and (Name_Vill_E not like '%(M)%' or Name_Vill_K not like '%(M)%')";

		$data[] = $this->db->query($sql)->row_array();

		$sql = "select Count(*) as HC from tblHFCodes where IsTarget = 1";

		$data[] = $this->db->query($sql)->row_array();

		$sql = "select Count(*) as OD from tblOD where IsTarget = 1";

		$data[] = $this->db->query($sql)->row_array();

		$sql = "select Count(*) as Province from tblProvince where IsTarget = 1";

		$data[] = $this->db->query($sql)->row_array();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
	}
}