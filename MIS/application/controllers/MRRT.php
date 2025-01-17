<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MRRT extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['MRRT Members'])) redirect('/Home');

		$data['title'] = 'MRRT';
		$data['main'] = 'mrrt_view';
		$this->load->view('layout', $data);
	}

	public function getData()
	{
		$rs = $this->db->get('tblMRRT')->result();

		$this->output->set_output(json_encode($rs));
	}

	public function save()
	{
		$model = json_decode($this->input->post('model'), true);

		$id = $model['Rec_ID'];
		unset($model['Rec_ID']);

		$model['ModiUser'] = $_SESSION['username'];
		$model['ModiTime'] = sqlNow();

		if ($id == 0) {
			$this->db->insert('tblMRRT', $model);
			$id = $this->db->insert_id();
		} else {
			$this->db->update('tblMRRT', $model, ['Rec_ID' => $id]);
		}

		$this->output->set_output(json_encode($id));
	}

	public function delete()
	{
		$where = $this->input->post();

		$this->db->delete('tblMRRT', $where);
	}
}