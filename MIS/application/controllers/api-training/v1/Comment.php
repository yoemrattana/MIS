<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Comment extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function list_get()
	{
		$codePlace = $this->get('code_place');
		$materialID = $this->get('material_id');

		$sql = "with comment
				as (
					select *
					from tblTrainMaterialComment as a
					where Code_Place = '{$codePlace}' and Parent_ID is null

					union all

					select b.*
					from tblTrainMaterialComment as a
					join tblTrainMaterialComment as b on a.Rec_ID = b.Parent_ID
					where a.Code_Place = '{$codePlace}'
				)

				select * from comment where Material_ID = {$materialID}
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
		$this->db->insert('tblTrainMaterialComment', $submit);

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
		$this->db->update('tblTrainMaterialComment', $submit, $where);

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);
	}

}