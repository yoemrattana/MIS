<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Pv extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

    public function getList_get()
    {
		$hccode = $this->get('Code_Facility_T');

        $sql = "select c.Name_Prov_K, Name_OD_K, Name_Facility_K, c.Code_Prov_T, b.Code_OD_T, a.* from tblChecklistPv as a
                join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
                join tblProvince as c on b.Code_Prov_N =  c.Code_Prov_T
                where a.Code_Facility_T = '$hccode'";

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
        $submit = $this->post('checklist');

        $details = $submit['Detail'];

        $parentId = $submit['Rec_ID'];
        unset( $submit['Detail'], $submit['Code_OD_T'], $submit['Code_Prov_T'], $submit['Rec_ID'] );

        if( isset($submit['Name_Facility_K']) ) unset($submit['Name_Facility_K']);
        if( isset($submit['Name_OD_K']) ) unset($submit['Name_OD_K']);
        if( isset($submit['Name_Prov_K']) ) unset($submit['Name_Prov_K']);

        if ( empty($parentId) ) {
            $submit['InitTime'] = sqlNow();
            $submit['InitUser'] = 'app';

            $this->db->insert('tblChecklistPv', $submit);
            $parentId = $this->db->insert_id();
        } else {
            $submit['ModiTime'] = sqlNow();
            $submit['ModiUser'] = 'app';

            $this->db->update('tblChecklistPv', $submit, ['Rec_ID' => $parentId]);
        }

        $this->db->delete('tblCheckListPvValue', ['ParentID' => $parentId]);

        foreach( $details as $detail ) {
            unset( $detail['Sort'], $detail['Subscore'], $detail['Section'], $detail['ShortName'],
            $detail['AttributeName'], $detail['Visible'], $detail['Value_ID'] );

            $detail['ParentID'] = $parentId;

            unset($detail['DataType']);

            $this->db->insert( 'tblCheckListPvValue', $detail );
        }

        $response = [
           "code" => 200,
           "message" => "success",
           "data" => []
       ];

        $this->response($response);
    }

	public function getDetail_get()
    {
        $id = $this->get('Rec_ID');

		$data = [];
        if ( empty( $id) ){
            $data = $this->getField();
            $data['Items']  = $this->db->get_where( 'tblChecklistPvAttribute' , ['Visible' => true] )->result_array();
        } else {
            $sql = "select c.Name_Prov_K, Name_OD_K, Name_Facility_K, c.Code_Prov_T, b.Code_OD_T, a.* from tblChecklistPv as a
                join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
                join tblProvince as c on b.Code_Prov_N =  c.Code_Prov_T
                where Rec_ID = {$id}";

            $data = $this->db->query( $sql )->row_array();

            $sql = "select * from tblChecklistPvAttribute as a
                    join tblCheckListPvValue as b on a.AttributeID = b.AttributeID
                    where Visible = 1 and b.ParentID = {$id}";

            $data['Detail']  = $this->db->query( $sql )->result_array();
        }

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
    }

    private function getField()
    {
        $rs = $this->db->list_fields('tblChecklistPv');
        $fields = [];
        foreach ($rs as $v) {
            $fields[$v] ='';
        }

        return $fields;
    }

}