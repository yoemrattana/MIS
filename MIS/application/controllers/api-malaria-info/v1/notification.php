<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Notification extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput('api_input_cmi.txt');
	}

	public function get_list_get()
	{
		$imei = $this->get('imei');
		$type = $this->get('type');

		$sql = "select top 20 Rec_ID, Imei, Message, Type, InitTime from tblNotificationLog where Imei = '{$imei}' and Type = '{$type}' order by Rec_ID desc";

		$rs = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}
}