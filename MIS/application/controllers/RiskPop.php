<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RiskPop extends MY_Controller {
    public function index() {
        if ($_SESSION['role'] != 'AU') redirect('Home');

        $data['title'] = 'Population at Risk';
        $data['main'] = 'riskpop_view';
        $this -> load -> view('layout', $data);
    }

    public function getData()
    {
        $sql = "select * from tblRiskPopV2";
        $rs = $this->db->query($sql)->result();

        $this->output->set_output(json_encode($rs));
    }

    public function save()
    {
        $submit = $this->input->post('submit');
        $this->db->delete('tblRiskPopV2', ['Code_Prov_T' => $submit['Code_Prov_T'], 'Year' => $submit['Year']]);
        unset( $submit['Rec_ID'] );
        $this->db->insert('tblRiskPopV2', $submit);
    }

    public function delete(){
        $year = $this->input->post('year');
        $province = $this->input->post('Code_Prov_T');
        $this->db->delete('tblRiskPopV2', ['Code_Prov_T' => $province, 'Year' => $year]);
    }
}