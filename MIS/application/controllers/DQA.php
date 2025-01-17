<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DQA extends MY_Controller
{
    public function index()
	{
		if (!isset($_SESSION['permiss']['DQA'])) redirect('Home');

		$data['title'] = 'DQA';
		$data['main'] = 'dqa_view';
		$data['type'] = $this->input->get('type');
		$this->load->view('layout', $data);
	}

    public function getTarget()
    {
        $target = $this->input->post('submit');

        if($target == 'HC') $rs = $this->getTargetHC();
        else $rs = $this->getTargetVMW();

        $this->output->set_output(json_encode($rs));
    }

    public function getHcPreData()
	{
		$prov = $this->input->post('prov');

		$where = "Code_Prov_N = '$prov'";
		if ($_SESSION['role'] == 'OD') {
			$code_od = $_SESSION['code_od'];
			$where = "Code_OD_T = '$code_od'";
		}

		$rs = $this->getTargetHC();

        $dist = $this->getDist();

        $provs = [];
        $ods = [];
        $hcs = [];
        foreach($rs as $k => $v){
            $prov['name'] = $v['Name_Prov_E'];
            $prov['code'] =  $v['Code_Prov_T'];
            array_push($provs, $prov);

            $od['name'] = $v['Name_OD_E'];
            $od['code'] =  $v['Code_OD_T'];
            $od['pvcode'] = $v['Code_Prov_T'];
            array_push($ods, $od);

            $hc['name'] = $v['Name_Facility_E'];
            $hc['code'] =  $v['Code_Facility_T'];
            $hc['odcode'] =  $v['Code_OD_T'];
            array_push($hcs, $hc);
        }

        $data['prov'] =array_values(array_unique($provs, SORT_REGULAR));
        $data['od']=array_values(array_unique($ods, SORT_REGULAR));
        $data['hc']=array_values(array_unique($hcs, SORT_REGULAR));
        $data['dist'] = $dist;

		$this->output->set_output(json_encode($data));
	}

    public function getVMWPreData()
	{
        $rs = $this->getTargetVMW();
        $dist = $this->getDist();

        $provs = [];
        $ods = [];
        $hcs = [];
        $vills = [];
        foreach($rs as $k => $v){
            $prov['name'] = $v['Name_Prov_E'];
            $prov['code'] =  $v['Code_Prov_T'];
            array_push($provs, $prov);

            $od['name'] = $v['Name_OD_E'];
            $od['code'] =  $v['Code_OD_T'];
            $od['pvcode'] = $v['Code_Prov_T'];
            array_push($ods, $od);

            $hc['name'] = $v['Name_Facility_E'];
            $hc['code'] =  $v['Code_Facility_T'];
            $hc['odcode'] =  $v['Code_OD_T'];
            array_push($hcs, $hc);

            $vill['name'] = $v['Name_Vill_E'];
            $vill['code'] =  $v['Code_Vill_T'];
            $vill['hccode'] =  $v['Code_Facility_T'];
            array_push($vills, $vill);
        }

        $data['prov'] = array_values(array_unique($provs, SORT_REGULAR));
        $data['od'] = array_values(array_unique($ods, SORT_REGULAR));
        $data['hc'] = array_values(array_unique($hcs, SORT_REGULAR));
        $data['vl'] = array_values(array_unique($vills, SORT_REGULAR));
        $data['dist'] = $dist;

		$this->output->set_output(json_encode($data));
    }

    public function getData()
    {
        $hc = $this->input->post('hc');
        $vl = $this->input->post('vl');
        $menu = $this->input->post('menu');

        if($menu == 'HC') $rs = $this->getHc($hc);
        else $rs = $this->getVmw($vl);

        $this->output->set_output(json_encode($rs));
    }

    public function getDetail()
    {
        $rec_id = $this->input->post('Rec_ID');
        $menu = $this->input->post('menu');

        if ($menu == 'HC') $rs = $this->getHcDetail($rec_id);
        else $rs = $this->getVmwDetail($rec_id);

        $this->output->set_output(json_encode($rs));
    }

    private function getHcDetail($rec_id)
    {
        $sql = "select​ 'HC' as CaseType, c.Code_Facility_T, a.Rec_ID,a.Year,a.Month,
                NameK, a.Age , a.Sex,a.Code_Vill_T,
                e.Code_Comm_T, f.Code_Dist_T, g.Code_Prov_T,
                DateCase, iif(RDT=1, 'RDT', 'Microscopy') as Method,
                Diagnosis, iif(LC=1 or L2=1 or L3=1 or L4=1, 'Yes','No') as IsInCountry,
                iif(LC_Code is not null or len(LC_Code) > 0, LC_Code, Which_Province) as InCountry,
                iif(IMP=1 or Imported=1, 'Yes','No') as IsOutCountry,
                iif(LC_Code is not null or len(LC_Code) > 0, IMP_Text, Which_Country) as OutCountry,
                'Yes' as Inv, DateCase as InvDate, Latitude as InvLat, Longitude as InvLong,
                FociInvestigationDate,h.FociClassification ,iif(Completed=1, 'Yes', 'No') as Completed,
                CASE
                    WHEN a.Year >= 2021 and a.Relapse = 1 THEN 'Relapse'
                    WHEN a.Year >= 2021 and a.LC= 1 THEN 'LC'
                    WHEN a.Year >= 2021 and a.IMP =1 THEN 'IMP'
	                WHEN a.Year >= 2021 and a.L1 =1 THEN 'L1'
	                WHEN a.Year < 2021 and I.L1 = 1 THEN 'L1'
	                WHEN a.Year < 2021 and I.L2 = 1 THEN 'L2'
	                WHEN a.Year < 2021 and I.L3 = 1 THEN 'L3'
	                WHEN a.Year < 2021 and I.L4 = 1 THEN 'L4'
	                WHEN a.Year < 2021 and I.Imported = 1 THEN 'Imported'
                END as Classify,
                i.Other_Village_Name, i.Which_Province,i.Which_Country,
                Treatment
                from tblHFActivityCases as a
                join tblHFCodes as c on a.ID = c.Code_Facility_T
                left join tblCensusVillage as d on a.Code_Vill_T = d.Code_Vill_T
                left join tblCommune as e on d.Code_Comm_T = e.Code_Comm_T
                left join tblDistrict as f on d.Code_Dist_T = f.Code_Dist_T
                join tblProvince as g on Code_Prov_N = g.Code_Prov_T
                left join (
	                select distinct Code_Vill_T, FociInvestigationDate,FociClassification ,Completed from
	                (
	                select  Code_Vill_T, FociInvestigationDate,FociClassification ,Completed from tblFociInvestigation

	                union all

	                select  Code_Vill_T, FociInvestigationDate,FociClassification ,Completed from tblFociInvestigation2
	                ) as sub
                ) as h on d.Code_Vill_T = h.Code_Vill_T
                left join (
	                select
	                Latitude,
	                Longitude,
	                Passive_Case_Id,
	                Sleep_Every_Night_In_This_Vill as L1,
	                Sleep_At_Least_One_Night_In_Other_Village_In_Same_HC as L2,
	                Other_Village_Name,
	                Sleep_At_Least_One_Night_In_Other_Village_In_Same_OD as L3,
	                Sleep_At_Least_One_Night_Elsewhere_Cambodia as L4,
	                Which_Province,
	                Sleep_At_Least_One_Night_In_Other_Country as Imported,
	                Which_Country
	                from tblInvestigationCases
                ) as i on CONCAT(a.Rec_ID, '_HC') = i.Passive_Case_Id
                where a.Rec_ID  = $rec_id";

        $rs = $this->db->query($sql)->row();

        $sql = "select * from tblDQA where Case_ID = $rec_id";
        $dqa = $this->db->query($sql)->row();
        $rs->dqa = $dqa;

        $dqaNote = null;
        if(!empty($dqa)) {
            $sql = "select * from tblDQANote where ParentID = $dqa->Rec_ID";
            $dqaNote = $this->db->query($sql)->row();
        }

        $rs->dqaNote = $dqaNote;

		return $rs;
    }

    private function getVmwDetail($rec_id)
    {
        $sql = "select​ 'VMW' as CaseType, d.Code_Facility_T, a.Rec_ID, a.Year,a.Month,
                NameK, a.Age , a.Sex , a.ID as Code_Vill_T
                ,e.Code_Comm_T, f.Code_Dist_T, g.Code_Prov_T,
                DateCase, 'RDT' as Method,
                Diagnosis,
                iif(LC=1 or L2=1 or L3=1 or L4=1, 'Yes','No') as IsInCountry,
                iif(LC_Code is not null or len(LC_Code) > 0, LC_Code, Which_Province) as InCountry,
                iif(IMP=1 or Imported=1, 'Yes','No') as IsOutCountry,
                iif(LC_Code is not null or len(LC_Code) > 0, IMP_Text, Which_Country) as OutCountry,
                'Yes' as Inv, DateCase as InvDate, Latitude as InvLat, Longitude as InvLong,
                FociInvestigationDate,h.FociClassification as FociClassification ,iif(Completed=1,'Yes','No') as Completed,
                CASE
                    WHEN a.Year >= 2021 and a.Relapse = 1 THEN 'Relapse'
                    WHEN a.Year >= 2021 and a.LC= 1 THEN 'LC'
                    WHEN a.Year >= 2021 and a.IMP =1 THEN 'IMP'
	                WHEN a.Year >= 2021 and a.L1 =1 THEN 'L1'
	                WHEN a.Year < 2021 and I.L1 = 1 THEN 'L1'
	                WHEN a.Year < 2021 and I.L2 = 1 THEN 'L2'
	                WHEN a.Year < 2021 and I.L3 = 1 THEN 'L3'
	                WHEN a.Year < 2021 and I.L4 = 1 THEN 'L4'
	                WHEN a.Year < 2021 and I.Imported = 1 THEN 'Imported'
                END as Classify,
                Treatment
                from tblVMWActivityCases as a
                join tblCensusVillage as c on a.ID = c.Code_Vill_T
                join tblHFCodes as d on c.HCCode = d.Code_Facility_T
                join tblCommune as e on c.Code_Comm_T = e.Code_Comm_T
                join tblDistrict as f on c.Code_Dist_T = f.Code_Dist_T
                join tblProvince as g on d.Code_Prov_N = g.Code_Prov_T
                left join (
	                select distinct Code_Vill_T, FociInvestigationDate,FociClassification ,Completed from
	                (
	                select  Code_Vill_T, FociInvestigationDate,FociClassification ,Completed from tblFociInvestigation

	                union all

	                select  Code_Vill_T, FociInvestigationDate,FociClassification ,Completed from tblFociInvestigation2
	                ) as sub
                )
                as h on a.ID = h.Code_Vill_T
                left join (
	                select
	                Latitude,
	                Longitude,
	                Passive_Case_Id,
	                Sleep_Every_Night_In_This_Vill as L1,
	                Sleep_At_Least_One_Night_In_Other_Village_In_Same_HC as L2,
	                Other_Village_Name,
	                Sleep_At_Least_One_Night_In_Other_Village_In_Same_OD as L3,
	                Sleep_At_Least_One_Night_Elsewhere_Cambodia as L4,
	                Which_Province,
	                Sleep_At_Least_One_Night_In_Other_Country as Imported,
	                Which_Country
	                from tblInvestigationCases
                ) as i on CONCAT(a.Rec_ID, '_VMW') = i.Passive_Case_Id
                where a.Rec_ID = $rec_id";

        $rs = $this->db->query($sql)->row();

        $sql = "select * from tblDQA where Case_ID = $rec_id";
        $dqa = $this->db->query($sql)->row();
        $rs->dqa = $dqa;

        $dqaNote = null;
        if(!empty($dqa)) {
            $sql = "select * from tblDQANote where ParentID = $dqa->Rec_ID";
            $dqaNote = $this->db->query($sql)->row();
        }

        $rs->dqaNote = $dqaNote;

		return $rs;
    }

    public function save()
    {
        $submit = $this->input->post('submit');

        $dqa = $submit['dqa'];
        $dqaNote = $submit['dqaNote'];

        $where['Rec_ID'] = $dqa['Rec_ID'];
        $dqa['InitTime'] = sqlNow();
        $dqa['InitUser'] = $_SESSION['username'];

        $dqaNote['InitTime'] = sqlNow();
        $dqaNote['InitUser'] = $_SESSION['username'];

        unset($dqa['Rec_ID'], $dqaNote['Rec_ID']);

        if(empty($dqa['DiagnosisDate'])) unset($dqa['DiagnosisDate']);
        if(empty($dqa['TreatmentDate'])) unset($dqa['TreatmentDate']);
        if(empty($dqa['NotificationDate'])) unset($dqa['NotificationDate']);
        if(empty($dqa['InvestigationDate'])) unset($dqa['InvestigationDate']);
        if(empty($dqa['FocusInvDate'])) unset($dqa['FocusInvDate']);

        $this->db->delete('tblDQA', $where);
        $this->db->insert('tblDQA',$dqa);

        $id = $this->db->insert_id();
        $dqaNote['ParentID'] = $id;
        $this->db->insert('tblDQANote',$dqaNote);
    }

    public function getSummary()
    {
        $rs = $this->db->query("SP_DqaSummary")->result();

        $this->output->set_output(json_encode($rs));
    }

    private function getHc($hc)
    {
        $sql = "select top 10 a.Rec_ID, NameK, a.Age, a.Sex, a.DateCase, a.Diagnosis, iif(b.Rec_ID is not null, 1,0) as HasDQA
                from tblHFActivityCases as a
                left join tblDQA as b on a.Rec_ID = b.Case_ID and Type = 'HC'
                join tblCensusVillage as c on a.Code_Vill_t = c.Code_Vill_T
                where a.Year between 2019 and 2023 and Positive= 'P'
                and ID = '$hc' and a.Code_Vill_T is not null and LEN(a.Code_Vill_T) =10 and ISNUMERIC(a.Code_Vill_T) =1
                order by Rec_ID desc";
        return $this->db->query($sql)->result();
    }

    private function getVmw($vl)
    {
        $sql = "select top 10 a.Rec_ID, NameK, a.Age, a.Sex, a.DateCase, a.Diagnosis, iif(b.Rec_ID is not null, 1,0) as HasDQA
                from tblVMWActivityCases as a
                left join tblDQA as b on a.Rec_ID = b.Case_ID and Type = 'VMW'
                where a.Year between 2019 and 2023 and Positive= 'P'
                and ID = '$vl'
                order by Rec_ID desc";
        return $this->db->query($sql)->result();;
    }

    private function getTargetHC()
    {
        $sql = "select COUNT(Rec_ID) as Positive ,
                Code_Facility_T, Name_Facility_E,
                Code_OD_T, Name_OD_E,
                Code_Prov_T, Name_Prov_E,
                iif(CaseInHC is null , 0,1) as Done
                from tblHFActivityCases as a
                join tblHFCodes as b on a.ID = b.Code_Facility_T
                join tblProvince as c on b.Code_Prov_N =  c.Code_Prov_T
                left join (
                 select Distinct CaseInHC from tblDQA where Type = 'HC'
                ) as d on b.Code_Facility_T = d.CaseInHC
                where Positive = 'P' and Year between 2019 and 2023 and b.IsTarget = 1
                and a.ID in ('020421','020423','020424','050309','050310','050406','110105','110107','110121')
                group By Code_Facility_T, Name_Facility_E,
                Code_OD_T, Name_OD_E,
                Code_Prov_T, Name_Prov_E,CaseInHC
                order by Positive desc";
		return $this->db->query($sql)->result_array();
    }

    private function getTargetVMW()
    {
        $sql = "select sum(iif(b.Rec_ID is null,0,1)) as Positive, a.Code_Vill_T, Name_Vill_E,
                Code_Facility_T, Name_Facility_E,
                Code_OD_T, Name_OD_E,
                d.Code_Prov_T, Name_Prov_E,
                iif(e.ID is null,0,1) as Done
                from tblCensusVillage  as a
                left join tblVMWActivityCases as b on b.ID = a.Code_Vill_T and Year between 2019 and 2023 and Positive = 'P'
                join tblHFCodes as c on a.HCCode = c.Code_Facility_T
                join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
                left join (
	                select distinct ID from tblDQA as a
	                join tblVMWActivityCases as b on a.Case_ID = b.Rec_ID
	                where Type = 'VMW'
                ) as e on a.Code_Vill_T = e.ID
                where a.Code_Vill_T in
                ('0209020502','0209050301','0209050601','0209010100','0209010200','0209010300','0209010400','0209010500','0209010800','0209010900','0209020100','0209020300','0209020400','0209020500','0209020600','0209020700','0209020900','0209050200','0209050300','0209050400','0209050500','0209050600','0209070200','0209070400','0209070500','0209070600','0209070700','0209070900','0505117900','0506010100','0506010700','0506010900','0506011300','0506050100','0506050200','0506050300','0506050700','0506051300','0506051400','0508010200','0508010300','0508010900','0508011000','0508011200','0508011400','0508011500','0508011600','0508011900','0508013700','0508040100','0508040200','0508040500','0508040700','0508040800','0508041300','0508041400','0508041500','0508043300','1101010100','1101010300','1101010400','1101010500','1101019200','1101020200','1101020300','1102020200','1102040100','1102040101','1102040201','1102040300','1102040400','1102040402','1102040700','1102040800','1102041200','1103020100','1103020200','1103020300','1103020301','1103020500','1103020600','1103020700','1103020800','1103020900','1103021000','1104020800','1101020401','1101031400')
                group by a.Code_Vill_T, Name_Vill_E,
                Code_Facility_T, Name_Facility_E,
                Code_OD_T, Name_OD_E,
                d.Code_Prov_T, Name_Prov_E,e.ID
                order by Positive desc";
        return $this->db->query($sql)->result_array();
    }

    private function getDist()
    {
        $sql = "select Code_Facility_T, Code_Dist_T
                from tblHFCodes as a
                join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
                where a.IsTarget=1";

        return $this->db->query($sql)->result();
    }
}