<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class iDes extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['iDes'])) redirect('Home');

		$data['title'] = 'iDES';
		$data['main'] = 'ides_view';
		$this->load->view('layout', $data);
	}

	public function getHCList()
	{
		$pv = $this->input->post('pv');
		$od = $this->input->post('od');
		$hc = $this->input->post('hc');
		$mf = $this->input->post('mf');
		$mt = $this->input->post('mt');
		$hasiDes = $this->input->post('hasiDes');

		if ($_SESSION['prov'] != '' && $pv == '') $pv = $_SESSION['prov'];
		if ($_SESSION['code_od'] != '') $od = $_SESSION['code_od'];

		$sql = "select a.Rec_ID as Case_ID, 'HC' as Case_Type, b.Code_Facility_T, NameK, Age, Sex, Diagnosis, Month, DateCase, c.InitTime as iDesDate
					  ,iif(c.Rec_ID is null,0,1) as HasiDes
				from tblHFActivityCases as a
				join tblHFCodes as b on a.ID = b.Code_Facility_T
				left join tbliDes as c on a.Rec_ID = c.Case_ID and c.Case_Type = 'HC'
				join tbliDesHC as d on b.Code_Facility_T = d.Code_Facility_T
				where Positive = 'P' and IsTarget = 1 and Type_Facility = 'HC'
				and Year + Month between '$mf' and '$mt'
				and ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0)
				and ('$od' = '' or Code_OD_T = '$od')
				and ('$hc' = '' or b.Code_Facility_T = '$hc')
				and ($hasiDes = 0 or c.Rec_ID is not null)
				and Year + '-' + Month >= StartDate
				order by Code_Prov_N, Name_OD_E, Name_Facility_E";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getVMWList()
	{
		$pv = $this->input->post('pv');
		$od = $this->input->post('od');
		$hc = $this->input->post('hc');
		$vl = $this->input->post('vl');
		$mf = $this->input->post('mf');
		$mt = $this->input->post('mt');
		$hasiDes = $this->input->post('hasiDes');

		if ($_SESSION['prov'] != '' && $pv == '') $pv = $_SESSION['prov'];
		if ($_SESSION['code_od'] != '') $od = $_SESSION['code_od'];

		$sql = "select a.Rec_ID as Case_ID, 'VMW' as Case_Type, c.Code_Facility_T, b.Code_Vill_T, NameK, Age, Sex, Diagnosis, Month, DateCase, d.InitTime as iDesDate
					  ,iif(d.Rec_ID is null,0,1) as HasiDes
				from tblVMWActivityCases as a
				join tblCensusVillage as b on a.ID = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				left join tbliDes as d on a.Rec_ID = d.Case_ID and d.Case_Type = 'VMW'
				join tbliDesHC as e on c.Code_Facility_T = e.Code_Facility_T
				left join tbliDesVillage as f on b.Code_Vill_T = f.Code_Vill_T
				where Positive = 'P' and IsTarget = 1
				and Year + Month between '$mf' and '$mt'
				and ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0)
				and ('$od' = '' or Code_OD_T = '$od')
				and ('$hc' = '' or c.Code_Facility_T = '$hc')
				and ('$vl' = '' or b.Code_Vill_T = '$vl')
				and ($hasiDes = 0 or d.Rec_ID is not null)
				and Year + '-' + Month >= e.StartDate
				and (f.Code_Vill_T is null or Year + '-' + Month >= f.StartDate)
				order by Code_Prov_N, Name_OD_E, Name_Facility_E, Name_Vill_E";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getRHList()
	{
		$pv = $this->input->post('pv');
		$od = $this->input->post('od');
		$hc = $this->input->post('hc');
		$mf = $this->input->post('mf');
		$mt = $this->input->post('mt');
		$hasiDes = $this->input->post('hasiDes');

		if ($_SESSION['prov'] != '' && $pv == '') $pv = $_SESSION['prov'];
		if ($_SESSION['code_od'] != '') $od = $_SESSION['code_od'];

		$sql = "select a.Rec_ID as Case_ID, 'HC' as Case_Type, b.Code_Facility_T, NameK, Age, Sex, Diagnosis, Month, DateCase, c.InitTime as iDesDate
					  ,iif(c.Rec_ID is null,0,1) as HasiDes
				from tblHFActivityCases as a
				join tblHFCodes as b on a.ID = b.Code_Facility_T
				left join tbliDes as c on a.Rec_ID = c.Case_ID and c.Case_Type = 'HC'
				join tbliDesHC as d on b.Code_Facility_T = d.Code_Facility_T
				where Positive = 'P' and IsTarget = 1 and Type_Facility in ('PRH','RH')
				and Year + Month between '$mf' and '$mt'
				and ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0)
				and ('$od' = '' or Code_OD_T = '$od')
				and ('$hc' = '' or b.Code_Facility_T = '$hc')
				and ($hasiDes = 0 or c.Rec_ID is not null)
				and Year + '-' + Month >= StartDate
				order by Code_Prov_N, Name_OD_E, Name_Facility_E";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

    public function getHcUpcomingFU()
    {
        $pv = $this->input->post('pv');
		$od = $this->input->post('od');
		$hc = $this->input->post('hc');
        $y = $this->input->post('y');
        $m = $this->input->post('m');
        $type = $this->input->post('type');

		if ($_SESSION['prov'] != '' && $pv == '') $pv = $_SESSION['prov'];
		if ($_SESSION['code_od'] != '') $od = $_SESSION['code_od'];

        $rs = $this->db->query("SP_iDes_HcUpcomingFU '$y', '$m', '$pv','$od', '$hc', '$type'")->result();
        $this->output->set_output(json_encode($rs));
    }

    public function getVmwUpcomingFU()
    {
        $pv = $this->input->post('pv');
		$od = $this->input->post('od');
		$hc = $this->input->post('hc');
        $y = $this->input->post('y');
        $m = $this->input->post('m');

		if ($_SESSION['prov'] != '' && $pv == '') $pv = $_SESSION['prov'];
		if ($_SESSION['code_od'] != '') $od = $_SESSION['code_od'];

        $rs = $this->db->query("SP_iDes_VmwUpcomingFU '$y', '$m', '$pv','$od', '$hc'")->result();
        $this->output->set_output(json_encode($rs));
    }

	public function getDetail()
	{
		$id = $this->input->post('id');
		$type = $this->input->post('type');

		if ($type == 'HC') {
			$sql = "select convert(date,a.InitTime) as NotificationDate
						  ,convert(date,DateCase) as DiagnosisDate
						  ,convert(date,DateCase) as InvestigationDate
						  ,NameK as FirstName, '' as LastName
						  ,Sex, Age, Weight, DOB, Occupation, PatientPhone as Phone
						  ,Name_Vill_E, Name_Comm_E, Name_Dist_E, Name_Prov_E
						  ,case when Sex = 'F' and G6PDHb >= 6.1 then N'Normal (≥ 6.1 U/g Hb)'
								when Sex = 'F' and G6PDHb between 4.1 and 6 then 'Intermediate (4.1-6.0 U/g Hb)'
								when Sex = 'F' and G6PDHb <= 4 then N'Deficient (≤ 4.0 U/g Hb)'
								when Sex = 'M' and G6PDHb >= 4.1 then N'Normal (≥ 4.1 U/g Hb)'
								when Sex = 'M' and G6PDHb <= 4 then N'Deficient (≤ 4.0 U/g Hb)' end as G6PD
						  ,Diagnosis, 'PCD' as CaseDetection
						  ,case when Relapse = 1 then 'Relapsing'
								when L1 = 1 then 'Introduced'
								when LC = 1 then 'Indigenous'
								when IMP = 1 then 'Imported' else 'Not done' end as CaseInvestigation
						  ,Dose, DoseTablet, DoseExpiration, DoseBatch, Mg, MgTablet, MgExpiration, MgBatch
						  ,FollowupCompleted, PCR, PCROther, Conclusion, DayFailure
					from tblHFActivityCases as a
					left join tbliDes as b on a.Rec_ID = b.Case_ID and b.Case_Type = 'HC'
					left join tblCensusVillage as c on a.Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS = c.Code_Vill_T
					left join tblCommune as d on c.Code_Comm_T = d.Code_Comm_T
					left join tblDistrict as e on c.Code_Dist_T = e.Code_Dist_T
					left join tblProvince as f on c.Code_Prov_T = f.Code_Prov_T
					where a.Rec_ID = $id";

			$sql2 = "select PatientCode, NameK, Sex, Weight, Diagnosis
							,G6PDHb, G6PDdL
							,case when Sex = 'F' and G6PDHb >= 6.1 then 'Normal'
								  when Sex = 'F' and G6PDHb between 4.1 and 6 then 'Intermediate'
								  when Sex = 'F' and G6PDHb <= 4 then 'Deficient'
								  when Sex = 'M' and G6PDHb >= 4.1 then 'Normal'
								  when Sex = 'M' and G6PDHb <= 4 then 'Deficient' end as G6PDLevel
							,isnull(Name_Vill_E,a.Code_Vill_t) as Name_Vill_E, Name_Facility_E, d.*
					from tblHFActivityCases as a
					left join tblCensusVillage as b on a.Code_Vill_t = b.Code_Vill_T
					join tblHFCodes as c on a.ID = c.Code_Facility_T
					left join tbliDesFollowup as d on a.Rec_ID = d.Case_ID and d.Case_Type = 'HC'
					where a.Rec_ID = $id";
		} else {
			$sql = "select convert(date,a.InitTime) as NotificationDate
						  ,convert(date,DateCase) as DiagnosisDate
						  ,convert(date,DateCase) as InvestigationDate
						  ,NameK as FirstName, '' as LastName
						  ,Sex, Age, Weight, DOB, Occupation, PatientPhone as Phone
						  ,Name_Vill_E, Name_Comm_E, Name_Dist_E, Name_Prov_E
						  ,case when Sex = 'F' and G6PDHb >= 6.1 then N'Normal (≥ 6.1 U/g Hb)'
								when Sex = 'F' and G6PDHb between 4.1 and 6 then 'Intermediate (4.1-6.0 U/g Hb)'
								when Sex = 'F' and G6PDHb <= 4 then N'Deficient (≤ 4.0 U/g Hb)'
								when Sex = 'M' and G6PDHb >= 4.1 then N'Normal (≥ 4.1 U/g Hb)'
								when Sex = 'M' and G6PDHb <= 4 then N'Deficient (≤ 4.0 U/g Hb)' end as G6PD
						  ,Diagnosis, 'PCD' as CaseDetection
						  ,case when Relapse = 1 then 'Relapsing'
								when L1 = 1 then 'Introduced'
								when LC = 1 then 'Indigenous'
								when IMP = 1 then 'Imported' else 'Not done' end as CaseInvestigation
						  ,Dose, DoseTablet, DoseExpiration, DoseBatch, Mg, MgTablet, MgExpiration, MgBatch
						  ,FollowupCompleted, PCR, PCROther, Conclusion, DayFailure
					from tblVMWActivityCases as a
					left join tbliDes as b on a.Rec_ID = b.Case_ID and b.Case_Type = 'VMW'
					join tblCensusVillage as c on a.ID = c.Code_Vill_T
					join tblCommune as d on c.Code_Comm_T = d.Code_Comm_T
					join tblDistrict as e on c.Code_Dist_T = e.Code_Dist_T
					join tblProvince as f on c.Code_Prov_T = f.Code_Prov_T
					where a.Rec_ID = $id";

			$sql2 = "select PatientCode, NameK, Sex, Weight, Diagnosis
							,G6PDHb, G6PDdL
							,case when Sex = 'F' and G6PDHb >= 6.1 then 'Normal'
								  when Sex = 'F' and G6PDHb between 4.1 and 6 then 'Intermediate'
								  when Sex = 'F' and G6PDHb <= 4 then 'Deficient'
								  when Sex = 'M' and G6PDHb >= 4.1 then 'Normal'
								  when Sex = 'M' and G6PDHb <= 4 then 'Deficient' end as G6PDLevel
							,Name_Vill_E, Name_Facility_E, d.*
					from tblVMWActivityCases as a
					join tblCensusVillage as b on a.ID = b.Code_Vill_T
					join tblHFCodes as c on b.HCCode = c.Code_Facility_T
					left join tbliDesFollowup as d on a.Rec_ID = d.Case_ID and d.Case_Type = 'VMW'
					where a.Rec_ID = $id";
		}

		$rs['master'] = $this->db->query($sql)->row();
		$rs['detail'] = $this->db->get_where('tbliDesDetail', "Case_ID = $id and Case_Type = '$type'")->result();

		$sql = "select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'tbliDes' and COLUMN_NAME <> 'Rec_ID'";
		$rs['masterColumns'] = array_column($this->db->query($sql)->result(), 'COLUMN_NAME');

		$rs['detailColumns'] = $this->db->list_fields('tbliDesDetail');

		$rs['followup'] = $this->db->query($sql2)->row();

		$this->output->set_output(json_encode($rs));
	}

	public function save()
	{
		$master = $this->input->post('master');
		$details = $this->input->post('details');
		$follow = json_decode($this->input->post('follow'));

		$where['Case_ID'] = $master['Case_ID'];
		$where['Case_Type'] = $master['Case_Type'];

		$count = $this->db->where($where)->count_all_results('tbliDes');
		if ($count == 0) {
            $master['InitUser'] = $_SESSION['username'];

            $this->db->insert('tbliDes', $master);
		} else {
			$master['ModiTime'] = sqlNow();
            $master['ModiUser'] = $_SESSION['username'];

            $this->db->update('tbliDes', $master, $where);
		}

		$this->db->delete('tbliDesDetail', $where);
		if ($details != null) $this->db->insert_batch('tbliDesDetail', $details);

		$count = $this->db->where($where)->count_all_results('tbliDesFollowup');
		if ($count == 0) {
			$this->db->insert('tbliDesFollowup', $follow);
		} else {
			$this->db->update('tbliDesFollowup', $follow, $where);
		}
	}

	public function getPermission()
	{
		$sql = "select Code_Prov_N, Code_OD_T, a.Code_Facility_T, iif(b.Code_Facility_T is null,0,1) as Permission, StartDate
				from tblHFCodes as a
				left join tbliDesHC as b on a.Code_Facility_T = b.Code_Facility_T
				where Type_Facility <> 'HP'
				order by Code_Prov_N, Name_OD_E, Name_Facility_E";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function savePermission()
	{
		$list = json_decode($this->input->post('list'));

		$this->db->query('delete tbliDesHC');
		$this->db->insert_batch('tbliDesHC', $list);
	}

	public function getTable()
	{
		$filter = $this->input->post('filter');
		$mf = $this->input->post('mf');
		$mt = $this->input->post('mt');
		$pv = $this->input->post('pv');
		$od = $this->input->post('od');
		$hc = $this->input->post('hc');
		$vl = $this->input->post('vl');
		$site = $this->input->post('site');

		if ($_SESSION['prov'] != '' && $pv == '') $pv = $_SESSION['prov'];
		if ($_SESSION['code_od'] != '') $od = $_SESSION['code_od'];

		if ($filter == 'iDES Summary') $rs = $this->db->query("SP_iDes_Table_Summary '$mf','$mt','$pv','$od','$hc','$vl','',''")->result();
		if ($filter == 'iDES Sites') {
			$rs['site'] = $this->db->query("SP_iDes_Table_Site '$pv','$od','$hc','$vl'")->result();
			$rs['count'] = $this->db->query("SP_iDes_Table_SiteCount '$pv','$od','$hc','$vl'")->result();
		}
		if ($filter == 'Case Notification') $rs = $this->db->query("SP_iDes_Table_Notification '$mf','$mt','$pv','$od','$hc','$vl','$site'")->row();
		if ($filter == 'Case Enrollment') $rs = $this->db->query("SP_iDes_Table_Enroll '$mf','$mt','$pv','$od','$hc','$vl'")->result();
		if ($filter == 'Follow-up') $rs = $this->db->query("SP_iDes_Table_Followup '$mf','$mt','$pv','$od','$hc','$vl','$site'")->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getGraph()
	{
		$filter = $this->input->post('filter');
		$mf = $this->input->post('mf');
		$mt = $this->input->post('mt');
		$pv = $this->input->post('pv');
		$od = $this->input->post('od');
		$hc = $this->input->post('hc');
		$vl = $this->input->post('vl');
		$species = $this->input->post('species');
		$site = $this->input->post('site');

		if ($_SESSION['prov'] != '' && $pv == '') $pv = $_SESSION['prov'];
		if ($_SESSION['code_od'] != '') $od = $_SESSION['code_od'];

		$param = "'$mf','$mt','$pv','$od','$hc','$vl','$species','$site'";

		if ($filter == 'iDES follow up rate') {
			$rs['follow'] = $this->db->query("SP_iDes_Graph_Followup $param")->row();
			$rs['species'] = $this->db->query("SP_iDes_Graph_Species $param")->result();
		}
		if ($filter == 'Geographical Distribution of Cases') {
			$rs['map1'] = $this->db->query("SP_iDes_Graph_Map1 $param")->result();
			$rs['map2'] = $this->db->query("SP_iDes_Graph_Map2 $param")->result();
		}
		if ($filter == 'Case Enrollment') {
			$rs['a'] = $this->db->query("SP_iDes_Table_Summary $param")->result();
			$rs['b'] = $this->db->query("SP_iDes_Graph_Enroll_OD $param")->result();
		}
		if ($filter == 'Weekly Case Enrollment') $rs = $this->db->query("SP_iDes_Graph_Week $param")->result();
		if ($filter == 'Blood Slides/DBS') $rs = $this->db->query("SP_iDes_Graph_DBS $param")->row();
		if ($filter == 'Samples Collected') $rs = $this->db->query("SP_iDes_Graph_SampleCollected $param")->row();
		if ($filter == 'iDES cases with side effects') $rs = $this->db->query("SP_iDes_Graph_SideEffect $param")->result();
		if ($filter == 'PCR Result') $rs = $this->db->query("SP_iDes_Graph_PCR $param")->result();

		$this->output->set_output(json_encode($rs));
	}

    public function saveNote()
    {
        $submit = $this->input->post('submit');

        $submit['InitTime'] = sqlNow();
        $submit['InitUser'] = $_SESSION['username'];

        $this->db->delete('tbliDesNote', ['Rec_ID' => $submit['Note_ID']]);
        unset($submit['Note_ID']);
        $this->db->insert('tbliDesNote', $submit);
    }

    public function exportExcel()
	{
		$data = json_decode($this->input->post('data'));

		$excel = arrayToExcel($data);

		ob_start();
		$writer = new PHPExcel_Writer_Excel2007($excel);
		$writer->save('php://output');
		header('Content-Length: ' . ob_get_length());
		header('Content-Type: ' . get_mime_by_extension('.xlsx'));
		ob_end_flush();
	}

	public function exportReport()
	{
		$list = json_decode($this->input->post('json'), true);

		$excel = $this->prepareReport($list);

        ob_start();
        $writer = new PHPExcel_Writer_Excel2007($excel);
        $writer->save('php://output');
        header('Content-Length: ' . ob_get_length());
        header('Content-Type: ' . get_mime_by_extension('.xlsx'));
        ob_end_flush();
	}

	private function prepareReport($list)
	{
		$this->load->library('PHPExcel');
		$excel = new PHPExcel();
		$sheet = $excel->getActiveSheet();

		$c = 0;
		$sheet->setCellValueByColumnAndRow($c++, 1, 'Place');
		$sheet->setCellValueByColumnAndRow($c++, 1, 'Positive');
		$sheet->setCellValueByColumnAndRow($c++, 1, 'Eligible iDES');
		$sheet->setCellValueByColumnAndRow($c++, 1, 'iDES');
		$sheet->setCellValueByColumnAndRow($c++, 1, 'iDES (%)');
		$sheet->setCellValueByColumnAndRow($c++, 1, 'CSO');

		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setWidth(12);
		$sheet->getStyle('A1:F1')->getFont()->setBold(true);
		$sheet->getStyle('A1:F1')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('E:F')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('E:E')->getNumberFormat()->setFormatCode('0%');

		$list = array_slice($list, 1);
		$r = 2;
        foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Place']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Positive']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Eligible_iDes']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['iDes']);
            $sheet->setCellValueByColumnAndRow($c++, $r, "=IFERROR(D$r/C$r,\"-\")");
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['CSO']);
            $r++;
		}

		$images = $this->input->post('images');
		$n = 2;
		foreach ($images as $img)
		{
			$image = imagecreatefromstring(base64_decode($img));

			$drawing = new PHPExcel_Worksheet_MemoryDrawing();
			$drawing->setImageResource($image);
			$drawing->setHeight(450);
			$drawing->setCoordinates('H'.$n);
			$drawing->setWorksheet($sheet);
			$n += 24;
		}

		return $excel;
	}

	public function delete()
	{
		$where = $this->input->post('where');

		$value['DeletedUser'] = $_SESSION['username'];
		$value['Code_Facility_T'] = $this->input->post('hc');
		$value['Code_Vill_T'] = $this->input->post('vl');
		$value['Parent'] = json_encode($this->db->get_where('tbliDes', $where)->row(), JSON_UNESCAPED_UNICODE);
		$value['Detail'] = json_encode($this->db->get_where('tbliDesDetail', $where)->result(), JSON_UNESCAPED_UNICODE);
		$value['Followup'] = json_encode($this->db->get_where('tbliDesFollowup', $where)->row(), JSON_UNESCAPED_UNICODE);
		$this->db->insert('tbliDesDeleted', $value);

		$this->db->delete('tbliDes', $where);
		$this->db->delete('tbliDesDBS', $where);
	}

	public function getDBS()
	{
		$prov = $this->input->post('prov');
		$mf = $this->input->post('mf');
		$mt = $this->input->post('mt');

		$sql = "select NameK, a.Case_ID, a.Case_Type, DBS_Code, Days, DBS_Date, Category, Field, Value
				from (
					select NameK, Rec_ID as Case_ID, 'VMW' as Case_Type, HCCode
					from tblVMWActivityCases as a
					join tblCensusVillage as b on a.ID = b.Code_Vill_T
					where Positive = 'P' and Year + Month between '$mf' and '$mt'

					union all

					select NameK, Rec_ID, 'HC' as Case_Type, ID
					from tblHFActivityCases
					where Positive = 'P' and Year + Month between '$mf' and '$mt'
				) as a
				join tblHFCodes as b on a.HCCode = b.Code_Facility_T
				left join tbliDesDBS as c on a.Case_ID = c.Case_ID and a.Case_Type = c.Case_Type
				join tbliDes as d on a.Case_ID = d.Case_ID and a.Case_Type = d.Case_Type
				where IsTarget = 1 and Code_Prov_N = '$prov'
				order by NameK";

		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function saveDBS()
	{
		$list = json_decode($this->input->post('list'), true);
		$changedId = $this->input->post('changedId');

		$this->db->delete('tbliDesDBS', "CONCAT(Case_Type,Case_ID) in ('$changedId')");

		foreach ($list as $value)
		{
			$this->db->insert('tbliDesDBS', $value);
		}
	}

    public function getNotification()
    {
        $sql = "select top 500 * from (
                select distinct Place_Code, Type, Message, FORMAT( a.InitTime,'yyyy-MM-dd') as InitDate,
                CONCAT('HC ', Name_Facility_E) as Place
                from tbliDesNotification as a
                join tblHFCodes as b on a.Place_Code = b.Code_Facility_T and a.Type = 'HC'

                union all

                select distinct Place_Code, Type, Message, FORMAT( a.InitTime,'yyyy-MM-dd') as InitDate,
                CONCAT('VMW ', Name_Vill_E) as Place
                from tbliDesNotification as a
                join tblCensusVillage as b on a.Place_Code = b.Code_Vill_T and a.Type = 'VMW'
            ) as a order by InitDate desc, Place_Code";

        $rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
    }
}