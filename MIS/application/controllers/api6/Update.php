<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Update extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();

		$this->load->model('MPlace');
	}

	public function place_get()
    {
		$response = [
			"code" => 200,
			"message" => "success",
			"data" => [
				'provinces' => $this->db->select('Code_Prov_T, Name_Prov_E, Name_Prov_K')->get('tblProvince')->result(),
                'districts' => $this->db->select('tblCensusVillage.Code_Prov_T,tblDistrict.Code_Dist_T,Name_Dist_E, Name_Dist_K ')->join('tblCensusVillage', 'tblCensusVillage.Code_Dist_T = tblDistrict.Code_Dist_T')->get('tblDistrict')->result(),
                'communes' => $this->db->select('tblCensusVillage.Code_Dist_T, tblCommune.Code_Comm_T,Name_Comm_E,Name_Comm_K')->join('tblCensusVillage', 'tblCensusVillage.Code_Comm_T = tblCommune.Code_Comm_T')->get('tblCommune')->result(),
                'villages' => $this->db->select('Code_Prov_T, Code_Dist_T,Code_Comm_T,Code_Vill_T,Name_Vill_E,Name_Vill_K,HCCode,HaveVMW')->get('tblCensusVillage')->result(),
                'ods' => $this->db->select('Code_Prov_T,Code_OD_T,Name_OD_E,Name_OD_K')->get('tblOD')->result(),
                'hfs' => $this->db->select('Code_Prov_N as Code_Prov_T,Code_OD_T,Code_Facility_T,Name_Facility_E,Name_Facility_K')->get('tblHFCodes')->result(),
			]
		];

		$this->response($response);
    }

}