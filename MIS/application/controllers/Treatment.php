<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Treatment extends MY_Controller
{
	public function index()
	{
        if ( $_SESSION['role'] != 'AU' ) redirect('Home');

		$data['title'] = "Treatment";
		$data['main'] = 'treatment_view';
		$this->load->view('layout', $data);
	}

	public function get()
	{
		$sql = "select Rec_ID, Treatment, Description, HF, VMW from tblTreatment order by Treatment";
		$rs = $this->db->query($sql)->result();
        $data['treatment'] = $rs;

        $sql = "select a.Rec_ID, Specie, Treatment, Description, TreatmentID from tblTreatmentSpecies as a
                join tblTreatment as b on b.Rec_ID = TreatmentID
                order by Treatment";
        $rs = $this->db->query($sql)->result();
        $data['treatmentSpecie'] = $rs;

		$this->output->set_output(json_encode($data));
	}

    public function saveTreatmentSpecie()
    {
        $specie = $this->input->post('specie');;
        $treatmentIDs = $this->input->post('treatmentIDs');

        if($treatmentIDs == null) $treatmentIDs = [];

        $this->db->delete('tblTreatmentSpecies', ['Specie' => $specie]);

        foreach($treatmentIDs as $id){
            $value['Specie'] = $specie;
            $value['TreatmentID'] = $id;
            $this->db->insert('tblTreatmentSpecies', $value);
        }

        $sql = "select a.Rec_ID, Specie, Treatment, Description, TreatmentID from tblTreatmentSpecies as a
                join tblTreatment as b on b.Rec_ID = TreatmentID
                order by Treatment";
        $rs = $this->db->query($sql)->result();

        $this->output->set_output(json_encode($rs));
    }

}