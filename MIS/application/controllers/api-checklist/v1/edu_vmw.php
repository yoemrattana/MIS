<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Edu_VMW extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

    public function list_post()
    {
		$pvcode = $this->post('Code_Prov_T');
        $odcode = $this->post('Code_OD_T');
		$hccode = $this->post('Code_Facility_T');
		$vlcode = $this->post('Code_Vill_T');

		$sql = "select a.*, Code_Prov_N as Code_Prov_T, Code_OD_T, Code_Facility_T
				from tblChecklistEduVMW as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				where ('$pvcode' = '' or Code_Prov_N = '$pvcode')
				and ('$odcode' = '' or Code_OD_T = '$odcode')
				and ('$hccode' = '' or Code_Facility_T = '$hccode')
				and ('$vlcode' = '' or a.Code_Vill_T = '$vlcode')";
		$rs = $this->db->query($sql)->result();

		foreach ($rs as $r)
		{
			unset($r->InitUser, $r->InitTime, $r->ModiUser, $r->ModiTime);
			$r->Participants = json_decode($r->Participants);
		}

        $this->response($rs);
    }

    public function detail_post()
    {
		$id = $this->post('Rec_ID');

		$sql = "select a.*, Code_Prov_N as Code_Prov_T, Code_OD_T, Code_Facility_T
				from tblChecklistEduVMW as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				where a.Rec_ID = $id";
		$rs = $this->db->query($sql)->row();

		if ($rs != null) {
			unset($rs->InitUser, $rs->InitTime, $rs->ModiUser, $rs->ModiTime);
			$rs->Participants = json_decode($rs->Participants);

			$list = $this->db->get_where('tblChecklistEduVMWDetail', ['ParentId' => $id])->result();

			$rs->Detail = [];
			foreach ($list as $r)
			{
				$rs->Detail[$r->Question] = json_decode($r->Answer);
			}
		}

		$this->response($rs);
    }

	public function update_post()
	{
		$main = $this->post();
		$detail = $main['Detail'];

		if(!isset($detail['Problem'])) $detail['Problem'] = '';
		if(!isset($detail['Solution'])) $detail['Solution'] = '';

		unset($main['Code_Prov_T']);
		unset($main['Code_OD_T']);
		unset($main['Code_Facility_T']);
		unset($main['Detail']);

		$sql = "select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'tblChecklistEduVMW' and DATA_TYPE = 'nvarchar'";
		$nvarchars = array_column($this->db->query($sql)->result(), 'COLUMN_NAME');

		foreach ($main as $k => $v)
		{
			if ($k == 'Participants') $main[$k] = json_encode($v, JSON_UNESCAPED_UNICODE);
			if (in_array($k, $nvarchars) && $k != 'Participants') $main[$k] = $v;
		}

		$id = 0;
		if (isset($main['Rec_ID'])){
			$id = $main['Rec_ID'];
			unset($main['Rec_ID']);
		}
		$insert = 0;

		if ($id == 0) {
			$main['MissionNo'] = date('Y') .'-'. $main['MissionNo'];
			$main['InitUser'] = 'Tablet';
			$this->db->insert('tblChecklistEduVMW', $main);
		    $insert = $id = toInt($this->db->insert_id());
		} else {
			$main['ModiUser'] = 'Tablet';
			$main['ModiTime'] = sqlNow();
		    $this->db->update('tblChecklistEduVMW', $main, ['Rec_ID' => $id]);
			$this->db->delete('tblChecklistEduVMWDetail', ['ParentId' => $id]);
		}

		foreach ($detail as $k => $v)
		{
			if ( $k == 'Q1' ) {
				$v = (object) [
					'reason' => isset($v['reason']) ? $v['reason']:  '',
					'meeting' => isset($v['meeting']) ? $v['meeting']:  '',
				];
			}

			if ( $k == 'Q3' && empty($v) ) {
				$v = (object) [
					'female' => 0,
					'participant' => 0,
					'times' => 0,
				];
			}

			if ( $k == 'Q11' && empty($v) ) {
				$v = (object) [
					'transfer' => '',
					'virus' => ''
				];
			}

			$value = [
				'ParentId' => $id,
				'Question' => $k,
				'Answer' => json_encode($v, JSON_UNESCAPED_UNICODE)
			];
			$this->db->insert('tblChecklistEduVMWDetail', $value);
		}

		if ($insert > 0) $this->response(['Rec_ID' => $id]);
	}
}