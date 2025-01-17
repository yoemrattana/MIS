<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SystemMenu extends MY_Controller
{
	public function getDO($pv)
	{
		$od = $_SESSION['code_od'];
		if ($od != '') $od = " and Code_OD_T = '$od'";

		$sql = "select distinct Prov_code_T,Code_OD_T,Code_Vill_T,Name_Outlet_E,Name_Outlet_K,Lat,long,Type,ID,PPM
				from tblDrugOutlets
				where Deleted = 0 and Prov_code_T = '$pv' $od";
		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function getHF($pv)
	{
		$od = $_SESSION['code_od'];
		if ($od != '') $od = " and Code_OD_T = '$od'";

		$sql = "select Code_Prov_N,Code_OD_T,Name_OD_E,Name_Facility_E,Name_Facility_K,Code_Facility_T,Type_Facility,Lat,long,Code_Vill_T,HIS_HFCode, 0 as isnew
				from tblHFCodes
				where Code_Prov_N = '$pv' $od";
		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function getVillage($pv)
	{
		$od = $_SESSION['code_od'];
		if ($od != '') $od = " and Code_OD_T = '$od'";

		$sql = "select a.*, Code_OD_T
				from tblCensusVillage as a join tblHFCodes as b on a.HCCode = b.Code_Facility_T
				where Code_Prov_T = '$pv' $od";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getPop()
	{
		$pv = $this->input->post('prov');
		$year = $this->input->post('year');

		$od = $_SESSION['code_od'];
		if ($od != '') $od = " and Code_OD_T = '$od'";

        $sql = "SELECT Code_OD_T, Name_OD_E, HCCode, Name_Facility_E, a.Code_Vill_T, Name_Vill_E, Name_Vill_K,
                '$year' as Year, Pop, AgeU4, Age5_14, Age15_49, AgeOver49
                FROM tblCensusVillage as a
                left join tblPopByVillages as b on a.Code_Vill_T = b.Code_Vill_T and Year = '$year'
                left join tblHFCodes as c on a.HCCode = c.Code_Facility_T
                WHERE Code_Prov_N = '$pv' $od
                order by Name_OD_E, Name_Facility_E, Name_Vill_E" ;
		$rs = $this->db->query($sql)->result_array();
		$this->output->set_output(json_encode($rs));
	}

    public function getHHold($pv)
    {
        $od = $_SESSION['code_od'];
		if ($od != '') $od = " and Code_OD_T = '$od'";

		$sql = "select * from (
					SELECT Code_OD_T, Name_OD_E, HCCode, Name_Facility_E, a.Code_Vill_T, Name_Vill_E, Name_Vill_K, Year, HHold
					FROM tblCensusVillage as a
					left join tblPopByVillages as b on a.Code_Vill_T = b.Code_Vill_T
					join tblHFCodes as c on a.HCCode = c.Code_Facility_T
					WHERE Code_Prov_N = '$pv' $od
				) as a pivot (
					max(HHold) for Year in ([2012],[2013],[2014],[2015],[2016],[2017],[2018],[2019],[2020],[2021],[2022],[2023],[2024],[2025])
				) as b order by Name_OD_E, Name_Facility_E, Name_Vill_E";
		$rs = $this->db->query($sql)->result_array();
		$this->output->set_output(json_encode($rs));
    }

    public function getBedNetTarget()
    {
        $pv = $this->input->post('pv');
		$from = $this->input->post('from');
		$to = $this->input->post('to');

		$sql = "select a.Code_Vill_T as Code, Year
				from tblBedNetTarget as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				where Code_Prov_T = '$pv' and Year between $from and $to";
		$rs['log'] = $this->db->query($sql)->result();

		$sql = "select a.Code_Vill_T as code
				from tblCensusVillage as a
				join tblHFCodes as b on a.HCCode = b.Code_Facility_T
				where Code_Prov_N = '$pv'";
		$rs['vl'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
    }

	public function getOD()
	{
		$sql = "select a.Code_Prov_T, Name_Prov_E, Name_Prov_K, Code_OD_T, Name_OD_E, Name_OD_K
				from tblOD as a join tblProvince as b on a.Code_Prov_T = b.Code_Prov_T";
		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function getProvince()
	{
		$sql = "select Code_Prov_T, Name_Prov_E, Name_Prov_K, CSO, CSO2021 from tblProvince";
		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function getDistrict()
	{
		$sql = "select Code_Prov_T, Name_Prov_E, Name_Prov_K, Code_Dist_T, Name_Dist_E, Name_Dist_K
				from tblDistrict as a join tblProvince as b on left(a.Code_Dist_T,2) = b.Code_Prov_T";
		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function getCommune()
	{
		$sql = "select Code_Prov_T, Name_Prov_E, Name_Prov_K, Code_Dist_T, Name_Dist_E, Name_Dist_K, Code_Comm_T, Name_Comm_E, Name_Comm_K
				from tblCommune as a
				join tblProvince as b on left(a.Code_Comm_T,2) = b.Code_Prov_T
				join tblDistrict as c on left(a.Code_Comm_T,4) = c.Code_Dist_T";
		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function getMLUnit()
    {
        $sql = "select Code_Unit_T, Name_Unit_E, Name_Unit_K, Name_Regional_E, Name_Regional_K, a.Code_Regional_T
				from tblMLUnit as a
				join tblMLRegion as b on a.Code_Regional_T = b.Code_Regional_T";
		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
    }

	public function getRegional()
	{
		$sql = "select Code_Regional_T, Name_Regional_E, Name_Regional_K from tblMLRegion";
		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function getGroup()
	{
		$sql = "select a.*, Name_Prov_E, Name_Prov_K, Name_Unit_E, Name_Unit_K, Name_Regional_E, Name_Regional_K, d.Code_Regional_T, c.Code_Unit_T
				from tblMLGroup as a
				join tblProvince as b on a.Code_Prov_T = b.Code_Prov_T
				join tblMLUnit as c on a.Code_Unit_T = c.Code_Unit_T
				join tblMLRegion as d on c.Code_Regional_T = d.Code_Regional_T";
		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function getHFLog()
	{
		$pv = $this->input->post('pv');
		$year = $this->input->post('year');

		$sql = "select a.Code_Facility_T as code, Year, Month
				from tblHFLog as a
				join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
				where b.Code_Prov_N = '$pv' and a.Year = '$year'";
		$rs['log'] = $this->db->query($sql)->result();

		$sql = "select Code_Facility_T as code, Type_Facility as type, IP1, IP2
				from tblHFCodes where Code_Prov_N = '$pv'";
		$rs['hc'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getVMWLog()
	{
		$pv = $this->input->post('pv');
		$year = $this->input->post('year');

		$sql = "select a.Code_Vill_T as code, Year, Month
				from tblVMWLog as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				where Code_Prov_N = '$pv' and a.Year = '$year'";
		$rs['log'] = $this->db->query($sql)->result();

		$sql = "select a.Code_Vill_T as code, Note
				from tblVMWLogNote as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				where Code_Prov_N = '$pv' and Year = '$year'";
		$rs['note'] = $this->db->query($sql)->result();

		$sql = "select a.Code_Vill_T as code, HaveVMW, a.IP1, a.IP2, CSO
		        from tblCensusVillage as a
		        join tblHFCodes as b on a.HCCode = b.Code_Facility_T
				join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
		        where Code_Prov_N = '$pv' and Name_Vill_E <> ''
				order by Name_Vill_E";
		$rs['vmw'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveDO()
	{
		$value = json_decode($this->input->post('submit'), true);

		$value['DateUpdate'] = sqlNow();
		$where['ID'] = $value['ID'];
		unset($value['ID']);

		if ($where['ID'] == '') {
			$this->db->insert('tblDrugOutlets', $value);

			$sql = 'select top 1 ID from tblDrugOutlets order by DateUpdate desc';
			$id = $this->db->query($sql)->row('ID');
			$this->output->set_output(json_encode($id));
		} else {
			$this->db->update('tblDrugOutlets', $value, $where);
		}
	}

	public function saveHF()
	{
		$value = json_decode($this->input->post('submit'), true);

		$sql = "select Name_OD_E, Name_OD_K, IsTarget from tblOD where Code_OD_T = '{$value['Code_OD_T']}'";
		$od = $this->db->query($sql)->row();

		$value['Name_OD_E'] = $od->Name_OD_E;
		$value['Name_OD_K'] = $od->Name_OD_K;
		$value['IsTarget'] = $od->IsTarget;
		unset($value['distCode']);
		unset($value['commCode']);

		$isnew = $value['isnew'];
		unset($value['isnew']);

		if ($isnew == 1) {
			$this->db->insert('tblHFCodes', $value);
		} else {
			$where['Code_Facility_T'] = $value['Code_Facility_T'];
			$this->db->update('tblHFCodes', $value, $where);
		}
		writePlaceUpdate('hc');

        $md0 = [];
        $md0['Code'] = $value['Code_Facility_T'];
        $md0['Name'] = $value['Name_Facility_E'];
        $md0['Parent_code'] = $value['Code_OD_T'];
        $this->updateMD0Place($md0);
	}

	public function deleteHF()
	{
		$code = $this->input->post('code');

		$sql = "BEGIN TRY delete tblHFCodes where Code_Facility_T = '$code' END TRY
			    BEGIN CATCH select ERROR_NUMBER() as Error END CATCH";
		$error = $this->db->query($sql)->row('Error') == 547;

		if ($error) {
			$this->output->set_output(json_encode('In relationship'));
			return;
		}

		writePlaceUpdate('hc');
	}

	public function saveVillage($mode)
	{
		$value = json_decode($this->input->post('submit'), true);
        $md0 = [];

		if ($mode == 'insert'){
			$value['Code_Vill_T'] = $value['Code_Vill_Census'] . '00';
			$value['Annex'] = '00';
			$value['InitUser'] = $_SESSION['username'];
			$value['InitTime'] = sqlNow();
			$value['HCCode_Meeting'] = $value['HCCode'];
			$value['HaveVMW'] = 0;
			$value['Unregistered'] = 0;

            $md0['Code'] = $value['Code_Vill_Census'];
            $md0["Parent_code"] = $value['HCCode'];
            $md0["Name"] = $value['Name_Vill_E'];

			$this->db->insert('tblCensusVillage', $value);
		} elseif ($mode == 'insertannex') {
			$where['Code_Vill_Census'] = $value['Code_Vill_Census'];
			$where['Annex'] = '00';
			$row = $this->db->get_where('tblCensusVillage',$where)->row_array();

			$row['Code_Vill_T'] = $value['Code_Vill_T'];
			$row['Name_Vill_E'] = $value['Name_Vill_E'];
			$row['Name_Vill_K'] = $value['Name_Vill_K'];
			$row['Annex'] = $value['Annex'];
			$row['InitUser'] = $_SESSION['username'];
			$row['InitTime'] = sqlNow();
			$row['ModiUser'] = null;
			$row['ModiTime'] = null;

			$this->db->insert('tblCensusVillage', $row);
		} elseif ($mode == 'update') {
            $md0['Code'] = substr($value['Code_Vill_T'], 0, 8);
            $md0["Parent_code"] = $value['HCCode'];
            $md0["Name"] = $value['Name_Vill_E'];

			$value['ModiUser'] = $_SESSION['username'];
			$value['ModiTime'] = sqlNow();
			$where['Code_Vill_T'] = $value['Code_Vill_T'];
			unset($value['Code_Vill_T']);

			$this->db->update('tblCensusVillage', $value, $where);
		} elseif ($mode == 'delete') {
			$count = $this->db->where($value)->count_all_results('tblHFActivityCases');
			if ($count == 0) $count = $this->db->where($value)->count_all_results('tblHFCodes');

			$sql = "BEGIN TRY delete tblCensusVillage where Code_Vill_T = '{$value['Code_Vill_T']}' END TRY
			        BEGIN CATCH select ERROR_NUMBER() as Error END CATCH";
			$error = $this->db->query($sql)->row('Error') == 547;

			if ($error) {
				$this->output->set_output(json_encode('In relationship'));
				return;
			}
		} elseif ($mode == 'movedata') {
			$from = $value['from'];
			$to = $value['to'];
			$this->db->query("SP_MoveVillData '$from','$to'");
		}
		writePlaceUpdate('vl');

		$this->updateMD0Place($md0);
	}

    public function updateMD0Place($params)
    {
        try
		{
			$client = new GuzzleHttp\Client();
			$baseUrl = 'http://13.228.170.200';
			$url = "{$baseUrl}/api/v1/places/update_mdzero_place";

			$client->postAsync($url, [
				'headers' => ['Content-type' => 'application/json'],
				'auth' => ['mis_app', 'mIs@2019'],
				'json' => $params,
			]);
		}
		catch (Exception $exception)
		{
		}
    }

	public function savePop()
	{
		$list = json_decode($this->input->post('list'));

		for ($i = 0; $i < count($list); $i++)
		{
			$vill = $list[$i]->Code_Vill_T;
			$year = $list[$i]->Year;
			$pop = $list[$i]->Pop;
            $ageU4      = empty($list[$i]->AgeU4) ? 0 : $list[$i]->AgeU4;
            $age5_14    = empty($list[$i]->Age5_14) ? 0 : $list[$i]->Age5_14;
            $age15_49   = empty($list[$i]->Age15_49) ? 0 : $list[$i]->Age15_49;
            $ageOver49  = empty($list[$i]->AgeOver49) ? 0 : $list[$i]->AgeOver49;

			$pop = $pop == null || $pop == '' ? 0 : $pop;
			$this->db->query("SP_UpdatePopulation '$vill','$year',$pop, $ageU4,$age5_14,$age15_49,$ageOver49");
		}
	}

    public function saveHHold()
	{
		$list = json_decode($this->input->post('list'));

		for ($i = 0; $i < count($list); $i++)
		{
			$vill = $list[$i]->vill;
			$year = $list[$i]->year;
			$hhold = $list[$i]->hhold;

			$hhold = $hhold == null || $hhold == '' ? 0 : $hhold;
			$this->db->query("SP_UpdateHHold '$vill','$year',$hhold");
		}
	}

    public function saveBedNetTarget()
	{
		$list = json_decode($this->input->post('list'));
		foreach ($list as $r)
		{
			$value['Code_Vill_T'] = $r->code;
			$value['Year'] = $r->year;
			$r->has ? $this->db->delete('tblBedNetTarget', $value) : $this->db->insert('tblBedNetTarget', $value);
		}
	}

	public function saveOD()
	{
		$submit = json_decode($this->input->post('submit'), true);
		$this->db->update('tblOD', $submit['value'], $submit['where']);
		writePlaceUpdate('od');
	}

	public function saveProvince()
	{
		$submit = json_decode($this->input->post('submit'), true);
		$this->db->update('tblProvince', $submit['value'], $submit['where']);
		writePlaceUpdate('pv');
	}

	public function saveDistrict()
	{
		$submit = json_decode($this->input->post('submit'), true);
		$this->db->update('tblDistrict', $submit['value'], $submit['where']);
		writePlaceUpdate('ds');
	}

	public function saveCommune()
	{
		$submit = json_decode($this->input->post('submit'), true);
		if ($submit['isnew']) {
			$value = array_merge($submit['value'], $submit['where']);
			$this->db->insert('tblCommune', $value);
		} else {
			$this->db->update('tblCommune', $submit['value'], $submit['where']);
		}
		writePlaceUpdate('cm');
	}

	public function saveRegional()
	{
		$submit = json_decode($this->input->post('submit'), true);

		if (isset($submit['where'])) {
			$this->db->update('tblMLRegion', $submit['value'], $submit['where']);
		} else {
			$this->db->insert('tblMLRegion', $submit['value']);
		}

		writePlaceUpdate('rg');
	}

	public function deleteRegional()
	{
		$where = $this->input->post();
		$this->db->delete('tblMLRegion', $where);
		writePlaceUpdate('rg');
	}

	public function saveMLUnit()
	{
		$submit = json_decode($this->input->post('submit'), true);

		if (isset($submit['where'])) {
			$this->db->update('tblMLUnit', $submit['value'], $submit['where']);
		} else {
			$this->db->insert('tblMLUnit', $submit['value']);
		}

		writePlaceUpdate('unit');
	}

	public function deleteMLUnit()
	{
		$where = $this->input->post();
		$this->db->delete('tblMLUnit', $where);
		writePlaceUpdate('unit');
	}

	public function saveGroup()
	{
		$submit = json_decode($this->input->post('submit'), true);
		$rec_id = $submit['where']['Rec_ID'];
		if ($rec_id == 0) {
			$this->db->insert('tblMLGroup', $submit['value']);
			$rec_id = $this->db->insert_id();
		} else {
			$this->db->update('tblMLGroup', $submit['value'], $submit['where']);
		}
		writePlaceUpdate('gp');
		writePlaceUpdate('rgpv');

		$sql = "select a.*, Name_Prov_E, Name_Prov_K, Name_Unit_E, Name_Unit_K, Name_Regional_E, Name_Regional_K, d.Code_Regional_T, c.Code_Unit_T
				from tblMLGroup as a
				join tblProvince as b on a.Code_Prov_T = b.Code_Prov_T
				join tblMLUnit as c on a.Code_Unit_T = c.Code_Unit_T
				join tblMLRegion as d on c.Code_Regional_T = d.Code_Regional_T
				where a.Rec_ID = $rec_id";
		$rs = $this->db->query($sql)->row();

		$this->output->set_output(json_encode($rs));
	}

	public function saveHFLog()
	{
		$list = json_decode($this->input->post('list'));
		foreach ($list as $r)
		{
			$value['Code_Facility_T'] = $r->code;
			$value['Year'] = $r->year;
			$value['Month'] = $r->month;
			$r->has ? $this->db->delete('tblHFLog', $value) : $this->db->insert('tblHFLog', $value);
		}

		$hf = json_decode($this->input->post('hf'), true);
		foreach ($hf as $r)
		{
			$this->db->update('tblHFCodes', $r['value'], $r['where']);
		}
	}

	public function saveVMWLog()
	{
		$list = json_decode($this->input->post('list'));
		foreach ($list as $r)
		{
			$value = [];
			$value['Code_Vill_T'] = $r->code;
			$value['Year'] = $r->year;
			$value['Month'] = $r->month;
			$r->has ? $this->db->delete('tblVMWLog', $value) : $this->db->insert('tblVMWLog', $value);
		}

		$vmw = json_decode($this->input->post('vmw'), true);
		foreach ($vmw as $r)
		{
			$this->db->update('tblCensusVillage', $r['value'], $r['where']);
		}

		$note = json_decode($this->input->post('note'));
		foreach ($note as $r)
		{
			$value = [];
			$value['Code_Vill_T'] = $r->code;
			$value['Year'] = $r->year;
			$this->db->delete('tblVMWLogNote', $value);

			if ($r->note != null && $r->note != '') {
				$value['Note'] = $r->note;
				$value['InitUser'] = $_SESSION['username'];
				$this->db->insert('tblVMWLogNote', $value);
			}
		}
	}

	public function saveTrackingLog()
	{
		$log = json_decode($this->input->post('log'), true);
		foreach ($log as $l) {
			$l['ModiUser'] = $_SESSION['username'];
			$l['ModiTime'] = sqlNow();
			$this->db->insert('tblVMWLogModiTrack', $l);
		}
	}

	public function vmwLogTrackingLog()
	{
		if ($_SESSION['role'] != 'AU') redirect('Home');

		$data['title'] = 'VMW Log Tracking Log';
		$data['main'] = 'vmwlogtrackinglog_view';

		$this->load->view('layout', $data);
	}

	public function getVMWlogTrackingLog()
	{
		$sql = "select Name_Prov_E, Name_OD_E, Name_Facility_E, Name_Vill_E, NewValue, OldValue, a.ModiUser, a.ModiTime from tblVMWLogModiTrack as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on c.Code_Facility_T = b.HCCode
				join tblProvince as d on d.Code_Prov_T = b.Code_Prov_T
				order by a.ModiTime desc";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function deleteCommune()
	{
		$where['Code_Comm_T'] = $this->input->post('code');
		$this->db->delete('tblCommune', $where);
		writePlaceUpdate('cm');
	}

	public function deleteGroup()
	{
		$where['Rec_ID'] = $this->input->post('Rec_ID');
		$this->db->delete('tblMLGroup', $where);
		writePlaceUpdate('gp');
	}

	public function getEnvOffice()
	{
		$sql = "select a.*, Name_Prov_E, Name_Prov_K
				from tblEnvOffice as a
				join tblProvince as b on a.Code_Prov_T = b.Code_Prov_T";
		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function saveOffice()
	{
		$submit = json_decode($this->input->post('submit'), true);
		$rec_id = $submit['where']['Rec_ID'];
		if ($rec_id == 0) {
			$this->db->insert('tblEnvOffice', $submit['value']);
			$rec_id = $this->db->insert_id();
		} else {
			$this->db->update('tblEnvOffice', $submit['value'], $submit['where']);
		}

		$sql = "select a.*, Name_Prov_E, Name_Prov_K
				from tblEnvOffice as a
				join tblProvince as b on a.Code_Prov_T = b.Code_Prov_T
				where Rec_ID = $rec_id";
		$rs = $this->db->query($sql)->row();

		$this->output->set_output(json_encode($rs));
	}

	public function deleteOffice()
	{
		$where['Rec_ID'] = $this->input->post('Rec_ID');
		$this->db->delete('tblEnvOffice', $where);
	}

	public function getPLTroop()
	{
		$sql = "select a.*, Name_Prov_E, Name_Prov_K
				from tblPLTroopCodes as a
				join tblProvince as b on a.Code_Prov_T = b.Code_Prov_T";
		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function saveTroop()
	{
		$submit = json_decode($this->input->post('submit'), true);
		$rec_id = $submit['where']['Rec_ID'];
		if ($rec_id == 0) {
			$this->db->insert('tblPLTroopCodes', $submit['value']);
			$rec_id = $this->db->insert_id();
		} else {
			$this->db->update('tblPLTroopCodes', $submit['value'], $submit['where']);
		}

		$sql = "select a.*, Name_Prov_E, Name_Prov_K
				from tblPLTroopCodes as a
				join tblProvince as b on a.Code_Prov_T = b.Code_Prov_T
				where Rec_ID = $rec_id";
		$rs = $this->db->query($sql)->row();

		$this->output->set_output(json_encode($rs));
	}

	public function deleteTroop()
	{
		$where['Rec_ID'] = $this->input->post('Rec_ID');
		$this->db->delete('tblPLTroopCodes', $where);
	}

	public function getEnvCommunity()
	{
		$sql = "select a.Code_Prov_T, a.Name_Prov_E, b.Code_Office_T, b.Name_Office_K
				from tblProvince as a
				left join tblEnvOffice as b on a.Code_Prov_T = b.Code_Prov_T";
		$rs['preData'] = $this->db->query($sql)->result();

		$sql = "select a.*, c.Code_Prov_T, Name_Prov_E, Name_Office_E, Name_Office_K
				from tblEnvCommunity as a
				join tblEnvOffice as b on a.Code_Office_T = b.Code_Office_T
				join tblProvince as c on b.Code_Prov_T = c.Code_Prov_T";
		$rs['mainData'] = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function saveCommunity()
	{
		$submit = json_decode($this->input->post('submit'), true);
		$rec_id = $submit['where']['Rec_ID'];
		if ($rec_id == 0) {
			$this->db->insert('tblEnvCommunity', $submit['value']);
			$rec_id = $this->db->insert_id();
		} else {
			$this->db->update('tblEnvCommunity', $submit['value'], $submit['where']);
		}

		$sql = "select a.*, c.Code_Prov_T, Name_Prov_E, Name_Office_E, Name_Office_K
				from tblEnvCommunity as a
				join tblEnvOffice as b on a.Code_Office_T = b.Code_Office_T
				join tblProvince as c on b.Code_Prov_T = c.Code_Prov_T
				where a.Rec_ID = $rec_id";
		$rs = $this->db->query($sql)->row();

		$this->output->set_output(json_encode($rs));
	}

	public function deleteCommunity()
	{
		$where['Rec_ID'] = $this->input->post('Rec_ID');
		$this->db->delete('tblEnvCommunity', $where);
	}

	public function getPLPost()
	{
		$sql = "select a.*, c.Code_Prov_T, Name_Prov_E, Name_Troop_E, Name_Troop_K
				from tblPLPostCodes as a
				join tblPLTroopCodes as b on a.Code_Troop_T = b.Code_Troop_T
				join tblProvince as c on b.Code_Prov_T = c.Code_Prov_T";
		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function savePost()
	{
		$submit = json_decode($this->input->post('submit'), true);
		$rec_id = $submit['where']['Rec_ID'];
		if ($rec_id == 0) {
			$this->db->insert('tblPLPostCodes', $submit['value']);
			$rec_id = $this->db->insert_id();
		} else {
			$this->db->update('tblPLPostCodes', $submit['value'], $submit['where']);
		}

		$sql = "select a.*, c.Code_Prov_T, Name_Prov_E, Name_Troop_E, Name_Troop_K
				from tblPLPostCodes as a
				join tblPLTroopCodes as b on a.Code_Troop_T = b.Code_Troop_T
				join tblProvince as c on b.Code_Prov_T = c.Code_Prov_T
				where a.Rec_ID = $rec_id";
		$rs = $this->db->query($sql)->row();

		$this->output->set_output(json_encode($rs));
	}

	public function deletePost()
	{
		$where['Rec_ID'] = $this->input->post('Rec_ID');
		$this->db->delete('tblPLPostCodes', $where);
	}
}