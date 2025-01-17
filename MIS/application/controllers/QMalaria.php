<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QMalaria extends MY_Controller
{
	public function index($v = '')
	{
		if (!isset($_SESSION['permiss']['Q Malaria'])) redirect('Home');

		$data['title'] = 'Q Malaria/CRP Duo Test';
		$data['main'] = 'qm_view';
		$data['sub'] = $v == '' ? '' : 'qm'.$v.'_view';

		$this->load->view('layout', $data);
	}

	public function getData()
	{
		$tbl = $this->input->post('tbl');
		$recid = $this->input->post('recid');

		$where = $recid == null ? '' : "where a.Rec_ID = $recid";
		$order = $tbl == 'tblQMBaselineData' ? 'DocNumber' : ($tbl == 'tblQMLabo' ? 'ParticipantCode' : 'PatientCode');

		$sql = "select Code_Prov_N, Code_OD_T, a.*
				from $tbl as a
				join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
				$where order by $order";
		$rs['data'] = $this->db->query($sql)->result();

		$arr = $this->db->field_data($tbl);

		$rs['model'] = [];
		$rs['datatype'] = [];
		foreach ($arr as $r) {
			if ($r->type == 'date') {
				$rs['datatype']['date'][] = $r->name;
				$rs['model'][$r->name] = null;
			} else {
				$rs['model'][$r->name] = '';
			}
			if ($r->type == 'nvarchar') $rs['datatype']['nvarchar'][] = $r->name;
		}

		$this->output->set_output(json_encode($rs));
	}

	public function getDetail()
	{
		$where = $this->input->post();
		$rs = $this->db->order_by('Rec_ID')->get_where('tblQMBaselineDataDetail', $where)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function saveBaselineData()
	{
		$model = json_decode($this->input->post('submit'), true);

		$id = $model['Rec_ID'];
		$list = $model['list'];

		$model['ModiUser'] = $_SESSION['username'];
		$model['ModiTime'] = sqlNow();

		unset($model['Rec_ID']);
		unset($model['InitTime']);
		unset($model['list']);

		$this->db->update('tblQMBaselineData', $model, ['Rec_ID' => $id]);

		$this->db->delete('tblQMBaselineDataDetail', ['ParentId' => $id]);
		$this->db->insert_batch('tblQMBaselineDataDetail', $list);

		$rs = $this->db->get_where('tblQMBaselineData', ['Rec_ID' => $id])->row();
		$this->output->set_output(json_encode($rs));
	}

	public function getLog($tbl)
	{
		$where = $this->input->post();
		$rs = $this->db->order_by('Rec_ID')->get_where($tbl, $where)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function exportExcel()
	{
		$filename = $this->input->post('filename');
		$tabs = ['labo', 'testing', 'sample'];

		$view = 'V_QMClinic';
		if ($filename == 'followup') $view = 'V_QMFollowup';
		if (in_array($filename, $tabs)) $view = 'V_QMLabo';

		$rs = $this->db->get($view)->result_array();

		$excel = arrayToExcel($rs);
		$excel->getActiveSheet()->setTitle($filename);

		ob_start();
		$writer = new PHPExcel_Writer_Excel2007($excel);
		$writer->save('php://output');
		header('Content-Length: ' . ob_get_length());
		header('Content-Type: ' . get_mime_by_extension('.xlsx'));
		ob_end_flush();
	}

	public function exportAll()
	{
		$rs1 = $this->db->get('V_QMLabo')->result_array();
		$rs2 = $this->db->get('V_QMClinic')->result_array();

		if (count($rs1) > 0 || count($rs2) > 0) {
			$excel = null;
			if (count($rs1) > 0) {
				$excel = arrayToExcel($rs1);
				$excel->getActiveSheet()->setTitle('CRP Laboratory');

				if (count($rs2) > 0) {
					$excel->createSheet()->setTitle('CRP Clinical');
					$excel->setActiveSheetIndexByName('CRP Clinical');
					arrayToExcel($rs2, $excel);
				}
			} else {
				$excel = arrayToExcel($rs2);
				$excel->getActiveSheet()->setTitle('CRP Clinical');
			}

			ob_start();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			header('Content-Length: ' . ob_get_length());
			header('Content-Type: ' . get_mime_by_extension('.xlsx'));
			ob_end_flush();
		}
	}

	public function report1()
	{
		$data['title'] = 'CRP Report';
		$data['main'] = 'qmreport1_view';

		$this->load->view('layout', $data);
	}

	public function report2()
	{
		$data['title'] = 'CRP Report';
		$data['main'] = 'qmreport2_view';

		$this->load->view('layout', $data);
	}

	public function getReportData1()
	{
		$sql = "select Name_Facility_E
					  ,count(*) as Patient
					  ,sum(iif(RDT = 'yes',1,0)) as RDT
					  ,sum(iif(Antibiotic = 'yes',1,0)) as Antibiotic
				from tblQMBaselineData as a
				join tblQMBaselineDataDetail as b on a.Rec_ID = b.ParentId
				join tblHFCodes as c on a.Code_Facility_T = c.Code_Facility_T
				where Code_OD_T = '0501'
				group by Name_Facility_E
				order by Name_Facility_E";
		$rs['table'] = $this->db->query($sql)->result();

		$sql = "select Name_Facility_E
					  ,iif(year(DateCase) = 2019,month(DateCase),13) as Month
					  ,count(*) as Total
				from tblHFCodes as a
				join tblQMBaselineData as b on a.Code_Facility_T = b.Code_Facility_T
				join tblQMBaselineDataDetail as c on b.Rec_ID = c.ParentId
				where Code_OD_T = '0501'
				group by Name_Facility_E, iif(year(DateCase) = 2019,month(DateCase),13)
				order by Name_Facility_E, Month";
		$rs['chart1'] = $this->db->query($sql)->result();

		$sql = "select Name_Facility_E, count(*) as Reported
				from tblQMBaselineData as a
				join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
				where Code_OD_T = '0501'
				group by Name_Facility_E
				order by Name_Facility_E";
		$rs['chart2'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getReportData2()
	{
		$rs['labo'] = $this->db->get('tblQMLabo')->result();
		$rs['clinic'] = $this->db->get('tblQMClinic')->result();

		$sql = "select isnull(a.Code_Facility_T,b.Code_Facility_T) as Code_Facility_T
					  ,isnull(ParticipantCode,'MA011' + PatientCode) as PatientCode
					  ,iif(a.Code_Facility_T is null,0,1) as Labo
					  ,iif(b.Code_Facility_T is null,0,1) as Clinic
				from tblQMLabo as a
				full join tblQMClinic as b on right(ParticipantCode,6) = PatientCode
				where ParticipantCode is null or PatientCode is null";
		$rs['notBoth'] = $this->db->query($sql)->result();

		$sql = "select a.Code_Facility_T, ParticipantCode, CRPLevel, CRPResult, b.Rec_ID, 'clinic' as type
				from tblQMLabo as a
				join tblQMClinic as b on right(ParticipantCode,6) = PatientCode
				where a.Code_Facility_T not in ('050112','050104','050124','050108','050119')
				and (CRPResult is null or (CRPLevel >= 20 and CRPResult <> 'Positive') or (CRPLevel < 20 and CRPResult <> 'Negative'))";
		$rs['checkResult'] = $this->db->query($sql)->result();

		$sql = "select a.Code_Facility_T, format(a.ConsultDate,'yyyyMM') YearMonth
					  ,count(distinct b.Rec_ID) as Labo
					  ,count(distinct a.Rec_ID) as Clinic
					  ,count(distinct c.Rec_ID) as Followup
				from tblQMClinic as a
				left join tblQMLabo as b on a.PatientCode = right(b.ParticipantCode,6)
				left join tblQMFollowup as c on a.PatientCode = c.PatientCode
				group by a.Code_Facility_T, format(a.ConsultDate,'yyyyMM')";
		$rs['monthReport'] = $this->db->query($sql)->result();

		$sql = "select Code_Facility_T, a.Year + a.Month as YearMonth, count(*) as Test
				from V_HFActivityCases as a
				join V_HFCodes as b on a.ID = b.Code_Facility_T and a.Year = b.Year
				where a.Year >= 2020 and Code_OD_T = '0501'
				group by Code_Facility_T, a.Year + a.Month";
		$rs['malariaTest'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}
}