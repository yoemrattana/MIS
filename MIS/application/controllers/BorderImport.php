<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BorderImport extends MY_Controller
{
	public function index()
	{
		if ($_SESSION['role'] != 'AU') redirect('Home');

		$data['title'] = "Import Border Data";
		$data['main'] = 'borderimport_view';
		$this->load->view('layout', $data);
	}

	public function getData()
	{
		$sql = "select distinct YearMonth from tblBorderData order by YearMonth desc";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function importExcel()
	{
		$base64 = $this->input->post('base64');
		$tempName = TEMPPATH . GUID() . '.xlsx';
		file_put_contents($tempName, base64_decode($base64));

		$this->load->library('PHPExcel');
        $excel = PHPExcel_IOFactory::load($tempName);

		$data = $excel->getActiveSheet()->toArray();
		if (count($data) > 1) {
			for ($i = 1; $i < count($data); $i++)
			{
				$ct = substr($data[$i][1], 0, 1);
				$row = [
					'Country' => $ct == 'T' ? 'Thailand' : ($ct == 'L' ? 'Lao' : 'Vietnam'),
					'PlaceCode' => $data[$i][7],
					'YearMonth' => $data[$i][9],
					'Test' => $data[$i][13] ?? 0,
					'Pf' => $data[$i][15] ?? 0,
					'Pv' => $data[$i][16] ?? 0,
					'Mix' => $data[$i][17] ?? 0,
					'Other' => $data[$i][18] ?? 0
				];
				$row['Positive'] = $row['Pf'] + $row['Pv'] + $row['Mix'] + $row['Other'];
				$table[] = $row;
			}

			$this->db->insert_batch('tblBorderData', $table);
		}

		unlink($tempName);
		$this->getData();
	}

    public function getList()
    {
        $yearMonth = $this->input->post('yearMonth');
        $rs = $this->db->get_where('tblBorderData', ['YearMonth' => $yearMonth])->result();

		$this->output->set_output(json_encode($rs));
    }
}