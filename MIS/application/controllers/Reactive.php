<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reactive extends MY_Controller
{
	public function open($id)
	{
		$where['Passive_Case_Id'] = $id;
		$count = $this->db->where($where)->count_all_results('tblReactiveCases');

		$data['title'] = 'ReACD';
		$data['main'] = $count > 0 ? 'reactive_view' : 'reactive2_view';
		$this->load->view('layout', $data);
	}

	public function getData($caseid)
	{
		$sql = "select * from tblReactiveCases where Passive_Case_Id = '$caseid'";
		$rs['data'] = $this->db->query($sql)->result();

		foreach ($rs['data'] as $i)
		{
			$villCode = $i->Vill_Code;
			$sql = "select Name_Vill_E, Name_OD_E, Name_Prov_E
					from tblCensusVillage as a
					join tblHFCodes as b on a.HCCode = b.Code_Facility_T
					join tblProvince as c on a.Code_Prov_T = c.Code_Prov_T
					where a.Code_Vill_T = '$villCode'";
			$r = $this->db->query($sql)->row();

			$i->Name_Vill_E = $r->Name_Vill_E;
			$i->Name_OD_E = $r->Name_OD_E;
			$i->Name_Prov_E = $r->Name_Prov_E;
		}

		$arr = $this->db->field_data('tblReactiveCases');
		$rs['model'] = [];
		foreach ($arr as $v) {
			$rs['model'][$v->name] = in_array($v->type, ['date', 'int', 'float']) ? null : '';
		}

		$this->output->set_output(json_encode($rs));
	}

	public function getData2($caseid)
	{
		$where['Rec_ID'] = explode('_', $caseid)[0];

		if (strContain($caseid, 'HC')) {
			$rs['head'] = $this->db->get_where('tblHFActivityCases', $where)->row();
		} else {
			$rs['head'] = $this->db->get_where('tblVMWActivityCases', $where)->row();
		}

		$rs['list'] = $this->db->get_where('tblReactive2', ['Passive_Case_Id' => $caseid])->result();

		$this->output->set_output(json_encode($rs));
	}

	public function save2()
	{
		$id = $this->input->post('id');
		$list = json_decode($this->input->post('list'), true);

		$this->db->delete('tblReactive2', ['Passive_Case_Id' => $id]);
		$this->db->insert_batch('tblReactive2', $list);
	}
}