<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PivotChart extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['Pivot Table'])) redirect('/Home');

		$data['title'] = 'Pivot Table';
		$data['main'] = 'pivotchart_view';
		$this->load->view('layout', $data);
	}

	public function getData()
	{
        ini_set('memory_limit', '-1');
        $type = $this->input->post('type');
        $name = $this->input->post('name');

		if ($_SERVER['SERVER_NAME'] == 'localhost') {
			$year = substr($name, 0, 4);
			$month = substr($name, 4);
			$rs = $this->db->query("SP_Pivot_$type $year,$month")->result();
			$rs = json_encode($rs);
		} else {
			$rs = file_get_contents("C:/MIS/Pivot Data/$type/$name.json");
		}

		$this->output->set_output($rs);
	}

	public function exportExcel()
	{
		$data = $this->input->post('data');

		$filepath = FCPATH . "\\temp\\".GUID().'.json';
		file_put_contents($filepath, $data);

		$path = FCPATH . '\media\ExportExcel\MISExcel.exe';
		$filepathOrError = exec("\"$path\" PivotChart \"$filepath\"");
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