<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TrainingMeeting extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['Training and Meeting'])) redirect('/Home');

		$data['title'] = 'Training and Meeting';
		$data['main'] = 'trainingmeeting_view';
		$this->load->view('layout', $data);
	}

	public function getTrainingList()
	{
		$rs = $this->db->get('tblTraining')->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getMeetingList()
	{
		$rs = $this->db->get('tblMeeting')->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getTrainingDetail()
	{
		$where = $this->input->post();

		$rs = $this->db->get_where('tblTrainingDetail', $where)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getMeetingDetail()
	{
		$where = $this->input->post();

		$rs = $this->db->get_where('tblMeetingDetail', $where)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveTraining()
	{
		$head = $this->input->post('head');
		$body = $this->input->post('body');

		$id = $head['Rec_ID'];
		unset($head['Rec_ID']);

		$head['ModiUser'] = $_SESSION['username'];
		$head['ModiTime'] = sqlNow();

		if ($id == 0) {
			$this->db->insert('tblTraining', $head);
			$id = $this->db->insert_id();
		} else {
			$this->db->update('tblTraining', $head, ['Rec_ID' => $id]);
		}

		$this->db->delete('tblTrainingDetail', ['ParentId' => $id]);

		foreach ($body as $value)
		{
			$value['ParentId'] = $id;
			$this->db->insert('tblTrainingDetail', $value);
		}

		$this->output->set_output(json_encode($id));
	}

	public function saveMeeting()
	{
		$head = $this->input->post('head');
		$body = $this->input->post('body');

		$id = $head['Rec_ID'];
		unset($head['Rec_ID']);

		$head['ModiUser'] = $_SESSION['username'];
		$head['ModiTime'] = sqlNow();

		if ($id == 0) {
			$this->db->insert('tblMeeting', $head);
			$id = $this->db->insert_id();
		} else {
			$this->db->update('tblMeeting', $head, ['Rec_ID' => $id]);
		}

		$this->db->delete('tblMeetingDetail', ['ParentId' => $id]);

		foreach ($body as $value)
		{
			$value['ParentId'] = $id;
			$this->db->insert('tblMeetingDetail', $value);
		}

		$this->output->set_output(json_encode($id));
	}

	public function exportExcel($menu)
	{
		if ($menu == 'Training') {
			$sql = "select Name_Prov_E, Name_OD_E, StartDate, EndDate, a.Type as TraingType, TrainTo, About, Result, NextStep
						  ,Name, Sex, Position, b.Type as ParticipantType
					from tblTraining as a
					join tblTrainingDetail as b on a.Rec_ID = b.ParentId
					join tblOD as c on a.Code_OD_T = c.Code_OD_T
					join tblProvince as d on c.Code_Prov_T = d.Code_Prov_T
					order by StartDate";
		} else {
			$sql = "select Name_Prov_E, Name_OD_E, StartDate, EndDate, a.Type as MeetingType, About, Result, NextStep, Name, Sex, Position
					from tblMeeting as a
					join tblMeetingDetail as b on a.Rec_ID = b.ParentId
					join tblOD as c on a.Code_OD_T = c.Code_OD_T
					join tblProvince as d on c.Code_Prov_T = d.Code_Prov_T
					order by StartDate";
		}

		$data = $this->db->query($sql)->result();
        $excel = arrayToExcel($data);

		ob_start();
		$writer = new PHPExcel_Writer_Excel2007($excel);
		$writer->save('php://output');
		header('Content-Length: ' . ob_get_length());
		header('Content-Type: ' . get_mime_by_extension('.xlsx'));
		ob_end_flush();
	}
}