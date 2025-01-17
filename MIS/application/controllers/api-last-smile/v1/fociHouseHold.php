<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class FociHouseHold extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function update_post()
	{
		$data = $this->post();

		$members = $data['member'];
		$house = $data['house'];

		$house['TotalMember'] = count($members);
		//$house['LLINLack'] = count($members) - round($house['LLIN'] * 1.8);

		$rs = array_filter( $members, function( $v, $k ) use ( $members ) {
		    if($v['ForestEntry'] == 'Yes') return $v;
		}, ARRAY_FILTER_USE_BOTH );

		$house['TotalForestEntry'] = count($rs);
		//$house['LLIHNLack'] = $house['TotalForestEntry'] - $house['LLIHN'];
		$house['InitTime'] = sqlNow();
		$house['IsMobileEntry'] = 1;

		if ( isset( $house['CompleteDate'] ) ) {
			$house['Year'] = date('Y', strtotime($house['CompleteDate']));
			$house['Month'] = date('m', strtotime($house['CompleteDate']));
		}

		if ( empty( $house['Rec_ID'] ) ){
			unset( $house['Rec_ID'] );
			$this->db->insert('tblLastmileHouseHold', $house);
			$house_id = $this->db->insert_id();
		} else {
			$where['Rec_ID'] = $house['Rec_ID'];
			$house_id = $house['Rec_ID'];
			unset( $house['Rec_ID'] );
			$this->db->update('tblLastmileHouseHold', $house, $where);
		}

		//Member
		$this->deleteMember($house_id, $members);

		$response = [
			"code"		=> 200,
			"message"	=> "success",
			"data"		=> []
		];

		if ( isset($house['HasMemberAtHome']) && $house['HasMemberAtHome'] == 'No' ) $this->response($response);

		foreach ($members as $member){
			if($member['Age'] >=15 && $member['Age'] <= 49 && $member['Sex'] == 'M'){
			    $member['TDA'] = 'Yes';
			}

			if ($member['Age'] >=15 && $member['Age'] <= 49 && $member['ForestEntry'] == 'Yes'){
			    $member['IPT'] = 'Yes';
			}
			$member['HouseHoldID'] = $house_id;
			$member['InitTime'] = sqlNow();

			if(empty($member['Rec_ID'])) {
				unset($member['Rec_ID']);
				$this->db->insert('tblLastmileHouseMember', $member);
			}else{
				$where['Rec_ID'] =  $member['Rec_ID'];
				unset($member['Rec_ID']);
				$this->db->update('tblLastmileHouseMember', $member, $where);
			}
		}

		$this->response($response);
	}

	public function delete_post()
	{
		$recID = $this->post('Rec_ID');

		$this->db->delete('tblLastmileHouseHold', ['Rec_ID' => $recID]);

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);
	}

	public function list_get()
	{
		$village_code = $this->get('village_code');
		$sql = "select a.*,
					(select min(TDADate) from tblLastmileTDA where Type = 1 and HouseHoldID = a.Rec_ID) as TDA1,
					(select min(TDADate) from tblLastmileTDA where Type = 2 and HouseHoldID = a.Rec_ID) as TDA2,
					(stuff((select distinct ',' + cast(b.IPTDate as varchar(100))
								from tblLastmileIPT as b
								where b.HouseHoldID = a.Rec_ID
								for xml path('')), 1, 1, '')) as IPT,
					(stuff((select distinct ',' + cast(c.AFSDate as varchar(500))
					from tblLastmileAFS as c
					where c.HouseHoldID = a.Rec_ID
					for xml path('')), 1, 1, '')) as AFS
					from tblLastmileHouseHold as a
				where Code_Vill_T = '{$village_code}' order by a.HouseNumber";

		$rs = $this->db->query($sql)->result_array();

		array_walk($rs, function (&$a, $k) {
			unset($a['InitTime']);
			$a['IPT'] = empty($a['IPT']) ? [] : explode(',', $a['IPT']);

			$a['AFS'] = empty($a['AFS']) ? [] : explode(',', $a['AFS']);
		});

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	public function detail_get()
	{
		$houseHoldID = $this->get('house_hold_id');

		$sql = "select a.*,
					(select min(TDADate) from tblLastmileTDA where Type = 1 and HouseHoldID = a.Rec_ID) as TDA1,
					(select min(TDADate) from tblLastmileTDA where Type = 2 and HouseHoldID = a.Rec_ID) as TDA2,
					(stuff((select distinct ',' + cast(b.IPTDate as varchar(100))
								from tblLastmileIPT as b
								where b.HouseHoldID = a.Rec_ID
								for xml path('')), 1, 1, '')) as IPT
				from tblLastmileHouseHold as a
				where a.Rec_ID = {$houseHoldID}";

		$houseHold = $this->db->query($sql)->row_array();

		$houseHold['IPT'] = empty($houseHold['IPT']) ? [] : explode(',', $houseHold['IPT']);
		unset($houseHold['InitTime']);

		$sql = "select * from tblLastmileHouseMember where HouseHoldID = {$houseHoldID}";
		$members = $this->db->query($sql)->result_array();

		array_walk($members, function (&$a, $k) {
			unset($a['InitTime']);
		});

		$rs = [
			'house' => $houseHold,
			'members' => $members
		];

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}

	private function getHouseMemeber($HouseHoldID)
	{
		$sql = "select * from tblLastmileHouseMember where HouseHoldID = {$HouseHoldID}";
		return $this->db->query($sql)->result_array();
	}

	private function deleteMember($houseID, array $members)
	{
		$oldMembers = $this->getHouseMemeber($houseID);
		$memberIDs = array_column($members, 'Rec_ID');
		$delMembers = notInArray($oldMembers, $memberIDs, 'Rec_ID');

		if ( empty( $delMembers ) ) return;

		$this->db->where_in('Rec_ID', array_column($delMembers, 'Rec_ID'));
		$this->db->delete('tblLastmileHouseMember');
	}
}