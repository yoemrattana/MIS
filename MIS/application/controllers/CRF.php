<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CRF extends MY_Controller
{
	public function index($v = '')
	{
		if (!isset($_SESSION['permiss']['CRF'])) redirect('Home');

		$data['title'] = 'CRF';
		$data['main'] = 'crf_view';
		$data['sub'] = $v == '' ? '' : 'crf'.$v.'_view';

		$this->load->view('layout', $data);
	}

	public function getData($tbl)
	{
		$arr = $this->db->field_data($tbl);

		$rs['data'] = $this->db->get($tbl)->result();
		$rs['model'] = [];
		$rs['datatype'] = [];

		foreach ($arr as $r) {
			if ($r->type == 'date') {
				$rs['datatype']['date'][] = $r->name;
				$rs['model'][$r->name] = null;
			}
			elseif ($r->type == 'time') {
				$rs['datatype']['time'][] = $r->name;
				$rs['model'][$r->name] = null;
			}
			else {
				$rs['model'][$r->name] = '';
			}
			if ($r->type == 'nvarchar') $rs['datatype']['nvarchar'][] = $r->name;
		}

		$this->output->set_output(json_encode($rs));
	}

    public function getReport()
    {
		$sql = "select * from (
					select a.ParticipantCode
						  ,a.InterpretationTime as User1
						  ,b.InterpretationTime as User3
						  ,DATEDIFF(minute,a.InterpretationTime,b.InterpretationTime) as MinDiff
					from tblCRFRDTUser1 as a
					join tblCRFRDTUser3 as b on a.ParticipantCode = b.ParticipantCode
				) as a
				where MinDiff is null or MinDiff < 0 or MinDiff > 15
				order by ParticipantCode";
		$rs['diff'] = $this->db->query($sql)->result();

		$sql = "select a.ParticipantCode
					  ,a.TestPerformedBy as User1
					  ,b.ReadingPerformed as User2
					  ,c.ReadingPerformedBy as User3
				from tblCRFRDTUser1 as a
				join tblCRFRDTUser2 as b on a.ParticipantCode = b.ParticipantCode
				join tblCRFRDTUser3 as c on a.ParticipantCode = c.ParticipantCode
				where a.TestPerformedBy = b.ReadingPerformed
				or a.TestPerformedBy = c.ReadingPerformedBy
				or b.ReadingPerformed = c.ReadingPerformedBy
				order by a.ParticipantCode";
		$rs['same'] = $this->db->query($sql)->result();

		$sql = "select a.ParticipantCode as Code1, b.ParticipantCode as Code2
					  ,c.ParticipantCode as Code3, d.ParticipantCode as Code4
					  ,e.ParticipantCode as Code5
				from tblCRFBaseline as a
				full join tblCRFSample as b on a.ParticipantCode = b.ParticipantCode
				full join tblCRFRDTUser1 as c on a.ParticipantCode = c.ParticipantCode
				full join tblCRFRDTUser2 as d on a.ParticipantCode = d.ParticipantCode
				full join tblCRFRDTUser3 as e on a.ParticipantCode = e.ParticipantCode
				where a.ParticipantCode is null or b.ParticipantCode is null
				or c.ParticipantCode is null or d.ParticipantCode is null
				or e.ParticipantCode is null";
		$rs['five'] = $this->db->query($sql)->result();

		$sql = "select SUBSTRING(ParticipantCode,1,2) as Code
					  ,sum(iif(RDTResult = 'Negative',1,0)) as Negative
					  ,sum(iif(RDTResult = 'Pf',1,0)) as Pf
					  ,sum(iif(RDTResult = 'Pv',1,0)) as Pv
					  ,sum(iif(RDTResult = 'Pv + Pf',1,0)) as Mix
					  ,sum(iif(RDTResult in ('Pf','Pv','Pv + Pf'),1,0)) as Positive
				from tblCRFRDTUser1
				group by SUBSTRING(ParticipantCode,1,2)";
		$rs['summary'] = $this->db->query($sql)->result();

		$sql = "select substring(ParticipantCode,1,2) as Code, count(*) as Qty
				from tblCRFBaseline
				group by substring(ParticipantCode,1,2)";
		$rs['chart'] = $this->db->query($sql)->result();

		$sql = "select ParticipantCode, TestingDate, Expiration
				from tblCRFRDTUser1
				where Expiration < TestingDate";
		$rs['expire'] = $this->db->query($sql)->result();

		$sql = "select ParticipantCode, 'User 1' as Form from tblCRFRDTUser1 where ControlLine = 'No' union all
				select ParticipantCode, 'User 2' as Form from tblCRFRDTUser2 where ControlLine = 'No' union all
				select ParticipantCode, 'User 3' as Form from tblCRFRDTUser3 where ControlLine = 'No' and CompareUser1User2 <> 'Same/concordant'";
		$rs['invalid'] = $this->db->query($sql)->result();

		$sql = "select ParticipantCode, DateOfAssessment, DateOfBirth, datediff(month,DateOfBirth,DateOfAssessment) / 12 as Age
				from tblCRFBaseline
				where datediff(month,DateOfBirth,DateOfAssessment) / 12 < 5";
		$rs['age'] = $this->db->query($sql)->result();

		$sql = "select ParticipantCode
				from tblCRFRDTUser3
				where CompareUser1User2 = 'Same/concordant' and (
					InterpretationDate is not null or
					InterpretationTime is not null or
					ControlLine <> '' or
					PvLine <> '' or
					PfLine <> '' or
					RDTResult <> '' or
					RDTStrip <> '' or
					RDTStripOther <> '' or
					OtherProblem <> '' or
					OtherProblemText <> ''
				) order by ParticipantCode";
		$rs['nonconcordant'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
    }
}