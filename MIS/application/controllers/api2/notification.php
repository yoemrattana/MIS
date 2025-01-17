<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Notification extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	function get_token_post()
	{
		$sql = "select * from tblToken";
		$token = $this->db->query($sql)->result();
		$this->response(['tokens' => $token]);
	}

	function update_token_post()
    {
        $row = $this->post();
		$this->db->delete('tblToken', ['Imei' => $row['Imei']]);
        $this->db->insert('tblToken', $row);
        $this->response('success');
    }

	function patients_notification_vmw_post()
	{
		$code_village = $this->post('code_village');
		$year = $this->post('year');
		$month = $this->post('month');

		$sql = "select * from
				(
					select b.Year, b.Month, b.Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS as Code_Vill_T, c.Name_Vill_K, a.PatientCode, b.NameK, b.Sex, b.Age,
					a.DateCase, Day4, Day4Date, Day7, Day7Date, Day14, Day14Date from tblVMWNotification as a
					join tblHFActivityCases as b on 'HC_' + CONVERT(varchar, b.Rec_ID) = a.CodeCase
					join tblCensusVillage as c on c.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS = b.Code_Vill_t
					where G6PD = 'Normal'

					union all

					select b.Year, b.Month, b.ID as Code_Vill_T, c.Name_Vill_K, a.PatientCode, b.NameK, b.Sex, b.Age,
					a.DateCase, Day4, Day4Date, Day7, Day7Date, Day14, Day14Date from tblVMWNotification as a
					join tblVMWActivityCases as b on 'VMW_' + CONVERT(varchar, b.Rec_ID) = a.CodeCase
					join tblCensusVillage as c on c.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS = b.ID
					where G6PD = 'Normal' and PQTreatment = 'ASMQ + 14 days PQ'
				) as a
				where a.Code_Vill_T = '{$code_village}' and Month = '{$month}' and Year = '{$year}'";

		$rs = $this->db->query($sql)->result();

		$this->response($rs);
	}

	public function get_list_get()
	{
		$imei = $this->get('imei');

		$sql = "select top 10 Rec_ID, Imei, Message, InitTime from tblNotificationLog where Imei = '{$imei}' and Type = 'case_vmw' order by Rec_ID desc";

		$rs = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}
}