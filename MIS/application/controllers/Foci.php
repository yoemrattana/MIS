<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Foci extends My_Controller
{
	public function index()
	{
        if (!isset($_SESSION['permiss']['Foci Investigation'])) redirect('Home');

		$data['title'] = "Foci Investigation";
		$data['main'] = "foci_view";
		$data['open'] = '';

		$this->load->view('layout', $data);
	}

	public function open($villcode = '')
	{
		$where['Code_Vill_T'] = $villcode;
		$count = $this->db->where($where)->count_all_results('tblFociInvestigation');

		$data['title'] = "Foci Investigation";
		$data['main'] = "foci_view";
		$data['open'] = $count > 0 ? 'foci1' : 'foci2';

		$this->load->view('layout', $data);
	}

	public function getData()
	{
		$pv = $_SESSION['prov'];
		$od = $_SESSION['code_od'];

		$rs = $this->db->query("SP_Get_FociList '$pv','$od'")->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getDetail()
	{
		$table = $this->input->post('table');
		$recid = $this->input->post('recid');
		$villcode = $this->input->post('villcode');
		$needNewModel = $this->input->post('needNewModel');

		$sql = "select top 1 a.*, Code_Prov_N, Code_OD_T, Code_Facility_T
				from $table as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				where a.Rec_ID = $recid or a.Code_Vill_T = '$villcode'
				order by a.Rec_ID desc";
		$rs['data'] = $this->db->query($sql)->row();

		if ($needNewModel == 1) {
			$arr = $this->db->list_fields($table);
			$model = [];
			foreach ($arr as $name) {
				$model[$name] = null;
			}
			$model['Code_Prov_N'] = null;
			$model['Code_OD_T'] = null;
			$model['Code_Facility_T'] = null;
			unset($model['InitUser']);
			unset($model['InitTime']);
			unset($model['ModiUser']);
			unset($model['ModiTime']);
			$rs['newModel'] = $model;
		}

        if ($rs['data'] != null) {
            $fociNum = $rs['data']->FociCode;
            $sql = "select sum(iif(b.Value in ('An. dirus s.l.','An. minimus s.l.','An. maculatus s.l.'),convert(int,c.Value),0)) as [Primary]
					      ,sum(iif(b.Value in ('An. dirus s.l.','An. minimus s.l.','An. maculatus s.l.'),0,convert(int,c.Value))) as [Secondary]
				    from tblEntomologyMosquito as a
				    join tblEntomologyMosquitoDetail as b on a.Rec_ID = b.ParentId
				    join tblEntomologyMosquitoDetail as c on b.ParentId = c.ParentId and b.ColumnIndex = c.ColumnIndex
				    where IsFoci = 'Yes' and FociNumber = '$fociNum'
				    and b.Section = 'Head' and c.Section in ('Body','Total') and c.Value is not null";
            $rs['mosquito'] = $this->db->query($sql)->row();
        } else {
            $rs['mosquito'] = new stdClass();
        }


		$this->output->set_output(json_encode($rs));
	}

	public function getPatient()
	{
		$code = $this->input->post('code');
		$dateFrom1y = $this->input->post('dateFrom1y');
		$dateFrom3y = $this->input->post('dateFrom3y');
		$dateTo = $this->input->post('dateTo');

		$sql = "select distinct NameK as Name, a.Age, Sex
					  ,Sleep_Every_Night_In_This_Vill as L1
					  ,Sleep_At_Least_One_Night_In_Other_Village_In_Same_HC as L2
					  ,Sleep_At_Least_One_Night_In_Other_Village_In_Same_OD as L3
					  ,Sleep_At_Least_One_Night_Elsewhere_Cambodia as L4
					  ,Sleep_At_Least_One_Night_In_Other_Country as Imp
					  ,DateCase
					  ,PlaceCode
				from (
					select NameK, Age, Sex, DateCase, Diagnosis, concat(Rec_ID,'_HC') as Rec_ID, ID as PlaceCode
					from tblHFActivityCases where Code_Vill_t = '$code'
					union all
					select NameK, Age, Sex, DateCase, Diagnosis, concat(Rec_ID,'_VMW') as Rec_ID, ID as PlaceCode
					from tblVMWActivityCases where ID = '$code'
				) as a
				left join tblInvestigationCases as b on a.Rec_ID = b.Passive_Case_Id
				where Diagnosis in ('F','M') and convert(date,DateCase) between '$dateFrom1y' and '$dateTo'
				order by DateCase";
		$rs = $this->db->query($sql)->result();
		foreach ($rs as $r)
		{
			$r->NoGrade = $r->L1 == 1 || $r->L2 == 1 || $r->L3 == 1 || $r->L4 == 1 || $r->Imp == 1 ? 0 : 1;
		}
		$data['investigation'] = $rs;

		$sql = "select isnull(sum(LLIN),0) as LLIN, isnull(sum(LLIHN),0) as LLIHN
				from tblMalBedNet
				where Campaign = 1 and VillCode = '$code' and Year+'-'+Month+'-01' between '$dateFrom3y' and '$dateTo'";
		$data['bednet3y'] = $this->db->query($sql)->row();

		$sql = "select isnull(sum(LLIN),0) as LLIN, isnull(sum(LLIHN),0) as LLIHN
				from tblMalBedNet
				where Continued = 1 and VillCode = '$code' and Year+'-'+Month+'-01' between '$dateFrom3y' and '$dateTo'";
		$data['bednet1y'] = $this->db->query($sql)->row();

		if (count($rs) > 0) {
			$sql = "select top 1 *
					from (
						select a.*, DateCase, iif(PassVill = '',0,1) as PassVill
						from tblInvestigationCases as a
						join tblHFActivityCases as b on a.Passive_Case_Id = concat(b.Rec_ID,'_HC')
						where Sleep_Every_Night_In_This_Vill = 1 and Code_Vill_t = '$code'
						union all
						select a.*, DateCase, 0 as PassVill
						from tblInvestigationCases as a
						join tblVMWActivityCases as b on a.Passive_Case_Id = concat(b.Rec_ID,'_VMW')
						where Sleep_Every_Night_In_This_Vill = 1 and b.Id = '$code'
					) as a
					where convert(date,DateCase) between '$dateFrom1y' and '$dateTo'
					order by DateCase desc";
			$data['profile'] = $this->db->query($sql)->row();
		}

		$sql = "select Lat, Long from tblCensusVillage where Code_Vill_T = '$code'";
		$data['gps'] = $this->db->query($sql)->row();

		$this->output->set_output(json_encode($data));
	}

	public function save1()
	{
		$value = json_decode($this->input->post('submit'), true);

		$id = $value['Rec_ID'];
		unset($value['Rec_ID']);

		if ($value['Photo'] != null && !strContain($value['Photo'], '.jpg')) {
			$dir = FCPATH.'/media/FociInvestigation';
			if (!file_exists($dir)) mkdir($dir);
			$filename = GUID().'.jpg';
			file_put_contents($dir.'/'.$filename, base64_decode(explode(',', $value['Photo'])[1]));
			$value['Photo'] = $filename;
		}

		if ($id == null) {
			$value['InitUser'] = $_SESSION['username'];
			$this->db->insert('tblFociInvestigation', $value);
			$id = $this->db->insert_id();
		} else {
			$value['ModiUser'] = $_SESSION['username'];
			$value['ModiTime'] = sqlNow();
			$where['Rec_ID'] = $id;
			$this->db->update('tblFociInvestigation', $value, $where);
		}

		$rs = $this->db->query("SP_Get_FociList '','','tblFociInvestigation',$id")->row();

		$this->output->set_output(json_encode($rs));
	}

	public function save2()
	{
		$value = json_decode($this->input->post('submit'), true);

		$id = $value['Rec_ID'];
		unset($value['Rec_ID']);

		if ($value['Photo'] != null && !strContain($value['Photo'], '.jpg')) {
			$dir = FCPATH.'/media/FociInvestigation';
			if (!file_exists($dir)) mkdir($dir);
			$filename = GUID().'.jpg';
			file_put_contents($dir.'/'.$filename, base64_decode(explode(',', $value['Photo'])[1]));
			$value['Photo'] = $filename;
		}

		if ($id == null) {
			$value['InitUser'] = $_SESSION['username'];
			$this->db->insert('tblFociInvestigation2', $value);
			$id = $this->db->insert_id();
		} else {
			$value['ModiUser'] = $_SESSION['username'];
			$value['ModiTime'] = sqlNow();
			$where['Rec_ID'] = $id;
			$this->db->update('tblFociInvestigation2', $value, $where);
		}

		$rs = $this->db->query("SP_Get_FociList '','','tblFociInvestigation2',$id")->row();

		$this->output->set_output(json_encode($rs));
	}
}