<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class VMWFollowup extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	function update_post()
	{
		$q = $this->post('followup');

		$q['IsMobileEntry'] = 1;
		$q['InitTime'] = sqlNow();

		if ($q['Day'] == 'D3') $q['Day'] = 'Day3';
		if ($q['Day'] == 'D7') $q['Day'] = 'Day7';

		$where['PatientCode'] = $q['PatientCode'];
		$where['Day'] = $q['Day'];
		$where['Case_ID'] = $q['Case_ID'];

		$this->db->delete('tblVMWFollowUp', $where);
		$this->db->insert('tblVMWFollowUp', $q);

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);
	}

	function list_get()
	{
		$code_village = $this->get('code_village');
		$year = $this->get('year');
		$month = $this->get('month');

		$followUps = $this->db->query("SP_API_VMWFollowUp '$code_village', '$year', '$month'")->result_array();
        $data = $this->mapFollowupDetail($followUps);

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
	}

    private function mapFollowupDetail($followUps)
    {
        $vmwDetails = $this->getDetailByVMW();

        array_walk($followUps, function (&$a, $k) use($vmwDetails) {
            unset($a['Rec_ID']);

            $found = array_filter($vmwDetails,function($v,$k) use ($a){
                return $v['Case_ID'] == $a['Case_ID'];
            },ARRAY_FILTER_USE_BOTH);

            $a['FollowUp'] = array_values($found);
        });

        return $followUps;
    }

    private function getDetailByVMW()
    {
        $sql = "WITH T as
                (
	                select distinct Day, CAST(SUBSTRING(Day, 4, 5) as int) as DayNum,
	                Case_ID, a.PatientCode, Date, Method, Feeling, a.ASMQ, a.Primaquine,
	                NoPrimaquineReason, NoPrimaquineOtherReason, PrimaquineDose,
	                PrimaquineRemain, CardNoted, NotNotedReason, Symptom, SevereFever, VeryChills,
	                SoreThroat, VeryDarkUrine, VeryPale, VeryWeak, VeryFastHeartBeat,SevereVomiting, OtherSymptom,
	                OverPrimaquine, PatientManagement
	                from tblVMWFollowUp as a
	                left join tblVMWActivityCases as b on a.Case_ID = concat('VMW_', b.Rec_ID)
	                left join tblHFActivityCases as c on a.Case_ID = CONCAT('HC_', c.Rec_ID)
                )

                select Day, Case_ID, PatientCode, Date, Method, Feeling, ASMQ, Primaquine,
		                NoPrimaquineReason, NoPrimaquineOtherReason, PrimaquineDose,
		                PrimaquineRemain, CardNoted, NotNotedReason, Symptom, SevereFever, VeryChills,
		                SoreThroat, VeryDarkUrine, VeryPale, VeryWeak, VeryFastHeartBeat,SevereVomiting, OtherSymptom,
		                OverPrimaquine, PatientManagement from T
                order by Case_ID desc, DayNum";

        return $this->db->query( $sql )->result_array();
    }

	function detail_get()
	{
		$patienCode = $this->get('patient_code');
		$day = $this->get('day');
		$caseID = $this->get('case_id');

		$sql = "select * from tblVMWFollowUp where PatientCode = '{$patienCode}' and Day = '{$day}' and Case_ID = '{$caseID}'";
		$rs = $this->db->query($sql)->row_array();

		unset($rs['PrimaquineDose']);
		unset($rs['VeryDarkUrine']);
		unset($rs['VeryFastHeartBeat']);

		$arr = $this->db->field_data('tblVMWFollowUp');
		$model = [];
		foreach ($arr as $v) {
			$model[$v->name] = $v->type == 'nvarchar' ? '' : null;
		}

		unset($model['Rec_ID']);
		unset($model['PrimaquineDose']);
		unset($model['VeryDarkUrine']);
		unset($model['VeryFastHeartBeat']);

		$rs = empty($rs) ? $model : $rs;

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}
}