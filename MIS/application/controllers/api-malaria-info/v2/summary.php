<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Summary extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput('api_input_cmi.txt');
	}

    public function list_get()
    {

        $data['blog'] = $this->getSlideShow();

        $data['todayCase'] = $this->getCaseToday();

		$this->db->cache_on();
        $data['weeklyCase'] = $this->getCaseThisWeek();

        $data['monthlyCase'] = $this->getCaseThisMonth();

        $data['yearlyCase'] = $this->getCaseThisYear();

        $data['fociClassification'] = $this->getFociClassification();

        $data['healthWorker'] = $this->getHealthWorker();

        $mne = $this->getMnEElimination();

        $caseNotify = [
            'Positive' => $mne['Positive'],
            'Notify' => $mne['Classify'],
            'Notify24' => $mne['Notify24'],
        ];

        $data['caseNotify'] = $caseNotify;

        $fociInvestigation = [
            'FociEligible' => $mne['FociNeed'],
            'Foci' => $mne['Foci'],
            'Foci7d' => $mne['Foci7d'],
        ];

        $data['fociInvestigation'] = $fociInvestigation;

        $data['popAtRisk'] = $this->getRiskPop();

        $data['yearlyPatient'] = $this->getPatientThisYear();

		$this->db->cache_off();

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
    }

    private function getCaseToday()
	{

		$sql = "WITH T as
				(
					select ID as HCCode, Month, Year, NameK, Diagnosis, DateCase, Positive from tblHFActivityCases

					union all

					select HCCode, Month, Year, NameK, Diagnosis, a.DateCase, Positive from tblVMWActivityCases as a
					join tblCensusVillage as b on b.Code_Vill_T = a.ID
				)

				select isnull(sum(iif(Diagnosis = 'F',1,0)), 0) as PF,
					isnull(sum(iif(Diagnosis = 'V',1,0)), 0) as PV,
					isnull(sum(iif(Diagnosis = 'M',1,0)), 0) as Mix,
                    isnull(sum(iif(Diagnosis = 'A',1,0)), 0) as Pm,
                    isnull(sum(iif(Diagnosis = 'O',1,0)), 0) as Po,
                    isnull(sum(iif(Diagnosis = 'K',1,0)), 0) as Pk,
					count(*) as Total
				from T as a
				join tblHFCodes as b on b.Code_Facility_T = a.HCCode
				where Positive = 'P'
				and CAST(a.DateCase as DATE) = CAST(GETDATE() as DATE)
				and IsTarget = 1";

		return $this->db->query($sql)->row();
	}

    private function getCaseThisWeek()
	{
		$from = date("Y-m-d", strtotime('monday this week'));
		$to = date("Y-m-d");

		$sql = "WITH T as
				(
					select ID as HCCode, Month, Year, NameK, Diagnosis, DateCase, Positive from tblHFActivityCases

					union all

					select HCCode, Month, Year, NameK, Diagnosis, a.DateCase, Positive from tblVMWActivityCases as a
					join tblCensusVillage as b on b.Code_Vill_T = a.ID
				)

				select isnull(sum(iif(Diagnosis = 'F',1,0)), 0) as PF,
					isnull(sum(iif(Diagnosis = 'V',1,0)), 0) as PV,
					isnull(sum(iif(Diagnosis = 'M',1,0)), 0) as Mix,
                    isnull(sum(iif(Diagnosis = 'A',1,0)), 0) as Pm,
                    isnull(sum(iif(Diagnosis = 'O',1,0)), 0) as Po,
                    isnull(sum(iif(Diagnosis = 'K',1,0)), 0) as Pk,
					count(*) as Total
				from T as a
				join tblHFCodes as b on b.Code_Facility_T = a.HCCode
				where Positive = 'P'
				and CAST(a.DateCase as Date) between '{$from}' and '{$to}'
				and IsTarget = 1";

		return $this->db->query($sql)->row();
	}

    private function getCaseThisMonth()
	{
		return $this->db->query("SP_API_CaseMonthly")->row();
	}

    private function getCaseThisYear()
	{
		return $this->db->query("SP_API_CaseLastCurrentYear")->row();
	}

    private function getPatientThisYear()
	{
		return $this->db->query("SP_API_PatientLastCurrentYear")->row();
	}

    private function getFociClassification()
	{
        $year = date('Y');
        $data = $this->db->query("SP_Dashboard_OverviewFoci $year,null,null,''")->row_array();
		return $data;
	}

    private function getMnEElimination()
    {
        $year = 2023;
        $from = 1;
        $to=12;
        $prov = null;
        $fdc = 0;

        return $this->db->query("SP_Dashboard_MnEElimination $year,$from,$to,'$prov',$fdc")->row_array();
    }

    private function getHealthWorker()
	{
		$year = date('Y');

		$data = [];

		$sql = "select sum(Pop) PopAtRisk from V_PopByVillages as a
				join tblCensusVillage as b on b.Code_Vill_T = a.Code_Vill_T
				join tblHFCodes as c on Code_Facility_T = b.HCCode
				where IsTarget = 1 and Year = {$year}";

		$data[] = $this->db->query($sql)->row_array();

		$sql = "select count(*) Village from tblCensusVillage as a
				join tblHFCodes as b on b.Code_Facility_T = a.HCCode
				where IsTarget = 1 and (Name_Vill_E not like '%(M)%' or Name_Vill_K not like '%(M)%')";

		$data[] = $this->db->query($sql)->row_array();

		$sql = "select count(*) as MMW from tblCensusVillage as a
				join tblHFCodes as b on a.HCCode =  b.Code_Facility_T
				where HaveVMW = 1 and IsTarget = 1
				and (Name_Vill_E like '%(M)%')";

		$data[] = $this->db->query($sql)->row_array();

		$sql = "select count(*) as VMW from tblCensusVillage as a
				join tblHFCodes as b on a.HCCode =  b.Code_Facility_T
				where HaveVMW = 1 and IsTarget = 1
				and (Name_Vill_E not like '%(M)%')";

		$data[] = $this->db->query($sql)->row_array();

		$sql = "select Count(*) as HC from tblHFCodes where IsTarget = 1";

		$data[] = $this->db->query($sql)->row_array();

		$sql = "select Count(*) as OD from tblOD where IsTarget = 1";

		$data[] = $this->db->query($sql)->row_array();

		$sql = "select Count(*) as Province from tblProvince where IsTarget = 1";

		$data[] = $this->db->query($sql)->row_array();

        $rs = array_reduce($data, 'array_merge', array());

		return $rs;
	}

    //TODO remove
    private function getRadicalCure()
	{
		$year = date('Y');

		$sql = "select count(*) as Pv, sum(G6PDTest) as G6PDTest, sum(G6PDNormal) as G6PDNormal, sum(Primaquine) as Primaquine
				from (
					select iif(PQTreatment = 'ASMQ + 14 days PQ' or Primaquine15 > 0 or Primaquine75 > 0,1,0) as Primaquine
						  ,iif(G6PDHb > 0 or G6PDdL > 0 or G6PD <> '',1,0) as G6PDTest
						  ,iif((G6PDHb > 6 and G6PDdL > 9) or G6PD = 'Normal',1,0) as G6PDNormal
					from tblVMWActivityCases as a
					join tblCensusVillage as b on a.ID = b.Code_Vill_T
					where Diagnosis in ('V','M') and Year = '$year'

					union all

					select iif(Primaquine15 > 0 or Primaquine75 > 0,1,0) as Primaquine
						  ,iif(G6PDHb > 0 or G6PDdL > 0 or G6PD <> '',1,0) as G6PDTest
						  ,iif((G6PDHb > 6 and G6PDdL > 9) or G6PD = 'Normal',1,0)
					from tblHFActivityCases
					where Diagnosis in ('V','M') and Year = '$year'
				) as a";

		return $this->db->query($sql)->row();
	}

    public function daily_case_get()
    {
        $sql = $this->getCaseSql();
        $sql .= " where CAST(DateCase as DATE) = CAST(GETDATE() as DATE)";
        $sql .= " order by Rec_ID desc";

        $rs = $this->db->query( $sql )->result();

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
    }

    public function weekly_case_get()
    {
        $from = date("Y-m-d", strtotime('monday this week'));
		$to = date("Y-m-d");

        $sql = $this->getCaseSql();
        $sql .= "where CAST(DateCase as Date) between '{$from}' and '{$to}' order by Rec_ID desc";
        //$sql .= " where Year = Year(GETDATE()) and Month = Month(GETDATE())";
       // $sql .= " and CAST(DateCase as Date) between '{$from}' and '{$to}' order by Name_OD_E, Name_Facility_E";

        $rs = $this->db->query( $sql )->result();

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
    }

    public function monthly_case_get()
    {
        $sql = $this->getCaseSql();
        $sql .= " where Year = Year(GETDATE()) and Month = Month(GETDATE())";
        $sql .= " order by Rec_ID desc";

        $rs = $this->db->query( $sql )->result();

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
    }

    private function getCaseSql()
    {
        return "WITH T as (
	            select
	            d.Name_Prov_E, c.Name_OD_E,Name_Facility_E, iif(Name_Vill_E is null, a.Code_Vill_t, Name_Vill_E) as Village
	            , Month, Year, NameK, Diagnosis, Age, Sex, DateCase
				,CASE WHEN L1=1 THEN 'L1'
				WHEN LC=1 THEN 'LC'
				WHEN IMP = 1 THEN 'IMP'
				WHEN Relapse = 1 THEN 'Relapse'
				END as Clasify, a.Rec_ID
	            from tblHFActivityCases as a
	            left join tblCensusVillage as b on a.Code_Vill_t = b.Code_Vill_T
	            join tblHFCodes as c on a.ID = c.Code_Facility_T
				join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
	            where Diagnosis in ('F', 'V', 'M') and c.IsTarget=1

	            union all

	            select
	            d.Name_Prov_E,c.Name_OD_E,Name_Facility_E,Name_Vill_E,
	            Month, Year, NameK, Diagnosis, Age, Sex, DateCase
				,CASE WHEN L1=1 THEN 'L1'
				WHEN LC=1 THEN 'LC'
				WHEN IMP = 1 THEN 'IMP'
				WHEN Relapse = 1 THEN 'Relapse'
				END as Clasify, a.Rec_ID
	            from tblVMWActivityCases as a
	            join tblCensusVillage as b on b.Code_Vill_T = a.ID
	            join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
	            where Diagnosis in ('F', 'V', 'M') and c.IsTarget=1
            )

            select * from T  ";
    }

    private function getSlideShow()
    {
        $sql = "select * from tblBlog";
        $rs = $this->db->query($sql)->result_array();

        array_walk($rs, function (&$a, $k) {
		    $a['Thumbnail'] = $_SERVER['SERVER_NAME'] . '/media/blog/' . $a['Thumbnail'];
		    unset( $a['InitUser'] );
		});

        return $rs;
    }

    private function getRiskPop(){
        $sql = "select * from tblRiskPop where Year = Year(GETDATE())";
        return $this->db->query($sql)->row();
    }
}