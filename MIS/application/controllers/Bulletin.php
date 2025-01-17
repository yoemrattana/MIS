<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulletin extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['Bulletin'])) redirect('/Home');

		$data['title'] = 'Bulletin';
		$data['main'] = 'bulletin_view';
		$this->load->view('layout', $data);
	}

	public function getList($id = null)
	{
		$sql = "select Rec_ID, Year, Month, PublishDate, Volume, Code_Prov_T, InitUser from tblBulletin";
		if ($id != null) $sql .= " where Rec_ID = $id";

		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function getNewData()
	{
		$prov = $this->input->post('prov');
		$from = $this->input->post('from');
		$to = $this->input->post('to');

		$rs['infra'] = $this->db->query("SP_Bulletin_Infrastructure '$prov'")->row();
		$rs['chart'] = $this->db->query("SP_Bulletin_Chart '$prov','$from','$to'")->result();
		$rs['table'] = $this->db->query("SP_Bulletin_Table '$prov','$to'")->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getOldData()
	{
		$where['Rec_ID'] = $this->input->post('id');

		$rs = $this->db->get_where('tblBulletin', $where)->row();
		$this->output->set_output(json_encode($rs));
	}

	public function save()
	{
		$value = json_decode($this->input->post('submit'), true);

		if ($value['Photo'] != null && !strContain($value['Photo'], '.jpg')) {
			$dir = FCPATH.'/media/Bulletin';
			if (!file_exists($dir)) mkdir($dir);
			$filename = GUID().'.jpg';
			file_put_contents($dir.'/'.$filename, base64_decode($value['Photo']));
			$value['Photo'] = $filename;
		}

		$this->db->insert('tblBulletin', $value);
		$id = $this->db->insert_id();

		$this->getList($id);
	}
}