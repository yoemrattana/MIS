<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportV2 extends MY_Controller
{
	public function index()
	{
        if (!isset($_SESSION['permiss']['Reports V2'])) redirect('Home');

		$data['title'] = "Reports V2";
		$data['main'] = 'reportv2_view';
		$this->load->view('layout', $data);
	}

	public function getreport()
	{
		$year = $this->input->post('year');
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$report = $this->input->post('report');

		$prov = $_SESSION['prov'];
		$od = $_SESSION['code_od'];

		$rs = $this->db->query("$report $year, $from, $to, '$prov', '$od'")->result();

		$this->output->set_output(json_encode($rs));
	}

	public function exportExcel()
	{
		$year = $this->input->post('year');
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$report = $this->input->post('report');
		$list = json_decode($this->input->post('json'), true);

		$folder = FCPATH . '/media/ReportV2/';
		$template = $folder . "$report.xlsx";

		$this->load->library('PHPExcel');
		$excel = PHPExcel_IOFactory::load($template);
		$sheet = $excel->getActiveSheet();

		$sheet->SetCellValue('A3', "Year: $year");
		$sheet->SetCellValue('A4', "Month: $from-$to");
		$sheet->SetCellValue('A6', 'Extracted Date: ' . date('d/m/Y'));

		if (method_exists($this, $report)) $this->$report($from, $to, $list, $sheet);
		else $this->General($list, $sheet);

		ob_start();
		$writer = new PHPExcel_Writer_Excel2007($excel);
		$writer->save('php://output');
		header('Content-Length: ' . ob_get_length());
		header('Content-Type: ' . get_mime_by_extension('.xlsx'));
		ob_end_flush();
	}

	public function General($list, PHPExcel_Worksheet $sheet)
	{
		$report = $this->input->post('report');
		$length = count($list);

		$rowStart = $sheet->getCell('B2')->getValue();
		if ($rowStart == null) $rowStart = 10;
		else $sheet->setCellValue('B2');

		if ($sheet->getCell('B3')->getValue() == 'remove') {
			$sheet->setCellValue('B3');
			if (55 - $length > 0) $sheet->removeRow($rowStart, 55 - $length);
		} elseif ($length > 2) {
			 $sheet->insertNewRowBefore($rowStart + 1, $length - 2);
		}

		for ($i = 0; $i < $length; $i++)
		{
			$c = 0;
			if (strContain($report, 'RAI4')) $sheet->setCellValueByColumnAndRow($c++, $rowStart + $i, $i + 1);
			foreach ($list[$i] as $v)
			{
				while ($sheet->getCellByColumnAndRow($c, $rowStart + $i)->getValue() != null) $c++;
				$sheet->setCellValueByColumnAndRow($c++, $rowStart + $i, $v);
			}
		}
	}

	public function SP_V2_HFCompleteness($from, $to, $list,PHPExcel_Worksheet $sheet)
	{
		$footer2 = $list[1];
		$list = $list[0];

		$mf = monthToInt($from);
		$mt = monthToInt($to);

		if ($mf == $mt) $sheet->removeColumnByIndex(14);
		for ($m = 12; $m >= 1; $m--)
		{
			if ($m >= $mf && $m <= $mt) continue;
			$sheet->removeColumnByIndex($m + 1);
		}

		$this->General($list, $sheet);

		$colCount = count($footer2);
		for ($i = 0; $i < $colCount; $i++)
		{
		    $sheet->setCellValueByColumnAndRow($i + 2, count($list) + 11, $footer2[$i]);
		}

		$sheet->setCellValue('C8', '# of completed reports submitted from each HF');
		if ($colCount > 1) $sheet->mergeCellsByColumnAndRow(2, 8, $colCount + 1, 8);
		else $sheet->getColumnDimension('C')->setWidth(45);
		$sheet->getStyle('C8')->getAlignment()->setHorizontal('center');
	}

	public function SP_V2_VMWCompleteness($from, $to, $list,PHPExcel_Worksheet $sheet)
	{
		$footer2 = $list[1];
		$list = $list[0];

		$mf = monthToInt($from);
		$mt = monthToInt($to);

		if ($mf == $mt) $sheet->removeColumnByIndex(15);
		for ($m = 12; $m >= 1; $m--)
		{
			if ($m >= $mf && $m <= $mt) continue;
			$sheet->removeColumnByIndex($m + 2);
		}

		$this->General($list, $sheet);

		$colCount = count($footer2);
		for ($i = 0; $i < $colCount; $i++)
		{
			$sheet->setCellValueByColumnAndRow($i + 3, count($list) + 11, $footer2[$i]);
		}

		$sheet->setCellValue('D8', '# of completed reports submitted from each VMW');
		if ($colCount > 1) $sheet->mergeCellsByColumnAndRow(3, 8, $colCount + 2, 8);
		else $sheet->getColumnDimension('D')->setWidth(47);
		$sheet->getStyle('D8')->getAlignment()->setHorizontal('center');
	}

	public function SP_V2_HaveStock($from, $to, $list,PHPExcel_Worksheet $sheet)
	{
		$mf = monthToInt($from);
		$mt = monthToInt($to);

		if ($mf == $mt) {
			$sheet->removeColumnByIndex(29, 24);
			$sheet->removeColumnByIndex(3, 24);
			$mmm = DateTime::createFromFormat('n', $mf)->format('M');
			$sheet->setCellValue('F8', '# HC without stock-out of RDT');
			$sheet->setCellValue('D9', $mmm);
			$sheet->setCellValue('F9', $mmm);
		} else {
			for ($m = 12; $m >= 1; $m--)
			{
				if ($m >= $mf && $m <= $mt) continue;
				$sheet->removeColumnByIndex(($m * 2) + 27, 2);
			}
			for ($m = 12; $m >= 1; $m--)
			{
				if ($m >= $mf && $m <= $mt) continue;
				$sheet->removeColumnByIndex(($m * 2) + 1, 2);
			}
			$sheet->setCellValueByColumnAndRow((($mt - $mf + 2) * 2) + 3, 8, '# HC without stock-out of RDT');
		}
		$sheet->setCellValue('D8', '# HC without stock-out of ACT');

		$this->General($list, $sheet);
	}

	public function SP_V2_RAI4_HFCompleteness($from, $to, $list,PHPExcel_Worksheet $sheet)
	{
		$footer2 = $list[1];
		$list = $list[0];

		$mf = monthToInt($from);
		$mt = monthToInt($to);

		if ($mf == $mt) $sheet->removeColumnByIndex(16);
		for ($m = 12; $m >= 1; $m--)
		{
			if ($m >= $mf && $m <= $mt) continue;
			$sheet->removeColumnByIndex($m + 3);
		}

		$this->General($list, $sheet);

		$colCount = count($footer2);
		for ($i = 0; $i < $colCount; $i++)
		{
		    $sheet->setCellValueByColumnAndRow($i + 3, count($list) + 11, $footer2[$i]);
		}

		$sheet->setCellValue('E8', '# of completed reports submitted from each HF');
		if ($colCount > 2) $sheet->mergeCellsByColumnAndRow(4, 8, $colCount + 2, 8);
		else $sheet->getColumnDimension('E')->setWidth(45);
	}

	public function SP_V2_RAI4_VMWCompleteness($from, $to, $list,PHPExcel_Worksheet $sheet)
	{
		$footer2 = $list[1];
		$list = $list[0];

		$mf = monthToInt($from);
		$mt = monthToInt($to);

		if ($mf == $mt) $sheet->removeColumnByIndex(17);
		for ($m = 12; $m >= 1; $m--)
		{
			if ($m >= $mf && $m <= $mt) continue;
			$sheet->removeColumnByIndex($m + 4);
		}

		$this->General($list, $sheet);

		$colCount = count($footer2);
		for ($i = 0; $i < $colCount; $i++)
		{
			$sheet->setCellValueByColumnAndRow($i + 4, count($list) + 11, $footer2[$i]);
		}

		$sheet->setCellValue('F8', '# of completed reports submitted from each VMW');
		if ($colCount > 2) $sheet->mergeCellsByColumnAndRow(5, 8, $colCount + 3, 8);
		else $sheet->getColumnDimension('F')->setWidth(45);
	}

	public function SP_V2_RAI4_StockACT($from, $to, $list,PHPExcel_Worksheet $sheet)
	{
		$footer2 = $list[1];
		$list = $list[0];

		$mf = monthToInt($from);
		$mt = monthToInt($to);

		if ($mf == $mt) $sheet->removeColumnByIndex(16);
		for ($m = 12; $m >= 1; $m--)
		{
			if ($m >= $mf && $m <= $mt) continue;
			$sheet->removeColumnByIndex($m + 3);
		}

		$this->General($list, $sheet);

		$colCount = count($footer2);
		for ($i = 0; $i < $colCount; $i++)
		{
		    $sheet->setCellValueByColumnAndRow($i + 3, count($list) + 11, $footer2[$i]);
		}
	}

	public function SP_V2_RAI4_StockRDT($from, $to, $list,PHPExcel_Worksheet $sheet)
	{
		$footer2 = $list[1];
		$list = $list[0];

		$mf = monthToInt($from);
		$mt = monthToInt($to);

		if ($mf == $mt) $sheet->removeColumnByIndex(16);
		for ($m = 12; $m >= 1; $m--)
		{
			if ($m >= $mf && $m <= $mt) continue;
			$sheet->removeColumnByIndex($m + 3);
		}

		$this->General($list, $sheet);

		$colCount = count($footer2);
		for ($i = 0; $i < $colCount; $i++)
		{
		    $sheet->setCellValueByColumnAndRow($i + 3, count($list) + 11, $footer2[$i]);
		}
	}
}