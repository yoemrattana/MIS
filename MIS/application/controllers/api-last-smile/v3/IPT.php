<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class IPT extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function form_get()
	{
		$houseHoldID = $this->get('house_hold_id');
		$month = $this->get('month');
		$month = str_pad($month, 2, '0', STR_PAD_LEFT);
		$year = $this->get('year');

		$sql = "select a.Rec_ID as HouseMemberID,b.Month, b.Year,a.Name, a.Age, a.Sex, IPTDate, DoNotUse, Date,
				a.HouseHoldID,NotEnterForest, SideEffect, NotSick, RefuseOtherReason,Absent from
				(
					select * from tblLastmileHouseMember where Sex = 'M' and Age between 15 and 49
				) as a
				left join
				(
					select * from tblLastmileIPT where HouseHoldID = {$houseHoldID} and Month = '{$month}' and Year = '{$year}'
				) as b on b.HouseMemberID = a.Rec_ID
				where a.HouseHoldID = {$houseHoldID}";

		$rs = $this->db->query($sql)->result();
		$data['IPT'] = $rs;
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
		$data = $data['IPT'];

		//if ( !isset( $data[0]['IPTDate'] ) ) return;

		$where = [
			'HouseHoldID'	=> $data[0]['HouseHoldID'],
			//'IPTDate'		=> date('Y-m-d', strtotime($data[0]['IPTDate'])) ,
			'Month' => str_pad($data[0]['Month'], 2, '0', STR_PAD_LEFT),
			'Year'  => $data[0]['Year'],
		];

		$this->db->delete('tblLastmileIPT', $where);

		foreach($data as $row){
			$row['IPTDate'] = date('Y-m-d', strtotime($row['IPTDate']));
            $row['Month'] = date('m', strtotime($row['IPTDate']));
			$row['Year'] = date('Y', strtotime($row['IPTDate']));
            //$row['Month'] = str_pad($row['Month'], 2, '0', STR_PAD_LEFT);
			//$row['Year'] = date('Y', strtotime($row['IPTDate']));
			$row['InitTime'] = sqlNow();
			$row['IsMobileEntry'] = 1;

			if( !isset( $row['Absent'] ) && $row['Absent'] == 'Yes' ) {
				$row['RefuseReason'] = '';
				$row['RefuseOtherReason'] = '';
				$row['DoNotUse'] = '';
				$row['SideEffect'] = '';
				$row['NotSick'] = '';
				$row['Date'] = '';
				$row['NotEnterForest'] = 'Yes';
			}

			if( !isset( $row['DoNotUse'] ) && $row['DoNotUse'] == 'Yes' ) {
				$row['RefuseReason'] = '';
				$row['RefuseOtherReason'] = '';
				$row['Absent'] = '';
				$row['SideEffect'] = '';
				$row['NotSick'] = '';
				$row['Date'] = '';
				$row['NotEnterForest'] = '';
			}

			if( $row['NotSick'] == 'Yes' && $row['SideEffect'] == 'Yes' ) {
				$row['RefuseReason'] = '';
				$row['RefuseOtherReason'] = '';
				$row['Absent'] = '';
				$row['Date'] = '';
				$row['NotEnterForest'] = '';
			}

			if( isset( $row['Date'] ) && !empty( $row['Date'] ) ) {
				$row['RefuseReason'] = '';
				$row['RefuseOtherReason'] = '';
				$row['Absent'] = '';
				$row['SideEffect'] = '';
				$row['NotSick'] = '';
			}

			if ( !isset( $row['Date'] ) ) $row['NotEnterForest'] = '';
			if( isset($row['houseLocalMonth']) ) unset( $row['houseLocalMonth'] );
			if( isset($row['houseLocalYear']) ) unset( $row['houseLocalYear'] );

			$this->db->insert('tblLastmileIPT', $row);
		}

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => []
		];

		$this->response($response);
	}

	public function tda_summary_get()
	{
		$houseHoldID = $this->get('house_hold_id');

		$sql = "with t as(
				select
				HouseHoldID,
				(select count(*) from tblLastmileHouseMember where HouseHoldID = 11 and TDA='Yes') as TotalTDA,
				sum(iif(Type = 1 and Date is not null, 1, 0)) as TDA1,
				sum(iif(Type = 1 and Reject = 'Yes', 1, 0)) as RejectTDA1,
				sum(iif(Type = 2 and Date is not null, 1, 0)) as TDA2,
				sum(iif(Type = 2 and Reject = 'Yes', 1, 0)) as RejectTDA2
				from tblLastmileTDA as a
				group by HouseHoldID
			)

			select a.HouseNumber, a.TotalMember, c.LLINLack,c.LLINOffer,c.LLIHNLack,c.LLIHNOffer,
			b.TotalTDA, b.RejectTDA1, b.TDA1, b.RejectTDA2, b.TDA2
			from tblLastmileHouseHold as a
			left join t as b on b.HouseHoldID = a.Rec_ID
			left join tblLastmileTDANet as c on c.HouseHoldID= b.HouseHoldID
			where a.Rec_ID = {$houseHoldID}";

		$data['TDA'] = $this->db->query($sql)->row();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
	}

	public function ipt_summary_get()
	{
		$houseID = $this->get('house_hold_id');
		//$month = $this->get('month');
		//$month = str_pad($month, 2, '0', STR_PAD_LEFT);
		//$year = $this->get('year');
		$ipt_date = $this->get('ipt_date');

		$sql = "with t as
				(
					select IPTDate, HouseHoldID,
						sum(iif(DoNotUse = 'Yes', 1, 0)) as DoNotUse,
						sum(iif(Reject = 'Yes', 1, 0)) as Reject,
						sum(iif(Date is not null and Date <> '', 1, 0)) as IPT,
						sum(iif(W1 = 'Yes', 1, 0)) as W1,
						sum(iif(W2 = 'Yes', 1, 0)) as W2,
						sum(iif(W3 = 'Yes', 1, 0)) as W3,
						sum(iif(W4 = 'Yes', 1, 0)) as W4
					from tblLastmileIPT
					where IPTDate = '{$ipt_date}'
					group by IPTDate, Month , Year, HouseHoldID
				)

				select b.* from tblLastmileHouseHold as a
				left join
				(
					select * from t
				) as b on a.Rec_ID = b.HouseHoldID where b.HouseHoldID = '{$houseID}'";

		$data = $this->db->query($sql)->row();

		$response = [
			"code" => 200,
			"message" => "success",
			"data" => $data
		];

		$this->response($response);
	}
}