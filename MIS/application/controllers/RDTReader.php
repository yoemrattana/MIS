<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RDTReader extends MY_Controller
{
	public function index($show = 0)
	{
		if (!isset($_SESSION['permiss']['RDT Reader'])) redirect('/Home');

		$data['title'] = 'RDT Reader';
		$data['main'] = 'RDTReader_view';
		$data['show'] = $show;

		$this->load->view('layout', $data);
	}

	public function getData()
	{
		$sql = "select * from tblMalariaRDT order by InitTime Desc";
		$rs['data'] = $this->db->query($sql)->result();

		$arr = $this->db->field_data('tblMalariaRDT');
		$model = [];
		foreach ($arr as $v) {
			$model[$v->name] = $v->type == 'nvarchar' ? '' : null;
		}
		unset($model['InitUser']);
		unset($model['InitTime']);
		unset($model['ModiUser']);
		unset($model['ModiTime']);
		$rs['model'] = $model;

		$this->output->set_output(json_encode($rs));
	}

	public function save()
	{
		$value = json_decode($this->input->post('submit'), true);

		$id = $value['post_id'];
		unset($value['post_id']);

		if ($value['image'] != null && !strContain($value['image'], '.jpg')) {
			$dir = FCPATH.'/media/MalariaRDT';
			if (!file_exists($dir)) mkdir($dir);
			$filename = GUID().'.jpg';
			file_put_contents($dir.'/'.$filename, base64_decode(explode(',', $value['image'])[1]));
			$value['image'] = $filename;
		}

		if ($id == null) {
			$id = uniqid('test_');
			$value['post_id'] = $id;
			$value['image_file_name'] = $filename;
			$value['InitTime'] = sqlNow();
			$value['InitUser'] = $_SESSION['username'];
		    $this->db->insert('tblMalariaRDT', $value);
		} else {
		    $value['ModiUser'] = $_SESSION['username'];
		    $value['ModiTime'] = sqlNow();
		    $where['post_id'] = $id;
		    $this->db->update('tblMalariaRDT', $value, $where);
		}

		$sql = "select * from tblMalariaRDT where post_id = '{$id}'";
		$rs = $this->db->query($sql)->row();

		$this->output->set_output(json_encode($rs));
	}

	public function report()
	{
		$data['title'] = 'RDT Reader Report';
		$data['main'] = 'RDTReaderReport_view';
		$this->load->view('layout', $data);
	}

	public function getReport()
    {
		$sql = "select patient_id
					  ,scan_time as ScanTime
				from tblMalariaRDT";
		$rs['diffRDT'] = $this->db->query($sql)->result();

		$sql = "select ParticipantCode
					  ,TestingDate as User1Date
					  ,InterpretationTime as User1Time
				from tblCRFRDTUser1";
		$rs['diffUser'] = $this->db->query($sql)->result();

		$sql = "select Code, AVG(Qty * 1.0) as Avg
				from (
					select SUBSTRING(patient_id,6,2) as Code, count(*) as Qty
					from tblMalariaRDT
					group by patient_id
					having count(*) > 1
				) as a
				group by Code";
		$rs['duplicate'] = $this->db->query($sql)->result();

		$sql = "select SUBSTRING(patient_id,6,2) as code, patient_id, error
				from tblMalariaRDT";
		$rs['error'] = $this->db->query($sql)->result();

		$sql = "select isnull(a.SiteCode,b.SiteCode) as SiteCode
					  ,isnull(a.Year,b.Year) + isnull(a.Month,b.Month) as Month
					  ,isnull(Test,0) as Test
					  ,isnull(Positive,0) as Positive
					  ,isnull(Pf,0) as Pf
					  ,isnull(Pv,0) as Pv
					  ,isnull(Mix,0) as Mix
					  ,isnull(PatientCount,0) as PatientCount
				from (
					select SiteCode, Year, Month
						  ,count(*) as Test
						  ,sum(iif(Diagnosis = 'N',0,1)) as Positive
						  ,sum(iif(Diagnosis = 'F',1,0)) as Pf
						  ,sum(iif(Diagnosis = 'V',1,0)) as Pv
						  ,sum(iif(Diagnosis = 'M',1,0)) as Mix
					from tblHFActivityCases as a
					join tblHFCodes as b on a.ID = b.Code_Facility_T
					join tblMalariaRDTSite as c on b.Code_Facility_T = c.Code_Facility_T
					where Year + Month >= '202007'
					group by SiteCode, Year, Month
				) as a
				full join (
					select substring(patient_id,6,2) as SiteCode
						  ,year(InitTime) as Year
						  ,month(InitTime) as Month
						  ,count(distinct patient_id) as PatientCount
					from tblMalariaRDT
					group by substring(patient_id,6,2), year(InitTime), month(InitTime)
				) as b on a.SiteCode = b.SiteCode and a.Year = b.Year and a.Month = b.Month";
		$rs['monthCount'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
    }

	public function pcr()
	{
		$data['title'] = 'RDT Reader PCR';
		$data['main'] = 'RDTReaderPCR_view';
		$this->load->view('layout', $data);
	}

	public function getPCR()
    {
		$this->load->library('PHPExcel');
		$excel = PHPExcel_IOFactory::load(FCPATH . '/media/PCR/CNM_FIND_PCR_Species.xlsx');
		$sheet = $excel->getActiveSheet();

		$rs = [];
		for ($i = 2; true; $i++)
		{
			$row = [];
			for ($c = 1; $c < 11; $c++)
			{
				$row[] = $sheet->getCellByColumnAndRow($c, $i)->getValue();
			}
			if ($row[0] == null) break;
			$rs[] = $row;
		}

		$this->output->set_output(json_encode($rs));
    }

	public function getImage($filename)
	{
		$filepath = FCPATH . "/media/MalariaRDT/$filename";
		header('Content-Type: ' . get_mime_by_extension('.jpg'));
		imagejpeg(imagecreatefromjpeg($filepath), null, 30);
	}
}