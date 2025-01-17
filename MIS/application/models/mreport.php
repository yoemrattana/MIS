<?php
class MReport extends CI_Model
{
	function search_positive_case($options){

		$hf =  $options['hc_code'];
		$month = $options['month'];
		$year = $options['year'];

		$rs = $this->db->query("SP_API_InvCases '$hf', $year, $month")->result_array();

		return $rs;
	}

	function build_search_query($tableName, $options, $case='_HC'){
		if($tableName == 'tblHFActivityCases'){
			$sql = "SELECT tblCase.Rec_Id, tblCase.ID, tblCase.NameK, tblCase.Diagnosis,
							tblCase.Year, tblCase.Month, tblCase.Code_Vill_t, tblCase.Age, tblCase.Sex, tblCase.ID,
							(Select Count(Passive_Case_Id)  from tblInvestigationCases
								Where Passive_Case_Id = CONCAT(tblCase.Rec_ID, '$case'))as Is_Investigated
			        FROM ".$tableName." as tblCase
							WHERE (Diagnosis = 'F' OR Diagnosis = 'M')";
			if($options['hc_code'] != NULL){
				$sql = $sql." AND tblCase.ID = '".$options['hc_code']."'";
			}
		}else{
			$sql = "SELECT tblCase.Rec_Id, tblCase.ID, tblCase.NameK, tblCase.Diagnosis,
							tblCase.Year, tblCase.Month, tblCase.ID as Code_Vill_t, tblCase.Age, tblCase.Sex, tblCensusVillage.HCCode,
							(Select Count(Passive_Case_Id)  from tblInvestigationCases Where Passive_Case_Id = CONCAT(tblCase.Rec_ID, '$case'))as Is_Investigated
			        FROM ".$tableName." as tblCase
							JOIN tblCensusVillage ON tblCensusVillage.Code_Vill_T = tblCase.ID
							WHERE (Diagnosis = 'F' OR Diagnosis = 'M')";
			if($options['hc_code'] != NULL){
				$sql = $sql." AND tblCensusVillage.HCCode = '".$options['hc_code']."'";
			}
		}


		if($options['year'] != NULL){
			$sql = $sql." AND Year ='".$options['year']."'";
		}

		if($options['month'] != NULL){
			$sql = $sql." AND Month ='".$options['month']."'";
		}
		return $sql;
	}

