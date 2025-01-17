<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class App extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

    public function version_get()
    {
		$path = FCPATH . '/media/MobileApp/info.json';
		$info = json_decode(file_get_contents($path));

		$rs['version'] = $info->version;
		$rs['url'] = 'http://mis.cnm.gov.kh/media/MobileApp/cnm_app.apk';

        $this->response($rs);
    }

	public function usage_post()
    {
		$value['MalariaAppVersion'] = $this->post('Malaria_Version');
		$value['MalariaAppUsage'] = $this->post('Malaria_Usage');
		$value['OtherAppUsage'] = $this->post('Other_Usage');
		$value['DateFrom'] = $this->post('Date_From');
		$value['DateTo'] = $this->post('Date_To');
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

			$value['Imei'] = $where['Imei'];
			unset($value['UpdatedOn']);
			$this->db->insert('tblDeviceUsage', $value);
        }

        $this->response(['updated_row' => 1]);
    }
}