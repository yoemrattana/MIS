<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Summary extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

    public function list_get()
    {
        $prov = $this->get('province');
		$od = $this->get('od');
		$year = $this->get('year');
		$mf = $this->get('month_from');
		$mt = $this->get('month_to');

        $data['eligible'] = $this->getEligible($prov, $od);

        $data['done'] = $this->getDone($prov, $od, $year, $mf, $mt);

        $data['ipt'] = $this->getIpt($prov, $od, $year, $mf, $mt);

        $data['tda'] = $this->getTda($prov, $od, $year, $mf, $mt);

        $response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
    }

    private function getEligible($prov, $od)
    {
        $where = '';
        if(!empty($prov)){
            $where .= " and c.Code_Prov_T = '$prov'";
        }
        if(!empty($od)){
            $where .= " and b.Code_OD_T = '$od'";
        }

        $sql = "select count(*) Number from tblCensusVillage as a
                join tblHFCodes as b on a.HCCode = b.Code_Facility_T
                join tblProvince as c on c.Code_Prov_T =  b.Code_Prov_N
                where IsLastmile = 1 $where";

        return $this->db->query( $sql )->row('Number');
    }

    private function getDone($prov, $od, $year, $mf, $mt)
    {
        $where = '';
        if(!empty($prov)){
            $where .= " and d.Code_Prov_T = '$prov'";
        }
        if(!empty($od)){
            $where .= " and c.Code_OD_T = '$od'";
        }
        if(!empty($year)){
            $where .= " and a.year = '$year'";
        }
        if(!empty($mf))  {
            $where .= " and a.Month between $mf and $mt";
        }

        $sql = "select count(distinct a.Code_Vill_T) as Number from tblLastmileHouseHold as a
                join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
                join tblHFCodes as c on c.Code_Facility_T = b.HCCode
                join tblProvince as d on d.Code_Prov_T = c.Code_Prov_N
                where 1=1 $where";

        return $this->db->query( $sql )->row('Number');
    }


    private function getIpt($prov, $od, $year, $mf, $mt)
    {
        $where = '';
        if(!empty($prov)){
            $where .= " and e.Code_Prov_T = '$prov'";
        }
        if(!empty($od)){
            $where .= " and d.Code_OD_T = '$od'";
        }

        $where2 = '';
        if(!empty($prov)){
            $where2 .= " and f.Code_Prov_T = '$prov'";
        }
        if(!empty($od)){
            $where2 .= " and e.Code_OD_T = '$od'";
        }
        if(!empty($year)){
            $where2 .= " and a.year = '$year'";
        }
        if(!empty($mf))  {
            $where2 .= " and a.Month between '$mf' and '$mt'";
        }

        $sql = "WITH census as
                (
	                select count(*) Eligible from tblLastmileHouseMember as a
                    join tblLastmileHouseHold as b on a.HouseHoldID = b.Rec_ID
                    join tblCensusVillage as c on c.Code_Vill_T = b.Code_Vill_T
                    join tblHFCodes as d on d.Code_Facility_T = c.HCCode
                    join tblProvince as e on e.Code_Prov_T = d.Code_Prov_N
                    where d.IsTarget = 1 and
	                Age between 15 and 49 and Sex = 'M' and ForestEntry = 'Yes' $where
                ),
                ipt as
                (
	                select count(distinct HouseMemberID) as NumberIPT from tblLastmileIPT as a
                    join tblLastmileHouseMember as b on a.HouseMemberID = b.Rec_ID
                    join tblLastmileHouseHold as c on c.Rec_ID = b.HouseHoldID
                    join tblCensusVillage as d on d.Code_Vill_T = c.Code_Vill_T
                    join tblHFCodes as e on e.Code_Facility_T = d.HCCode
                    join tblProvince as f on f.Code_Prov_T = e.Code_Prov_N
                    where e.IsTarget = 1 and
	                Age between 15 and 49 and Sex = 'M' $where2
                )

                select (select NumberIPT from ipt) * 100.0 /  (select Eligible from census) as Proportion";

        return $this->db->query( $sql )->row('Proportion');
    }

    private function getTda($prov, $od, $year, $mf, $mt)
    {
        $where = '';
        if(!empty($prov)){
            $where .= " and e.Code_Prov_T = '$prov'";
        }
        if(!empty($od)){
            $where .= " and d.Code_OD_T = '$od'";
        }

        $where2 = '';
        if(!empty($prov)){
            $where2 .= " and f.Code_Prov_T = '$prov'";
        }
        if(!empty($od)){
            $where2 .= " and e.Code_OD_T = '$od'";
        }
        if(!empty($year)){
            $where2 .= " and a.year = '$year'";
        }
        if(!empty($mf))  {
            $where2 .= " and a.Month between '$mf' and '$mt'";
        }

        $sql = "WITH census as
                (
	                select count(*) Eligible from tblLastmileHouseMember as a
                    join tblLastmileHouseHold as b on b.Rec_ID = a.HouseHoldID
                    join tblCensusVillage as c on c.Code_Vill_T = b.Code_Vill_T
                    join tblHFCodes as d on d.Code_Facility_T = c.HCCode
                    join tblProvince as e on e.Code_Prov_T = d.Code_Prov_N
                    where d.IsTarget = 1 and
	                Age between 15 and 49 and Sex = 'M' $where
                ),
                ipt as
                (
	               select count(distinct HouseMemberID) as TDA from tblLastmileTDA as a
                    join tblLastmileHouseMember as b on a.HouseMemberID = b.Rec_ID
                    join tblLastmileHouseHold as c on c.Rec_ID = b.HouseHoldID
                    join tblCensusVillage as d on d.Code_Vill_T = c.Code_Vill_T
                    join tblHFCodes as e on e.Code_Facility_T = d.HCCode
                    join tblProvince as f on f.Code_Prov_T = e.Code_Prov_N
                    where e.IsTarget = 1 and
	                Age between 15 and 49 and Sex = 'M' $where2
                )

                select (select TDA from ipt) * 100.0 /  (select Eligible from census) as Proportion";

        return $this->db->query( $sql )->row('Proportion');
    }
}