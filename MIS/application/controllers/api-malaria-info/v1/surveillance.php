<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Surveillance extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput('api_input_cmi.txt');
	}

	public function case_daily_get()
	{
		$sql = "WITH T as
				(
					select ID as HCCode, Month, Year, NameK, Diagnosis, DateCase from tblHFActivityCases

					union all

					select HCCode, Month, Year, NameK, Diagnosis, a.DateCase from tblVMWActivityCases as a
					join tblCensusVillage as b on b.Code_Vill_T = a.ID
				)

				select isnull(sum(iif(Diagnosis = 'F',1,0)), 0) as PF,
					isnull(sum(iif(Diagnosis = 'V',1,0)), 0) as PV,
					isnull(sum(iif(Diagnosis = 'M',1,0)), 0) as Mix,
					count(*) as Total
				from T as a
				join tblHFCodes as b on b.Code_Facility_T = a.HCCode
				where Diagnosis in ('F', 'V', 'M')
				and CAST(a.DateCase as DATE) = CAST(GETDATE() as DATE)
				and IsTarget = 1";

		$rs = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function case_weekly_get()
	{
		$from = date("Y-m-d", strtotime('monday this week'));
		$to = date("Y-m-d");

		$sql = "WITH T as
				(
					select ID as HCCode, Month, Year, NameK, Diagnosis, DateCase from tblHFActivityCases

					union all

					select HCCode, Month, Year, NameK, Diagnosis, a.DateCase from tblVMWActivityCases as a
					join tblCensusVillage as b on b.Code_Vill_T = a.ID
				)

				select isnull(sum(iif(Diagnosis = 'F',1,0)), 0) as PF,
					isnull(sum(iif(Diagnosis = 'V',1,0)), 0) as PV,
					isnull(sum(iif(Diagnosis = 'M',1,0)), 0) as Mix,
					count(*) as Total
				from T as a
				join tblHFCodes as b on b.Code_Facility_T = a.HCCode
				where Diagnosis in ('F', 'V', 'M')
				and CAST(a.DateCase as Date) between '{$from}' and '{$to}'
				and IsTarget = 1";

		$rs = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function case_monthly_get()
	{
		$rs =  $this->db->query("SP_API_CaseMonthly")->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function top_od_weekly_get()
	{
		$from = date("Y-m-d", strtotime('monday this week'));
		$to = date("Y-m-d");

		$sql = "WITH T as
				(
					select ID as HCCode, Month, Year, NameK, InitTime, 1 as Positive, Diagnosis from tblHFActivityCases
					where Positive = 'P'
					and CAST(DateCase as Date) between '{$from}' and '{$to}'

					union all

					select HCCode, Month, Year, NameK, a.InitTime, 1 as Positive, Diagnosis from tblVMWActivityCases as a
					join tblCensusVillage as b on b.Code_Vill_T = a.ID
					where Positive = 'P'
					and CAST(a.DateCase as Date) between '{$from}' and '{$to}'
				)

				select top 5 Code_OD_T,
					Name_OD_K,
					Name_OD_E,
					sum(iif(Diagnosis = 'F',1,0)) as PF,
					sum(iif(Diagnosis = 'V',1,0)) as PV,
					sum(iif(Diagnosis = 'M',1,0)) as Mix,
					sum(Positive) as Total
				from T as a
				join tblHFCodes as b on b.Code_Facility_T = a.HCCode
				where b.IsTarget = 1
				group by Code_OD_T, Name_OD_K, Name_OD_E
				order by Total desc";

		$rs = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function top_ten_village_get()
	{
		$prov = $this->get('province');
		$od = $this->get('od');
		$year = $this->get('year');
		$mf = $this->get('month_from');
		$mt = $this->get('month_to');

		$rs =  $this->db->query("SP_API_Top10Villages '{$prov}', '{$od}', '{$year}', '{$mf}', '{$mt}'")->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function malaria_get()
	{
		$prov = $this->get('province');
		$od = $this->get('od');
		$year = $this->get('year');

		$rs =  $this->db->query("SP_API_MalariaCaseTest '{$prov}', '{$od}', '{$year}'")->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function pf_mix_get()
	{
		$prov = $this->get('province');
		$od = $this->get('od');
		$year = $this->get('year');
		$mf = $this->get('month_from');
		$mt = $this->get('month_to');

		$rs =  $this->db->query("SP_API_PFMix10Village '{$prov}', '{$od}', '{$year}', '{$mf}', '{$mt}'")->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function malaria_hotspot_get()
	{
		$prov = $this->get('province');
		$od = $this->get('od');
		$year = $this->get('year');
		$mf = $this->get('month_from');
		$mt = $this->get('month_to');

		//$od = $this->getOD($user);
		$rs =  $this->db->query("SP_API_MapTop30Vill '{$prov}', '{$od}', '{$year}', '{$mf}', '{$mt}'")->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function stock_out_get()
	{
		$prov = $this->get('province');
		$year = $this->get('year');
		$m = $this->get('month');

		$user = $this->get('user');

		$od = $this->get('od');

        //if(empty($prov)){
        //    $od = $this->getOD($user);
        //    $od = explode(",", $od);
        //}else{
        //    $od = $this->get('od');
        //}

		$this->db->select("*");
		$this->db->join("tblProvince", "Code_Prov_N = Code_Prov_T");

		if(!empty($prov)){
			$this->db->where(["Code_Prov_N" => $prov]);
		}
		if(!empty($od)){
			if(is_array($od)){
				$this->db->where_in('Code_OD_T', $od);
			}else{
				$this->db->where(["Code_OD_T" => $od]);
			}
		}

		$hcs = $this->db->get("tblHFCodes")->result_array();

		$itemNoStock = [];
		foreach($hcs as $hc) {
		    $sql = "SP_StockHC '{$hc['Code_Facility_T']}','{$year}','{$m}'";
		    $items = $this->db->query($sql)->result_array();
			$items = notInArray($items, ['SUM of ACT'], 'Description');

			foreach ($items as $item) {
				$total = $item['StockStart'] + $item['StockIn'];
				$AMC = $item['AMC'] == null ? 'NA' : floatval($item['AMC']);
				$balance = floatval($total - $item['StockOut'] + $item['Adjustment']);
				$MOS = in_array($AMC, ['NA', 0]) ? 'NA' : floatval($balance / $AMC);

				if (empty($MOS)){
					$stock = [
						'Name_Prov_K' => $hc['Name_Prov_K'],
						'Name_Prov_E' => $hc['Name_Prov_E'],
						'Name_Facility_K' => $hc['Name_Facility_K'],
						'Name_Facility_E' => $hc['Name_Facility_E'],
						'Name_OD_K' => $hc['Name_OD_K'],
						'Name_OD_E' => $hc['Name_OD_E'],
						'Description' => $item['Description'],
						'Unit' => $item['Unit']
					];
					array_push($itemNoStock, $stock);
				}
			}
		}

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $itemNoStock
		];

		$this->response($response);
	}

	private function getOD($user)
	{
		$sql = "select * from MIS_User where Us = '{$user}'";
		$user = $this->db->query($sql)->row_array();

		if (!$user) {
			$error = [
				'status' => 'error',
				'message' => 'Invalid User'
			];
			$this->response($error, 400);
		}

		if( $user['Role'] == 'OD' ){
			$codeOD = (array) $user['Code_OD'];
		}elseif( in_array($user['Role'], ['PHD', 'CSO', 'VICE DIRECTOR']) ){
			$sql = "select Code_OD_T from tblOD where left(Code_OD_T, 2) in (select Code from dbo.Split('{$user['Code_Prov']}'))";
			$od = $this->db->query($sql)->result_array();
			$codeOD = array_flatten($od);
		}elseif( in_array($user['Role'], ['AU', 'M&E CNM', 'M&E']) ) {
			$codeOD = [];
		}elseif( in_array($user['Role'], ['STOCK CNM'])) {
			$sql = "select Code_OD_T from tblOD where IsTarget = 1";
			$od = $this->db->query($sql)->result_array();
			$codeOD = array_flatten($od);
		}else{
			$error = [
				'status' => 'error',
				'message' => 'User not allowed'
			];
			$this->response($error, 400);
		}

		return implode(',', $codeOD);
	}

	public function hf_report_timely_get()
	{
		$year = $this->get('year');
		$month = $this->get('month');

		$rs =  $this->db->query("SP_API_HFReportTimeline '{$year}', '{$month}'")->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function vmw_report_timely_get()
	{
		$year = $this->get('year');
		$month = $this->get('month');

		$rs =  $this->db->query("SP_API_VMWReportTimeline '{$year}', '{$month}'")->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function case_this_year_get()
	{
		$firstMonth = date('Y-m', strtotime('first day of january'));
		$lastMonth = date('Y-m');

		$sql = "WITH T as
				(
					select ID as HCCode, Month, Year, Diagnosis
					from V_HFActivityCases
                    where Exclude = 0

					union all

					select HCCode, Month, a.Year, Diagnosis
					from V_VMWActivityCases as a
					join V_CensusVillage as b on b.Code_Vill_T = a.ID and a.Year = b.Year
					where Exclude = 0
				)

				select isnull(sum(iif(Diagnosis = 'F',1,0)), 0) as PF,
					   isnull(sum(iif(Diagnosis = 'V',1,0)), 0) as PV,
					   isnull(sum(iif(Diagnosis = 'M',1,0)), 0) as Mix,
					   count(*) as Total
				from T as a
				join tblHFCodes as b on b.Code_Facility_T = a.HCCode
				where Diagnosis in ('F', 'V', 'M')
				and Year + '-' + Month between '{$firstMonth}' and '{$lastMonth}'
				and IsTarget = 1";

		$rs = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function case_pf_mix_get()
	{
		$province = $this->get('province');
		$od	= $this->get('od');
		$hc = $this->get('hc');
		$year	= $this->get('year');
		$monthFrom	= $this->get('month_from');
		$monthTo		= $this->get('month_to');
		$user = $this->get('user');

		$sql = "WITH T as
				(
					select ID as HCCode, Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS as Code_Vill_T, Month, Year, NameK, Diagnosis, DateCase, Age, L1, LC, IMP
					from tblHFActivityCases
					where Diagnosis in ('F', 'M') and Year = {$year} and Month between {$monthFrom} and {$monthTo}
					union all

					select HCCode, ID, Month, Year, NameK, Diagnosis, DateCase, Age, L1, LC, IMP
					from tblVMWActivityCases as a
					join tblCensusVillage as b on b.Code_Vill_T = a.ID
					where Diagnosis in ('F', 'M') and Year = {$year} and Month between {$monthFrom} and {$monthTo}
				)

				select e.Code_Prov_T, Name_Prov_K, Name_Prov_E, c.Code_OD_T, c.Name_OD_K, c.Name_OD_E, Code_Facility_T, Name_Facility_K, Name_Facility_E,
				a.Code_Vill_T,a.Code_Vill_T as Name_Vill_K, a.Code_Vill_T as Name_Vill_E, null as Lat, null as Long, a.Month, a.Year, a.NameK, a.Diagnosis, DateCase, Age, L1, LC, IMP
				from T as a
				join tblHFCodes as c on c.Code_Facility_T = a.HCCode
				join tblOD as d on d.Code_OD_T = c.Code_OD_T
				join tblProvince as e on e.Code_Prov_T = left(c.Code_OD_T, 2)
				where c.IsTarget = 1
				and (ISNUMERIC(a.Code_Vill_T) = 0 or LEN(a.Code_Vill_T) < 10)
				and ('{$province}' = '' or e.Code_Prov_T = '{$province}')
				and ('{$od}' = '' or d.Code_OD_T = '{$od}')
				and ('{$hc}' = '' or c.Code_Facility_T = '{$hc}')

				union all

				select e.Code_Prov_T, Name_Prov_K, Name_Prov_E, c.Code_OD_T, c.Name_OD_K, c.Name_OD_E, Code_Facility_T, Name_Facility_K, Name_Facility_E,
				a.Code_Vill_T, b.Name_Vill_K,b.Name_Vill_E, b.Lat, b.long, a.Month, a.Year, a.NameK, a.Diagnosis, DateCase, Age, L1, LC, IMP
				from T as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on c.Code_Facility_T = a.HCCode
				join tblOD as d on d.Code_OD_T = c.Code_OD_T
				join tblProvince as e on e.Code_Prov_T = left(c.Code_OD_T, 2)
				where c.IsTarget = 1
				and ('{$province}' = '' or e.Code_Prov_T = '{$province}')
				and ('{$od}' = '' or d.Code_OD_T = '{$od}')
				and ('{$hc}' = '' or c.Code_Facility_T = '{$hc}')";

		$rs = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function pv_radicalcure_get()
	{
		$year = $this->get('year');
		$mf = $this->get('month_from');
		$mt = $this->get('month_to');

		$sql = "select count(*) as Pv, sum(G6PDTest) as G6PDTest, sum(G6PDNormal) as G6PDNormal, sum(Primaquine) as Primaquine
				from (
					select iif(PQTreatment = 'ASMQ + 14 days PQ' or Primaquine15 > 0 or Primaquine75 > 0,1,0) as Primaquine
						  ,iif(G6PDHb > 0 or G6PDdL > 0 or G6PD <> '',1,0) as G6PDTest
						  ,iif((G6PDHb > 6 and G6PDdL > 9) or G6PD = 'Normal',1,0) as G6PDNormal
					from tblVMWActivityCases as a
					join tblCensusVillage as b on a.ID = b.Code_Vill_T
					where Diagnosis in ('V','M') and Year = '$year' and Month between $mf and $mt

					union all

					select iif(Primaquine15 > 0 or Primaquine75 > 0,1,0) as Primaquine
						  ,iif(G6PDHb > 0 or G6PDdL > 0 or G6PD <> '',1,0) as G6PDTest
						  ,iif((G6PDHb > 6 and G6PDdL > 9) or G6PD = 'Normal',1,0)
					from tblHFActivityCases
					where Diagnosis in ('V','M') and Year = '$year' and Month between $mf and $mt
				) as a";
		$rs = $this->db->query($sql)->result();

		$this->response([
			"code" => 200,
			"message" => "success",
			"data" => $rs
		]);
	}

    //may be not use
	public function cases_get()
	{
		$rs =  $this->db->query("SP_API_CaseLastCurrentYear")->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function today_cases_detail_get()
	{
		$sql = "WITH Cases as (
					select ID as HCCode,Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS as Code_Vill_T, Month, Year, NameK, Diagnosis, DateCase
					from tblHFActivityCases
					where Diagnosis in ('F', 'V', 'M', 'A', 'O', 'K')
					and CAST(DateCase as DATE) = CAST(GETDATE() as DATE)

					union all

					select HCCode, ID, Month, Year, NameK, Diagnosis, a.DateCase
					from tblVMWActivityCases as a
					join tblCensusVillage as b on b.Code_Vill_T = a.ID
					where Diagnosis in ('F', 'V', 'M', 'A', 'O', 'K')
				  and CAST(a.DateCase as DATE) = CAST(GETDATE() as DATE)
				),
				Unknown as (
					select * from Cases
					where ISNUMERIC(Code_Vill_T) = 0 or (LEN(Code_Vill_T) < 10 and ISNUMERIC(Code_Vill_T) = 1)
				)

				select Name_OD_K, Name_OD_E, Name_Facility_K, Name_Facility_E, Name_Vill_K, Name_Vill_E,
				sum(iif(Diagnosis = 'F', 1, 0))as Pf,
				sum(iif(Diagnosis = 'V', 1, 0))as Pv,
				sum(iif(Diagnosis = 'M', 1, 0))as Mix,
				sum(iif(Diagnosis = 'A', 1, 0))as Pm,
				sum(iif(Diagnosis = 'O', 1, 0))as Po,
				sum(iif(Diagnosis = 'K', 1, 0))as Pk
				from
				(
					select a.*, Name_OD_K, Name_OD_E, Name_Facility_K, Name_Facility_E, Name_Vill_K, Name_Vill_E
					from Cases as a
					join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
					join tblHFCodes as c on a.HCCode = c.Code_Facility_T
					where IsTarget = 1

					union all

					select a.*, Name_OD_K, Name_OD_E, Name_Facility_K, Name_Facility_E, a.Code_Vill_T as Name_Vill_K, 'N/A' as Name_Vill_E from Unknown as a
					join tblHFCodes as b on a.HCCode = b.Code_Facility_T
					where IsTarget = 1
				) as sub
				group by Name_OD_K, Name_OD_E, Name_Facility_K, Name_Facility_E, Name_Vill_K, Name_Vill_E";

		$rs = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function weekly_cases_detail_get()
	{
		$from = date("Y-m-d", strtotime('monday this week'));
		$to = date("Y-m-d");

		$sql = "WITH Cases as (
					select ID as HCCode,Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS as Code_Vill_T, Month, Year, NameK, Diagnosis, DateCase
					from tblHFActivityCases
					where Diagnosis in ('F', 'V', 'M', 'A', 'O', 'K')
					and CAST(DateCase as DATE) between '{$from}' and '{$to}'

					union all

					select HCCode, ID, Month, Year, NameK, Diagnosis, a.DateCase
					from tblVMWActivityCases as a
					join tblCensusVillage as b on b.Code_Vill_T = a.ID
					where Diagnosis in ('F', 'V', 'M', 'A', 'O', 'K')
					and CAST(a.DateCase as DATE) between '{$from}' and '{$to}'
				),
				Unknown as (
					select * from Cases
					where ISNUMERIC(Code_Vill_T) = 0 or (LEN(Code_Vill_T) < 10 and ISNUMERIC(Code_Vill_T) = 1)
				)

				select Name_OD_K, Name_OD_E, Name_Facility_K, Name_Facility_E, Name_Vill_K, Name_Vill_E,
				sum(iif(Diagnosis = 'F', 1, 0))as Pf,
				sum(iif(Diagnosis = 'V', 1, 0))as Pv,
				sum(iif(Diagnosis = 'M', 1, 0))as Mix,
				sum(iif(Diagnosis = 'A', 1, 0))as Pm,
				sum(iif(Diagnosis = 'O', 1, 0))as Po,
				sum(iif(Diagnosis = 'K', 1, 0))as Pk
				from
				(
					select a.*, Name_OD_K, Name_OD_E, Name_Facility_K, Name_Facility_E, Name_Vill_K, Name_Vill_E
					from Cases as a
					join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
					join tblHFCodes as c on a.HCCode = c.Code_Facility_T
					where IsTarget = 1

					union all

					select a.*, Name_OD_K, Name_OD_E, Name_Facility_K, Name_Facility_E, a.Code_Vill_T as Name_Vill_K, 'N/A' as Name_Vill_E from Unknown as a
					join tblHFCodes as b on a.HCCode = b.Code_Facility_T
					where IsTarget = 1
				) as sub
				group by Name_OD_K, Name_OD_E, Name_Facility_K, Name_Facility_E, Name_Vill_K, Name_Vill_E";

		$rs = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

    public function top_od_get()
    {
        $sql = "WITH Cases as
                (
	                select ID as HCCode, Code_OD_T, Code_Prov_N, Diagnosis, 1 as Positive
	                from V_HFActivityCases as a
	                join tblHFCodes as b on a.ID = b.Code_Facility_T
	                where Diagnosis in ('F','V','M')
	                and Year = Year(Getdate())
	                and IsTarget = 1 and Exclude = 0

	                union all

	                select HCCode, Code_OD_T, Code_Prov_N, Diagnosis, 1 as Positive
	                from V_VMWActivityCases as a
	                join V_CensusVillage as b on a.ID = b.Code_Vill_T and a.Year = b.Year
	                join tblHFCodes as c on b.HCCode = c.Code_Facility_T
	                where Diagnosis in ('F','V','M')
	                and a.Year = Year(Getdate())
	                and c.IsTarget = 1 and Exclude = 0
                )

                select top 10 Name_Prov_E, Name_Prov_K, Name_OD_E, Name_OD_K
                ,sum(iif(Diagnosis = 'V', 1, 0)) as Pv
                ,sum(iif(Diagnosis = 'F', 1, 0)) as Pf
                ,sum(iif(Diagnosis = 'M', 1, 0)) as Mix
                ,sum(Positive) as Positive
                from Cases as a
                join tblOD as b on a.Code_OD_T = b.Code_OD_T
                join tblProvince as c on c.Code_Prov_T = b.Code_Prov_T
                group by Name_Prov_E, Name_Prov_K, Name_OD_E, Name_OD_K
                order by sum(Positive) desc";

        $rs = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
    }
}