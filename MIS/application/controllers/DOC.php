<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DOC extends MY_Controller
{
	public function index($page)
	{
		if (!isset($_SESSION['permiss']['DOC'])) redirect('/Home');

		$data['title'] = 'DOC';
		$data['main'] = "doc_{$page}_view";
		$this->load->view('layout', $data);
	}

	public function getData()
	{
		$code = $this->input->post('code');
		$menu = $this->input->post('menu');
		$type = explode(' ', $menu)[0];

		if ($type == 'PHD') $key = 'Code_Prov_T';
		if ($type == 'OD') $key = 'Code_OD_T';
		if ($type == 'RH' || $type == 'HC') $key = 'Code_Facility_T';
		if ($type == 'VMW') $key = 'Code_Vill_T';

		if (strContain($menu, 'Availability')) {
			$sql = "select *, a.SN
					from tblDoc{$type}Doc1 as a
					left join tblDoc{$type}Availability as b on a.SN = b.SN and b.$key = '$code'
					order by a.SN";
		}
		if (strContain($menu, 'Accessibility')) {
			$sql = "select *, a.SN
					from tblDoc{$type}Doc1 as a
					left join tblDoc{$type}Accessibility as b on a.SN = b.SN and b.$key = '$code'
					order by a.SN";
		}
		if (strContain($menu, 'Comp-Accuracy')) {
			$sql = "select *, a.Doc2_ID
					from tblDoc{$type}Doc2 as a
					left join tblDoc{$type}Comp as b on a.Doc2_ID = b.Doc2_ID and b.$key = '$code'
					order by a.Doc2_ID";
		}

		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function save()
	{
		$where = $this->input->post('where');
		$list = json_decode($this->input->post('list'), true);
		$table = $this->input->post('table');

		$this->db->delete($table, $where);
		$this->db->insert_batch($table, $list);
	}
}