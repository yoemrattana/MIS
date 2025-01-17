<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Stocks extends REST_Controller
{
	public function stock_form_post()
	{
		$hf = $this->post('HC_Code');
		$year = $this->post('Year');
		$month = $this->post('Month');

		$sql = "SP_StockForm '$hf','$year','$month'";
		$rs = $this->db->query($sql)->result_array();

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

		$num = 0;
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
			$num++;
		}
		$this->db->query("SP_StockHCRecalculate '$hf','$year','$month'");

		$this->response(['inserted_row' => $num]);
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