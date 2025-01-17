<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class TDA extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function form_get()
	{
		$houseHoldID = $this->get('house_hold_id');
		$type = $this->get('type');
		//$month = $this->get('month');
		//$month = str_pad($month, 2, '0', STR_PAD_LEFT);
		//$year = $this->get('year');
		//$tda_date = $this->get('tda_date');

		$sql = "select TDADate, a.HouseHoldID,a.Rec_ID as HouseMemberID, a.Name, a.Age, a.Sex,
				DoNotUse, SideEffect, NotSick, RejectOtherReason, Absent, Type, Date,
					iif(TDA = 'Yes', 1, 0) as IsTDA from
				(
					select * from tblLastmileHouseMember where TDA = 'Yes'
				) as a
				left join (
					select * from tblLastmileTDA where Type = {$type}
				) as b on a.Rec_ID = b.HouseMemberID
				where a.HouseHoldID = {$houseHoldID}" ;

		$rs = $this->db->query($sql)->result();
		$data['TDA'] = $rs;

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
	}

	public function net_distribute_form_get()
	{
		$houseHoldID = $this->get('house_hold_id');

		$sql = "select a.Rec_ID as HouseHoldID, a.HouseNumber, a.TotalMember, b.Rec_ID, a.LLINLack,b.LLINOffer, a.LLIHNLack,LLIHNOffer from
				(
					select * from tblLastmileHouseHold
				) as a
				left join (
					select * from tblLastmileTDANet
				) as b on a.Rec_ID = b.HouseHoldID
				where a.Rec_ID = {$houseHoldID}";

		$rs = $this->db->query($sql)->row();
		$data['net_distribute'] = $rs;

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
		$data = $data['TDA'];

		if ( !isset( $data[0]['TDADate'] ) ) return;

		$where = ['HouseHoldID' => $data[0]['HouseHoldID'], 'Type' => $data[0]['Type']];

		$this->db->delete('tblLastmileTDA', $where);

		foreach( $data as $row ) {
			$row['TDADate'] = date('Y-m-d', strtotime($row['TDADate']));
			$row['Month'] = date('m', strtotime($row['TDADate']));
			$row['Year'] = date('Y', strtotime($row['TDADate']));
			$row['Date'] = empty($row['Date']) ? NULL : $row['Date'];
			$row['InitTime'] = sqlNow();
			$row['IsMobileEntry'] = 1;

			if( isset($row['houseLocalMonth']) ) unset( $row['houseLocalMonth'] );
			if( isset($row['houseLocalYear']) ) unset( $row['houseLocalYear'] );

			$this->db->insert('tblLastmileTDA', $row);
		}

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);
	}

	public function net_distribute_post()
	{
		$data = $this->post();
		$data = $data['net'];

		if ( isset( $data['Rec_ID'] ) && !empty( $data['Rec_ID'] ) ) {
			$where['Rec_ID'] = $data['Rec_ID'];
			unset($data['Rec_ID']);
			$this->db->update('tblLastmileTDANet', $data, $where);
		} else {
			unset($data['Rec_ID']);
			$this->db->insert('tblLastmileTDANet', $data);
		}

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);
	}

	public function summary_get()
	{
		$houseHoldID = $this->get('house_hold_id');

		$sql = "with t1 as
				(
					select * from tblLastmileTDA where HouseHoldID = {$houseHoldID} and Type = 1
				)
				,
				t2 as
				(
					select * from tblLastmileTDA where HouseHoldID = {$houseHoldID} and Type = 2
				)

				select (select count(*) from tblLastmileHouseMember where HouseHoldID = {$houseHoldID} and TDA='Yes') as TotalTDA,
				ISNULL(sum(iif(t1.Date is not null or t1.Date <> '', 1, 0)), 0) as TDA1,
				ISNULL(sum(iif(t1.SideEffect = 'Yes', 1, 0)), 0) as SideEffectTDA1,
				ISNULL(sum(iif(t1.NotSick = 'Yes', 1, 0)), 0) as NotSickTDA1,
				ISNULL(sum(iif(t1.RejectOtherReason <> '', 1, 0)), 0) as OtherTDA1,
				ISNULL(sum(iif(t1.DoNotUse = 'Yes',1, 0)),0) as DoNotUseTDA1,
				ISNULL(sum(iif(t1.Absent = 'Yes',1, 0)),0) as AbsentTDA1,
				ISNULL(sum(iif(t2.Date is not null or t2.Date <> '', 1, 0)), 0) as TDA2,
				ISNULL(sum(iif(t2.SideEffect = 'Yes', 1, 0)), 0) as SideEffectTDA2,
				ISNULL(sum(iif(t2.NotSick = 'Yes', 1, 0)), 0) as NotSickTDA2,
				ISNULL(sum(iif(t2.RejectOtherReason <> '', 1, 0)), 0) as OtherTDA2,
				ISNULL(sum(iif(t2.DoNotUse = 'Yes',1, 0)),0) as DoNotUseTDA2,
				ISNULL(sum(iif(t2.Absent = 'Yes',1, 0)),0) as AbsentTDA2
				from t1
				left join t2 on t1.HouseMemberID = t2.HouseMemberID";

		$rs = $this->db->query($sql)->result();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $rs
		];

		$this->response($response);
	}
}