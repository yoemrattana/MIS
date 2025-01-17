<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Medication extends REST_Controller
{
	public function all_get()
	{
		$sql = "SELECT Rec_ID as Id, Description as Name, VMW as Is_VMW_Usable, HF as Is_HC_Usable
				FROM tblTreatment
				WHERE VMW = 1 OR HF = 1
				ORDER BY Treatment";
		$rs = $this->db->query($sql)->result();

		return $this->response($rs);
	}

    public function get_by_specie_post()
    {
        $specie = $this->post('specie');

        $sql = "select Specie, Treatment, Description, VMW, PPM, HF from tblTreatmentSpecies as a
                join tblTreatment as b on b.Rec_ID = TreatmentID
                where specie = '$specie' order by Treatment";
        $rs = $this->db->query($sql)->result();

        return $this->response($rs);
    }
}