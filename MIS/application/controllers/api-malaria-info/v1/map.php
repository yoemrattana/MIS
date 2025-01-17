<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Map extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput('api_input_cmi.txt');
	}

	public function village_hf_get()
	{
		$province = $this->get('code_province');
		$od = $this->get('code_od');
		$hf = $this->get('code_hf');

		$where = ' ';
		if (!empty($province)) $where .= " and Code_Prov_N = '{$province}'";
		if (!empty($od)) $where .= " and Code_OD_T = '{$od}'";
		if (!empty($hf)) $where .= " and Code_Facility_T = '{$hf}'";

		$sql = "select a.Code_Vill_T,
				a.Name_Vill_K,
				a.Name_Vill_E,
				b.Code_Facility_T,
				b.Name_Facility_K,
				b.Name_Facility_E,
				b.Code_OD_T,
				b.Name_OD_K,
				b.Name_OD_E,
				c.Code_Prov_T,
				c.Name_Prov_K,
				c.Name_Prov_E,
				a.Lat,
				a.Long,
				'Village' as Type
			from tblCensusVillage​​ as a
			join tblHFCodes as b on a.HCCode = b.Code_Facility_T
			join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
			where b.IsTarget = 1 and a.HaveVMW = 1 {$where} ";

		$sql .= "union all
				select '' as Code_Vill_T,
				'' as Name_Vill_K,
				'' as Name_Vill_E,
				a.Code_Facility_T,
				a.Name_Facility_K,
				a.Name_Facility_E,
				a.Code_OD_T,
				a.Name_OD_K,
				a.Name_OD_E,
				b.Code_Prov_T,
				b.Name_Prov_K,
				b.Name_Prov_E,
				a.Lat,
				a.Long,
				'HF' as Type
			from tblHFCodes as a
			join tblProvince as b on a.Code_Prov_N = b.Code_Prov_T
			where a.IsTarget = 1 {$where}";

		$data = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
	}
}