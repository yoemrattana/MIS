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

    public function reported_post()
	{
        $hf = $this->post('hc_code');
		$year = $this->post('year');

        $sql = "select distinct Month from tblMalBedNet where ID = '$hf' and year = '$year'";
        $rs = $this->db->query($sql)->result();
        $this->response($rs);
    }

    public function form_post()
    {
        $hf = $this->post('hc_code');
		$year = $this->post('year');
		$month = $this->post('month');
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
		$this->response($rs);
    }

    public function update_post()
    {
        $month = $this->post('month');
        $year = $this->post('year');
        $hcCode = $this->post('hc_code');
        $data = json_decode($this->post('data'));
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);

        $this->db->delete('tblMalBedNet', ['ID' => $hcCode, 'Year' => $year, 'Month' => $month]);

		$arr = array_column($data, 'VillCode');
		$rs = $this->db->select('Code_Vill_T')->where_in('Code_Vill_T', $arr)->get('tblCensusVillage')->result();
		$arr = array_column($rs, 'Code_Vill_T');

        foreach ($data as $r)
		{
			if (in_array($r->VillCode, $arr)) {
				$r->ID = $hcCode;
				$r->InitUser = $hcCode;
				$this->db->insert('tblMalBedNet', $r);
			}
        }

        $this->response("Successful");
   }
}