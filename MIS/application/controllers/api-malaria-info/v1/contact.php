<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Contact extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput('api_input_cmi.txt');
	}

	public function cnm_units_get()
	{
		$sql = "select Rec_ID , Name from tblCNMUnit";
		$rs = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function list_post()
	{
		$type = $this->post('type');
		$HCCode = $this->post('hc_code');
		$prov_code = $this->post('prov_code');
		$partner = $this->post('partner');
		$unit = $this->post('unit');
		$user = $this->post('user');

		$role =  $this->getRole($user);

		$where = " ";
		if(!empty($HCCode)) $where = " and c.Code_Facility_T = '{$HCCode}'";

		$whereProv = " ";
		if(!empty($prov_code)) $whereProv = " and PlaceCode = '{$prov_code}'";

		$wherePartner = " ";
		if(!empty($partner)) $wherePartner = " and Partner = '{$partner}'";

		$whereUnit = " ";
		if(!empty($unit)) $whereUnit = " and Unit = '{$unit}'";

		$sql = "";

		if ($type == 'CNM') {

			$sql = "select Rec_ID, a.Name, Phone, Email, Position, UnitName
			        from (
			            select a.*, b.Name as UnitName
			                  ,iif(b.Name = 'Leader',1,2) as SortUnit
			                  ,iif(Position = 'Director',1,iif(Position = 'Vice Director',2,3)) as SortPosition
			            from tblContact as a
			            join tblCNMUnit as b on a.Unit = b.Rec_ID
			            where Type = '$type' {$whereUnit}
			        ) as a
			        order by SortUnit, UnitName, SortPosition, Rec_ID";
		}
		elseif ($type == 'Partner') {
		    $sql = "select Rec_ID,Name,Phone,Email,Position,Partner from tblContact where Type = '$type' {$wherePartner} order by Name";
		}
		elseif ($type == 'PHD') {
		    $sql = "select a.Rec_ID,Name,Phone,Email,Position,Code_Prov_T,Name_Prov_E,Name_Prov_K
					from tblContact as a
					join tblProvince as b on a.PlaceCode = b.Code_Prov_T
					where Type = '$type' {$whereProv} order by Name";
		}
		elseif ($type == 'OD') {
		    $sql = "select distinct a.Rec_ID,Name,Phone,Email,Position,Code_Prov_T,Name_Prov_E,Name_Prov_K,Code_OD_T,Name_OD_E,Name_OD_K
					from tblContact as a
					join tblHFCodes as b on a.PlaceCode = b.Code_OD_T
					join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
					where Type = '$type' order by Name";
		}
		elseif ($type == 'HC') {
		    $sql = "select a.Rec_ID,Name,Phone,Code_Prov_T,Name_Prov_E,Name_Prov_K,Code_OD_T,Name_OD_E,Name_OD_K,Code_Facility_T,Name_Facility_E,Name_Facility_K
					from tblContact as a
					join tblHFCodes as b on a.PlaceCode = b.Code_Facility_T
					join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
					where Type = '$type' order by Name";
		}
		elseif ($type == 'VMW') {
		    $sql = "select a.Rec_ID,Name,Phone,d.Code_Prov_T,Name_Prov_E,Name_Prov_K,Code_OD_T,Name_OD_E,Name_OD_K,Code_Facility_T,Name_Facility_E,Name_Facility_K,b.Code_Vill_T,Name_Vill_E,Name_Vill_K
					from tblContact as a
					join tblCensusVillage as b on a.PlaceCode = b.Code_Vill_T
					join tblHFCodes as c on b.HCCode = c.Code_Facility_T
					join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
					where Type = '$type' {$where} order by Name";
		}else{
			$sql = "select * from tblContact where 1=0";
		}

		$rs = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function insert_post()
    {
		$value = $this->post();
		if (!isset($value['Name']) || $value['Name'] == null) $value['Name'] = '';
		if (!isset($value['Phone']) || $value['Phone'] == null) $value['Phone'] = '';
		if (!isset($value['Email']) || $value['Email'] == null) $value['Email'] = '';
		if (!isset($value['Position']) || $value['Position'] == null) $value['Position'] = '';
		if (!isset($value['PlaceCode']) || $value['PlaceCode'] == null) $value['PlaceCode'] = '';
		if (!isset($value['Partner']) || $value['Partner'] == null) $value['Partner'] = '';
		$value['ModiUser'] = 'api';
		$value['ModiTime'] = sqlNow();

		unset($value['Rec_ID']);

		$this->db->insert('tblContact', $value);
    }

	public function update_post()
    {
		$value = $this->post();
		if (isset($value['Name']) && $value['Name'] == null) $value['Name'] = '';
		if (isset($value['Phone']) && $value['Phone'] == null) $value['Phone'] = '';
		if (isset($value['Email']) && $value['Email'] == null) $value['Email'] = '';
		if (isset($value['Position']) && $value['Position'] == null) $value['Position'] = '';
		if (isset($value['PlaceCode']) && $value['PlaceCode'] == null) $value['PlaceCode'] = '';
		if (isset($value['Partner']) && $value['Partner'] == null) $value['Partner'] = '';
		$value['ModiUser'] = 'api';
		$value['ModiTime'] = sqlNow();

		$where['Rec_ID'] = $value['Rec_ID'];
		unset($value['Rec_ID']);

		$this->db->update('tblContact', $value, $where);
    }

	public function delete_post()
    {
		$where['Rec_ID'] = $this->post('Rec_ID');
		$this->db->delete('tblContact', $where);
    }

	private function getRole($user)
	{
		$sql = "select * from MIS_User where Us = '{$user}'";
		$query = $this->db->query($sql);
		$user = $query->row_array();

		return $user ? $user['Role'] : '';
	}
}