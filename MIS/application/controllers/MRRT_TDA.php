<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MRRT_TDA extends MY_Controller
{
    public function index()
	{
		if (!isset($_SESSION['permiss']['MRRT2'])) redirect('Home');

		$data['title'] = 'MRRT TDA';
		$data['main'] = 'mrrt_tda_view';
		$this->load->view('layout', $data);
	}

    public function getData()
    {
		$pv = $_SESSION['prov'];

        $sql = "select Code_Prov_T, c.Code_OD_T, c.Code_Facility_T, a.*
                from tblMRRT_TDA as a
                join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
                join tblHFCodes as c on b.HCCode = c.Code_Facility_T
                where '$pv' = '' or CHARINDEX(code_prov_n,'$pv') > 0";

        $rs = $this->db->query( $sql )->result();
        $this->output->set_output(json_encode($rs));
    }

    public function getDetail()
    {
        $recID = $this->input->post('Rec_ID');

        $sql = "select * from tblMRRT_TDA where Rec_ID = $recID";
        $rs = $this->db->query($sql)->row_array();

        $parentID = $rs ? $rs['Rec_ID'] : 0;

        $cases = $this->getMembers($parentID);
        $rs['Members'] = $cases;

        $this->output->set_output(json_encode($rs));
    }

    private function getMembers($parentID)
    {
        if ($parentID == 0) return [];
        $sql = "select * from tblMRRT_TDA_Member where Parent_ID = $parentID";
        return $this->db->query($sql)->result_array();
    }

    public function save()
    {
        $question = $this->input->post('Question');
        $members = json_decode($this->input->post('Members'), true);

        $parentId = $question['Rec_ID'];
        unset($question['Rec_ID']);

        if ($parentId == 0) {
            $parentId = $this->insert($question, $members);
        } else {
            $this->update($question, $members, $parentId);
        }

        $sql = "select Code_Prov_T, c.Code_OD_T, c.Code_Facility_T, a.*
                from tblMRRT_TDA as a
                join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
                join tblHFCodes as c on b.HCCode = c.Code_Facility_T
                where Rec_ID = $parentId";

        $rs = $this->db->query( $sql )->row();

        $this->output->set_output(json_encode($rs));
    }

    private function insert($parent, $members)
    {
        $parent['InitTime'] = sqlNow();
        $parent['InitUser'] = $_SESSION['username'];
        $this->db->insert('tblMRRT_TDA', $parent);
        $parentId = $this->db->insert_id();

        if( !empty($members) ) {
            foreach($members as $r) {
                unset($r['Rec_ID']);
                $r['Parent_ID'] = $parentId;
                $this->db->insert('tblMRRT_TDA_Member', $r);
            }
        }

        return $parentId;
    }

    private function update($parent, $members, $parentId)
    {
        $parent['ModiTime'] = sqlNow();
        $parent['ModiUser'] = $_SESSION['username'];
        $this->db->update('tblMRRT_TDA', $parent, ['Rec_ID' => $parentId]);

        if( !empty($members) ) {
            foreach($members as $r) {
                $recID = $r['Rec_ID'];
                unset($r['Rec_ID']);
                $r['Parent_ID'] = $parentId;

                if ($recID > 0) {
                    $this->db->update('tblMRRT_TDA_Member', $r, ['Rec_ID' => $recID]);
                } elseif ($recID < 0) {
                    $this->db->delete('tblMRRT_TDA_Member', ['Rec_ID' => $recID * -1]);
                } else {
                    $this->db->insert('tblMRRT_TDA_Member', $r);
                }
            }
        }
    }
}