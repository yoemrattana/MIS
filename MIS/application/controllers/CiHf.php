<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CiHf extends MY_Controller
{
    public function index()
	{
		if (!isset($_SESSION['permiss']['MRRT2'])) redirect('Home');

		$data['title'] = 'Case Investigation By HF';
		$data['main'] = 'cihf_view';
		$this->load->view('layout', $data);
	}

    public function getData()
    {
        $pv = $this->input->post('pv');
        $od = $this->input->post('od');
        $hc = $this->input->post('hc');
        $year = $this->input->post('year');
        $month = $this->input->post('month');

        $whereMonth = '';
        if( !empty($month) ) $whereMonth = ' and Month='. $month;

        $sql = "WITH T as (
	                select PatientCode, NameK,Age, Sex, Diagnosis, Weight, Month, Year, DateCase, ID as Code_Facility_T, Rec_ID, 'HC' as Type, '' as Class
	                from tblHFActivityCases
	                where year = '$year' and Positive = 'P' $whereMonth

                    union all
                    select PatientCode, NameK,Age, Sex, Diagnosis, Weight, Month, Year, DateCase, HCCode as Code_Facility_T, Rec_ID, 'VMW' as Type,
                    case when Recrudescence = 1 or Relapse = 1 then 'Recrudescense/Relapse'
	                    when LocallyAcquired = 1 then 'Locally Acquired'
	                    when DomesticallyImported = 1 then 'Domestically Imported'
	                    when InternationalImported = 1 then 'International Imported'
	                    end  Class
	                    from tblVMWActivityCases as a
	                    join tblCensusVillage as b on a.ID = b.Code_Vill_T
                    where year = '$year' and Positive = 'P' $whereMonth
                )

                select a.*, Code_OD_T, Code_Prov_N, c.Rec_ID as CI_ID, iif(a.Type = 'HC', c.Classify, a.Class) as Classify, d.ToOD, d.Note, d.Prov_Code
                from T as a
                join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
                left join tblCI_HF as c on a.Rec_ID = c.Case_ID and c.Case_Type = a.Type
                left join
                (
                    select a.*, Code_Prov_T as Prov_Code from tblMRRTCaseTransfer as  a
                    join tblOD as b on a.ToOD = b.Code_OD_T
                )
                as d on  a.Rec_ID = d.Case_ID and d.Case_Type = a.Type
                where (Code_Prov_N = '$pv' or '$pv' = '')
                and (Code_OD_T = '$od' or '$od' = '')
                and (a.Code_Facility_T = '$hc' or '$hc' = '')
                and IsTarget = 1
                or d.ToOD = '$od'
                order by Month desc";

        $rs = $this->db->query( $sql )->result();
        $this->output->set_output(json_encode($rs));
    }

    public function getDetail()
    {
        $recID = $this->input->post('Rec_ID');
        $type = $this->input->post('Type');

        $sql = "select * from tblCI_HF where Case_ID = $recID and Case_Type = '$type'";
        $rs = $this->db->query($sql)->row_array();

        $parentID = $rs ? $rs['Rec_ID'] : 0;

        $travel = $this->getTravel($parentID);

        $rs['Travel'] = $travel;

        $this->output->set_output(json_encode($rs));
    }

    private function getTravel($parentID)
    {
        if ($parentID == 0) return [];
        $sql = "select * from tblCI_HF_Travel where Parent_ID = $parentID";
        return $this->db->query($sql)->result_array();
    }

    public function save()
    {
        $question = $this->input->post('Question');
        $travel = json_decode($this->input->post('Travel'), true);

        $parentId = $question['Rec_ID'];
        unset($question['Rec_ID']);

        //$this->load->model('Classify_model');
        //$this->Classify_model->update($question);

        if ($parentId == 0) {
           $parentId = $this->insert($question, $travel);
        } else {
            $this->update($question, $travel, $parentId);
        }

        $this->output->set_output(json_encode($parentId));
    }

    private function insert($parent, $children)
    {
        $this->db->insert('tblCI_HF', $parent);
        $parentId = $this->db->insert_id();

        if( !empty($children) ) {
            foreach($children as $r) {
                $r['Parent_ID'] = $parentId;
                $this->db->insert('tblCI_HF_Travel', $r);
            }
        }

        return $parentId;
    }

    private function update($parent, $children, $parentId)
    {
        $this->db->update('tblCI_HF', $parent, ['Rec_ID' => $parentId]);
        $this->db->delete('tblCI_HF_Travel', ['Parent_ID'=> $parentId]);

        if( !empty($children) ) {
            foreach($children as $r) {
                unset($r['Rec_ID']);
                $r['Parent_ID'] = $parentId;
                $this->db->insert('tblCI_HF_Travel', $r);
            }
        }
    }

    public function delete() {
        $submit = $this->input->post('submit');

        $this->load->model('Classify_model');
        $this->Classify_model->updateDel($submit);

        $this->db->delete('tblCI_HF' , ['Rec_ID' => $submit['Rec_ID']]);
    }
}