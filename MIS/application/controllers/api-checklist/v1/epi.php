<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Epi extends REST_Controller
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

		$sql = "select a.*, Code_Prov_N as Code_Prov_T, Code_OD_T
				from tblChecklistEpi as a
				join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
				where ('$pvcode' = '' or Code_Prov_N = '$pvcode')
				and ('$odcode' = '' or Code_OD_T = '$odcode')
				and ('$hccode' = '' or a.Code_Facility_T = '$hccode')";
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

		$sql = "select a.*, Code_Prov_N as Code_Prov_T, Code_OD_T
				from tblChecklistEpi as a
				join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
				where a.Rec_ID = $id";
		$rs = $this->db->query($sql)->row();

		if ($rs != null) {
			unset($rs->InitUser, $rs->InitTime, $rs->ModiUser, $rs->ModiTime);

			$rs->Participants = json_decode($rs->Participants);

			$sql = "select a.Question, Answer, Score
				from tblChecklistEpiDetail as a
				join tblChecklistQuestion as b on a.Question = b.Question
				where Category = 'Epi' and ParentId = $id
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
		unset($main['Code_OD_T']);
		unset($main['Detail']);
		if (isset($main['Quarter'])) unset($main['Quarter']);

		$sql = "select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'tblChecklistEpi' and DATA_TYPE = 'nvarchar'";
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
		    $this->db->insert('tblChecklistEpi', $main);
		    $insert = $id = toInt($this->db->insert_id());
		} else {
		    $main['ModiUser'] = 'Tablet';
		    $main['ModiTime'] = sqlNow();
		    $this->db->update('tblChecklistEpi', $main, ['Rec_ID' => $id]);
		    $this->db->delete('tblChecklistEpiDetail', ['ParentId' => $id]);
		}

		foreach ($detail as $k => $v)
		{
		    $value = [
		        'ParentId' => $id,
		        'Question' => $k,
		        'Answer' => json_encode($v['Answer'], JSON_UNESCAPED_UNICODE),
		        'Score' => $v['Score']
		    ];
		    $this->db->insert('tblChecklistEpiDetail', $value);
		}

		if ($insert > 0) $this->response(['Rec_ID' => $id]);
	}
}