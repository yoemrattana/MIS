<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LastmileData extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['Lastmile'])) redirect('Home');

		$data['title'] = 'Last Mile Data';
		$data['main'] = 'lastmile_data_view';

		$this->load->view('layoutV3', $data);
	}

	public function getPreData()
	{
		$sql = "select distinct a.Code_Prov_T as code, a.Name_Prov_E as name from tblProvince as a
				join tblHFCodes as b on a.Code_Prov_T = b.Code_Prov_N
				join tblCensusVillage as c on b.Code_Facility_T = c.HCCode
				where c.IsLastmile = 1";
		$rs['pv'] = $this->db->query( $sql )->result();

		$sql = "select distinct Code_OD_T as code, Name_OD_E as name, a.Code_Prov_N as pvcode
                from tblHFCodes as a join tblCensusVillage as b on a.Code_Facility_T = b.HCCode
                where IsLastmile = 1 order by name";
		$rs['od'] = $this->db->query( $sql )->result();

		$sql = "select distinct Code_Facility_T as code, Name_Facility_E as name, Code_OD_T as od
                from tblHFCodes as a join tblCensusVillage as b on a.Code_Facility_T = b.HCCode
                where IsLastmile = 1 order by name";
		$rs['hc'] = $this->db->query( $sql )->result();

		$sql = "select Code_Vill_T as code, Name_Vill_E as name, HCCode as hccode
				from tblCensusVillage
				where IsLastmile = 1";
		$rs['vl'] = $this->db->query( $sql )->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getData()
	{
		$province = $this->input->post('province');

		if ( $province ) $where = " and Code_Prov_N = '{$province}'";
		else $where = " and 1=1";

		$sql = "select a.Rec_ID, a.Month, a.Year, a.Code_Vill_T, b.Name_Vill_E,
				Code_Facility_T, Name_Facility_E, Code_OD_T, Name_OD_E,
				Code_Prov_N, Name_Prov_E, HouseNumber, HouseHolder
				from tblLastmileHouseHold as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				where IsLastmile=1 and c.IsTarget = 1 $where
				order by Code_Prov_N";

		$rs = $this->db->query( $sql )->result();

		$this->output->set_output( json_encode( $rs ) );
	}

	public function getHouse()
	{
		$houseId = $this->input->post('house_id');

		$sql = "select * from tblLastmileHouseHold where Rec_ID = {$houseId}";

		$rs['house'] = $this->db->query($sql)->row();

		$sql = "select * from tblLastmileHouseMember where HouseHoldID = {$houseId}";
		$rs['members'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getTda()
	{
		$houseId = $this->input->post('house_id');

		$sql = "select a.HouseHoldID, DoNotUse, Reject,RejectReason, SideEffect, Absent, Type, Date, a.Rec_ID as HouseMemberID,
					iif(TDA = 'Yes', 1, 0) as IsTDA from
				(
					select * from tblLastmileHouseMember
				) as a
				left join (
					select * from tblLastmileTDA where Type = 1
				) as b on a.Rec_ID = b.HouseMemberID
				where a.HouseHoldID = {$houseId} order by HouseMemberID";

		$rs['tda1'] = $this->db->query($sql)->result();

		$sql = "select a.HouseHoldID, DoNotUse, Reject,RejectReason, SideEffect, Absent, Type, Date, a.Rec_ID as HouseMemberID,
					iif(TDA = 'Yes', 1, 0) as IsTDA from
				(
					select * from tblLastmileHouseMember
				) as a
				left join (
					select * from tblLastmileTDA where Type = 2
				) as b on a.Rec_ID = b.HouseMemberID
				where a.HouseHoldID = {$houseId} order by HouseMemberID";

		$rs['tda2'] = $this->db->query($sql)->result();

		$sql = "select a.Rec_ID as HouseHoldID, a.HouseNumber, a.TotalMember,
				b.Rec_ID, a.LLINLack,isnull(b.LLINOffer, 0) as LLINOffer,a.LLIHNLack,isnull(LLIHNOffer, 0) as LLIHNOffer
				from
				(
					select * from tblLastmileHouseHold
				) as a
				left join (
					select * from tblLastmileTDANet
				) as b on a.Rec_ID = b.HouseHoldID
				where a.Rec_ID = {$houseId}";

		$rs['net'] = $this->db->query($sql)->row();

		$sql = "with t1 as
				(
					select * from tblLastmileTDA where HouseHoldID = {$houseId} and Type = 1
				)
				,
				t2 as
				(
					select * from tblLastmileTDA where HouseHoldID = {$houseId} and Type = 2
				)

				select (select count(*) from tblLastmileHouseMember where HouseHoldID = {$houseId} and TDA='Yes') as TotalTDA,
				ISNULL(sum(iif(t1.Date is not null or t1.Date <> '', 1, 0)), 0) as TDA1,
				ISNULL(sum(iif(t1.Reject = 'Yes', 1, 0)), 0) as RejectTDA1,
				ISNULL(sum(iif(t2.Date is not null or t2.Date <> '', 1, 0)), 0) as TDA2,
				ISNULL(sum(iif(t2.Reject = 'Yes', 1, 0)), 0) as RejectTDA2
				from t1
				left join t2 on t1.HouseMemberID = t2.HouseMemberID";

		$rs['summary'] = $this->db->query($sql)->row();

		$this->output->set_output(json_encode($rs));
	}

	public function getIpt()
	{
		$houseId = $this->input->post('house_id');

		$sql = "select distinct IPTDate from tblLastmileIPT where HouseHoldID = {$houseId}";
		$iptDates = $this->db->query( $sql )->result_array();

		$ipts = [];
		foreach ( $iptDates as $date ) {
			//if ( empty( $date['IPTDate'] ) ) continue;
			$sql = "select a.Rec_ID as HouseMemberID, Month, Year, DoNotUse,Reject,Date,
					W1,W2,W3,W4,W1Specie,W2Specie,W3Specie,W4Specie,Absent,NotEnterForest,RefuseReason,
					a.HouseHoldID, iif(a.IPT = 'Yes' ,1,0) as IsIPT, IPTDate from
					(
						select * from tblLastmileHouseMember
					) as a
					left join
					(
						select * from tblLastmileIPT where IPTDate = '{$date['IPTDate']}' and HouseHoldID = {$houseId}
					) as b on b.HouseMemberID = a.Rec_ID
					where a.HouseHoldID = {$houseId}";

			$ipt = $this->db->query( $sql )->result();
			array_push($ipts, $ipt);
		}

		$rs['ipts'] = $ipts;

		$this->output->set_output(json_encode($rs));
	}

	public function getAfs()
	{
		$houseId = $this->input->post('house_id');

		$sql = "select distinct AFSDate from tblLastmileAFS where HouseHoldID = {$houseId}";
		$afsDates = $this->db->query($sql)->result_array();

		$afses = [];
		foreach( $afsDates as $date ) {
			$sql = "select a.Rec_ID as HouseMemberID, Month, Year,
					W1,W2,W3,W4,W1Specie,W2Specie,W3Specie,W4Specie,
					a.HouseHoldID, AFSDate from
					(
						select * from tblLastmileHouseMember
					) as a
					left join
					(
						select * from tblLastmileAFS where AFSDate = '{$date['AFSDate']}' and HouseHoldID = {$houseId}
					) as b on b.HouseMemberID = a.Rec_ID
					where a.HouseHoldID = {$houseId}";

			$afs = $this->db->query( $sql )->result();
			array_push($afses, $afs);
		}

		$rs['afses'] = $afses;

		$this->output->set_output(json_encode($rs));
	}

}