<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Reports extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('MReport');
		$this->load->model('MTelegram');
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
					join tblPopByVillages as b on a.Code_Vill_T = b.Code_Vill_T
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
				) as a left join (
					select * from tblPopByVillages where Year = '$year'
				) as b on a.Code_Vill_T = b.Code_Vill_T";

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
					if (isset($row['PassAddress'])) {
						$row['PassVill'] = $row['PassAddress'];
						unset($row['PassAddress']);
					}
					$row['Treatment'] = isset($treatments[$row['Treatment']]) ? $treatments[$row['Treatment']] : $row['Treatment'];
					if ($row['Sex'] == 'F' && $row['PregnantMTHS'] == '') $row['PregnantMTHS'] = 'N';
					$row['Severe'] = $row['Diagnosistext'] == 'Severe' ? 1 : 0;
					$row['ExtraCode'] = $row['Code_Vill_t'];
				} else {
					$row['Dead'] = 0;
					$row['Severe'] = 0;
					$row['Refered'] = 0;
                    $row['SentSMS'] = 0;
				}
				$row['AgeType'] = 'Y';
				$row['Positive'] = $row['Diagnosis'] == 'N' ? 'N' : 'P';
				$row['Is_Mobile_Entry'] = 1;
			}
			$row['ID'] = $row['User_Code_Fa_T'];
			unset($row['User_Code_Fa_T']);

			$list[] = $row;
		}

		$inserted_row = 0;
		$ids = [];
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
			}
			$inserted_row++;
		}

		$this->response(['inserted_row' => $inserted_row]);
	}

    private function getCode($hc_code, $i) {
        $sql = "select max(Code) as Code from
                (
                    select Code from tblHFActivityCases where ID = '{$hc_code}'
                    union all
                    select Code from tblVMWActivityCases as a
                    join tblCensusVillage as b on b.Code_Vill_T = a.ID
                    where b.HCCode = '{$hc_code}'
                ) as sub";

        $code = $this->db->query($sql)->row('Code');

        if (empty($code)) return '' . str_pad($i, 4, '0', STR_PAD_LEFT);
        $code = (int) $code + $i;
        if (strlen($code) < 4) return '' . str_pad($code, 4, '0', STR_PAD_LEFT);
        return '' . $code;
    }

	private function getPatientCode($i)
	{
		$sql = "select Code from dbo.ValueToCode($i ,'WA2009')";
		$code = $this->db->query($sql)->row('Code');
		return $code;
	}

	private function increaseCode()
	{
		$sql = "insert into tblPatient (Code) (select Max(Code)+1 from tblPatient)";
		$this->db->query($sql);
	}

    public function delete_hf_activity_case_post()
    {
        $whereCase['Rec_ID']    = $this->post('rec_id');

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

        $this->db->update('tblHFActivityCases', $row, $whereCase);

		$rec_id = $whereCase['Rec_ID'];
		$sql = "select NameK, PatientCode from tblHFActivityCases where Rec_ID = {$rec_id} and PatientCode is not null";
		$rs = $this->db->query($sql)->result();

        $this->response(['patient' => $rs]);
    }

	public function vmw_activity_cases_post()
	{
		$reports = json_decode(file_get_contents('php://input'), true)['VMW_Activity_Cases'];
		$length = is_array($reports) ? count($reports) : 0;
		$list = [];

		$sql = "select Treatment, Description from tblTreatment";
		$rs = $this->db->query($sql)->result_array();
		$treatments = array_column($rs, 'Treatment', 'Description');

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

				if (isset($row['HC_Code'])) {
					$row['InitUser'] = $row['HC_Code'];
					unset($row['HC_Code']);
				}
				unset($row['Dot3days']);
			}
			$row['ID'] = $row['User_Code_Fa_T'];
			unset($row['User_Code_Fa_T']);

			$list[] = $row;
		}

		$inserted_row = 0;
		$ids = [];
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
			}
			$inserted_row++;
		}

		$this->response(['inserted_row' => $inserted_row]);
	}

	private function notifyToHF($caseId)
	{
		$sql = "select NameK, Sex, Age, PatientCode, Diagnosis, Name_Vill_K, PatientPhone, Token from tblVMWActivityCases as a
				join tblCensusVillage as b on b.Code_Vill_T = a.ID
				join tblToken as c on c.CodePlace = b.HCCode
				where a.Rec_ID = '{$caseId}'";

		$rs = $this->db->query($sql)->result_array();

		$sql = "select * from tblSetting where Name = 'HFTemplate'";
		$body = $this->db->query($sql)->row('Value');

		foreach($rs as $row){
			$body = str_replace('{code}', $row['PatientCode'], $body);
			$body = str_replace('{name}', $row['NameK'], $body);
			$body = str_replace('{sex}', $row['Sex'] == 'M' ? 'ប្រុស' : 'ស្រី', $body);
			$body = str_replace('{age}', $row['Age'], $body);
			$body = str_replace('{village}', $row['Name_Vill_K'], $body);
			$body = str_replace('{patient_phone}', $row['PatientPhone'], $body);
			$body = str_replace('{diagnosis}', $row['Diagnosis'], $body);

			$msg = [
				"to" => $row['Token'],
				"notification" => [
					"title" => "អ្នកជំងឺត្រូវបានបញ្ជូន",
					"body" => $body
				]
			];

			$url = 'https://fcm.googleapis.com/fcm/send';
			$headers = [
				'Authorization: key=' . FIREBASE_TOKEN,
				'Content-Type: application/json'
			];

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($msg));

			$result = curl_exec($ch);

			curl_close($ch);
		}
	}

    public function delete_vmw_activity_case_post()
    {
        $whereCase['Rec_ID'] = $this->post('rec_id');

        $this->db->delete('tblVMWActivityCases', $whereCase);

        $this->response(['success']);
    }

    public function update_vmw_activity_case_post()
    {
        $row = $this->post('VMWCase');

        $sql = "select Treatment, Description from tblTreatment";
		$rs = $this->db->query($sql)->result_array();
		$treatments = array_column($rs, 'Treatment', 'Description');

        $where['Month'] = $row['Month'];
        $where['Year']  = $row['Year'];
        $where['ID']    = $row['User_Code_Fa_T'];
        $whereCase['Rec_ID']= $row['Rec_ID'];

        if ($row['Diagnosis'] != 'N') {
            $row['Treatment'] = isset($treatments[$row['Treatment']]) ? $treatments[$row['Treatment']] : $row['Treatment'];
            if ($row['Sex'] == 'F' && $row['PregnantMTHS'] == '') $row['PregnantMTHS'] = 'N';
            $row['DOT1'] = $row['Dot3days'];
            $row['DOT2'] = $row['Dot3days'];
            $row['DOT3'] = $row['Dot3days'];
			if ($row['Diagnosis'] == 'F') {
				$row['PatientCode'] = null;
				$row['PatientPhone'] = null;
            }
        } else {
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

        $this->db->update('tblVMWActivityCases', $row, $whereCase);

        $rec_id = $whereCase['Rec_ID'];
		$sql = "select NameK, PatientCode from tblVMWActivityCases where Rec_ID = {$rec_id} and PatientCode is not null";
		$rs = $this->db->query($sql)->result();

        $this->response(['patient' => $rs]);
    }

	public function investigation_cases_post()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$reports = $data['Investigation_Cases'];

		for ($i = 0; $i < count($reports); $i++)
		{
			$row = $reports[$i];
			$where['Id'] = $row['Id'];

			foreach ($row as $key => $value) {
				$row[$key] = $value;
			}

			unset($row['Id']);
			unset($row['Is_New']);
			unset($row['Last_12_M']);
			unset($row['Last_3_M']);

			file_put_contents('c:\note.txt', print_r($row, true));

			if ($where['Id'] == 0) {
				$this->db->insert('tblInvestigationCases', $row);
			} else {
				$this->db->update('tblInvestigationCases', $row, $where);
			}
		}

		$this->response(['inserted_row' => $i]);
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

            $this->db->insert('tblReactiveCases', $row);
		}

		$this->response(['inserted_row' => $i]);
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

		$sql = "select Year,Month,DateCase,Code_Vill_t,PassVill as PassAddress,NameK,Age,AgeType,Sex,PregnantMTHS,DiagnosisText,ServiceText,Microscopy,RDT,Diagnosis,Treatment,OtherTreatment,Refered,Dead,ID,1 as NumberTests,Rec_ID,Is_Mobile_Entry,Weight, PatientCode, PatientPhone
		        from tblHFActivityCases where ID = '$hccode' and year = '$year' and month = '$month' order by Rec_ID";
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

	    $sql = "select Year,Month,DateCase,NameK,Age,AgeType,Sex,PregnantMTHS,Weight,Temperature,Mobile,Diagnosis,Treatment,OtherTreatment,DOT3 'Dot3days',Refered,Dead,Remark,ID,1 as NumberTests,Rec_ID,Is_Mobile_Entry,Passive, PatientCode, PatientPhone
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