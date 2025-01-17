<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['Quiz'])) redirect('Home');

		$data['title'] = 'Quiz';
		$data['main'] = 'quiz_view';

		$this->load->view('layoutV3', $data);
	}

	public function getQuizList()
	{
		$rs = $this->db->get('tblQuiz')->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getList()
	{
		$rs = $this->db->get('tblQuizQuestion')->result_array();
		array_walk($rs, function (&$a, $k) {
			$a['Answer'] = $this->db->get_where('tblQuizAnswer', ['QuestionID' => $a['Rec_ID']])->result_array();
		});

		$this->output->set_output(json_encode($rs));
	}

	public function saveQuiz()
	{
		$submit = $this->input->post('submit');
		$submit = json_decode($submit, true);

		$submit['InitTime'] = sqlNow();
		$submit['InitUser'] = $_SESSION['username'];
		$quizId = $submit['Rec_ID'];
		unset($submit['Rec_ID']);

		if ( empty( $quizId ) ) {
			$this->db->insert('tblQuiz', $submit);
			$quizId = $this->db->insert_id();
		} else {
			$this->db->update('tblQuiz', $submit, ['Rec_ID' => $quizId]);
		}

		$row = $this->db->get_where('tblQuiz', ['Rec_ID' => $quizId])->row();
		$this->output->set_output( json_encode( $row ) );
	}

	public function deleteQuiz()
	{
		$rec_id = $this->input->post('rec_id');
		$this->db->delete('tblQuiz', ['Rec_ID'=>$rec_id]);
	}

	/**
	 * Question
	 *
	 * */

	public function getQuestionList()
	{
		$quizId = $this->input->post('quizId');

		$rs = $this->db->get_where('tblQuizQuestion', ['QuizID' => $quizId])->result_array();

		array_walk($rs, function (&$a, $k) {
			$a['Answers'] = $this->db->get_where('tblQuizAnswer', ['QuestionID' => $a['Rec_ID']])->result_array();
		});

		$this->output->set_output(json_encode($rs));
	}

	public function saveQuestion()
	{
		$submit = $this->input->post('submit');
		$submit = json_decode($submit, true);

		$answers = $submit['Answers'];

		$question = $submit;
		$questionID = $question['Rec_ID'];
		unset($question['Answers'], $question['Rec_ID']);

		if ( empty( $questionID  ) ) {
			$question['InitTime'] = sqlNow();
			$question['InitUser'] = $_SESSION['username'];
			$this->db->insert('tblQuizQuestion', $question);
			$questionID = $this->db->insert_id();

			array_walk($answers, function (&$a, $k) use($questionID){
				$a['QuestionID'] = $questionID;
				unset($a['Rec_ID']);
			});

			$this->db->insert_batch( 'tblQuizAnswer', $answers );
		} else {
			$this->db->update('tblQuizQuestion', $question, ['Rec_ID' => $questionID]);
			$this->db->update_batch( 'tblQuizAnswer', $answers, 'Rec_ID' );
		}

		$rs = $this->getDetail( $questionID );

		$this->output->set_output( json_encode( $rs ) );
	}

	public function getDetail( $rec_id )
	{
		$row = $this->db->get_where('tblQuizQuestion', ['Rec_ID'=> $rec_id])->row_array();
		$row['Answers'] = $this->db->get_where('tblQuizAnswer', ['QuestionID' => $row['Rec_ID']])->result_array();

		return $row;
	}

	public function deleteQuestion()
	{
		$rec_id = $this->input->post('rec_id');
		$this->db->delete('tblQuizQuestion', ['Rec_ID'=>$rec_id]);
	}

	public function upload()
	{
		$base64 = $this->input->post('base64');
		$quizID = $this->input->post('QuizID');
		$tempName = TEMPPATH . GUID() . '.xlsx';
		file_put_contents($tempName, base64_decode($base64));

		$this->load->library('PHPExcel');
        $excel = PHPExcel_IOFactory::load($tempName);

		$data = $excel->getActiveSheet()->toArray();
		if (count($data) > 1) {
			$cols = $data[0];
			$tempArr = [];

			for ($i = 1; $i < count($data); $i++)
			{
				$row = [];
				for ($j = 0; $j < count($cols); $j++)
				{
					$cname = $cols[$j];
					$row[$cname] = $data[$i][$j];
				}
				$row['InitTime'] = sqlNow();
				$row['InitUser'] = $_SESSION['username'];
				$tempArr[] = $row;
			}

			foreach( $tempArr as $t ) {
				$q = [
					'Question' => $t['Question'],
					'Module'   => $t['Module'],
					'InitTime' => sqlNow(),
					'InitUser' => $t['InitUser'],
					'QuizID'   => $quizID,
				];

				$this->db->insert('tblQuizQuestion', $q);
				$questionID = $this->db->insert_id();

				for ($i = 1; $i <= 4 ; $i++) {
					$a = [
						'Answer' => $t['Answer'. $i],
						'IsCorrect' => $t['Correct'. $i],
						'QuestionID' => $questionID
					];

					$this->db->insert('tblQuizAnswer', $a);
				}

			}
		}

		unlink($tempName);
		$this->getList();
	}


	/**
	 * Quiz Result
	 *
	 * */

	public function result()
	{
		if (!isset($_SESSION['permiss']['Quiz'])) redirect('Home');

		$data['title'] = 'Quiz Result';
		$data['main'] = 'quizresult_view';

		$this->load->view('layoutV3', $data);
	}

	public function getQuizResult()
	{
		$sql = "with T as
				(
					select  QuizID, Code_Place, MAX(Rec_ID) as Rec_ID from tblQuizTake
					group by  QuizID, Code_Place
				),
				T0 as (
					select b.TakeID,
					sum(iif(c.IsCorrect = 1 , 1,0 )) as Correct,
					sum(iif(c.IsCorrect = 0 , 1,0 )) as Incorrect
					from tblQuizTake as a
					join tblQuizTakeAnswer as b on a.Rec_ID = b.TakeID
					join  tblQuizAnswer  as c on c.Rec_ID= b.AnswerID
					group by b.TakeID
				),
				T1 as (
					select a.Code_Place, c.Category, cast(avg(TotalScore) as decimal(5,2)) as TotalScore, avg(datediff(ss, StartTime, EndTime)) as Duration, Correct, Incorrect from T as a
					join tblQuizTake as b on a.QuizID = b.QuizID and a.Code_Place = b.Code_Place and a.Rec_ID = b.Rec_ID
					join tblQuiz as c on a.QuizID = c.Rec_ID
					left join T0 as d on b.Rec_ID = d.TakeID
					group by a.Code_Place, c.Category, Correct, Incorrect
				)

				select a.*, b.Code_Facility_T, b.Name_Facility_E, b.Code_OD_T,Name_OD_E, Code_Prov_N,Name_Prov_E, iif(len(a.Code_Place) = 6, 'HC', 'VMW') as Type, iif(TotalScore > 95, '<span class=\"label label-success\"> Passed </span>', '<span class=\"label label-danger\"> Failed </span>') as Status
				from T1 as a
				join tblHFCodes as b on a.Code_Place = b.Code_Facility_T
				join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T

				union all

				select a.*, b.HCCode, c.Name_Facility_E, c.Code_OD_T, Name_OD_E, Code_Prov_N,Name_Prov_E, iif(len(a.Code_Place) = 6, 'HC', 'VMW') as Type, iif(TotalScore > 95, '<span class=\"label label-success\"> Passed </span>', '<span class=\"label label-danger\"> Failed </span>') as Status
				from T1 as a
				join tblCensusVillage as b on a.Code_Place = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				order by TotalScore desc, Duration asc";


		$rs = $this->db->query( $sql )->result();

		$this->output->set_output( json_encode( $rs ) );
	}


	/**
     * Dashboard
     *
	 * */

	public function dashboard()
    {
        if (!isset($_SESSION['permiss']['Quiz'])) redirect('Home');

		$data['title'] = 'Quiz Dashboard';
		$data['main'] = 'quiz_dashboard_view';

		$this->load->view('layoutV3', $data);
    }

	public function getDashboardData()
    {
		$pv = $this->input->post('pv');
		$od = $this->input->post('od');
		$hc = $this->input->post('hc');

		$data['vmw'] = $this->getVMWExamResult($pv, $od , $hc);
		$data['hc'] = $this->getHCExamResult($pv, $od , $hc);

		$this->output->set_output(json_encode($data));
    }

	private function getVMWExamResult($pv, $od, $hc)
    {
        $sql = "with t as (
					select a.* , ROW_NUMBER() over (Partition by Code_Place Order by a.InitTime DESC) as RowNum
					from tblQuizTake as a
					join tblCensusVillage as b on a.Code_Place = b.Code_Vill_T
					join tblHFCodes as c on b.HCCode = c.Code_Facility_T
					where ('$pv' = '' or c.Code_Prov_N = '$pv')
					and ('$od' = '' or c.Code_OD_T = '$od')
					and ('$hc' = '' or c.Code_Facility_T = '$hc')
				)

				select sum(iif(TotalScore >=90 , 1,0)) as Pass
				,sum(iif (TotalScore <90 ,1,0)) as Failed, sum(1) as Total
				from t  where RowNum = 1";

		return $this->db->query( $sql )->row();
    }


	private function getHCExamResult($pv, $od, $hc)
    {
        $sql = "with t as (
					select a.* , ROW_NUMBER() over (Partition by Code_Place Order by a.InitTime DESC) as RowNum
					from tblQuizTake as a
					join tblHFCodes as b on a.Code_Place = b.Code_Facility_T
					where ('$pv' = '' or b.Code_Prov_N = '$pv')
					and ('$od' = '' or b.Code_OD_T = '$od')
					and ('$hc' = '' or b.Code_Facility_T = '$hc')
				)

				select sum(iif(TotalScore >=90 , 1,0)) as Pass
				,sum(iif (TotalScore <90 ,1,0)) as Failed
				,sum(1) as Total
				from t  where RowNum = 1";

		return $this->db->query( $sql )->row();
    }
}