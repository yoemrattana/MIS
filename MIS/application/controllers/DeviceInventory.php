<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DeviceInventory extends MY_Controller
{
	public function index()
	{
        if ($_SESSION['role'] != 'AU') redirect('Home');

		$data['title'] = 'Device Inventory';
		$data['main'] = 'deviceinventory_view';
		$this->load->view('layout', $data);
	}

	public function getData()
	{
		$sql = "select Rec_ID, Imei, Serial, Model, Phone, Note, Code_Prov_T, b.Code_OD_T, Code_Facility_T, Code_Vill_T
				from tblDeviceInventory as a
				join tblOD as b on a.Code_OD_T = b.Code_OD_T
				union all
				select Rec_ID, Imei, Serial, Model, Phone, Note, Code_Prov_N, b.Code_OD_T, b.Code_Facility_T, a.Code_Vill_T
				from tblDeviceInventory as a
				join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
				union all
				select Rec_ID, Imei, Serial, Model, Phone, Note, Code_Prov_N, c.Code_OD_T, c.Code_Facility_T, a.Code_Vill_T
				from tblDeviceInventory as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T";
		$rs = $this->db->query($sql)->result();

		$this->output->json($rs);
	}

	public function save()
	{
		$id = $this->submit->Rec_ID;
		unset($this->submit->Rec_ID);

		if ($id == 0) {
			$this->db->insert('tblDeviceInventory', $this->submit);
			$id = $this->db->insert_id();
		} else {
			$this->db->update('tblDeviceInventory', $this->submit, ['Rec_ID' => $id]);
		}

		$this->output->json($id);
	}
}