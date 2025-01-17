<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MRRT_Traveler extends MY_Controller
{
    public function index()
	{
		if (!isset($_SESSION['permiss']['MRRT2'])) redirect('Home');

		$data['title'] = 'MRRT Traveler';
		$data['main'] = 'mrrt_traveler_view';
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
	                where year = '$year' and Positive = 'P' $whereMonth

	                union all

	                select PatientCode, NameK,Age, Sex, Diagnosis, Weight, Month, Year, DateCase, HCCode as Code_Facility_T, Rec_ID, 'VMW' as Type
	                from tblVMWActivityCases as a
	                join tblCensusVillage as b on a.ID = b.Code_Vill_T
	                where year = '$year' and Positive = 'P' $whereMonth
                )

                select a.*, Code_OD_T, Code_Prov_N, c.Rec_ID as Id,
                d.ToOD
                from T as a
                join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
                left join tblMRRT_Traveler as c on a.Rec_ID = c.Case_ID and c.Case_Type = a.Type
                left join
                (
                    select a.*, Code_Prov_T as Prov_Code from tblMRRTCaseTransfer as  a
                    join tblOD as b on a.ToOD = b.Code_OD_T
                )
                as d on  a.Rec_ID = d.Case_ID and d.Case_Type = a.Type
                where  (Code_Prov_N = '$pv' or '$pv' = '')
                and (Code_OD_T = '$od' or '$od' = '')
                and (a.Code_Facility_T = '$hc' or '$hc' = '')
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

        $sql = "select Code_OD_T, Code_Prov_N, a.* from tblMRRT_Traveler as a
                join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
                where Case_ID = $recID and Case_Type = '$type'";
        $master = $this->db->query($sql)->row_array();

        $parentID = $master ? $master['Rec_ID'] : 0;

        $members = $this->getMembers($parentID);

        $data = [];
        $data['master'] = $master;
        $data['members'] = $members;

        $this->output->set_output(json_encode($data));
    }


    private function getMembers($parentID)
    {
        if ($parentID == 0) return [];
        $sql = "select * from tblMRRT_Traveler_Member where Parent_ID = $parentID";
        return $this->db->query($sql)->result_array();
    }

    public function save()
    {
        $detail = $this->input->post('detail');
        $member = json_decode($this->input->post('members'), true);

        unset($detail['Code_Prov_N'] , $detail['Code_OD_T']);

        $parentId = $detail['Rec_ID'];
        unset($detail['Rec_ID']);

        if ($parentId == 0) {
            $parentId = $this->insert($detail, $member);
        } else {
            $this->update($detail, $member, $parentId);
        }

        $this->output->set_output(json_encode($parentId));
    }

    private function insert($parent, $children)
    {
        $parent['InitTime'] = sqlNow();
        $parent['InitUser'] = $_SESSION['username'];
        $this->db->insert('tblMRRT_Traveler', $parent);
        $parentId = $this->db->insert_id();

        if( !empty($children) ) {
            foreach($children as $r) {
                $r['Parent_ID'] = $parentId;
                $this->db->insert('tblMRRT_Traveler_Member', $r);
            }
        }

        return $parentId;
    }

    private function update($parent, $children, $parentId)
    {
        $parent['ModiTime'] = sqlNow();
        $parent['ModiUser'] = $_SESSION['username'];
        $this->db->update('tblMRRT_Traveler', $parent, ['Rec_ID' => $parentId]);
        $this->db->delete('tblMRRT_Traveler_Member', ['Parent_ID'=> $parentId]);

        if( !empty($children) ) {
            foreach($children as $r) {
                unset($r['Rec_ID']);
                $r['Parent_ID'] = $parentId;
                $this->db->insert('tblMRRT_Traveler_Member', $r);
            }
        }
    }
}