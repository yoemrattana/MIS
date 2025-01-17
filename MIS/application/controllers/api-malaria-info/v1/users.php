<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

/*
 * For App Cambodia Malaria Info
 * */

class Users extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput('api_input_cmi.txt');
	}

	public function auth_post()
	{
		$user_name = $this->post('user_name');
		$password = $this->post('password');

		$where = [
			'Us' => $user_name,
			'Ps' => $password
		];

		$this->db->select('Us, Role, Code_Prov, Code_OD, Code_RG, Activate, IsNotification');
		$this->db->where($where);
		$row = $this->db->get('MIS_User');

		if ($row->num_rows()){
			$this->response($row->row());
		}

		return $this->response(['error' => 'User not found'], 404);
	}

	function get_tokens_post()
	{
		$sql = "select * from tblMalariaInfoToken";
		$token = $this->db->query($sql)->result();
		$this->response(['tokens' => $token]);
	}

	function update_token_post()
    {
        $row = $this->post();
		$this->db->delete('tblMalariaInfoToken', ['Imei' => $row['Imei']]);
        $this->db->insert('tblMalariaInfoToken', $row);
        $this->response('success');
    }

	public function log_post()
	{
		$row = $this->post();
		$imei = $row['Imei'];

		if($this->isExist($imei)){
			$row['ModiTime'] = sqlNow();
			$this->db->update('tblDeviceMalInfo', $row, ['Imei' => $imei]);
		}else{
			$row['InitTime'] = sqlNow();
			$this->db->insert('tblDeviceMalInfo', $row);
		}

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);
	}

	public function isExist($imei)
	{
		$this->db->select('*');
		$this->db->where(['Imei' => $imei]);
		$row = $this->db->get('tblDeviceMalInfo');

		if ($row->num_rows()){
			return true;
		}
		return false;
	}

	public function rolelist_post()
	{
		$arr = $this->db->get('MIS_Role')->result();
		$rs['roles'] = array_column($arr, 'Role');

		$this->response($rs);
	}
}