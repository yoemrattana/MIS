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

    public function pop_village_get()
    {
        $hcCode = $this->get('hc_code');
        $year = $this->get('year');

		$sql = "select a.Code_Vill_T, isnull(nullif(Name_Vill_K,''),Name_Vill_E) as Name_Vill_K, isnull(Distance, 0) as Distance,
                isnull(Pop, 0) as Pop, isnull(MobilePop, 0) as MobilePop, isnull(HHold, 0) as HHold,
                isnull(AgeU4,0) as AgeU4, isnull(Age5_14,0) as Age5_14, isnull(Age15_49,0) as Age15_49, isnull(AgeOver49,0) as AgeOver49,  isnull(Male,0) as Male, isnull(Female,0) as Female, Lat, Long, Lat_Old, Long_Old
                ,Lat_HC, Long_HC
                from
                (
	                SELECT HCCode, Code_Vill_T, Name_Vill_E, Name_Vill_K, DistanceFromHC as Distance, Lat, Long, Lat_Census as Lat_Old, Long_Census as Long_Old
	                FROM tblCensusVillage
	                WHERE HCCode = '$hcCode'
                ) as a
                LEFT JOIN (
	                select Code_Vill_T, Pop, MobilePop, HHold, AgeU4, Age5_14,Age15_49, AgeOver49,Male, Female From
	                tblPopByVillages
	                WHERE Year = $year
                ) as b on a.Code_Vill_T = b.Code_Vill_T
                join (
                    select Lat as Lat_HC, Long as Long_HC, Code_Facility_T from tblHFCodes where Code_Facility_T = '$hcCode'
                ) as c on c.Code_Facility_T = a.HCCode";


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

            if( isset( $row['Lat'] ) && isset( $row['Long'] ) ) {
                $village = [
                    'DistanceFromHC' => $row['Distance'],
                    "Lat" => $row['Lat'],
                    "Long"=> $row['Long'],
                    "Lat_Census" => isset($row['Lat_Old']) ? $row['Lat_Old'] : null,
                    "Long_Census" => isset($row['Long_Old']) ? $row['Long_Old'] : null,
                    "LatLongUpdateDate" => isset($row['LatLongUpdateDate']) ? $row['LatLongUpdateDate'] : null
                ];
            } else {
                $village = [
                    'DistanceFromHC' => $row['Distance'],
                ];
            }

			unset($row['Distance'],$row['Lat'],$row['Long'], $row['Lat_Old'] ,$row['Long_Old'], $row['LatLongUpdateDate']);

			if (in_array($code, $arr)) {
				$this->db->update('tblCensusVillage', $village, ['Code_Vill_T' => $code]);
				$this->db->delete('tblPopByVillages', ['Code_Vill_T' => $code, 'Year' => $year]);
				$this->db->insert('tblPopByVillages', $row);
			}
        }

        $this->response('successful');
    }
}