<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImpCase extends MY_Controller
{
    public function index()
	{
		if (!isset($_SESSION['permiss']['Imported Cases'])) redirect('Home');

		$data['title'] = 'IMP Cases';
		$data['main'] = 'impcase_view';
		$data['tab'] = $this->input->get('tab');
		$this->load->view('layout', $data);
	}

    public function getData()
    {
        $rs['patient'] = $this->db->get('tblImpCases')->result();

        $sql = "select a.*, Name_Vill_E, Name_Comm_E, Name_Dist_E, Name_Prov_E 
                from tblImpCases as a
                left join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
                join tblCommune as c on b.Code_Comm_T = c.Code_Comm_T
                join tblDistrict as d on b.Code_Dist_T = d.Code_Dist_T
                join tblProvince as e on b.Code_Prov_T = e.Code_Prov_T";

        $rs['mapData'] = $this->db->query($sql)->result();

        $this->output->set_output(json_encode($rs));
    }

    public function save()
    {
        $submit = $this->input->post('submit');
        $recID = $submit['Rec_ID'];
        unset($submit['Rec_ID']);

        $submit['Note'] = isset($submit['Note']) ? $submit['Note'] : null;
        $id = 0;
        if(empty($recID)) {
            $submit['InitTime'] = sqlNow();
            $submit['InitUser'] = $_SESSION['username'];
            $this->db->insert('tblImpCases', $submit);
            $id = $this->db->insert_id();
        }else{
            $submit['ModiTime'] = sqlNow();
            $submit['ModiUser'] = $_SESSION['username'];
            $this->db->update('tblImpCases', $submit, ['Rec_ID' => $recID]);
        }

        $this->output->set_output(json_encode($id));
    }
}