<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Edu_HC extends REST_Controller
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
				from tblChecklistEduHC as a
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
				from tblChecklistEduHC as a
				join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
				where a.Rec_ID = $id";
		$rs = $this->db->query($sql)->row();

		if ($rs != null) {
			unset($rs->InitUser, $rs->InitTime, $rs->ModiUser, $rs->ModiTime);
			$rs->Participants = json_decode($rs->Participants);

			$list = $this->db->get_where('tblChecklistEduHCDetail', ['ParentId' => $id])->result();

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
		unset($main['Detail']);

		$sql = "select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'tblChecklistEduHC' and DATA_TYPE = 'nvarchar'";
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
			$this->db->insert('tblChecklistEduHC', $main);
		    $insert = $id = toInt($this->db->insert_id());
		} else {
			$main['ModiUser'] = 'Tablet';
			$main['ModiTime'] = sqlNow();
		    $this->db->update('tblChecklistEduHC', $main, ['Rec_ID' => $id]);
			$this->db->delete('tblChecklistEduHCDetail', ['ParentId' => $id]);
		}

		foreach ($detail as $k => $v)
		{
			if ( $k == 'Q2') {
				$v['village'] = isset($v['village']) ? $v['village']:  0;
				$v['villageVMW'] = isset($v['villageVMW']) ? $v['villageVMW']:  0;
				$v['villageMMW'] = isset($v['villageMMW']) ? $v['villageMMW']:  0;
				$v['vmw'] = isset($v['vmw']) ? $v['vmw']:  0;
				$v['mmw'] = isset($v['mmw']) ? $v['mmw']:  0;
				$v['vhv'] = isset($v['vhv']) ? $v['vhv']:  0;
				$v['mobile'] = isset($v['mobile']) ? $v['mobile']:  0;
				$v['immigration'] = isset($v['immigration']) ? $v['immigration']:  0;
				$v['site'] = isset($v['site']) ? $v['site']:  0;
				$v['worker'] = isset($v['worker']) ? $v['worker']:  0;

				$v['hcData']['m1']['pf'] = isset($v['hcData']['m1']['pf']) ? $v['hcData']['m1']['pf'] : 0;
				$v['hcData']['m1']['pv'] = isset($v['hcData']['m1']['pv']) ? $v['hcData']['m1']['pv'] : 0;
				$v['hcData']['m1']['mix'] = isset($v['hcData']['m1']['mix']) ? $v['hcData']['m1']['mix'] : 0;
				$v['hcData']['m1']['total'] = isset($v['hcData']['m1']['total']) ? $v['hcData']['m1']['total'] : 0;

				$v['hcData']['m2']['pf'] = isset($v['hcData']['m2']['pf']) ? $v['hcData']['m2']['pf'] : 0;
				$v['hcData']['m2']['pv'] = isset($v['hcData']['m2']['pv']) ? $v['hcData']['m2']['pv'] : 0;
				$v['hcData']['m2']['mix'] = isset($v['hcData']['m2']['mix']) ? $v['hcData']['m2']['mix'] : 0;
				$v['hcData']['m2']['total'] = isset($v['hcData']['m2']['total']) ? $v['hcData']['m2']['total'] : 0;

				$v['hcData']['m3']['pf'] = isset($v['hcData']['m3']['pf']) ? $v['hcData']['m3']['pf'] : 0;
				$v['hcData']['m3']['pv'] = isset($v['hcData']['m3']['pv']) ? $v['hcData']['m3']['pv'] : 0;
				$v['hcData']['m3']['mix'] = isset($v['hcData']['m3']['mix']) ? $v['hcData']['m3']['mix'] : 0;
				$v['hcData']['m3']['total'] = isset($v['hcData']['m3']['total']) ? $v['hcData']['m3']['total'] : 0;

				$v['vmwData']['m1']['pf'] = isset($v['vmwData']['m1']['pf']) ? $v['vmwData']['m1']['pf'] : 0;
				$v['vmwData']['m1']['pv'] = isset($v['vmwData']['m1']['pv']) ? $v['vmwData']['m1']['pv'] : 0;
				$v['vmwData']['m1']['mix'] = isset($v['vmwData']['m1']['mix']) ? $v['vmwData']['m1']['mix'] : 0;
				$v['vmwData']['m1']['total'] = isset($v['vmwData']['m1']['total']) ? $v['vmwData']['m1']['total'] : 0;

				$v['vmwData']['m2']['pf'] = isset($v['vmwData']['m2']['pf']) ? $v['vmwData']['m2']['pf'] : 0;
				$v['vmwData']['m2']['pv'] = isset($v['vmwData']['m2']['pv']) ? $v['vmwData']['m2']['pv'] : 0;
				$v['vmwData']['m2']['mix'] = isset($v['vmwData']['m2']['mix']) ? $v['vmwData']['m2']['mix'] : 0;
				$v['vmwData']['m2']['total'] = isset($v['vmwData']['m2']['total']) ? $v['vmwData']['m2']['total'] : 0;

				$v['vmwData']['m3']['pf'] = isset($v['vmwData']['m3']['pf']) ? $v['vmwData']['m3']['pf'] : 0;
				$v['vmwData']['m3']['pv'] = isset($v['vmwData']['m3']['pv']) ? $v['vmwData']['m3']['pv'] : 0;
				$v['vmwData']['m3']['mix'] = isset($v['vmwData']['m3']['mix']) ? $v['vmwData']['m3']['mix'] : 0;
				$v['vmwData']['m3']['total'] = isset($v['vmwData']['m3']['total']) ? $v['vmwData']['m3']['total'] : 0;

				$v['asmqAdult']['total']  = isset($v['asmqAdult']['total'] )? $v['asmqAdult']['total'] : 0;
				$v['asmqAdult']['expire'] = isset($v['asmqAdult']['expire']) ? $v['asmqAdult']['expire'] : '';

				$v['asmqChildren']['total']  = isset($v['asmqChildren']['total'] )? $v['asmqChildren']['total'] : 0;
				$v['asmqChildren']['expire'] = isset($v['asmqChildren']['expire']) ? $v['asmqChildren']['expire'] : '';

				$v['primarquine']['total']  = isset($v['primarquine']['total'] )? $v['primarquine']['total'] : 0;
				$v['primarquine']['expire'] = isset($v['primarquine']['expire']) ? $v['primarquine']['expire'] : '';

				$v['rdt']['total']  = isset($v['rdt']['total'] )? $v['rdt']['total'] : 0;
				$v['rdt']['expire'] = isset($v['rdt']['expire']) ? $v['rdt']['expire'] : '';
			}

			if ( $k == 'Q31' ) {
				$v['meeting'] =  isset($v['meeting']) ? $v['meeting'] : '';
				$v['vmw'] =  isset($v['vmw']) ? $v['vmw'] : 0;
				$v['absent'] =  isset($v['absent']) ? $v['absent'] : 0;
				$v['message'] =  isset($v['message']) ? $v['message'] : '';
				$v['meetingSetup'] =  isset($v['meetingSetup']) ? $v['meetingSetup'] : '';
			}

			if ( $k == 'Q32') {
				$v['educate'] =  isset($v['educate']) ? $v['educate'] : '';
				$v['times'] =  isset($v['times']) ? $v['times'] : 0;
				$v['people'] =  isset($v['people']) ? $v['people'] : 0;
				$v['female'] =  isset($v['female']) ? $v['female'] : 0;
				$v['who'] =  isset($v['who']) ? $v['who'] : '';
				$v['other'] =  isset($v['other']) ? $v['other'] : '';
				$v['schedule'] =  isset($v['schedule']) ? $v['schedule'] : '';
				$v['method'] =  isset($v['method']) ? $v['method'] : '';
			}

			if ( $k == 'Q331' ) {
				$v['community'] =  isset($v['community']) ? $v['community'] : '';
				$v['people'] =  isset($v['people']) ? $v['people'] : 0;
				$v['male'] =  isset($v['male']) ? $v['male'] : 0;
				$v['female'] =  isset($v['female']) ? $v['female'] : 0;
				$v['implement'] =  isset($v['implement']) ? $v['implement'] : '';
			}

			if ( $k == 'Q332') {
				$v['educate'] =  isset($v['educate']) ? $v['educate'] : '';
				$v['educatedVillage'] =  isset($v['educatedVillage']) ? $v['educatedVillage'] : 0;
				$v['people'] =  isset($v['people']) ? $v['people'] : 0;
				$v['male'] =  isset($v['male']) ? $v['male'] : 0;
				$v['female'] =  isset($v['female']) ? $v['female'] : 0;
				$v['noneducatedVillage'] =  isset($v['noneducatedVillage']) ? $v['noneducatedVillage'] : 0;
			}

			if ( $k == 'Q342' ) {
				$v['distribution'] =  isset($v['distribution']) ? $v['distribution'] : '';
				$v['banner'] =  isset($v['banner']) ? $v['banner'] : 0;
				$v['broken'] =  isset($v['broken']) ? $v['broken'] : 0;
			}

			if ( $k == 'Q4' ) {
				$v['bednet'] =  isset($v['bednet']) ? $v['bednet'] : '';
				$v['total'] =  isset($v['total']) ? $v['total'] : 0;
				$v['reason'] =  isset($v['reason']) ? $v['reason'] : '';
			}

			$value = [
				'ParentId' => $id,
				'Question' => $k,
				'Answer' => json_encode($v, JSON_UNESCAPED_UNICODE)
			];
			$this->db->insert('tblChecklistEduHCDetail', $value);
		}

		if ($insert > 0) $this->response(['Rec_ID' => $id]);
	}
}