<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['Notification'])) redirect('Home');

		$data['title'] = "Notification List";
		$data['main'] = 'notification_view';

		$this->load->view('layout', $data);
	}

	public function getData()
	{
		$sql = "select d.Code_Facility_T, b.Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS as Code_Vill_T, Code_OD_T, Code_Prov_T, a.PatientCode, NameK, Sex, Age,
				a.DateCase, Day3, Day3Date, Day7, Day7Date, Day14, Day14Date, Year, Month, b.InitTime from tblHFNotification as a
				join tblHFActivityCases as b on  b.Rec_ID = a.CodeCase
				join tblCensusVillage as c on c.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS = b.Code_Vill_t
				join tblHFCodes as d on d.Code_Facility_T = b.ID
				where Primaquine15 > 0 or Primaquine75 > 0

				union all

				select Code_Facility_T, b.ID as Code_Vill_T, Code_OD_T, Code_Prov_T, a.PatientCode, NameK, Sex, Age,
				a.DateCase, Day3, Day3Date, Day7, Day7Date, Day14, Day14Date, Year, Month, b.InitTime
				from tblVMWNotification as a
				join tblVMWActivityCases as b on 'VMW_' + convert(varchar, b.Rec_ID) = a.CodeCase
				join tblCensusVillage as c on c.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS = b.ID
				join tblHFCodes as d on d.Code_Facility_T = c.HCCode
				where Primaquine15 > 0 or Primaquine75 > 0

				union all

				select d.Code_Facility_T, b.Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS as Code_Vill_T, Code_OD_T, Code_Prov_T, a.PatientCode, NameK, Sex, Age,
				a.DateCase, Day3, Day3Date, Day7, Day7Date, Day14, Day14Date, Year, Month, b.InitTime from tblVMWNotification as a
				join tblHFActivityCases as b on 'HC_' + convert(varchar, b.Rec_ID) = a.CodeCase
				join tblCensusVillage as c on c.Code_Vill_T collate SQL_Latin1_General_CP1_CI_AS = b.Code_Vill_t
				join tblHFCodes as d on d.Code_Facility_T = b.ID
				where Primaquine15 > 0 or Primaquine75 > 0
				order by a.DateCase";

		$rs['list'] = $this->db->query($sql)->result();

		$sql = "select * from tblSetting where Name = 'AlertDayBefore'";
		$rs['AlertDayBefore'] = $this->db->query($sql)->row();

		$sql = "select * from tblSetting where Name = 'StockGrace'";
		$rs['StockGrace'] = $this->db->query($sql)->row();

		$sql = "select * from tblSetting where Name = 'NotifySpecies'";
		$rs['NotifySpecies'] = $this->db->query($sql)->row();

		$sql = "select * from tblSetting where Name = 'Threshold'";
		$rs['Threshold'] = $this->db->query($sql)->row();

		$sql = "select * from tblNotificationTemplates";
		$notification = $this->db->query($sql)->row();

		$rs['FollowupVMW']		= $notification->FollowupVMW;
		$rs['FollowupHC']		= $notification->FollowupHC;
		$rs['CaseVmwHc']		= $notification->CaseVmwHc;
		$rs['CmiCase']			= $notification->CmiCase;
		$rs['FociCase']			= $notification->FociCase;
		$rs['FociReminder']		= $notification->FociReminder;
		$rs['ReactiveCase']		= $notification->ReactiveCase;
		$rs['ReactiveReminder'] = $notification->ReactiveReminder;
		$rs['StockOut']			= $notification->StockOut;

		$this->output->set_output(json_encode($rs));
	}

	public function saveTemplate()
	{
		$value = json_decode($this->input->post('submit'), true);

		$col = $value['Name'];
		$data[$col] = $value['Value'];

		$this->db->update( 'tblNotificationTemplates', $data, ['Rec_ID' => 1] );
	}

	public function saveSetting()
	{
		$value = json_decode($this->input->post('submit'), true);

		$this->db->delete( 'tblSetting', [ 'Name' => $value['Name'] ] );
		$this->db->insert( 'tblSetting', $value );
	}
}