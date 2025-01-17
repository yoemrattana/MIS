<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class CIHF extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

    public function list_get()
	{
		$hf =  $this->get('HC_Code');
		$month = $this->get('month');
		$year = $this->get('year');

		$sql = "WITH T as (
	        select PatientCode, NameK,Age, Sex, Diagnosis, Weight, Month, Year, DateCase, ID as Code_Facility_T, Rec_ID as Case_ID, 'HC' as Case_Type
	        from tblHFActivityCases
	        where year = $year and month = $month and Positive = 'P'

	        union all

	        select PatientCode, NameK,Age, Sex, Diagnosis, Weight, Month, Year, DateCase, HCCode as Code_Facility_T, Rec_ID as Case_ID, 'VMW' as Case_Type
	        from tblVMWActivityCases as a
	        join tblCensusVillage as b on a.ID = b.Code_Vill_T
	        where year = $year and month = $month and Positive = 'P'
        )

        select a.*, Code_OD_T, Code_Prov_N, isnull(c.Rec_ID,0) as Rec_ID from T as a
        join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
        left join tblCI_HF as c on a.Case_ID = c.Case_ID and c.Case_Type = a.Case_Type
        where b.Code_Facility_T = '$hf'
        order by Month";

        $rs = $this->db->query( $sql )->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function update_post()
	{
		$q = $this->post('CI');

        $travels = $q['Travels'];
        unset($q['Travels']);

        $parentId = '';
        if( isset( $q['Rec_ID'] ) ) {
            $parentId = $q['Rec_ID'];
            unset($q['Rec_ID']);
        }

        $q['ASMQfakvDay'] = empty($q['ASMQfakvDay']) ? null : $q['ASMQfakvDay'];
        $q['ASMQSLDPfakvDay'] = empty($q['ASMQSLDPfakvDay']) ? null : $q['ASMQSLDPfakvDay'];

        $q['ASMQvoDay'] = empty($q['ASMQvoDay']) ? null : $q['ASMQvoDay'];
        $q['ASMQSLDPvoDay'] = empty($q['ASMQSLDPvoDay']) ? null : $q['ASMQSLDPvoDay'];

        $q['Symptom'] = str_replace(',', ', ', $q['Symptom']);;

        if ( empty( $parentId ) ) {
            $q['InitTime'] = sqlNow();
            $this->insert($q, $travels);
        } else {
            $this->update($q, $travels, $parentId);
        }

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);
	}

    private function insert($parent, $travels)
    {
        $this->db->insert('tblCI_HF', $parent);
        $parentId = $this->db->insert_id();

        if( !empty($travels) ) {
            foreach($travels as $r) {
                if(empty($r['DateFrom']) || empty( $r['DateTo'])) continue;
                if (isset($r['Rec_ID'])) unset($r['Rec_ID']);
                $r['Parent_ID'] = $parentId;
                $this->db->insert('tblCI_HF_Travel', $r);
            }
        }

        return $parentId;
    }

    private function update($parent, $travels, $parentId)
    {
        $parent['ModiTime'] = sqlNow();
        $this->db->update('tblCI_HF', $parent, ['Rec_ID' => $parentId]);
        $this->db->delete('tblCI_HF_Travel', ['Parent_ID'=> $parentId]);

        if( !empty($travels) ) {
            foreach($travels as $r) {
                if(empty($r['DateFrom']) || empty( $r['DateTo'])) continue;
                if (isset($r['Rec_ID'])) unset($r['Rec_ID']);
                $r['Parent_ID'] = $parentId;
                $this->db->insert('tblCI_HF_Travel', $r);
            }
        }
    }

	public function detail_get()
	{
        $recID = $this->get('Rec_ID');

        $sql = "select * from tblCI_HF where Rec_ID = $recID";
        $rs = $this->db->query($sql)->row_array();

        $parentID = $rs ? $rs['Rec_ID'] : 0;

        $travel = $this->getTravel($parentID);

        $rs['Travels'] = $travel;

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

    private function getTravel($parentID)
    {
        if ($parentID == 0) return [];
        $sql = "select * from tblCI_HF_Travel where Parent_ID = $parentID";
        return $this->db->query($sql)->result_array();
    }

}