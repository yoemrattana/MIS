<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CaseConfirm extends MY_Controller
{
	public function index()
	{
        if (!isset($_SESSION['permiss']['Case Monitoring'])) redirect('Home');

		$data['title'] = 'Case Confirmation';
		$data['main'] = 'case_confirm_view';
		$this->load->view('layout', $data);
	}

    public function getData()
    {
        $sql = "select d.Code_Prov_T, c.Code_OD_T, c.Code_Facility_T, b.Code_Vill_T, a.Year, a.Month, a.Rec_ID, CaseType, NameK, Age, Sex, Specie, IsConfirm, Description
                from tblPreConfirmCase as a
                join tblCensusVillage as b on a.Place = b.Code_Vill_T
                join tblHFCodes as c on b.HCCode = c.Code_Facility_T
                join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T

                union all

                select Code_Prov_T, Code_OD_T, Code_Facility_T, '' as Code_Vill_T ,a.Year, a.Month, a.Rec_ID, CaseType, NameK, Age, Sex, Specie, IsConfirm, Description
                from tblPreConfirmCase as a
                join tblHFCodes as b on a.Place = b.Code_Facility_T
                join tblProvince as c on c.Code_Prov_T =b.Code_Prov_N";

        $rs = $this->db->query( $sql )->result();

        $this->output->set_output(json_encode($rs));
    }

    public function confirm()
    {
        $recId = $this->input->post('rec_id');
        $caseType = $this->input->post('case_type');
        $description = $this->input->post('description');

        if ($caseType == 'HC') $this->confirmCaseHF($description);
        else $this->confirmCaseVMW($description);

        $this->db->update('tblPreConfirmCase', ['IsConfirm'=>1], ['Rec_ID'=> $recId]);
    }

    public function reject()
    {
        $recId = $this->input->post('rec_id');
        $this->db->update('tblPreConfirmCase', ['IsConfirm'=>2], ['Rec_ID'=> $recId]);
    }

    private function confirmCaseHF($description)
    {
        $data = json_decode($description, true);

        $this->db->insert('tblHFActivityCases', $data);
    }

    private function confirmCaseVMW($description)
    {
        $data = json_decode($description, true);

        $this->db->insert('tblVMWActivityCases', $data);
    }
}