<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MRRT_Entomo extends MY_Controller
{
    public function index()
	{
		if (!isset($_SESSION['permiss']['MRRT2'])) redirect('Home');

		$data['title'] = 'MRRT Mosquito Collection';
		$data['main'] = 'mrrt_entomo_view';
		$this->load->view('layout', $data);
	}

    public function getData()
    {
        $pv = $_SESSION['prov'];

        $sql = "select Code_Prov_T, b.Code_Dist_T, b.Code_Comm_T, c.Code_OD_T, a.*
                from tblMRRT_Entomo as a
                join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
                join tblHFCodes as c on b.HCCode = c.Code_Facility_T
                where '$pv' = '' or CHARINDEX(code_prov_n,'$pv') > 0";

        $rs = $this->db->query( $sql )->result();
        $this->output->set_output(json_encode($rs));
    }

    public function getDetail()
    {
        $recID = $this->input->post('Rec_ID');

        $sql = "select Code_Prov_T, b.Code_Dist_T, b.Code_Comm_T, c.Code_OD_T, a.*
                from tblMRRT_Entomo as a
                join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
                join tblHFCodes as c on b.HCCode = c.Code_Facility_T
                where a.Rec_ID = $recID";
        $rs = $this->db->query($sql)->row_array();

        $parentID = $rs ? $rs['Rec_ID'] : 0;

        $mosquitoes = $this->getMosquitoes($parentID);

        $rs['Mosquitoes'] = $mosquitoes;

        $this->output->set_output(json_encode($rs));
    }

    private function getMosquitoes($parentID)
    {
        $sql = "select * from tblMRRT_Entomo_Mosquito where Parent_ID = $parentID";
        return $this->db->query( $sql )->result();
    }

    public function save()
    {
        $question = $this->input->post('Question');
        $travel = json_decode($this->input->post('Mosquitoes'), true);

        $parentId = $question['Rec_ID'];
        unset($question['Rec_ID']);

        $question['CollectionDateTo'] = isset($question['CollectionDateTo']) && $question['CollectionDateTo'] ? $question['CollectionDateTo'] :  NULL;
        $question['ReceivedDate'] = isset($question['ReceivedDate']) && $question['ReceivedDate'] ? $question['ReceivedDate'] :  NULL;
        $question['AnalysisDate'] = isset($question['AnalysisDate']) &&  $question['AnalysisDate'] ? $question['AnalysisDate']: NULL;
        $question['SentDate'] = isset($question['SentDate']) &&  $question['SentDate'] ? $question['SentDate']: NULL;
        $question['EntomoCNMDate'] = isset($question['EntomoCNMDate']) &&  $question['EntomoCNMDate'] ? $question['EntomoCNMDate'] : NULL;
        $question['AnalystDate'] = isset($question['AnalystDate']) &&  $question['AnalystDate'] ? $question['AnalystDate'] : NULL;

        if ($parentId == 0) {
            $parentId = $this->insert($question, $travel);
        } else {
            $this->update($question, $travel, $parentId);
        }

        $sql = "select Code_Prov_T, b.Code_Dist_T, b.Code_Comm_T, c.Code_OD_T, a.*
                from tblMRRT_Entomo as a
                join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
                join tblHFCodes as c on b.HCCode = c.Code_Facility_T
                where a.Rec_ID = $parentId";

        $rs = $this->db->query( $sql )->row();

        $this->output->set_output(json_encode($rs));
    }

    private function insert($parent, $children)
    {
        $parent['InitTime'] = sqlNow();
        $parent['InitUser'] = $_SESSION['username'];
        $this->db->insert('tblMRRT_Entomo', $parent);
        $parentId = $this->db->insert_id();

        if( !empty($children) ) {
            foreach($children as $r) {
                $r['Parent_ID'] = $parentId;
                $this->db->insert('tblMRRT_Entomo_Mosquito', $r);
            }
        }

        return $parentId;
    }

    private function update($parent, $children, $parentId)
    {
        $parent['ModiTime'] = sqlNow();
        $parent['ModiUser'] = $_SESSION['username'];
        $this->db->update('tblMRRT_Entomo', $parent, ['Rec_ID' => $parentId]);
        $this->db->delete('tblMRRT_Entomo_Mosquito', ['Parent_ID'=> $parentId]);

        if( !empty($children) ) {
            foreach($children as $r) {
                unset($r['Rec_ID']);
                $r['Parent_ID'] = $parentId;
                $this->db->insert('tblMRRT_Entomo_Mosquito', $r);
            }
        }
    }

    public function getDashboardData()
    {
        $rs['mosquitosByHuor'] = $this->getMosquitosByHour();
        $rs['mainVector'] = $this->getMainVector();
        $rs['vector'] = $this->getVector();

        $this->output->set_output(json_encode( $rs ));
    }

    private function getMosquitosByHour()
    {
        $sql = "select
                  Name,
                  sum(H6_7) as H6_7,
                  sum(H7_8) as H7_8,
                  sum(H8_9) as H8_9,
                  sum(H9_10) as H9_10,
                  sum(H10_11) as H10_11,
                  sum(H11_12) as H11_12
                  from tblMRRT_Entomo_Mosquito
                  group by Name";

        return $this->db->query( $sql )->result();
    }

    private function getMainVector()
    {
        $sql = "WITH T as (
                  select YEAR(CollectionDate) as Year, Code_Vill_T, Lat, Long
                  ,sum((ISNULL(H6_7, 0) + ISNULL(H7_8 , 0)+ isnull(H8_9 ,0)+ ISNULL(H9_10,0 )+ ISNULL(H10_11 ,0)+ ISNULL(H11_12,0))) as Total
                  from tblMRRT_Entomo as a
                  join tblMRRT_Entomo_Mosquito as b on a.Rec_ID = b.Parent_ID
                  where Name in ('An. dirus s.l.', 'An. minimus s.l.', 'An. maculatus s.l.')
                  group by Year(CollectionDate), Code_Vill_T, Lat, Long
                )

                select Name_Prov_E, Name_OD_E, Name_Facility_E, Name_Vill_E, Year
                  ,iif(a.Lat in ('0', ''), Cast(b.Lat as varchar), cast(a.Lat as varchar)) as Lat
                  ,iif(a.Long in ('0', ''), Cast(b.Long as varchar), cast(a.Long as varchar)) as Long
                  ,Total
                from T as a
                join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
                join tblHFCodes as c on b.HCCode = c.Code_Facility_T
                join tblProvince as d on d.Code_Prov_T = c.Code_Prov_N";

        return $this->db->query( $sql )->result();
    }

    private function getVector()
    {
        $sql = "WITH T as (
                select Code_OD_T, Name_OD_E,
                iif(Name= 'An. dirus s.l.',1,0) as Dirus,
                iif(Name= 'An. minimus s.l.',1,0) as Minimus,
                iif(Name= 'An. maculatus s.l.',1,0) as Maculatus,
                iif(substring(Name, 1,2) = 'An' and Name not in ('An. dirus s.l.','An. minimus s.l.','An. maculatus s.l.') ,1,0) as OtherAnophele
                from tblMRRT_Entomo as a
                join tblMRRT_Entomo_Mosquito as b on a.Rec_ID = b.Parent_ID
                join tblHFCodes as c on a.Code_Facility_T = c.Code_Facility_T
                )

                select
                 Code_OD_T, Name_OD_E,
                 sum(Dirus) as Dirus,
                 sum(Minimus) as Minimus,
                 sum(Maculatus) as Maculatus,
                 sum(OtherAnophele) as OtherAnophele,
                 sum(Dirus) + sum(Minimus) +sum(Maculatus) + sum(OtherAnophele) as Total
                from T
                group by Code_OD_T, Name_OD_E";

        return $this->db->query( $sql )->result();
    }
}