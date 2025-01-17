<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QuestionBank extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['Surveillance Assessment Questionnaire'])) redirect('Home');

		$data['title'] = 'Surveillance Assessment Questionnaire';
		$data['main'] = 'questionbank_view';
		$data['type'] = $this->input->get('type');
		$this->load->view('layout', $data);
	}

	public function getList($type, $id = '')
	{
		if ($type == 'PHD') {
			$sql = "select a.*, Name_Prov_E, Code_Prov_T as pv
					from tblQuestionBank as a
					join tblProvince as b on a.PlaceCode = b.Code_Prov_T";
		}
		if ($type == 'OD') {
			$sql = "select a.*, Name_Prov_E, Name_OD_E
						  ,b.Code_Prov_T as pv, Code_OD_T as od
					from tblQuestionBank as a
					join tblOD as b on a.PlaceCode = b.Code_OD_T
					join tblProvince as c on b.Code_Prov_T = c.Code_Prov_T";
		}
		if ($type == 'HC') {
			$sql = "select a.*, Name_Prov_E, Name_OD_E, Name_Facility_E
						  ,Code_Prov_T as pv, Code_OD_T as od, Code_Facility_T as hc
					from tblQuestionBank as a
					join tblHFCodes as b on a.PlaceCode = b.Code_Facility_T
					join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T";
		}
		if ($type == 'VMW') {
			$sql = "select a.*, Name_Prov_E, Name_OD_E, Name_Facility_E, Name_Vill_E
						  ,d.Code_Prov_T as pv, Code_OD_T as od, Code_Facility_T as hc, b.Code_Vill_T as vl
					from tblQuestionBank as a
					join tblCensusVillage as b on a.PlaceCode = b.Code_Vill_T
					join tblHFCodes as c on b.HCCode = c.Code_Facility_T
					join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T";
		}
        if($type == 'Summary') {
            return;
        }

		if ($id != '') $sql .= " where a.Rec_ID = $id";
		$sql .= " order by InterviewDate";

		$rs = $this->db->query($sql)->result();
		if ($id != '') $rs = $rs[0];

		$this->output->set_output(json_encode($rs));
	}

	public function getDetail()
	{
		$where = $this->input->post();

		$rs = $this->db->get_where('tblQuestionBankDetail', $where)->result();

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
			$this->db->insert('tblQuestionBank', $master);
			$id = $this->db->insert_id();
		} else {
			$this->db->update('tblQuestionBank', $master, ['Rec_ID' => $id]);
		}

		$this->db->delete('tblQuestionBankDetail', ['ParentId' => $id]);

		foreach ($detail as $value)
		{
			$value['ParentId'] = $id;
			$this->db->insert('tblQuestionBankDetail', $value);
		}

		$this->getList($master['FormType'], $id);
	}

    public function getSummary()
    {
        $param = $this->input->post('submit');

        if( $param == 'HC' ) $rs=  $this->getHcSummary();
        else $rs= $this->getVmwSummary();

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

    private function getVmwSummary()
    {
        $sql = "select Name_Prov_E, Name_OD_E,Name_Facility_E, Name_Vill_E
                ,iif(b.Rec_ID is null, 0,1) as HasData
                from tblCensusVillage as a
                left join tblQuestionBank as b on a.Code_Vill_T = b.PlaceCode
                join tblHFCodes as c on a.HCCode = c.Code_Facility_T
                join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
                where a.Code_Vill_T in ('0209020502','0209050301','0209050601','0209010100','0209010200','0209010300','0209010400','0209010500','0209010800','0209010900','0209020100','0209020300','0209020400','0209020500','0209020600','0209020700','0209020900','0209050200','0209050300','0209050400','0209050500','0209050600','0209070200','0209070400','0209070500','0209070600','0209070700','0209070900','0505117900','0506010100','0506010700','0506010900','0506011300','0506050100','0506050200','0506050300','0506050700','0506051300','0506051400','0508010200','0508010300','0508010900','0508011000','0508011200','0508011400','0508011500','0508011600','0508011900','0508013700','0508040100','0508040200','0508040500','0508040700','0508040800','0508041300','0508041400','0508041500','0508043300','1101010100','1101010300','1101010400','1101010500','1101019200','1101020200','1101020300','1101020400','1101030201','1102020200','1102040100','1102040101','1102040201','1102040300','1102040400','1102040402','1102040700','1102040800','1102041200','1103020100','1103020200','1103020300','1103020301','1103020500','1103020600','1103020700','1103020800','1103020900','1103021000','1104020800','1101020401','1101010401')";

        $rs = $this->db->query($sql)->result();

        return $rs;
    }

	public function exportExcel()
    {
        $type = $this->input->post('type');

		if ($type == 'PHD') {
			$sql = "select Name_Prov_E as Province, Interviewer, InterviewDate, Interviewee, IntervieweePosition, Rec_ID
					from tblQuestionBank as a
					join tblProvince as b on a.PlaceCode = b.Code_Prov_T
					order by Province";
		}
		if ($type == 'OD') {
			$sql = "select Name_Prov_E as Province, Name_OD_E as OD, Interviewer, InterviewDate, Interviewee, IntervieweePosition, Rec_ID
					from tblQuestionBank as a
					join tblOD as b on a.PlaceCode = b.Code_OD_T
					join tblProvince as c on b.Code_Prov_T = c.Code_Prov_T
					order by Province, OD";
		}
		if ($type == 'HC') {
			$sql = "select Name_Prov_E as Province, Name_OD_E as OD, Name_Facility_E as HC, Interviewer, InterviewDate, Interviewee, IntervieweePosition, Rec_ID
					from tblQuestionBank as a
					join tblHFCodes as b on a.PlaceCode = b.Code_Facility_T
					join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
					order by Province, OD, HC";
		}
		if ($type == 'VMW') {
			$sql = "select Name_Prov_E as Province, Name_OD_E as OD, Name_Facility_E as HC, Name_Vill_E as [VMW/MMW], Interviewer, InterviewDate, Interviewee, IntervieweePosition, Rec_ID
					from tblQuestionBank as a
					join tblCensusVillage as b on a.PlaceCode = b.Code_Vill_T
					join tblHFCodes as c on b.HCCode = c.Code_Facility_T
					join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
					order by Province, OD, HC";
		}

		$rs = $this->db->query($sql)->result_array();

		$list = [];
		foreach ($rs as $r)
		{
			$id = $r['Rec_ID'];
			unset($r['Rec_ID']);

			$sql = "select QuestionId, Answer from tblQuestionBankDetail where ParentId = $id
			        order by iif(charindex('.',QuestionId + '.') = 2,1,2), QuestionId";
			$arr = $this->db->query($sql)->result_array();

			foreach ($arr as $value)
			{
				$r[$value['QuestionId']] = $value['Answer'];
			}

			$list[] = $r;
		}

		if ($type == 'OD') $type = 'PHD';
		
		$template = FCPATH . "/media/SVA/$type.xlsx";

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