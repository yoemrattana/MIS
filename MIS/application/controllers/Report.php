<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['Reports'])) redirect('/Home');

		$data['title'] = 'Reports';
		$data['main'] = 'report_view';
		$this->load->view('layout', $data);
	}

	public function getReport($report)
	{
		$submit = $this->input->post();
		$submit = join("','", array_values($submit));
		$rs = $this->db->query("$report '$submit'")->result_array();
		$this->output->set_output(json_encode($rs));
	}

	public function exportExcel()
	{
		$year = $this->input->post('year');
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$report = $this->input->post('report');
		$list = json_decode($this->input->post('json'), true);
        $type = $this->input->post('type');

        $role = $_SESSION['role'] == 'AU' ? 'AU' : '';
        if ($report == 'SP_V1_StockForecasting') $report = $report.$type.$role;

		$template = FCPATH . "/media/Report/$report.xlsx";

		$this->load->library('PHPExcel');
		$excel = PHPExcel_IOFactory::load($template);
		$sheet = $excel->getActiveSheet();

		$this->$report($year, $from, $to, $list, $sheet);

        ob_start();
        $writer = new PHPExcel_Writer_Excel2007($excel);
        $writer->save('php://output');
        header('Content-Length: ' . ob_get_length());
        //header('Content-Type: ' . get_mime_by_extension('.xlsx'));
        ob_end_flush();
	}

	public function SP_V1_PrimaquineDistribution($year, $from, $to, $list, PHPExcel_Worksheet $sheet)
	{
		$c = 4;
		for ($i = 0; $i < 5; $i++)
		{
			for ($m = 1; $m <= 12; $m++)
			{
				$sheet->setCellValueByColumnAndRow($c++, 2, intToMonth($m).'-'.substr($year, 2));
			}
			$c++;
		}

		$r = 3;
		foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Prov_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_OD_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Facility_E']);

			$c = 4;
			for ($i = 1; $i <= 12; $i++)
			{
				$v1 = PHPExcel_Cell::stringFromColumnIndex($c + 13);
				$v2 = PHPExcel_Cell::stringFromColumnIndex($c + 26);
				$v3 = PHPExcel_Cell::stringFromColumnIndex($c + 39);
				$v4 = PHPExcel_Cell::stringFromColumnIndex($c + 52);
				$sheet->setCellValueByColumnAndRow($c++, $r, "=$v1$r+$v2$r+$v3$r+$v4$r");
			}

			$c = 17;
			for ($i = 1; $i <= 12; $i++)
			{
				$sheet->setCellValueByColumnAndRow($c++, $r, $obj["N$i"]);
			}

			$c = 30;
			for ($i = 1; $i <= 12; $i++)
			{
				$v = PHPExcel_Cell::stringFromColumnIndex($c + 13);
				$sheet->setCellValueByColumnAndRow($c++, $r, "=$v$r*3");
			}

			$c = 43;
			for ($i = 1; $i <= 12; $i++)
			{
				$sheet->setCellValueByColumnAndRow($c++, $r, $obj["B$i"]);
			}

			$c = 56;
			for ($i = 1; $i <= 12; $i++)
			{
				$v1 = PHPExcel_Cell::stringFromColumnIndex($c - 39);
				$v2 = PHPExcel_Cell::stringFromColumnIndex($c - 13);
				$sheet->setCellValueByColumnAndRow($c++, $r, "=IF($v1$r+$v2$r<10,10,0)");
			}

			$r++;
		}
	}

	public function SP_V1_G6PD($year, $from, $to, $list, PHPExcel_Worksheet $sheet)
	{
		$c = 4;
		for ($i = 0; $i < 5; $i++)
		{
			for ($m = 1; $m <= 12; $m++)
			{
				$sheet->setCellValueByColumnAndRow($c++, 2, intToMonth($m).'-'.substr($year, 2));
			}
			$c++;
		}

		$r = 3;
		foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Prov_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_OD_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Facility_E']);

			$c = 4;
			for ($i = 1; $i <= 12; $i++)
			{
				$sheet->setCellValueByColumnAndRow($c++, $r, $obj["N$i"] * 10);
			}

			$c = 17;
			for ($i = 1; $i <= 12; $i++)
			{
				$sheet->setCellValueByColumnAndRow($c++, $r, $obj["N$i"] * 1);
			}

			$c = 30;
			for ($i = 1; $i <= 12; $i++)
			{
				$sheet->setCellValueByColumnAndRow($c++, $r, $obj["N$i"] * 1);
			}

			$c = 43;
			for ($i = 1; $i <= 12; $i++)
			{
				$sheet->setCellValueByColumnAndRow($c++, $r, $obj["N$i"] * 3);
			}

			$c = 56;
			for ($i = 1; $i <= 12; $i++)
			{
				$sheet->setCellValueByColumnAndRow($c++, $r, $obj["N$i"] * 6);
			}

			$r++;
		}
	}

	public function SP_V1_Primaquine($year, $from, $to, $list, PHPExcel_Worksheet $sheet)
	{
		$c = 4;
		for ($i = 0; $i < 5; $i++)
		{
			for ($m = 1; $m <= 12; $m++)
			{
				$sheet->setCellValueByColumnAndRow($c++, 2, intToMonth($m).'-'.substr($year, 2));
			}
			$c++;
		}

		$r = 3;
		foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Prov_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_OD_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Facility_E']);

			$c = 4;
			for ($i = 1; $i <= 12; $i++)
			{
				$sheet->setCellValueByColumnAndRow($c++, $r, $obj["N$i"] * 10);
			}

			$c = 17;
			for ($i = 1; $i <= 12; $i++)
			{
				$sheet->setCellValueByColumnAndRow($c++, $r, $obj["N$i"] * 1);
			}

			$c = 30;
			for ($i = 1; $i <= 12; $i++)
			{
				$sheet->setCellValueByColumnAndRow($c++, $r, $obj["N$i"] * 1);
			}

			$c = 43;
			for ($i = 1; $i <= 12; $i++)
			{
				$sheet->setCellValueByColumnAndRow($c++, $r, $obj["N$i"] * 3);
			}

			$c = 56;
			for ($i = 1; $i <= 12; $i++)
			{
				$sheet->setCellValueByColumnAndRow($c++, $r, $obj["N$i"] * 6);
			}

			$r++;
		}
	}

    public function SP_V1_StockForecastingrdt($year, $from, $to, $list, PHPExcel_Worksheet $sheet)
    {
        $r = 10;
        foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Level']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Province']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['OD']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['HC']);

            $c = 5;
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['RDTNeed']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferRDTOD']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferRDTHC']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferRDTCentral']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['RDTNeed'] + $obj['BufferRDTHC'] + $obj['BufferRDTOD'] +$obj['BufferRDTCentral']);
            $r++;
		}
    }

    public function SP_V1_StockForecastingrdtAU($year, $from, $to, $list, PHPExcel_Worksheet $sheet)
    {
        $sheet->setCellValueByColumnAndRow(5, 9, 'Pop ' . strval($year));
        $sheet->setCellValueByColumnAndRow(6, 9, 'Pop ' . strval($year -1));
        $r = 10;
        foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Level']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Province']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['OD']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['HC']);

            $c = 5;
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['NextPop']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['PrevPop']);
            $sheet->setCellValueByColumnAndRow($c++, $r, round($obj['AberRDT'], 8));
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['RDT']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Microscopy']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Positive']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['RDTNeed']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferRDTOD']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferRDTHC']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferRDTCentral']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['RDTNeed'] + $obj['BufferRDTHC'] + $obj['BufferRDTOD'] +$obj['BufferRDTCentral']);
            $r++;
		}
    }

    public function SP_V1_StockForecastingasmq($year, $from, $to, $list, PHPExcel_Worksheet $sheet)
    {
        $r = 8;
        foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Level']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Province']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['OD']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['HC']);

            $c = 5;
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Need_6m_11m']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Need_1y_6y' ] );
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Need_7y_12y']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Need_gt_12y']);
            $c = 10;
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferOD_6m_11m']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferOD_1y_6y'] );
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferOD_7y_12y']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferOD_gt_12y']);
            $c = 15;
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferHC_6m_11m']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferHC_1y_6y' ] );
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferHC_7y_12y']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferHC_gt_12y']);
            $c = 20;
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferCentral_6m_11m']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferCentral_1y_6y' ] );
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferCentral_7y_12y']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferCentral_gt_12y']);
            $c = 25;
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Need_6m_11m'] +$obj['BufferOD_6m_11m'] + $obj['BufferHC_6m_11m'] +$obj['BufferCentral_6m_11m']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Need_1y_6y'] +$obj['BufferOD_1y_6y']   + $obj['BufferHC_1y_6y' ] +$obj['BufferCentral_1y_6y' ]);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Need_7y_12y'] +$obj['BufferOD_7y_12y'] + $obj['BufferHC_7y_12y'] +$obj['BufferCentral_7y_12y']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Need_gt_12y'] +$obj['BufferOD_gt_12y'] + $obj['BufferHC_gt_12y'] +$obj['BufferCentral_gt_12y']);
            $r++;
		}
    }

    public function SP_V1_StockForecastingasmqAU($year, $from, $to, $list, PHPExcel_Worksheet $sheet)
    {
        $sheet->setCellValueByColumnAndRow(5, 7, 'Pop ' . strval($year));
        $sheet->setCellValueByColumnAndRow(6, 7, 'Pop ' . strval($year -1));
        $r = 8;
        foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Level']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Province']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['OD']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['HC']);

            $c = 5;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['NextPop']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['PrevPop']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Microscopy']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['RDT']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Test']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['ExpectedTest']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Positive']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Test'] >0 ? $obj['Positive']/$obj['Test'] *100 : 0);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['PregnantMTHS']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Severe']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Positive_6m_11m']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Positive_1y_6y']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Positive_7y_12y']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Positive_gt_12y']);

            $c = 20;
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Need_6m_11m']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Need_1y_6y' ] );
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Need_7y_12y']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Need_gt_12y']);
            $c = 25;
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferOD_6m_11m']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferOD_1y_6y'] );
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferOD_7y_12y']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferOD_gt_12y']);
            $c = 30;
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferHC_6m_11m']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferHC_1y_6y' ] );
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferHC_7y_12y']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferHC_gt_12y']);
            $c = 35;
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferCentral_6m_11m']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferCentral_1y_6y' ] );
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferCentral_7y_12y']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['BufferCentral_gt_12y']);
            $c = 40;
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Need_6m_11m'] +$obj['BufferOD_6m_11m'] + $obj['BufferHC_6m_11m'] +$obj['BufferCentral_6m_11m']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Need_1y_6y'] +$obj['BufferOD_1y_6y']   + $obj['BufferHC_1y_6y' ] +$obj['BufferCentral_1y_6y' ]);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Need_7y_12y'] +$obj['BufferOD_7y_12y'] + $obj['BufferHC_7y_12y'] +$obj['BufferCentral_7y_12y']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Need_gt_12y'] +$obj['BufferOD_gt_12y'] + $obj['BufferHC_gt_12y'] +$obj['BufferCentral_gt_12y']);
            $r++;
		}
    }

    public function SP_V1_StockOD($year, $from, $to, $list, PHPExcel_Worksheet $sheet)
    {
		$pv = $this->input->post('pv');
		$od = $this->input->post('od');

		$list = $this->db->query("SP_V1_StockOD '$year','$from','$to','$pv','$od','','','1'")->result_array();

        $r = 2;
        foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Prov_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_OD_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Code']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Description']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Strength']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Unit']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['StockStart']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['StockIn']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['StockStart'] + $obj['StockIn']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['StockOut']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Adjustment']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Balance']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Request']);

			$arr = $obj['ExpireDetail'] == null ? [] : json_decode($obj['ExpireDetail']);
			$arr = array_map(function($r) { return date('d-m-Y',strtotime($r->Date)) . ': ' . $r->Qty; }, $arr);
			$expire = count($arr) == 0 ? '' : '(' . implode(")\n(", $arr) . ')';
            $sheet->setCellValueByColumnAndRow($c++, $r, $expire);

            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['AMC'] ?? 'N/A');

			$MOS = in_array($obj['AMC'], [null, 0]) ? 'N/A' : $obj['Balance'] / $obj['AMC'];
			$sheet->setCellValueByColumnAndRow($c++, $r, $MOS);

            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Note']);
            $r++;
		}
    }

    public function SP_V1_StockHC($year, $from, $to, $list, PHPExcel_Worksheet $sheet)
    {
		$pv = $this->input->post('pv');
		$od = $this->input->post('od');

		$list = $this->db->query("SP_V1_StockHC '$year','$from','$to','$pv','$od','','','1'")->result_array();

        $r = 2;
        foreach ($list as $obj)
        {
            $c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Prov_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_OD_E']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Facility_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Code']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Description']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Strength']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Unit']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['StockStart']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['StockIn']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['StockStart'] + $obj['StockIn']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['StockOut']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Adjustment']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Balance']);

			$arr = $obj['ExpireDetail'] == null ? [] : json_decode($obj['ExpireDetail']);
			$arr = array_map(function($r) { return date('d-m-Y',strtotime($r->Date)) . ': ' . $r->Qty; }, $arr);
			$expire = count($arr) == 0 ? '' : '(' . implode(")\n(", $arr) . ')';
            $sheet->setCellValueByColumnAndRow($c++, $r, $expire);

            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['AMC'] ?? 'N/A');

			$MOS = in_array($obj['AMC'], [null, 0]) ? 'N/A' : $obj['Balance'] / $obj['AMC'];
			$sheet->setCellValueByColumnAndRow($c++, $r, $MOS);

            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Note']);
            $r++;
        }
    }

    public function SP_V1_StockODCompleteness($year, $from, $to, $list, PHPExcel_Worksheet $sheet)
    {
        $r = 2;
        foreach ($list as $obj)
        {
            $c = 0;
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Place']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['01']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['02']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['03']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['04']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['05']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['06']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['07']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['08']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['09']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['10']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['11']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['12']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['CSO']);

            $r++;
        }
    }

    public function SP_V1_StockHFCompleteness($year, $from, $to, $list, PHPExcel_Worksheet $sheet)
    {
        $r = 2;
        foreach ($list as $obj)
        {
            $c = 0;
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Place']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['01']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['02']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['03']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['04']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['05']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['06']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['07']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['08']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['09']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['10']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['11']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['12']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['CSO']);

            $r++;
        }
    }

    public function SP_V1_IntensificationPlan($year, $from, $to, $list, PHPExcel_Worksheet $sheet)
    {
		$mf = intToMonth($from);
		$mt = intToMonth($to);
		$sheet->setCellValue('A2',  "$mf - $mt $year Data");

		$count = count($list);
		if ($count > 1) $sheet->insertNewColumnBefore('F', $count - 1);

		$csos = []; $pvs = []; $ods = []; $hcs = [];
		foreach ($list as $v) {
			$name = $v['CSO'];
			$csos[$name] = isset($csos[$name]) ? $csos[$name] + 1 : 1;

			$name = $v['Name_Prov_E'];
			$pvs[$name] = isset($pvs[$name]) ? $pvs[$name] + 1 : 1;

			$name = $v['Name_OD_E'];
			$ods[$name] = isset($ods[$name]) ? $ods[$name] + 1 : 1;

			$hcs[] = $v['Name_Facility_E'];
		}

		$r = 3; $c = 5;
		foreach ($csos as $k => $v) {
			if ($v > 1) $sheet->mergeCellsByColumnAndRow($c, $r, $c + $v - 1, $r);
			$sheet->setCellValueByColumnAndRow($c, $r, $k);
			$sheet->getStyleByColumnAndRow($c, $r)->getAlignment()->setHorizontal('center');
			$c += $v;
		}

		$r = 4; $c = 5;
		foreach ($pvs as $k => $v) {
			if ($v > 1) $sheet->mergeCellsByColumnAndRow($c, $r, $c + $v - 1, $r);
			$sheet->setCellValueByColumnAndRow($c, $r, $k);
			$sheet->getStyleByColumnAndRow($c, $r)->getAlignment()->setHorizontal('center');
			$c += $v;
		}

		$r = 5; $c = 5;
		foreach ($ods as $k => $v) {
			if ($v > 1) $sheet->mergeCellsByColumnAndRow($c, $r, $c + $v - 1, $r);
			$sheet->setCellValueByColumnAndRow($c, $r, $k);
			$sheet->getStyleByColumnAndRow($c, $r)->getAlignment()->setHorizontal('center');
			$c += $v;
		}

		$r = 6; $c = 5;
		foreach ($hcs as $v) {
			$sheet->setCellValueByColumnAndRow($c, $r, $v);
			$sheet->getStyleByColumnAndRow($c, $r)->getAlignment()->setWrapText(false);
			$sheet->getColumnDimensionByColumn($c)->setAutoSize(true);
			$c++;
		}

		$c = 5;
		foreach ($list as $v) {
			$r = 7;
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['TestAll']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['TestHC']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['TestVMW']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['TestMMW']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['PositiveAll']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['PositiveHC']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['PositiveVMW']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['PositiveMMW']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['Pf']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['Pv']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['Mix']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['PfMixAct']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['LLIN']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['LLIHN']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['MMWNotIP']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['TestMMWNotIP']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['PositiveMMWNotIP']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['PfMMWNotIP']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['PvMMWNotIP']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['MixMMWNotIP']);
			$r += 3;
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['VMW']);
			$r += 2;
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['VMWReported']);
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['MMW']);
			$r += 1;
			$sheet->setCellValueByColumnAndRow($c, $r++, $v['MMWReported']);
			$sheet->setCellValueByColumnAndRow($c, 44, 'Paid Same Day');
			$c++;
		}
    }

	public function SP_V1_InvestigationPopup($year, $from, $to, $list, PHPExcel_Worksheet $sheet)
    {
		$r = 2;
        foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Prov_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_OD_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Facility_E']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Vill_E']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['ReportType']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $year.'-'.$obj['ReportMonth']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Age']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Sex']);

            $sheet->setCellValueByColumnAndRow($c, $r, PHPExcel_Shared_Date::PHPToExcel($obj['DateCase']));
			$sheet->getStyleByColumnAndRow($c++, $r)->getNumberFormat()->setFormatCode('dd-mm-yyyy');

            $sheet->setCellValueByColumnAndRow($c, $r, PHPExcel_Shared_Date::PHPToExcel($obj['EntryDate']));
			$sheet->getStyleByColumnAndRow($c++, $r)->getNumberFormat()->setFormatCode('dd-mm-yyyy hh:mm');

            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Pf']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Pv']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Mix']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Pm']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Po']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Pk']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Relapse']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['L1']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['LC']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['IMP']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Reactive']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['FociNeed']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Foci']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['LastmileVillage']);

            $r++;
		}
    }

	public function SP_V1_InvestigationPopupRai4($year, $from, $to, $list, PHPExcel_Worksheet $sheet)
    {
		$r = 2;
        foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Prov_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_OD_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Facility_E']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Vill_E']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['ReportType']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $year.'-'.$obj['ReportMonth']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Age']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Sex']);

            $sheet->setCellValueByColumnAndRow($c, $r, PHPExcel_Shared_Date::PHPToExcel($obj['DateCase']));
			$sheet->getStyleByColumnAndRow($c++, $r)->getNumberFormat()->setFormatCode('dd-mm-yyyy');

            $sheet->setCellValueByColumnAndRow($c, $r, PHPExcel_Shared_Date::PHPToExcel($obj['EntryDate']));
			$sheet->getStyleByColumnAndRow($c++, $r)->getNumberFormat()->setFormatCode('dd-mm-yyyy hh:mm');

            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Pf']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Pv']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Mix']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Pm']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Po']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Pk']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Relapse']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['L1']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['LC']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['IMP']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Induce']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Reactive']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['FociNeed']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Foci']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Foci7d']);

			if ($obj['FociResponseDate'] != null) {
				$sheet->setCellValueByColumnAndRow($c, $r, PHPExcel_Shared_Date::PHPToExcel($obj['FociResponseDate']));
				$sheet->getStyleByColumnAndRow($c++, $r)->getNumberFormat()->setFormatCode('dd-mm-yyyy');
			}

            $r++;
		}
    }

	public function SP_V1_PopCompleteness($year, $from, $to, $list, PHPExcel_Worksheet $sheet)
    {
		$pv = $this->input->post('pv');
		$od = $this->input->post('od');
		$hc = $this->input->post('hc');
		$vl = $this->input->post('vl');

		$list = $this->db->query("SP_V1_PopCompleteness '$year','$from','$to','$pv','$od','$hc','$vl','1'")->result_array();
		$sheet->fromArray($list, null, 'A2', true);
    }

    public function SP_V1_LastmileSummary($year, $from, $to, $list, PHPExcel_Worksheet $sheet)
    {
		$r = 2;
        foreach ($list as $obj)
		{
            if ($obj['Name_Prov_E'] == 'All') continue;

			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Prov_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_OD_E']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Village']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['House']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Member']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['AFS']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['EligibleTDA']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['TDA']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['EligibleIPT']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['IPT']);
            $r++;
		}
    }

    public function SP_V1_LastMileNoLatLong($year, $from, $to, $list, PHPExcel_Worksheet $sheet) {
        $r = 2;
        foreach ($list as $obj)
		{
			$c = 0;
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Prov_K']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_OD_K']);
			$sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Facility_K']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['Name_Vill_K']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['TotalHouse']);
            $sheet->setCellValueByColumnAndRow($c++, $r, $obj['NoLatLong']);
            $r++;
		}
    }

	public function getInvestDetail()
	{
		$type = $this->input->post('type');
		$id = $this->input->post('id');

		$rs = $this->db->query("SP_V1_InvestigationDetailByVill '$type',$id")->result();
		$this->output->set_output(json_encode($rs));
	}

	public function getPreData()
	{
		$rs = $this->db->query("SP_V1_PredataStockForcasting 2020")->row();
		$this->output->set_output(json_encode($rs));
	}
}