<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class qmalaria extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function list_post()
	{
		$table = strtolower('tblQM' . $this->post('type'));
		$code = $this->post('hc_code');

		$field = 'PatientCode';
		if ($table == 'tblqmlabo') $field = 'ParticipantCode';
		elseif ($table == 'tblqmbaselinedata') $field = 'DocNumber';

		$sql = "select Rec_ID, $field, InitTime, ModiTime from $table where Code_Facility_T = '$code'";
		$rs = $this->db->query($sql)->result();
		$this->response($rs);
	}

	public function form_post()
	{
		$table = strtolower('tblQM' . $this->post('type'));
        $id = $this->post('Rec_ID');

		$rs = $this->db->get_where($table, ['Rec_ID' => $id])->row();

		unset($rs->InitTime);
		unset($rs->ModiUser);
		unset($rs->ModiTime);

		if ($table == 'tblqmbaselinedata') {
			$rs->list = $this->db->get_where('tblQMBaselineDataDetail', ['ParentId' => $id])->result();
		}

		$this->response($rs);
	}

    public function update_post()
    {
		$table = strtolower('tblQM' . $this->post('type'));
        $value = $this->post('data');
		$list = [];

		if ($table == 'tblqmbaselinedata') {
			$list = $value['list'];
			unset($value['list']);
		}

		$sql = "select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '$table' and DATA_TYPE = 'nvarchar'";
		$nvarchars = array_column($this->db->query($sql)->result(), 'COLUMN_NAME');

		foreach ($value as $k => $v)
		{
			if (in_array($k, $nvarchars)) $value[$k] = $v;
		}

		$id = 0;
		if (isset($value['Rec_ID'])) {
			$id = $value['Rec_ID'];
			$sql = "select count(*) as count from $table where Rec_ID = $id";
			$count = $this->db->query($sql)->row('count');
			if ($count == 0) $id = 0;
			unset($value['Rec_ID']);
		}

		if ($id == 0) {
			if ($table == 'tblqmbaselinedata') {
				$where['Code_Facility_T'] = $value['Code_Facility_T'];
				$where['DocNumber'] = $value['DocNumber'];

				$num = $this->db->select('max(convert(int,DocNumber)) + 1 as num')->get_where('tblQMBaselineData', $where)->row('num');
				if ($num != null) $this->response(['status'=> 'Duplicate DocNumber', 'suggestion' => $num], 500);
			}

			$this->db->insert($table, $value);
			$id = $this->db->insert_id();
		} else {
			$value['ModiTime'] = sqlNow();
			$this->db->update($table, $value, ['Rec_ID' => $id]);
		}

		if (count($list) > 0) {
			for ($i = 0; $i < count($list); $i++)
			{
				$list[$i]['ParentId'] = $id;
			}

			$this->db->delete('tblQMBaselineDataDetail', ['ParentId' => $id]);
			$this->db->insert_batch('tblQMBaselineDataDetail', $list);
		}

		$this->response(['status'=> 'Successful']);
	}

	public function delete_post()
	{
		$table = strtolower('tblQM' . $this->post('type'));
        $id = $this->post('Rec_ID');

		$this->db->delete($table, ['Rec_ID' => $id]);

		$this->response('Successful');
	}
}