<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Users extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
		$this->load->model('MTelegram');
	}

	public function auth_post()
	{
        $code = $this->post('HC_Code');

        if ($code != '') {
			$imei = $this->post('Imei');
			$appVersion = $this->post('QA_App_Version');
			$table = 'tblHFDevice';

			$sql = "select Code_Facility_T as Code, Active from $table where Imei = '$imei'";
			$row = $this->db->query($sql)->row();
			if ($row == null) {
				$sql = "select count(*) as count from tblHFCodes where Code_Facility_T = '$code'";
				$count = $this->db->query($sql)->row('count');
				if ($count == 0) {
					$msg = 'លេខកូដមិនត្រឹមត្រូវ';
				} else {
					$value['Code_Facility_T'] = $code;
					$value['Imei'] = $imei;
					$value['QAAppVersion'] = $appVersion;
					$value['UpdatedOn'] = sqlNow();
					$this->db->insert($table, $value);
					$RecID = $this->db->insert_id();

					$this->MTelegram->sendDeviceRequest($table, $code, $appVersion, $RecID);

					$msg = 'ដើម្បីដំណើរការកម្មវិធីនេះ សូមទាក់ទងទៅ CNM តាមលេខទូរស័ព្ទ 010 88 33 88';
				}
			} else {
				if ($row->Code == $code) {
					if ($row->Active === null) $msg = 'ដើម្បីដំណើរការកម្មវិធីនេះ សូមទាក់ទងទៅ CNM តាមលេខទូរស័ព្ទ 010 88 33 88';
					elseif ($row->Active === 0) $msg = 'កម្មវិធីអ្នកត្រូវបានផ្អាក សូមទាក់ទងទៅ CNM តាមលេខទូរស័ព្ទ 010 88 33 88';
					else {
						$value['QAAppVersion'] = $appVersion;
						$value['UpdatedOn'] = sqlNow();
						$where['Imei'] = $imei;
						$this->db->update($table, $value, $where);
						$msg = 'ok';

						$sql = "select Code_Prov_T, Name_Prov_E, Name_Prov_K
									  ,Code_OD_T, Name_OD_E, Name_OD_K
									  ,Code_Facility_T, Name_Facility_E, Name_Facility_K
								from tblHFCodes as a
								join tblProvince as b on a.Code_Prov_N = b.Code_Prov_T
								where Code_Facility_T = '$code'";
						$row = $this->db->query($sql)->row();

						$rs['Role'] = 'HC';
						$rs['Code_Prov_T'] = $row->Code_Prov_T;
						$rs['Name_Prov_E'] = $row->Name_Prov_E;
						$rs['Name_Prov_K'] = $row->Name_Prov_K;
						$rs['Code_OD_T'] = $row->Code_OD_T;
						$rs['Name_OD_E'] = $row->Name_OD_E;
						$rs['Name_OD_K'] = $row->Name_OD_K;
						$rs['Code_Facility_T'] = $code;
						$rs['Name_Facility_E'] = $row->Name_Facility_E;
						$rs['Name_Facility_K'] = $row->Name_Facility_K;
					}
				} else {
					$value['Code_Facility_T'] = $code;
					$value['QAAppVersion'] = $appVersion;
					$value['Active'] = null;
					$value['CreatedOn'] = sqlNow();
					$value['UpdatedOn'] = sqlNow();
					$where['Imei'] = $imei;
					$this->db->update($table, $value, $where);

					$this->MTelegram->sendDeviceRequest($table, $code, $appVersion, $row->Rec_ID);
					$msg = 'ដើម្បីដំណើរការកម្មវិធីនេះ សូមទាក់ទងទៅ CNM តាមលេខទូរស័ព្ទ 010 88 33 88';
				}
			}
		} else {
			$where = [
				'Us' => $this->post('Username'),
				'Ps' => $this->post('Password')
			];

			$row = $this->db->get_where('MIS_User', $where)->row();

			if ($row != null) {
				$rs['Role'] = in_array($row->Role, ['AU', 'VMW']) ? 'CNM' : $row->Role;
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