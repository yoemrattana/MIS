<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class G6PD extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function update_post()
	{
		$data = $this->post();

		$where['Rec_ID'] = isset($data['Rec_ID']) ? $data['Rec_ID'] : '';
		$data['InitTime'] = sqlNow();
		$data['InitUser'] = $data['User_Code_Fa_T'];
		$data['Is_Mobile_Entry'] = 1;

		unset($data['User_Code_Fa_T']);
		unset($data['Rec_ID']);

		if(empty($where['Rec_ID'])) {
			$this->db->insert('tblG6PDInvestigation', $data);
		} else {
			$this->db->update('tblG6PDInvestigation', $data, $where);
		}

		$this->response(['sucess']);
	}

	public function search_case_get()
	{
		$year = $this->get('year');
	    $month = $this->get('month');
	    $hf = $this->get('hc_code');

		$data = $this->db->query("SP_API_G6PDInv '$hf', $year, $month")->result_array();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
	}

	public function get_case_get()
	{
		$g6pdCode = $this->get('g6pd_code');
		$sql = "Select * from tblG6PDInvestigation Where G6PDCode='{$g6pdCode}'";
		$data = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
	}

	public function get_g6pds_post()
	{
		$year = $this->post('year');
	    $month = $this->post('month');
	    $hc = $this->post('hc_code');
	    $month = str_pad($month, 2, 0, STR_PAD_LEFT);

	    $sql = "select c.*, a.Rec_ID as RecIdCase ,a.Diagnosis, a.NameK, a.DateCase, a.Weight, a.Sex
	            ,a.Age, b.Code_Facility_T ,Name_Facility_K, a.PatientCode from tblHFActivityCases as a
	            left join tblHFCodes as b on a.ID = b.Code_Facility_T
	            left join tblG6PDInvestigation as c on CONCAT('HC_', CONVERT(nvarchar, a.Rec_ID)) = c.G6PDCode
	            where a.Diagnosis in ('V', 'M') and a.Year = '$year' and a.ID = '$hc'";
	    if ($month != '00') $sql .= " and a.Month = '$month'";
		$sql .= " order by c.Rec_ID desc";

	    $rs = $this->db->query($sql)->result_array();

		for($i=0; $i<count($rs); $i++){
			$rs[$i]['G6PDCode'] = 'HC_' . $rs[$i]['RecIdCase'];
			unset($rs[$i]['InitTime']);
			unset($rs[$i]['InitUser']);
			unset($rs[$i]['RecIdCase']);
			unset($rs[$i]['Is_Mobile_Entry']);
		}

		$this->response($rs);
	}
}