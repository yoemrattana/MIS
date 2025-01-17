<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PWA extends CI_Controller
{
	public function getPlace()
	{
		$p['pv'] = $this->db->query("select Code_Prov_T as code, Name_Prov_E as name from tblProvince order by name")->result();
		$p['od'] = $this->db->query("select Code_OD_T as code, Name_OD_E as name, Code_Prov_T as pvcode from tblOD order by name")->result();
		$p['hc'] = $this->db->query("select Code_Facility_T as code, Name_Facility_E as name, Code_OD_T as odcode, lat, long from tblHFCodes order by name")->result();
		$p['vl'] = $this->db->query("select Code_Vill_T as code, Name_Vill_E as name, HCCode as hccode, lat, long from tblCensusVillage where HCCode is not null order by name")->result();

		$rs['p'] = $p;
		$rs['pt'] = readPlaceUpdate();

		$this->output->set_output(json_encode($rs));
	}

	public function checkUpdate()
	{
		$submit = $this->input->post();

		$pu = $this->db->get_where('tblSetting', ['Name' => 'PlaceUpdate'])->row('Value');
		$pu = json_decode($pu, true);

		if ($submit['pv'] < $pu['pv']) $rs = 1;
		elseif ($submit['od'] < $pu['od']) $rs = 1;
		elseif ($submit['hc'] < $pu['hc']) $rs = 1;
		elseif ($submit['vl'] < $pu['vl']) $rs = 1;
		else $rs = 0;

		$this->output->set_output(json_encode($rs));
	}

	public function checkEntry()
	{
		$hc = $this->input->post('hc');
		$vl = $this->input->post('vl');

		$sql = "select min(convert(int,ExpireEntry)) as ExpireEntry, min(convert(int,ExpireStock)) as ExpireStock
				from tblHFDevice
				where Code_Facility_T = '$hc'";
		$rs['hc'] = $this->db->query($sql)->row();

		if ($vl != '') {
			$sql = "select min(convert(int,ExpireEntry)) as ExpireEntry
					from tblVMWDevice
					where Code_Vill_T = '$vl'";
			$rs['vl'] = $this->db->query($sql)->row();
		}

		$this->output->set_output(json_encode($rs));
	}
}