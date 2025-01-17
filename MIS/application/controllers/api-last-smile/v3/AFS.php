<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class AFS extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function form_get()
	{
		$houseHoldID = $this->get('house_hold_id');
		$afs_date = $this->get('afs_date');

		$sql = "select a.Rec_ID as HouseMemberID,a.Name, a.Age, a.Sex,
				AFSDate,W1,W2,W3,W4,
				a.HouseHoldID from
				(
					select * from tblLastmileHouseMember
				) as a
				left join
				(
					select * from tblLastmileAFS where AFSDate = '{$afs_date}' and HouseHoldID = {$houseHoldID}
				) as b on b.HouseMemberID = a.Rec_ID
				where a.HouseHoldID = {$houseHoldID}";

		$rs = $this->db->query($sql)->result();
		$data['AFS'] = $rs;

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
	}

	public function update_post()
	{
		$data = $this->post();
		$data = $data['AFS'];

		if ( !isset( $data[0]['AFSDate'] ) ) return;

		$where = [
			'HouseHoldID'	=> $data[0]['HouseHoldID'],
			'AFSDate'		=> date('Y-m-d', strtotime($data[0]['AFSDate'])) ,
		];

		$this->db->delete('tblLastmileAFS', $where);

		foreach($data as $row){
			$row['AFSDate'] = date('Y-m-d', strtotime($row['AFSDate']));
			$row['Month'] = date('m', strtotime($row['AFSDate']));
			$row['Year'] = date('Y', strtotime($row['AFSDate']));
			$row['InitTime'] = sqlNow();
			$row['IsMobileEntry'] = 1;

			if( isset($row['houseLocalMonth']) ) unset( $row['houseLocalMonth'] );
			if( isset($row['houseLocalYear']) ) unset( $row['houseLocalYear'] );

			$this->db->insert('tblLastmileAFS', $row);
		}

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);
	}

}