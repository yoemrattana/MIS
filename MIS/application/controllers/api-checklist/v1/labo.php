<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Labo extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

    public function list_post()
    {
		$pvcode = $this->post('Code_Prov_T');
		$dscode = $this->post('Code_Dist_T');

		$sql = "select *, left(Code_Dist_T,2) as Code_Prov_T
				from tblChecklistLabo
				where ('$pvcode' = '' or left(Code_Dist_T,2) = '$pvcode')
				and ('$dscode' = '' or Code_Dist_T = '$dscode')";
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

		$sql = "select *, left(Code_Dist_T,2) as Code_Prov_T
				from tblChecklistLabo
				where Rec_ID = $id";
		$rs = $this->db->query($sql)->row();

		if ($rs != null) {
			unset($rs->InitUser, $rs->InitTime, $rs->ModiUser, $rs->ModiTime);
			$rs->Participants = json_decode($rs->Participants);

			$list = $this->db->get_where('tblChecklistLaboDetail', ['ParentId' => $id])->result();

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
		if(!isset($detail['ProblemSolution'])) $detail['ProblemSolution'] = '';
		if(!isset($detail['Problem'])) $detail['Problem'] = '';
		if(!isset($detail['Solution'])) $detail['Solution'] = '';
		if(isset($main['HFEmail'])) unset($main['HFEmail']);
		unset($main['Code_Prov_T']);
		unset($main['Detail']);

		$sql = "select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'tblChecklistLabo' and DATA_TYPE = 'nvarchar'";
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
			$this->db->insert('tblChecklistLabo', $main);
		    $insert = $id = toInt($this->db->insert_id());
		} else {
			$main['ModiUser'] = 'Tablet';
			$main['ModiTime'] = sqlNow();
		    $this->db->update('tblChecklistLabo', $main, ['Rec_ID' => $id]);
			$this->db->delete('tblChecklistLaboDetail', ['ParentId' => $id]);
		}

		foreach ($detail as $k => $v)
		{
			if ( $k == 'P2Q1' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}

			if ( $k == 'P2Q2' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}

			if ( $k == 'P2Q3' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}

			if ( $k == 'P3Q1' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}

			if ( $k == 'P3Q2' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}

			if ( $k == 'P3Q3' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}

			if ( $k == 'P3Q4' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}

			if ( $k == 'P3Q5' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}

			if ( $k == 'P3Q6' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}

			if ( $k == 'P3Q7' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}

			if ( $k == 'P4_1Q1' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}

			if ( $k == 'P4_1Q2' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}

			if ( $k == 'P4_1Q3' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}

			if ( $k == 'P4_1Q4' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}

			if ( $k == 'P4_1Q5' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}

			if ( $k == 'P4_2Q1' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}

			if ( $k == 'P4_2Q2' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P4_2Q3' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P4_2Q4' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P4_3Q1' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P4_3Q2' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P4_4Q1' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P4_4Q2' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P4_4Q3' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P4_4Q4' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P4_4Q5' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P4_4Q6' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P4_4Q7' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P4_4Q8' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P5_1Q1' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P5_1Q2' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P5_1Q3' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P5_1Q4' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P5_1Q5' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P5_1Q6' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P5_1Q7' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P5_1Q8' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P5_1Q9' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P5_1Q10' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P5_1Q11' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P5_1Q12' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}

			if ( $k == 'P6Q1' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P6Q2' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P6Q3' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P6Q4' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P6Q5' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P7Q1' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P7Q2' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P7Q3' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P7Q4' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P7Q5' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P7Q6' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P7Q7' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P7Q8' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P7Q9' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P8Q1' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P8Q2' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P8Q3' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P8Q4' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P8Q5' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P8Q6' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P8Q7' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P8Q8' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P8Q9' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P8Q10' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_1Q1' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_1Q2' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_1Q3' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_1Q4' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_1Q5' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_1Q6' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_1Q7' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_1Q8' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_2Q1' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_2Q2' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_2Q3' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_2Q4' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_2Q5' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_2Q6' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_2Q7' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_3Q1' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_3Q2' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_3Q3' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_3Q4' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_3Q5' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_3Q6' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_3Q7' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_3Q8' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_3Q9' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_3Q10' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q1' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q2' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q3' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q4' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q5' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q6' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q7' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q8' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q9' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q10' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q11' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q12' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q13' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q14' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q15' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q16' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q17' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q18' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q19' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q20' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q21' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q22' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P9_4Q23' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P10Q1' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P10Q2' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P10Q3' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P10Q4' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P10Q5' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}
			if ( $k == 'P10Q6' ) {
				$v['answer'] = isset($v['answer']) ? $v['answer'] : '';
				$v['note'] = isset($v['note']) ? $v['note'] : '';
			}

			$value = [
				'ParentId' => $id,
				'Question' => $k,
				'Answer' => json_encode($v, JSON_UNESCAPED_UNICODE)
			];
			$this->db->insert('tblChecklistLaboDetail', $value);
		}

		if ($insert > 0) $this->response(['Rec_ID' => $id]);
	}
}