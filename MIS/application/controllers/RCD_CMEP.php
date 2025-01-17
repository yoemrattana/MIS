<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RCD_CMEP extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['RCD CMEP'])) redirect('/Home');

		$data['title'] = 'RCD CMEP';
		$data['main'] = 'rcd_cmep_view';
		$this->load->view('layout', $data);
	}

	public function getList()
	{
		$pv = $this->input->post('pv');
		$od = $this->input->post('od');
		$hc = $this->input->post('hc');
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$hasform = $this->input->post('hasform');

		if ($_SESSION['prov'] != '' && $pv == '') $pv = $_SESSION['prov'];
		if ($_SESSION['code_od'] != '') $od = $_SESSION['code_od'];

		$sql = "select a.*, iif(b.Rec_ID is null,0,1) as HasForm
				from (
					select Rec_ID as Case_ID, 'VMW' as Case_Type, HCCode as Code_Facility_T, NameK, Age, Sex, Diagnosis, Month, DateCase
					from tblVMWActivityCases as a
					join tblCensusVillage as b on a.ID = b.Code_Vill_T
					where Year = '$year' and Positive = 'P'
					union all
					select Rec_ID, 'HC', ID, NameK, Age, Sex, Diagnosis, Month, DateCase
					from tblHFActivityCases
					where Year = '$year' and Positive = 'P'
				) as a
				left join tblRCDCMEP as b on a.Case_ID = b.Case_ID and a.Case_Type = b.Case_Type
				join tblHFCodes as c on a.Code_Facility_T = c.Code_Facility_T
				join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				where c.IsTarget = 1 and CSO2021 = 'URC'
				and ('$month' = '' or Month = '$month')
				and ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0)
				and ('$od' = '' or Code_OD_T = '$od')
				and ('$hc' = '' or c.Code_Facility_T = '$hc')
				and ($hasform = 0 or b.Rec_ID is not null)
				order by Month, Name_Prov_E, Name_OD_E, Name_Facility_E";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getDetail()
	{
		$where = $this->input->post();

		$rs = $this->db->get_where('tblRCDCMEP', $where)->row();

		$this->output->set_output(json_encode($rs));
	}

	public function save()
	{
		$data = $this->input->post('data');

		$id = $data['Rec_ID'];
		unset($data['Rec_ID']);

		$data['ModiUser'] = $_SESSION['username'];
		$data['ModiTime'] = sqlNow();

		if ($id == 0) {
			$this->db->insert('tblRCDCMEP', $data);
		} else {
			$this->db->update('tblRCDCMEP', $data, ['Rec_ID' => $id]);
		}
	}

	public function exportExcel()
	{
		$sql = "select Year, Month, Name_Prov_E, Name_OD_E, Name_Facility_E, NameK as PatientName, CONCAT(Case_Type,'-',Case_ID) as CaseCode, Detail
				from (
					select a.*, HCCode, NameK, Year, Month
					from tblRCDCMEP as a
					join tblVMWActivityCases as b on a.Case_ID = b.Rec_ID and a.Case_Type = 'VMW'
					join tblCensusVillage as c on b.ID = c.Code_Vill_T
					union all
					select a.*, ID, NameK, Year, Month
					from tblRCDCMEP as a
					join tblHFActivityCases as b on a.Case_ID = b.Rec_ID and a.Case_Type = 'HC'
				) as a
				join tblHFCodes as b on a.HCCode = b.Code_Facility_T
				join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
				order by Year, Month, Name_Prov_E, Name_OD_E, Name_Facility_E";

		$data = $this->db->query($sql)->result();

		function check($r, $obj, $key)
		{
			if (is_string($obj)) {
				$r->$key = $obj;
				return;
			}

			foreach ($obj as $k => $v) {
				if (in_array($k, ['pvcode', 'dscode', 'cmcode', 'vlcode'])) continue;
				check($r, $v, $key == '' ? $k : $key.'_'.$k);
			}
		}

		foreach ($data as $r)
		{
			$d = json_decode($r->Detail);
			unset($r->Detail);
			check($r, $d, '');
		}

		$excel = arrayToExcel($data);

		ob_start();
		$writer = new PHPExcel_Writer_Excel2007($excel);
		$writer->save('php://output');
		header('Content-Length: ' . ob_get_length());
		header('Content-Type: ' . get_mime_by_extension('.xlsx'));
		ob_end_flush();
	}
}