<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class RACDT extends REST_Controller
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
	        from tblHFActivityCases as a
            join (
                select Case_ID, Case_Type, Classify from tblMRRT_CICC where Classify in ( 'LocallyAcquired', 'DomesticallyImported') and Case_Type = 'HC'
            ) as b on a.Rec_ID = b.Case_ID
	        where year = $year and month = $month and Positive = 'P'

	        union all

	        select PatientCode, NameK,Age, Sex, Diagnosis, Weight, Month, Year, DateCase, HCCode as Code_Facility_T, Rec_ID as Case_ID, 'VMW' as Case_Type
	        from tblVMWActivityCases as a
	        join tblCensusVillage as b on a.ID = b.Code_Vill_T
            join (
                select Case_ID, Case_Type, Classify from tblMRRT_CICC where Classify in ( 'LocallyAcquired', 'DomesticallyImported') and Case_Type = 'VMW'
            ) as c on a.Rec_ID = c.Case_ID

	        where year = $year and month = $month and Positive = 'P'
        )

        select a.*, Code_OD_T, Code_Prov_N, isnull(c.Rec_ID,0) as Rec_ID from T as a
        join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
        left join tblRACDT as c on a.Case_ID = c.Case_ID and c.Case_Type = a.Case_Type
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
		$q = $this->post('RACDT');

        $houses = $q['Houses'];
        unset($q['Houses']);

        $parentId = '';
        if( isset( $q['Rec_ID'] ) ) {
            $parentId = $q['Rec_ID'];
            unset($q['Rec_ID']);
        }

        if ( empty( $parentId ) ) {
            $q['InitTime'] = sqlNow();
            $this->insert($q, $houses);
        } else {
            $this->update($q, $houses, $parentId);
        }

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);
	}

    private function insert($parent, $houses)
    {
        $this->db->insert('tblRACDT', $parent);
        $parentId = $this->db->insert_id();

        if( !empty($houses) ) {
            foreach($houses as $r) {
                if (isset($r['Rec_ID'])) unset($r['Rec_ID']);
                if (isset($r['Diagnosis']) && $r['Diagnosis'] == 'Negative') $r['Diagnosis'] = 'N';
                $r['Parent_ID'] = $parentId;
                $this->db->insert('tblRACDT_StakeHolder', $r);
            }
        }

        return $parentId;
    }

    private function update($parent, $travels, $parentId)
    {
        $parent['ModiTime'] = sqlNow();
        $this->db->update('tblRACDT', $parent, ['Rec_ID' => $parentId]);
        $this->db->delete('tblRACDT_StakeHolder', ['Parent_ID'=> $parentId]);

        if( !empty($travels) ) {
            foreach($travels as $r) {
                if (isset($r['Rec_ID'])) unset($r['Rec_ID']);
                if (isset($r['Diagnosis']) && $r['Diagnosis'] == 'Negative') $r['Diagnosis'] = 'N';
                $r['Parent_ID'] = $parentId;
                $this->db->insert('tblRACDT_StakeHolder', $r);
            }
        }
    }

	public function detail_get()
	{
        $recID = $this->get('Rec_ID');

        $sql = "select * from tblRACDT where Rec_ID = $recID";
        $rs = $this->db->query($sql)->row_array();

        $parentID = $rs ? $rs['Rec_ID'] : 0;

        $houses = $this->getHouse($parentID);

        $rs['Houses'] = $houses;

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

    private function getHouse($parentID)
    {
        if ($parentID == 0) return [];
        $sql = "select * from tblRACDT_StakeHolder where Parent_ID = $parentID";
        return $this->db->query($sql)->result_array();
    }

}