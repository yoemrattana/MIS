<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Bednet extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

    public function form_get()
    {
        $hf = $this->get('hc_code');
		$year = $this->get('year');
		$month = $this->get('month');
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);

        $sql = "SP_API_BedNetForm '$hf','$year','$month'";
		$rs = $this->db->query($sql)->result_array();

        for ($i = 0; $i < count($rs); $i++)
        {
            foreach ($rs[$i] as $k => $v)
            {
                if ($v === null) $rs[$i][$k] = '';
            }
        }

        $response = [
           "code" => 200,
           "message" => "success",
           "data" => $rs
       ];

		$this->response($response);
    }

    public function update_post()
    {
        $data = $this->post('net');

        $p = $data[0];

        $this->db->delete('tblMalBedNet', ['ID' => $p['ID'], 'Year' => $p['Year'], 'Month' => $p['Month']]);

        foreach($data as $d) {
            if(!isset($d['VillCode'])) continue;
            $d['InitUser'] = $p['ID'];
            $this->db->insert('tblMalBedNet', $d);
        }

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);
   }
}