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

    public function mobile_auth_post()
    {
        $place_code = $this->post('place_code');
		$imei = $this->post('Imei');

        $hc = $this->mobile_auth($place_code, $imei);
        if ($hc) {
			$value['Model'] = $this->post('Model_Name');
			if ($value['Model'] != null) {
				$table = strlen($place_code) == 6 ? 'tblHFDevice' : 'tblVMWDevice';
				$this->db->update($table, $value, ['Imei' => $imei]);
			}
			$this->response($hc);
		} else {
			$this->response(['error' => 'User not found'], 404);
		}
    }

	private function mobile_auth($place_code, $imei)
	{
		$sql = "SELECT tblProvince.Name_Prov_K,
				tblOD.Name_OD_K,
				tblOD.Is_Enable_VMW_Report,
				tblOD.Is_Enable_Investigation_Report, tblOD.Is_Enable_Reactive_Report,
				tblOD.Is_Enable_SMS_Alert, tblOD.Is_Enable_Stock, tblOD.Is_Radical_Cure,
				tblOD.Is_Radical_Cure_HSD,
				tblHFCodes.Name_Facility_K,
				tblHFCodes.Code_Facility_T,
                IsReminder,
                BedNetView, BedNetEdit, BedNetDelete,
                HCCaseDelete, HCCaseEdit,
                VMWCaseDelete, VMWCaseEdit,
                PopView, PopEdit
				FROM tblDevicePermission, tblHFCodes
				JOIN tblProvince ON tblProvince.Code_Prov_T = tblHFCodes.Code_Prov_N
				JOIN tblOD ON tblOD.Code_OD_T = tblHFCodes.Code_OD_T
				WHERE tblHFCodes.Code_Facility_T = '$place_code'";

		$query_from_hc = $this->db->query($sql);

		if ($query_from_hc->num_rows() > 0) {
			$data = $query_from_hc->row_array();

			$sql = "select isnull(NewPhone,Phone) as Phone from tblHFDevice where Imei = '$imei'";
			$phone = $this->db->query($sql)->row('Phone');

            $data['Is_Enable_Stock'] = 1;
            $data['User_Role'] = 'HC';
			$data['Phone'] = $phone;

			return $data;
		} else {
			$sql = "SELECT tblProvince.Name_Prov_K,
					tblDistrict.Name_Dist_K,
					tblCommune.Name_Comm_K,
					tblCensusVillage.Name_Vill_K,
					tblCensusVillage.Code_Vill_T,
					tblHFCodes.Name_Facility_K,
					tblOD.Is_Radical_Cure,
					tblOD.Is_Radical_Cure_HSD,
					tblHFCodes.IsReminder
					FROM tblCensusVillage
					JOIN tblProvince ON tblProvince.Code_Prov_T = tblCensusVillage.Code_Prov_T
					JOIN tblDistrict ON tblDistrict.Code_Dist_T = tblCensusVillage.Code_Dist_T
					JOIN tblCommune ON tblCommune.Code_Comm_T = tblCensusVillage.Code_Comm_T
					JOIN tblHFCodes ON tblCensusVillage.HCCode = tblHFCodes.Code_Facility_T
					JOIN tblOD ON tblOD.Code_OD_T = tblHFCodes.Code_OD_T
					WHERE tblCensusVillage.Code_Vill_T = '$place_code'";

			$query_from_vill = $this->db->query($sql);
			if ($query_from_vill->num_rows() > 0) {
				$data = $query_from_vill->row_array();

				$sql = "select isnull(NewPhone,Phone) as Phone from tblVMWDevice where Imei = '$imei'";
				$phone = $this->db->query($sql)->row('Phone');

                $data['User_Role'] = 'VMW';
                $data['Phone'] = $phone;

                return $data;
			}
		}

		return 0;
	}

    public function logout_post()
    {
        $code = $this->post('code');
		$sql = "select * from tblSetting where Name = 'LogoutCode' and Value = '$code'";
		$rs = $this->db->query($sql)->num_rows() > 0;
        if ($rs) $this->response(["logout" => true]);
        else $this->response(["logout" => false], 404);
    }

    public function location_post()
    {
        $value['Lat'] = $this->post('Lat');
        $value['Long'] = $this->post('Lon');
		$value['UpdatedOn'] = sqlNow();
		$where['Imei'] = $this->post('Imei');
		$code = $this->post('HC_Code');

		if (strlen($code) == 6) {
			$table = 'tblHFDevice';
		} else {
			$table = 'tblVMWDevice';
		}

        $count = $this->db->where($where)->count_all_results($table);
        if ($count > 0) {
			$this->db->update($table, $value, $where);
		}

		$this->response(['updated_row' => 1]);
    }

    public function phone_info_post()
    {
		$code = $this->post('HC_Code');
		$phone = str_replace('+855', '0', $this->post('Phone_Number'));

		$value['UpdatedOn'] = sqlNow();

		$model = $this->post('Model_Name');
		if ($model != null) $value['Model'] = $model;

		$where['Imei'] = $this->post('Imei');

        $sql = "";
		if (strlen($code) == 6) {
			$table = 'tblHFDevice';
            $sql = "select Name_Facility_E as Username from tblHFCodes where Code_Facility_T = '{$code}'";
		} else {
			$table = 'tblVMWDevice';
            $sql = "select Name_Vill_E as Username from tblCensusVillage where Code_Vill_T = '{$code}'";
            $code = substr($code, 0, 8);
		}

		$row = $this->db->select('Phone, AutoPhone')->get_where($table, $where)->row();

		if ($row != null) {
			if ($row->AutoPhone == 1 && $row->Phone != $phone) $value['Phone'] = $phone;
			$this->db->update($table, $value, $where);
		}

        $user = $this->db->query($sql)->row('Username');
        $phone = preg_replace('/^0/', '855', $phone);
        $params = [
            "Username" => $user,
	        "Password"=> '',
	        "Email" => "",
	        "Phone" => $phone,
	        "Place" => $code,
	        "Role"  => "Default",
	        "Status" => 1
        ];
        $this->createMD0user($params);

		$this->response(['updated_row' => 1]);
    }

    public function createMD0user($params)
    {
        $client = new GuzzleHttp\Client();
        $baseUrl = '';
        $url = "{$baseUrl}/api/v1/users/update_mdzero_user";

        $re = $client->post($url, [
            'headers' => ['Content-type' => 'application/json'],
            'auth' => ['user', 'Password'],
            'json' => $params,
        ]);
        return $re;
    }

	public function restrict_login_post()
    {
		$code = $this->post('HC_Code');
		$imei = $this->post('Imei');
		$logged = $this->post('Logged');
		$appVersion = $this->post('Malaria_Version');

		if (strlen($code) == 6) {
			$column = 'Code_Facility_T';
			$table = 'tblHFDevice';
		} else {
			$column = 'Code_Vill_T';
			$table = 'tblVMWDevice';
		}

		$sql = "select $column as Code, Active, Rec_ID from $table where Imei = '$imei'";
		$row = $this->db->query($sql)->row();
		if ($row == null) {
			$tbl = strlen($code) == 6 ? 'tblHFCodes' : 'tblCensusVillage';
			$sql = "select count(*) as count from $tbl where $column = '$code'";
			$count = $this->db->query($sql)->row('count');
			if ($count == 0) {
				$msg = 'លេខកូដមិនត្រឹមត្រូវ';
			} else {
				if (intval($logged) == 0) {
					$value[$column] = $code;
					$value['Imei'] = $imei;
					$value['MalariaAppVersion'] = $appVersion;
					$value['UpdatedOn'] = sqlNow();
					$this->db->insert($table, $value);
					$RecID = $this->db->insert_id();

					$this->MTelegram->sendDeviceRequest($table, $code, $appVersion, $RecID);
					$msg = 'ដើម្បីដំណើរការកម្មវិធីនេះ សូមទាក់ទងទៅ CNM តាមលេខទូរស័ព្ទ 010 88 33 88';
				} else {
					$msg = 'deleted';
				}
			}
		} else {
			if ($row->Code == $code) {
				if ($row->Active === null) $msg = 'ដើម្បីដំណើរការកម្មវិធីនេះ សូមទាក់ទងទៅ CNM តាមលេខទូរស័ព្ទ 010 88 33 88';
				elseif ($row->Active === 0) $msg = 'កម្មវិធីអ្នកត្រូវបានផ្អាក សូមទាក់ទងទៅ CNM តាមលេខទូរស័ព្ទ 010 88 33 88';
				else {
					$value['MalariaAppVersion'] = $appVersion;
					$where['Imei'] = $imei;
					$this->db->update($table, $value, $where);
					$msg = 'ok';
				}
			} else {
				$value[$column] = $code;
				$value['MalariaAppVersion'] = $appVersion;
				$value['Active'] = null;
				$value['CreatedOn'] = sqlNow();
				$value['UpdatedOn'] = sqlNow();
				$where['Imei'] = $imei;
				$this->db->update($table, $value, $where);

				$this->MTelegram->sendDeviceRequest($table, $code, $appVersion, $row->Rec_ID);
				$msg = 'ដើម្បីដំណើរការកម្មវិធីនេះ សូមទាក់ទងទៅ CNM តាមលេខទូរស័ព្ទ 010 88 33 88';
			}
		}

		$rs['message'] = $msg;
		$this->response($rs);
    }

	public function permission_post()
    {
		$code = $this->post('HC_Code');
		$where['Imei'] = $this->post('Imei');

		$select = 'ExpireEntry, AutoPhone';
		if (strlen($code) == 6) {
			$table = 'tblHFDevice';
			$select .= ', ExpireStock';
		} else {
			$table = 'tblVMWDevice';
		}

        $row = $this->db->select($select)->get_where($table, $where)->row();
		$rs['entry_expired_form'] = $row == null ? 0 : $row->ExpireEntry;
		$rs['entry_expired_stock'] = strlen($code) == 10 || $row == null ? 0 : $row->ExpireStock;
		$rs['send_phone'] = 1;

		$this->response($rs);
    }

    public function get_mdzero_user_post()
    {
        $sql = "select * from tblMDZeroUsers";
        $rs = $this->db->query($sql)->result();

        $this->response($rs);
    }

    public function update_mdzero_action_post()
    {
        $id = $this->post('id');

        $where = "ID = '{$id}' and Action <> 'Deleted'";
        $this->db->update('tblMDZeroUsers', ['Action'=> 'Normal'], $where);
        $this->response('Successful');
    }
}