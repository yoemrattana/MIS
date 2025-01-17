<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Quiz extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function list_get()
	{
		$category	= $this->get('category');
		$candidate	= $this->get('candidate');
		//$user		= $this->get('user');

		//if ( is_numeric( $user ) && strlen( $user ) == 6 ) $candidate = 'HC';
		//if ( is_numeric( $user ) && strlen( $user ) == 10 ) $candidate = 'VMW';
		//if ( !is_numeric( $user ) ) $candidate = $this->getCandidate( $user );

		if ( !empty( $category ) ) $this->db->where('Category', $category);
		$this->db->where('Candidate', $candidate);
		$rs = $this->db->get('tblQuiz')->result_array();

		array_walk($rs, function (&$a, $k) {
			unset($a['InitTime'], $a['InitUser']);
		});

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function questions_get()
	{
		$quizID = $this->get('quiz_id');

		$sql = "select top 20 b.Rec_ID as QuestionID, b.Question from tblQuiz as a
				join tblQuizQuestion as b on b.QuizID =a.Rec_ID
				where a.Rec_ID = '{$quizID}' order by NEWID()";

		$rs = $this->db->query( $sql )->result_array();

		array_walk($rs, function (&$a, $k) {
			$a['Answers'] = $this->db->get_where('tblQuizAnswer', ['QuestionID' => $a['QuestionID']])->result_array();
			unset($a['InitTime'], $a['InitUser']);
		});

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function answer_question_post()
	{
		$submit = $this->post();

		$quizTake = $submit['quiz_take'];
		$quizTake['InitTime'] = sqlNow();

		$this->db->insert('tblQuizTake', $quizTake);
		$takeID = $this->db->insert_id();

		$answers = $submit['answers'];
		$totalScore = 0;
		foreach($answers as $answer) {
			$answer['TakeID'] = $takeID;
			$answer['InitTime'] = sqlNow();

			$this->db->insert('tblQuizTakeAnswer', $answer);

			$score = $this->getScore( $answer['AnswerID'] );
			$totalScore = $totalScore + $score;
		}

		$totalQuestion = count( $answers );
		$result = $totalScore * 100 / 20;

		$this->db->update( 'tblQuizTake', ['TotalScore' => $result], ['Rec_ID' => $takeID] );

		$response = [
			"code"		=> 200,
			"message"	=> "success",
			"data"		=> []
		];

		$this->response($response);
	}

	private function getScore($answerID)
	{
		$answer = $this->db->get_where( 'tblQuizAnswer', ['Rec_ID' => $answerID] )->row_array();
		return $answer['IsCorrect'] == 1 ? 1 : 0;
	}

	public function profile_get()
	{
		$codePlace = $this->get('Code_Place');

		$score = $this->getAVGScore( $codePlace );

		$rs['score'] = $score;

		if ( strlen( $codePlace) == 6 ) $rs['histories'] = $this->getProfileHC( $codePlace );
		else $rs['histories'] = $this->getProfileVMW( $codePlace );

		$response = [
			"code"		=> 200,
			"message"	=> "success",
			"data"		=> $rs,
		];

		$this->response( $response );
	}

	private function getProfileHC( $codePlace )
	{
		$sql = "select Code_Place, Name_Facility_E as Name_Place, QuizID, Title, StartTime, EndTime, cast(TotalScore as decimal(5,2)) as TotalScore
				from tblQuizTake as a
				join tblHFCodes as b on a.Code_Place = b.Code_Facility_T
				join tblQuiz as c on a.QuizID = c.Rec_ID where Code_Place = '{$codePlace}' order by a.Rec_ID desc";

		return $this->db->query( $sql )->result_array();
	}

	private function getProfileVMW( $codePlace )
	{
		$sql = "select Code_Place, Name_Vill_K as Name_Place, QuizID, Title, StartTime, EndTime, cast(TotalScore as decimal(5,2)) as TotalScore
				from tblQuizTake as a
				join tblCensusVillage as b on a.Code_Place = b.Code_Vill_T
				join tblQuiz as c on a.QuizID = c.Rec_ID where Code_Place = '{$codePlace}' order by a.Rec_ID desc";

		return $this->db->query( $sql )->result_array();
	}

	public function last_score_get()
	{
		$codePlace = $this->get('Code_Place');
		$quizId    = $this->get('Quiz_ID');

		$sql = "select top 1 cast(TotalScore as decimal(5,2)) as LastScore from tblQuizTake where Code_Place = '{$codePlace}' and QuizID = {$quizId} order by Rec_ID desc";

		$rs = $this->db->query( $sql )->row();

		$response = [
			"code"		=> 200,
			"message"	=> "success",
			"data"		=> $rs
		];

		$this->response($response);
	}

	public function verify_get()
	{
		$codePlace = $this->get('Code_Place');

		//$sql = "with t as (
		//            select top 1 TotalScore  from tblQuizTake where Code_Place = '{$codePlace}' order by Rec_ID desc
		//        )
		//        select iif(TotalScore > 95, 1, 0) as verified from t
		//        ";

		//$rs = $this->db->query( $sql )->row();

		$rs = $this->getAVGScore( $codePlace );
		$data['verified'] = $rs > 95 ? 1 : 0;

		$response = [
			"code"		=> 200,
			"message"	=> "success",
			"data"		=> $data
		];

		$this->response($response);
	}

	private function getAVGScore( $codePlace )
	{
		$sql = "with T as
				(
					select  QuizID, Code_Place, MAX(Rec_ID) as Rec_ID from tblQuizTake
					group by  QuizID, Code_Place
				)

				select cast(AVG(TotalScore) as decimal(5,2)) as TotalScore from T as a
				left join tblQuizTake as b on a.QuizID = b.QuizID and a.Code_Place = b.Code_Place and a.Rec_ID = b.Rec_ID
				where a.Code_Place = '{$codePlace}'";

		$rs = $this->db->query( $sql )->row_array();

		return round( $rs['TotalScore'], 2 );
	}
}
