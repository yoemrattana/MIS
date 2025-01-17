<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class VMWSurvey extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		writeApiInput();
	}

	public function list_post()
	{
		$where['Code_Vill_T'] = $this->post('Village_Code');

		$rs = $this->db->get_where('tblVMWSurvey', $where)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function detail_post()
	{
		$where['ParentId'] = $this->post('Rec_ID');

		$rs = $this->db->get_where('tblVMWSurveyDetail', $where)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function save_post()
	{
		$data = $this->post();

		$details = $data['details'];
		unset($data['details']);

		if (isset($data['Rec_ID']) && $data['Rec_ID'] > 0) {
			$id = $data['Rec_ID'];
			unset($data['Rec_ID']);
			$data['ModiUser'] = $data['Code_Vill_T'];
			$data['ModiTime'] = sqlNow();

			$this->db->update('tblVMWSurvey', $data, ['Rec_ID' => $id]);
		} else {
			unset($data['Rec_ID']);
			$data['InitUser'] = $data['Code_Vill_T'];

			$this->db->insert('tblVMWSurvey', $data);
			$id = $this->db->insert_id();
		}

		$this->db->delete('tblVMWSurveyDetail', ['ParentId' => $id]);

		foreach ($details as $value)
		{
			unset($value['Rec_ID']);
			$value['ParentId'] = $id;
			$this->db->insert('tblVMWSurveyDetail', $value);
		}

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => null
		];

		$this->response($response);
	}

	public function delete_post()
	{
		$where['Rec_ID'] = $this->post('Rec_ID');

		$this->db->delete('tblVMWSurvey', $where);

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => null
		];

		$this->response($response);
	}
}