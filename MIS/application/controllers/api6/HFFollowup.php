<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class HFFollowup extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function update_post()
	{
		$q = $this->post('followup');

		$where['PatientCode'] = $q['PatientCode'];
		$where['Day'] = $q['Day'];
		$where['Case_ID'] = str_replace('HC_', '', $q['Case_ID']);

		$q['Case_ID'] = str_replace('HC_', '', $q['Case_ID']);

		if ($q['Day'] == 'D3') $q['Day'] = 'Day3';
		if ($q['Day'] == 'D7') $q['Day'] = 'Day7';

		$q['IsMobileEntry'] = 1;
		$q['InitTime'] = sqlNow();

		$this->db->delete('tblHFFollowup', $where);
		$this->db->insert('tblHFFollowup', $q);

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);
	}

	public function list_get()
	{
		$year = $this->get('year');
	    $month = $this->get('month');
	    $hf = $this->get('hc_code');
        $patientCode = $this->get('patient_code');

		$followUps = $this->db->query("SP_API_FollowUp '$hf', '$year', '$month', '$patientCode'")->result_array();
        $data = $this->mapFollowUpDetail($followUps);

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
	}

    private function mapFollowUpDetail($followUps)
    {
        $hcDetails = $this->getDetailByHC();
        $vmwDetails = $this->getDetailByVMW();

        array_walk($followUps, function (&$a, $k) use($hcDetails, $vmwDetails) {
            unset($a['Rec_ID']);

            if($a['HaveVMW']) {
                $found = array_filter($vmwDetails,function($v,$k) use ($a){
                    return $v['Case_ID'] == $a['Case_ID'];
                },ARRAY_FILTER_USE_BOTH);
            } else {
                $found = array_filter($hcDetails,function($v,$k) use ($a){
                    return $v['Case_ID'] == $a['Case_ID'];
                },ARRAY_FILTER_USE_BOTH);
            }

            $a['FollowUp'] = array_values($found);
        });

        return $followUps;
    }

    private function getDetailByHC()
    {
        $sql = "WITH T as (
	            select distinct Day, CAST(SUBSTRING(Day, 4, 5) as int) as DayNum,
	            concat('HC_',Case_ID) as Case_ID,  a.PatientCode, Date, Call, a.Refered, Code, TabletRemain
	            from tblHFFollowup as a
	            join tblHFActivityCases as b on a.Case_ID = b.Rec_ID
            )

            select Day, Case_ID,
            PatientCode, Date, Call, Refered, Code, TabletRemain from T
            order by Case_ID desc, DayNum";

        return $this->db->query( $sql )->result_array();
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

	public function detail_get()
	{
		$patienCode = $this->get('patient_code');
		$day = $this->get('day');

		$caseID = str_replace('HC_', '', $this->get('case_id') );

		if($day == 'D3') $day = 'Day3';
		if($day == 'D7') $day = 'Day7';

		$sql = "select * from tblHFFollowup where PatientCode = '{$patienCode}' and Day = '{$day}' and Case_ID = '{$caseID}'";
		$rs = $this->db->query($sql)->row_array();

		$arr = $this->db->field_data('tblHFFollowup');
		$model = [];
		foreach ($arr as $v) {
			$model[$v->name] = $v->type == 'nvarchar' ? '' : null;
		}

		unset($model['Rec_ID']);

		$rs = empty($rs) ? $model : $rs;

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}
}