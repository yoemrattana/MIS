<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require_once FCPATH.'/vendor/autoload.php';
use Message\SingleMessage;
use Message\MultiThreadMessage;
use Message\MessageSender;

class VMW extends REST_Controller
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
					  ,G6PDHb as G6PDdL,G6PDdL as G6PDHb, Relapse,L1,LC,IMP,c.Code_Prov_T as LC_Province, c.Code_Dist_T as LC_District, c.Code_Comm_T as LC_Commune,LC_Code,Primaquine,ASMQ,IMP_Text,Fingerprint
				from tblVMWActivityCases as a
				join tblCensusVillage as b on a.ID = b.Code_Vill_T
				left join tblCensusVillage as c on a.LC_Code = c.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS
				where Year = '$year' and Month = '$month' and (b.HCCode = '$hccode' or b.HCCode_Meeting = '$hccode') $where order by a.Rec_ID";

		$rs = $this->db->query($sql)->result();

		$this->response($rs);
	}
}