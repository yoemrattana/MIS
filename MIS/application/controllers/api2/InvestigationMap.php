<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class InvestigationMap extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function hcdata_post()
	{
		$yearmonth = $this->post('yearmonth');
		$species = $this->post('species');

		$rs = $this->db->query("SP_InvMap_HCData '$yearmonth','$species'")->result();
		$this->response($rs);
	}

	public function vldata_post()
	{
		$yearmonth = $this->post('yearmonth');
		$species = $this->post('species');
		$hccode = $this->post('hccode');

		$rs = $this->db->query("SP_InvMap_VLData '$yearmonth','$hccode','$species'")->result();
		$this->response($rs);
	}

	public function housedata_post()
	{
		$yearmonth = $this->post('yearmonth');
		$species = $this->post('species');
		$vlcode = $this->post('vlcode');

		$rs = $this->db->query("SP_InvMap_HouseData '$yearmonth','$vlcode','$species'")->result();
		$this->response($rs);
	}
}