	public function search_investigation_cases($positive_ids){
		$sql = "Select ID as Investigation_Case_Id, Passive_Case_Id, Name_K, Age, Gender, Vill_Of_Residence, Dob, Tel,
						(Select count(ID) from tblReactiveCases Where tblReactiveCases.Passive_Case_Id = tblInvestigationCases.Passive_Case_Id)
						As Is_Reactive
						From tblInvestigationCases
						Where Passive_Case_Id In (".implode(',',$positive_ids).")
						and (Sleep_Every_Night_In_This_Vill = 1 or Sleep_At_Least_One_Night_In_Other_Village_In_Same_HC = 1)";

		$result = array();
		$Q = $this->db->query($sql);
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$result[] = [
					"Investigation_Case_Id" =>  $row['Investigation_Case_Id'],
					"Passive_Case_Id" =>  $row['Passive_Case_Id'],
					"Name_K" => $row['Name_K'],
					"Age" => $row['Age'],
					"Gender" => $row['Gender'],
					"Vill_Of_Residence" => $row['Vill_Of_Residence'],
					"Dob" => $row['Dob'],
					"Tel" => $row['Tel'],
					"Is_Reactive" => $row['Is_Reactive']
				];
			}
		}
		return $result;

	}

	public function get_investigation_case($passive_case_id){
		$sql = "Select * from tblInvestigationCases Where Passive_Case_Id='".$passive_case_id."'";
		$Q = $this->db->query($sql);
		if ($Q->num_rows() > 0){
			return $Q->result_array();
		}
		return NULL;
	}

	public function get_reactive_cases($passive_case_id){
		$sql = "Select * from tblReactiveCases Where Passive_Case_Id = '$passive_case_id'";
		$Q = $this->db->query($sql);
		if ($Q->num_rows() > 0){
			return $Q->result_array();
		}
		return [];
	}

	public function getNotifySpecies()
	{
		$sql = "select Value from tblSetting where Name = 'NotifySpecies'";
		$species = $this->db->query($sql)->row_array();
		$species = str_replace(' ', '', $species['Value']);
		return explode(',', $species);
	}

	public function getTotalCase($hc_code, $month, $year)
	{
		$sql = "WITH T as
				(
					select Year, Month, ID as HCCode, Positive, RDT, Microscopy, Diagnosis, 'HF' as Type
					from tblHFActivityCases
					union all
					select Year, Month, HCCode, Positive, 1 as RDT, 0 as Microscopy,Diagnosis, 'VMW' as Type
					from tblVMWActivityCases as a
					join tblCensusVillage as b on a.ID = b.Code_Vill_T
				)

				select sum(iif(Diagnosis = 'F', 1, 0)) as Pf
							,sum(iif(Diagnosis = 'V', 1, 0)) as Pv
							,sum(iif(Diagnosis = 'M', 1, 0)) as Mix
							,sum(iif(Positive = 'P', 1, 0)) as Positive
							,count(*) as Test
				from T
				where HCCode = '{$hc_code}'
				and Month = '{$month}'
				and Year = '{$year}'";

		return $this->db->query($sql)->row_array();
	}

	public function getVmwTotalCase($hc_code, $month, $year)
	{
		$sql = "WITH T as
				(
					select Year, Month, HCCode, Positive, 1 as RDT, 0 as Microscopy,Diagnosis, 'VMW' as Type
					from tblVMWActivityCases as a
					join tblCensusVillage as b on a.ID = b.Code_Vill_T
				)

				select sum(iif(Diagnosis = 'F', 1, 0)) as Pf
							,sum(iif(Diagnosis = 'V', 1, 0)) as Pv
							,sum(iif(Diagnosis = 'M', 1, 0)) as Mix
							,sum(iif(Positive = 'P', 1, 0)) as Positive
							,count(*) as Test
				from T
				where HCCode = '{$hc_code}'
				and Month = '{$month}'
				and Year = '{$year}'";

		return $this->db->query($sql)->row_array();
	}

	public function getHcTotalCase($hc_code, $month, $year)
	{
		$sql = "WITH T as
				(
					select Year, Month, ID as HCCode, Positive, RDT, Microscopy, Diagnosis, 'HF' as Type
					from tblHFActivityCases
				)

				select sum(iif(Diagnosis = 'F', 1, 0)) as Pf
							,sum(iif(Diagnosis = 'V', 1, 0)) as Pv
							,sum(iif(Diagnosis = 'M', 1, 0)) as Mix
							,sum(iif(Positive = 'P', 1, 0)) as Positive
							,count(*) as Test
				from T
				where HCCode = '{$hc_code}'
				and Month = '{$month}'
				and Year = '{$year}'";

		return $this->db->query($sql)->row_array();
	}

    public function getTreatments()
    {
        $sql = "select Treatment, Description from tblTreatment";
		$rs = $this->db->query($sql)->result_array();
        $treatments = array_column($rs, 'Treatment', 'Description');
        return $treatments;
    }

    public function isIP2($reports)
    {
        $length = is_array($reports) ? count($reports) : 0;
        $isIP2 = false;
		if ($length > 0) {
			$villcode = $reports[0]['User_Code_Fa_T'];
			$sql = "select IP2 from tblCensusVillage where Code_Vill_T = '$villcode'";
			$isIP2 = $this->db->query($sql)->row('IP2') == 1;
		}
        return $isIP2;
    }

    public function getVmwSummary($where)
    {
        $sql = "select
                sum(iif(Diagnosis <> 'S',1,0)) as Test,
                sum(iif(Diagnosis = 'N',1,0)) as Negative,
                sum(iif(Positive = 'P',1,0)) as Positive,
                sum(iif(Diagnosis = 'F',1,0)) as Pf,
                sum(iif(Diagnosis = 'V',1,0)) as Pv,
                sum(iif(Diagnosis = 'M',1,0)) as Mix,
                sum(iif(Diagnosis in ('A', 'O', 'K'),1,0)) as Other,
                sum(iif(Refered =1, 1,0)) as Referred,
                sum(iif(Relapse =1, 1,0)) as Relapse,
                sum(iif(Recrudescence =1, 1,0)) as Recrudescence,
                sum(iif(LocallyAcquired =1, 1,0)) as LocallyAcquired,
                sum(iif(DomesticallyImported =1, 1,0)) as DomesticallyImported,
                sum(iif(InternationalImported =1, 1,0)) as InternationalImported
                from tblVMWActivityCases
                $where";

        return $this->db->query($sql)->result();
    }

    public function getVmwList($where)
    {
        $sql = "select Year,Month,DateCase,NameK,Age,Sex,PregnantMTHS,Weight,Temperature,Mobile,Diagnosis,Treatment,OtherTreatment,Primaquine,ASMQ,DOT1, DOT3 'Dot3days',Refered,ReferedReason, ReferedOtherReason,Dead
	                ,Remark,ID,1 as NumberTests,Rec_ID,Is_Mobile_Entry,Passive, PatientCode, PatientPhone, PQTreatment, G6PD, IsConsult, IsACT, IsPrimaquine, Primaquine15, Primaquine75, PrimaquineDate
	                ,G6PDHb as G6PDdL,G6PDdL as G6PDHb, Relapse,Fingerprint, RdtImage, DiagnosisScan
                    ,EverHadMalaria, a.Code_Vill_T,b.Code_Prov_T,b.Code_Dist_T, b.Code_Comm_T, SymptomDate, ReferredFromService, ReferredFromServiceOther, Recrudescence, LocallyAcquired, DomesticallyImported, InternationalImported, Suspect
                from tblVMWActivityCases as a
                left join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				$where order by Rec_ID";

       return $this->db->query($sql)->result();
    }

    public function getWormAbet($codeVill, $year, $month)
    {
        $sql = "select * from tblVMWWormAbet
                where Code_Vill_T = '$codeVill' and Year = $year and Month= $month";

        return $this->db->query( $sql )->result();
    }

    public function getVmwEdu($codeVill, $year, $month)
    {
        $sql = "select * from tblVMWEdu
                where Code_Vill_T = '$codeVill' and Year = $year and Month= $month";

        return $this->db->query( $sql )->result();
    }
}