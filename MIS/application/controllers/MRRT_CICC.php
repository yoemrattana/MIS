<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MRRT_CICC extends MY_Controller
{
    public function index()
	{
		if (!isset($_SESSION['permiss']['MRRT2'])) redirect('Home');

		$data['title'] = 'MRRT CICC';
		$data['main'] = 'mrrt_cicc_view';
		$data['type'] = $this->input->get('type');
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

        $isTarget = " and b.IsTarget = 1";
        if ($_SESSION['role'] == 'AU') $isTarget = " ";

        $sql = "WITH T as (
	                select PatientCode, NameK,Age, Sex, Diagnosis, Weight, Month, Year, DateCase, ID as Code_Facility_T, Rec_ID, 'HC' as Type
	                from tblHFActivityCases
	                where concat(Year, '-', Month) >= '2024-05' and Positive = 'P'

	                union all

	                select PatientCode, NameK,Age, Sex, Diagnosis, Weight, Month, Year, DateCase, HCCode as Code_Facility_T, Rec_ID, 'VMW' as Type
	                from tblVMWActivityCases as a
	                join tblCensusVillage as b on a.ID = b.Code_Vill_T
	                where concat(Year, '-', Month) >= '2024-05' and Positive = 'P'
                )

                select a.*, Code_OD_T, Code_Prov_N, c.Rec_ID as CICC_ID,
                d.ToOD, d.Note, d.Prov_Code, NotDo, Completed, ReasonNotDo, c.Classify
                from T as a
                join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
                left join tblMRRT_CICC as c on a.Rec_ID = c.Case_ID and c.Case_Type = a.Type
                left join
                (
                    select a.*, Code_Prov_T as Prov_Code from tblMRRTCaseTransfer as  a
                    join tblOD as b on a.ToOD = b.Code_OD_T
                )
                as d on  a.Rec_ID = d.Case_ID and d.Case_Type = a.Type
                where
                (Code_Prov_N = '$pv' or '$pv' = '')
                and (Code_OD_T = '$od' or '$od' = '')
                and (a.Code_Facility_T = '$hc' or '$hc' = '')
                and year = '$year'
                $whereMonth
                $isTarget

                or d.ToOD = '$od'
                order by Month desc";

        $rs = $this->db->query( $sql )->result();
        $this->output->set_output(json_encode($rs));
    }

    public function getDetail()
    {
        $recID = $this->input->post('Rec_ID');
        $type = $this->input->post('Type');

        $sql = "select * from tblMRRT_CICC where Case_ID = $recID and Case_Type = '$type'";
        $rs = $this->db->query($sql)->row_array();

        $parentID = $rs ? $rs['Rec_ID'] : 0;

        $travel = $this->getTravel($parentID);
        $stakeHolder = $this->getStakeHolder($parentID);

        $rs['Travel'] = $travel;
        $rs['Stakeholders'] = $stakeHolder;

        $this->output->set_output(json_encode($rs));
    }

    private function getTravel($parentID)
    {
        if ($parentID == 0) return [];
        $sql = "select * from tblMRRT_CICC_Travel where Parent_ID = $parentID";
        return $this->db->query($sql)->result_array();
    }

    private function getStakeHolder($parentID)
    {
        if ($parentID == 0) return [];
        $sql = "select * from tblMRRT_CICC_StakeHolder where Parent_ID = $parentID";
        return $this->db->query($sql)->result_array();
    }

    public function saveNote()
    {
        $case = $this->input->post('submit');
        $recId = $case['Rec_ID'];
        unset($case['Rec_ID']);

        if ($recId == 0) {
            $case['InitTime'] = sqlNow();
            $case['InitUser'] = $_SESSION['username'];
            $this->db->insert('tblMRRT_CICC', $case);
            $recId = $this->db->insert_id();
        } else {
            $case['ModiTime'] = sqlNow();
            $case['ModiUser'] = $_SESSION['username'];
            $this->db->update('tblMRRT_CICC', $case, ['Rec_ID' => $recId]);
        }

        $this->output->set_output(json_encode($recId));
    }

    public function save()
    {
        $question = $this->input->post('Question');
        $travel = json_decode($this->input->post('Travel'), true);
        $stakeHolders = json_decode($this->input->post('StakeHolders'), true);

        $parentId = $question['Rec_ID'];
        unset($question['Rec_ID']);

        $this->load->model('Classify_model');
        $this->Classify_model->update($question);

        if ($parentId == 0) {

            $question['InitTime'] = sqlNow();
            $question['InitUser'] = $_SESSION['username'];

            $this->db->insert('tblMRRT_CICC', $question);
            $parentId = $this->db->insert_id();

            if( !empty($travel) ) {
                foreach($travel as $r) {
                    $r['Parent_ID'] = $parentId;
                    $this->db->insert('tblMRRT_CICC_Travel', $r);
                }
            }

            if( !empty($stakeHolders) ) {
                foreach($stakeHolders as $r) {
                    $r['Parent_ID'] = $parentId;
                    $this->db->insert('tblMRRT_CICC_StakeHolder', $r);
                }
            }
        } else {
            $question['ModiTime'] = sqlNow();
            $question['ModiUser'] = $_SESSION['username'];
            $this->db->update('tblMRRT_CICC', $question, ['Rec_ID' => $parentId]);

            $this->db->delete('tblMRRT_CICC_Travel', ['Parent_ID'=> $parentId]);
            $this->db->delete('tblMRRT_CICC_StakeHolder', ['Parent_ID'=> $parentId]);

            if( !empty($travel) ) {
                foreach($travel as $r) {
                    unset($r['Rec_ID']);
                    $r['Parent_ID'] = $parentId;
                    $this->db->insert('tblMRRT_CICC_Travel', $r);
                }
            }

            if( !empty($stakeHolders) ) {
                foreach($stakeHolders as $r) {
                    unset($r['Rec_ID']);
                    $r['Parent_ID'] = $parentId;
                    $this->db->insert('tblMRRT_CICC_StakeHolder', $r);
                }
            }
        }

        $this->output->set_output(json_encode($parentId));
    }

    public function delete() {
        $submit = $this->input->post('submit');

        $this->load->model('Classify_model');
        $this->Classify_model->updateDel($submit);

        $this->db->delete('tblMRRT_CICC' , ['Rec_ID' => $submit['Rec_ID']]);
    }
}