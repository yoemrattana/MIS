<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CaseMonitoring extends MY_Controller
{
	public function index($view = 'casemonitoring_view')
	{
        if (!isset($_SESSION['permiss']['Case Monitoring'])) redirect('Home');

		$data['title'] = 'Case Monitoring';
		$data['main'] = $view;
		$this->load->view('layout', $data);
	}

	public function pf()
	{
        $this->index('casemonitoring_pf_view');
	}

	public function pv()
	{
        $this->index('casemonitoring_pv_view');
	}

	public function getData($type)
	{
		$rs = $this->db->query("SP_CaseMonitoring_$type")->result();

		$this->output->set_output(json_encode($rs));
	}

	public function save()
	{
		$value = $this->input->post();

		$where['Case_Type'] = $value['Case_Type'];
		$where['Case_ID'] = $value['Case_ID'];

		$table = 'tblCaseMonitoring';
		$count = $this->db->where($where)->count_all_results($table);

		$count == 0 ? $this->db->insert($table, $value) : $this->db->update($table, $value, $where);
	}

    public function exportExcel()
    {
        $data = json_decode($this->input->post('data'), true);

        $excel = arrayToExcel($data);

		ob_start();
		$writer = new PHPExcel_Writer_Excel2007($excel);
		$writer->save('php://output');
		header('Content-Length: ' . ob_get_length());
		header('Content-Type: ' . get_mime_by_extension('.xlsx'));
		ob_end_flush();
    }
}