<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Place extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

    public function all_post()
    {
        $sql = "select Code_Prov_T, Name_Prov_E, Name_Prov_K
                from tblProvince
                where IsTarget = 1";
		$rs['province'] = $this->db->query($sql)->result();

		$sql = "select distinct Code_Prov_N as Code_Prov_T, Code_OD_T, Name_OD_E, Name_OD_K
                from tblHFCodes
                where IsTarget = 1";
		$rs['od'] = $this->db->query($sql)->result();

		$sql = "select Code_OD_T, Code_Facility_T, Name_Facility_E, Name_Facility_K
                from tblHFCodes
                where IsTarget = 1 and Type_Facility <> 'RH'";
		$rs['hc'] = $this->db->query($sql)->result();

		$sql = "select Code_Facility_T, a.Code_Vill_T, Name_Vill_E, Name_Vill_K
                from tblCensusVillage as a
				join tblHFCodes as b on a.HCCode = b.Code_Facility_T
                where IsTarget = 1 and HaveVMW = 1";
		$rs['village'] = $this->db->query($sql)->result();

        $this->response($rs);
    }
}