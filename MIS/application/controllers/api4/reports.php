<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require_once FCPATH.'/vendor/autoload.php';
use Message\SingleMessage;
use Message\MultiThreadMessage;
use Message\MessageSender;

class Reports extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('MReport');
		$this->load->model('MPatient');
		$this->load->model('Token_model');
		$this->load->model('Template_model');
		$this->load->model('Log_model');

		$this->load->model('MTelegram');

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
						Select iif(Diagnosis='N',1,0) Negative, iif(Diagnosis<>'N',1,0) Positive, iif(Diagnosis='F',1,0) PF, iif(Diagnosis='V',1,0) PV, iif(Diagnosis='M',1,0) MIX
						from tblHFActivityCases
						Where ID = '$hc_code' and Year + '-' + Month between '$start_date' and '$end_date' and ('$type' = 'HC' or '$type' = 'ALL')
						union all
						Select iif(Diagnosis='N',1,0) Negative, iif(Diagnosis<>'N',1,0) Positive, iif(Diagnosis='F',1,0) PF, iif(Diagnosis='V',1,0) PV, iif(Diagnosis='M',1,0) MIX
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

		$sql = "select a.Code_Vill_T as village_code, PF, PV, MIX, positive, Negative, convert(decimal(6,2),iif(Pop>0,positive*1000.0/Pop,0)) incidence
				from (
					select Code_Vill_T, sum(PF) PF, sum(PV) PV, sum(MIX) MIX, sum(positive) positive, sum(Negative) as Negative
					from (
						select Code_Vill_T COLLATE SQL_Latin1_General_CP1_CI_AS as Code_Vill_T, iif(Diagnosis='F',1,0) PF, iif(Diagnosis='V',1,0) PV, iif(Diagnosis='M',1,0) MIX, iif(Positive= 'P',1,0) as positive, iif(Positive= 'N',1,0) as Negative
						from tblHFActivityCases
						where ID = '$hc_code' and Year + '-' + Month between '$start_date' and '$end_date' and ('$type' = 'HC' or '$type' = 'ALL')
						union all
						select a.ID, iif(Diagnosis='F',1,0) PF, iif(Diagnosis='V',1,0) PV, iif(Diagnosis='M',1,0) MIX, iif(Positive= 'P',1,0) as positive, iif(Positive= 'N',1,0) as Negative
						from tblVMWActivityCases as a
						join tblCensusVillage as b on a.ID = b.Code_Vill_T
						where HCCode = '$hc_code' and Year + '-' + Month between '$start_date' and '$end_date' and ('$type' = 'VMW' or '$type' = 'ALL')
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

				if ($row['Sex'] == 'F' && isset($row['PregnantMTHS']) && $row['PregnantMTHS'] == '') $row['PregnantMTHS'] = 'N';

				if ($row['Diagnosis'] != 'N') {
					$row['YearCase'] = substr($row['DateCase'], 0, 4);
					$row['MonthCase'] = substr($row['DateCase'], 5, 2);

					$row['PatientPhone'] = empty($row['PatientPhone']) ? null : $row['PatientPhone'];

					if (isset($row['PassAddress'])) {
						$row['PassVill'] = $row['PassAddress'];
						unset($row['PassAddress']);
					}

					$row['Treatment'] = isset($treatments[$row['Treatment']]) ? $treatments[$row['Treatment']] : $row['Treatment'];
					$row['Refered'] = isset($row['ReferedReason']) && !empty($row['ReferedReason']) ? true : false;
					$row['Severe'] = $row['Diagnosistext'] == 'Severe' ? 1 : 0;

					if (isset($row['G6PDHb']) && isset($row['G6PDdL'])) { //exchange value because app use wrong parameter
						$temp = $row['G6PDHb'];
						$row['G6PDHb'] = $row['G6PDdL'];
						$row['G6PDdL'] = $temp;
					}

					if (!isset($row['Relapse'])) $row['Relapse'] = null;
					if (!isset($row['L1'])) $row['L1'] = null;
					if (!isset($row['LC'])) $row['LC'] = null;
					if (!isset($row['IMP'])) $row['IMP'] = null;
					if (!isset($row['LC_Code'])) $row['LC_Code'] = null;
					if (!isset($row['IMP_Text'])) $row['IMP_Text'] = null;

					if ($row['Diagnosis'] == 'V') {
						if ($row['Relapse'] == 1) {
							$row['L1'] = null;
							$row['LC'] = null;
							$row['IMP'] = null;
							$row['LC_Code'] = null;
							$row['IMP_Text'] = null;
						} elseif ($row['L1'] == 1) {
							$row['LC'] = null;
							$row['IMP'] = null;
							$row['LC_Code'] = null;
							$row['IMP_Text'] = null;
						} elseif ($row['LC'] == 1) {
							$row['IMP'] = null;
							$row['IMP_Text'] = null;
						}
					} else {
						if ($row['L1'] == 1) {
							$row['LC'] = null;
							$row['IMP'] = null;
							$row['LC_Code'] = null;
							$row['IMP_Text'] = null;
						} elseif ($row['LC'] == 1) {
							$row['IMP'] = null;
							$row['IMP_Text'] = null;
						}
						$row['Relapse'] = 0;
					}

					if (isset($row['Primaquine75']) && !empty($row['Primaquine75'])) {
						$row['PrimaquineDate'] = $row['DateCase'];
						$row['RadicalCureHcCode'] = $row['User_Code_Fa_T'];
					}
					else {
						$row['PrimaquineDate'] = null;
					}

					$patientCode = $row['PatientCode'] ?? '';
					$fingerprint = $row['Fingerprint'] ?? '';
					$row['PatientCode'] = $this->MPatient->createCode($row['User_Code_Fa_T'], $row['Diagnosis'], $patientCode, $fingerprint);
					$row['IsNotified'] = 0;
				} else {
					$row['YearCase'] = $row['Year'];
					$row['MonthCase'] = $row['Month'];
					$row['NameK'] = null;
					$row['Code_Vill_t'] = null;
					$row['Dead'] = 0;
					$row['Refered'] = 0;
                    $row['SentSMS'] = 0;
					$row['Severe'] = 0;
					$row['PatientCode'] = null;
					$row['Relapse'] = null;
					$row['L1'] = null;
					$row['LC'] = null;
					$row['IMP'] = null;
					$row['LC_Code'] = null;
					$row['IMP_Text'] = null;
					$row['IsNotified'] = null;
				}
				$row['AgeType'] = 'Y';
				$row['Positive'] = $row['Diagnosis'] == 'N' ? 'N' : 'P';
				$row['Is_Mobile_Entry'] = 1;

				if ( isset( $row['RdtImage']) && !empty( $row['RdtImage'] ) ) {
					$dir = FCPATH.'/media/RDT';
					if (!file_exists($dir)) mkdir($dir);
					$filename = $row['User_Code_Fa_T'] . '-' . $row['Diagnosis'] . '-' . uniqid() . '.jpg';
					file_put_contents($dir.'/'.$filename, base64_decode($row['RdtImage']));
					$row['RdtImage'] = $filename;
				}
			}
			$row['ID'] = $row['User_Code_Fa_T'];
			$place = $row['User_Code_Fa_T'];
			unset($row['User_Code_Fa_T']);
			unset($row['TreatmentPill']);

			$list[] = $row;
		}

		$notifySpecies = $this->MReport->getNotifySpecies();
		$caseIds = [];
		$patients = [];
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

                if (in_array($data['Diagnosis'], ['F', 'M'])) {
                    $recId = $this->MPatient->logPfMix($data, 'HC');
                    $this->MTelegram->notifyPfMix($data, $recId, 'HC');
                    continue;
                }

	    		$this->db->insert('tblHFActivityCases', $data);
				$id = $this->db->insert_id();
				if (in_array($data['Diagnosis'], $notifySpecies)) array_push($caseIds, $id);

				$data['Rec_ID'] = $id;

				if ($data['PatientCode'] != '') {
					array_push($patients, ['NameK' => str_replace("♣","", $data['NameK']), 'PatientCode' => $data['PatientCode']]);
				}

				$hasVMW = isset($data['Code_Vill_t']) ? $this->MPatient->hasVMW($data['Code_Vill_t']) : false;

				if ($hasVMW) $this->MPatient->createNotification($data);
				else $this->MPatient->createHFNotification($data);

				if (!in_array($data['Diagnosis'], $notifySpecies) && $data['Diagnosis'] != 'N') {
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

		//$this->sendNotification($caseIds, $place, 'hc');
		$this->response(['status'=> 'success', 'patients' => $patients]);
	}

    public function delete_hf_activity_case_post()
    {
        $whereCase['Rec_ID'] = $this->post('rec_id');

		$this->Log_model->deleteCase('tblHFActivityCases', $whereCase['Rec_ID']);
        $this->db->delete('tblHFActivityCases', $whereCase);

        $this->response(['successful']);
    }

    public function update_hf_activity_case_post()
    {
        $sql = "select Treatment, Description from tblTreatment";
		$rs = $this->db->query($sql)->result_array();
		$treatments = array_column($rs, 'Treatment', 'Description');

        $row = $this->post('HFCase');

        $whereCase['Rec_ID']= $row['Rec_ID'];

        if ($row['Diagnosis'] != 'N') {
			$row['YearCase'] = substr($row['DateCase'], 0, 4);
			$row['MonthCase'] = substr($row['DateCase'], 5, 2);

            if (isset($row['PassAddress'])) {
                $row['PassVill'] = $row['PassAddress'];
                unset($row['PassAddress']);
            }

			$row['Severe'] = $row['Diagnosistext'] == 'Severe' ? 1 : 0;
			if ($row['Sex'] == 'F' && $row['PregnantMTHS'] == '') $row['PregnantMTHS'] = 'N';

			// TODO date follow up
			$currentCase = $this->db->get_where('tblHFActivityCases', $whereCase)->row_array();
			if (empty($currentCase['Primaquine75'])
				&& isset($row['Primaquine75'])
				&& !empty($row['Primaquine75'])
			) {
				$row['PrimaquineDate'] = date("Y-m-d");
			}

            $row['Treatment'] = isset($treatments[$row['Treatment']]) ? $treatments[$row['Treatment']] : $row['Treatment'];
			$row['Refered'] = isset($row['ReferedReason']) && !empty($row['ReferedReason']) ? true : false;

			if (isset($row['G6PDHb']) && isset($row['G6PDdL'])) { //exchange value because app use wrong parameter
				$temp = $row['G6PDHb'];
				$row['G6PDHb'] = $row['G6PDdL'] == '' ? NULL : $row['G6PDdL'];
				$row['G6PDdL'] = $temp == '' ? NULL : $temp;
			}

			if (!isset($row['Relapse'])) $row['Relapse'] = null;
			if (!isset($row['L1'])) $row['L1'] = null;
			if (!isset($row['LC'])) $row['LC'] = null;
			if (!isset($row['IMP'])) $row['IMP'] = null;
			if (!isset($row['LC_Code'])) $row['LC_Code'] = null;
			if (!isset($row['IMP_Text'])) $row['IMP_Text'] = null;

			if ($row['Diagnosis'] == 'V') {
				if ($row['Relapse'] == 1) {
					$row['L1'] = null;
					$row['LC'] = null;
					$row['IMP'] = null;
					$row['LC_Code'] = null;
					$row['IMP_Text'] = null;
				} elseif ($row['L1'] == 1) {
					$row['LC'] = null;
					$row['IMP'] = null;
					$row['LC_Code'] = null;
					$row['IMP_Text'] = null;
				} elseif ($row['LC'] == 1) {
					$row['IMP'] = null;
					$row['IMP_Text'] = null;
				}
			} else {
				if ($row['L1'] == 1) {
					$row['LC'] = null;
					$row['IMP'] = null;
					$row['LC_Code'] = null;
					$row['IMP_Text'] = null;
				} elseif ($row['LC'] == 1) {
					$row['IMP'] = null;
					$row['IMP_Text'] = null;
				}
				$row['Relapse'] = 0;
			}

			if (!isset($row['PatientCode'])) {
				$sql = "select PatientCode from tblHFActivityCases where Rec_ID = {$row['Rec_ID']}";
				$row['PatientCode'] = $this->db->query($sql)->row('PatientCode');
				$row['PatientCode'] = $this->MPatient->createCode($row['User_Code_Fa_T'], $row['Diagnosis'], $row['PatientCode']);
			}

			if (empty($row['PatientCode']) && !empty($row['Primaquine75']))
				$row['PatientCode'] = $this->MPatient->getNewCode();

			$n = $row;
			$n['ID'] = $n['User_Code_Fa_T'];

			$hasVMW = isset($n['Code_Vill_t']) ? $this->MPatient->hasVMW($n['Code_Vill_t']) : false;

			if ($hasVMW) {
				$this->MPatient->createNotification($n);
			} else {
				$this->MPatient->createHFNotification($n);
			}

			if (!isset($row['PQTreatment'])) {
				$row['PQTreatment'] = '';
			}
        } else {
			$row['YearCase'] = $row['Year'];
			$row['MonthCase'] = $row['Month'];
			$row['NameK'] = null;
			$row['Code_Vill_t'] = null;
            $row['PassVill'] = null;
            $row['Dead'] = 0;
            $row['Refered'] = 0;
            $row['Treatment'] = null;
            $row['Diagnosistext'] = null;
            $row['ServiceText'] = null;
            $row['PatientCode'] = null;
            $row['SentSMS'] = 0;
			$row['G6PDHb'] = null;
			$row['G6PDdL'] = null;
			$row['Relapse'] = null;
			$row['L1'] = null;
			$row['LC'] = null;
			$row['IMP'] = null;
			$row['LC_Code'] = null;
			$row['IMP_Text'] = null;
			$row['IsNotified'] = null;
        }
        $row['AgeType'] = 'Y';
        $row['Positive'] = $row['Diagnosis'] == 'N' ? 'N' : 'P';
        $row['Is_Mobile_Entry'] = 1;
        $row['ID'] = isset($row['CaseFromHcCode']) ? $row['CaseFromHcCode'] : $row['User_Code_Fa_T'];
        $row['ModiUser'] = $row['User_Code_Fa_T'];
        $row['ModiTime'] = sqlNow();

        $oldCase = $this->MPatient->getPatient($row['Rec_ID'], 'HC');
        if($oldCase['Diagnosis'] != $row['Diagnosis']) {
            $row['OldDiagnosis'] = $oldCase['Diagnosis'];
            $row['IsNotified'] = 0;
        }

        unset($row['User_Code_Fa_T']);
        unset($row['Rec_ID']);
		unset($row['UUID']);
		if (isset($row['NumberTests'])) unset($row['NumberTests']);
		if (isset($row['CaseFromHcCode'])) unset($row['CaseFromHcCode']);

        $this->db->update('tblHFActivityCases', $row, $whereCase);

		$rec_id = $whereCase['Rec_ID'];
		$sql = "select NameK, PatientCode from tblHFActivityCases where Rec_ID = {$rec_id} and PatientCode is not null";
		$rs = $this->db->query($sql)->result();

        $this->response(['status' => 'success', 'patient' => $rs]);
    }

	private function sendNotification($caseIds, $place, $type, $isByHC = false)
	{
		if (empty($caseIds)) return;
		$msg = new MultiThreadMessage();
		$sender = new MessageSender($msg);

		$bodyArr = [];
		$bodyAdminArr = [];

		foreach($caseIds as $id) {
			$p = $this->MPatient->getCase($id, $type);
			$template = 'cmi_case';
			if ($p['Diagnosis'] == 'Pf' && $p['L1']) $template = 'foci_case';
			if ($p['Diagnosis'] == 'Pf' && !$p['L1']) $template = 'reactive_case';
			if ($p['Diagnosis'] == 'Pv' && $p['L1']) $template = 'reactive_case';
			if (in_array($p['Diagnosis'], ['Pf', 'Mix'])) {
				$template = 'cmi_case';
				$bodyAdmin = $this->Template_model->set($template, $p);
				if (!empty($bodyAdmin)) array_push($bodyAdminArr, $bodyAdmin);
			}

			$body = $this->Template_model->set($template, $p);
			if (!empty($body)) array_push($bodyArr, $body);
		}

		$tokenHcs = $isByHC ? [] : $this->Token_model->getTokens($place, 'hc_by_vmw');
		$tokenCmis = $this->Token_model->getTokens($place, 'cmi_by_'.$type);
		$tokenAdmin = $this->Token_model->getTokens('', 'admin');
		$tokenArr = array_merge($tokenCmis['tokens'], $tokenHcs);

		$imeiArr = $tokenCmis['imeis'];

		$title = 'ករណីគ្រុនចាញ់ត្រូវបានរាយការណ៍';

		$msg->setMessage($tokenArr, $title, $bodyArr);

		$sender->send();

		foreach($bodyArr as $body) {
			$this->saveNotificaton($imeiArr, $body);
		}

		//
		$msg->setMessage($tokenAdmin['tokens'], $title, $bodyAdminArr);
		$sender->send();

		$imeiAdminArr = $tokenAdmin['imeis'];
		foreach($bodyAdminArr as $body) {
			$this->saveNotificaton($imeiAdminArr, $body);
		}
	}

	private function saveNotificaton($imeiList, $body) {
		foreach ($imeiList as $m) {
			$log = [
				'Imei' => $m,
				'Message' => $body,
				'Type' => 'case',
				'InitTime' => sqlNow()
			];
			$this->Log_model->logCase($log);
		}
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

				$row['AgeType'] = 'Y';

				if ($row['Diagnosis'] != 'N') {
					$row['YearCase'] = substr($row['DateCase'], 0, 4);
					$row['MonthCase'] = substr($row['DateCase'], 5, 2);
					$row['PatientPhone'] = empty($row['PatientPhone']) ? null : $row['PatientPhone'];
					$row['Treatment'] = isset($treatments[$row['Treatment']]) ? $treatments[$row['Treatment']] : $row['Treatment'];
					if ($row['Sex'] == 'F' && $row['PregnantMTHS'] == '') $row['PregnantMTHS'] = 'N';

					$row['DOT2'] = 0;
					$row['DOT3'] = 0;

					$row['Refered'] = isset($row['ReferedReason']) && !empty($row['ReferedReason']) ? 1 : 0;

					if (isset($row['G6PDHb']) && isset($row['G6PDdL'])) { //exchange value because app use wrong parameter
						$temp = $row['G6PDHb'];
						$row['G6PDHb'] = $row['G6PDdL'];
						$row['G6PDdL'] = $temp;
					}

					if (!isset($row['Relapse'])) $row['Relapse'] = null;
					if (!isset($row['L1'])) $row['L1'] = null;
					if (!isset($row['LC'])) $row['LC'] = null;
					if (!isset($row['IMP'])) $row['IMP'] = null;
					if (!isset($row['LC_Code'])) $row['LC_Code'] = null;
					if (!isset($row['IMP_Text'])) $row['IMP_Text'] = null;

					if ($row['Diagnosis'] == 'V') {
						if ($row['Relapse'] == 1) {
							$row['L1'] = null;
							$row['LC'] = null;
							$row['IMP'] = null;
							$row['LC_Code'] = null;
							$row['IMP_Text'] = null;
						} elseif ($row['L1'] == 1) {
							$row['LC'] = null;
							$row['IMP'] = null;
							$row['LC_Code'] = null;
							$row['IMP_Text'] = null;
						} elseif ($row['LC'] == 1) {
							$row['IMP'] = null;
							$row['IMP_Text'] = null;
						}
					} else {
						if ($row['L1'] == 1) {
							$row['LC'] = null;
							$row['IMP'] = null;
							$row['LC_Code'] = null;
							$row['IMP_Text'] = null;
						} elseif ($row['LC'] == 1) {
							$row['IMP'] = null;
							$row['IMP_Text'] = null;
						}
						$row['Relapse'] = 0;
					}

					if (isset($row['Primaquine75']) && !empty($row['Primaquine75'])) {
						$row['PrimaquineDate'] = $row['DateCase'];
						$r = $this->db->get_where('tblCensusVillage', ['Code_Vill_T' => $row['User_Code_Fa_T']])->row_array();
						$row['RadicalCureHcCode'] = $r['HCCode'];
					}
					else {
						$row['PrimaquineDate'] = null;
					}

					$patientCode = $row['PatientCode'] ?? '';
					$fingerprint = $row['Fingerprint'] ?? '';
					$row['PatientCode'] = $this->MPatient->createCode($row['User_Code_Fa_T'], $row['Diagnosis'], $patientCode, $fingerprint);
					$row['IsNotified'] = 0;
				} else {
					$row['YearCase'] = $row['Year'];
					$row['MonthCase'] = $row['Month'];
					$row['NameK'] = null;
					$row['Refered'] = 0;
					$row['ReferedOtherReason'] = null;
					$row['ReferedReason'] = null;
                    $row['SentSMS'] = 0;
					$row['PatientCode'] = null;
					$row['Relapse'] = null;
					$row['L1'] = null;
					$row['LC'] = null;
					$row['IMP'] = null;
					$row['LC_Code'] = null;
					$row['IMP_Text'] = null;
					$row['Primaquine'] = null;
					$row['ASMQ'] = null;
					$row['IsNotified'] = null;
				}
				$row['Positive'] = $row['Diagnosis'] == 'N' ? 'N' : 'P';
				$row['Dead'] = 0;
				$row['Is_Mobile_Entry'] = 1;

				if ( isset( $row['RdtImage']) && !empty( $row['RdtImage'] ) ) {
					$dir = FCPATH.'/media/RDT';
					if (!file_exists($dir)) mkdir($dir);
					$filename = $row['User_Code_Fa_T'] . '-' . $row['Diagnosis'] . '-' . uniqid() . '.jpg';
					file_put_contents($dir.'/'.$filename, base64_decode($row['RdtImage']));
					$row['RdtImage'] = $filename;
				}

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

		$caseIds = [];
		$patients = [];
		$isByHc = false;
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

                if (in_array($data['Diagnosis'], ['F', 'M'])) {
                    $recId = $this->MPatient->logPfMix($data, 'VMW');
                    $this->MTelegram->notifyPfMix($data, $recId, 'VMW');
                    continue;
                }

				$this->db->insert('tblVMWActivityCases', $data);
				$id = $this->db->insert_id();
				if (in_array($data['Diagnosis'], ['F', 'V', 'M']))
					array_push($caseIds, $id);

				if (!empty($data['InitUser'])) $isByHc = true;

				if ($data['PatientCode'] != '' && $isByHc == false) {
					array_push($patients, ['NameK' => str_replace("♣","", $data['NameK']), 'PatientCode' => $data['PatientCode']]);
				}

				$data['Rec_ID'] = $id;
				unset($data['Code_Vill_t']);
				$this->MPatient->createNotification($data);

				if (!in_array($data['Diagnosis'], $notifySpecies) && $data['Diagnosis'] != 'N') {
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

		//$this->sendNotification($caseIds, $place, 'vmw', $isByHc);

		$this->response(['status'=> 'success', 'patients' => $patients]);
	}

    public function delete_vmw_activity_case_post()
    {
        $whereCase['Rec_ID'] = $this->post('rec_id');

		$this->Log_model->deleteCase('tblVMWActivityCases', $whereCase['Rec_ID']);
        $this->db->delete('tblVMWActivityCases', $whereCase);

        $this->response(['success']);
    }

    public function update_vmw_activity_case_post()
    {
        $row = $this->post('VMWCase');

        $sql = "select Treatment, Description from tblTreatment";
		$rs = $this->db->query($sql)->result_array();
		$treatments = array_column($rs, 'Treatment', 'Description');

        $whereCase['Rec_ID'] = $row['Rec_ID'];

        if ($row['Diagnosis'] != 'N') {
			$row['YearCase'] = substr($row['DateCase'], 0, 4);
			$row['MonthCase'] = substr($row['DateCase'], 5, 2);
            $row['Treatment'] = isset($treatments[$row['Treatment']]) ? $treatments[$row['Treatment']] : $row['Treatment'];
			if ($row['Sex'] == 'F' && $row['PregnantMTHS'] == '') $row['PregnantMTHS'] = 'N';

            $row['DOT2'] = 0;
            $row['DOT3'] = 0;

			$row['Refered'] = isset($row['ReferedReason']) && !empty($row['ReferedReason']) ? true : false;

			if (isset($row['G6PDHb']) && isset($row['G6PDdL'])) { //exchange value because app use wrong parameter
				$temp = $row['G6PDHb'];
				$row['G6PDHb'] = $row['G6PDdL'] == '' ? NULL : $row['G6PDdL'];
				$row['G6PDdL'] = $temp == '' ? NULL : $temp;
			}

			if (!isset($row['Relapse'])) $row['Relapse'] = null;
			if (!isset($row['L1'])) $row['L1'] = null;
			if (!isset($row['LC'])) $row['LC'] = null;
			if (!isset($row['IMP'])) $row['IMP'] = null;
			if (!isset($row['LC_Code'])) $row['LC_Code'] = null;
			if (!isset($row['IMP_Text'])) $row['IMP_Text'] = null;

			if ($row['Diagnosis'] == 'V') {
				if ($row['Relapse'] == 1) {
					$row['L1'] = null;
					$row['LC'] = null;
					$row['IMP'] = null;
					$row['LC_Code'] = null;
					$row['IMP_Text'] = null;
				} elseif ($row['L1'] == 1) {
					$row['LC'] = null;
					$row['IMP'] = null;
					$row['LC_Code'] = null;
					$row['IMP_Text'] = null;
				} elseif ($row['LC'] == 1) {
					$row['IMP'] = null;
					$row['IMP_Text'] = null;
				}
			} else {
				if ($row['L1'] == 1) {
					$row['LC'] = null;
					$row['IMP'] = null;
					$row['LC_Code'] = null;
					$row['IMP_Text'] = null;
				} elseif ($row['LC'] == 1) {
					$row['IMP'] = null;
					$row['IMP_Text'] = null;
				}
				$row['Relapse'] = 0;
			}

			// TODO date follow up
			$currentCase = $this->db->get_where('tblVMWActivityCases', $whereCase)->row_array();
			if (empty($currentCase['Primaquine75'])
				&& isset($row['Primaquine75'])
				&& !empty($row['Primaquine75'])
			) {
				$row['PrimaquineDate'] = date("Y-m-d");
			}

			$row['PatientCode'] = $this->MPatient->createCode($row['User_Code_Fa_T'], $row['Diagnosis'], $row['PatientCode']);

			if (empty($row['PatientCode']) && !empty($row['Primaquine75']))
				$row['PatientCode'] = $this->MPatient->getNewCode();

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
			$row['NameK'] = null;
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
			$row['ReferedOtherReason'] = null;
			$row['ReferedReason'] = null;
            $row['Mobile'] = null;
            $row['SentSMS'] = 0;
            $row['PatientCode'] = null;
			$row['PatientPhone'] = null;
			$row['G6PDHb'] = null;
			$row['G6PDdL'] = null;
			$row['Relapse'] = null;
			$row['L1'] = null;
			$row['LC'] = null;
			$row['IMP'] = null;
			$row['LC_Code'] = null;
			$row['IMP_Text'] = null;
			$row['IsNotified'] = null;
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

        $oldCase = $this->MPatient->getPatient($row['Rec_ID'], 'VMW');

        if($oldCase['Diagnosis'] != $row['Diagnosis']) {
            $row['OldDiagnosis'] = $oldCase['Diagnosis'];
            $row['IsNotified'] = 0;
        }

        unset($row['Code_Vill_t']);
        unset($row['User_Code_Fa_T']);
        unset($row['Rec_ID']);
        unset($row['UUID']);
        if (isset($row['NumberTests'])) unset($row['NumberTests']);
        if (isset($row['CaseFromHcCode'])) unset($row['CaseFromHcCode']);

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
		$hccode = $this->post('hc_code');
		$villcode = $this->post('Code_Vill_t');

		$where = empty($villcode) ? '' : " and a.ID = '$villcode' ";

		$sql = "select a.ID as Code_Vill_T, Year,Month,DateCase,NameK,Age,AgeType,Sex,PregnantMTHS,Weight,Temperature,Mobile,Diagnosis,Treatment,ReferedReason, ReferedOtherReason
					  ,OtherTreatment,DOT1,DOT3 'Dot3days',Refered,Dead,Remark,ID,1 as NumberTests,Rec_ID,Is_Mobile_Entry,Passive, PatientCode, PatientPhone
					  ,PQTreatment,G6PD,IsConsult,IsACT,IsPrimaquine,Primaquine15,Primaquine75,PrimaquineDate
					  ,G6PDHb as G6PDdL,G6PDdL as G6PDHb, Relapse,L1,LC,IMP,c.Code_Prov_T as LC_Province, c.Code_Dist_T as LC_District, c.Code_Comm_T as LC_Commune,LC_Code,Primaquine,ASMQ,IMP_Text,Fingerprint,RdtImage,DiagnosisScan
				from tblVMWActivityCases as a
				join tblCensusVillage as b on a.ID = b.Code_Vill_T
				left join tblCensusVillage as c on a.LC_Code = c.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS
				where Year = '$year' and Month = '$month' and (b.HCCode = '$hccode' or b.HCCode_Meeting = '$hccode') $where order by a.Rec_ID";

		$rs = $this->db->query($sql)->result_array();

		array_walk($rs, function (&$a, $k) {
			$imagePath = FCPATH.'/media/RDT/' . $a['RdtImage'];
			$image = is_file( $imagePath ) && file_exists($imagePath) ? file_get_contents( $imagePath ) : '';
			$a['RdtImage'] = base64_encode($image);
		});

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

		$positive = $this->MReport->search_positive_case ($options);

		$positive_ids = array_map(function($n) {
			return "'{$n['Passive_Case_Id']}'";
		}, $positive);

		if (count($positive_ids) > 0) {
			$result = $this->MReport->search_investigation_cases($positive_ids);
		} else {
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

	public function hc_data_post($patientCode = null)
	{
		$hccode = $this->post('hc_code');
		$year = $this->post('year');
		$month = $this->post('month');
        $where = '';

        if ($patientCode == null) {
            $sql = "select count(*) as count from tblHFActivity where ID = '$hccode' and year = '$year' and month = '$month'";
            $count = $this->db->query($sql)->row('count');
            if ($count == 0) $this->response(-1);

            $where = "where ID = '$hccode' and year = '$year' and month = '$month'";
        } else {
            $where = "where PatientCode = '$patientCode'";
        }

		$sql = $this->getHFDataSql($where);
		$rs = $this->db->query($sql)->result_array();

		array_walk($rs, function (&$a, $k) {
			$imagePath = FCPATH.'/media/RDT/' . $a['RdtImage'];
			$image = is_file( $imagePath ) && file_exists( $imagePath ) ? file_get_contents( $imagePath ) : '';
			$a['RdtImage'] = base64_encode($image);
		});

		$this->response($rs);
	}

	private function getHFDataSql($where)
	{
		return "select Year,Month,DateCase,c.Code_Prov_T,c.Code_Dist_T,c.Code_Comm_T,a.Code_Vill_t,b.Code_Prov_T as PassProvince,b.Code_Dist_T as PassDistrict
					,b.Code_Comm_T as PassCommune,PassVill as PassAddress,NameK,Age,AgeType,Sex,PregnantMTHS,DiagnosisText,ServiceText,Microscopy,RDT,Diagnosis
					,Treatment,OtherTreatment,Refered,ReferedReason,ReferedOtherReason,Dead,ID,1 as NumberTests,Rec_ID,Is_Mobile_Entry,Weight, Temperature, PatientCode, PatientPhone, G6PD, PQTreatment
					,IsConsult,IsACT,IsPrimaquine,Primaquine15,Primaquine75,PrimaquineDate
					,G6PDHb as G6PDdL,G6PDdL as G6PDHb, Relapse,L1,LC,IMP,d.Code_Prov_T as LC_Province, d.Code_Dist_T as LC_District, d.Code_Comm_T as LC_Commune,LC_Code,IMP_Text,Fingerprint, RdtImage, DiagnosisScan
				from tblHFActivityCases as a
				left join tblCensusVillage as b on a.PassVill = b.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS
				left join tblCensusVillage as c on a.Code_Vill_t = c.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS
				left join tblCensusVillage as d on a.LC_Code = d.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS
				$where order by a.Rec_ID";
	}

	public function vmw_data_post($patientCode = null)
	{
		$villcode = $this->post('Code_Vill_t');
	    $year = $this->post('year');
		$month = $this->post('month');
        $where = '';

        if ($patientCode == null) {
            $sql = "select count(*) as count from tblVMWActivity where ID = '$villcode' and year = '$year' and month = '$month'";
            $count = $this->db->query($sql)->row('count');
            if ($count == 0) $this->response(-1);

            $where = "where ID = '$villcode' and year = '$year' and month = '$month'";
        } else {
            $where = "where PatientCode = '$patientCode'";
        }

		$sql = $this->getVMWDataSql($where);

	    $rs = $this->db->query($sql)->result();

	    $this->response($rs);
	}

	private function getVMWDataSql($where)
	{
		return "select Year,Month,DateCase,NameK,Age,Sex,PregnantMTHS,Weight,Temperature,Mobile,Diagnosis,Treatment,OtherTreatment,Primaquine,ASMQ,DOT1, DOT3 'Dot3days',Refered,ReferedReason, ReferedOtherReason,Dead
					,Remark,ID,1 as NumberTests,Rec_ID,Is_Mobile_Entry,Passive, PatientCode, PatientPhone, PQTreatment, G6PD, IsConsult, IsACT, IsPrimaquine, Primaquine15, Primaquine75, PrimaquineDate
					,G6PDHb as G6PDdL,G6PDdL as G6PDHb, Relapse,L1,LC,IMP,b.Code_Prov_T as LC_Province, b.Code_Dist_T as LC_District, b.Code_Comm_T as LC_Commune,LC_Code,IMP_Text,Fingerprint, RdtImage, DiagnosisScan
                    ,b.Name_Vill_K
	            from tblVMWActivityCases as a
				left join tblCensusVillage as b on a.LC_Code = b.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS
				$where order by Rec_ID";
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

	public function hc_data_via_patientcode_post()
	{
		$patientCode = $this->post('PatientCode');

		$this->hc_data_post($patientCode);
	}

	public function vmw_data_via_patientcode_post()
	{
		$patientCode = $this->post('PatientCode');

	    $this->vmw_data_post($patientCode);
	}

	public function pv_list_get()
	{
		$hcCode = $this->get('hc_code');
		$dateCase = $this->get('date_case');

		$sql = "with t as (
					select ID as HCCode, Year, Month, NameK, Age, Sex, PatientCode, Weight, DateCase, Diagnosis,G6PDHb as G6PDdL,G6PDdL as G6PDHb, Rec_ID, 'HC' as Type,Treatment, IsPrimaquine, Is_Mobile_Entry, RDT, Microscopy,Primaquine75,RadicalCureHcCode
					from tblHFActivityCases
					union all
					select b.HCCode, Year, Month, NameK, Age, Sex, PatientCode, Weight, DateCase, Diagnosis,G6PDHb as G6PDdL,G6PDdL as G6PDHb, Rec_ID, 'VMW' as Type,Treatment, IsPrimaquine, Is_Mobile_Entry, 1 as RDT, 0 as Microscopy,Primaquine75,RadicalCureHcCode
					from tblVMWActivityCases as a
					join tblCensusVillage as b on a.ID = b.Code_Vill_T
				),
				t2 as (
					select * from tblHFCodes
					where Code_Facility_T = '{$hcCode}'
				)

				select Code_Facility_T as CaseFromHcCode, Name_Facility_K as CaseFromHcName, Year, Month, NameK, Age, Sex,PatientCode, Weight,
				CAST(DateCase as Date) as DateCase, Diagnosis,G6PDHb as G6PDdL,G6PDdL as G6PDHb, Rec_ID, Type, Diagnosis,Treatment, Is_Mobile_Entry, IsPrimaquine, RDT, Microscopy, Primaquine75,RadicalCureHcCode
				from t
				join tblHFCodes as b on t.HCCode = b.Code_Facility_T
				where Diagnosis in ('V', 'M') and Code_OD_T = (select Code_OD_T from t2)
				and CAST(DateCase as Date) = '{$dateCase}' and Code_Facility_T <> '{$hcCode}'";

		$data = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
	}

	public function patient_get()
	{
		$rec_id = $this->get('rec_id');
		$type = $this->get('type');
		$where = "where Rec_ID = {$rec_id}";

		if ($type == 'HC') $sql = $this->getHFDataSql($where);
		else $sql = $this->getVMWDataSql($where);

		$data = $this->db->query($sql)->row();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
	}
}