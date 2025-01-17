<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lab extends MY_Controller
{
	public function index($view)
	{
		if (!isset($_SESSION['permiss']['Lab'])) redirect('/Home');

		$data['title'] = 'Lab';
		$data['menu'] = explode('_', $view)[0];
		$data['main'] = "lab/lab_{$view}_view";

		if (strContain($view, '_training')) $data['main'] = 'lab/lab_training_view';
		if (strContain($view, '_course')) $data['main'] = 'lab/lab_course_view';
		if (strContain($view, '_assessment')) {
			$data['main'] = 'lab/lab_assessment_view';
			$data['ranges'] = [range(1, 19), range(20, 38), range(39, 56)];

			if ($data['menu'] == 'basic') {
				$data['ranges'] = [range(1, 12), range(13, 24), range(25, 36), range(37, 48), range(49, 61), range(62, 74), range(75, 87), range(88, 100)];
			}
			if ($data['menu'] == 'refresher') {
				$data['ranges'] = [range(1, 10), range(11, 20), range(21, 30), range(31, 40), range(41, 50)];
			}
		}

		$this->load->view('layout', $data);
	}

	public function getStaff($staffid = 0)
	{
		$hc = $this->input->post('hc');

		$sql = "select isnull(Name_Prov_E,'CNM') as Name_Prov_E, Name_OD_E, Name_Facility_E, a.*, b.*, a.Staff_ID
				from tblLabStaff as a
				left join (
					select Staff_ID
						  ,max(iif(EventName = 'Basic Malaria',year(FromDate),null)) as BasicYear
						  ,max(iif(EventName = 'Refresher',year(FromDate),null)) as RefresherYear
						  ,max(iif(EventName = 'NCAMM',year(FromDate),null)) as NCAMMYear
						  ,max(iif(EventName = 'Pre-ECAMM',year(FromDate),null)) as PreECAMMYear
						  ,max(iif(EventName = 'ECAMM',year(FromDate),null)) as ECAMMYear

						  ,max(iif(EventName = 'Basic Malaria',Score,null)) as BasicScore
						  ,max(iif(EventName = 'Refresher',Score,null)) as RefresherScore
						  ,max(iif(EventName = 'NCAMM',Score,null)) as NCAMMScore
						  ,max(iif(EventName = 'Pre-ECAMM',Score,null)) as PreECAMMScore
						  ,max(iif(EventName = 'ECAMM',Score,null)) as ECAMMScore
					from (
						select *, ROW_NUMBER() over (partition by Staff_ID,EventName order by FromDate desc) as Num
						from tblLabStaffEvent
						where EventType = 'Training'
					) as a
					where Num = 1
					group by Staff_ID
				) as b on a.Staff_ID = b.Staff_ID
				left join tblHFCodes as c on a.Code_Facility_T = c.Code_Facility_T
				left join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				where ('$hc' = '' or a.Code_Facility_T = '$hc') and ($staffid = 0 or a.Staff_ID = $staffid)
				order by Name";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveStaff()
	{
		$list = json_decode($this->input->post('list'), true);

		foreach ($list as $value)
		{
			$id = $value['Staff_ID'];
			unset($value['Staff_ID']);

			if ($id == 0) {
				$this->db->insert('tblLabStaff', $value);
			} else {
				$this->db->update('tblLabStaff', $value, ['Staff_ID' => $id]);
			}
		}

		$this->getStaff();
	}

	public function deleteStaff()
	{
		$id = $this->input->post('Staff_ID');

		$sql = "BEGIN TRY delete tblLabStaff where Staff_ID = $id END TRY
				BEGIN CATCH select ERROR_NUMBER() as Error END CATCH";
		$error = $this->db->query($sql)->row('Error') == 547;

		$this->output->set_output(json_encode($error));
	}

	public function getStaffEvent()
	{
		$id = $this->input->post('id');

		$rs = $this->db->get_where('tblLabStaffEvent', ['Staff_ID' => $id])->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveStaffEvent()
	{
		$id = $this->input->post('id');
		$list = $this->input->post('list');

		$this->db->delete('tblLabStaffEvent', ['Staff_ID' => $id]);

		if ($list != null) $this->db->insert_batch('tblLabStaffEvent', $list);

		$this->getStaff($id);
	}

	public function getLogbook()
	{
		$hc = $this->input->post('hc');
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$needStaff = $this->input->post('needStaff') == 1;

		$sql = "select Name_Prov_E, Name_OD_E, Name_Facility_E, a.*
				from tblLabLogbook as a
				left join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
				left join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
				where Year = '$year' and ('$hc' = '' or a.Code_Facility_T = '$hc') and ('$month' = '' or Month = '$month')";

		$rs['list'] = $this->db->query($sql)->result();

		if ($needStaff) {
			$sql = "select Staff_ID, Name from tblLabStaff where Code_Facility_T = '$hc' order by Name";
			$rs['staff'] = $this->db->query($sql)->result();
		}

		$this->output->set_output(json_encode($rs));
	}

	public function saveLogbook()
	{
		$list = json_decode($this->input->post('list'), true);

		foreach ($list as $value)
		{
			$id = $value['Rec_ID'];
			unset($value['Rec_ID']);

			if ($id == null) {
				$this->db->insert('tblLabLogbook', $value);
			} else {
				$this->db->update('tblLabLogbook', $value, ['Rec_ID' => $id]);
			}
		}
	}

	public function getCrossCheck($needStaff = true)
	{
		$hc = $this->input->post('hc');
		$year = $this->input->post('year');
		$mf = $this->input->post('mf') ?? 0;
		$mt = $this->input->post('mt') ?? 0;

		$sql = "select Name_Prov_E, Name_OD_E, Name_Facility_E, b.*
					  ,a.Rec_ID as Logbook_ID, Name, Age, Sex, CollectionDate, D1, a.ParasiteCount as ParaCount, Year, Month
				from tblLabLogbook as a
				left join tblLabCrossCheck as b on a.Rec_ID = b.Logbook_ID
				left join tblHFCodes as c on a.Code_Facility_T = c.Code_Facility_T
				left join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				where ('$hc' = '' or a.Code_Facility_T = '$hc')
				and Year = '$year'
				and ($mf = 0 or Month between $mf and $mt)
				order by a.Rec_ID";
		$rs['list'] = $this->db->query($sql)->result();

		if ($needStaff) {
			$sql = "select Staff_ID, Name from tblLabStaff where Code_Facility_T = '$hc'";
			$rs['staff'] = $this->db->query($sql)->result();
		}

		$this->output->set_output(json_encode($rs));
	}

	public function saveCrossCheck()
	{
		$list = json_decode($this->input->post('list'), true);

		foreach ($list as $value)
		{
			$id = $value['Rec_ID'];
			unset($value['Rec_ID']);

			if ($id == null) {
				$this->db->insert('tblLabCrossCheck', $value);
			} else {
				$this->db->update('tblLabCrossCheck', $value, ['Rec_ID' => $id]);
			}
		}

		$this->getCrossCheck(false);
	}

	public function getEquipment()
	{
		$hc = $this->input->post('hc');

		$rs = $this->db->get_where('tblLabEquipment', "'$hc' = '' or Code_Facility_T = '$hc'")->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveEquipment()
	{
		$list = json_decode($this->input->post('list'), true);

		foreach ($list as $value)
		{
			$id = $value['Rec_ID'];
			unset($value['Rec_ID']);

			if ($id == null) {
				$this->db->insert('tblLabEquipment', $value);
			} else {
				$this->db->update('tblLabEquipment', $value, ['Rec_ID' => $id]);
			}
		}
	}

	public function deleteEquipment()
	{
		$id = $this->input->post('id');

		$sql = "BEGIN TRY delete tblLabEquipment where Rec_ID = $id END TRY
				BEGIN CATCH select ERROR_NUMBER() as Error END CATCH";
		$error = $this->db->query($sql)->row('Error') == 547;

		$this->output->set_output(json_encode($error));
	}

	public function getMaintenance()
	{
		$where = $this->input->post();

		$rs = $this->db->order_by('MaintenanceDate')->get_where('tblLabMaintenance', $where)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveMaintenance()
	{
		$id = $this->input->post('id');
		$list = $this->input->post('list') ?? [];

		$this->db->delete('tblLabMaintenance', ['Equipment_ID' => $id]);

		foreach ($list as $value)
		{
			$this->db->insert('tblLabMaintenance', $value);
		}
	}

	public function getPanelTesting()
	{
		$hc = $this->input->post('hc');
		$s = $this->input->post('s');

		if($hc != null) {
			$where = ['Code_Facility_T' => $hc, 'Semester' => $s];
			$rs['head'] = $this->db->get_where('tblLabPanelTesting', $where)->row();
		}

		$sql = "select Name_Prov_E, Name_OD_E, Name_Facility_E, Semester, b.*
				from tblLabPanelTesting as a
				join tblLabPanelTestingDetail as b on a.Rec_ID = b.ParentId
				join tblHFCodes as c on a.Code_Facility_T = c.Code_Facility_T
				join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				where ('$hc' = '' or a.Code_Facility_T = '$hc') and Semester like '$s%'";
		$rs['list'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function savePanelTesting()
	{
		$head = json_decode($this->input->post('head'), true);
		$list = json_decode($this->input->post('list'), true);

		$id = $head['Rec_ID'];
		unset($head['Rec_ID']);

		if ($id == null) {
			$this->db->insert('tblLabPanelTesting', $head);
			$id = $this->db->insert_id();
		} else {
			$this->db->update('tblLabPanelTesting', $head, ['Rec_ID' => $id]);
		}

		$this->db->delete('tblLabPanelTestingDetail', ['ParentId' => $id]);

		foreach ($list as $value)
		{
			$value['ParentId'] = $id;
			$this->db->insert('tblLabPanelTestingDetail', $value);
		}

		$this->getPanelTesting();
	}

	public function getReferenceSlide()
	{
		$hc = $this->input->post('hc');
		$q = $this->input->post('q');

		if ($hc != null) {
			$where = ['Code_Facility_T' => $hc, 'Q' => $q];
			$rs['head'] = $this->db->get_where('tblLabReferenceSlide', $where)->row();
		}

		$sql = "select Name_Prov_E, Name_OD_E, Name_Facility_E, Q, b.*
				from tblLabReferenceSlide as a
				join tblLabReferenceSlideDetail as b on a.Rec_ID = b.ParentId
				join tblHFCodes as c on a.Code_Facility_T = c.Code_Facility_T
				join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				where ('$hc' = '' or a.Code_Facility_T = '$hc') and Q like '$q%'";
		$rs['list'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveReferenceSlide()
	{
		$head = json_decode($this->input->post('head'), true);
		$list = json_decode($this->input->post('list'), true);

		$id = $head['Rec_ID'];
		unset($head['Rec_ID']);

		if ($id == null) {
			$this->db->insert('tblLabReferenceSlide', $head);
			$id = $this->db->insert_id();
		} else {
			$this->db->update('tblLabReferenceSlide', $head, ['Rec_ID' => $id]);
		}

		$this->db->delete('tblLabReferenceSlideDetail', ['ParentId' => $id]);

		foreach ($list as $value)
		{
			$value['ParentId'] = $id;
			$this->db->insert('tblLabReferenceSlideDetail', $value);
		}

		$this->getReferenceSlide();
	}

	public function getEQA()
	{
		$rs['head'] = $this->db->get_where('tblLabEQA', ['Username' => $_SESSION['username']])->row();
		$rs['list'] = [];

		if ($rs['head'] != null) {
			$rs['list'] = $this->db->get_where('tblLabEQADetail', ['ParentId' => $rs['head']->Rec_ID])->result();
		}

		$this->output->set_output(json_encode($rs));
	}

	public function saveEQA()
	{
		$head = json_decode($this->input->post('head'), true);
		$list = json_decode( $this->input->post('list'), true);

		$id = $head['Rec_ID'];
		unset($head['Rec_ID']);

		if ($id == 0) {
			$this->db->insert('tblLabEQA', $head);
			$id = $this->db->insert_id();
		} else {
			$this->db->update('tblLabEQA', $head, ['Rec_ID' => $id]);
		}

		$this->db->delete('tblLabEQADetail', ['ParentId' => $id]);

		foreach ($list as $value)
		{
			$value['ParentId'] = $id;
			$this->db->insert('tblLabEQADetail', $value);
		}

		$this->output->set_output(json_encode($id));
	}

	public function getIQA()
	{
		$hc = $this->input->post('hc');
		$q = $this->input->post('q');

		$sql = "select a.*, b.Rec_ID, Answer, Remark
				from tblLabIQAStatement as a
				left join tblLabIQA as b on a.Statement_ID = b.Statement_ID and b.Code_Facility_T = '$hc' and Q = '$q'
				order by a.Statement_ID";

		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveIQA()
	{
		$list = json_decode($this->input->post('list'), true);

		foreach ($list as $value)
		{
			$id = $value['Rec_ID'];
			unset($value['Rec_ID']);

			if ($id == null) {
				$this->db->insert('tblLabIQA', $value);
			} else {
				$this->db->update('tblLabIQA', $value, ['Rec_ID' => $id]);
			}
		}
	}

	public function getIQAExport()
	{
		$year = $this->input->post('year');

		$sql = "select Name_Prov_E, Name_OD_E, Name_Facility_E, Q, Category, Statement, Answer, Remark
				from tblLabIQAStatement as a
				join tblLabIQA as b on a.Statement_ID = b.Statement_ID
				join tblHFCodes as c on b.Code_Facility_T = c.Code_Facility_T
				join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				where Q like '$year%'
				order by a.Statement_ID";

		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function newIQAStatement()
	{
		$value = $this->input->post();

		$this->db->insert('tblLabIQAStatement', $value);
	}

	public function getStock()
	{
		$hc = $this->input->post('hc');
		$year = $this->input->post('year');

		$sql = "select distinct MO as Month, iif(Rec_ID is null,0,1) as Has
				from [Blank Months] as a
				join tblLabStockItem as b on 1 = 1
				left join tblLabStock as c on a.MO = c.Month and Year = '$year' and b.Code_Facility_T = c.Code_Facility_T
				where b.Code_Facility_T = '$hc'";

		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getStockDetail()
	{
		$hc = $this->input->post('hc');
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$rs = $this->db->query("SP_Lab_Stock '$hc','$year','$month'")->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getStockExport()
	{
		$hc = $this->input->post('hc');
		$year = $this->input->post('year');

		$sql = "select Name_Prov_E, Name_OD_E, Name_Facility_E, Year, Month, ItemName, StockStart, StockIn, StockOut, Adjustment, Balance
				from tblLabStock as a
				join tblLabStockItem as b on a.Item_ID = b.Item_ID and a.Code_Facility_T = b.Code_Facility_T
				join tblHFCodes as c on a.Code_Facility_T = c.Code_Facility_T
				join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				where ('$hc' = ''  or a.Code_Facility_T = '$hc') and Year = '$year'";

		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveStock()
	{
		$where = $this->input->post('where');
		$list = $this->input->post('list');

		$this->db->delete('tblLabStock', $where);
		$this->db->insert_batch('tblLabStock', $list);

		$hc = $where['Code_Facility_T'];
		$year = $where['Year'];
		$month = $where['Month'];
		$this->db->query("SP_Lab_StockRecalculate '$hc','$year','$month'");
	}

	public function deleteStock()
	{
		$where = $this->input->post('where');

		$this->db->delete('tblLabStock', $where);

		$hc = $where['Code_Facility_T'];
		$year = $where['Year'];
		$month = $where['Month'];
		$this->db->query("SP_Lab_StockRecalculate '$hc','$year','$month'");
	}

	public function getStockItem()
	{
		$hc = $this->input->post('hc');

		$rs = $this->db->get_where('tblLabStockItem', ['Code_Facility_T' => $hc])->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveStockItem()
	{
		$list = $this->input->post('list');

		foreach ($list as $value)
		{
			$id = $value['Item_ID'];
			unset($value['Item_ID']);

			if ($id == 0) $this->db->insert('tblLabStockItem', $value);
			else $this->db->update('tblLabStockItem', $value, ['Item_ID' => $id]);
		}
	}

	public function deleteStockItem()
	{
		$id = $this->input->post('id');

		$sql = "BEGIN TRY delete tblLabStockItem where Item_ID = $id END TRY
				BEGIN CATCH select ERROR_NUMBER() as Error END CATCH";
		$error = $this->db->query($sql)->row('Error') == 547;

		$this->output->set_output(json_encode($error));
	}

	public function getTraining($tbl, $needstaff = 1)
	{

		$rs['list'] = $this->db->get($tbl)->result();
		if ($needstaff == 1) $rs['staffs'] = $this->db->get('tblLabStaff')->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveTraining($tbl)
	{
		$head = $this->input->post('head');
		$list = $this->input->post('list') ?? [];

		$id = $head['Rec_ID'];
		unset($head['Rec_ID']);

		if ($id == 0) {
			$this->db->insert($tbl, $head);
			$id = $this->db->insert_id();
		} else {
			$this->db->update($tbl, $head, ['Rec_ID' => $id]);
		}

		function findStaff($arr, $value) {
			foreach ($arr as $r) {
				if ($r['Staff_ID'] == $value['Staff_ID']) return true;
			}
			return false;
		}

		$rs = $this->db->get_where($tbl.'Staff', ['ParentId' => $id])->result_array();
		foreach ($rs as $value)
		{
			if (findStaff($list, $value)) continue;
			$this->db->delete($tbl.'Staff', $value);
		}

		foreach ($list as $value)
		{
			if (findStaff($rs, $value)) continue;
			$value['ParentId'] = $id;
			$this->db->insert($tbl.'Staff', $value);
		}

		$this->output->set_output(json_encode($id));
	}

	public function getTrainingStaff($tbl)
	{
		$where = $this->input->post();
		$rs = $this->db->get_where($tbl.'Staff', $where)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function getTheory($tbl)
	{
		$id = $this->input->post('id');
		$part = $this->input->post('part');

		$where['ParentId'] = $id;
		if ($part != '') $where['Part'] = $part;

		$rs['score'] = $this->db->get_where($tbl.'Theory', $where)->row('Score');

		if ($part != '') $part = " and d.Part = '$part'";

		$sql = "select c.Staff_ID, Name, NameK, Code_Facility_T, Score
				from $tbl as a
				join {$tbl}Staff as b on a.Rec_ID = b.ParentId
				join tblLabStaff as c on b.Staff_ID = c.Staff_ID
				left join {$tbl}TheoryDetail as d on b.ParentId = d.ParentId and b.Staff_ID = d.Staff_ID $part
				where Rec_ID = $id
				order by Name";
		$rs['list'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveTheory($tbl)
	{
		$where = $this->input->post('where');
		$score = $this->input->post('score') ?? null;
		$list = json_decode($this->input->post('list'), true);

		$this->db->delete($tbl.'Theory', $where);
		$this->db->delete($tbl.'TheoryDetail', $where);

		$value = array_merge($where, ['Score' => $score]);
		$this->db->insert($tbl.'Theory', $value);
		$this->db->insert_batch($tbl.'TheoryDetail', $list);
	}

	public function getPractical($tbl)
	{
		$where = $this->input->post();
		$id = $where['ParentId'];

		$rs['heads'] = $this->db->get_where($tbl.'Practical', $where)->result();
		$rs['details'] = $this->db->get_where($tbl.'PracticalDetail', $where)->result();

		$sql = "select b.Staff_ID, Name, NameK
				from {$tbl}Staff as a
				join tblLabStaff as b on a.Staff_ID = b.Staff_ID
				where ParentId = $id
				order by Name";
		$rs['staffs'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function savePractical($tbl)
	{
		$where = $this->input->post('where');
		$heads = json_decode($this->input->post('heads'), true);
		$details = json_decode($this->input->post('details'), true);

		$this->db->delete($tbl.'Practical', $where);
		$this->db->delete($tbl.'PracticalDetail', $where);

		foreach ($heads as $value) $this->db->insert($tbl.'Practical', $value);
		foreach ($details as $value) $this->db->insert($tbl.'PracticalDetail', $value);
	}

	public function getAssessment($tbl)
	{
		$where = $this->input->post();
		$id = $where['ParentId'];

		$rs['heads'] = $this->db->get_where($tbl.'Assessment', $where)->result();
		$rs['details'] = $this->db->get_where($tbl.'AssessmentDetail', $where)->result();

		$sql = "select b.Staff_ID, Name, NameK
				from {$tbl}Staff as a
				join tblLabStaff as b on a.Staff_ID = b.Staff_ID
				where ParentId = $id
				order by Name";
		$rs['staffs'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveAssessment($tbl)
	{
		$where = $this->input->post('where');
		$heads = json_decode($this->input->post('heads'), true);
		$details = json_decode($this->input->post('details'), true);

		$this->db->delete($tbl.'Assessment', $where);
		$this->db->delete($tbl.'AssessmentDetail', $where);

		foreach ($heads as $value) $this->db->insert($tbl.'Assessment', $value);
		foreach ($details as $value) $this->db->insert($tbl.'AssessmentDetail', $value);
	}

	public function getSmear($tbl)
	{
		$id = $this->input->post('id');
		$part = $this->input->post('part');

		$sql = "select c.*, b.Staff_ID, Name
				from {$tbl}Staff as a
				join tblLabStaff as b on a.Staff_ID = b.Staff_ID
				left join {$tbl}Smear as c on a.ParentId = c.ParentId and a.Staff_ID = c.Staff_ID and c.Part = '$part'
				where a.ParentId = $id
				order by Name";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveSmear($tbl)
	{
		$where = $this->input->post('where');
		$list = json_decode($this->input->post('list'), true);

		$this->db->delete($tbl.'Smear', $where);
		$this->db->insert_batch($tbl.'Smear', $list);
	}

	public function getCourse($tbl)
	{
		$where = $this->input->post();

		$rs['list'] = $this->db->get_where($tbl.'Course', $where)->result();
		$rs['qty'] = $this->db->where($where)->count_all_results($tbl.'Staff');

		$this->output->set_output(json_encode($rs));
	}

	public function saveCourse($tbl)
	{
		$where = $this->input->post('where');
		$list = json_decode($this->input->post('list'), true);

		$this->db->delete($tbl.'Course', $where);
		$this->db->insert_batch($tbl.'Course', $list);
	}

	public function getDashboard1()
	{
		$year = $this->input->post('year');

		$rs['totalCase'] = $this->db->query("SP_Lab_Dashboard_TotalCase $year")->row();
		$rs['monthlyCase'] = $this->db->query("SP_Lab_Dashboard_MonthlyCase $year")->result();
		$rs['logbook'] = $this->db->query("SP_Lab_Dashboard_Logbook $year")->result();
		$rs['crosscheck'] = $this->db->query("SP_Lab_Dashboard_CrossCheck $year")->result();
		$rs['reference'] = $this->db->query("SP_Lab_Dashboard_Reference $year")->result();
		$rs['panel'] = $this->db->query("SP_Lab_Dashboard_Panel $year")->result();
		$rs['staff'] = $this->db->query("SP_Lab_Dashboard_Microscopist")->result();

		$rs['basic'] = $this->db->query("SP_Lab_Dashboard_Basic")->result();
		$rs['refresher'] = $this->db->query("SP_Lab_Dashboard_Refresher")->result();
		$rs['ncamm'] = $this->db->query("SP_Lab_Dashboard_NCAMM")->result();
		$rs['preecamm'] = $this->db->query("SP_Lab_Dashboard_PreECAMM")->result();
		$rs['ecamm'] = $this->db->query("SP_Lab_Dashboard_ECAMM")->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getDashboard2()
	{
		$pv = $this->input->post('pv');

		$rs['main'] = $this->db->query("SP_Lab_Dashboard2 '$pv'")->result();
		$rs['tbl'] = $this->db->query("SP_Lab_Dashboard3 '$pv'")->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getDashboard3()
	{
		$pv = $this->input->post('pv');

		$rs = $this->db->query("SP_Lab_Dashboard3 '$pv'")->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getSlide()
	{
		$rs = $this->db->get_where('tblLabSlideBank')->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveSlide()
	{
		$list = json_decode($this->input->post('list'), true);

		foreach ($list as $value)
		{
			$id = $value['Rec_ID'];
			unset($value['Rec_ID']);

			if ($id == null) {
				$this->db->insert('tblLabSlideBank', $value);
			} else {
				$this->db->update('tblLabSlideBank', $value, ['Rec_ID' => $id]);
			}
		}
	}

	public function getTrainingExport()
	{
		$tbl = $this->input->post('tbl');

		$sql = "select DateFrom, DateTo, Venue, Support, Batch
					  ,Name as StaffName, Sex, year(getdate()) - YOB as Age
					  ,Working as ServiceYear, Certificate as Education
					  ,isnull(Name_Prov_E,'CNM') as Province
					  ,isnull(Name_Facility_E,'CNM') as Province
					  ,Phone, BankAccount as ACLEDA
				from {$tbl} as a
				join {$tbl}Staff as b on a.Rec_ID = b.ParentId
				join tblLabStaff as c on b.Staff_ID = c.Staff_ID
				left join tblHFCodes as d on c.Code_Facility_T = d.Code_Facility_T
				left join tblProvince as e on d.Code_Prov_N = e.Code_Prov_T
				order by StaffName";

		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}
}