<?php
require_once FCPATH.'/vendor/autoload.php';
use Message\SingleMessage;
use Message\MessageSender;
use Message\GroupMessage;

class Cron_model extends CI_Model
{
    public function __construct()
	{
		parent::__construct();
		$this->load->model('MPatient');
		$this->load->model('Token_model');
		$this->load->model('Template_model');
		$this->load->model('HFFollowup_model');
		$this->load->model('VMWFollowup_model');
		$this->load->model('Cron_model');
        $this->load->model('Ides_model');
		$this->load->model('Log_model');
        $this->load->model('Stock_model');
	}

	public function getHighRiskVillages()
	{
		$rs = $this->db->query("SP_V1_HighRiskVillage '','','','','','','','' ")->result_array();
		return $rs;
	}

	public function getCase()
	{
		$threshold = $this->db->get_where('tblSetting', ['Name' => 'Threshold'])->row('Value');
		$threshold = (int) $threshold;

		$sql = "with t1 as
				(
					select Code_OD_T from tblCaseLog where Notified = 0
					group by Code_OD_T having count(Code_OD_T) >= {$threshold}

				),
				 t2 as
				(
					select * from tblCaseLog where Notified = 0
				)

				select Rec_ID, Case_Id, Type from t1
				join t2 on t1.Code_OD_T = t2.Code_OD_T";

		$logs = $this->db->query($sql)->result_array();

		if (empty($logs)) return [];

		$this->load->model('MPatient');

		$cases = [];
		foreach ($logs as $log) {
			$case = $this->MPatient->getCase($log['Case_Id'], strtolower($log['Type']));
			array_push($cases, $case);
		}

		return $cases;
	}

    public function getFociClassification( $prov = null)
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

    public function getRadicalCure($year, $mf, $mt, $prov)
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

    public function getRiskPop($year)
    {
        return $this->db->get_where('tblRiskPop', ['Year' => $year] )->row();
    }

	/*Case alert*/
	public function getPatients()
    {
        $sql = "WITH T as (
				select a.Rec_ID, ID, NameK, PatientCode, Age, Sex, ISNULL(PatientPhone, 'N/A') as PatientPhone, iif(ISNUMERIC(Code_Vill_t) = 0, cast(Code_Vill_t as nvarchar), 'N/A') as Name_Vill_K,
				L1, LC, IMP, Diagnosis, Year, IsNotified, 'HC' as EntryBy, 'tblHFActivityCases' as tblName, OldDiagnosis
				from tblHFActivityCases as a
				where ISNUMERIC(a.Code_Vill_t) = 0 or (ISNUMERIC(a.Code_Vill_t) = 1 and len(a.Code_Vill_t) < 10)

				union all

				select a.Rec_ID, ID, NameK, PatientCode, Age, Sex, ISNULL(PatientPhone, 'N/A') as PatientPhone, ISNULL(Name_Vill_K collate Thai_100_BIN, 'N/A') as Name_Vill_K,
				L1, LC, IMP, Diagnosis, Year, IsNotified, 'HC' as EntryBy, 'tblHFActivityCases' as tblName, OldDiagnosis
				from tblHFActivityCases as a
				left join tblCensusVillage as b on a.Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS = b.Code_Vill_T
				where ISNUMERIC(a.Code_Vill_t) = 1 and len(a.Code_Vill_t) = 10

				union all

				select a.Rec_ID, HCCode, NameK, PatientCode, Age, Sex, ISNULL(PatientPhone, 'N/A') as PatientPhone, Name_Vill_K,
				L1, LC, IMP, Diagnosis, Year, IsNotified, 'VMW' as EntryBy, 'tblVMWActivityCases' as tblName, OldDiagnosis
				from tblVMWActivityCases as a
				join tblCensusVillage as b on a.ID = b.Code_Vill_T
			)

			select a.Rec_ID, Code_OD_T, b.Code_Prov_N, Name_Prov_K, Name_OD_K, b.Code_Facility_T, Name_Facility_K,
				Name_Vill_K, NameK, PatientCode,
				case when Diagnosis = 'V' then 'Pv' when Diagnosis = 'F' then 'Pf' when Diagnosis = 'M' then 'Mix'
				when Diagnosis = 'A' then 'Pm' when Diagnosis = 'O' then 'Po' when Diagnosis = 'K' then 'Pk' end as Diagnosis,
				Diagnosis as DiagnosisAbre,
				Age, Sex, isnull(PatientPhone, 'N/A') as PatientPhone, iif(EntryBy = 'HC', Concat('HC' collate Thai_100_BIN, Name_Facility_K collate Thai_100_BIN), Concat(N'VMWភូមិ' collate Thai_100_BIN, Name_Vill_K collate Thai_100_BIN)) as EntryBy, isnull(e.Phone, 'N/A') as Phone, L1, LC, IMP, tblName, OldDiagnosis
			from T as a
			join tblHFCodes as b on a.ID = b.Code_Facility_T
			join tblProvince as d on b.Code_Prov_N = d.Code_Prov_T
			left join (
				select max(Phone) as Phone, Code_Facility_T from tblHFDevice group by Code_Facility_T
			) as e on b.Code_Facility_T = e.Code_Facility_T
			where a.Diagnosis in ('F', 'M', 'V', 'A', 'O', 'K') and a.IsNotified = 0";

		$q = $this->db->query($sql);
        return $q->result_array();
    }

	public function sendGcm( $p )
    {
		$title = 'ករណីគ្រុនចាញ់ត្រូវបានរាយការណ៍';
		$msg = new SingleMessage();
        $sender = new MessageSender( $msg );

        $template = 'cmi_case';
        $msgTxt = $this->Template_model->get($template, $p);

        [$tokens, $imeis]= $this->getHcCmiToken($p);

		foreach($tokens as $token) {
            $msg->setMessage( $token, $title, $msgTxt );
            $sender->send();
			sleep(0.2);
        }

		$this->saveNotificaton($imeis, $msgTxt);
		$this->updateCaseStatus($p);
    }

	private function getHcCmiToken( $p )
    {
        $tokenHcs = $p['tblName'] == 'tblHFActivityCases' ? [] : $this->Token_model->getHcToken($p['Code_Facility_T']);
        $cmi = $this->Token_model->getCMITokenImei( $p['Code_Facility_T'], $p['DiagnosisAbre'] );

        return [array_merge($cmi['tokens'], $tokenHcs), $cmi['imeis']];
    }

	private function saveNotificaton( $imeis, $msgTxt ){
		foreach ($imeis as $m){
			$log = [
				'Imei' => $m,
				'Message' => $msgTxt,
				'Type' => 'case',
				'InitTime' => sqlNow()
			];
			$this->Log_model->logCase($log);
		}
	}

	private function updateCaseStatus($p)
    {
        $this->db->update($p['tblName'], ['IsNotified' => 1], ['Rec_ID' => $p['Rec_ID']]);
    }

    public function sendTelegram($patient)
    {
        $title = 'ករណីគ្រុនចាញ់ត្រូវបានរាយការណ៍';
        $chatIds = $this->Token_model->getChatId( $patient['Code_Facility_T'], $patient['DiagnosisAbre'] );
		$telegram = new GroupMessage();
        $tgSender = new MessageSender( $telegram );

        $template = 'cmi_case';
        $msgTxt = $this->Template_model->get($template, $patient);

        foreach( $chatIds as $id ) {
            $telegram->setMessage( $id, $title, $msgTxt );
            $tgSender->send();
            sleep(0.2);
        }
    }

}