<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Population extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

    public function pop_village_post()
    {
        $hcCode = $this->post('hc_code');
        $year = $this->post('year');

		$sql = "select a.Code_Vill_T, isnull(nullif(Name_Vill_K,''),Name_Vill_E) as Name_Vill_K, isnull(Distance, 0) as Distance, isnull(Pop, 0) as Pop, isnull(MobilePop, 0) as MobilePop, isnull(HHold, 0) as HHold from
                (
	                SELECT Code_Vill_T, Name_Vill_E, Name_Vill_K, DistanceFromHC as Distance
	                FROM tblCensusVillage
	                WHERE HCCode = '$hcCode'
                ) as a
                LEFT JOIN (
	                select Code_Vill_T, Pop, MobilePop, HHold From
	                tblPopByVillages
	                WHERE Year = $year
                ) as b on a.Code_Vill_T = b.Code_Vill_T";

        $rs = $this->db->query($sql)->result();
        $this->response($rs);
    }

    public function update_pop_village_post()
    {
        $data = $this->post('PopVillage');

        if (count($data)  == 0) {
            $this->response(["Error" => "Data cannot be blank!"], 400);
		}

		$arr = array_column($data, 'Code_Vill_T');
		$rs = $this->db->select('Code_Vill_T')->where_in('Code_Vill_T', $arr)->get('tblCensusVillage')->result();
		$arr = array_column($rs, 'Code_Vill_T');

        foreach ($data as $row)
		{
			$code = $row['Code_Vill_T'];
			$year = $row['Year'];
			$distance = $row['Distance'];
			unset($row['Distance']);

			if (in_array($code, $arr)) {
				$this->db->update('tblCensusVillage', ['DistanceFromHC' => $distance], ['Code_Vill_T' => $code]);
				$this->db->delete('tblPopByVillages', ['Code_Vill_T' => $code, 'Year' => $year]);
				$this->db->insert('tblPopByVillages', $row);
			}
        }

        $this->response('successful');
    }
}