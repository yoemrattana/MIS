<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RACDT extends MY_Controller
{
    public function index()
	{
		if (!isset($_SESSION['permiss']['MRRT2'])) redirect('Home');

		$data['title'] = 'RACDT';
		$data['main'] = 'racdt_view';
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
	                select PatientCode, NameK,Age, Sex, Diagnosis, Weight, Month, Year, DateCase, ID as Code_Facility_T, Rec_ID, 'HC' as Type, Classify
	                from tblHFActivityCases as a
                    join (
                        select Case_ID, Case_Type, Classify from tblMRRT_CICC where Classify in ( 'LocallyAcquired', 'DomesticallyImported') and Case_Type = 'HC'
                    ) as b on a.Rec_ID = b.Case_ID
	                where year = '$year' and Positive = 'P' $whereMonth

	                union all

	                select PatientCode, NameK,Age, Sex, Diagnosis, Weight, Month, Year, DateCase, HCCode as Code_Facility_T, Rec_ID, 'VMW' as Type, Classify
	                from tblVMWActivityCases as a
	                join tblCensusVillage as b on a.ID = b.Code_Vill_T
                    join (
                        select Case_ID, Case_Type, Classify from tblMRRT_CICC where Classify in ( 'LocallyAcquired', 'DomesticallyImported') and Case_Type = 'VMW'
                    ) as c on a.Rec_ID = c.Case_ID
	                where year = '$year' and Positive = 'P' $whereMonth
                )

                select a.*, Code_OD_T, Code_Prov_N, c.Rec_ID as CI_ID , Classify, NotDo, Completed, ReasonNotDo,
                d.ToOD, d.Note, d.Prov_Code, InfectionSourceAddress
                from T as a
                join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
                left join tblRACDT as c on a.Rec_ID = c.Case_ID and c.Case_Type = a.Type
                left join
                (
                    select a.*, Code_Prov_T as Prov_Code from tblMRRTCaseTransfer as  a
                    join tblOD as b on a.ToOD = b.Code_OD_T
                ) as d
                on  a.Rec_ID = d.Case_ID and d.Case_Type = a.Type
                where b.IsTarget =1 and (Code_Prov_N = '$pv' or '$pv' = '')
                and (Code_OD_T = '$od' or '$od' = '')
                and (a.Code_Facility_T = '$hc' or '$hc' = '')
                or d.ToOD = '$od'
                order by Month desc";

        $rs = $this->db->query( $sql )->result();
        $this->output->set_output(json_encode($rs));
    }

    public function saveNote()
    {
        $case = $this->input->post('submit');
        $recId = $case['Rec_ID'];
        unset($case['Rec_ID']);

        if ($recId == 0) {
            $case['InitTime'] = sqlNow();
            $case['InitUser'] = $_SESSION['username'];
            $this->db->insert('tblRACDT', $case);
            $recId = $this->db->insert_id();
        } else {
            $case['ModiTime'] = sqlNow();
            $case['ModiUser'] = $_SESSION['username'];
            $this->db->update('tblRACDT', $case, ['Rec_ID' => $recId]);
        }

        $this->output->set_output(json_encode($recId));
    }

    public function getDetail()
    {
        $recID = $this->input->post('Rec_ID');
        $type = $this->input->post('Type');

        $sql = "select * from tblRACDT where Case_ID = $recID and Case_Type = '$type'";
        $rs = $this->db->query($sql)->row_array();

        $parentID = $rs ? $rs['Rec_ID'] : 0;

        $houses = $this->getHouses($parentID);

        $rs['Houses'] = $houses;

        $this->output->set_output(json_encode($rs));
    }

    private function getHouses($parentID)
    {
        if ($parentID == 0) return [];
        $sql = "select * from tblRACDT_StakeHolder where Parent_ID = $parentID";
        return $this->db->query($sql)->result_array();
    }

    public function save()
    {
        $question = $this->input->post('Question');
        $travel = json_decode($this->input->post('Houses'), true);

        $parentId = $question['Rec_ID'];
        unset($question['Rec_ID']);

        if ($parentId == 0) {
            $parentId = $this->insert($question, $travel);
        } else {
            $this->update($question, $travel, $parentId);
        }

        $this->output->set_output(json_encode($parentId));
    }

    private function insert($parent, $children)
    {
        $parent['InitTime'] = sqlNow();
        $parent['InitUser'] = $_SESSION['username'];
        $this->db->insert('tblRACDT', $parent);
        $parentId = $this->db->insert_id();

        if( !empty($children) ) {
            foreach($children as $r) {
                $r['Parent_ID'] = $parentId;
                $this->db->insert('tblRACDT_StakeHolder', $r);
            }
        }

        return $parentId;
    }

    private function update($parent, $children, $parentId)
    {
        $parent['ModiTime'] = sqlNow();
        $parent['ModiUser'] = $_SESSION['username'];
        $this->db->update('tblRACDT', $parent, ['Rec_ID' => $parentId]);
        $this->db->delete('tblRACDT_StakeHolder', ['Parent_ID'=> $parentId]);

        if( !empty($children) ) {
            foreach($children as $r) {
                unset($r['Rec_ID']);
                $r['Parent_ID'] = $parentId;
                $this->db->insert('tblRACDT_StakeHolder', $r);
            }
        }
    }
}