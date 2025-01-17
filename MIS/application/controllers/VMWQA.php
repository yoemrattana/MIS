<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VMWQA extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('MVMWQA');
	}

	public function index()
	{
		if (!isset($_SESSION['permiss']['VMW QA'])) redirect('Home');

		$data['title'] = 'VMW Questionnaire';
		$data['main'] = 'vmwqa_view';

		$this->load->view('layout', $data);
	}

	public function getList()
	{
		$sql = "select a.*, Code_Prov_N, Code_OD_T, Code_Facility_T
				from tblVMWQuestionnaire as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getDetail()
	{
		$where['ParentId'] = $this->input->post('id');

		$rs = $this->db->get_where('tblVMWQuestionnaireDetail', $where)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function save()
	{
		$master = json_decode($this->input->post('master'), true);
		$detail = json_decode($this->input->post('detail'), true);

		$id = $master['Rec_ID'];

		unset($master['Rec_ID']);
		unset($master['InitTime']);
		unset($master['Code_Prov_N']);
		unset($master['Code_OD_T']);
		unset($master['Code_Facility_T']);
		unset($master['TPR']);

		if ($id == 0) {
			$this->db->insert('tblVMWQuestionnaire', $master);
			$id = $this->db->insert_id();
			for ($i = 0; $i < count($detail); $i++) $detail[$i]['ParentId'] = $id;
		} else {
			$this->db->update('tblVMWQuestionnaire', $master, ['Rec_ID' => $id]);
		}

		$this->db->delete('tblVMWQuestionnaireDetail', ['ParentId' => $id]);
		$this->db->insert_batch('tblVMWQuestionnaireDetail', $detail);

		$this->output->set_output(json_encode($id));
	}

    public function logDelete()
    {
        $submit = $this->input->post('submit');
		$submit = json_decode($submit, true);

        $this->load->model('Log_model');
		$this->Log_model->deleteVMWQA( $submit );
    }

	public function getSupervision()
	{
		$pvcode = $this->input->post('pvcode');
		$odcode = $this->input->post('odcode');
		$hccode = $this->input->post('hccode');
		$vlcode = $this->input->post('vlcode');

		$sql = "SP_Get_VMWQAList '$pvcode','$odcode','$hccode','$vlcode'";
		$rs = $this->MVMWQA->groupReport($sql);

		$this->output->set_output(json_encode($rs));
	}

	public function getMonitor()
	{
		$sql = "select a.Code_Vill_T, VisitDate, Section2, Section3, Section4, Section5, Section6, Section7, TotalScore
				from (
					select *, ROW_NUMBER() over (partition by Code_Vill_T order by VisitDate desc) as Num
					from tblVMWQuestionnaire
				) as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				where Num = 1";
		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function getReport()
	{
		$pvcode = $this->input->post('pvcode');
        $odcode = $this->input->post('odcode');
		$hccode = $this->input->post('hccode');
        $vlcode = $this->input->post('vlcode');
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$sql = "SP_Get_VMWQAList '$pvcode','$odcode','$hccode','$vlcode','$year','$month'";
		$rs = $this->MVMWQA->crossTabReport($sql);

		$this->output->set_output(json_encode($rs));
	}

	public function getDashboard()
	{
		$pv = $this->input->post('pv');
		$od = $this->input->post('od');

		$sql = "select AVG(TotalScore) as Average
				from tblVMWQuestionnaire as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				where ('$pv' = '' or Code_Prov_N = '$pv')
				and ('$od' = '' or Code_OD_T = '$od')";
		$data['overall'] = $this->db->query($sql)->row_array();

		$sql = "select count(*) as NeverAssessed
				from tblCensusVillage as a
				join tblHFCodes as b on a.HCCode = b.Code_Facility_T
				left join tblVMWQuestionnaire as c on a.Code_Vill_T = c.Code_Vill_T and c.Code_Vill_T is null
				where HaveVMW = 1 and IsTarget = 1
				and ('$pv' = '' or Code_Prov_N = '$pv')
				and ('$od' = '' or Code_OD_T = '$od')";
		$data['overall']['NeverAssessed'] = $this->db->query($sql)->row('NeverAssessed');

		$sql = "select avg(iif(TotalScore < 40,100,0)) as Low
					  ,avg(iif(TotalScore between 40 and 79,100,0)) as Medium
					  ,avg(iif(TotalScore > 79,100,0)) as High
				from tblVMWQuestionnaire as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				where TotalScore is not null
				and ('$pv' = '' or Code_Prov_N = '$pv')
				and ('$od' = '' or Code_OD_T = '$od')";
		$data['chartPie'] = $this->db->query($sql)->row();

		$data['chartNeverAssessed'] = $this->db->query("SP_QA_Dashboard '$pv','$od'")->result();

		$sql = "select top 5 English
					  ,iif(b.Score = 0, 100, avg(a.Score) * 100 / b.Score) as Percentage
				from tblVMWQuestionnaireDetail as a
				join tblVMWQuestionnaireItem as b on a.Question = b.Question
				join tblVMWQuestionnaire as c on a.ParentId = c.Rec_ID
				join tblCensusVillage as d on c.Code_Vill_T = d.Code_Vill_T
				join tblHFCodes as e on d.HCCode = e.Code_Facility_T
				where ('$pv' = '' or Code_Prov_N = '$pv')
				and ('$od' = '' or Code_OD_T = '$od')
				group by a.Question, English, b.Score
				order by Percentage";
		$data['chartTop5'] = $this->db->query($sql)->result();

		$sql = "select convert(float,min(Section2)) as Section2Min
					  ,convert(float,max(Section2)) as Section2Max
					  ,convert(float,min(Section3)) as Section3Min
					  ,convert(float,max(Section3)) as Section3Max
					  ,convert(float,min(Section4)) as Section4Min
					  ,convert(float,max(Section4)) as Section4Max
					  ,convert(float,min(Section5)) as Section5Min
					  ,convert(float,max(Section5)) as Section5Max
					  ,convert(float,min(Section6)) as Section6Min
					  ,convert(float,max(Section6)) as Section6Max
					  ,convert(float,min(Section7)) as Section7Min
					  ,convert(float,max(Section7)) as Section7Max
				from tblVMWQuestionnaire as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				where ('$pv' = '' or Code_Prov_N = '$pv')
				and ('$od' = '' or Code_OD_T = '$od')";
		$data['chartBoxPlot'] = $this->db->query($sql)->row();

		$sql = "select Code_OD_T, avg(TotalScore) as Score
				from tblVMWQuestionnaire as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				where TotalScore is not null
				group by Code_OD_T";
		$data['mapQA'] = $this->db->query($sql)->result();

		$sql = "select WorkPlace, count(*) as Number
				from tblVMWQuestionnaire as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				where ('$pv' = '' or Code_Prov_N = '$pv')
				and ('$od' = '' or Code_OD_T = '$od')
				group by WorkPlace";
		$data['tableSupervisor'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($data));
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
}