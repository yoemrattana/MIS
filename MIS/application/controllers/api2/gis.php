<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class GIS extends REST_Controller
{
    public function getdata_get()
    {
		$rs['case'] = $this->db->query("SP_GIS_Case")->result();
		$rs['bednet'] = $this->db->query("SP_GIS_Bednet")->result();

        $this->response($rs);
    }

	public function uploadimage_post()
    {
		$image = $this->post('image');

		$path = FCPATH . '/media/GIS/';
		if (!file_exists($path)) mkdir($path);

		$path .= GUID() . '.png';
		file_put_contents($path, base64_decode($image));
    }
}