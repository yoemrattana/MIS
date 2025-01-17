<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class ides extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

    public function hc_list_post()
    {
		$year = $this->post('Year');
		$code = $this->post('Code_Facility_T');

		$sql = "select Month
					  ,a.Rec_ID as Case_ID
					  ,NameK as FirstName
					  ,Age, iif(Sex = 'M',N'ប្រុស',N'ស្រី') as Sex, '' as DOB
					  ,dbo.ToSpecies(Diagnosis) as Species
					  ,convert(date,DateCase) as D0
					  ,convert(date,DATEADD(day,1,DateCase)) as D1
					  ,convert(date,DATEADD(day,2,DateCase)) as D2
					  ,convert(date,DATEADD(day,3,DateCase)) as D3
					  ,convert(date,DATEADD(day,7,DateCase)) as D7
					  ,convert(date,DATEADD(day,14,DateCase)) as D14
					  ,convert(date,DATEADD(day,28,DateCase)) as D28
					  ,convert(date,DATEADD(day,42,DateCase)) as D42
					  ,convert(date,DATEADD(day,90,DateCase)) as D90
					  ,isnull(sum(iif(Days = 'D0',1,0)),0) as D0_Done
					  ,isnull(sum(iif(Days = 'D1',1,0)),0) as D1_Done
					  ,isnull(sum(iif(Days = 'D2',1,0)),0) as D2_Done
					  ,isnull(sum(iif(Days = 'D3',1,0)),0) as D3_Done
					  ,isnull(sum(iif(Days = 'D7',1,0)),0) as D7_Done
					  ,isnull(sum(iif(Days = 'D14',1,0)),0) as D14_Done
					  ,isnull(sum(iif(Days = 'D28',1,0)),0) as D28_Done
					  ,isnull(sum(iif(Days = 'D42',1,0)),0) as D42_Done
					  ,isnull(sum(iif(Days = 'D90',1,0)),0) as D90_Done
					  ,iif(c.Case_ID is null,0,1) as Followup_Done
				from tblHFActivityCases as a
				left join tbliDes as b on a.Rec_ID = b.Case_ID and b.Case_Type = 'HC'
				left join tbliDesDetail as c on b.Case_ID = c.Case_ID and b.Case_Type = c.Case_Type
				left join tbliDesFollowup as d on c.Case_ID = d.Case_ID and c.Case_Type = d.Case_Type
				where Positive = 'P' and Year = '$year' and ID = '$code'
				group by Month, a.Rec_ID, NameK, Age, Sex, Diagnosis, DateCase, c.Case_ID
				order by NameK";
		$rs = $this->db->query($sql)->result();

        $this->response($rs);
    }

	public function vmw_list_post()
    {
		$year = $this->post('Year');
		$code = $this->post('Code_Vill_T');

		$sql = "select Month
					  ,a.Rec_ID as Case_ID
					  ,NameK as FirstName
					  ,Age, iif(Sex = 'M',N'ប្រុស',N'ស្រី') as Sex, '' as DOB
					  ,dbo.ToSpecies(Diagnosis) as Species
					  ,convert(date,DateCase) as D0
					  ,convert(date,DATEADD(day,1,DateCase)) as D1
					  ,convert(date,DATEADD(day,2,DateCase)) as D2
					  ,convert(date,DATEADD(day,3,DateCase)) as D3
					  ,convert(date,DATEADD(day,7,DateCase)) as D7
					  ,convert(date,DATEADD(day,14,DateCase)) as D14
					  ,convert(date,DATEADD(day,28,DateCase)) as D28
					  ,convert(date,DATEADD(day,42,DateCase)) as D42
					  ,convert(date,DATEADD(day,90,DateCase)) as D90
					  ,isnull(sum(iif(Days = 'D0',1,0)),0) as D0_Done
					  ,isnull(sum(iif(Days = 'D1',1,0)),0) as D1_Done
					  ,isnull(sum(iif(Days = 'D2',1,0)),0) as D2_Done
					  ,isnull(sum(iif(Days = 'D3',1,0)),0) as D3_Done
					  ,isnull(sum(iif(Days = 'D7',1,0)),0) as D7_Done
					  ,isnull(sum(iif(Days = 'D14',1,0)),0) as D14_Done
					  ,isnull(sum(iif(Days = 'D28',1,0)),0) as D28_Done
					  ,isnull(sum(iif(Days = 'D42',1,0)),0) as D42_Done
					  ,isnull(sum(iif(Days = 'D90',1,0)),0) as D90_Done
					  ,iif(c.Case_ID is null,0,1) as Followup_Done
				from tblVMWActivityCases as a
				left join tbliDes as b on a.Rec_ID = b.Case_ID and b.Case_Type = 'VMW'
				left join tbliDesDetail as c on b.Case_ID = c.Case_ID and b.Case_Type = c.Case_Type
				left join tbliDesFollowup as d on c.Case_ID = d.Case_ID and c.Case_Type = d.Case_Type
				where Positive = 'P' and Year = '$year' and ID = '$code'
				group by Month, a.Rec_ID, NameK, Age, Sex, Diagnosis, DateCase, c.Case_ID
				order by NameK";

		$rs = $this->db->query($sql)->result();

        $this->response($rs);
    }

    public function hc_detail_post()
    {
		$id = $this->post('Case_ID');
		$day = $this->post('Days');
		$d = substr($day, 1);

		$sql = "select a.Rec_ID as Case_ID
					  ,convert(date,a.InitTime) as NotificationDate
					  ,convert(date,DateCase) as DiagnosisDate
					  ,convert(date,DateCase) as InvestigationDate
					  ,NameK as FirstName, '' as LastName
					  ,iif(Sex = 'M',N'ប្រុស',N'ស្រី') as Sex
					  ,Age, Weight, DOB, Occupation, PatientPhone as Phone
					  ,Name_Vill_E, Name_Comm_E, Name_Dist_E, f.Name_Prov_E
					  ,case when Sex = 'F' and G6PDHb >= 6.1 then N'Normal (≥ 6.1 U/g Hb)'
							when Sex = 'F' and G6PDHb between 4.1 and 6 then 'Intermediate (4.1-6.0 U/g Hb)'
							when Sex = 'F' and G6PDHb <= 4 then N'Deficient (≤ 4.0 U/g Hb)'
							when Sex = 'M' and G6PDHb >= 4.1 then N'Normal (≥ 4.1 U/g Hb)'
							when Sex = 'M' and G6PDHb <= 4 then N'Deficient (≤ 4.0 U/g Hb)' end as G6PD
					  ,dbo.ToSpecies(Diagnosis) as Species
					  ,'PCD' as CaseDetection
					  ,case when Relapse = 1 then 'Relapsing'
							when L1 = 1 then 'Introduced'
							when LC = 1 then 'Indigenous'
							when IMP = 1 then 'Imported' else 'Not done' end as CaseInvestigation
					  ,Dose, DoseTablet, DoseExpiration, DoseBatch, Mg, MgTablet, MgExpiration, MgBatch
					  ,'$day' as Days, convert(date,dateadd(day,$d,DateCase)) as ExpectedDate, ActualDate
					  ,Temp, SlideSpecies, PfPmPkASMQ, PfPmPkPQ
					  ,G6PDNormalASMQ, G6PDNormalPQ, G6PDDeficient
					  ,Vomit30min, CollectSlide, CollectDBS
					  ,Vomit2hrs, Dizziness, Headache, Pain, Diarrhoea, SkinRash, OtherEffect, FollowupBy
					  ,Name_OD_K, i.Name_Prov_K
				from tblHFActivityCases as a
				left join tbliDesDetail as b on a.Rec_ID = b.Case_ID and b.Case_Type = 'HC' and b.Days = '$day'
				left join tblCensusVillage as c on a.Code_Vill_t = c.Code_Vill_T
				left join tblCommune as d on c.Code_Comm_T = d.Code_Comm_T
				left join tblDistrict as e on c.Code_Dist_T = e.Code_Dist_T
				left join tblProvince as f on c.Code_Prov_T = f.Code_Prov_T
				left join tbliDes as g on a.Rec_ID = g.Case_ID and g.Case_Type = 'HC'
				join tblHFCodes as h on a.ID = h.Code_Facility_T
				join tblProvince as i on h.Code_Prov_N = i.Code_Prov_T
				where a.Rec_ID = $id";
		$rs = $this->db->query($sql)->row_array();

		foreach ($rs as $key => $value)
		{
			if ($value === null) $rs[$key] = '';
		}

		$this->response($rs);
    }

	public function vmw_detail_post()
    {
		$id = $this->post('Case_ID');
		$day = $this->post('Days');
		$d = substr($day, 1);

		$sql = "select a.Rec_ID as Case_ID
					  ,convert(date,a.InitTime) as NotificationDate
					  ,convert(date,DateCase) as DiagnosisDate
					  ,convert(date,DateCase) as InvestigationDate
					  ,NameK as FirstName, '' as LastName
					  ,iif(Sex = 'M',N'ប្រុស',N'ស្រី') as Sex
					  ,Age, Weight, DOB, Occupation, PatientPhone as Phone
					  ,Name_Vill_E, Name_Comm_E, Name_Dist_E, Name_Prov_E
					  ,case when Sex = 'F' and G6PDHb >= 6.1 then N'Normal (≥ 6.1 U/g Hb)'
							when Sex = 'F' and G6PDHb between 4.1 and 6 then 'Intermediate (4.1-6.0 U/g Hb)'
							when Sex = 'F' and G6PDHb <= 4 then N'Deficient (≤ 4.0 U/g Hb)'
							when Sex = 'M' and G6PDHb >= 4.1 then N'Normal (≥ 4.1 U/g Hb)'
							when Sex = 'M' and G6PDHb <= 4 then N'Deficient (≤ 4.0 U/g Hb)' end as G6PD
					  ,case Diagnosis when 'F' then 'Pf' when 'V' then 'Pv' when 'M' then 'Mix' when 'A' then 'Pm' when 'O' then 'Po' when 'K' then 'Pk' end as Species
					  ,'PCD' as CaseDetection
					  ,case when Relapse = 1 then 'Relapsing'
							when L1 = 1 then 'Introduced'
							when LC = 1 then 'Indigenous'
							when IMP = 1 then 'Imported' else 'Not done' end as CaseInvestigation
					  ,Dose, DoseTablet, DoseExpiration, DoseBatch, Mg, MgTablet, MgExpiration, MgBatch
					  ,'$day' as Days, convert(date,dateadd(day,$d,DateCase)) as ExpectedDate, ActualDate
					  ,Temp, SlideSpecies, PfPmPkASMQ, PfPmPkPQ
					  ,G6PDNormalASMQ, G6PDNormalPQ, G6PDDeficient
					  ,Vomit30min, CollectSlide, CollectDBS
					  ,Vomit2hrs, Dizziness, Headache, Pain, Diarrhoea, SkinRash, OtherEffect, FollowupBy
					  ,Name_OD_K, Name_Prov_K
				from tblVMWActivityCases as a
				left join tbliDesDetail as b on a.Rec_ID = b.Case_ID and b.Case_Type = 'VMW' and b.Days = '$day'
				join tblCensusVillage as c on a.ID = c.Code_Vill_T
				join tblCommune as d on c.Code_Comm_T = d.Code_Comm_T
				join tblDistrict as e on c.Code_Dist_T = e.Code_Dist_T
				join tblProvince as f on c.Code_Prov_T = f.Code_Prov_T
				left join tbliDes as g on a.Rec_ID = g.Case_ID and g.Case_Type = 'VMW'
				join tblHFCodes as h on c.HCCode = h.Code_Facility_T
				where a.Rec_ID = $id";
		$rs = $this->db->query($sql)->row_array();

		foreach ($rs as $key => $value)
		{
			if ($value === null) $rs[$key] = '';
		}

		$this->response($rs);
    }

	public function hc_update_post()
	{
		$data = $this->post();

		$where['Case_Type'] = $data['Case_Type'] = 'HC';
		$where['Case_ID'] = $data['Case_ID'];

		$main = $where;
		$main['DOB'] = $data['DOB'];
		$main['Occupation'] = $data['Occupation'];
		$main['Dose'] = $data['Dose'];
		$main['DoseTablet'] = $data['DoseTablet'];
		$main['DoseExpiration'] = $data['DoseExpiration'];
		$main['DoseBatch'] = $data['DoseBatch'];
		$main['Mg'] = $data['Mg'];
		$main['MgTablet'] = $data['MgTablet'];
		$main['MgExpiration'] = $data['MgExpiration'];
		$main['MgBatch'] = $data['MgBatch'];

		$count = $this->db->where($where)->count_all_results('tbliDes');
		if ($count == 0) {
			$this->db->insert('tbliDes', $main);
		} else {
            $main['ModiTime'] = sqlNow();
			$this->db->update('tbliDes', $main, $where);
		}

		$where['Days'] = $data['Days'];
		$this->db->delete('tbliDesDetail', $where);

		$arr = $this->db->list_fields('tbliDesDetail');

		$detail = [];
		foreach ($arr as $name)
		{
			$detail[$name] = $data[$name] ?? '';
		}
		$this->db->insert('tbliDesDetail', $detail);
	}

	public function vmw_update_post()
	{
		$data = $this->post();

		$where['Case_Type'] = $data['Case_Type'] = 'VMW';
		$where['Case_ID'] = $data['Case_ID'];

		$main = $where;
		$main['DOB'] = $data['DOB'];
		$main['Occupation'] = $data['Occupation'];
		$main['Dose'] = $data['Dose'];
		$main['DoseTablet'] = $data['DoseTablet'];
		$main['DoseExpiration'] = $data['DoseExpiration'];
		$main['DoseBatch'] = $data['DoseBatch'];
		$main['Mg'] = $data['Mg'];
		$main['MgTablet'] = $data['MgTablet'];
		$main['MgExpiration'] = $data['MgExpiration'];
		$main['MgBatch'] = $data['MgBatch'];

		$count = $this->db->where($where)->count_all_results('tbliDes');
		if ($count == 0) {
			$this->db->insert('tbliDes', $main);
		} else {
            $main['ModiTime'] = sqlNow();
			$this->db->update('tbliDes', $main, $where);
		}

		$where['Days'] = $data['Days'];
		$this->db->delete('tbliDesDetail', $where);

		$arr = $this->db->list_fields('tbliDesDetail');

		$detail = [];
		foreach ($arr as $name)
		{
			$detail[$name] = $data[$name] ?? '';
		}
		$this->db->insert('tbliDesDetail', $detail);
	}

	public function permission_post()
	{
		$where = $this->post();
		$count = $this->db->where($where)->count_all_results('tbliDesHC');
		$this->response($count);
	}

	public function followup_detail_post()
    {
		$id = $this->post('Case_ID');
		$type = $this->post('Case_Type');

		if ($type == 'HC') {
			$sql = "select a.Rec_ID as Case_ID, 'HC' as Case_Type, PatientCode, NameK
						  ,iif(Sex = 'M',N'ប្រុស',N'ស្រី') as Sex
						  ,Weight, dbo.ToSpecies(Diagnosis) as Species
						  ,null as G6PDDate, G6PDHb as G6PD, G6PDdL as Hemoglobin
						  ,case when Sex = 'F' and G6PDHb >= 6.1 then 'Normal'
								when Sex = 'F' and G6PDHb between 4.1 and 6 then 'Intermediate'
								when Sex = 'F' and G6PDHb <= 4 then 'Deficient'
								when Sex = 'M' and G6PDHb >= 4.1 then 'Normal'
								when Sex = 'M' and G6PDHb <= 4 then 'Deficient' end as G6PDLevel
						  ,isnull(Name_Vill_E,a.Code_Vill_t) as Name_Vill_E, Name_Facility_E
						  ,HFPhone, Hospital, HospitalPhone
						  ,ACTDay0Date, ACTDay0Checked, ACTDay1Date, ACTDay1Checked, ACTDay2Date, ACTDay2Checked
						  ,SLDDay0Date, SLDDay0Checked
						  ,Day0Date, Day0Checked, Day1Date, Day1Checked, Day2Date, Day2Checked, Day3Date, Day3Checked, Day4Date, Day4Checked
						  ,Day5Date, Day5Checked, Day6Date, Day6Checked, Day7Date, Day7Checked, Day8Date, Day8Checked, Day9Date, Day9Checked
						  ,Day10Date, Day10Checked, Day11Date, Day11Checked, Day12Date, Day12Checked, Day13Date, Day13Checked
						  ,Week1Date, Week1Checked, Week2Date, Week2Checked, Week3Date, Week3Checked, Week4Date, Week4Checked
						  ,Week5Date, Week5Checked, Week6Date, Week6Checked, Week7Date, Week7Checked, Week8Date, Week8Checked
					from tblHFActivityCases as a
					left join tblCensusVillage as b on a.Code_Vill_t = b.Code_Vill_T
					join tblHFCodes as c on a.ID = c.Code_Facility_T
					left join tbliDesFollowup as d on a.Rec_ID = d.Case_ID and d.Case_Type = 'HC'
					where a.Rec_ID = $id";
		} else {
			$sql = "select a.Rec_ID as Case_ID, 'VMW' as Case_Type, PatientCode, NameK
						  ,iif(Sex = 'M',N'ប្រុស',N'ស្រី') as Sex
						  ,Weight, dbo.ToSpecies(Diagnosis) as Species
						  ,null as G6PDDate, G6PDHb as G6PD, G6PDdL as Hemoglobin
						  ,case when Sex = 'F' and G6PDHb >= 6.1 then 'Normal'
								when Sex = 'F' and G6PDHb between 4.1 and 6 then 'Intermediate'
								when Sex = 'F' and G6PDHb <= 4 then 'Deficient'
								when Sex = 'M' and G6PDHb >= 4.1 then 'Normal'
								when Sex = 'M' and G6PDHb <= 4 then 'Deficient' end as G6PDLevel
						  ,Name_Vill_E, Name_Facility_E
						  ,HFPhone, Hospital, HospitalPhone
						  ,ACTDay0Date, ACTDay0Checked, ACTDay1Date, ACTDay1Checked, ACTDay2Date, ACTDay2Checked
						  ,SLDDay0Date, SLDDay0Checked
						  ,Day0Date, Day0Checked, Day1Date, Day1Checked, Day2Date, Day2Checked, Day3Date, Day3Checked, Day4Date, Day4Checked
						  ,Day5Date, Day5Checked, Day6Date, Day6Checked, Day7Date, Day7Checked, Day8Date, Day8Checked, Day9Date, Day9Checked
						  ,Day10Date, Day10Checked, Day11Date, Day11Checked, Day12Date, Day12Checked, Day13Date, Day13Checked
						  ,Week1Date, Week1Checked, Week2Date, Week2Checked, Week3Date, Week3Checked, Week4Date, Week4Checked
						  ,Week5Date, Week5Checked, Week6Date, Week6Checked, Week7Date, Week7Checked, Week8Date, Week8Checked
					from tblVMWActivityCases as a
					join tblCensusVillage as b on a.ID = b.Code_Vill_T
					join tblHFCodes as c on b.HCCode = c.Code_Facility_T
					left join tbliDesFollowup as d on a.Rec_ID = d.Case_ID and d.Case_Type = 'VMW'
					where a.Rec_ID = $id";
		}

		$rs = $this->db->query($sql)->row_array();

		if ($rs !== null) {
			foreach ($rs as $key => $value)
			{
				if (strContain($key, 'Date')) continue;
				if ($value === null) {
					$rs[$key] = strContain($key, 'Checked') ? 0 : '';
				}
			}
		}

		$this->response($rs);
    }

	public function followup_update_post()
    {
		$data = $this->post();

		$where['Case_ID'] = $data['Case_ID'];
		$where['Case_Type'] = $data['Case_Type'];

		$follow = [];
		$arr = $this->db->list_fields('tbliDesFollowup');
		foreach ($arr as $name)
		{
			if ($name != 'Rec_ID') $follow[$name] = $data[$name];
			if (strContain($name, 'Date') && $follow[$name] === '') $follow[$name] = null;
		}

		$count = $this->db->where($where)->count_all_results('tbliDesFollowup');
		if ($count == 0) {
			$this->db->insert('tbliDesFollowup', $follow);
		} else {
			$this->db->update('tbliDesFollowup', $follow, $where);
		}
	}

    public function summary_get()
    {
        $prov = $this->get('province');
		$od = $this->get('od');
		$year = $this->get('year');
		$mf = $this->get('month_from');
		$mt = $this->get('month_to');

        $data['eligible'] = $this->getEligible($prov, $od, $year, $mf, $mt);

        $data['numberIdes'] = $this->getNumberIdes($prov, $od, $year, $mf, $mt);

        $data['doneByDay'] = $this->getDoneByDay($prov, $od, $year, $mf, $mt);

        $response = [
		    "code" => 200,
		    "message" => "success",
		    "data" => $data
		];

		$this->response($response);
    }

    private function getEligible($prov, $od, $year, $mf, $mt)
    {
        $where = '';
        if(!empty($prov)){
            $where .= " and Code_Prov_N = '$prov'";
        }
        if(!empty($od)){
            $where .= " and Code_OD_T = '$od'";
        }
        if(!empty($year)){
            $where .= " and a.year = '$year'";
        }
        if(!empty($mf))  {
            $where .= " and a.Month between $mf and $mt";
        }

        $sql = "WITH T as (
	            select ID as HcCode, 1 as PostiveCase, a.Month, a.Year
	            from V_HFActivityCases as a
	            join tbliDesHC as b on a.ID = b.Code_Facility_T
	            where Positive = 'P' and Exclude = 0
	            and Year >= 2022

	            union all

	            select HCCode, 1 as PostiveCase, a.Month, a.Year
	            from V_VMWActivityCases as a
	            join V_CensusVillage as b on a.ID = b.Code_Vill_T and a.Year = b.Year
	            join tbliDesHC as c on b.HCCode = c.Code_Facility_T
	            where Positive = 'P' and Exclude = 0
	            and a.Year >= 2022
            )

            select sum(PostiveCase) as TotalEligible from T as a
            join tblHFCodes as b on b.Code_Facility_T = a.HcCode
            where 1=1 $where";

        return $this->db->query($sql)->row('TotalEligible');
    }

    private function getNumberIdes($prov, $od, $year, $mf, $mt)
    {
        $where = '';
        if(!empty($prov)){
            $where .= " and Code_Prov_N = '$prov'";
        }
        if(!empty($od)){
            $where .= " and Code_OD_T = '$od'";
        }
        if(!empty($year)){
            $where .= " and a.year = '$year'";
        }
        if(!empty($mf))  {
            $where .= " and a.Month between $mf and $mt";
        }

        $sql = "WITH T as (
	            select ID as HCCode, Month, Year, 1 as Ides from tbliDes as a
	            join V_HFActivityCases as b on a.Case_ID = b.Rec_ID and Case_Type = 'HC'

	            union all

	            select HCCode, Month, Year, 1 as Ides from tbliDes as a
	            join V_VMWActivityCases as b on a.Case_ID = b.Rec_ID and Case_Type = 'VMW'
	            join tblCensusVillage as c on b.ID = c.Code_Vill_T
            )

            select count(*) as didIdes from T as a
            join tblHFCodes as b on a.HCCode = b.Code_Facility_T
            where 1=1 $where";

        return $this->db->query($sql)->row('didIdes');
    }

    private function getDoneByDay($prov, $od, $year, $mf, $mt)
    {
        $where = '';
        if(!empty($prov)){
            $where .= " and Code_Prov_N = '$prov'";
        }
        if(!empty($od)){
            $where .= " and Code_OD_T = '$od'";
        }
        if(!empty($year)){
            $where .= " and a.year = '$year'";
        }
        if(!empty($mf))  {
            $where .= " and a.Month between $mf and $mt";
        }

        $sql = "WITH T as (
	            select ID as HCCode, Month, Year, Days from tbliDesDetail as a
	            join V_HFActivityCases as b on a.Case_ID = b.Rec_ID and Case_Type = 'HC'

	            union all

	            select HCCode, Month, Year, Days from tbliDesDetail as a
	            join V_VMWActivityCases as b on a.Case_ID = b.Rec_ID and Case_Type = 'VMW'
	            join tblCensusVillage as c on b.ID = c.Code_Vill_T
            )

            select Days, count(Days) as Number from T as a
            join tblHFCodes as b on a.HCCode = b.Code_Facility_T
            where 1=1 $where
            group by Days
            order by cast(substring(Days,2,4) as int)";

        return $this->db->query($sql)->result();
    }
}