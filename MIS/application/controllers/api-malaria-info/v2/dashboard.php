<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Dashboard extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput('api_input_cmi.txt');

        $this->load->model('Stock_model');
	}

    //Case tab
    public function cases_tab_get()
    {
        $prov = $this->get('province');
		$od = $this->get('od');
		$year = $this->get('year');
        $mf = $this->get('month_from');
		$mt = $this->get('month_to');

        $data['top_hc'] = $this->getTopHc($year, $prov, $od);
        $data['test'] = $this->getTest($prov, $od, $year);
        $data['top_village'] = $this->getTopVillages($prov, $od, $year, $mf, $mt);

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
    }

    private function getTopHc($year, $province='', $od='')
    {
        $where = '';
        if(!empty($province)) {
            $where .= " and $province = Code_Prov_T";
        }
        if(!empty($od)) {
            $where .=" and $od = Code_OD_T";
        }

        $sql = "WITH Cases as (
	            select ID as Code_Facility_T, Year, Month, Diagnosis, 1 as Positive
	            from V_HFActivityCases as a
	            where Positive = 'P'
	            and Year = '{$year}'

	            union all

	            select HCCode, a.Year, Month, Diagnosis, 1 as Positive
	            from V_VMWActivityCases as a
	            join V_CensusVillage as b on a.ID = b.Code_Vill_T and a.Year = b.Year
	            join tblHFCodes as c on b.HCCode = c.Code_Facility_T
	            where Positive = 'P'
	            and a.Year = '{$year}'
            )

            select top 10 Code_Prov_T, Code_OD_T, a.Code_Facility_T,
            Name_Prov_E, Name_Prov_K, Name_OD_E, Name_OD_K, Name_Facility_E, Name_Facility_K, Lat, Long,
            SUM(Positive) as Positive
            from Cases as a
            join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
            join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
            where 1=1 $where
            group by Code_Prov_T, Code_OD_T, a.Code_Facility_T, Name_Prov_E, Name_Prov_K, Name_OD_E, Name_OD_K, Name_Facility_E, Name_Facility_K,Lat, Long
            order by SUM(Positive) desc";

        return $this->db->query( $sql )->result_array();
    }

    private function getTest($prov, $od, $year)
	{
		return $this->db->query("SP_API_MalariaCaseTest '{$prov}', '{$od}', '{$year}'")->result();
	}

    private function getTopVillages($prov, $od, $year, $mf, $mt)
	{
		return $this->db->query("SP_API_Top10Villages '{$prov}', '{$od}', '{$year}', '{$mf}', '{$mt}'")->result();
	}

    public function chart_get()
    {
        $data['caseByMonth'] = $this->getCaseByMonth();

        $data['topVillage'] = $this->getTopVillage();

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
    }

    private function getTopVillage()
	{
		$prov = $this->get('province');
		$od = $this->get('od');
		$year = $this->get('year');
		$mf = $this->get('month_from');
		$mt = $this->get('month_to');

		$rs =  $this->db->query("SP_API_Top10Villages '{$prov}', '{$od}', '{$year}', '{$mf}', '{$mt}'")->result();

        return $rs;
	}

    private function getCaseByMonth()
	{
		$prov = $this->get('province');
		$od = $this->get('od');
		$year = $this->get('year');

		$rs =  $this->db->query("SP_API_MalariaCaseTest '{$prov}', '{$od}', '{$year}'")->result();

		return $rs;
	}

    public function table_get()
    {
        $data['topVillage'] = $this->getTopVillage();

        $data['stockOut'] = $this->getStockout();

        $data['topOD'] = $this->getTopOD();

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
    }

    private function getStockout()
	{
		$prov = $this->get('province');
        $od = $this->get('od');
		$year = $this->get('year');
		$m = $this->get('month_from');
		$user = $this->get('user');

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

		return $itemNoStock;
	}

    private function getTopOD()
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

        return $this->db->query($sql)->result();
    }

    public function hotspot_get()
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

    //case tab
    public function case_village_get()
    {
        $province = $this->get('province');
		$od = $this->get('od');
        $hf = $this->get('hc');
		$year = $this->get('year');
        $specie = $this->get('specie');

        $where = '';
        if(!empty($province)) {
            $where .= " and Code_Prov_N in ($province)";
        }

        $caseInVillage = $this->getCaseInVillage($year, $specie);

        $sql = "WITH Cases as (
	            select ID as Code_Facility_T, Year, Month, Diagnosis, 1 as Positive
	            from V_HFActivityCases as a
                join tblHFCodes as b on a.ID = b.Code_Facility_T
	            where Diagnosis in ('F','V','M')
                and ('$od' = '' or '$od' = Code_OD_T)
                and ('$hf' = '' or '$hf' = Code_Facility_T)
                and ('$specie' = '' or '$specie' = Diagnosis)
	            and Year = '{$year}' $where

	            union all

	            select HCCode, a.Year, Month, Diagnosis, 1 as Positive
	            from V_VMWActivityCases as a
	            join V_CensusVillage as b on a.ID = b.Code_Vill_T and a.Year = b.Year
	            join tblHFCodes as c on b.HCCode = c.Code_Facility_T
	            where Diagnosis in ('F','V','M')
                and ('$od' = '' or '$od' = Code_OD_T)
                and ('$hf' = '' or '$hf' = Code_Facility_T)
                and ('$specie' = '' or '$specie' = Diagnosis)
	            and a.Year = '{$year}' $where
            )

            select Code_Prov_T, Code_OD_T, a.Code_Facility_T,
            Name_Prov_E, Name_Prov_K, Name_OD_E, Name_OD_K, Name_Facility_E, Name_Facility_K, Lat, Long,
            SUM(Positive) as Positive
            from Cases as a
            join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
            join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
            group by Code_Prov_T, Code_OD_T, a.Code_Facility_T, Name_Prov_E, Name_Prov_K, Name_OD_E, Name_OD_K, Name_Facility_E, Name_Facility_K,Lat, Long
            order by Positive desc";

		$data = $this->db->query( $sql )->result_array();

		array_walk($data, function (&$a, $k) use ($caseInVillage) {
            $found = array_filter($caseInVillage,function($v,$k) use ($a){
                return $v['Code_Facility_T'] == $a['Code_Facility_T'];
            },ARRAY_FILTER_USE_BOTH);

		    $a['Villages'] = array_values($found);
		});

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
    }

    public function village_hf_get()
	{
		$province = $this->get('province');
		$od = $this->get('od');
		$hf = $this->get('hf');

		$where = ' ';
		if (!empty($province)) $where .= " and Code_Prov_N = {$province}";
		if (!empty($od)) $where .= " and Code_OD_T = {$od}";
		if (!empty($hf)) $where .= " and Code_Facility_T = {$hf}";

		$sql = "select a.Code_Vill_T,
				a.Name_Vill_K,
				a.Name_Vill_E,
				b.Code_Facility_T,
				b.Name_Facility_K,
				b.Name_Facility_E,
				b.Code_OD_T,
				b.Name_OD_K,
				b.Name_OD_E,
				c.Code_Prov_T,
				c.Name_Prov_K,
				c.Name_Prov_E,
				a.Lat,
				a.Long,
				'Village' as Type
			from tblCensusVillage​​ as a
			join tblHFCodes as b on a.HCCode = b.Code_Facility_T
			join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
			where b.IsTarget = 1 and a.HaveVMW = 1 {$where} ";

		$sql .= "union all
				select '' as Code_Vill_T,
				'' as Name_Vill_K,
				'' as Name_Vill_E,
				a.Code_Facility_T,
				a.Name_Facility_K,
				a.Name_Facility_E,
				a.Code_OD_T,
				a.Name_OD_K,
				a.Name_OD_E,
				b.Code_Prov_T,
				b.Name_Prov_K,
				b.Name_Prov_E,
				a.Lat,
				a.Long,
				'HF' as Type
			from tblHFCodes as a
			join tblProvince as b on a.Code_Prov_N = b.Code_Prov_T
			where a.IsTarget = 1 {$where}";

		$data = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
	}

    //Intervention + Foci tab
    public function foci_get()
	{
        //$where['Us'] = $this->get('user');
        //$prov = $this->db->get_where('MIS_User', $where)->row('Code_Prov');

        $prov = $this->get('province');
		$year = $this->get('year');
		$mf = $this->get('month_from');
		$mt = $this->get('month_to');

		$rs = $this->db->query("SP_Dashboard_MapFoci $year,$mf,$mt,'$prov'")->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}
    //move to summary
    public function blog_get()
    {
        $sql = "select * from tblBlog";
        $rs = $this->db->query($sql)->result_array();

        array_walk($rs, function (&$a, $k) {
		    $a['Thumbnail'] = $_SERVER['SERVER_NAME'] . '/media/blog/' . $a['Thumbnail'];
		    unset( $a['InitUser'] );
		});

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
    }

    //not use
    public function blog_detail_get() {
        $id = $this->get('rec_id');

        $rs = $this->db->get_where('tblBlog', ['Rec_ID'=> $id])->row_array();

        $rs['Thumbnail'] = $_SERVER['SERVER_NAME'] . '/media/blog/' . $rs['Thumbnail'];

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
    }

    public function top_hc_get()
    {
		$year = $this->get('year');

        $topHcs = $this->getTopHc($year);

        //array_walk($topHcs, function (&$a, $k) use ($year) {
        //    unset($a['Diagnosis']);
        //});

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $topHcs
		];

		$this->response($response);
    }

    public function cases_vill_get()
    {
        $year = $this->get('year');
        $hc = $this->get('hf');

        $rs = $this->getVillageCase($hc, $year);

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
    }

    private function getCaseInVillage($year, $specie='')
    {
        $where = " ";
        if(!empty($specie)) {
            $where .= " and Diagnosis = '$specie'";
        }

        $sql = "WITH Cases as (
	        select ID as Code_Facility_T, a.Code_Vill_T, Year, Month, Diagnosis, 1 as Positive
	        from V_HFActivityCases as a
            join tblHFCodes as b on a.ID = b.Code_Facility_T
	        where Diagnosis in ('F','V','M')
            and Year = $year
            and ('$specie' = '' or '$specie' = Diagnosis)

	        union all

	        select HCCode, ID as Code_Vill_T, a.Year, Month, Diagnosis, 1 as Positive
	        from V_VMWActivityCases as a
	        join V_CensusVillage as b on a.ID = b.Code_Vill_T and a.Year = b.Year
	        join tblHFCodes as c on b.HCCode = c.Code_Facility_T
	        where Diagnosis in ('F','V','M')
            and a.Year = $year
            and ('$specie' = '' or '$specie' = Diagnosis)
        )

        select Name_Vill_E, Name_Vill_K, Code_Facility_T,Lat, Long, sum(Positive) as Positive
        from Cases as a
        join tblCensusVillage as b on a.Code_Vill_t = b.Code_Vill_T
        group by Name_Vill_E, Name_Vill_K, Code_Facility_T,Lat, Long
        order by Positive desc";

        return $this->db->query($sql)->result_array();
    }

    private function getVillageCase($hc, $year, $specie='')
    {
        $where = " ";
        if(!empty($specie)) {
            $where .= " and Diagnosis = '$specie'";
        }
        $sql = "WITH Cases as (
	        select ID as Code_Facility_T, a.Code_Vill_T, Year, Month, Diagnosis, 1 as Positive
	        from V_HFActivityCases as a
            join tblHFCodes as b on a.ID = b.Code_Facility_T
	        where Diagnosis in ('F','V','M')
            and Year = $year
            and ('$specie' = '' or '$specie' = Diagnosis)
            and ('$hc' = '' or '$hc' = Code_Facility_T)

	        union all

	        select HCCode, ID as Code_Vill_T, a.Year, Month, Diagnosis, 1 as Positive
	        from V_VMWActivityCases as a
	        join V_CensusVillage as b on a.ID = b.Code_Vill_T and a.Year = b.Year
	        join tblHFCodes as c on b.HCCode = c.Code_Facility_T
	        where Diagnosis in ('F','V','M')
            and ('$specie' = '' or '$specie' = Diagnosis)
            and ('$hc' = '' or '$hc' = c.Code_Facility_T)
            and a.Year = $year
        )

        select Name_Vill_K, sum(Positive) as Positive
        from Cases as a
        join tblCensusVillage as b on a.Code_Vill_t = b.Code_Vill_T
        group by Name_Vill_K
        order by Positive desc";

       return $this->db->query($sql)->result_array();
    }

    public function near_expired_stock_get()
    {
        $expiredItem = $this->Stock_model->getNearExpiredStock();

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $expiredItem
		];

		$this->response($response);
    }

    //Intervention + Ides tab
    public function ides_get() {
        $pv = $this->get('province');
		$od = $this->get('od');
        $hc = $this->get('hc');
		$year = $this->get('year');
        $mf = $this->get('month_from');
        $mt = $this->get('month_to');

        $mf = $year.$mf;
        $mt = $year.$mt;

        $rs = $this->db->query("SP_iDes_Report '$mf','$mt','$pv','$od','$hc', ''")->result_array();

        array_walk($rs, function (&$a, $k) {
            unset( $a['CSO'], $a['Level'] );
        });

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
    }

    //Intervention + Pv Radical Cure
    public function radical_cure_get()
	{
		$year = date('Y');

		$sql = "WITH cases as (
	            select ID as HCCode
		              ,G6PD, G6PDHb, G6PDdL
		              ,iif(Primaquine15 > 0 or Primaquine75 > 0 or PQTreatment = 'ASMQ + 14 days PQ',1,0) as Primaquine
		              ,DateCase, Weight, Sex
		              ,iif(Sex = 'F' and PregnantMTHS between '1' and '9',1,0) as Pregnant
	            from V_HFActivityCases
	            where Year = $year  and Diagnosis in ('V','M')

	            union all

	            select HCCode
		              ,G6PD, G6PDHb, G6PDdL
		              ,iif(Primaquine15 > 0 or Primaquine75 > 0 or PQTreatment = 'ASMQ + 14 days PQ',1,0) as Primaquine
		              ,DateCase, Weight, Sex
		              ,iif(Sex = 'F' and PregnantMTHS between '1' and '9',1,0) as Pregnant
	            from V_VMWActivityCases as a
	            join V_CensusVillage as b on a.ID = b.Code_Vill_T and a.Year = b.Year
	            where a.Year = $year and Diagnosis in ('V','M')
            )

            select
	              count(c.HCCode) as Pv
	              ,sum(iif(Weight >= 20 and Pregnant = 0,1,0)) as EligibleG6PD
	              ,sum(iif((G6PDHb > 0 or G6PD <> ''),1,0)) as G6PDTest
	              ,sum(case when DateCase <= '2022-05-27' and ((G6PDHb > 6 and G6PDdL >= 9) or G6PD = 'Normal') then 1
				            when DateCase >  '2022-05-27' and Sex = 'M' and G6PDHb >= 4 and G6PDdL >= 7 then 1
				            when DateCase >  '2022-05-27' and Sex = 'F' and G6PDHb >  6 and G6PDdL >= 7 then 1 else 0 end) as G6PDNormal
	              ,sum(isnull(Primaquine,0)) as Primaquine
            from tblHFCodes as a
            left join cases as c on a.Code_Facility_T = c.HCCode
            where a.IsTarget = 1 and (IsReminder = 1 or G6PDHb > 0 or G6PD <> '')";

		$rs = $this->db->query($sql)->row();

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}
}