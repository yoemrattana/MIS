<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Message_9 extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function list_get()
	{
		$codePlace = $this->get('code_place');

		$sql = "with msg
				as (
					select *
					from tblMessage as a
					where Code_Place = '{$codePlace}' and Parent_ID is null

					union all

					select b.*
					from tblMessage as a
					join tblMessage as b on a.Rec_ID = b.Parent_ID
					where a.Code_Place = '{$codePlace}'
				)

				select * from msg
				order by Rec_ID";

		$rs = $this->db->query( $sql )->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function send_post()
	{
		$submit = $this->post('message');

		$submit['InitTime'] = sqlNow();
		$submit['IsRead'] = 0;
		unset($submit['Place'], $submit['Rec_ID'], $submit['Label'],$submit['isCNM']);
		$this->db->insert('tblMessage', $submit);

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);
	}

	public function update_status_post()
	{
		$submit = $this->post();

		$where['Rec_ID'] = $submit['Rec_ID'];
		unset( $submit['Rec_ID'] );
		$this->db->update('tblMessage', $submit, $where);

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);
	}

}