<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlacePermission extends My_Controller
{
	public function index()
	{
		if ($_SESSION['role'] != 'AU') redirect('Home');

		$data['title'] = "Place Permission";
		$data['main'] = "placepermission_view";
		$data['listModel'] = $this->db->get('tblOD')->result();

		$this->load->view('layout', $data);
	}

    public function getData()
    {
        $sql = "select Code_Prov_N, Name_Prov_E, Code_OD_T, Name_OD_E, Code_Facility_T, Name_Facility_E, IsReminder, IsFinger, IsRdtPhoto
                from tblHFCodes as a
                join tblProvince as b on a.Code_Prov_N = b.Code_Prov_T
                order by Code_Prov_N, Code_OD_T, Code_Facility_T";
        $rs = $this->db->query($sql)->result();
        $data['reminder'] = $rs;

        $sql = "select * from tblDevicePermission";
        $rs = $this->db->query($sql)->row();

        $data['device'] = $rs;

		$rs = $this->db->get('tblCensusVillage')->result();
		$data['village'] = $rs;

        return $this->output->set_output(json_encode($data));
    }
}