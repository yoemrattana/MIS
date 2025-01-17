<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Stocks extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function stock_form_post()
	{
		$hf = $this->post('HC_Code');
		$year = $this->post('Year');
		$month = $this->post('Month');

		$sql = "SP_StockForm '$hf','$year','$month'";
		$rs = $this->db->query($sql)->result_array();

		$sql = "select Code_Facility_T, Type_Facility, Type_Facility, b.IP2, Is_Radical_Cure
				from tblHFCodes as a
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

		for ($i = 0; $i < count($rs); $i++)
		{
			foreach ($rs[$i] as $k => $v)
			{
		        if ($v === null) $rs[$i][$k] = '';
			}
		}
		
		$this->response($rs);
	}

	public function stock_close_post()
	{
		$hf = $this->post('HC_Code');
		$year = $this->post('Year');
		$month = $this->post('Month');
		$data = json_decode($this->post('Data'));

		foreach ($data as $r)
		{
			$itemId = $r->ItemId;
			$sql = "select count(*) as count from tblStockV2
					where Code_Facility_T = '$hf' and Year = '$year' and Month = '$month' and ItemId = $itemId";
			$count = $this->db->query($sql)->row('count');

			$value = [];
			$value['StockStart'] = $r->StockStart;
			$value['StockIn'] = $r->StockIn;
			$value['StockOut'] = $r->StockOut;
			$value['Adjustment'] = $r->Adjustment;
			$value['Balance'] = toInt($r->Balance);
			$value['Estimate'] = toInt($r->Estimate);
			$value['Note'] = $r->Note;
			$value['Expire'] = isset($r->Expire) && !empty($r->Expire)? $r->Expire : null;

			if ($count == 0) {
				$value['Code_Facility_T'] = $hf;
				$value['Year'] = $year;
				$value['Month'] = $month;
				$value['ItemId'] = $itemId;
				$value['InitUser'] = $hf;
				$this->db->insert('tblStockV2', $value);
			} else {
				$value['ModiUser'] = $hf;
				$value['ModiTime'] = sqlNow();

				$where = [];
				$where['Code_Facility_T'] = $hf;
				$where['Year'] = $year;
				$where['Month'] = $month;
				$where['ItemId'] = $itemId;
				$this->db->update('tblStockV2', $value, $where);
			}
		}
		$this->db->query("SP_StockHCRecalculate '$hf','$year','$month'");

		$this->response(['inserted_row' => 1]);
	}

	public function request_post()
	{
		$hf = $this->post('HC_Code');
		$itemId = $this->post('ItemId');
		$num = $this->post('Num');
		$year = date('Y');
		$month = date('m');

		$sql = "select isnull(RequestTotal,0) as RequestTotal from tblStockV2
				where Code_Facility_T = '$hf' and Year = '$year' and Month = '$month' and ItemId = $itemId";
		$row = $this->db->query($sql)->row();

		$value['Request'] = $num;
		$value['Status'] = 'Requested';

		if ($row == null){
			$value['Code_Facility_T'] = $hf;
			$value['Year'] = $year;
			$value['Month'] = $month;
			$value['ItemId'] = $itemId;
			$value['RequestTotal'] = $num;
			$this->db->insert('tblStockV2', $value);
		} else {
			$where['Code_Facility_T'] = $hf;
			$where['Year'] = $year;
			$where['Month'] = $month;
			$where['ItemId'] = $itemId;
			$value['RequestTotal'] = $row->RequestTotal + $num;
			$this->db->update('tblStockV2', $value, $where);
		}
		$this->response(['updated_row' => 1]);
	}

	public function receive_post()
	{
		$hf = $this->post('HC_Code');
		$itemId = $this->post('ItemId');
		$num = $this->post('Num');
		$year = date('Y');
		$month = date('m');

		$sql = "select isnull(StockIn,0) as StockIn, isnull(ReceiveTotal,0) as ReceiveTotal, Balance from tblStockV2
				where Code_Facility_T = '$hf' and Year = '$year' and Month = '$month' and ItemId = $itemId";
		$row = $this->db->query($sql)->row();

		$value['StockIn'] = $row->StockIn + $num;
		$value['Request'] = null;
		$value['Receive'] = $num;
		$value['ReceiveTotal'] = $row->ReceiveTotal + $num;
		$value['Status'] = 'Received';
		if ($row->Balance != null) {
			$value['Balance'] = $row->Balance + $num;
		}

		if ($row == null){
			$value['Code_Facility_T'] = $hf;
			$value['Year'] = $year;
			$value['Month'] = $month;
			$value['ItemId'] = $itemId;
			$this->db->insert('tblStockV2', $value);
		} else {
			$where['Code_Facility_T'] = $hf;
			$where['Year'] = $year;
			$where['Month'] = $month;
			$where['ItemId'] = $itemId;
			$this->db->update('tblStockV2', $value, $where);
		}
		$this->response(['updated_row' => 1]);
	}

	public function cancel_post()
	{
		$hf = $this->post('HC_Code');
		$itemId = $this->post('ItemId');
		$year = date('Y');
		$month = date('m');

		$sql = "select count(*) as count from tblStockV2
				where Code_Facility_T = '$hf' and Year = '$year' and Month = '$month' and ItemId = $itemId";
		$count = $this->db->query($sql)->row('count');

		$value['Request'] = null;
		$value['Status'] = 'Canceled';

		if ($count == 0){
			$value['Code_Facility_T'] = $hf;
			$value['Year'] = $year;
			$value['Month'] = $month;
			$value['ItemId'] = $itemId;
			$this->db->insert('tblStockV2', $value);
		} else {
			$where['Code_Facility_T'] = $hf;
			$where['Year'] = $year;
			$where['Month'] = $month;
			$where['ItemId'] = $itemId;
			$this->db->update('tblStockV2', $value, $where);
		}
		$this->response(['updated_row' => 1]);
	}
}