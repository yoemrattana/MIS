<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class OD extends REST_Controller
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

		$sql = "select distinct a.*, Code_Prov_N as Code_Prov_T
				from tblChecklistOD as a
				join tblHFCodes as b on a.Code_OD_T = b.Code_OD_T
				where ('$pvcode' = '' or Code_Prov_N = '$pvcode')
				and ('$odcode' = '' or a.Code_OD_T = '$odcode')";
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

		$sql = "select distinct a.*, Code_Prov_N as Code_Prov_T
				from tblChecklistOD as a
				join tblHFCodes as b on a.Code_OD_T = b.Code_OD_T
				where a.Rec_ID = $id";
		$rs = $this->db->query($sql)->row();

		if ($rs != null) {
			unset($rs->InitUser, $rs->InitTime, $rs->ModiUser, $rs->ModiTime);
			$rs->Participants = json_decode($rs->Participants);

			$sql = "select a.Question, Answer, Score
				from tblChecklistODDetail as a
				join tblChecklistQuestion as b on a.Question = b.Question
				where Category = 'OD' and ParentId = $id
				order by Sort";
			$list = $this->db->query($sql)->result();

			$rs->Detail = [];
			foreach ($list as $r)
			{
				$rs->Detail[$r->Question] = [
					'Answer' => json_decode($r->Answer),
					'Score' => $r->Score
				];
			}
		}

		$this->response($rs);
    }

	public function update_post()
	{
		$main = $this->post();
		$detail = $main['Detail'];

		unset($main['Code_Prov_T']);
		unset($main['Detail']);
		if (isset($main['Quarter'])) unset($main['Quarter']);

		$sql = "select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'tblChecklistOD' and DATA_TYPE = 'nvarchar'";
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
			$this->db->insert('tblChecklistOD', $main);
		    $insert = $id = toInt($this->db->insert_id());
		} else {
			$main['ModiUser'] = 'Tablet';
			$main['ModiTime'] = sqlNow();
		    $this->db->update('tblChecklistOD', $main, ['Rec_ID' => $id]);
			$this->db->delete('tblChecklistODDetail', ['ParentId' => $id]);
		}

		foreach ($detail as $k => $v)
		{
			$value = [
				'ParentId' => $id,
				'Question' => $k,
				'Answer' => json_encode($v['Answer'], JSON_UNESCAPED_UNICODE),
				'Score' => $v['Score']
			];
			$this->db->insert('tblChecklistODDetail', $value);
		}

		if ($insert > 0) $this->response(['Rec_ID' => $id]);
	}

	public function misdata_post()
	{
		$od = $this->post('Code_OD_T');
		$from = $this->post('CheckFrom');
		$to = $this->post('CheckTo');

		$rs = $this->db->query("SP_Checklist_OD '$od','$from','$to'")->row();

		$this->response($rs);
	}
}