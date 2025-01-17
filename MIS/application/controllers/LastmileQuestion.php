<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LastmileQuestion extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['Last Mile Elimination Assessment'])) redirect('Home');

		$data['title'] = 'Last Mile Elimination Assessment';
		$data['main'] = 'lastmilequestion_view';
		$data['type'] = $this->input->get('type');
		$this->load->view('layout', $data);
	}

	public function getList($type, $id = '')
	{
		if ($type == 'PHD') {
			$sql = "select a.*, Name_Prov_E, Code_Prov_T as pv
					from tblLastmileQuestion as a
					join tblProvince as b on a.PlaceCode = b.Code_Prov_T";
		}
		if ($type == 'OD') {
			$sql = "select a.*, Name_Prov_E, Name_OD_E
						  ,b.Code_Prov_T as pv, Code_OD_T as od
					from tblLastmileQuestion as a
					join tblOD as b on a.PlaceCode = b.Code_OD_T
					join tblProvince as c on b.Code_Prov_T = c.Code_Prov_T";
		}
		if ($type == 'HC') {
			$sql = "select a.*, Name_Prov_E, Name_OD_E, Name_Facility_E
						  ,Code_Prov_T as pv, Code_OD_T as od, Code_Facility_T as hc
					from tblLastmileQuestion as a
					join tblHFCodes as b on a.PlaceCode = b.Code_Facility_T
					join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T";
		}
		if ($type == 'VMW') {
			$sql = "select a.*, Name_Prov_E, Name_OD_E, Name_Facility_E, Name_Vill_E
						  ,d.Code_Prov_T as pv, Code_OD_T as od, Code_Facility_T as hc, b.Code_Vill_T as vl
					from tblLastmileQuestion as a
					join tblCensusVillage as b on a.PlaceCode = b.Code_Vill_T and a.FormType = 'VMW'
					join tblHFCodes as c on b.HCCode = c.Code_Facility_T
					join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T";
		}
		if ($type == 'Vill') {
			$sql = "select a.*, Name_Prov_E, Name_OD_E, Name_Facility_E, Name_Vill_E
						  ,d.Code_Prov_T as pv, Code_OD_T as od, Code_Facility_T as hc, b.Code_Vill_T as vl
					from tblLastmileQuestion as a
					join tblCensusVillage as b on a.PlaceCode = b.Code_Vill_T and a.FormType = 'Vill'
					join tblHFCodes as c on b.HCCode = c.Code_Facility_T
					join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T";
		}
		if ($type == 'Pop') {
			$sql = "select a.*, Name_Prov_E, Name_OD_E, Name_Facility_E, Name_Vill_E
						  ,d.Code_Prov_T as pv, Code_OD_T as od, Code_Facility_T as hc, b.Code_Vill_T as vl
					from tblLastmileQuestion as a
					join tblCensusVillage as b on a.PlaceCode = b.Code_Vill_T and a.FormType = 'Pop'
					join tblHFCodes as c on b.HCCode = c.Code_Facility_T
					join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T";
		}

        if($type=='Summary') return;

		if ($id != '') $sql .= " where a.Rec_ID = $id";
		$sql .= " order by InterviewDate";

		$rs = $this->db->query($sql)->result();
		if ($id != '') $rs = $rs[0];

		$this->output->set_output(json_encode($rs));
	}

	public function getDetail()
	{
		$where = $this->input->post();

		$rs = $this->db->get_where('tblLastmileQuestionDetail', $where)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function save()
	{
		$master = $this->input->post('master');
		$detail = $this->input->post('detail');

		$master['ModiUser'] = $_SESSION['username'];
		$master['ModiTime'] = sqlNow();

		$id = $master['Rec_ID'];
		unset($master['Rec_ID']);

		if ($id == 0) {
			$this->db->insert('tblLastmileQuestion', $master);
			$id = $this->db->insert_id();
		} else {
			$this->db->update('tblLastmileQuestion', $master, ['Rec_ID' => $id]);
		}

		$this->db->delete('tblLastmileQuestionDetail', ['ParentId' => $id]);

		foreach ($detail as $value)
		{
			$value['ParentId'] = $id;
			$this->db->insert('tblLastmileQuestionDetail', $value);
		}

		$this->getList($master['FormType'], $id);
	}

    public function getSummary()
    {
        $param = $this->input->post('submit');

        if( $param == 'HC' ) $rs=  $this->getHcSummary();
        else $rs= $this->getVmwSummary($param);

        $this->output->set_output(json_encode($rs));
    }

    private function getHcSummary()
    {
        $sql = "select Name_Facility_E, Name_OD_E, Name_Prov_E,
                iif(b.Rec_ID is null, 0,1) as HasData
                from tblHFCodes as a
                left join tblQuestionBank as b on a.Code_Facility_T =  b.PlaceCode
                join tblProvince as c on a.Code_Prov_N = c.Code_Prov_T
                where a.Code_Facility_T in ('020421','020423','020424','050309','050310','050406','110105','110107','110121')";

        $rs = $this->db->query($sql)->result();

        return $rs;
    }

    private function getVmwSummary($type)
    {
        $sql = "WITH insteads as (
	                select '0506010800' as OriVill , '0506011300' as InsteadVill

	                union all

	                select '1101030201' as OriVill , '1101031400' as InsteadVill
                )

                select distinct Name_Prov_E, Name_OD_E, Name_Facility_E, Name_Vill_E, e.InsteadVill,
                iif(b.Rec_ID is null and f.PlaceCode is null, 0,1) as HasData
                from tblCensusVillage as a
                left join tblLastmileQuestion as b on a.Code_Vill_T = b.PlaceCode and FormType = '$type'
                left join insteads as e on  a.Code_Vill_T = e.OriVill
                left join (
	                select distinct PlaceCode from tblLastmileQuestion where PlaceCode in ('0506011300', '1101031400') and FormType = '$type'
                ) as f on e.InsteadVill = f.PlaceCode
                join tblHFCodes as c on a.HCCode = c.Code_Facility_T
                join tblProvince as d on a.Code_Prov_T = d.Code_Prov_T
                where a.Code_Vill_T in ('0506010100','0506010700','1101020200','1101020401','1101030201','1104020800','1504050400','1504070900','1504060600','0506010800','1101010401')";
        $rs = $this->db->query($sql)->result();

        return $rs;
    }

	public function exportExcel()
    {
        $type = $this->input->post('type');

		if ($type == 'PHD') {
			$sql = "select Name_Prov_E as Province, Interviewer, InterviewDate, Interviewee, IntervieweePosition, Rec_ID
					from tblLastmileQuestion as a
					join tblProvince as b on a.PlaceCode = b.Code_Prov_T
					order by Province";
		}
		if ($type == 'OD') {
			$sql = "select Name_Prov_E as Province, Name_OD_E as OD, Interviewer, InterviewDate, Interviewee, IntervieweePosition, Rec_ID
					from tblLastmileQuestion as a
					join tblOD as b on a.PlaceCode = b.Code_OD_T
					join tblProvince as c on b.Code_Prov_T = c.Code_Prov_T
					order by Province, OD";
		}
		if ($type == 'HC') {
			$sql = "select Name_Prov_E as Province, Name_OD_E as OD, Name_Facility_E as HC, Interviewer, InterviewDate, Interviewee, IntervieweePosition, Rec_ID
					from tblLastmileQuestion as a
					join tblHFCodes as b on a.PlaceCode = b.Code_Facility_T
					join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
					order by Province, OD, HC";
		}
		if ($type == 'VMW') {
			$sql = "select Name_Prov_E as Province, Name_OD_E as OD, Name_Facility_E as HC, Name_Vill_E as [VMW/MMW], Interviewer, InterviewDate, Interviewee, IntervieweePosition, Rec_ID
					from tblLastmileQuestion as a
					join tblCensusVillage as b on a.PlaceCode = b.Code_Vill_T
					join tblHFCodes as c on b.HCCode = c.Code_Facility_T
					join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
					where FormType = 'VMW'
					order by Province, OD, HC";
		}
		if ($type == 'Vill') {
			$sql = "select Name_Prov_E as Province, Name_OD_E as OD, Name_Facility_E as HC, Name_Vill_E as Village, Interviewer, InterviewDate, Interviewee, IntervieweePosition, Rec_ID
					from tblLastmileQuestion as a
					join tblCensusVillage as b on a.PlaceCode = b.Code_Vill_T
					join tblHFCodes as c on b.HCCode = c.Code_Facility_T
					join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
					where FormType = 'Vill'
					order by Province, OD, HC";
		}
		if ($type == 'Pop') {
			$sql = "select Name_Prov_E as Province, Name_OD_E as OD, Name_Facility_E as HC, Name_Vill_E as Village, Interviewer, InterviewDate, Interviewee, IntervieweePosition, Rec_ID
					from tblLastmileQuestion as a
					join tblCensusVillage as b on a.PlaceCode = b.Code_Vill_T
					join tblHFCodes as c on b.HCCode = c.Code_Facility_T
					join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
					where FormType = 'Pop'
					order by Province, OD, HC";
		}

		$rs = $this->db->query($sql)->result_array();

		$list = [];
		foreach ($rs as $r)
		{
			$id = $r['Rec_ID'];
			unset($r['Rec_ID']);

			$sql = "select QuestionId, Answer from tblLastmileQuestionDetail where ParentId = $id
			        order by iif(charindex('.',QuestionId + '.') = 2,1,2), QuestionId";
			$arr = $this->db->query($sql)->result_array();

			foreach ($arr as $value)
			{
				$r[$value['QuestionId']] = $value['Answer'];
			}

			$list[] = $r;
		}

		$template = FCPATH . "/media/LMA/$type.xlsx";

		$this->load->library('PHPExcel');
		$excel = PHPExcel_IOFactory::load($template);
		arrayToExcel($list, $excel, false);

		ob_start();
		$writer = new PHPExcel_Writer_Excel2007($excel);
		$writer->save('php://output');
		header('Content-Length: ' . ob_get_length());
		header('Content-Type: ' . get_mime_by_extension('.xlsx'));
		ob_end_flush();
    }
}