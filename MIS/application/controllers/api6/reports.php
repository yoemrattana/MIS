<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require_once FCPATH.'/vendor/autoload.php';

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

    public function search_patient_get()
    {
        $code = $this->get('code');
        $name = $this->get('name');
        $phone = $this->get('phone');
        $age = $this->get('age');
        $sex = $this->get('sex');
        $vill = $this->get('code_vill_t');

        $patient = [
          'name' => str_replace(' ','%',$name),
          'code' => $code,
          'sex' => $sex,
          'age' => $age,
          'phone' => $phone,
          'vill' => $vill
        ];

        $data = $this->MPatient->searchPatient($patient);

        $response = [
            "code" => 200,
            "message" => "success",
            "data" => $data
        ];

        $this->response($response);
    }

    /**
     * VMW
     */
    public function vmw_activity_cases_post()
	{
		$reports = json_decode(file_get_contents('php://input'), true)['VMW_Activity_Cases'];
		$length = is_array($reports) ? count($reports) : 0;
		$list = [];
		$place = '';

		$treatments = $this->MReport->getTreatments();
		$isIP2 = $this->MReport->isIP2($reports);
		$notifySpecies = $this->MReport->getNotifySpecies();

		for ($i = 0; $i < $length; $i ++)
		{
			$row = $reports[$i];
			if (!isset($row['NumberTests'])) $row['NumberTests'] = 0;

            if(empty($row['Diagnosis']))  $row['Diagnosis'] = 'S';

			if ($row['NumberTests'] > 0) {
				if ((!isset($row['Sex']) || $row['Sex'] == '') && $row['Diagnosis'] != 'S') continue;
				if ((!isset($row['Age']) || $row['Age'] === null || $row['Age'] === '') && $row['Diagnosis'] != 'S') continue;

				$row['AgeType'] = 'Y';

				if ( !in_array($row['Diagnosis'], ['N', 'S']) ) {
					$row['YearCase'] = substr($row['DateCase'], 0, 4);
					$row['MonthCase'] = substr($row['DateCase'], 5, 2);
					$row['PatientPhone'] = empty($row['PatientPhone']) ? null : $row['PatientPhone'];
					$row['Treatment'] = isset($treatments[$row['Treatment']]) ? $treatments[$row['Treatment']] : $row['Treatment'];
					if ($row['Sex'] == 'F' && $row['PregnantMTHS'] == '') $row['PregnantMTHS'] = 'N';

					$row['DOT2'] = 0;
					$row['DOT3'] = 0;

					$row['Refered'] = isset($row['ReferedReason']) && !empty($row['ReferedReason']) ? 1 : 0;

                    //if (isset($row['G6PDHb']) && isset($row['G6PDdL'])) {
                    //    $temp = $row['G6PDHb'];
                    //    $row['G6PDHb'] = $row['G6PDdL'];
                    //    $row['G6PDdL'] = $temp;
                    //}

                    if (!isset($row['EverHadMalaria'])) $row['EverHadMalaria'] = null;
					if (!isset($row['Relapse'])) $row['Relapse'] = null;
					if (!isset($row['L1'])) $row['L1'] = null;
					if (!isset($row['LC'])) $row['LC'] = null;
					if (!isset($row['IMP'])) $row['IMP'] = null;
					if (!isset($row['LC_Code'])) $row['LC_Code'] = null;
					if (!isset($row['IMP_Text'])) $row['IMP_Text'] = null;

					if ( in_array($row['Diagnosis'], ['V', 'M', 'F', 'A', 'O', 'K']) ) {
                        if( $row['EverHadMalaria'] == 0 ) {
                            $row['Relapse'] = 0;
                            $row['Recrudescence'] = 0;
                        } else {
                            if ($row['Relapse'] == 1 || $row['Recrudescence'] ==1) {
                                $row['LocallyAcquired'] = null;
                                $row['DomesticallyImported'] = null;
                                $row['InternationalImported'] = null;
                            } elseif ($row['LocallyAcquired'] == 1) {
                                $row['DomesticallyImported'] = null;
                                $row['InternationalImported'] = null;
                            } elseif ($row['DomesticallyImported'] == 1) {
                                $row['InternationalImported'] = null;
                            }
                        }
					}

					if (isset($row['Primaquine75']) && !empty($row['Primaquine75'])) {
						$row['PrimaquineDate'] = $row['DateCase'];
						$r = $this->db->get_where('tblCensusVillage', ['Code_Vill_T' => $row['Code_Vill_T']])->row_array();
						$row['RadicalCureHcCode'] = $r['HCCode'];
					}
					else {
						$row['PrimaquineDate'] = null;
					}

					$patientCode = $row['PatientCode'] ?? '';
					$fingerprint = $row['Fingerprint'] ?? '';
					$row['PatientCode'] = $this->MPatient->createCode($row['Code_Vill_T'], $row['Diagnosis'], $patientCode, $fingerprint);
					$row['IsNotified'] = 0;
				} elseif ($row['Diagnosis'] == 'S'){
                    $row['YearCase'] = $row['Year'];
					$row['MonthCase'] = $row['Month'];
                    $row['Sex'] = null;
                    $row['PregnantMTHS'] = null;
                    $row['Refered'] = 0;
                    $row['SentSMS'] = 0;
                }
                else {
					$row['YearCase'] = $row['Year'];
					$row['MonthCase'] = $row['Month'];
					$row['NameK'] = null;
					$row['Refered'] = 0;
					$row['ReferedOtherReason'] = null;
					$row['ReferedReason'] = null;
                    $row['SymptomDate'] = null;
                    $row['EverHadMalaria'] = null;
                    $row['ReferredFromService'] = null;
                    $row['ReferredFromServiceOther'] = null;
                    $row['SentSMS'] = 0;
					$row['PatientCode'] = null;
					$row['Relapse'] = null;
					$row['L1'] = null;
					$row['LC'] = null;
					$row['IMP'] = null;
                    $row['Recrudescence'] = null;
                    $row['LocallyAcquired'] = null;
                    $row['DomesticallyImported'] = null;
                    $row['InternationalImported'] = null;
					$row['LC_Code'] = null;
					$row['IMP_Text'] = null;
					$row['Primaquine'] = null;
					$row['ASMQ'] = null;
					$row['IsNotified'] = null;
				}
                if($row['Diagnosis'] == 'N') {
                    $row['Positive'] = 'N';
                } else if($row['Diagnosis'] == 'S') {
                    $row['Positive'] = 'S';
                } else {
                    $row['Positive'] = 'P';
                }
				$row['Dead'] = 0;
				$row['Is_Mobile_Entry'] = 1;

				if ( isset( $row['RdtImage']) && !empty( $row['RdtImage'] ) ) {
					$dir = FCPATH.'/media/RDT';
					if (!file_exists($dir)) mkdir($dir);
					$filename = $row['Code_Vill_T'] . '-' . $row['Diagnosis'] . '-' . uniqid() . '.jpg';
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
			if ( isset( $row['Code_Vill_T'] ) ) {
                $row['ID'] = $row['Code_Vill_T'];
                $place = $row['Code_Vill_T'];
                unset($row['Code_Vill_T'] , $row['User_Code_Fa_T']);
            }

			if ( isset( $row['Code_Vill_t'] ) ) {
                $row['ID'] = $row['Code_Vill_t'];
                $place = $row['Code_Vill_t'];
                unset($row['Code_Vill_t'] , $row['User_Code_Fa_T']);
            }

			if( !isset( $row['Code_Vill_T'] )
				&& !isset( $row['Code_Vill_t'] )
				&& isset( $row['User_Code_Fa_T'] )
			) {
                $row['ID'] = $row['User_Code_Fa_T'];
                $place = $row['User_Code_Fa_T'];
                unset( $row['User_Code_Fa_T'] );
            }

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
				//unset($data['Code_Vill_T']);
                if(isset($data['Code_Vill_t'])) unset($data['Code_Vill_t']);
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

                if($data['Diagnosis'] == 'S') continue;

				if ($data['PatientCode'] != '' && $isByHc == false) {
					array_push($patients, ['NameK' => str_replace("♣","", $data['NameK']), 'PatientCode' => $data['PatientCode']]);
				}

				$data['Rec_ID'] = $id;
				unset($data['Code_Vill_T']);
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

        $treatments = $this->MReport->getTreatments();

        $whereCase['Rec_ID'] = $row['Rec_ID'];

        if(empty($row['Diagnosis'])) $row['Diagnosis'] = 'S';

        if ( !in_array($row['Diagnosis'], ['N', 'S']) ) {
			$row['YearCase'] = substr($row['DateCase'], 0, 4);
			$row['MonthCase'] = substr($row['DateCase'], 5, 2);
            $row['Treatment'] = isset($treatments[$row['Treatment']]) ? $treatments[$row['Treatment']] : $row['Treatment'];
			if ($row['Sex'] == 'F' && $row['PregnantMTHS'] == '') $row['PregnantMTHS'] = 'N';

            $row['DOT2'] = 0;
            $row['DOT3'] = 0;

			$row['Refered'] = isset($row['ReferedReason']) && !empty($row['ReferedReason']) ? true : false;

			if ( isset($row['G6PDHb']) && empty($row['G6PDHb']) ) $row['G6PDHb'] = null;
			if ( isset($row['G6PDdL']) && empty($row['G6PDdL']) ) $row['G6PDdL'] = null;

            if (!isset($row['EverHadMalaria'])) $row['EverHadMalaria'] = null;
			if (!isset($row['Relapse'])) $row['Relapse'] = null;
			if (!isset($row['L1'])) $row['L1'] = null;
			if (!isset($row['LC'])) $row['LC'] = null;
			if (!isset($row['IMP'])) $row['IMP'] = null;
			if (!isset($row['LC_Code'])) $row['LC_Code'] = null;
			if (!isset($row['IMP_Text'])) $row['IMP_Text'] = null;

			if ( in_array($row['Diagnosis'], ['V', 'M', 'F', 'A', 'O', 'K']) ) {
                if( $row['EverHadMalaria'] == 0 ) {
                    $row['Relapse'] = 0;
                    $row['Recrudescence'] = 0;
                } else {
                    if ($row['Relapse'] == 1 || $row['Recrudescence'] ==1) {
                        $row['LocallyAcquired'] = null;
                        $row['DomesticallyImported'] = null;
                        $row['InternationalImported'] = null;
                    } elseif ($row['LocallyAcquired'] == 1) {
                        $row['DomesticallyImported'] = null;
                        $row['InternationalImported'] = null;
                    } elseif ($row['DomesticallyImported'] == 1) {
                        $row['InternationalImported'] = null;
                    }
                }
            }

			// TODO date follow up
			$currentCase = $this->db->get_where('tblVMWActivityCases', $whereCase)->row_array();
			if (empty($currentCase['Primaquine75'])
				&& isset($row['Primaquine75'])
				&& !empty($row['Primaquine75'])
			) {
				$row['PrimaquineDate'] = date("Y-m-d");
			}

			$row['PatientCode'] = $this->MPatient->createCode($row['Code_Vill_T'], $row['Diagnosis'], $row['PatientCode']);

			if (empty($row['PatientCode']) && !empty($row['Primaquine75']))
				$row['PatientCode'] = $this->MPatient->getNewCode();

			$n = $row;

			$n['ID'] = $n['Code_Vill_T'];
            unset($n['Code_Vill_T']);
			$this->MPatient->createNotification($n);

			if (!isset($row['PQTreatment'])) {
				$row['PQTreatment'] = '';
			}
        } else if ($row['Diagnosis'] == 'S'){
            $row['YearCase'] = $row['Year'];
            $row['MonthCase'] = $row['Month'];
            $row['Sex'] = null;
            $row['PregnantMTHS'] = null;
            $row['Refered'] = 0;
            $row['SentSMS'] = 0;
        }
        else {
			$row['YearCase'] = $row['Year'];
			$row['MonthCase'] = $row['Month'];
			$row['NameK'] = null;
            $row['Refered'] = 0;
            $row['Treatment'] = null;
            $row['PregnantMTHS'] = null;
            $row['NameK'] = null;
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
            $row['Recrudescence'] = null;
            $row['LocallyAcquired'] = null;
            $row['DomesticallyImported'] = null;
            $row['InternationalImported'] = null;
			$row['L1'] = null;
			$row['LC'] = null;
			$row['IMP'] = null;
			$row['LC_Code'] = null;
			$row['IMP_Text'] = null;
			$row['IsNotified'] = null;
            $row['SymptomDate'] = null;
            $row['EverHadMalaria'] = null;
            $row['Address'] = null;
            $row['Primaquine'] = null;
            $row['ASMQ'] = null;
        }

        if($row['Diagnosis'] == 'N') {
            $row['Positive'] = 'N';
        } else if($row['Diagnosis'] == 'S') {
            $row['Positive'] = 'S';
        } else {
            $row['Positive'] = 'P';
        }

        $row['Dead'] = 0;
        $row['Is_Mobile_Entry'] = 1;

        if (isset($row['HC_Code'])) {
            $row['InitUser'] = $row['HC_Code'];
            $row['ModiUser'] =  $row['HC_Code'];
            $row['RadicalCureHcCode'] = $row['HC_Code'];
            unset($row['HC_Code']);
        }
        unset($row['Dot3days']);

		$row['ID'] = $row['Code_Vill_T'];
        $row['ModiTime'] = sqlNow();

        $oldCase = $this->MPatient->getPatient($row['Rec_ID'], 'VMW');

        if($oldCase['Diagnosis'] != $row['Diagnosis']) {
            $row['OldDiagnosis'] = $oldCase['Diagnosis'];
            $row['IsNotified'] = 0;
        }

        unset($row['Code_Vill_T']);
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

    public function vwm_summary_get()
    {
        $villcode = $this->get('Code_Vill_t');
        $year = $this->get('year');
        $month = $this->get('month');

        $where = "where ID = '$villcode' and year = '$year' and month = '$month'";
        $data['summary'] = $this->MReport->getVmwSummary($where);

        //$data['list'] = $this->MReport->getVmwList($where);

        $response = [
            "code" => 200,
            "message" => "success",
            "data" => $data
        ];

        $this->response($response);
    }

	//delete
    public function vmw_wormabet_get()
    {
        $codeVill = $this->get('Code_Vill_T');
		$year = $this->get('year');
		$month = $this->get('month');

		$data = $this->MReport->getWormAbet($codeVill, $year, $month);

        $response = [
            "code" => 200,
            "message" => "success",
            "data" => $data
        ];

        $this->response($response);
    }

	//delete
    public function update_vmw_wormabet_post()
    {
        $data = $this->post('wormabet');

        $data['InitTime'] = sqlNow();

        $where['Code_Vill_T'] = $data['Code_Vill_T'];
        $where['Year'] = $data['Year'];
        $where['Month'] = $data['Month'];

        $this->db->delete('tblVMWWormAbet', $where);
		$this->db->insert('tblVMWWormAbet', $data);

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);
    }

    public function vmw_edu_get()
    {
        $codeVill = $this->get('Code_Vill_T');
		$year = $this->get('year');
		$month = $this->get('month');

		$data = $this->MReport->getVmwEdu($codeVill, $year, $month);

        $response = [
            "code" => 200,
            "message" => "success",
            "data" => $data
        ];

        $this->response($response);
    }

    public function update_vmw_edu_post()
    {
        $data = $this->post('vmwedu');

        $data['InitTime'] = sqlNow();

        $where['Code_Vill_T'] = $data['Code_Vill_T'];
        $where['Year'] = $data['Year'];
        $where['Month'] = $data['Month'];

        $this->db->delete('tblVMWEdu', $where);
		$this->db->insert('tblVMWEdu', $data);

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);
    }

    public function vmw_commodity_get()
    {
        $codeVil = $this->get('Code_Vill_T');
		$year = $this->get('Year');
		$month = $this->get('Month');

		$sql = "SP_VMWCommodityForm '$codeVil','$year','$month'";
		$rs = $this->db->query($sql)->result_array();

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
    }

    public function update_vmw_commodity_post()
    {
        $vmw = $this->post('Code_Vill_T');
		$year = $this->post('Year');
		$month = $this->post('Month');
		$data = $this->post('Data');

		foreach ($data as $r)
		{
			if (!isset($r['ItemId'])) continue;

			$itemId = $r['ItemId'];
			$sql = "select count(*) as count
					from tblVMWCommodity
					where Code_Vill_T = '$vmw' and Year = '$year' and Month = '$month' and ItemId = $itemId";
			$count = $this->db->query($sql)->row('count');

			$value = [];
			$value['StockStart'] = $r['StockStart'];
			$value['StockIn'] = $r['StockIn'];
			$value['StockOut'] = $r['StockOut'];
			$value['Balance'] = toInt($r['StockStart']) + toInt($r['StockIn']) - toInt($r['StockOut']);

			if ($count == 0) {
				$value['Code_Vill_T'] = $vmw;
				$value['Year'] = $year;
				$value['Month'] = $month;
				$value['ItemId'] = $itemId;
				$value['InitUser'] = $vmw;
				$this->db->insert('tblVMWCommodity', $value);
			} else {
				$value['ModiUser'] = $vmw;
				$value['ModiTime'] = sqlNow();

				$where = [];
				$where['Code_Vill_T'] = $vmw;
				$where['Year'] = $year;
				$where['Month'] = $month;
				$where['ItemId'] = $itemId;
				$this->db->update('tblVMWCommodity', $value, $where);
			}
		}

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);

    }

	public function vmw_data_get($patientCode = null)
	{
		$villcode = $this->get('Code_Vill_t');
	    $year = $this->get('year');
		$month = $this->get('month');
        $where = '';

        if ($patientCode == null) {
            $sql = "select count(*) as count from tblVMWActivity where ID = '$villcode' and year = '$year' and month = '$month'";
            $count = $this->db->query($sql)->row('count');
            if ($count == 0) {
                $response = [
			        "code" => 200,
			        "message" => "success",
			        "data" => []
		        ];

                $this->response($response);
            }

            $where = "where ID = '$villcode' and year = '$year' and month = '$month'";
        } else {
            $where = "where PatientCode = '$patientCode'";
        }

		$sql = $this->getVMWDataSql($where);

	    $data = $this->db->query($sql)->result();

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
	}

	private function getVMWDataSql($where)
	{
		return "select Year,Month,DateCase,NameK,Age,Sex,PregnantMTHS,Weight,Temperature,Mobile,Diagnosis,Treatment,OtherTreatment,Primaquine,ASMQ,DOT1, DOT3 'Dot3days',Refered,ReferedReason, ReferedOtherReason,Dead
	                ,Remark,ID, ID as Code_Vill_T,1 as NumberTests,Rec_ID,Is_Mobile_Entry,Passive, PatientCode, PatientPhone, PQTreatment, G6PD, IsConsult, IsACT, IsPrimaquine, Primaquine15, Primaquine75, PrimaquineDate
	                ,G6PDHb,G6PDdL, Relapse,Fingerprint, RdtImage, DiagnosisScan
                    ,EverHadMalaria, a.Address,b.Code_Prov_T,b.Code_Dist_T, b.Code_Comm_T, SymptomDate, ReferredFromService, ReferredFromServiceOther, Recrudescence, LocallyAcquired, DomesticallyImported, InternationalImported, Suspect
                    ,PregnantTest,HbD0,HbD3, HbD7
                from tblVMWActivityCases as a
                left join tblCensusVillage as b on a.Address = b.Code_Vill_T
				$where order by Rec_ID";
	}

    public function vmw_patient_get()
	{
		$year = $this->get('year');
		$month = $this->get('month');
		$hccode = $this->get('hc_code');
		$villcode = $this->get('Code_Vill_t');

		$where = empty($villcode) ? '' : " and a.ID = '$villcode' ";

		$sql = "select Year,Month,DateCase,NameK,Age,Sex,PregnantMTHS,Weight,Temperature,Mobile,Diagnosis,Treatment,OtherTreatment,Primaquine,ASMQ,DOT1, DOT3 'Dot3days',Refered,ReferedReason, ReferedOtherReason,Dead
	                ,Remark,ID,1 as NumberTests,Rec_ID,Is_Mobile_Entry,Passive, PatientCode, PatientPhone, PQTreatment, G6PD, IsConsult, IsACT, IsPrimaquine, Primaquine15, Primaquine75, PrimaquineDate
	                ,G6PDHb as G6PDdL,G6PDdL as G6PDHb, Relapse,Fingerprint, RdtImage, DiagnosisScan
                    ,EverHadMalaria, a.Address,b.Code_Prov_T,b.Code_Dist_T, b.Code_Comm_T, SymptomDate, ReferredFromService, ReferredFromServiceOther, Recrudescence, LocallyAcquired, DomesticallyImported, InternationalImported, Suspect
                    ,PregnantTest,HbD0,HbD3, HbD7
                from tblVMWActivityCases as a
                left join tblCensusVillage as b on a.ID = b.Code_Vill_T
				where Year = '$year' and Month = '$month' and (b.HCCode = '$hccode' or b.HCCode_Meeting = '$hccode') $where order by a.Rec_ID";

		$rs = $this->db->query($sql)->result_array();

		array_walk($rs, function (&$a, $k) {
			$imagePath = FCPATH.'/media/RDT/' . $a['RdtImage'];
			$image = is_file( $imagePath ) && file_exists($imagePath) ? file_get_contents( $imagePath ) : '';
			$a['RdtImage'] = base64_encode($image);
		});

        $response = [
            "code" => 200,
            "message" => "success",
            "data" => $rs
        ];

        $this->response($response);
	}

    /*
     * HF
     * */

    public function hf_activity_cases_post()
	{
		$reports = json_decode(file_get_contents('php://input'), true)['HF_Activity_Cases'];
		$length = is_array($reports) ? count($reports) : 0;
		$list = [];
		$place = '';

		$treatments = $this->MReport->getTreatments();

		for($i = 0; $i < $length; $i ++)
		{
			$row = $reports[$i];

			if (!isset($row['NumberTests'])) $row['NumberTests'] = 0;

            if(empty($row['Diagnosis']))  $row['Diagnosis'] = 'S';

			if ($row['NumberTests'] > 0) {
				if (!isset($row['Sex']) || $row['Sex'] == '') continue;
				if (!isset($row['Age']) || $row['Age'] === null || $row['Age'] === '') continue;

				if ($row['Sex'] == 'F' && isset($row['PregnantMTHS']) && $row['PregnantMTHS'] == '') $row['PregnantMTHS'] = 'N';

				if ( !in_array($row['Diagnosis'], ['N', 'S']) ) {
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

                    //if (isset($row['G6PDHb']) && isset($row['G6PDdL'])) { //exchange value because app use wrong parameter
                    //    $temp = $row['G6PDHb'];
                    //    $row['G6PDHb'] = $row['G6PDdL'];
                    //    $row['G6PDdL'] = $temp;
                    //}

					if (!isset($row['Relapse'])) $row['Relapse'] = null;
					if (!isset($row['L1'])) $row['L1'] = null;
					if (!isset($row['LC'])) $row['LC'] = null;
					if (!isset($row['IMP'])) $row['IMP'] = null;
					if (!isset($row['LC_Code'])) $row['LC_Code'] = null;
					if (!isset($row['IMP_Text'])) $row['IMP_Text'] = null;

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
				}
                else if ($row['Diagnosis'] == 'S'){
                    $row['YearCase'] = $row['Year'];
					$row['MonthCase'] = $row['Month'];
                    $row['Diagnosistext'] = null;
                    $row['Microscopy'] = null;
                    $row['RDT'] = null;
                    $row['Sex'] = null;
                    $row['PregnantMTHS'] = null;
                    $row['Dead'] = 0;
                    $row['Refered'] = 0;
                    $row['SentSMS'] = 0;
                    $row['Severe'] = 0;
                }
                else {
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

                if($row['Diagnosis'] == 'N') {
                    $row['Positive'] = 'N';
                } else if($row['Diagnosis'] == 'S') {
                    $row['Positive'] = 'S';
                } else {
                    $row['Positive'] = 'P';
                }

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

                if($data['Diagnosis'] == 'S') continue;

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
        $treatments = $this->MReport->getTreatments();

        $row = $this->post('HFCase');

        $whereCase['Rec_ID']= $row['Rec_ID'];

        if(empty($row['Diagnosis']))  $row['Diagnosis'] = 'S';

        if ( !in_array($row['Diagnosis'], ['N', 'S']) ) {
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

            //if (isset($row['G6PDHb']) && isset($row['G6PDdL'])) { //exchange value because app use wrong parameter
            //    $temp = $row['G6PDHb'];
            //    $row['G6PDHb'] = $row['G6PDdL'] == '' ? NULL : $row['G6PDdL'];
            //    $row['G6PDdL'] = $temp == '' ? NULL : $temp;
            //}

			if (!isset($row['Relapse'])) $row['Relapse'] = null;
			if (!isset($row['L1'])) $row['L1'] = null;
			if (!isset($row['LC'])) $row['LC'] = null;
			if (!isset($row['IMP'])) $row['IMP'] = null;
			if (!isset($row['LC_Code'])) $row['LC_Code'] = null;
			if (!isset($row['IMP_Text'])) $row['IMP_Text'] = null;

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
        }
        else if ($row['Diagnosis'] == 'S'){
            $row['YearCase'] = $row['Year'];
            $row['MonthCase'] = $row['Month'];
            $row['Diagnosistext'] = null;
            $row['Microscopy'] = null;
            $row['RDT'] = null;
            $row['Sex'] = null;
            $row['PregnantMTHS'] = null;
            $row['Dead'] = 0;
            $row['Refered'] = 0;
            $row['SentSMS'] = 0;
            $row['Severe'] = 0;
        }
        else {
			$row['YearCase'] = $row['Year'];
			$row['MonthCase'] = $row['Month'];
			$row['NameK'] = null;
			$row['Code_Vill_t'] = null;
            $row['PassVill'] = null;
            $row['Dead'] = 0;
            $row['Refered'] = 0;
            $row['SentSMS'] = 0;
            $row['Treatment'] = null;
            $row['Diagnosistext'] = null;
            $row['ServiceText'] = null;
            $row['PatientCode'] = null;
			$row['G6PDHb'] = null;
			$row['G6PDdL'] = null;
			$row['Primaquine'] = null;
            $row['ASMQ'] = null;
            $row['Mobile'] = null;
            $row['ReferredFromService'] = null;
            $row['AgeMonth'] = null;
            $row['IPD'] = null;
            $row['OPD'] = null;
            $row['DOT1'] = null;
			$row['IsNotified'] = null;
        }
        $row['AgeType'] = 'Y';

        if($row['Diagnosis'] == 'N') {
            $row['Positive'] = 'N';
        } else if($row['Diagnosis'] == 'S') {
            $row['Positive'] = 'S';
        } else {
            $row['Positive'] = 'P';
        }

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

    public function hc_data_get($patientCode = null)
	{
		$hccode = $this->get('hc_code');
		$year = $this->get('year');
		$month = $this->get('month');
        $where = '';

        if ($patientCode == null) {
            $sql = "select count(*) as count from tblHFActivity where ID = '$hccode' and year = '$year' and month = '$month'";
            $count = $this->db->query($sql)->row('count');
            if ($count == 0) {
                $response = [
			        "code" => 200,
			        "message" => "success",
			        "data" => []
		        ];

                $this->response($response);
            }

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

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	private function getHFDataSql($where)
	{
		return "select Year,Month,DateCase,c.Code_Prov_T,c.Code_Dist_T,c.Code_Comm_T,a.Code_Vill_t,NameK,Age,AgeType,Sex,PregnantMTHS,DiagnosisText,ServiceText,Microscopy,RDT,Diagnosis
	                ,Treatment,OtherTreatment,Refered,ReferedReason,ReferedOtherReason,Dead,ID,1 as NumberTests,Rec_ID,Is_Mobile_Entry,Weight, Temperature, PatientCode, PatientPhone, G6PD, PQTreatment
	                ,IsConsult,IsACT,IsPrimaquine,Primaquine15,Primaquine75,PrimaquineDate
	                ,G6PDHb,G6PDdL, Relapse,Fingerprint, RdtImage, DiagnosisScan
	                ,Mobile, IPD, OPD, ASMQ, Primaquine, DOT1, ReferredFromService, AgeMonth, Suspect, PregnantTest,HbD0,HbD3, HbD7
                from tblHFActivityCases as a
                left join tblCensusVillage as c on a.Code_Vill_t = c.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS
				$where order by a.Rec_ID";
	}

    public function pv_list_get()
	{
		$hcCode = $this->get('hc_code');
		$dateCase = $this->get('date_case');

		$sql = "with t as (
					select ID as HCCode, Year, Month, NameK, Code_Vill_t, Age, Sex, PatientCode, Weight, DateCase, Diagnosis,G6PDHb as G6PDdL,G6PDdL as G6PDHb, Rec_ID, 'HC' as Type,Treatment, IsPrimaquine, Is_Mobile_Entry, RDT, Microscopy,Primaquine75,RadicalCureHcCode,IsConsult, IsACT
					from tblHFActivityCases
					union all
					select b.HCCode, Year, Month, NameK, b.Code_Vill_T, Age, Sex, PatientCode, Weight, DateCase, Diagnosis,G6PDHb as G6PDdL,G6PDdL as G6PDHb, Rec_ID, 'VMW' as Type,Treatment, IsPrimaquine, Is_Mobile_Entry, 1 as RDT, 0 as Microscopy,Primaquine75,RadicalCureHcCode,IsConsult, IsACT
					from tblVMWActivityCases as a
					join tblCensusVillage as b on a.ID = b.Code_Vill_T
				),
				t2 as (
					select * from tblHFCodes
					where Code_Facility_T = '{$hcCode}'
				)

				select Code_Facility_T as CaseFromHcCode, Name_Facility_K as CaseFromHcName, Year, Month, NameK, Age, Sex,PatientCode, Weight,
				CAST(DateCase as Date) as DateCase, Diagnosis,G6PDHb,G6PDdL, Rec_ID, Type, Diagnosis,Treatment, Is_Mobile_Entry, IsPrimaquine, RDT, Microscopy, Primaquine75,RadicalCureHcCode
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