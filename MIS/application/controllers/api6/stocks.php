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
		$lastYear = (int) $year - 1;
		$currentYearStock = $this->getStockItem($hf, $year, $month);
		$lastYearStock = $this->getStockItem($hf, $lastYear, $month);

		$this->load->model('MReport');
		$totalCase = $this->MReport->getTotalCase($hf, $month, $year);
		$hfCase = $this->MReport->getHcTotalCase($hf, $month, $year);
		$vmwCase = $this->MReport->getVmwTotalCase($hf, $month, $year);

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => [
				'total_case' => $totalCase,
				'hc_case' => $hfCase,
				'vmw_case' => $vmwCase,
				'current_year_items' => $currentYearStock,
				'last_year_items' => $lastYearStock,
			]
		];

		$this->response($response);
	}

	private function getStockItem($hf, $year, $month)
    {
        $sql = "SP_StockForm '$hf','$year','$month'";
		$rs = $this->db->query($sql)->result_array();

		$rs = array_map(function($r) {
			$r['MOS'] = $r['AMC'] == 0 ? 'NA' : round($r['Balance'] / $r['AMC'], 1);

			return $r;
		}, $rs);

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
			$rs[$i]['AdjustmentDetail'] = $rs[$i]['AdjustmentDetail'] == null ? [] : json_decode($rs[$i]['AdjustmentDetail']);
			$rs[$i]['ExpireDetail'] = $rs[$i]['ExpireDetail'] == null ? [] : json_decode($rs[$i]['ExpireDetail']);

		    foreach ($rs[$i] as $k => $v)
		    {
		        if ($v === null) $rs[$i][$k] = '';
		    }
		}

		return $rs;
    }

	public function stock_close_post()
	{
		$hf = $this->post('HC_Code');
		$year = $this->post('Year');
		$month = $this->post('Month');

		$data = $this->post('Data');
		if (is_string($data)) $data = json_decode($data);

		foreach ($data as $r)
		{
			$itemId = $r->ItemId;
			$sql = "select count(*) as count
					from tblStockV2
					where Code_Facility_T = '$hf' and Year = '$year' and Month = '$month' and ItemId = $itemId";
			$count = $this->db->query($sql)->row('count');

			$value = [];
			$value['StockStart'] = toInt($r->StockStart);
			$value['StockIn'] = toInt($r->StockIn);
			$value['StockOut'] = toInt($r->StockOut);
			$value['Adjustment'] = toInt($r->Adjustment);
			$value['Estimate'] = toInt($r->Estimate);
			$value['Note'] = $r->Note;
			$value['Expire'] = isset($r->Expire) && !empty($r->Expire)? $r->Expire : null;
			$value['VMWQty'] = 0;

			if (isset($r->AdjustmentDetail)) {
				$value['Adjustment'] = 0;
				foreach ($r->AdjustmentDetail as $d) {
					$value['Adjustment'] += $d->Qty;
					if ($d->Name == 'VMW' && $d->Qty < 0) $value['VMWQty'] += $d->Qty * -1;
				}
				$value['AdjustmentDetail'] = json_encode($r->AdjustmentDetail);
			}
			if (isset($r->ExpireDetail)) $value['ExpireDetail'] = json_encode($r->ExpireDetail);

			$value['Balance'] = $value['StockStart'] + $value['StockIn'] - $value['StockOut'] + $value['Adjustment'];

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