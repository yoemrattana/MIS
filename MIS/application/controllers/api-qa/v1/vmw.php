<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class VMW extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
		$this->load->model('MVMWQA');
	}

    public function list_post()
    {
		$pvcode = $this->post('Code_Prov_T');
        $odcode = $this->post('Code_OD_T');
		$hccode = $this->post('Code_Facility_T');
        $vlcode = $this->post('Code_Vill_T');

		$sql = "SP_Get_VMWQAList '$pvcode','$odcode','$hccode','$vlcode'";
		$rs = $this->MVMWQA->groupReport($sql);

        $this->response($rs);
    }

    public function detail_post()
    {
		$id = $this->post('Rec_ID');

		$current = $this->db->get_where('tblVMWQuestionnaire', ['Rec_ID' => $id])->row_array();

		$keys = ['Rec_ID','Code_Vill_T','VMWName','VisitDate','VisitorName','Position','WorkPlace','FormType','Sex','Training','TotalScore','TPR'];
		foreach ($keys as $k)
		{
			$rs[$k] = $k == 'TotalScore' ? (float)$current[$k] : $current[$k];
		}

		$sql = "select top 1 *
				from tblVMWQuestionnaire
				where Code_Vill_T = '{$current['Code_Vill_T']}'
				and (VisitDate = '{$current['VisitDate']}' and Rec_ID < $id or VisitDate < '{$current['VisitDate']}')
				order by VisitDate desc, Rec_ID desc";
		$previous = $this->db->query($sql)->row_array();

		$len = $rs['FormType'] == 'Old' ? 7 : ($rs['FormType'] == 'Integrated' ? 16 : 8);
		for ($i = 2; $i <= $len; $i++)
		{
			if ($i == 11) continue;
			$rs['Summary']['Current']["Section$i"] = (float)$current["Section$i"];
			$rs['Summary']['Previous']["Section$i"] = (float)$previous["Section$i"];
		}

		$sql = "select Question, Answer, convert(float,Score) as Score
				from tblVMWQuestionnaireDetail
				where ParentId = $id";
		$rs['Detail'] = $this->db->query($sql)->result();

        $this->response($rs);
    }

	public function update_post()
	{
		$value = $this->post('data');

		$detail = $value['Detail'];
		$summary = $value['Summary'];
		unset($value['Detail']);
		unset($value['Summary']);

		$vill = $value['Code_Vill_T'];
		$value = array_merge($value, $summary);

		$sql = "select isnull(avg(Positive * 100),0) as TPR
				from (
					select iif(Diagnosis = 'N',0,1) as Positive
					from tblVMWActivityCases
					where ID = '$vill' and Year + Month >= format(DATEADD(month,-6,getdate()),'yyyyMM')
					union all
					select iif(Diagnosis = 'N',0,1) as Positive
					from tblHFActivityCases
					where Code_Vill_t = '$vill' and Year + Month >= format(DATEADD(month,-6,getdate()),'yyyyMM')
				) as a";
		$value['TPR'] = $this->db->query($sql)->row('TPR');

		$sql = "select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'tblVMWQuestionnaire' and DATA_TYPE = 'nvarchar'";
		$nvarchars = array_column($this->db->query($sql)->result(), 'COLUMN_NAME');

		foreach ($value as $k => $v)
		{
			if (in_array($k, $nvarchars)) $value[$k] = $v;
		}

		for ($i = 0; $i < count($detail); $i++)
		{
			$detail[$i]['Score'] = round($detail[$i]['Score'], 2);
		}

		$id = 0;
		if (isset($value['Rec_ID'])) {
			$id = $value['Rec_ID'];
			$sql = "select count(*) as count from tblVMWQuestionnaire where Rec_ID = $id";
			$count = $this->db->query($sql)->row('count');
			if ($count == 0) $id = 0;
			unset($value['Rec_ID']);
		}

		$insert = 0;
		if ($id == 0) {
		    $this->db->insert('tblVMWQuestionnaire', $value);
		    $insert = $id = toInt($this->db->insert_id());
		} else {
		    $this->db->update('tblVMWQuestionnaire', $value, ['Rec_ID' => $id]);
		}

		for ($i = 0; $i < count($detail); $i++)
		{
		    $detail[$i]['ParentId'] = $id;
		}

		$this->db->delete('tblVMWQuestionnaireDetail', ['ParentId' => $id]);
		$this->db->insert_batch('tblVMWQuestionnaireDetail', $detail);

		if ($insert > 0) $this->response(['Rec_ID' => $id]);
	}

	public function delete_post()
	{
        $id = $this->post('Rec_ID');
		$this->db->delete('tblVMWQuestionnaire', ['Rec_ID' => $id]);
	}

	public function report_post()
	{
		$pvcode = $this->post('Code_Prov_T');
        $odcode = $this->post('Code_OD_T');
		$hccode = $this->post('Code_Facility_T');
        $vlcode = $this->post('Code_Vill_T');
		$year = $this->post('Year');
		$month = $this->post('Month');

		$sql = "SP_Get_VMWQAList '$pvcode','$odcode','$hccode','$vlcode','$year','$month'";
		$rs = $this->MVMWQA->crossTabReport($sql);

        $this->response($rs);
	}
}