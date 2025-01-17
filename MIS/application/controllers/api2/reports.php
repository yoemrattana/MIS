<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Reports extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('MReport');
		$this->load->model('MPatient');
		$this->load->model('MTelegram');
		$this->load->model('Log_model');
		writeApiInput();
	}

	public function report_by_hc_post()
	{
		$request = $this->post('HF_Request');

		$hc_code = $request['hc_code'];
		$start_date = substr($request['start_date'], 0, 7);
		$end_date = substr($request['end_date'], 0, 7);
		$year = substr($start_date, 0, 4);
		$type = isset($request['type']) ? $request['type'] : 'ALL';

		$sql = "Select Negative, Positive, PF, PV, MIX, convert(decimal(6,2),iif(Pop>0,Positive*1000.0/Pop,0)) Incidence
				from (
					select isnull(sum(Negative),0) Negative, isnull(sum(Positive),0) Positive, isnull(sum(PF),0) PF, isnull(sum(PV),0) PV, isnull(sum(MIX),0) MIX
					from (
						Select iif(Diagnosis='N',1,0) Negative, iif(Positive = 'P',1,0) Positive, iif(Diagnosis='F',1,0) PF, iif(Diagnosis='V',1,0) PV, iif(Diagnosis='M',1,0) MIX
						from tblHFActivityCases
						Where ID = '$hc_code' and Year + '-' + Month between '$start_date' and '$end_date' and ('$type' = 'HC' or '$type' = 'ALL')
						union all
						Select iif(Diagnosis='N',1,0) Negative, iif(Positive = 'P',1,0) Positive, iif(Diagnosis='F',1,0) PF, iif(Diagnosis='V',1,0) PV, iif(Diagnosis='M',1,0) MIX
						from tblVMWActivityCases as a
						join tblCensusVillage as b on a.ID = b.Code_Vill_T
						where HCCode = '$hc_code' and Year + '-' + Month between '$start_date' and '$end_date' and ('$type' = 'VMW' or '$type' = 'ALL')
					) as p
				) as a, (
					select sum(Pop) as Pop
					from tblCensusVillage as a
					join V_PopByVillages as b on a.Code_Vill_T = b.Code_Vill_T
					where HCCode = '$hc_code' and Year = '$year'
				) as b";

		$result = $this->db->query($sql)->result_array();
		$this->response($result);
	}

	public function hf_positive_incidence_post()
	{
		$request = $this->post('HF_Request');

		$hc_code = $request['hc_code'];
		$start_date = substr($request['start_date'], 0, 7);
		$end_date = substr($request['end_date'], 0, 7);
		$year = substr($start_date, 0, 4);
		$type = isset($request['type']) ? $request['type'] : 'ALL';

		$sql = "select a.Code_Vill_T as village_code, PF, PV, MIX, positive, convert(decimal(6,2),iif(Pop>0,positive*1000.0/Pop,0)) incidence
				from (
					select Code_Vill_T, sum(PF) PF, sum(PV) PV, sum(MIX) MIX, sum(positive) positive
					from (
						select Code_Vill_T COLLATE SQL_Latin1_General_CP1_CI_AS as Code_Vill_T, iif(Diagnosis='F',1,0) PF, iif(Diagnosis='V',1,0) PV, iif(Diagnosis='M',1,0) MIX, 1 as positive
						from tblHFActivityCases
						where ID = '$hc_code' and Year + '-' + Month between '$start_date' and '$end_date' and Positive = 'P' and ('$type' = 'HC' or '$type' = 'ALL')
						union all
						select a.ID, iif(Diagnosis='F',1,0) PF, iif(Diagnosis='V',1,0) PV, iif(Diagnosis='M',1,0) MIX, 1 as positive
						from tblVMWActivityCases as a
						join tblCensusVillage as b on a.ID = b.Code_Vill_T
						where HCCode = '$hc_code' and Year + '-' + Month between '$start_date' and '$end_date' and Positive = 'P' and ('$type' = 'VMW' or '$type' = 'ALL')
					) as sub group by Code_Vill_T
				) as a left join V_PopByVillages as b on a.Code_Vill_T = b.Code_Vill_T and b.Year = '$year'";

		$list = $this->db->query($sql)->result();

		foreach ($list as $r)
		{
			$r->PF = (int)$r->PF;
			$r->PV = (int)$r->PV;
			$r->MIX = (int)$r->MIX;
			$r->positive = (int)$r->positive;
			$r->incidence = (float)$r->incidence;
		}

		$result = ['reports' => $list];
		$this->response($result);
	}

	public function hf_activity_cases_post()
	{
		$reports = json_decode(file_get_contents('php://input'), true)['HF_Activity_Cases'];
		$length = is_array($reports) ? count($reports) : 0;
		$list = [];
		$place = '';

		$sql = "select Treatment, Description from tblTreatment";
		$rs = $this->db->query($sql)->result_array();
		$treatments = array_column($rs, 'Treatment', 'Description');

		for($i = 0; $i < $length; $i ++)
		{
			$row = $reports[$i];

			if (!isset($row['NumberTests'])) $row['NumberTests'] = 0;

			if ($row['NumberTests'] > 0) {
				if (!isset($row['Sex']) || $row['Sex'] == '') continue;
				if (!isset($row['Age']) || $row['Age'] === null || $row['Age'] === '') continue;

				if ($row['Diagnosis'] != 'N') {
					$row['YearCase'] = substr($row['DateCase'], 0, 4);
					$row['MonthCase'] = substr($row['DateCase'], 5, 2);
					if (isset($row['PassAddress'])) {
						$row['PassVill'] = $row['PassAddress'];
						unset($row['PassAddress']);
					}
					$row['Treatment'] = isset($treatments[$row['Treatment']]) ? $treatments[$row['Treatment']] : $row['Treatment'];
					if ($row['Sex'] == 'F' && $row['PregnantMTHS'] == '') $row['PregnantMTHS'] = 'N';
					$row['Severe'] = $row['Diagnosistext'] == 'Severe' ? 1 : 0;
					$row['ExtraCode'] = $row['Code_Vill_t'];
					if ($row['Diagnosis'] == 'F') {
						$row['PatientCode'] = null;
						$row['PatientPhone'] = null;
					}

					$row['PatientCode'] = $this->MPatient->createCode($row['User_Code_Fa_T'], $row['Diagnosis']);
				} else {
					$row['YearCase'] = $row['Year'];
					$row['MonthCase'] = $row['Month'];
					$row['Dead'] = 0;
					$row['Severe'] = 0;
					$row['Refered'] = 0;
                    $row['SentSMS'] = 0;
					$row['PatientCode'] = null;
				}
				$row['AgeType'] = 'Y';
				$row['Positive'] = $row['Diagnosis'] == 'N' ? 'N' : 'P';
				$row['Is_Mobile_Entry'] = 1;
			}
			$row['ID'] = $row['User_Code_Fa_T'];
			$place = $row['User_Code_Fa_T'];
			unset($row['User_Code_Fa_T']);

			$list[] = $row;
		}

		$notifySpecies = $this->MReport->getNotifySpecies();
		$ids = [];
		$cases = [];
		for ($i = 0; $i < count($list); $i++) {
			$data = $list[$i];

			$value['ID'] = $data['ID'];
			$value['Year'] = $data['Year'];
			$value['Month'] = $data['Month'];

			$count = $this->db->where($value)->count_all_results('tblHFActivity');

			if ($count == 0) {
				$value['ID'] = $data['ID'];
				$value['Year'] = $data['Year'];
				$value['Month'] = $data['Month'];

				$this->db->insert('tblHFActivity', $value);
			}

			if ($data['NumberTests'] > 0) {
				unset($data['NumberTests']);
				unset($data['UUID']);
	    		$this->db->insert('tblHFActivityCases', $data);
				$id = $this->db->insert_id();
				array_push($ids, $id);

				$data['Rec_ID'] = $id;
				$this->MPatient->createNotification($data);

				if(in_array($data['Diagnosis'], $notifySpecies)) {
					array_push($cases, $id);
				}

				if(!in_array($data['Diagnosis'], $notifySpecies) && $data['Diagnosis'] != 'N') {
				    $sql = "select Code_OD_T from tblHFCodes where Code_Facility_T = '{$data['ID']}'";
				    $codeOD = $this->db->query($sql)->row('Code_OD_T');
				    $logData = [
				        'Code_OD_T' => $codeOD,
				        'Case_Id' => $id,
				        'Type' => 'HC',
				        'Notified' => 0
				    ];
				    $this->db->insert('tblCaseLog', $logData);
				}
			}
		}

		$rs = [];
		if (!empty($ids)) {
			$this->db->select('NameK, PatientCode');
			$this->db->from('tblHFActivityCases');
			$this->db->where_in('Rec_ID', $ids);
			$this->db->where(['PatientCode !=' => null]);
			$rs = $this->db->get()->result();
		}

		$this->sendNotification($cases, $place, 'HC');
		$this->response(['status'=> 'success', 'patients' => $rs]);
	}

    public function delete_hf_activity_case_post()
    {
        $whereCase['Rec_ID']    = $this->post('rec_id');

		$this->Log_model->deleteCase( 'tblHFActivityCases', $whereCase['Rec_ID']);
        $this->db->delete('tblHFActivityCases', $whereCase);

        $this->response(['successful']);
    }

    public function update_hf_activity_case_post()
    {
        $sql = "select Treatment, Description from tblTreatment";
		$rs = $this->db->query($sql)->result_array();
		$treatments = array_column($rs, 'Treatment', 'Description');

        $row = $this->post('HFCase');

        $where['Month'] = $row['Month'];
        $where['Year']  = $row['Year'];
        $where['ID']    = $row['User_Code_Fa_T'];
        $whereCase['Rec_ID']= $row['Rec_ID'];

        if ($row['Diagnosis'] != 'N') {
			$row['YearCase'] = substr($row['DateCase'], 0, 4);
			$row['MonthCase'] = substr($row['DateCase'], 5, 2);
            if (isset($row['PassAddress'])) {
                $row['PassVill'] = $row['PassAddress'];
                unset($row['PassAddress']);
            }
            $row['Treatment'] = isset($treatments[$row['Treatment']]) ? $treatments[$row['Treatment']] : $row['Treatment'];
            if ($row['Sex'] == 'F' && $row['PregnantMTHS'] == '') $row['PregnantMTHS'] = 'N';
            $row['Severe'] = $row['Diagnosistext'] == 'Severe' ? 1 : 0;
            $row['ExtraCode'] = $row['Code_Vill_t'];

            if ($row['Diagnosis'] == 'F') {
				$row['PatientCode'] = null;
				$row['PatientPhone'] = null;
            }

			if (!isset($row['PatientCode'])) {
				$sql = "select PatientCode from tblHFActivityCases where Rec_ID = {$row['Rec_ID']}";
				$row['PatientCode'] = $this->db->query($sql)->row('PatientCode');
				$row['PatientCode'] = $this->MPatient->createCode($row['User_Code_Fa_T'], $row['Diagnosis'], $row['PatientCode']);
			}

			$n = $row;
			$n['ID'] = $n['User_Code_Fa_T'];
			$this->MPatient->createNotification($n);

			if (!isset($row['PQTreatment'])) {
				$row['PQTreatment'] = '';
			}
        } else {
			$row['YearCase'] = $row['Year'];
			$row['MonthCase'] = $row['Month'];
            $row['Code_Vill_t'] = null;
            $row['PassVill'] = null;
            $row['DateCase'] = null;
            $row['Dead'] = 0;
            $row['Severe'] = 0;
            $row['Refered'] = 0;
            $row['NameK'] = null;
            $row['Treatment'] = null;
            $row['Diagnosistext'] = null;
            $row['Severe'] = 0;
            $row['ServiceText'] = null;
            $row['ExtraCode'] = null;
            $row['PregnantMTHS'] = null;
            $row['Weight'] = null;
            $row['PatientCode'] = null;
			$row['PatientPhone'] = null;
            $row['SentSMS'] = 0;
			$row['G6PDHb'] = null;
			$row['G6PDdL'] = null;
        }
        $row['AgeType'] = 'Y';
        $row['Positive'] = $row['Diagnosis'] == 'N' ? 'N' : 'P';
        $row['Is_Mobile_Entry'] = 1;
        $row['ID'] = $row['User_Code_Fa_T'];
        $row['ModiUser'] = $row['User_Code_Fa_T'];
        $row['ModiTime'] = sqlNow();

        unset($row['User_Code_Fa_T']);
        unset($row['Rec_ID']);
		unset($row['UUID']);
		if(isset($row['NumberTests'])) unset($row['NumberTests']);

        $this->db->update('tblHFActivityCases', $row, $whereCase);

		$rec_id = $whereCase['Rec_ID'];
		$sql = "select NameK, PatientCode from tblHFActivityCases where Rec_ID = {$rec_id} and PatientCode is not null";
		$rs = $this->db->query($sql)->result();

        $this->response(['status' => 'success', 'patient' => $rs]);
    }

	public function vmw_activity_cases_post()
	{
		$reports = json_decode(file_get_contents('php://input'), true)['VMW_Activity_Cases'];
		$length = is_array($reports) ? count($reports) : 0;
		$list = [];
		$place = '';

		$sql = "select Treatment, Description from tblTreatment";
		$rs = $this->db->query($sql)->result_array();
		$treatments = array_column($rs, 'Treatment', 'Description');

		$isIP2 = false;
		if ($length > 0) {
			$villcode = $reports[0]['User_Code_Fa_T'];
			$sql = "select IP2 from tblCensusVillage where Code_Vill_T = '$villcode'";
			$isIP2 = $this->db->query($sql)->row('IP2') == 1;
		}

		$notifySpecies = $this->MReport->getNotifySpecies();

		for ($i = 0; $i < $length; $i ++)
		{
			$row = $reports[$i];
			if (!isset($row['NumberTests'])) $row['NumberTests'] = 0;

			if ($row['NumberTests'] > 0) {
				if (!isset($row['Sex']) || $row['Sex'] == '') continue;
				if (!isset($row['Age']) || $row['Age'] === null || $row['Age'] === '') continue;
				if (!isset($row['AgeType']) || $row['AgeType'] == '') continue;

				if ($row['Diagnosis'] != 'N') {
					$row['YearCase'] = substr($row['DateCase'], 0, 4);
					$row['MonthCase'] = substr($row['DateCase'], 5, 2);
					$row['Treatment'] = isset($treatments[$row['Treatment']]) ? $treatments[$row['Treatment']] : $row['Treatment'];
					if ($row['Sex'] == 'F' && $row['PregnantMTHS'] == '') $row['PregnantMTHS'] = 'N';
					$row['DOT1'] = $row['Dot3days'];
					$row['DOT2'] = $row['Dot3days'];
					$row['DOT3'] = $row['Dot3days'];
					if ($row['Diagnosis'] == 'F') {
						$row['PatientCode'] = null;
						$row['PatientPhone'] = null;
					}

					$row['PatientCode'] = $this->MPatient->createCode($row['User_Code_Fa_T'], $row['Diagnosis']);
				} else {
					$row['YearCase'] = $row['Year'];
					$row['MonthCase'] = $row['Month'];
					$row['Refered'] = 0;
                    $row['SentSMS'] = 0;
					$row['PatientCode'] = null;
				}
				$row['Positive'] = $row['Diagnosis'] == 'N' ? 'N' : 'P';
				$row['Dead'] = 0;
				$row['Is_Mobile_Entry'] = 1;

				if ($isIP2) $row['Passive'] = 1;

				if (isset($row['HC_Code'])) {
					$row['InitUser'] = $row['HC_Code'];
					unset($row['HC_Code']);
				}
				unset($row['Dot3days']);
			}
			$row['ID'] = $row['User_Code_Fa_T'];
			$place = $row['User_Code_Fa_T'];
			unset($row['User_Code_Fa_T']);

			$list[] = $row;
		}

		$ids = [];
		$cases = [];
		for ($i = 0; $i < count($list); $i++) {
			$data = $list[$i];

			$value['ID'] = $data['ID'];
			$value['Year'] = $data['Year'];
			$value['Month'] = $data['Month'];

			$count = $this->db->where($value)->count_all_results('tblVMWActivity');

			if ($count == 0) {
				$value['ID'] = $data['ID'];
				$value['Year'] = $data['Year'];
				$value['Month'] = $data['Month'];

				$this->db->insert('tblVMWActivity', $value);
			}

			if ($data['NumberTests'] > 0) {
				unset($data['NumberTests']);
				unset($data['Code_Vill_t']);
				unset($data['UUID']);
				$this->db->insert('tblVMWActivityCases', $data);
				$id = $this->db->insert_id();
				array_push($ids, $id);

				$data['Rec_ID'] = $id;
				unset($data['Code_Vill_t']);
				$this->MPatient->createNotification($data);

				if(in_array($data['Diagnosis'], $notifySpecies)) {
					array_push($cases, $id);
				}

				if(!in_array($data['Diagnosis'], $notifySpecies) && $data['Diagnosis'] != 'N') {
				    $sql = "select Code_OD_T from tblCensusVillage as a
				     join tblHFCodes as b on a.HCCode = b.Code_Facility_T
				     where a.Code_Vill_T = '{$data['ID']}'";
				    $codeOD = $this->db->query($sql)->row('Code_OD_T');
				    $logData = [
				        'Code_OD_T' => $codeOD,
				        'Case_Id' => $id,
				        'Type' => 'VMW',
				        'Notified' => 0
				    ];
				    $this->db->insert('tblCaseLog', $logData);
				}
			}
		}

		$rs = [];
		if (!empty($ids) && empty($row['InitUser'])) {
			$this->db->select('Rec_ID, NameK, PatientCode');
			$this->db->from('tblVMWActivityCases');
			$this->db->where_in('Rec_ID', $ids);
			$this->db->where(['PatientCode !=' => null]);
			$this->db->where(['PatientCode !=' => '']);
			$rs = $this->db->get()->result_array();

			foreach($rs as $row){
				$this->notifyRadicalCure($row['Rec_ID']);
				unset($row['Rec_ID']);
			}
		}

		$this->sendNotification($cases, $place, 'VMW');

		$this->response(['status'=> 'success', 'patients' => $rs]);
	}

	private function notifyRadicalCure($caseId)
	{
		$sql = "select NameK, Sex, Age, PatientCode, Diagnosis, Name_Vill_K, PatientPhone, Token, Imei from tblVMWActivityCases as a
				join tblCensusVillage as b on b.Code_Vill_T = a.ID
				join tblToken as c on c.CodePlace = b.HCCode
				where a.Rec_ID = '{$caseId}'";

		$rs = $this->db->query($sql)->result_array();

		$this->load->library('Notification');
		$template = $this->notification->getTemplate('HC');

		foreach($rs as $row){
			$template = str_replace('{code}', $row['PatientCode'], $template);
			$template = str_replace('{name}', $row['NameK'], $template);
			$template = str_replace('{sex}', $row['Sex'] == 'M' ? 'ប្រុស' : 'ស្រី', $template);
			$template = str_replace('{age}', $row['Age'], $template);
			$template = str_replace('{village}', $row['Name_Vill_K'], $template);
			$template = str_replace('{patient_phone}', $row['PatientPhone'], $template);
			$template = str_replace('{diagnosis}', $row['Diagnosis'], $template);

			$msg = [
				"to" => $row['Token'],
				"notification" => [
					"title" => "អ្នកជំងឺត្រូវបានបញ្ជូន",
					"body" => $template
				]
			];

			$this->notification->notify($msg);
		}
	}

	private function notifyToHF($caseId)
	{
		$sql = "select Code_OD_T, c.Code_Prov_N, Name_Prov_K, Name_OD_K, Name_Facility_K,
				Name_Vill_K, NameK, Diagnosis, Age, Sex, e.Imei, e.Token from tblVMWActivityCases as a
				join tblCensusVillage as b on a.ID = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				join tblToken as e on e.CodePlace = b.HCCode
				where a.Rec_ID = {$caseId}";

		$rs = $this->db->query($sql)->result_array();

		$this->load->library('Notification');
		$template = $this->notification->getTemplate('OD');

		foreach($rs as $row){
			$template = str_replace('{name}', $row['NameK'], $template);
			$template = str_replace('{sex}', $row['Sex'] == 'M' ? 'ប្រុស' : 'ស្រី', $template);
			$template = str_replace('{age}', $row['Age'], $template);
			$template = str_replace('{village}', $row['Name_Vill_K'], $template);
			$template = str_replace('{hc}', $row['Name_Facility_K'], $template);
			$template = str_replace('{od}', $row['Name_OD_K'], $template);
			$template = str_replace('{province}', $row['Name_Prov_K'], $template);
			$template = str_replace('{diagnosis}', $row['Diagnosis'], $template);

			$msg = [
				"to" => $row['Token'],
				"notification" => [
					"title" => "អ្នកជំងឺត្រូវបានបញ្ជូន",
					"body" => $template
				]
			];

			//$log = [
			//        'Imei' => $row['Imei'],
			//        'Message' => $template,
			//        'Type' => 'case',
			//        'InitTime' => sqlNow()
			//    ];
			//$this->notification->logCase($log);

			$this->notification->notify($msg);
		}

	}

	private function sendNotification($caseIds, $place, $type)
	{
		if(empty($caseIds)) return;
		//get tokens
		$tokens = $this->getTokens($place, $type);
		$tokenList = array_column($tokens, 'Token');
		$tokenList = array_flatten($tokenList);

		$imeiList = array_column($tokens, 'Imei');
		$imeiList = array_flatten($imeiList);

		//get message
		$msgList = [];
		foreach($caseIds as $id){
			$message = $this->getMsg($id, $type);
			if (!empty($message)) array_push($msgList, $message);
		}

		$messages = [
			'tokens' => $tokenList,
			'message'=> $msgList
		];

		foreach($msgList as $msg){
			$this->saveNotificaton($imeiList, $msg);
		}

		$param = base64_encode(json_encode($messages));
		$path = FCPATH . '\media\Message\MIS Notification.exe';
		$rs = exec("\"$path\" $param");
	}

	private function saveNotificaton($imeiList, $msg){
		$this->load->library('Notification');
		foreach ($imeiList as $m){
			$log = [
				'Imei' => $m,
				'Message' => $msg,
				'Type' => 'case',
				'InitTime' => sqlNow()
			];
			$this->notification->logCase($log);
		}

	}

	private function getMsg($caseId, $type)
	{
		if(trim($type) == 'HC'){
			$sql = "with t as
				(
					select c.Code_Facility_T, Code_OD_T, Code_Prov_N, Name_Vill_K, Name_Facility_K, Name_OD_K, Name_Prov_K,
					NameK, Age, Sex, case when Diagnosis = 'V' then 'Pv' when Diagnosis = 'F' then 'Pf' else 'Mix' end as Diagnosis,
					'HC' + Name_Facility_K as EntryBy, Phone from tblHFActivityCases as a
					join tblCensusVillage as b on a.Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS = b.Code_Vill_T
					join tblHFCodes as c on a.ID = c.Code_Facility_T
					join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
					join (
						select max(Phone) as Phone, Code_Facility_T from tblHFDevice group by Code_Facility_T
					) as e on c.Code_Facility_T = e.Code_Facility_T
					where a.Rec_ID = '{$caseId}'
				) ";
		} else{
			$sql = "with t as
				(
					select Code_OD_T, c.Code_Prov_N, Name_Prov_K, Name_OD_K, Name_Facility_K,
					Name_Vill_K, NameK, case when Diagnosis = 'V' then 'Pv' when Diagnosis = 'F' then 'Pf' else 'Mix' end as Diagnosis,
					Age, Sex, N'VMWភូមិ' + Name_Vill_K as EntryBy, isnull(e.Phone, 'N/A') as Phone from tblVMWActivityCases as a
					join tblCensusVillage as b on a.ID = b.Code_Vill_T
					join tblHFCodes as c on b.HCCode = c.Code_Facility_T
					join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
					join (
						select max(Phone) as Phone, Code_Vill_T from tblVMWDevice group by Code_Vill_T
					) as e on b.Code_Vill_T = e.Code_Vill_T
					where a.Rec_ID = '{$caseId}'
				) ";
		}

		$sql .= " select * from t";

		$q = $this->db->query($sql);

		if (!$q->num_rows()) return;

		$row = $q->row_array();

		$this->load->library('Notification');
		$template = $this->notification->getTemplate('OD');

		$template = str_replace('{name}', $row['NameK'], $template);
		$template = str_replace('{sex}', $row['Sex'] == 'M' ? 'ប្រុស' : 'ស្រី', $template);
		$template = str_replace('{age}', $row['Age'], $template);
		$template = str_replace('{village}', $row['Name_Vill_K'], $template);
		$template = str_replace('{hc}', $row['Name_Facility_K'], $template);
		$template = str_replace('{od}', $row['Name_OD_K'], $template);
		$template = str_replace('{province}', $row['Name_Prov_K'], $template);
		$template = str_replace('{diagnosis}', $row['Diagnosis'], $template);
		$template = str_replace('{entry_by}', $row['EntryBy'], $template);
		$template = str_replace('{phone}', $row['Phone'], $template);

		return $template;
	}

	private function getTokens($place, $type)
	{
		$place = trim($place);
		if($type=='HC'){
			$sql = "with t as (
						select * from tblHFCodes
					)

					select Token, Imei
					from (
						select Imei, Token, Code_OD, Code_Prov from tblMalariaInfoToken as a
						left join MIS_User as b on b.Us = a.Username
					) as a
					join t as b on b.Code_Prov_N in (select * from dbo.Split(a.Code_Prov)) and (a.Code_OD = b.Code_OD_T or a.Code_OD = '')
					where Code_Facility_T = '{$place}'";
		} else {
			$sql = "with t as (
					select a.Code_Vill_T, Code_Prov_T, Code_OD_T from tblCensusVillage as a
					join tblHFCodes as b on a.HCCode = b.Code_Facility_T
				)

				select Token, Imei
				from (
					select Imei, Token, Code_OD, Code_Prov from tblMalariaInfoToken as a
					left join MIS_User as b on b.Us = a.Username
				) as a
				join t as b on b.Code_Prov_T in (select * from dbo.Split(a.Code_Prov)) and (a.Code_OD = b.Code_OD_T or a.Code_OD = '')
				where Code_Vill_T = '{$place}'";
		}

		$tokens = $this->db->query($sql)->result_array();
		return $tokens;
	}

	//private function notifyMalInfo($caseId, $type)
	//{
	//    if($type=='HC'){
	//        $sql = "with t as
	//            (
	//                select c.Code_Facility_T, Code_OD_T, Code_Prov_N, Name_Vill_K, Name_Facility_K, Name_OD_K, Name_Prov_K,
	//                NameK, Age, Sex, case when Diagnosis = 'V' then 'Pv' when Diagnosis = 'F' then 'Pf' else 'Mix' end as Diagnosis,
	//                'HC' + Name_Facility_K as EntryBy, Phone from tblHFActivityCases as a
	//                join tblCensusVillage as b on a.Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS = b.Code_Vill_T
	//                join tblHFCodes as c on a.ID = c.Code_Facility_T
	//                join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
	//                join (
	//                    select max(Phone) as Phone, Code_Facility_T from tblHFDevice group by Code_Facility_T
	//                ) as e on c.Code_Facility_T = e.Code_Facility_T
	//                where a.Rec_ID = {$caseId}
	//            ) ";
	//    } else{
	//        $sql = "with t as
	//            (
	//                select Code_OD_T, c.Code_Prov_N, Name_Prov_K, Name_OD_K, Name_Facility_K,
	//                Name_Vill_K, NameK, case when Diagnosis = 'V' then 'Pv' when Diagnosis = 'F' then 'Pf' else 'Mix' end as Diagnosis,
	//                Age, Sex, N'VMWភូមិ' + Name_Vill_K as EntryBy, isnull(e.Phone, 'N/A') as Phone from tblVMWActivityCases as a
	//                join tblCensusVillage as b on a.ID = b.Code_Vill_T
	//                join tblHFCodes as c on b.HCCode = c.Code_Facility_T
	//                join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
	//                join (
	//                    select max(Phone) as Phone, Code_Vill_T from tblVMWDevice group by Code_Vill_T
	//                ) as e on b.Code_Vill_T = e.Code_Vill_T
	//                where a.Rec_ID = {$caseId}
	//            ) ";
	//    }

	//    $sql .= "select a.Imei, Token, Code_OD, Code_Prov, b.*
	//            from (
	//                select Imei, Token, Code_OD, Code_Prov from tblMalariaInfoToken as a
	//                left join MIS_User as b on b.Us = a.Username
	//            ) as a
	//            join t as b on b.Code_Prov_N in (select * from dbo.Split(a.Code_Prov)) and (a.Code_OD = b.Code_OD_T or a.Code_OD = '')";

	//    $rs = $this->db->query($sql)->result_array();

	//    $this->load->library('Notification');
	//    $template = $this->notification->getTemplate('OD');

	//    foreach($rs as $row){
	//        $template = str_replace('{name}', $row['NameK'], $template);
	//        $template = str_replace('{sex}', $row['Sex'] == 'M' ? 'ប្រុស' : 'ស្រី', $template);
	//        $template = str_replace('{age}', $row['Age'], $template);
	//        $template = str_replace('{village}', $row['Name_Vill_K'], $template);
	//        $template = str_replace('{hc}', $row['Name_Facility_K'], $template);
	//        $template = str_replace('{od}', $row['Name_OD_K'], $template);
	//        $template = str_replace('{province}', $row['Name_Prov_K'], $template);
	//        $template = str_replace('{diagnosis}', $row['Diagnosis'], $template);
	//        $template = str_replace('{entry_by}', $row['EntryBy'], $template);
	//        $template = str_replace('{phone}', $row['Phone'], $template);

	//        $msg = [
	//            "to" => $row['Token'],
	//            "notification" => [
	//                "title" => "ព័ត៌មានអ្នកជម្ងឺគ្រុនចាញ់",
	//                "body" => $template
	//            ]
	//        ];

	//        $log = [
	//                'Imei' => $row['Imei'],
	//                'Message' => $template,
	//                'Type' => 'case',
	//                'InitTime' => sqlNow()
	//            ];
	//        $this->notification->logCase($log);

	//        $this->notification->notify($msg);
	//    }
	//}

    public function delete_vmw_activity_case_post()
    {
        $whereCase['Rec_ID'] = $this->post('rec_id');

		$this->Log_model->deleteCase( 'tblVMWActivityCases', $whereCase['Rec_ID']);
        $this->db->delete('tblVMWActivityCases', $whereCase);

        $this->response(['success']);
    }

    public function update_vmw_activity_case_post()
    {
        $row = $this->post('VMWCase');

        $sql = "select Treatment, Description from tblTreatment";
		$rs = $this->db->query($sql)->result_array();
		$treatments = array_column($rs, 'Treatment', 'Description');

        $where['Year']  = $row['Year'];
        $where['Month'] = $row['Month'];
        $where['ID']    = $row['User_Code_Fa_T'];
        $whereCase['Rec_ID']= $row['Rec_ID'];

        if ($row['Diagnosis'] != 'N') {
			$row['YearCase'] = substr($row['DateCase'], 0, 4);
			$row['MonthCase'] = substr($row['DateCase'], 5, 2);
            $row['Treatment'] = isset($treatments[$row['Treatment']]) ? $treatments[$row['Treatment']] : $row['Treatment'];
            if ($row['Sex'] == 'F' && $row['PregnantMTHS'] == '') $row['PregnantMTHS'] = 'N';
            $row['DOT1'] = $row['Dot3days'];
            $row['DOT2'] = $row['Dot3days'];
            $row['DOT3'] = $row['Dot3days'];
			if ($row['Diagnosis'] == 'F') {
				$row['PatientCode'] = null;
				$row['PatientPhone'] = null;
            }

			$row['PatientCode'] = $this->MPatient->createCode($row['User_Code_Fa_T'], $row['Diagnosis'], $row['PatientCode']);

			$n = $row;
			unset($n['Code_Vill_t']);
			$n['ID'] = $n['User_Code_Fa_T'];
			$this->MPatient->createNotification($n);

			if (!isset($row['PQTreatment'])) {
				$row['PQTreatment'] = '';
			}
        } else {
			$row['YearCase'] = $row['Year'];
			$row['MonthCase'] = $row['Month'];
            $row['Refered'] = 0;
            $row['Treatment'] = null;
            $row['PregnantMTHS'] = null;
            $row['NameK'] = null;
            $row['Code_Vill_t'] = null;
            $row['Treatment'] = null;
            $row['DateCase'] = null;
            $row['Remark'] = null;
            $row['Weight'] = 0;
            $row['Temperature'] = 0;
            $row['DOT1'] = 0;
            $row['DOT2'] = 0;
            $row['DOT3'] = 0;
            $row['Mobile'] = null;
            $row['SentSMS'] = 0;
            $row['PatientCode'] = null;
			$row['PatientPhone'] = null;
			$row['G6PDHb'] = null;
			$row['G6PDdL'] = null;
        }
        $row['Positive'] = $row['Diagnosis'] == 'N' ? 'N' : 'P';
        $row['Dead'] = 0;
        $row['Is_Mobile_Entry'] = 1;

        if (isset($row['HC_Code'])) {
            $row['InitUser'] = $row['HC_Code'];
            $row['ModiUser'] =  $row['HC_Code'];
            unset($row['HC_Code']);
        }
        unset($row['Dot3days']);

        $row['ID'] = $row['User_Code_Fa_T'];

        $row['ModiTime'] = sqlNow();

        unset($row['User_Code_Fa_T']);
        unset($row['Rec_ID']);
		unset($row['Code_Vill_t']);
		unset($row['UUID']);
		if(isset($row['NumberTests'])) unset($row['NumberTests']);

        $this->db->update('tblVMWActivityCases', $row, $whereCase);

        $rec_id = $whereCase['Rec_ID'];
		$sql = "select NameK, PatientCode from tblVMWActivityCases where Rec_ID = {$rec_id} and PatientCode is not null";
		$rs = $this->db->query($sql)->result();

        $this->response(['status' => 'success', 'patient' => $rs]);
    }

	public function search_patient_post()
	{
		$year = $this->post('year');
		$month = $this->post('month');
		//$patient_name = $this->post('patient_name');
		//$patient_code = $this->post('patient_code');
		$hc_code = $this->post('hc_code');
		$villcode = $this->post('Code_Vill_t');

		//$where1 = empty($patient_name) ? '' : " and NameK like N'%{$patient_name}%'";
		//$where2 = empty($patient_code) ? '' : " and PatientCode = '{$patient_code}'";
		$where = empty($villcode) ? '' : " and a.ID = '{$villcode}'";

		$sql = "select a.ID as Code_Vill_T, Year,Month,DateCase,NameK,Age,AgeType,Sex,PregnantMTHS,Weight,Temperature,Mobile,Diagnosis,Treatment,OtherTreatment
					,DOT3 'Dot3days',Refered,Dead,Remark,ID,1 as NumberTests,Rec_ID,Is_Mobile_Entry,Passive, PatientCode, PatientPhone, PQTreatment, G6PD
					,G6PDHb as G6PDdL,G6PDdL as G6PDHb
				from tblVMWActivityCases as a
				join tblCensusVillage as b on a.ID = b.Code_Vill_T
				where b.HCCode = '{$hc_code}'
				and Year = {$year} and Month = {$month} ";
		$sql .= $where;

		$rs = $this->db->query($sql)->result();

		$this->response($rs);
	}

	public function investigation_cases_post()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$reports = $data['Investigation_Cases'];

		for ($i = 0; $i < count($reports); $i++)
		{
			$row = $reports[$i];

			if (!isset($row['Date_Of_Invest'])) {
				$row['Date_Of_Invest'] = sqlNow();
			}

			if ($row['Vill_Of_Residence'] == null || $row['Date_Of_Invest'] == null) {
				show_error('Vill_Of_Residence and Date_Of_Invest are required!');
			}

			$where['Id'] = $row['Id'];

			foreach ($row as $key => $value) {
				$row[$key] = is_numeric($value) ? $value : $value;
			}

			unset($row['Id']);
			unset($row['Is_New']);
			unset($row['Last_12_M']);
			unset($row['Last_3_M']);

			if ($where['Id'] == 0) {
				$this->db->insert('tblInvestigationCases', $row);
			} else {
				$this->db->update('tblInvestigationCases', $row, $where);
			}
		}

		$this->response(['inserted_row' => 1]);
	}

	public function reactive_cases_post()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$reports = $data['Reactive_Activity_Cases'];

		if (count($reports) > 0) {
			$where['Passive_Case_Id'] = $reports[0]['Passive_Case_Id'];
			$this->db->delete('tblReactiveCases', $where);
		}

		for ($i = 0; $i < count($reports); $i ++)
		{
			$row = $reports[$i];

			$row['Fever'] = isset($row['Fever']) ? $row['Fever'] : 'N';
			$row['Forest'] = isset($row['Forest']) ? $row['Forest'] : 'N';
			$row['Travel'] = isset($row['Travel']) ? $row['Travel'] : 'N';
			$row['Tested'] = isset($row['Tested']) ? $row['Tested'] : 'N';
			$row['History'] = isset($row['History']) ? $row['History'] : 'N';
			$row['Relative'] = isset($row['Relative']) ? $row['Relative'] : 'N';
			$row['No_Risk'] = isset($row['No_Risk']) ? $row['No_Risk'] : 'N';
			$row['Refused'] = isset($row['Refused']) ? $row['Refused'] : 'N';
			$row['Absent'] = isset($row['Absent']) ? $row['Absent'] : 'N';
			$row['User_Id'] = isset($row['User_Code_Fa_T']) ? $row['User_Code_Fa_T'] : null;
			$row['Is_Mobile_Entry'] = 1;

			$where['Id'] = $row['Id'];
			unset($row['Id']);
			unset($row['User_Code_Fa_T']);
			unset($row['Investigation_Case_Id']);

            $this->db->insert('tblReactiveCases', $row);
		}

		$this->response(['inserted_row' => 1]);
	}

	public function search_positive_cases_get()
	{
		$options['year'] = $this->get('year');
		$options['month'] = $this->get('month');
		$options['hc_code'] = $this->get('HC_Code') ;

		$result = $this->MReport->search_positive_case($options);
		$this->response($result);
	}

	public function search_investigation_cases_get()
	{
		$options['year'] = $this->get('year');
		$options['month'] = $this->get('month');
		$options['hc_code'] = $this->get('HC_Code') ;

		$positive = $this->MReport->search_positive_case ( $options );

		$positive_ids = array_map(function($n){
			return "'{$n['Passive_Case_Id']}'";
		}, $positive);

		if(count($positive_ids) > 0){
			$result = $this->MReport->search_investigation_cases($positive_ids);
		}else{
			$result = [];
		}

		$this->response($result);
	}

	public function get_investigation_case_get()
	{
		$result = $this->MReport->get_investigation_case($this->get('passive_case_id'));
		$this->response($result);
	}

	public function get_reactive_cases_get()
	{
		$result = $this->MReport->get_reactive_cases($this->get('passive_case_id'));
		$this->response($result);
	}

	public function stock_post()
	{
		$code = $this->post('HC_Code');
		$from = $this->post('Date_From');
		$to = $this->post('Date_To');

		$from = substr($from, 0, 7);
		$to = substr($to, 0, 7);

		$sql = "SP_V2_Stock '', '$code', '$from', '$to'";
		$rs = $this->db->query($sql)->result();

		$this->response($rs);
	}

	public function hc_data_post()
	{
		$hccode = $this->post('hc_code');
		$year = $this->post('year');
		$month = $this->post('month');

		$sql = "select count(*) as count from tblHFActivity where ID = '$hccode' and year = '$year' and month = '$month'";
		$count = $this->db->query($sql)->row('count');
		if ($count == 0) $this->response(-1);

		$sql = "select Year,Month,DateCase,c.Code_Prov_T,c.Code_Dist_T,c.Code_Comm_T,a.Code_Vill_t,b.Code_Prov_T as PassProvince,b.Code_Dist_T as PassDistrict,b.Code_Comm_T as PassCommune,PassVill as PassAddress
					,NameK,Age,AgeType,Sex,PregnantMTHS,DiagnosisText,ServiceText,Microscopy,RDT,Diagnosis,Treatment,OtherTreatment,Refered,Dead,ID,1 as NumberTests,Rec_ID,Is_Mobile_Entry,Weight
					,PatientCode, PatientPhone, G6PD, PQTreatment, G6PDHb as G6PDdL,G6PDdL as G6PDHb
				from tblHFActivityCases as a
				full join tblCensusVillage as b on a.PassVill = b.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS
				full join tblCensusVillage as c on a.Code_Vill_t = c.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS
				where ID = '$hccode' and year = '$year' and month = '$month' order by Rec_ID";
		$rs = $this->db->query($sql)->result();
		$this->response($rs);
	}

	public function vmw_data_post()
	{
		$villcode = $this->post('Code_Vill_t');
	    $year = $this->post('year');
		$month = $this->post('month');

		$sql = "select count(*) as count from tblVMWActivity where ID = '$villcode' and year = '$year' and month = '$month'";
		$count = $this->db->query($sql)->row('count');
		if ($count == 0) $this->response(-1);

	    $sql = "select Year,Month,DateCase,NameK,Age,AgeType,Sex,PregnantMTHS,Weight,Temperature,Mobile,Diagnosis,Treatment,OtherTreatment,DOT3 'Dot3days',Refered,Dead
					,Remark,ID,1 as NumberTests,Rec_ID,Is_Mobile_Entry,Passive, PatientCode, PatientPhone, PQTreatment, G6PD
					,G6PDHb as G6PDdL,G6PDdL as G6PDHb
	            from tblVMWActivityCases where ID = '$villcode' and year = '$year' and month = '$month' order by Rec_ID";
	    $rs = $this->db->query($sql)->result();
	    $this->response($rs);
	}

	public function hc_completeness_post()
	{
		$hccode = $this->post('hc_code');
		$year = $this->post('year');

		$sql = "select Name_Facility_K from tblHFCodes where Code_Facility_T = '$hccode'";
		$name = $this->db->query($sql)->row('Name_Facility_K');

		$sql = "select convert(int,Month) as month from tblHFActivity where ID = '$hccode' and Year = '$year'";
		$arr = $this->db->query($sql)->result();

		$months = [];
		foreach ($arr as $v)
		{
			$months[] = $v->month;
		}

		$rs['NameK'] = $name;
		for ($i = 1; $i <= 12; $i++)
		{
			$rs['M'.$i] = in_array($i, $months) ? 1 : 0;
		}

		$this->response($rs);
	}

	public function vmw_completeness_post()
	{
		$hccode = $this->post('hc_code');
		$year = $this->post('year');

		$sql = "select Code_Vill_T code, Name_Vill_K name from tblCensusVillage
				where HaveVMW = 1 and (HCCode = '$hccode' or HCCode_Meeting = '$hccode')
				order by name";
		$main = $this->db->query($sql)->result();

		$sql = "select a.ID code, convert(int,a.Month) as month
				from tblVMWActivity as a join tblCensusVillage as b on a.ID = b.Code_Vill_T
				where Year = '$year' and HaveVMW = 1 and (HCCode = '$hccode' or HCCode_Meeting = '$hccode')";
		$detail = $this->db->query($sql)->result();

		$rs = [];
		foreach ($main as $m)
		{
			$r['NameK'] = $m->name;
			for ($i = 1; $i <= 12; $i++)
			{
				$r['M'.$i] = 0;
				foreach ($detail as $d)
				{
					if ($d->code == $m->code && $d->month == $i) {
						$r['M'.$i] = 1;
						break;
					}
				}
			}
			$rs[] = $r;
		}

		$this->response($rs);
	}

    public function vill_surveillance_post()
    {
        $hf = $this->post('hc_code');
        $year = $this->post('year');
        $mf = $this->post('mf');
        $mt = $this->post('mt');

        $sql = "SP_API_VillSurveillance '$hf','$year','$mf', '$mt'";
		$rs = $this->db->query($sql)->result();

        $this->response($rs);
    }

    public function test_case_post()
    {
        $hf = $this->post('hc_code');
        $year = $this->post('year');
        $mf = $this->post('mf');
        $mt = $this->post('mt');

        $sql = "SP_API_TestCase '$hf','$year','$mf', '$mt'";
		$rs = $this->db->query($sql)->result();

        $this->response($rs);
    }

    public function get_sms_hf_post(){
        $sql = "select a.Rec_ID, a.ID as HFCode, Phone, Diagnosis + cast(iif(AgeType = 'Y', Age ,0) as varchar) + Sex + '0' + ID as CaseCode
                from tblHFActivityCases as a
                join tblHFDevice as b on a.ID = b.Code_Facility_t
                where SentSMS = 0 and Positive = 'P'";

        $rs = $this->db->query($sql)->result();

        $this->response($rs);
    }

    public function get_sms_vmw_post(){
        $sql = "select a.Rec_ID, a.ID as VillCode, Phone, Diagnosis + cast(iif(AgeType = 'Y', Age ,0) as varchar) + Sex + '0.' as CaseCode
        from tblVMWActivityCases as a
        join tblVMWDevice as b on a.ID = b.Code_Vill_T
        where SentSMS = 0 and Positive = 'P'";
        $rs = $this->db->query($sql)->result();

        $this->response($rs);
    }

    public function update_sms_hf_post()
    {
        $rec_id = $this->post('rec_id');
        $this->db->update('tblHFActivityCases', ['SentSMS' => 1], ['Rec_ID' => $rec_id]);

        $this->response('Successful');
    }

    public function update_sms_vmw_post()
    {
        $rec_id = $this->post('rec_id');
        $this->db->update('tblVMWActivityCases', ['SentSMS' => 1], ['Rec_ID' => $rec_id]);

        $this->response('Successful');
    }
}