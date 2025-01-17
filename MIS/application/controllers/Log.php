<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends My_Controller {

    /**
     * log error of MIS
     *
     * @param String $log_date
     */
    public function index($log_date = NULL)
	{
		$this->load->library('log_library');

        if ($log_date == NULL)
        {
        	$log_date = date('Y-m-d');
        }

        $data['cols'] = $this->log_library->get_file('log-'. $log_date . '.txt');
        $data['log_date'] = $log_date;

		$this->load->view('log_view', $data);
	}

	public function caseLog()
	{

		$data['title'] = "Delete Log";
		$data['main'] = 'logcase_view';

		$this->load->view('layoutV3', $data);
	}

	public function getCaseLog()
	{
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$prov = $this->input->post('prov');
		$where = " ";
		if ( !empty( $prov ) ) $where .= " and Code_Prov_N = '{$prov}' ";

		$sql = "select Place, Month, Year, Description, a.InitTime, a.InitUser, IsMobile, Code_Prov_N, Code_OD_T, Code_Facility_T, 'HC' as Module from tblLogDelete as a
				join tblHFCodes as b on a.Place = b.Code_Facility_T
				where Month = '{$month}' and Year = '{$year}' and Module = 'case' $where

				union all

				select Place, Month, Year, Description, a.InitTime, a.InitUser, IsMobile, b.Code_Prov_T as Code_Prov_N, Code_OD_T, Code_Facility_T, 'VMW' as Module from tblLogDelete as a
				join tblCensusVillage as b on a.Place = b.Code_Vill_T
				join tblHFCodes as c on c.Code_Facility_T = b.HCCode
				where Month = '{$month}' and Year = '{$year}' and Module = 'case' $where
				order by a.InitTime,Code_Prov_N";

		$rs = $this->db->query( $sql )->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getStockHCLog()
	{
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$prov = $this->input->post('prov');
		$where = " ";
		if ( !empty( $prov ) ) $where .= " and Code_Prov_N = '{$prov}' ";

		$sql = "select Month, Year, Description, IsMobile, a.Module, a.InitTime, a.InitUser, a.IsMobile, b.Code_Facility_T, b.Code_OD_T, b.Code_Prov_N  from tblLogDelete as a
				join tblHFCodes as b on a.Place = b.Code_Facility_T
				where Month = '{$month}' and Year = '{$year}' and Module = 'stock hc' $where order by b.Code_Prov_N";

		$rs = $this->db->query( $sql )->result();
		$this->output->set_output(json_encode( $rs ));
	}

	public function getStockODLog()
	{
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$prov = $this->input->post('prov');
		$where = " ";
		if ( !empty( $prov ) ) $where .= " and left(b.Code_OD_T, 2) = '{$prov}' ";

		$sql = "select Month, Year, Description, IsMobile, a.Module, a.InitTime, a.InitUser, a.IsMobile, 'N/A' as Code_Facility_T, b.Code_OD_T, left(b.Code_OD_T, 2) as Code_Prov_N  from tblLogDelete as a
				join tblOD as b on a.Place = b.Code_OD_T
				where Month = '{$month}' and Year = '{$year}' and Module = 'stock od' $where order by left(b.Code_OD_T, 2)";

		$rs = $this->db->query( $sql )->result();
		$this->output->set_output(json_encode( $rs ));
	}

    public function getFollowupLog()
	{
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$prov = $this->input->post('prov');
		$where = " ";
		if ( !empty( $prov ) ) $where .= " and Code_Prov_N = '{$prov}' ";

		$sql = "select Place, Month, Year, Description, a.InitTime, a.InitUser, IsMobile,
                Code_Prov_N, Code_OD_T, Code_Facility_T, Module from tblLogDelete as a
				join tblHFCodes as b on a.Place = b.Code_Facility_T
				where Month = '{$month}' and Year = '{$year}' and Module = 'hf-radical-cure' $where

				union all

				select Place, Month, Year, Description, a.InitTime, a.InitUser, IsMobile,
                b.Code_Prov_T as Code_Prov_N, Code_OD_T, Code_Facility_T, Module from tblLogDelete as a
				join tblCensusVillage as b on a.Place = b.Code_Vill_T
				join tblHFCodes as c on c.Code_Facility_T = b.HCCode
				where Month = '{$month}' and Year = '{$year}' and Module = 'vmw-radical-cure' $where
				order by a.InitTime,Code_Prov_N";

		$rs = $this->db->query( $sql )->result();

		$this->output->set_output(json_encode($rs));
	}
}
