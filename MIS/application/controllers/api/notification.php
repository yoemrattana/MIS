<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Notification extends REST_Controller
{
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

		$sql = "select b.Code_Vill_t as Code_Vill_T, c.Name_Vill_K, a.PatientCode, NameK, Sex, Age, 
				a.DateCase, Day4, Day4Date, Day8, Day8Date, Day15, Day15Date from tblNotification as a
				join tblHFActivityCases as b on 'HC_' + CONVERT(varchar, b.Rec_ID) = a.CodeCase
				join tblCensusVillage as c on c.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS = b.Code_Vill_t
				where c.Code_Vill_T = '{$code_village}'";

		$rs = $this->db->query($sql)->result();

		$this->response($rs);
	}

}