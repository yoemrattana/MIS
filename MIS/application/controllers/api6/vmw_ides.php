<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class vmw_ides extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

    public function list_get()
    {
        $year = $this->get('Year');
		$code = $this->get('Code_Place');

        $masters = $this->isVMW($code) ? $this->getList($year, $code) : $this->getListByHc($year, $code);

        $data = [];
        foreach($masters as $r){
            $r['Details'] = $this->getDetails($r['Case_ID']);

            array_push($data, $r);
        }

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
    }

    public function followup_get()
    {
        $year = $this->get('Year');
		$code = $this->get('Code_Place');

        $masters = [];
        if( $this->isVMW($code) ) {
            $masters = $this->getList($year, $code);
        } else {
            $masters = $this->getListByHc($year, $code);
        }

        $data = [];
        foreach($masters as $r){
            $r['Detail'] = $this->getFollowupDetail($r['Case_ID']);

            array_push($data, $r);
        }

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
    }

    private function isVMW($code)
    {
        return strlen($code) == 10;
    }

    private function getList($year, $code)
    {
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

		return $this->db->query($sql)->result_array();
    }

    private function getListByHc($year, $code)
    {
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
				left join tbliDesDetail as b on a.Rec_ID = b.Case_ID and b.Case_Type = 'VMW'
				left join tbliDesFollowup as c on b.Case_ID = c.Case_ID and b.Case_Type = c.Case_Type
                join tblCensusVillage as d on a.ID = d.Code_Vill_T
				where Positive = 'P' and Year = '$year' and HCCode = '$code'
				group by Month, a.Rec_ID, NameK, Age, Sex, Diagnosis, DateCase, c.Case_ID
				order by NameK";

		return $this->db->query($sql)->result_array();
    }

    private function getDetails($id)
    {
        $days = ['D0','D1','D2','D3','D7','D14','D28','D42','D90',];

        $details = [];
        foreach($days as $day) {
            $details[] = $this->getDetail($id, $day);
        }
        return $details;
    }

    private function getDetail($id, $day)
    {
        $d = substr($day, 1);
        $sql = "select a.Rec_ID as Case_ID
					  ,convert(date,a.InitTime) as NotificationDate
					  ,convert(date,DateCase) as DiagnosisDate
					  ,convert(date,DateCase) as InvestigationDate
					  ,NameK as FirstName, '' as LastName
					  ,iif(Sex = 'M',N'ប្រុស',N'ស្រី') as Sex
					  ,Age, convert(int,Weight) as Weight, DOB, Occupation, PatientPhone as Phone
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
			if (($d == 3 || $d == 7) && $rs['G6PDNormalPQ'] == '') $rs['G6PDNormalPQ'] = $rs['ExpectedDate'];
		}

        return $rs;
    }

    private function getFollowupDetail($caseId)
    {
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
					where a.Rec_ID = $caseId";

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

        return $rs;
    }

}