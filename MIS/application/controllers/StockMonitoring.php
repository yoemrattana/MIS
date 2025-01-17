<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StockMonitoring extends MY_Controller
{
	public function od()
	{
		if (!isset($_SESSION['permiss']['OD Stock Monitoring'])) redirect('Home');

		$data['title'] = 'OD Stock Completeness Monitoring';
		$data['main'] = 'stockmonitoring_od_view';
		$this->load->view('layout', $data);
	}

	public function hc()
	{
		if (!isset($_SESSION['permiss']['HC Stock Monitoring'])) redirect('Home');

		$data['title'] = 'HC Stock Completeness Monitoring';
		$data['main'] = 'stockmonitoring_hc_view';
		$this->load->view('layout', $data);
	}

	public function getDataOD()
	{
		$year = $this->input->post('year');

		$sql = "select * from (
					select Name_Prov_E, Name_OD_E, c.Code_Prov_T, a.Code_OD_T, Month
					from (
						select a.Code_OD_T, a.Month
						from tblStockOD as a
						left join tblStockODConfirm as b on a.Code_OD_T = b.Code_OD_T and a.Year = b.Year and a.Month = b.Month
						where a.Year = '$year' and a.Year + a.Month < format(getdate(),'yyyyMM') and b.Code_OD_T is null
						group by a.Code_OD_T, a.Month
						having sum(StockIn) = 0 and sum(StockOut) = 0 and sum(Adjustment) = 0
					) as a
					join tblOD as b on a.Code_OD_T = b.Code_OD_T
					join tblProvince as c on b.Code_Prov_T = c.Code_Prov_T
				) as a pivot (count(Month) for Month in ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12])) as b
				order by Name_Prov_E, Name_OD_E";
		$rs = $this->db->query($sql)->result_array();

		$this->output->set_output(json_encode($rs));
	}

	public function getDataHC()
	{
		$year = $this->input->post('year');

		$sql = "select * from (
					select Name_Prov_E, Name_OD_E, Name_Facility_E, Code_Prov_N, Code_OD_T, a.Code_Facility_T, Month
					from (
						select a.Code_Facility_T, a.Month
						from tblStockV2 as a
						left join tblStockHCConfirm as b on a.Code_Facility_T = b.Code_Facility_T and a.Year = b.Year and a.Month = b.Month
						where a.Year = '$year' and a.Year + a.Month < format(getdate(),'yyyyMM') and b.Code_Facility_T is null
						group by a.Code_Facility_T, a.Month
						having sum(StockIn) = 0 and sum(StockOut) = 0 and sum(Adjustment) = 0
					) as a
					join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
					join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
				) as a pivot (count(Month) for Month in ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12])) as b
				order by Name_Prov_E, Name_OD_E, Name_Facility_E";
		$rs = $this->db->query($sql)->result_array();

		$this->output->set_output(json_encode($rs));
	}

	public function saveOD()
	{
		$list = $this->input->post('list');

		$this->db->insert_batch('tblStockODConfirm', $list);

		$this->getDataOD();
	}

	public function saveHC()
	{
		$list = $this->input->post('list');

		$this->db->insert_batch('tblStockHCConfirm', $list);

		$this->getDataHC();
	}
}