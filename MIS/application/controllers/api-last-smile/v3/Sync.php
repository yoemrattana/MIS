<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Sync extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

    public function data_get()
	{
		$code_vill_t = $this->get('code_vill_t');
		$year = $this->get('year');

        $houses = $this->getHouses($code_vill_t);
        $members = $this->getMembers($code_vill_t);
        $nets = $this->getNet($code_vill_t);
        $tdas = $this->getTDA($code_vill_t);
        $ipts = $this->getIPT($code_vill_t, $year);
        $afs = $this->getAFS($code_vill_t, $year);

		$data = [];
		foreach( $houses as $house ) {
            $found = array_filter($members,function($v,$k) use ($house){
                return $v['HouseHoldID'] == $house['Rec_ID'];
            },ARRAY_FILTER_USE_BOTH);

            $house['Members'] = array_values($found);

            $found= array_filter($nets,function($v,$k) use ($house){
                return $v['HouseHoldID'] == $house['Rec_ID'];
            },ARRAY_FILTER_USE_BOTH);

            $house['Net'] = array_values($found);

            $found= array_filter($tdas,function($v,$k) use ($house){
                return $v['HouseHoldID'] == $house['Rec_ID'] && $v['Type'] == 1;
            },ARRAY_FILTER_USE_BOTH);

            $house['TDA1'] = array_values($found);

            $found= array_filter($tdas,function($v,$k) use ($house){
                return $v['HouseHoldID'] == $house['Rec_ID'] && $v['Type'] == 2;
            },ARRAY_FILTER_USE_BOTH);

            $house['TDA2'] = array_values($found);

            $found= array_filter($ipts,function($v,$k) use ($house){
                return $v['HouseHoldID'] == $house['Rec_ID'];
            },ARRAY_FILTER_USE_BOTH);

            $house['IPT'] = array_values($found);

            $found= array_filter($afs,function($v,$k) use ($house){
                return $v['HouseHoldID'] == $house['Rec_ID'];
            },ARRAY_FILTER_USE_BOTH);

            $house['AFS'] = array_values($found);

            array_push($data, $house);
        }

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
    }

    private function getHouses($code_vill_t)
    {
        $this->db->select('*');
		$this->db->from('tblLastmileHouseHold');
		$this->db->where(['Code_Vill_T' => $code_vill_t]);
		$this->db->order_by('HouseNumber');
		$query = $this->db->get();
		return $query->result_array();
    }

    private function getMembers($code_vill_t)
    {
        $sql = "select a.* from tblLastmileHouseMember as a
                join tblLastmileHouseHold as b on a.HouseHoldID = b.Rec_ID
                where Code_Vill_T = '$code_vill_t' order by a.HouseHoldID, a.Rec_ID";

        return $this->db->query($sql)->result_array();
    }

    private function getNet($code_vill_t)
    {
        $sql = "select a.* from tblLastmileTDANet as a
                join tblLastmileHouseHold as b on a.HouseHoldID = b.Rec_ID
                where Code_Vill_T = '$code_vill_t'";

        return $this->db->query($sql)->result_array();
    }

    private function getTDA($code_vill_t)
    {
        $sql = "select a.* from tblLastmileTDA as a
                join tblLastmileHouseHold as b on a.HouseHoldID = b.Rec_ID
                where Code_Vill_T = '$code_vill_t'";

        return $this->db->query($sql)->result_array();
    }

    private function getIPT($code_vill_t, $year)
    {
        $sql = "select a.* from tblLastmileIPT as a
                join tblLastmileHouseHold as b on a.HouseHoldID = b.Rec_ID
                where Code_Vill_T = '$code_vill_t' and a.Year = $year";

        return $this->db->query($sql)->result_array();
    }

    private function getAFS($code_vill_t, $year)
    {
        $sql = "select a.* from tblLastmileAFS as a
                join tblLastmileHouseHold as b on a.HouseHoldID = b.Rec_ID
                where Code_Vill_T = '$code_vill_t' and a.Year = $year";

        return $this->db->query($sql)->result_array();
    }
}