<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{
	public function index()
	{
		$od = $_SESSION['code_od'];
		$rg = $_SESSION['code_rg'];

		$data['provlist'] = $this->getProvince();

		if ($od != '') {
			$sql = "select Name_OD_E, Name_OD_K from tblOD where Code_OD_T = '$od'";
			$rs = $this->db->query($sql)->row();
			$data['nameE'] = $rs->Name_OD_E;
			$data['nameK'] = $rs->Name_OD_K;
		} elseif ($rg != '') {
			$sql = "select distinct Name_Regional_E, Name_Regional_K from tblMLCodes where Code_Regional_T = '$rg'";
			$rs = $this->db->query($sql)->row();
			$data['nameE'] = $rs != null ? $rs->Name_Regional_E : 'All Regional';
			$data['nameK'] = $rs != null ? $rs->Name_Regional_K : 'យោធភូមិភាគទាំងអស់';
		}

		$permiss = isset($_SESSION['permiss']['Export Data']) ? $_SESSION['permiss']['Export Data'] : [];
		$data['exportList'] = [];
		$sql = "select StoreName,Text,DateFilter from tblExportList where Enable = 1 order by Text";
		$rs = $this->db->query($sql)->result_array();
		foreach ($rs as $row) {
			if (in_array($row['Text'], $permiss)) $data['exportList'][] = $row;
		}

		$today = date("Y-m-d");
		$yesterday = date("Y-m-d", strtotime("yesterday"));

		$data['todayVisit'] = $this->getVisitCount($today);
		$data['yesterdayVisit'] = $this->getVisitCount($yesterday);
		$data['isLogin'] = true;
        $data['title'] = 'Home';
		$data['main'] = 'homeV2';
		$this->load->view('layoutV2', $data);
	}

	private function getVisitCount($date)
	{
		$sql = "SELECT count(*) as visitor FROM tblAccessLog where convert(date, AccessDate) = '{$date}'";
		return $this->db->query($sql)->row()->visitor;
	}

	public function sysmenu($code_prov = '', $systable = 'choose', $year = '')
	{
		if (!isset($_SESSION['permiss']['System Menu'])) redirect('/Home');

		$data['title'] = 'System Menu';
		$data['main'] = "nav_$systable";
		$data['systablelist'] = $this->getSystemTable();
		$data['systable'] = $systable;
		$data['code_prov'] = $code_prov;
        $data['yearList'] = $this->yearList();
        $data['year'] = $year == '' ? date('Y') : $year;

		if (!in_array($systable, ['district', 'commune'])) {
			$data['provlist'] = $this->getProvince();
		}

		$this->load->view('layout', $data);
	}

	private function yearList()
	{
		return [
			'2006' => '2006',
            '2007' => '2007',
            '2008' => '2008',
            '2009' => '2009',
            '2010' => '2010',
            '2011' => '2011',
            '2012' => '2012',
            '2013' => '2013',
            '2014' => '2014',
            '2015' => '2015',
            '2016' => '2016',
            '2017' => '2017',
            '2018' => '2018',
            '2019' => '2019',
            '2020' => '2020',
            '2021' => '2021',
            '2022' => '2022',
            '2023' => '2023',
            '2024' => '2024',
            '2025' => '2025'
		];
	}

	private function getSystemTable()
	{
		$data['choose'] = 'Choose';
		$data['drugoutlets'] = 'Drug Outlets';
		$data['healthfacility'] = 'Health Facilities';
		$data['village'] = 'Village';
		$data['population'] = 'Population';
        $data['hhold'] = 'House Hold';
		$data['province'] = 'Province';
		$data['od'] = 'OD';
		$data['district'] = 'District';
		$data['commune'] = 'Commune';
		$data['hflog'] = 'HF Log';
		$data['vmwlog'] = 'VMW Log';
        $data['bednettarget'] = 'Bed Net Target';

        $permiss = [];
        foreach ($_SESSION['permiss']['System Menu'] as $pm) {
            $permiss[] = explode(" -", $pm)[0];
        }
        foreach ($data as $k => $mn) {
			if ($k == 'choose') continue;
            if (!in_array($mn, $permiss)) unset($data[$k]);
        }
		if (in_array('Military', $permiss)) {
			$data['regional'] = 'Military Regional';
			$data['mlunit'] ='Military Unit';
			$data['group'] = 'Military Group';
		}
		if ($_SESSION['role'] == 'AU') {
			$data['pltroop'] = 'Police Troop';
			$data['plpost'] = 'Police Post';
			$data['envoffice'] = 'Environment Office';
			$data['envcommunity'] = 'Environment Community';
		}
    	return $data;
    }

	private function getProvince()
	{
		$code_prov = $_SESSION['code_prov'];
    	$sql = "select distinct Code_Prov_T,Name_Prov_E from tblProvince where Code_Prov_T <> 30";
    	if ($code_prov != '') $sql .= " and Code_Prov_T in ('$code_prov')";
    	$sql .= " order by Name_Prov_E";

    	$rs = $this->db->query($sql)->result();
		return array_column($rs, 'Name_Prov_E', 'Code_Prov_T');
    }

	private function getSqlToExport()
	{
		$prov = $this->input->get('prov');
		$storeName = $this->input->get('storeName');
		$national = $this->input->get('national') == 1;
		$dateFrom = $this->input->get('df');
		$dateTo = $this->input->get('dt');
        $code_od = $_SESSION['code_od'];
		$fdc = $this->input->get('fdc');

		$national && $prov = $_SESSION['prov'];
		$sql = "$storeName '$dateFrom','$dateTo','$prov','$code_od',$fdc";

		return $sql;
	}

	public function previewExcel()
	{
		$data['data'] = $this->db->query($this->getSqlToExport())->result_array();
		$data['main'] = 'export_preview';
		$this->load->library('table');
		$this->load->view('layout', $data);
	}

	public function exportExcel()
	{
		ExportExcel($this->getSqlToExport());
	}

	public function changePassword()
	{
		$value['Ps'] = $this->input->post('password');
		$where['Us'] = $_SESSION['username'];
		$this->db->update('MIS_User', $value, $where);

		$pwd = password_hash($value['Ps'], PASSWORD_BCRYPT);
		set_cookie('pwd', $pwd, strtotime('+2 years') - time());
	}

	public function getPlace()
	{
		$req = $this->input->post('request');
		$rs = [];

		if (in_array('pv', $req)) {
			$sql = "select Code_Prov_T as code, Name_Prov_E as name, Name_Prov_K as nameK, IsTarget as target from tblProvince where Code_Prov_T <> 30 order by name";
			$rs['pv'] = $this->db->query($sql)->result();
		}
		if (in_array('od', $req)) {
			$sql = "select Code_OD_T as code, Name_OD_E as name, Name_OD_K as nameK, left(Code_OD_T,2) as pvcode, IsTarget as target from tblOD order by name";
			$rs['od'] = $this->db->query($sql)->result();
		}
		if (in_array('hc', $req)) {
			$sql = "select Code_Facility_T as code, Name_Facility_E as name, Name_Facility_K as nameK, Code_OD_T as odcode, Type_Facility as type from tblHFCodes order by name";
			$rs['hc'] = $this->db->query($sql)->result();
		}
		if (in_array('ds', $req)) {
			$sql = "select Code_Dist_T as code, Name_Dist_E as name, Name_Dist_K as nameK, left(Code_Dist_T,2) as pvcode from tblDistrict order by name";
			$rs['ds'] = $this->db->query($sql)->result();
		}
		if (in_array('cm', $req)) {
			$sql = "select Code_Comm_T as code, Name_Comm_E as name, Name_Comm_K as nameK, left(Code_Comm_T,4) as dscode from tblCommune order by name";
			$rs['cm'] = $this->db->query($sql)->result();
		}
		if (in_array('vl', $req)) {
			$sql = "select Code_Vill_T as code, Name_Vill_E as name, Name_Vill_K as nameK, Code_Comm_T as cmcode, HCCode as hccode, iif(HaveVMW = 1,VMWType,null) as type from tblCensusVillage order by name";
			$rs['vl'] = $this->db->query($sql)->result();
		}
		if (in_array('rg', $req)) {
			$sql = "select Code_Regional_T as code, Name_Regional_E as name, Name_Regional_K as nameK from tblMLRegion order by name";
			$rs['rg'] = $this->db->query($sql)->result();
		}
		if (in_array('unit', $req)) {
			$sql = "select Code_Unit_T as code, Name_Unit_E as name, Name_Unit_K as nameK, Code_Regional_T as rgcode from tblMLUnit";
			$rs['unit'] = $this->db->query($sql)->result();
		}
		if (in_array('gp', $req)) {
			$sql = "select Code_Group_T as code, Name_Group_E as name, Name_Group_K as nameK, Code_Unit_T as unitcode from tblMLGroup order by name";
			$rs['gp'] = $this->db->query($sql)->result();
		}
		if (in_array('rgpv', $req)) {
			$sql = "select distinct Code_Regional_T as rgcode, Code_Prov_T as pvcode
					from tblMLGroup as a
					join tblMLUnit as b on a.Code_Unit_T = b.Code_Unit_T";
			$rs['rgpv'] = $this->db->query($sql)->result();
		}

		$this->output->set_output(json_encode($rs));
	}
}