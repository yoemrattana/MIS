<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends MY_Controller
{
	public function request()
	{
        if (!isset($_SESSION['permiss']['Stock Request'])) redirect('Home');

		$data['title'] = "Stock Request";
		$data['main'] = 'stockrequest_view';
		$this->load->view('layout', $data);
	}

	public function report()
	{
		if (!isset($_SESSION['permiss']['Stock Data'])) redirect('Home');

		$permiss = $_SESSION['permiss']['Stock Data'];
		if (!in_array('Stock OD', $permiss) && !in_array('Stock HC', $permiss) && !in_array('Stock VMW', $permiss)) redirect('Home');

		$data['title'] = "Stock Report";
		$data['main'] = 'stockreport_view';
		$this->load->view('layout', $data);
	}

	public function reportCNM()
	{
		if (!isset($_SESSION['permiss']['CNM Stock Data'])) redirect('Home');

		$data['title'] = "CNM Stock Report";
		$data['main'] = 'stockreportcnm_view';
		$this->load->view('layout', $data);
	}

	public function item()
	{
        if ( $_SESSION['role'] != 'AU' ) redirect('Home');

		$data['title'] = "Stock Item";
		$data['main'] = 'stockitem_view';
		$this->load->view('layout', $data);
	}

	public function getRequest()
	{
		$prov = $_SESSION['code_prov'];
		$od = $_SESSION['code_od'];

		$where = 'where Status is not null';
		if ($od != '') $where .= " and Code_OD_T = '$od'";
		elseif ($prov != '') $where .= " and Code_Prov_T in ('$prov')";

		$sql = "select distinct Code_Prov_T, Name_Prov_E, Code_OD_T, Name_OD_E, Name_Facility_E, a.Code_Facility_T, Year, Month, Status
				from tblStockV2 as a
				join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
				join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
				$where
				order by Name_Prov_E, Name_OD_E, Name_Facility_E, Year, Month";
		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function getDetail()
	{
		$hf = $this->input->post('hf');
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$sql = "SP_StockForm '$hf','$year','$month'";
		$rs = $this->db->query($sql)->result_array();

		$sql = "select Code_Facility_T, Type_Facility, Type_Facility, b.IP2,  Is_Radical_Cure from tblHFCodes as a
				left join tblCensusVillage as b on b.HCCode = a.Code_Facility_T and b.IP2 = 1
				left join tblOD as c on a.Code_OD_T = c.Code_OD_T and c.Is_Radical_Cure = 1
				where Code_Facility_T = '{$hf}'";
		$hc = $this->db->query($sql)->row_array();

		$radicalCureItems = ['G6PD'];
		$IP2Items = ['Repellent', 'Forest pack', 'Mebendazole', 'Paracetamol'];
		$RHPHNHItems = ['Quinine Dihydrochloride', 'Artesunate powder 60mg/ml/vial + solution sodium bicarbonate 5% ampoule/ml (IM+IV)'];

		if (!$hc['Is_Radical_Cure']) {
			$rs = notInArray($rs, $radicalCureItems, 'Description');
		}

		if (!$hc['IP2']) {
		    $rs = notInArray($rs, $IP2Items, 'Description');
		}

		if ($hc['Type_Facility'] == 'HC') {
		    $rs = notInArray($rs, $RHPHNHItems, 'Description');
		}

		$this->output->set_output(json_encode($rs));
	}

	public function offer()
	{
		$id = $this->input->post('id');
		$offer = $this->input->post('offer');
		$comment = $this->input->post('comment');

		$sql = "update tblStockV2
				set Offer = $offer, OfferTotal = isnull(OfferTotal,0) + $offer, Status = 'Offered', Comment = '$comment', CommentDate = getdate()
				where Rec_ID = $id";
		$this->db->query($sql);
	}

	public function getPreData()
	{
		$prov = $this->input->post('prov');
		$od = $_SESSION['code_od'];

		$sql = "select distinct HCCode from tblCensusVillage where HaveVMW = 1";
		$rs['hcHasVMW'] = array_column($this->db->query($sql)->result(), 'HCCode');

		$sql = "select a.Code_OD_T
				from tblOD as a
				join (
					select distinct Code_OD_T
					from tblHFCodes
					where Code_Prov_N = '$prov' or Code_OD_T = '$od'
				) as b on a.Code_OD_T = b.Code_OD_T
				where Is_Radical_Cure = 1 and IsTarget = 1";
		$rs['radicalCure'] = array_column($this->db->query($sql)->result(), 'Code_OD_T');

		$sql = "select distinct Code_OD_T, Code_Facility_T
				from tblHFCodes
				where IP2 = 1 and (Code_Prov_N = '$prov' or Code_OD_T = '$od')";
		$rs['IP2'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getCaseData()
	{
		$prov = $this->input->post('prov');
		$year = $this->input->post('year');
		$od = $_SESSION['code_od'];

		$sql = "select Code_OD_T, Code_Facility_T, Month, sum(iif(Positive='P',1,0)) as Positive, sum(iif(Positive='P' and Type='HF' ,1,0)) as PositiveHF,
				sum(iif(Positive='P' and Type='VMW' ,1,0)) as PositiveVMW , count(*) as Test, sum(iif(Type='HF',1,0)) as TestHF, sum(iif(Type='VMW',1,0)) as TestVMW,
				sum(RDT) as RDT,sum(Microscopy) as Microscopy
				from (
					select Year, Month, ID as HCCode, Positive, RDT, Microscopy, 'HF' as Type from tblHFActivityCases union all
					select Year, Month, HCCode, Positive, 1 as RDT, 0 as Microscopy, 'VMW' as Type from tblVMWActivityCases as a join tblCensusVillage as b on a.ID = b.Code_Vill_T
				) as a
				join tblHFCodes as b on a.HCCode = b.Code_Facility_T
				where Year = '$year' and (Code_Prov_N = '$prov' or Code_OD_T = '$od')
				group by Code_OD_T, Code_Facility_T, Month";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getReportOD()
	{
		$prov = $this->input->post('prov');
		$year = $this->input->post('year');
		$od = $_SESSION['code_od'];

		$sql = "select Code_OD_T, Name_OD_E, Name_OD_K
				from tblOD
				where (Code_Prov_T = '$prov' or Code_OD_T = '$od') and IsTarget is not null
				order by Name_OD_E";
		$rs['ods'] = $this->db->query($sql)->result();

		$sql = "select distinct a.Code_OD_T, Month
		        from tblStockOD as a
				join (
					select Code_OD_T
					from tblOD
					where (Code_Prov_T = '$prov' or Code_OD_T = '$od') and IsTarget is not null
				) as b on a.Code_OD_T = b.Code_OD_T
		        where Year = '$year' and Balance is not null";
		$rs['reportODs'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getReportHF()
	{
		$od = $this->input->post('od');
		$year = $this->input->post('year');

		$sql = "select a.Code_Facility_T, Name_Facility_E , Name_Facility_K, Type_Facility, Month, IsReminder
				from tblHFCodes as a
				join V_HFLog as b on a.Code_Facility_T = b.Code_Facility_T
				where Code_OD_T = '$od' and Year = '$year' and Type_Facility <> 'HP'
				order by Name_Facility_E";
		$rs['hfs'] = $this->db->query($sql)->result();

		$sql = "select distinct b.Code_Facility_T, b.Month
				from tblHFCodes as a join tblStockV2 as b on a.Code_Facility_T = b.Code_Facility_T
				where Code_OD_T = '$od' and Year = '$year' and Balance is not null";
		$rs['reportHFs'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getReportVMW()
	{
		$hc = $this->input->post('hc');
		$year = $this->input->post('year');

		$sql = "select a.Code_Vill_T, Name_Vill_E , Name_Vill_K, Month
				from tblCensusVillage as a
				join V_VMWLog as b on a.Code_Vill_T = b.Code_Vill_T
				where HCCode = '$hc' and Year = '$year' and HaveVMW = 1
				order by Name_Vill_E";
		$rs['vmws'] = $this->db->query($sql)->result();

		$sql = "select distinct b.Code_Vill_T, b.Month
				from tblCensusVillage as a join tblStockVMW as b on a.Code_Vill_T = b.Code_Vill_T
				where HCCode = '$hc' and Year = '$year' and Balance is not null";
		$rs['reportVMWs'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getReportCNM()
	{
		$year = $this->input->post('year');

		$sql = "select Month from tblStockCNM
		        where Year = '$year' and Balance is not null";
		$rs['reports'] = $this->db->query($sql)->result();

		$sql = "select Month, sum(iif(Positive='P',1,0)) as Positive, count(*) as Test
				from (
					select Year, Month, Positive from tblHFActivityCases union all
					select Year, Month, Positive from tblVMWActivityCases
				) as a
				where Year = '$year'
				group by Month";
		$rs['cases'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getReportDetailOD()
	{
		$code = $this->input->post('code');
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$sql = "SP_StockOD '$code','$year','$month'";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getReportDetailHF()
	{
		$code = $this->input->post('code');
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$sql = "SP_StockHC '$code','$year','$month'";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getReportDetailVMW()
	{
		$code = $this->input->post('code');
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$sql = "SP_StockVMW '$code','$year','$month'";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getReportDetailCNM()
	{
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$sql = "SP_StockCNM '$year','$month'";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveStockOD()
	{
		$submit = json_decode($this->input->post('submit'));
		foreach ($submit as $r)
		{
			if ($r->Rec_ID == 0) {
				$r->InitUser = $_SESSION['username'];
				unset($r->Rec_ID);
				$this->db->insert('tblStockOD', $r);
			} else {
				$r->ModiUser = $_SESSION['username'];
				$r->ModiTime = sqlNow();
				$where['Rec_ID'] = $r->Rec_ID;
				unset($r->Rec_ID);
				$this->db->update('tblStockOD', $r, $where);
			}
		}

		$od = $submit[0]->Code_OD_T;
		$year = $submit[0]->Year;
		$month = $submit[0]->Month;
		$this->db->query("SP_StockODRecalculate '$od','$year','$month'");
	}

	public function saveStockHF()
	{
		$submit = json_decode($this->input->post('submit'));
		foreach ($submit as $r)
		{
			$r->Expire = $r->Expire == 'Invalid date' ? null : $r->Expire;
			if ($r->Rec_ID == 0) {
				$r->InitUser = $_SESSION['username'];
				unset($r->Rec_ID);
				$this->db->insert('tblStockV2', $r);
			} else {
				$r->ModiUser = $_SESSION['username'];
				$r->ModiTime = sqlNow();
				$where['Rec_ID'] = $r->Rec_ID;
				unset($r->Rec_ID);
				$this->db->update('tblStockV2', $r, $where);
			}
		}

		$hc = $submit[0]->Code_Facility_T;
		$year = $submit[0]->Year;
		$month = $submit[0]->Month;
		$this->db->query("SP_StockHCRecalculate '$hc','$year','$month'");
	}

	public function saveStockVMW()
	{
		$submit = json_decode($this->input->post('submit'));
		foreach ($submit as $r)
		{
			$r->Expire = $r->Expire == 'Invalid date' ? null : $r->Expire;
			if ($r->Rec_ID == 0) {
				$r->InitUser = $_SESSION['username'];
				unset($r->Rec_ID);
				$this->db->insert('tblStockVMW', $r);
			} else {
				$r->ModiUser = $_SESSION['username'];
				$r->ModiTime = sqlNow();
				$where['Rec_ID'] = $r->Rec_ID;
				unset($r->Rec_ID);
				$this->db->update('tblStockVMW', $r, $where);
			}
		}

		$vmw = $submit[0]->Code_Vill_T;
		$year = $submit[0]->Year;
		$month = $submit[0]->Month;
		$this->db->query("SP_StockVMWRecalculate '$vmw','$year','$month'");
	}

	public function saveStockCNM()
	{
		$submit = json_decode($this->input->post('submit'));
		foreach ($submit as $r)
		{
			if ($r->Rec_ID == 0) {
				unset($r->Rec_ID);
				$this->db->insert('tblStockCNM', $r);
			} else {
				$where['Rec_ID'] = $r->Rec_ID;
				unset($r->Rec_ID);
				$this->db->update('tblStockCNM', $r, $where);
			}
		}

		$year = $submit[0]->Year;
		$month = $submit[0]->Month;
		$this->db->query("SP_StockCNMRecalculate '$year','$month'");
	}

	public function getItem()
	{
		$sql = "select * from tblStockItems order by Sort";
		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function saveItem()
	{
		$value = $this->input->post();
		if ($value['Id'] == 0) {
			unset($value['Id']);
            $value['InitTime'] = sqlNow();
			$this->db->insert('tblStockItems', $value);
			$this->output->set_output($this->db->insert_id());
		} else {
			$where['Id'] = $value['Id'];
			unset($value['Id']);
			$this->db->update('tblStockItems', $value, $where);
		}
	}

    public function exportExcel()
    {
		$report = $this->input->post('report');
        $master = json_decode($this->input->post('master'));
		$details = json_decode($this->input->post('details'), true);

		$folder = FCPATH . '/media/Stock/';
		$template = $folder . "$report.xlsx";

		$this->load->library('PHPExcel');
		$excel = PHPExcel_IOFactory::load($template);
		$sheet = $excel->getActiveSheet();

		$this->$report($master, $details, $sheet, $excel);

		ob_start();
		$writer = new PHPExcel_Writer_Excel2007($excel);
		$writer->save('php://output');
		header('Content-Length: ' . ob_get_length());
		//header('Content-Type: ' . get_mime_by_extension('.xlsx'));
		ob_end_flush();
    }

    private function od($master, $details, $sheet, $excel)
    {
        $sheet->setCellValueByColumnAndRow(2, 1, $master->odkh);
        $sheet->setCellValueByColumnAndRow(2, 2, $master->month);
        $sheet->setCellValueByColumnAndRow(2, 3, $master->positive);
        $sheet->setCellValueByColumnAndRow(2, 4, $master->test);
        $sheet->setCellValueByColumnAndRow(2, 5, $master->rdt);
        $sheet->setCellValueByColumnAndRow(2, 6, $master->microscopy);

        $r = 9;
        foreach ($details as $obj)
        {
            $c = 0;
            $sheet->setCellValueByColumnAndRow($c++, $r, $r - 8);
            foreach($obj as $v)
			{
                $sheet->setCellValueByColumnAndRow($c++, $r, $v);
            }
            $r++;
        }
    }

    private function hf($master, $details, $sheet, $excel)
    {
        $sheet->setCellValueByColumnAndRow(2, 1, $master->odkh);
        $sheet->setCellValueByColumnAndRow(2, 2, $master->kh);
        $sheet->setCellValueByColumnAndRow(2, 3, $master->month);
        $sheet->setCellValueByColumnAndRow(2, 4, $master->positive);
        $sheet->setCellValueByColumnAndRow(2, 5, $master->test);
        $sheet->setCellValueByColumnAndRow(2, 6, $master->rdt);
        $sheet->setCellValueByColumnAndRow(2, 7, $master->microscopy);

        $r = 10;
        foreach ($details as $obj)
        {
            $c = 0;
            $sheet->setCellValueByColumnAndRow($c++, $r, $r - 9);
            foreach ($obj as $v)
            {
                $sheet->setCellValueByColumnAndRow($c++, $r, $v);
            }
            $r++;
        }
    }

	private function vmw($master, $details, $sheet, $excel)
    {
        $sheet->setCellValueByColumnAndRow(2, 1, $master->odkh);
        $sheet->setCellValueByColumnAndRow(2, 2, $master->hckh);
        $sheet->setCellValueByColumnAndRow(2, 3, $master->kh);
        $sheet->setCellValueByColumnAndRow(2, 4, $master->month);

        $r = 7;
        foreach ($details as $obj)
        {
            $c = 0;
            $sheet->setCellValueByColumnAndRow($c++, $r, $r - 6);
            foreach ($obj as $v)
            {
                $sheet->setCellValueByColumnAndRow($c++, $r, $v);
            }
            $r++;
        }
    }

	public function deleteStock()
	{
		$submit = json_decode($this->input->post('submit'), true);

		$this->db->delete($submit['table'], $submit['where']);

        if($submit['table'] == 'tblStockOD') {
            $code = 'Code_OD_T';
            $module = 'stock od';
        }
        else if($submit['table'] == 'tblStockV2') {
            $code = 'Code_Facility_T';
            $module = 'stock hc';
        }
        else if($submit['table'] == 'tblStockCNM') {
            $code = 'cnm';
            $module = 'stock cnm';
        }
        else {
            $code = 'Code_Vill_T';
            $module = 'stock vmw';
        }

		$row = [
			'Module' => $module,
			'Month'	 => $submit['where']['Month'],
			'Year'	 => $submit['where']['Year'],
			'Place'	 => $submit['where'][$code]
		];

        $this->load->model('Log_model');
        $this->Log_model->deleteStock($row);
	}
}