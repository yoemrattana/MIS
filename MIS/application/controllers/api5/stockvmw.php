<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class StockVMW extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function stock_form_post()
	{
		$vmw = $this->post('Village_Code');
		$year = $this->post('Year');
		$month = $this->post('Month');

		$sql = "SP_StockFormVMW '$vmw','$year','$month'";
		$rs = $this->db->query($sql)->result_array();

		$rs = array_map(function($r) {
			$r['MOS'] = $r['AMC'] == 0 ? 'NA' : round($r['Balance'] / $r['AMC'], 1);
			return $r;
		}, $rs);

		for ($i = 0; $i < count($rs); $i++)
		{
		    foreach ($rs[$i] as $k => $v)
		    {
		        if ($v === null) $rs[$i][$k] = '';
		    }
		}

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => [
				'items' => $rs
			]
		];

		$this->response($response);
	}

	public function stock_close_post()
	{
		$vmw = $this->post('Village_Code');
		$year = $this->post('Year');
		$month = $this->post('Month');
		$data = $this->post('Data');

		foreach ($data as $r)
		{
			if (!isset($r['ItemId'])) continue;

			$itemId = $r['ItemId'];
			$sql = "select count(*) as count
					from tblStockVMW
					where Code_Vill_T = '$vmw' and Year = '$year' and Month = '$month' and ItemId = $itemId";
			$count = $this->db->query($sql)->row('count');

			$value = [];
			$value['StockStart'] = $r['StockStart'];
			$value['StockIn'] = $r['StockIn'];
			$value['StockOut'] = $r['StockOut'];
			$value['Adjustment'] = $r['Adjustment'];
			$value['Balance'] = toInt($r['StockStart']) + toInt($r['StockIn']) - toInt($r['StockOut']) + toInt($r['Adjustment']);
			$value['Expire'] = $r['Expire'];

			if ($count == 0) {
				$value['Code_Vill_T'] = $vmw;
				$value['Year'] = $year;
				$value['Month'] = $month;
				$value['ItemId'] = $itemId;
				$value['InitUser'] = $vmw;
				$this->db->insert('tblStockVMW', $value);
			} else {
				$value['ModiUser'] = $vmw;
				$value['ModiTime'] = sqlNow();

				$where = [];
				$where['Code_Vill_T'] = $vmw;
				$where['Year'] = $year;
				$where['Month'] = $month;
				$where['ItemId'] = $itemId;
				$this->db->update('tblStockVMW', $value, $where);
			}
		}
		$this->db->query("SP_StockVMWRecalculate '$vmw','$year','$month'");

		$this->response(['inserted_row' => 1]);
	}
}