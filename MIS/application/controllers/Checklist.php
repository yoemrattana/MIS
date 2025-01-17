<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checklist extends MY_Controller
{
	public function index($v = '')
	{
		if (!isset($_SESSION['permiss']['Checklist'])) redirect('Home');

		$v == 'mneod' && $v = 'od';
		$v == 'mnehc' && $v = 'hc';

		$data['title'] = 'Checklist';
		$data['main'] = 'checklist_view';
		$data['sub'] = $v == '' ? '' : "checklist_{$v}_view";

		$this->load->view('layout', $data);
	}

	public function getData()
	{
        ini_set('memory_limit', '-1');
		$tbl = $this->input->post('tbl');

		$sql = $this->getSql($tbl) . " order by VisitDate";
		$rs['reports'] = $this->db->query($sql)->result();

        $rs['details'] = $this->getDetails($tbl);

		$this->output->set_output(json_encode($rs));
	}

    private function getDetails($tbl)
    {
        if(in_array($tbl, ['tblChecklistOD','tblChecklistHC', 'tblChecklistEduCSO', 'tblChecklistCMEPPharmacy', 'tblChecklistCMEPMicroscopy', 'tblChecklistCMEPPPM','tblChecklistSurv', 'tblChecklistStockHC','tblChecklistStockOD','tblChecklistStockRH'])) return [];

        $table = $tbl.'Detail';
        $sql = "select * from $table";
        return $this->db->query($sql)->result();
    }

	public function getDetail()
	{
		$tbl = $this->input->post('tbl');
		$where['ParentId'] = $this->input->post('id');

		$rs = $this->db->get_where($tbl.'Detail', $where)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getMISDataOD()
	{
		$od = $this->input->post('od');
		$from = $this->input->post('from');
		$to = $this->input->post('to');

		$rs = $this->db->query("SP_Checklist_OD '$od','$from','$to'")->row();

		$this->output->set_output(json_encode($rs));
	}

	public function getMISDataHC()
	{
		$hc = $this->input->post('hc');
		$from = $this->input->post('from');
		$to = $this->input->post('to');

		$rs = $this->db->query("SP_Checklist_HC '$hc','$from','$to'")->row();

		$this->output->set_output(json_encode($rs));
	}

	public function save()
	{
		$submit = json_decode($this->input->post('submit'), true);
		$tbl = $submit['tbl'];
		$master = $submit['master'];
		$details = $submit['details'] ?? null;

		if ($master['Rec_ID'] == 0) {
			if (isset($master['MissionNo'])) $master['MissionNo'] = date('Y') .'-'. $master['MissionNo'];

			$master['InitUser'] = $_SESSION['username'];
			unset($master['Rec_ID']);
			$this->db->insert($tbl, $master);
			$id = $this->db->insert_id();
		} else {
			$master['ModiUser'] = $_SESSION['username'];
			$master['ModiTime'] = sqlNow();
			$id = $master['Rec_ID'];

			unset($master['Rec_ID']);
			$this->db->update($tbl, $master, ['Rec_ID' => $id]);
		}

		if ($details) {
			$this->db->delete($tbl.'Detail', ['ParentId' => $id]);

			foreach ($details as $d)
			{
				$d['ParentId'] = $id;
				$this->db->insert($tbl.'Detail', $d);
			}
		}

		$sql = $this->getSql($tbl) . " and Rec_ID = $id";
		$rs = $this->db->query($sql)->row();

		$this->output->set_output(json_encode($rs));
	}

    public function exportExcel()
    {
        $tableName = $this->input->post('tableName');

        $sql = $this->getExportSql($tableName);
        $list = $this->db->query( $sql )->result_array();

        $template = FCPATH . "/media/Checklist/$tableName.xlsx";

        $this->load->library('PHPExcel');
        $excel = PHPExcel_IOFactory::load($template);
        $sheet = $excel->getActiveSheet();

        $this->$tableName($list, $sheet);

        ob_start();
        $writer = new PHPExcel_Writer_Excel2007($excel);
        $writer->save('php://output');
        header("Content-Disposition: attachement; filename=\"$tableName\"");
        header('Content-Length: ' . ob_get_length());
        header('Content-Type: ' . get_mime_by_extension('.xlsx'));
        ob_end_flush();
    }

    private function getExportSql($table)
    {
        if($table == 'tblChecklistCmepHC') {
            $sql = "select Name_Prov_E,Name_OD_E,Name_Facility_E, VisitDate,VisitorName,HCRepresentative,Question,Answer
                    from tblChecklistCmepHC as a
                    join tblChecklistCmepHCDetail as b on a.Rec_ID = b.ParentId
                    join tblHFCodes as c on a.Code_Facility_T = c.Code_Facility_T
                    join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
                    WHERE Deleted = 0
                    order by a.Rec_ID";
        } else if ($table == 'tblChecklistCmepOD') {
            $sql = "select Name_Prov_E, Name_OD_E, VisitDate, ODRepresentative, MnERepresentative,Question,Answer
                    from tblChecklistCmepOD as a
                    join tblChecklistCmepODDetail as b on a.Rec_ID = b.ParentId
                    join tblOD as c on a.Code_OD_T = c.Code_OD_T
                    join tblProvince as d on c.Code_Prov_T = d.Code_Prov_T
                    WHERE Deleted = 0
                    order by a.Rec_ID";
        } else if ($table == 'tblChecklistCmepRH'){
            $sql = "select Name_Prov_E,Name_OD_E,Name_Facility_E, VisitDate,VisitorName,RHRepresentative,Question,Answer
                    from tblChecklistCmepRH as a
                    join tblChecklistCmepRHDetail as b on a.Rec_ID = b.ParentId
                    join tblHFCodes as c on a.Code_Facility_T = c.Code_Facility_T
                    join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
                    WHERE Deleted = 0
                    order by a.Rec_ID";
        } else if ($table == 'tblChecklistCMEPPPM') {
            $sql = "select Name_Prov_E, Name_OD_E, Name_Facility_E, Name_Vill_E, PPM, VisitorName, VisitDate, Position, WorkPlace, J.Question, J.Answer
                    from tblChecklistCMEPPPM as a
                    CROSS APPLY OPENJSON (Detail)
                    WITH (
	                    Question varchar(MAX),
	                    Answer MAX
                    ) AS J
                    join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
                    join tblCensusVillage as c on a.Code_Vill_T = c.Code_Vill_T
                    join tblProvince as d on b.Code_Prov_N = d.Code_Prov_T
                    where Deleted = 0";
        } else if ($table == 'tblChecklistCMEPPharmacy') {
            $sql = "select Name_Prov_E, Name_OD_E, Name_Facility_E,
                    VisitorName, Schedule, VisitDate,CaseQty,Interest,NextVisitDate, J.Question, J.Answer
                    from tblChecklistCMEPPharmacy as a
                    CROSS APPLY OPENJSON (Detail)
                    WITH (
	                    Question varchar(MAX),
	                    Answer MAX
                    ) AS J
                    join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
                    join tblProvince as d on b.Code_Prov_N = d.Code_Prov_T
                    where Deleted = 0";
        } else if ($table == 'tblChecklistCMEPMicroscopy') {
            $sql = "select Name_Prov_E, Name_OD_E, Name_Facility_E,
                    FacilityType,Phone,Fax,Email,LaboDirector,HospitalDirector,Interviewee,Interviewer,
                    VisitorName,VisitDate,J.Question, J.Answer
                    from tblChecklistCMEPMicroscopy as a
                    CROSS APPLY OPENJSON (Detail)
                    WITH (
	                    Question varchar(MAX),
	                    Answer MAX
                    ) AS J
                    join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
                    join tblProvince as d on b.Code_Prov_N = d.Code_Prov_T
                    where Deleted = 0";
        }

        return $sql;
    }

    private function tblChecklistCmepHC($list,$sheet)
    {
        $r = 2;
        foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Prov_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_OD_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Facility_E']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['VisitDate']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['VisitorName']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['HCRepresentative']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Question']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Answer']);
            $r++;
		}
    }

    private function tblChecklistCmepOD($list,$sheet)
    {
        $r = 2;
        foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Prov_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_OD_E']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['VisitDate']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['ODRepresentative']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['MnERepresentative']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Question']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Answer']);
            $r++;
		}
    }

    private function tblChecklistCmepRH($list,$sheet)
    {
        $r = 2;
        foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Prov_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_OD_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Facility_E']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['VisitDate']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['VisitorName']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['RHRepresentative']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Question']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Answer']);
            $r++;
		}
    }

    private function tblChecklistCMEPPPM($list,$sheet)
    {
        $r = 2;
        foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Prov_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_OD_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Facility_E']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Vill_E']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['PPM']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['VisitDate']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['VisitorName']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Position']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['WorkPlace']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Question']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Answer']);
            $r++;
		}
    }

    private function tblChecklistCMEPMicroscopy($list,$sheet)
    {
        $r = 2;
        foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Prov_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_OD_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Facility_E']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['FacilityType']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Phone']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Fax']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Email']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['LaboDirector']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['HospitalDirector']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Interviewee']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Interviewer']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['VisitorName']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['VisitDate']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Question']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Answer']);
            $r++;
		}
    }

	private function tblChecklistStockHc($list,$sheet)
    {
        $r = 2;
        foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Prov_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_OD_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Facility_E']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['FacilityType']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Phone']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Fax']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Email']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['LaboDirector']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['HospitalDirector']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Interviewee']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Interviewer']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['VisitorName']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['VisitDate']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Question']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Answer']);
            $r++;
		}
    }

    private function tblChecklistCMEPPharmacy($list,$sheet)
    {
        $r = 2;
        foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Prov_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_OD_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Facility_E']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['VisitorName']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Schedule']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['VisitDate']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['CaseQty']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['NextVisitDate']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Question']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Answer']);
            $r++;
		}
    }

	private function getSql($tbl)
	{
		$pv = $_SESSION['prov'];
		$od = $_SESSION['code_od'];

		if ($tbl == 'tblChecklistEpi')
		{
			$sql = "select Code_Prov_N, Code_OD_T, a.*
					from $tbl as a
					join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
					where ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or Code_OD_T = '$od')";
		}
		elseif ($tbl == 'tblChecklistMnEOD')
		{
			$sql = "select distinct Code_Prov_N, a.*
					from $tbl as a
					join tblHFCodes as b on a.Code_OD_T = b.Code_OD_T
					where ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or b.Code_OD_T = '$od')";
		}
		elseif ($tbl == 'tblChecklistMnEHC')
		{
			$sql = "select Code_Prov_N, Code_OD_T, a.*
					from $tbl as a
					join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
					where ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or Code_OD_T = '$od')";
		}
		elseif ($tbl == 'tblChecklistEduHC')
		{
			$sql = "select Code_Prov_N, Code_OD_T, a.*
					from $tbl as a
					join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
					where ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or Code_OD_T = '$od')";
		}
		elseif ($tbl == 'tblChecklistEduVMW')
		{
			$sql = "select Code_Prov_N, Code_OD_T, Code_Facility_T, a.*
					from $tbl as a
					join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
					join tblHFCodes as c on b.HCCode = c.Code_Facility_T
					where ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or Code_OD_T = '$od')";
		}
		elseif ($tbl == 'tblChecklistLabo')
		{
			$sql = "select *, left(Code_Dist_T,2) as Code_Prov_N
					from $tbl
					where ('$pv' = '' or charindex(left(Code_Dist_T,2),'$pv') > 0)";
		}
		elseif ($tbl == 'tblChecklistProcurement')
		{
			$sql = "select distinct Code_Prov_N, a.*
					from $tbl as a
					join tblHFCodes as b on a.Code_OD_T = b.Code_OD_T
					where ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or b.Code_OD_T = '$od')";
		}
		elseif ($tbl == 'tblChecklistOD')
		{
			$sql = "select distinct Code_Prov_N, a.*
					from $tbl as a
					join tblHFCodes as b on a.Code_OD_T = b.Code_OD_T
					where ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or b.Code_OD_T = '$od')";
		}
		elseif ($tbl == 'tblChecklistHC')
		{
			$sql = "select Code_Prov_N, Code_OD_T, a.*
					from $tbl as a
					join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
					where ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or b.Code_OD_T = '$od')";
		}
		elseif ($tbl == 'tblChecklistCmepOD')
		{
            $sql = "select distinct Code_Prov_N, a.*
					from $tbl as a
					join tblHFCodes as b on a.Code_OD_T = b.Code_OD_T
					where ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or b.Code_OD_T = '$od')";
        }
		elseif ($tbl == 'tblChecklistCmepHC')
		{
            $sql = "select Code_Prov_N, Code_OD_T, a.*
					from $tbl as a
					join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
					where ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or Code_OD_T = '$od')";
        }
		elseif ($tbl == 'tblChecklistCmepRH')
		{
            $sql = "select Code_Prov_N, Code_OD_T, a.*
					from $tbl as a
					join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
					where ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or Code_OD_T = '$od')";
        }
		elseif ($tbl == 'tblChecklistCMEPPharmacy')
		{
            $sql = "select Code_Prov_N, Code_OD_T, a.*
					from $tbl as a
					join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
					where ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or Code_OD_T = '$od')";
        }
		elseif ($tbl == 'tblChecklistCMEPMicroscopy')
		{
            $sql = "select Code_Prov_N, Code_OD_T, a.*
					from $tbl as a
					join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
					where ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or Code_OD_T = '$od')";
		}
		elseif ($tbl == 'tblChecklistCMEPPPM')
		{
            $sql = "select Code_Prov_N, Code_OD_T, a.*
					from $tbl as a
					join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
					where ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or Code_OD_T = '$od')";
        }
		elseif ($tbl == 'tblChecklistSurv')
		{
			$sql = "select Code_Prov_N, Code_OD_T, a.*
					from $tbl as a
					join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T";
		}
		elseif ($tbl == 'tblChecklistStockHC')
		{
            $sql = "select Code_Prov_N, Code_OD_T, a.*
					from $tbl as a
					join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
					where ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or Code_OD_T = '$od')";
        }
		elseif ($tbl == 'tblChecklistStockRH')
		{
            $sql = "select Code_Prov_N, Code_OD_T, a.*
					from $tbl as a
					join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
					where ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or Code_OD_T = '$od')";
        }
		elseif ($tbl == 'tblChecklistStockOD')
		{
			$sql = "select distinct Code_Prov_N, a.*
					from $tbl as a
					join tblHFCodes as b on a.Code_OD_T = b.Code_OD_T
					where ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or b.Code_OD_T = '$od')";
		}
		elseif ($tbl == 'tblChecklistEduCSO')
		{
			$sql = "select distinct Code_Prov_N, a.*
					from $tbl as a
					join tblHFCodes as b on a.Code_OD_T = b.Code_OD_T
					where ('$pv' = '' or charindex(Code_Prov_N,'$pv') > 0) and ('$od' = '' or b.Code_OD_T = '$od')";
		}

		return $sql;
	}

	private function getCompleteness($tbl)
	{
		$where = [];
		if ($tbl == 'tblChecklistMnEHC') $where = ['P6Q1', 'P6Q2'];
		else if ($tbl == 'tblChecklistMnEOD') $where = ['P5Q1', 'P5Q2'];
		else return [];

		$tbl = $tbl.'Detail';

		$this->db->where_in('Question', $where);
		$this->db->order_by('ParentId');
		return $this->db->get($tbl)->result();
	}

	public function showReport($report, $missionNo)
	{
		if (!isset($_SESSION['permiss']['Checklist'])) redirect('Home');

		$data['title'] = 'Checklist Report';
		$data['main'] = 'checklist_'.$report.'_report_view';

		$this->load->view('layout', $data);
	}

	public function getMnEOdReport()
	{
		$missionNo = $this->input->post('mission_no');

		$sql = "select distinct Name_OD_K, Participants,
				(select format(min(VisitDate), 'dd/MM/yyyy') from tblChecklistMnEOD where MissionNo = '{$missionNo}') as StartDate,
				(select format(max(VisitDate), 'dd/MM/yyyy') from tblChecklistMnEOD where MissionNo = '{$missionNo}') as EndDate,
				Rec_ID
				from tblChecklistMnEOD as a
				join tblOD as b on b.Code_OD_T = a.Code_OD_T
				where MissionNo = '{$missionNo}'
				group by Name_OD_K, Participants, Rec_ID";
		$parents = $this->db->query($sql)->result_array();

		$children = [];
		foreach($parents as $parent) {
			$sql = "select * from tblChecklistMnEODDetail
					where Question in ('P5Q1', 'P5Q2') and ParentId = {$parent['Rec_ID']}";
			$child = $this->db->query($sql)->result_array();

			array_push($children, $child);
		}

		$data['parents'] = $parents;
		$data['children'] = $children;

		$this->output->set_output(json_encode($data));
	}

	public function getMnEHcReport()
	{
		$missionNo = $this->input->post('mission_no');

		$sql = "SELECT Name_Facility_K, Participants,
				(select format(min(VisitDate), 'dd/MM/yyyy') from tblChecklistMnEHC where MissionNo = N'$missionNo') AS StartDate,
				(select format(max(VisitDate), 'dd/MM/yyyy') from tblChecklistMnEHC where MissionNo = N'$missionNo') As EndDate,
				Rec_ID
				FROM tblChecklistMnEHC as a
				join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
				where MissionNo = N'$missionNo'";
		$parents = $this->db->query($sql)->result_array();

		$children = [];
		foreach($parents as $parent) {
			$sql = "select * from tblChecklistMnEHCDetail
					where Question in ('P6Q1', 'P6Q2') and ParentId = {$parent['Rec_ID']}";
			$child = $this->db->query($sql)->result_array();

			array_push($children, $child);
		}
		$data['parents'] = $parents;
		$data['children'] = $children;

		$this->output->set_output(json_encode($data));
	}

	public function getEpiReport()
	{
		$missionNo = $this->input->post('mission_no');

		$sql = "SELECT Name_Facility_K, Participants,
				(select format(min(VisitDate), 'dd/MM/yyyy') from tblChecklistEpi where MissionNo = N'{$missionNo}') as StartDate,
				(select format(max(VisitDate), 'dd/MM/yyyy') from tblChecklistEpi where MissionNo = N'{$missionNo}') as EndDate,
				a.Rec_ID
				FROM tblChecklistEpi as a
				join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
				where MissionNo = '{$missionNo}'";
		$parents = $this->db->query($sql)->result_array();

		$children = [];
		foreach($parents as $parent) {
			$sql = "select * from tblChecklistEpiDetail
					where ParentId = {$parent['Rec_ID']}";
			$child = $this->db->query($sql)->result_array();

			array_push($children, $child);
		}
		$data['parents'] = $parents;
		$data['children'] = $children;

		$this->output->set_output(json_encode($data));
	}

	public function getEduHCReport()
	{
		$missionNo = $this->input->post('mission_no');

		$sql = "SELECT Name_Facility_K, Participants,
				(select format(min(VisitDate), 'dd/MM/yyyy') from tblChecklistEduHC where MissionNo = '{$missionNo}') as StartDate,
				(select format(max(VisitDate), 'dd/MM/yyyy') from tblChecklistEduHC where MissionNo = '{$missionNo}') as EndDate,
				a.Rec_ID
				FROM tblChecklistEduHC as a
				join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
				where MissionNo = '{$missionNo}'";
		$parents = $this->db->query($sql)->result_array();

		$children = [];
		foreach($parents as $parent) {
			$sql = "select * from tblChecklistEduHCDetail
					where ParentId = {$parent['Rec_ID']}";
			$child = $this->db->query($sql)->result_array();

			array_push($children, $child);
		}
		$data['parents'] = $parents;
		$data['children'] = $children;

		$this->output->set_output(json_encode($data));
	}

	public function getEduVMWReport()
	{
		$missionNo = $this->input->post('mission_no');
		$sql = "SELECT Name_Vill_K, Participants,
				(select format(min(VisitDate), 'dd/MM/yyyy') from tblChecklistEduVMW where MissionNo = '{$missionNo}') as StartDate,
				(select format(max(VisitDate), 'dd/MM/yyyy') from tblChecklistEduVMW where MissionNo = '{$missionNo}') as EndDate,
				a.Rec_ID
				FROM tblChecklistEduVMW as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				where MissionNo = '{$missionNo}'";
		$parents = $this->db->query($sql)->result_array();

		$children = [];
		foreach($parents as $parent) {
			$sql = "select * from tblChecklistEduVMWDetail
					where ParentId = {$parent['Rec_ID']}";
			$child = $this->db->query($sql)->result_array();

			array_push($children, $child);
		}
		$data['parents'] = $parents;
		$data['children'] = $children;

		$this->output->set_output(json_encode($data));

	}

	public function getLaboReport()
	{
		$missionNo = $this->input->post('mission_no');

		$sql = "SELECT HFName, Participants,
				(select format(min(VisitDate), 'dd/MM/yyyy') from tblChecklistLabo where MissionNo = '{$missionNo}') as StartDate,
				(select format(max(VisitDate), 'dd/MM/yyyy') from tblChecklistLabo where MissionNo = '{$missionNo}') as EndDate,
				Rec_ID
				FROM tblChecklistLabo
				where MissionNo = '{$missionNo}'";
		$parents = $this->db->query($sql)->result_array();

		$children = [];
		foreach($parents as $parent) {
			$sql = "select * from tblChecklistLaboDetail
					where ParentId = {$parent['Rec_ID']}";
			$child = $this->db->query($sql)->result_array();

			array_push($children, $child);
		}
		$data['parents'] = $parents;
		$data['children'] = $children;

		$this->output->set_output(json_encode($data));
	}

	public function autoFill()
	{
		$list =  $this->db->query("select Rec_ID from tblChecklistEpi where VisitorPosition = 'MIS' and isnull(Part1Score,0) = 0")->result();
		$count = count($list);

		if ($count > 0) {
			foreach ($list as $r) $this->autoFillDetail($r->Rec_ID);
			$this->output->set_output("<h1>Done! ($count items updated)</h1>");
		} else {
			$this->output->set_output('<h1>Nothing to update!</h1>');
		}
	}

	private function autoFillDetail($recid)
	{
		$this->db->query("update tblChecklistEpi set Part1Score = 100, Part2Score = 100 where Rec_ID = $recid");

		$date = $this->db->query("select CheckFrom from tblChecklistEpi where Rec_ID = $recid")->row('CheckFrom');

		$thisYear = substr($date, 0, 4);
		$lastYear = $thisYear - 1;
		$month1 = intval(substr($date, -2));
		$month2 = $month1 + 1;
		$month3 = $month1 + 2;

		$obj['Q1'] = [
			'thisYear' => [
				'hc' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
				'vmw' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
				'total' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => '']
			],
			'lastYear' => [
				'hc' => ['year' => $lastYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
				'vmw' => ['year' => $lastYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
				'total' => ['year' => $lastYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => '']
			]
		];
		$obj['Q2'] = [
			'thisYear' => [
				'hc' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
				'vmw' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
				'total' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => '']
			],
			'lastYear' => [
				'hc' => ['year' => $lastYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
				'vmw' => ['year' => $lastYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
				'total' => ['year' => $lastYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => '']
			]
		];
		$obj['Q3'] = [
			'thisYear' => [
				'hc' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
				'vmw' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
				'total' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => '']
			],
			'lastYear' => [
				'hc' => ['year' => $lastYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
				'vmw' => ['year' => $lastYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
				'total' => ['year' => $lastYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => '']
			]
		];
		$obj['Q4'] = [
			'thisYear' => [
				'hc' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
				'vmw' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
				'total' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => '']
			],
			'lastYear' => [
				'hc' => ['year' => $lastYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
				'vmw' => ['year' => $lastYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
				'total' => ['year' => $lastYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => '']
			]
		];
		$obj['Q5'] = [
			'hc' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
			'vmw' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
			'total' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => '']
		];
		$obj['Q6'] = [
			'hc' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
			'vmw' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
			'total' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => '']
		];
		$obj['Q7'] = [
			'hc' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
			'vmw' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
			'total' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => '']
		];
		$obj['Q8'] = [
			'hc' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
			'vmw' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
			'total' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => '']
		];
		$obj['Q9'] = 'ពុំមានករណីខុសគ្នាទេ';
		$obj['Q10'] = 'ល្អ';
		$obj['P1Q1'] = [
			'hc' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
			'vmw' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
			'total' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
			'Score' => 10
		];
		$obj['P1Q2'] = [
			'hc' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
			'vmw' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
			'total' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
			'Score' => 15
		];
		$obj['P1Q3'] = ['tick' => [], 'other' => ''];
		$obj['P1Q4'] = [
			'hc' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
			'vmw' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
			'total' => ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => ''],
			'Score' => 15
		];
		$obj['P1Q5'] = ['tick' => [], 'other' => ''];
		$obj['P1Q6'] = ['year' => $thisYear, 'month1' => $month1, 'value1' => '', 'month2' => $month2, 'value2' => '', 'month3' => $month3, 'value3' => '', 'Score' => 10];
		$obj['P1Q6_1'] = '100';
		$obj['P1Q7'] = ['year' => $thisYear, 'month1' => $month1, 'value1' => 0, 'month2' => $month2, 'value2' => 0, 'month3' => $month3, 'value3' => 0, 'Score' => 10];
		$obj['P1Q7_1'] = '0';
		$obj['P1Q8'] = ['tick' => [], 'other' => ''];
		$obj['P1Q9'] = [
			'tablet' => ['L1' => '', 'L2' => '', 'L3' => '', 'L4' => '', 'IMP' => ''],
			'paper' => ['L1' => '', 'L2' => '', 'L3' => '', 'L4' => '', 'IMP' => ''],
			'Score' => 5
		];
		$obj['P1Q10'] = ['tick' => 'Yes', 'other' => '', 'Score' => 5];
		$obj['P1Q11'] = [
			'tick' => 'Under 7 days', 'other' => '',
			'qty1' => '', 'percent1' => '100',
			'qty2' => '', 'percent2' => '',
			'qty3' => '', 'percent3' => '',
			'Score' => 5
		];
		$obj['P2Q1'] = [
			'tick' => 'Under 14 days', 'other' => '',
			'qty1' => '', 'percent1' => '100',
			'qty2' => '', 'percent2' => '',
			'qty3' => '', 'percent3' => '',
			'Score' => 20
		];
		$obj['P2Q2'] = ['tick' => 'Full', 'other' => '', 'qty1' => '', 'qty2' => '',  'qty3' => '', 'Score' => 20];
		$obj['P2Q3'] = ['tick' => 'Draw', 'other' => '', 'qty1' => '', 'qty2' => '', 'Score' => 20];
		$obj['P2Q4'] = ['tick' => 'Done', 'other' => '', 'qty1' => '', 'qty2' => '', 'Score' => 20];
		$obj['P2Q5'] = ['test' => '1', 'bednet' => '1', 'educate' => '1', 'Score' => 20];
		$obj['Problem'] = 'ពុំមានបញ្ហាប្រឈមទេ';
		$obj['Solution'] = 'ពុំមានបញ្ហាត្រូវដោះស្រាយទេ';
		$obj['Request'] = 'ពុំមានសំណូមពរទេ';

		$rs = $this->db->query("SP_Checklist_AutoFill_Data $recid")->row_array();
		foreach ($rs as $key => $value)
		{
			$names = explode('_', $key);
			$code = '$obj';
			foreach ($names as $name) $code .= "['$name']";
			if ($value === null) $value = 0;
			eval($code . " = $value;");
		}

		$this->db->delete('tblChecklistEpiDetail', "ParentId = $recid");

		foreach ($obj as $key => $value)
		{
			$row['ParentId'] = $recid;
			$row['Question'] = $key;
			$row['Score'] = $value['Score'] ?? null;

			if (is_array($value)) unset($value['Score']);

			$row['Answer'] = json_encode($value, JSON_UNESCAPED_UNICODE);

			$this->db->insert('tblChecklistEpiDetail', $row);
		}
	}
}