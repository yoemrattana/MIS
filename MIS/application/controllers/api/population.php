<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Population extends REST_Controller
{
    public function pop_village_post()
    {
        $hcCode = $this->post('hc_code');
        $year = $this->post('year');

        $sql = "select a.Code_Vill_T, a.Name_Vill_K, isnull(Distance, 0) as Distance, isnull(Pop, 0) as Pop, isnull(MobilePop, 0) as MobilePop, isnull(HHold, 0) as HHold from
                (
	                SELECT a.Code_Vill_T, a.Name_Vill_K, a.DistanceFromHC as Distance
	                FROM tblCensusVillage as a
	                WHERE HCCode = '$hcCode'
                ) as a
                LEFT JOIN (
	                select Code_Vill_T, Pop, MobilePop, HHold From
	                tblPopByVillages
	                WHERE Year = $year
                ) as b on a.Code_Vill_T = b.Code_Vill_T";

        $rs = $this->db->query($sql)->result();
        $this->response($rs);
    }

    public function update_pop_village_post()
    {
        $data = $this->post('PopVillage');

        if (count($data)  == 0) {
            $this->response(["Error" => "Data cannot be blank!"], 400);
		}

        foreach ($data as $row) {
            $code_vill_t = $row['Code_Vill_T'];
            $year = $row['Year'];
            $distance = $row['Distance'];

            $this->db->update('tblCensusVillage', ['DistanceFromHC' => $distance], ['Code_Vill_T'=>$code_vill_t]);
            $this->db->delete('tblPopByVillages',  ['Code_Vill_T'=> $code_vill_t, 'Year'=> $year]);
            unset($row['Distance']);
            $this->db->insert('tblPopByVillages', $row);
        }

        $this->response('successful');
    }
}