<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class FociVillage extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function detail_get()
	{
		$codeVillage = $this->get('code_vill_t');

		$sql = "SELECT Name_Vill_K ,Name_Facility_K, Name_OD_K, Investigator
					  ,Phone ,FociInvestigationDate ,a.Lat ,a.Long ,R1 ,V1
				FROM tblFociInvestigation as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T where a.Code_Vill_T = '{$codeVillage}'";

		$rs = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function bednet_tda_get()
	{
		$villageCode = $this->get('code_vill_t');

		$sql = "with t as
				(
					select (select count(*) from tblLastmileHouseMember where tblLastmileHouseMember.HouseHoldID = tblLastmileTDA.HouseHoldID and TDA='Yes') as TotalTDA,
					sum(iif(Type = 1 and Date is not null, 1, 0)) as TDA1,
					sum(iif(Type = 1 and Reject = 'Yes', 1, 0)) as RejectTDA1,
					sum(iif(Type = 2 and Date is not null, 1, 0)) as TDA2,
					sum(iif(Type = 2 and Reject = 'Yes', 1, 0)) as RejectTDA2,
					HouseHoldID
					from tblLastmileTDA
					group by tblLastmileTDA.HouseHoldID
				)

				select Code_Vill_T, HouseNumber, TotalMember,
				b.LLINLack, b.LLINOffer, b.LLIHNLack, b.LLIHNOffer,
				t.TotalTDA, t.TDA1, t.RejectTDA1, t.TDA2, t.RejectTDA2
				from tblLastmileHouseHold as a
				left join tblLastmileTDANet as b on a.Rec_ID = b.HouseHoldID
				left join t on t.HouseHoldID = a.Rec_ID
				where Code_Vill_T = '{$villageCode}'";

		$rs = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function ipt_get()
	{
		$villCode = $this->get('code_vill_t');
		$month = $this->get('month');
		$year = $this->get('year');

		$sql = "with t as
				(
					select Month as Month, Year as Year, HouseHoldID as HouseHoldID,
						sum(iif(DoNotUse = 'Yes', 1, 0)) as DoNotUse,
						sum(iif(Reject = 'Yes', 1, 0)) as Reject,
						sum(iif(Date is not null and Date <> '', 1, 0)) as IPT,
						sum(iif(W1 = 'Yes', 1, 0)) as W1,
						sum(iif(W2 = 'Yes', 1, 0)) as W2,
						sum(iif(W3 = 'Yes', 1, 0)) as W3,
						sum(iif(W4 = 'Yes', 1, 0)) as W4
					from tblLastmileIPT
					where Month = '{$month}' and Year = {$year}
					group by  Month , Year, HouseHoldID
				)

				select a.HouseNumber,a.TotalForestEntry, b.* from tblLastmileHouseHold as a
				left join
				(
					select * from t
				) as b on a.Rec_ID = b.HouseHoldID where Code_Vill_T = '{$villCode}'";

		$rs = $this->db->query($sql)->result_array();

		array_walk($rs, function (&$a, $k) {

		});

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}
}