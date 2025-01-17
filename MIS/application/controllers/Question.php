<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends MY_Controller
{
	public function index($q = '')
	{
        if (!isset($_SESSION['permiss']['Questionnaire'])) redirect('Home');

		$data['title'] = 'Questionnaire Form';
		$data['main'] = 'question_view';
		$data['sub'] = $q == '' ? '' : 'question'.substr($q,1).'_view';

		$this->load->view('layout', $data);
	}

	public function getData($tbl)
	{
		$where = [];
		if ($_SESSION['role'] == 'OD') $where['SubmitOD'] = $_SESSION['code_od'];

		$rs['data'] = $this->db->get_where($tbl, $where)->result();

		$arr = $this->db->field_data($tbl);
		$rs['model'] = [];
		foreach ($arr as $v) {
			$rs['model'][$v->name] = in_array($v->type, ['date', 'int', 'float']) ? null : '';
		}

		$this->output->set_output(json_encode($rs));
	}

    public function q13Cases()
    {
        if (!isset($_SESSION['permiss']['Questionnaire'])) redirect('Home');

		$data['title'] = 'Q13 Cases Form';
		$data['main'] = 'q13cases_view';

		$this->load->view('layout', $data);
    }

    public function getQ13Cases()
    {
        $rec_id = $this->input->post('rec_id');
        $location = $this->input->post('location');

        $sql = "select Treatment from tblTreatment where VMW = 1 order by Treatment";
		$array = $this->db->query($sql)->result();
		$list = [];
		foreach ($array as $r) $list[] = $r->Treatment;
		$rs['treatmentList'] = $list;

        $sql = "select * from tblVMWActiveCaseDection where Q13ID = '$rec_id' and Location = N'$location'";
        $rs['cases'] = $this->db->query($sql)->result();

        $this->output->set_output(json_encode($rs));
    }

    public function q13UpdateCase()
    {
        if (!in_array("Edit", $_SESSION['permiss']['VMW Data'])){
            show_unauthorized();
        }
        $submit = json_decode($this->input->post('submit'));

        foreach ($submit as $d)
        {
            if ($d->Rec_ID > 0) {
                $d->ModiUser = $_SESSION['username'];
                $d->ModiTime = sqlNow();
                $where = ['Rec_ID' => $d->Rec_ID];
                unset($d->Rec_ID);
                $this->db->update('tblVMWActiveCaseDection', $d, $where);
            } elseif ($d->Rec_ID < 0) {
                $this->db->delete('tblVMWActiveCaseDection', ['Rec_ID' => $d->Rec_ID * -1]);
            } else {
                $d->Is_Mobile_Entry = 0;
                $d->InitUser = $_SESSION['username'];
                unset($d->Rec_ID);
                $this->db->insert('tblVMWActiveCaseDection', $d);
            }
        }
    }
}