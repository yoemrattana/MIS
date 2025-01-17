<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportDirector extends MY_Controller
{
	public function index()
	{
        if ($_SESSION['role'] != 'AU' ) redirect('Home');

		$data['title'] = "Report For Director";
		$data['main'] = 'reportdirector_view';
		$this->load->view('layout', $data);
	}

	public function getreport($year, $from, $to)
	{
		$data['report1'] = $this->db->query("SP_ReportDirector1 $year, $from, $to")->result();
		$data['report2'] = $this->db->query("SP_ReportDirector2 $year, $from, $to")->result();
		$data['report3'] = $this->db->query("SP_ReportDirector3 $year")->result();
		$data['pop'] = $this->db->query("SP_ReportDirector4 $year")->result();
		$data['report5'] = $this->db->query("SP_ReportDirector5 $year, $from, $to")->result();
		$data['reportWeekly'] = $this->db->query("SP_ReportDirectorWeekly $year")->result();
		$data['weeklyCurrentLastY'] = $this->db->query("SP_ReportDirectorWeeklyCurrentLastYear $year")->result();
		$data['reportPfMix'] = $this->db->query("SP_ReportDirectorPfMix $year")->result();
		$this->output->set_output(json_encode($data));
	}

	public function export()
	{
		$year = $this->input->post('year');
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$data = $this->input->post('data');

		$data = json_decode($data);
		$data->report6 = $this->db->query("SP_ReportDirector6 $year, $to")->result();
		$data = json_encode($data);

		$filepath = FCPATH . "\\temp\\".GUID().'.json';
		file_put_contents($filepath, $data);

		$args['filepath'] = $filepath;
		$args['template'] = FCPATH . '\media\ReportDirector\template.xlsx';
		$args['year'] = $year;
		$args['from'] = $from;
		$args['to'] = $to;
		$args = base64_encode(json_encode($args));

		//$path = 'D:\Projects\MIS Excel\MIS Excel\bin\Release\MISExcel.exe';
		$path = FCPATH . '\media\ExportExcel\MISExcel.exe';
		$filepathOrError = exec("\"$path\" ReportDirector $args");
		if (strpos($filepathOrError, 'Error') === 0) {
			$error = 'MISExcel.exe: ' . base64_decode(explode(':', $filepathOrError)[1]);
			$error = str_replace("\r\n", '<br>', $error);
			show_error($error);
		}
		$this->output->set_header('Content-Length: ' . filesize($filepathOrError));
		$this->output->set_content_type('xlsx');
		$this->output->set_output(file_get_contents($filepathOrError));
		unlink($filepathOrError);
	}
}