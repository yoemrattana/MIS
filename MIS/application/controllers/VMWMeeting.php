<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VMWMeeting extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['VMW Meeting'])) redirect('Home');

		$data['title'] = 'VMW Meeting';
		$data['main'] = 'vmwmeeting_view';
		$this->load->view('layout', $data);
	}

	public function getData()
	{
		$code = $this->input->post('code');
		$year = $this->input->post('year');

		$sql = "select a.Code_Vill_T, Name_Vill_E, Name_Vill_K, HaveVMW, b.Month, c.Rec_ID, Met
				from tblCensusVillage as a
				join V_VMWLog as b on a.Code_Vill_T = b.Code_Vill_T
				left join tblVMWMeeting as c on b.Code_Vill_T = c.Code_Vill_T and b.Year = c.Year and b.Month = c.Month
				where HCCode = '$code' and b.Year = '$year'
				order by Name_Vill_E";
		$rs['meeting'] = $this->db->query($sql)->result();

		$where = ['Code_Facility_T' => $code, 'Year' => $year];
		$rs['date'] = $this->db->get_where('tblVMWMeetingDate', $where)->row();

		$this->output->set_output(json_encode($rs));
	}

	public function save()
	{
		$list = $this->input->post('list') ?? [];
		$date = json_decode($this->input->post('date'), true);
		$code = $this->input->post('code');
		$year = $this->input->post('year');

		foreach ($list as $value)
		{
		    $where = ['Rec_ID' => $value['Rec_ID']];
		    unset($value['Rec_ID']);

		    if ($where['Rec_ID'] == 0) {
		        $this->db->insert('tblVMWMeeting', $value);
		    } else {
		        $this->db->update('tblVMWMeeting', $value, $where);
		    }
		}

		$where = ['Code_Facility_T' => $code, 'Year' => $year];
		$this->db->delete('tblVMWMeetingDate', $where);
		$this->db->insert('tblVMWMeetingDate', $date);

		$this->getData();
	}

	public function exportExcel()
	{
		$sql = "select Name_Prov_E, Name_OD_E, Name_Facility_E, Name_Vill_E, a.Year, a.Month, MeetingDate, isnull(Met,0) as Met
				from (
					select Code_Facility_T, Year, MeetingDate, right(replace(Month,'M','0'),2) as Month
					from tblVMWMeetingDate as a
					unpivot (MeetingDate for Month in (M1,M2,M3,M4,M5,M6,M7,M8,M9,M10,M11,M12)) as b
				) as a
				join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
				join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
				join tblCensusVillage as d on b.Code_Facility_T = d.HCCode
				left join tblVMWMeeting as e on d.Code_Vill_T = e.Code_Vill_T and a.Year = e.Year and a.Month = e.Month
				where HaveVMW = 1 and b.IsTarget = 1
				order by Name_Prov_E, Name_OD_E, Name_Facility_E, Name_Vill_E, Year, Month";

		$data = $this->db->query($sql)->result();
        $excel = arrayToExcel($data);

		ob_start();
		$writer = new PHPExcel_Writer_Excel2007($excel);
		$writer->save('php://output');
		header('Content-Length: ' . ob_get_length());
		header('Content-Type: ' . get_mime_by_extension('.xlsx'));
		ob_end_flush();
	}
}