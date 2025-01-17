<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

	function getOverViewData($year,$from,$to,$prov,$fdc)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $data['net'] = $this->db->query("SP_Dashboard_OverviewNet $year,$from,$to,'$prov',$fdc")->result();
        $data['cases'] = $this->db->query("SP_Dashboard_OverviewCase $year,$from,$to,'$prov',$fdc")->result();
        $data['casesCountry'] = $this->db->query("SP_Dashboard_OverviewCaseCountry $year,$from,$to,'$prov',$fdc")->result();
        $data['chart'] = $this->db->query("SP_Dashboard_OverviewChart $year,$from,$to,'$prov',$fdc")->result();
        $data['chartCaseDeathSpecie'] = $this->db->query("SP_Dashboard_ChartCaseDeathSpecie $year,$from,$to,'$prov',$fdc")->result();
        $data['chartSexAge'] = $this->db->query("SP_Dashboard_ChartSexAge $year,$from,$to,'$prov',$fdc")->result();
        $data['chartSpecieProvince'] = $this->db->query("SP_Dashboard_ChartSpecieProvince $year,$from,$to,'$prov',$fdc")->result();
        $data['chartIncidentMortality'] = $this->db->query("SP_Dashboard_ChartIncidentMortality $year,$from,$to,'$prov',$fdc")->result();
        $data['chartTop30HF'] = $this->db->query("SP_Dashboard_ChartTop30HF $year,$from,$to,'$prov',$fdc")->result();
        $data['chartTop30Vill'] = $this->db->query("SP_Dashboard_ChartTop30Vill $year,$from,$to,'$prov',$fdc")->result();
        $data['foci'] = $this->getFociClassification( $prov );
        $data['lastMile'] = $this->db->query("SP_Dashboard_Lastmile $year,$from,$to,'$prov',$fdc")->result();
		if ($year > 2023) $data['mneElimination'] = $this->db->query("SP_V1_MnEEliminationRai4 $year,$from,$to,'$prov','','',''")->row();
		else $data['mneElimination'] = $this->db->query("SP_Dashboard_MnEElimination $year,$from,$to,'$prov',$fdc")->row();
        $data['radicalCure'] = $this->getRadicalCure($year, $from, $to, $prov);
        $data['riskPop'] = $this->getRiskPop($year, $prov);
        $data['slides'] = $this->db->get('tblBlog')->result();
        $data['caseInvestigate'] = $this->db->query("SP_Dashboard_OverviewCI $year,$from,$to,'$prov',$fdc")->result();
        return $data;
    }

    function getFociClassification( $prov = null)
	{
		$years = [2020,2021,2022,2023,2024];
        $data=[];
        foreach($years as $year){
            $rs = $this->db->query("SP_Dashboard_OverviewFoci $year,null,null,'$prov'")->row_array();
            $data[] = [
                'Year' => $year,
                'Active' => $rs['Active'],
                'Residual' => $rs['Residual'],
                'Cleared' => $rs['Cleared']
            ];
        }

		return $data;
	}

    function getRadicalCure($year, $mf, $mt, $prov)
    {
        $sql = "WITH cases as (
	            select ID as HCCode
		              ,G6PD, G6PDHb, G6PDdL
		              ,iif(Primaquine15 > 0 or Primaquine75 > 0 or PQTreatment = 'ASMQ + 14 days PQ',1,0) as Primaquine
		              ,DateCase, Weight, Sex
		              ,iif(Sex = 'F' and PregnantMTHS between '1' and '9',1,0) as Pregnant
	            from V_HFActivityCases
	            where Year = $year and Month between $mf and $mt and Diagnosis in ('V','M')

	            union all

	            select HCCode
		              ,G6PD, G6PDHb, G6PDdL
		              ,iif(Primaquine15 > 0 or Primaquine75 > 0 or PQTreatment = 'ASMQ + 14 days PQ',1,0) as Primaquine
		              ,DateCase, Weight, Sex
		              ,iif(Sex = 'F' and PregnantMTHS between '1' and '9',1,0) as Pregnant
	            from V_VMWActivityCases as a
	            join V_CensusVillage as b on a.ID = b.Code_Vill_T and a.Year = b.Year
	            where a.Year = $year and Month between $mf and $mt and Diagnosis in ('V','M')
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
            where a.IsTarget = 1 and (IsReminder = 1 or G6PDHb > 0 or G6PD <> '') and ('$prov' = '' or '$prov' = a.Code_Prov_N)";

		return $this->db->query($sql)->row();
    }

    function getRiskPop($year, $prov)
    {
		$sql = "select sum(High) as High, sum(Medium) as Medium, sum(Low) as Low, sum(No) as No
				from tblRiskPopV2
				where Year = $year and ('$prov' = '' or '$prov' = Code_Prov_T)";

		return $this->db->query( $sql )->row();
    }

}

?>