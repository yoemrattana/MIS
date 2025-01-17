<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MRRT_Foci extends MY_Controller
{
    public function index()
	{
		if (!isset($_SESSION['permiss']['MRRT2'])) redirect('Home');

		$data['title'] = 'MRRT Foci';
		$data['main'] = 'mrrt_foci_view';
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
	                select a.PatientCode, NameK,a.Age, a.Sex, a.Diagnosis, a.Weight, Month, Year, a.DateCase, ID as Code_Facility_T, Code_Vill_t, a.Rec_ID, 'HC' as Type,  Classify
                    from tblHFActivityCases as a
                    join tblMRRT_CICC as b on a.Rec_ID = b.Case_ID and Case_Type = 'HC'
                    where year = '$year' and Positive = 'P' and b.Classify in ('DomesticallyImported', 'LocallyAcquired') $whereMonth

                    union all

                    select a.PatientCode, NameK,a.Age, a.Sex, a.Diagnosis, a.Weight, Month, Year, a.DateCase, HCCode as Code_Facility_T, ISNULL(nullif(a.Address,''), ID) as Address, a.Rec_ID, 'VMW' as Type,  Classify
                    from tblVMWActivityCases as a
                    join tblCensusVillage as b on a.ID = b.Code_Vill_T
                    join tblMRRT_CICC as c on a.Rec_ID = c.Case_ID and Case_Type = 'VMW'
                    where year = '$year' and Positive = 'P' and c.Classify in ('DomesticallyImported', 'LocallyAcquired') $whereMonth
                )

                select a.*, Code_OD_T, Code_Prov_N, c.Rec_ID as CI_ID, iif(c.Rec_ID is null or NotDo = 1, 0, 1) as Done
                ,NotDo, Completed, ReasonNotDo, d.Rec_ID as NoteID, d.ToOD, d.Note, d.Prov_Code, Classify, InfectionSourceAddress
                from T as a
                join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
                left join tblMRRT_Foci as c on a.Rec_ID = c.Case_ID and c.Case_Type = a.Type
                left join
                (
                    select a.*, Code_Prov_T as Prov_Code from tblMRRTCaseTransfer as  a
                    join tblOD as b on a.ToOD = b.Code_OD_T
                )
                as d on  a.Rec_ID = d.Case_ID and d.Case_Type = a.Type
                where IsTarget = 1 and
                (Code_Prov_N = '$pv' or '$pv' = '')
                and (Code_OD_T = '$od' or '$od' = '')
                and (a.Code_Facility_T = '$hc' or '$hc' = '')
                or d.ToOD = '$od'
                order by Code_Vill_t";

        $rs = $this->db->query( $sql )->result();
        $this->output->set_output(json_encode($rs));
    }

    public function getDetail()
    {
        $recID = $this->input->post('Rec_ID');
        $type = $this->input->post('Type');

        $sql = "select * from tblMRRT_Foci where Case_ID = $recID and Case_Type = '$type'";
        $rs = $this->db->query($sql)->row_array();

        $parentID = $rs ? $rs['Rec_ID'] : 0;

        $cases = $this->getCases($parentID);
        $rs['Cases'] = $cases;

        $llins = $this->getLLINs($parentID);
        $rs['LLINs'] = $llins;

        $this->output->set_output(json_encode($rs));
    }

    private function getCases($parentID)
    {
        if ($parentID == 0) return [];
        $sql = "select * from tblMRRT_Foci_Case where Parent_ID = $parentID";
        return $this->db->query($sql)->result_array();
    }

    private function getLLINs($parentID)
    {
        if ($parentID == 0) return [];
        $sql = "select * from tblMRRT_Foci_LLIN where Parent_ID = $parentID";
        return $this->db->query($sql)->result_array();
    }

    public function transfer()
    {
        $case = $this->input->post('submit');
        $case['InitTime'] = sqlNow();
        $case['InitUser'] = $_SESSION['username'];

        $this->db->delete('tblMRRTCaseTransfer', ['Case_ID' => $case['Case_ID'], 'Case_Type' => $case['Case_Type']]);

        $this->db->insert('tblMRRTCaseTransfer', $case);
    }

    public function saveNote()
    {
        $case = $this->input->post('submit');
        $recId = $case['Rec_ID'];
        unset($case['Rec_ID']);

        if ($recId == 0) {
            $case['InitTime'] = sqlNow();
            $case['InitUser'] = $_SESSION['username'];
            $this->db->insert('tblMRRT_Foci', $case);
            $recId = $this->db->insert_id();
        } else {
            $case['ModiTime'] = sqlNow();
            $case['ModiUser'] = $_SESSION['username'];
            $this->db->update('tblMRRT_Foci', $case, ['Rec_ID' => $recId]);
        }

        $this->output->set_output(json_encode($recId));
    }

    public function save()
    {
        $question = $this->input->post('Question');
        $cases = json_decode($this->input->post('Cases'), true);
        $LLINs = json_decode($this->input->post('LLINs'), true);

        if (isset($question['Photo']) && $question['Photo'] != null && !strContain($question['Photo'], '.jpg')) {
			$dir = FCPATH.'/media/MRRT_Foci';
			if (!file_exists($dir)) mkdir($dir);
			$filename = GUID().'.jpg';
            if (explode(',', $question['Photo'])[1]) {
                file_put_contents($dir.'/'.$filename, base64_decode(explode(',', $question['Photo'])[1]));
                $question['Photo'] = $filename;
            }

		}

        $parentId = $question['Rec_ID'];
        unset($question['Rec_ID']);

        if ($parentId == 0) {
            $parentId = $this->insert($question, $cases, $LLINs);
        } else {
            $this->update($question, $cases,$LLINs, $parentId);
        }

        $this->output->set_output(json_encode($parentId));
    }

    private function insert($parent, $cases, $LLINs)
    {
        $parent['InitTime'] = sqlNow();
        $parent['InitUser'] = $_SESSION['username'];
        $this->db->insert('tblMRRT_Foci', $parent);
        $parentId = $this->db->insert_id();

        if( !empty($cases) ) {
            foreach($cases as $r) {
                $r['Parent_ID'] = $parentId;
                $this->db->insert('tblMRRT_Foci_Case', $r);
            }
        }

        if( !empty($LLINs) ) {
            foreach($LLINs as $r) {
                $r['Parent_ID'] = $parentId;
                $this->db->insert('tblMRRT_Foci_LLIN', $r);
            }
        }

        return $parentId;
    }

    private function update($parent, $cases, $llins, $parentId)
    {
        $parent['ModiTime'] = sqlNow();
        $parent['ModiUser'] = $_SESSION['username'];
        $this->db->update('tblMRRT_Foci', $parent, ['Rec_ID' => $parentId]);
        $this->db->delete('tblMRRT_Foci_Case', ['Parent_ID'=> $parentId]);
        $this->db->delete('tblMRRT_Foci_LLIN', ['Parent_ID'=> $parentId]);

        if( !empty($cases) ) {
            foreach($cases as $r) {
                unset($r['Rec_ID']);
                $r['Parent_ID'] = $parentId;
                $this->db->insert('tblMRRT_Foci_Case', $r);
            }
        }

        if( !empty($llins) ) {
            foreach($llins as $r) {
                unset($r['Rec_ID']);
                $r['Parent_ID'] = $parentId;
                $this->db->insert('tblMRRT_Foci_LLIN', $r);
            }
        }
    }
}