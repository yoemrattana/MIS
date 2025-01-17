<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Users extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function auth_post()
	{
		$us = $this->post('Username');
		$ps = $this->post('Password');

		if ($us == null || $ps == null) {
			$msg = 'សូមប្រើឈ្មោះនិងលេខសម្ងាត់';
		} else {
			$row = $this->db->get_where('MIS_User', ['Us' => $us, 'Ps' => $ps])->row();

			if ($row != null) {
				$rs['Role'] = $row->Role;
				$rs['Code_Prov_T'] = $row->Code_Prov;
				$rs['Code_OD_T'] = $row->Code_OD;
				$rs['Code_Facility_T'] = '';

				$msg = 'ok';
			} else {
				$msg = 'ឈ្មោះនិងលេខសំងាត់មិនត្រឹមត្រូវ';
			}
		}

		$rs['message'] = $msg;
		$this->response($rs, $msg == 'ok' ? 200 : 404);
	}
}