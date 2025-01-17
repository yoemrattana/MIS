<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Places extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();

		$this->load->model('MPlace');
	}

	public function isModify_get()
	{
		$date = date("Y-m-d", strtotime($this->get('date')));

		$sql = "SELECT tblName, Action, Property, Created_at from tblPlaceLogs Where Created_at >= '$date'";
		$result = $this->db->query($sql)->result_array();
		$this->response($result);
	}

	public function provinces_get()
	{
		$provinces = $this->MPlace->getProvinces();
		$result = ['meta' => ['total_page' => 1],
				   'data' => $provinces];

		$this->response($result);
	}

	public function districts_get()
	{
		$page_index = ($this->get('page') ?: 1);
		$districts = $this->MPlace->getDistricts($page_index);
		$total_page = ceil($this->MPlace->countDistrict()/30);
		$result = ['meta' => ['total_page' => $total_page],
				   'data' => $districts];

		$this->response($result);
	}

	public function communes_get()
	{
		$page_index = ($this->get('page') ?: 1);
		$communes = $this->MPlace->getCommunes($page_index);
		$total_page = ceil($this->MPlace->countCommune()/30);
		$result = ['meta' => ['total_page' => $total_page],
				   'data' => $communes];

		$this->response($result);
	}

	public function villages_get()
	{
		$page_index = ($this->get('page') ?: 1);
		$villages = $this->MPlace->getVillages($page_index);
		$total_page = ceil($this->MPlace->countVillage()/30);
		$result = ['meta' => ['total_page' => $total_page],
				   'data' => $villages];

		$this->response($result, 200);
	}

	public function ods_get()
	{
		$page_index = ($this->get('page') ?: 1);
		$ods = $this->MPlace->getODs($page_index);
		$total_page = ceil($this->MPlace->countOD()/30);
		$result = ['meta' => ['total_page' => $total_page],
				   'data' => $ods];

		$this->response($result);
	}

	public function hcs_get()
	{
		$page_index = ($this->get('page') ?: 1);
		$hcs = $this->MPlace->getHCs($page_index);
		$total_page = ceil($this->MPlace->countHC()/30);
		$result = ['meta' => ['total_page' => $total_page],
				   'data' => $hcs];

		$this->response($result, 200);
	}

	public function vmw_by_hc_post()
	{
		$code = $this->post('hc_code');

		$sql = "select Code_Vill_T,Name_Vill_E,Name_Vill_K,0 Meeting
				from tblCensusVillage where HCCode = '$code' and HaveVMW = 1 union
				select Code_Vill_T,Name_Vill_E,Name_Vill_K,1 Meeting
				from tblCensusVillage where HCCode_Meeting = '$code' and HaveVMW = 1 and HCCode <> HCCode_Meeting
				order by Name_Vill_K";
		$rs = $this->db->query($sql)->result();
		$this->response($rs);
	}

    public function get_places_post()
    {
        $type = $this->post('type');

        $sql = "SP_API_Places '$type'";
        $rs = $this->db->query($sql)->result();

        $this->response($rs);
    }
}