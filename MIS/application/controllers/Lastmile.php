<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lastmile extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['Lastmile'])) redirect('Home');

		$data['title'] = 'Last Mile';
		$data['main'] = 'lastmile_view';

		$this->load->view('layoutV3', $data);
	}

	public function getPreData()
	{
		$prov = $this->input->post('prov');

		$where = "Code_Prov_N = '$prov'";
		if ($_SESSION['role'] == 'OD') {
			$code_od = $_SESSION['code_od'];
			$where = "Code_OD_T = '$code_od'";
		}

		$sql = "select distinct Code_OD_T as code, Name_OD_E as name
                from tblHFCodes as a join tblCensusVillage as b on a.Code_Facility_T = b.HCCode
                where IsLastmile = 1 and $where order by name";
		$rs['od'] = $this->db->query($sql)->result();

		$sql = "select distinct Code_Facility_T as code, Name_Facility_E as name, Code_OD_T as od
                from tblHFCodes as a join tblCensusVillage as b on a.Code_Facility_T = b.HCCode
                where IsLastmile = 1 and $where order by name";
		$rs['hc'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getReport()
	{
		$hc = $this->input->post('hc');

		$sql = "select Code_Vill_T, Name_Vill_E, Name_Vill_K, IsLastmile
				from tblCensusVillage
				where HCCode = '{$hc}' and IsLastmile = 1
				order by Name_Vill_E";
		$rs['vmws'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	/*
	 * House hold
	 * */

	public function getHouses()
	{
		$village_code = $this->input->post('vl');

		$sql = "select a.*,
					(select min(TDADate) from tblLastmileTDA where Type = 1 and HouseHoldID = a.Rec_ID) as TDA1,
					(select min(TDADate) from tblLastmileTDA where Type = 2 and HouseHoldID = a.Rec_ID) as TDA2,
					(stuff((select distinct ',' + cast(b.IPTDate as varchar(100))
								from tblLastmileIPT as b
								where b.HouseHoldID = a.Rec_ID
								for xml path('')), 1, 1, '')) as IPT,
                    (stuff((select distinct ',' + cast(b.AFSDate as varchar(100))
                    from tblLastmileAFS as b
                    where b.HouseHoldID = a.Rec_ID
                    for xml path('')), 1, 1, '')) as AFS
				from tblLastmileHouseHold as a
				where Code_Vill_T = '{$village_code}' order by a.HouseNumber";

		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
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

	public function saveHouse()
	{
		$submit = json_decode($this->input->post('submit'));
		$house = $submit->house;
		$members = $submit->members;

		$house->Code_Vill_T = $submit->village;

		$houseId = $house->Rec_ID;

		$house->InitTime = sqlNow();
		$house->InitUser = $_SESSION['username'];
		$house->IsMobileEntry = 0;

		unset( $house->Rec_ID, $house->h, $house->vl );
		if(empty($houseId)) {
			$this->db->insert('tblLastmileHouseHold', $house);
			$houseId = $this->db->insert_id();
		} else {
			$this->db->update('tblLastmileHouseHold', $house, ['Rec_ID' => $houseId]);
		}

		if ( $house->HasMemberAtHome == 'No' ) {
			$this->db->delete('tblLastmileHouseMember', ['HouseHoldID' => $houseId]);
			return;
		}

		foreach($members as $member) {
			$member->HouseHoldID = $houseId;
			$recID = $member->Rec_ID;
			unset($member->Rec_ID);
			if ($recID > 0) {
				$this->db->update('tblLastmileHouseMember', $member, ['Rec_ID' => $recID]);
			} elseif ($recID < 0) {
				$this->db->delete('tblLastmileHouseMember', ['Rec_ID' => $recID * -1]);
			} else {
				$member->InitTime = sqlNow();
				$this->db->insert('tblLastmileHouseMember', $member);
			}
		}

	}

	public function deleteHouse()
	{
		$submit = json_decode($this->input->post('submit'));
        $this->load->model('Log_model');
        $this->Log_model->deleteLastmileHouse($submit->Rec_ID);
		$where = ['Rec_ID' => $submit->Rec_ID];
		$this->db->delete('tblLastmileHouseHold', $where);
	}

	/*
	 * TDA
	 *
	 * */
	public function getTDA()
	{
		$houseId = $this->input->post('house_id');
		$type = $this->input->post('type');

		$sql = "select TDADate from tblLastmileTDA where HouseHoldID = {$houseId} and Type = {$type}";
		$rs['tdaDate'] = $this->db->query($sql)->row_array()['TDADate'];

		$sql = "select a.HouseHoldID, DoNotUse, SideEffect, NotSick,RejectOtherReason, Absent, {$type} as Type, Date, a.Rec_ID as HouseMemberID,
					iif(TDA = 'Yes', 1, 0) as IsTDA from
				(
					select * from tblLastmileHouseMember
				) as a
				left join (
					select * from tblLastmileTDA where Type = {$type}
				) as b on a.Rec_ID = b.HouseMemberID
				where a.HouseHoldID = {$houseId} order by HouseMemberID";

		$rs['TDA'] = $this->db->query($sql)->result();

		$sql = "select a.Rec_ID as HouseHoldID, a.HouseNumber, a.TotalMember, b.Rec_ID, a.LLINLack,b.LLINOffer,a.LLIHNLack,LLIHNOffer from
				(
					select * from tblLastmileHouseHold
				) as a
				left join (
					select * from tblLastmileTDANet
				) as b on a.Rec_ID = b.HouseHoldID
				where a.Rec_ID = {$houseId}";

		$rs['net'] = $this->db->query($sql)->row();

		//$sql = "select (select count(*) from tblLastmileHouseMember where HouseHoldID = {$houseId} and TDA='Yes') as TotalTDA,
		//        sum(iif(Type = 1 and Date is not null, 1, 0)) as TDA1,
		//        sum(iif(Type = 1 and Reject = 'Yes', 1, 0)) as RejectTDA1,
		//        sum(iif(Type = 2 and Date is not null, 1, 0)) as TDA2,
		//        sum(iif(Type = 2 and Reject = 'Yes', 1, 0)) as RejectTDA2
		//        from tblLastmileTDA where HouseHoldID = {$houseId}";

		//$rs['summary'] = $this->db->query($sql)->row();

		$this->output->set_output(json_encode($rs));
	}

	public function saveTDA()
	{
		$submit = json_decode($this->input->post('submit'));
		$TDADate = $submit->TDADate;
		$TDAs = $submit->TDA;
		$net = $submit->net;
		$type = $submit->type;

		$month = date('m', strtotime($TDADate));
		$year = date('Y', strtotime($TDADate));

		foreach($TDAs as $TDA){
			unset($TDA->IsTDA);
			$TDA->Type = $type;
			$TDA->TDADate = $TDADate;
			$TDA->Month = $month;
			$TDA->Year = $year;
			$TDA->InitTime = sqlNow();
			$TDA->InitUser = $_SESSION['username'];
			$TDA->IsMobileEntry = 0;

			$this->db->delete('tblLastmileTDA', ['HouseMemberID' => $TDA->HouseMemberID, 'Type' => $type]);
			$this->db->insert('tblLastmileTDA', $TDA);
		}

		$where['Rec_ID'] = $net->Rec_ID;
		unset($net->HouseNumber);
		unset($net->TotalMember);
		unset($net->Rec_ID);

		if(empty($where['Rec_ID'])){
			$this->db->insert('tblLastmileTDAnet', $net);
		} else {
			$this->db->update('tblLastmileTDAnet', $net, $where);
		}
	}

	public function deleteTDA()
	{
		$submit = json_decode($this->input->post('submit'));

        $this->load->model('Log_model');
        $this->Log_model->deleteTDA($submit->tda, $submit->house_id);

		$where = ['Type' => $submit->tda, 'HouseHoldID' => $submit->house_id];
		$this->db->delete('tblLastmileTDA', $where);
	}

	/*
	 * IPT
	 *
	 * */
	public function getIPT()
	{
		$houseID = $this->input->post('house_id');
		$iptDate = $this->input->post('ipt_date');

		$sql = "select b.Rec_ID as IptRec_ID, a.Rec_ID as HouseMemberID, Month, Year, DoNotUse,SideEffect,NotSick,Date,
				Absent,NotEnterForest,RefuseOtherReason,
				a.HouseHoldID, iif(a.Sex = 'M' and a.Age between 15 and 49,1,0) as IsIPT from
				(
					select * from tblLastmileHouseMember
				) as a
				left join
				(
					select * from tblLastmileIPT where IPTDate = '{$iptDate}' and HouseHoldID = {$houseID}
				) as b on b.HouseMemberID = a.Rec_ID
				where a.HouseHoldID = {$houseID} order by a.Rec_ID";
		$rs['IPT'] = $this->db->query($sql)->result();

		$sql = "with t as(
				select
				HouseHoldID,
				(select count(*) from tblLastmileHouseMember where HouseHoldID = {$houseID} and TDA='Yes') as TotalTDA,
				sum(iif(Type = 1 and Date is not null, 1, 0)) as TDA1,
				sum(iif(Type = 1 and Reject = 'Yes', 1, 0)) as RejectTDA1,
				sum(iif(Type = 2 and Date is not null, 1, 0)) as TDA2,
				sum(iif(Type = 2 and Reject = 'Yes', 1, 0)) as RejectTDA2
				from tblLastmileTDA as a
				group by HouseHoldID
			)

			select c.HouseNumber,c.TotalMember, a.LLINLack,a.LLINOffer,a.LLIHNLack,a.LLIHNOffer,
			b.TotalTDA, b.RejectTDA1, b.TDA1, b.RejectTDA2, b.TDA2
			from tblLastmileTDANet as a
			join t as b on b.HouseHoldID = a.HouseHoldID
			join tblLastmileHouseHold as c on c.Rec_ID = b.HouseHoldID
			where a.HouseHoldID = {$houseID}";

		$rs['TDA'] = $this->db->query($sql)->row();

		//$sql = "with t as
		//        (
		//            select Month as Month, Year as Year, HouseHoldID as HouseHoldID,
		//                sum(iif(DoNotUse = 'Yes', 1, 0)) as DoNotUse,
		//                sum(iif(Reject = 'Yes', 1, 0)) as Reject,
		//                sum(iif(Date is not null and Date <> '', 1, 0)) as IPT,
		//                sum(iif(W1 = 'Yes', 1, 0)) as W1,
		//                sum(iif(W2 = 'Yes', 1, 0)) as W2,
		//                sum(iif(W3 = 'Yes', 1, 0)) as W3,
		//                sum(iif(W4 = 'Yes', 1, 0)) as W4
		//            from tblLastmileIPT
		//            where Month = '{$month}' and Year = {$year}
		//            group by  Month , Year, HouseHoldID
		//        )

		//        select a.HouseNumber,a.TotalForestEntry, b.* from tblLastmileHouseHold as a
		//        left join
		//        (
		//            select * from t
		//        ) as b on a.Rec_ID = b.HouseHoldID where b.HouseHoldID = '{$houseID}'";

		//$rs['IPTsummary'] = $this->db->query($sql)->row();

		$this->output->set_output(json_encode($rs));
	}

	public function getIPTDate()
	{
		$houseID = $this->input->post('house_id');

		$sql = "select distinct IPTDate from tblLastmileIPT where HouseHoldID = {$houseID}";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveIPT()
	{
		$submit = json_decode($this->input->post('submit'));
		$IPTs = $submit->IPT;
		$IPTDate = $submit->IPTDate;
		$month = date('m', strtotime($IPTDate));
		$year  = date('Y', strtotime($IPTDate));

		foreach($IPTs as $IPT){
			unset($IPT->IsIPT);
			$IPT->IPTDate = $IPTDate;
			$IPT->Month = $month;
			$IPT->Year = $year;

			$IPT->InitTime = sqlNow();
			$IPT->InitUser = $_SESSION['username'];
			$IPT->IsMobileEntry = 0;
			$this->db->delete('tblLastmileIPT', ['Rec_ID' => $IPT->Rec_ID]);
            unset($IPT->Rec_ID);
			$this->db->insert('tblLastmileIPT', $IPT);
		}
	}

	public function deleteIPT()
	{
		$submit = json_decode($this->input->post('submit'));

        $this->load->model('Log_model');
        $this->Log_model->deleteIPT($submit->ipt_date, $submit->house_id);

		$where = ['IPTDate' => $submit->ipt_date, 'HouseHoldID' => $submit->house_id];
		$this->db->delete('tblLastmileIPT', $where);
	}

	/*
	 * AFS
	 *
	 * */
	public function getAFSDate()
	{
		$houseID = $this->input->post('house_id');

		$sql = "select distinct AFSDate from tblLastmileAFS where HouseHoldID = {$houseID}";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getAFS() {
		$houseID = $this->input->post('house_id');
		$afsDate = $this->input->post('afs_date');

		$sql = "select a.Rec_ID as HouseMemberID, Month, Year,
				W1,W2,W3,W4,W5,W1Specie,W2Specie,W3Specie,W4Specie,
				a.HouseHoldID from
				(
					select * from tblLastmileHouseMember
				) as a
				left join
				(
					select * from tblLastmileAFS where AFSDate = '{$afsDate}' and HouseHoldID = {$houseID}
				) as b on b.HouseMemberID = a.Rec_ID
				where a.HouseHoldID = {$houseID} order by a.Rec_ID";
		$rs['AFS'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveAFS()
	{
		$submit = json_decode($this->input->post('submit'));
		$AFSs = $submit->AFS;
		$AFSDate = $submit->AFSDate;
		$month = date('m', strtotime($AFSDate));
		$year  = date('Y', strtotime($AFSDate));

		foreach($AFSs as $AFS){
			$AFS->AFSDate = $AFSDate;
			$AFS->Month = $month;
			$AFS->Year = $year;

			$AFS->InitTime = sqlNow();
			$AFS->InitUser = $_SESSION['username'];
			$AFS->IsMobileEntry = 0;

			$this->db->delete('tblLastmileAFS', ['HouseMemberID' => $AFS->HouseMemberID, 'AFSDate' => $AFS->AFSDate ]);
			$this->db->insert('tblLastmileAFS', $AFS);
		}
	}

	public function deleteAFS()
	{
		$submit = json_decode($this->input->post('submit'));


        $this->load->model('Log_model');
        $this->Log_model->deleteAFS($submit->afs_date, $submit->house_id);

		$where = ['AFSDate' => $submit->afs_date, 'HouseHoldID' => $submit->house_id];
		$this->db->delete('tblLastmileAFS', $where);
	}

	/*
	 *summary village
	 *
	 */

	public function getVillSummary()
	{
		$village = $this->input->post('village');

		$sql = "select Name_Vill_K ,Name_Facility_K, Name_OD_K, Investigator
					  ,Phone ,FociInvestigationDate ,a.Lat ,a.Long ,R1 ,V1
				from tblFociInvestigation as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T where a.Code_Vill_T = '{$village}'";

		$row = $this->db->query($sql)->row();

		$rs['village'] = $row;

		$sql = "with t as
				(
					select (select count(*) from tblLastmileHouseMember where tblLastmileHouseMember.HouseHoldID = tblLastmileTDA.HouseHoldID and TDA='Yes') as TotalTDA,
					sum(iif(Type = 1 and Date is not null, 1, 0)) as TDA1,
					sum(iif(Type = 1 and Reject = 'Yes', 1, 0)) as RejectTDA1,
					sum(iif(Type = 2 and Date is not null, 1, 0)) as TDA2,
					sum(iif(Type = 2 and Reject = 'Yes', 1, 0)) as RejectTDA2,
					HouseHoldID
					from tblLastmileTDA
					group by tblLastmileTDA.HouseHoldID
				)

				select Code_Vill_T, HouseNumber, TotalMember,
				b.LLINLack, b.LLINOffer, b.LLIHNLack, b.LLIHNOffer,
				t.TotalTDA, t.TDA1, t.RejectTDA1, t.TDA2, t.RejectTDA2
				from tblLastmileHouseHold as a
				left join tblLastmileTDANet as b on a.Rec_ID = b.HouseHoldID
				left join t on t.HouseHoldID = a.Rec_ID
				where Code_Vill_T = '{$village}'";

		$rs['TDA'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getVillIPT()
	{
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$village = $this->input->post('village');

		$sql = "with t as
				(
					select Month as Month, Year as Year, HouseHoldID as HouseHoldID,
						sum(iif(DoNotUse = 'Yes', 1, 0)) as DoNotUse,
						sum(iif(Reject = 'Yes', 1, 0)) as Reject,
						sum(iif(Date is not null and Date <> '', 1, 0)) as IPT,
						sum(iif(W1 = 'Yes', 1, 0)) as W1,
						sum(iif(W2 = 'Yes', 1, 0)) as W2,
						sum(iif(W3 = 'Yes', 1, 0)) as W3,
						sum(iif(W4 = 'Yes', 1, 0)) as W4
					from tblLastmileIPT
					where Month = '{$month}' and Year = {$year}
					group by  Month , Year, HouseHoldID
				)

				select a.HouseNumber,a.TotalForestEntry, b.* from tblLastmileHouseHold as a
				left join
				(
					select * from t
				) as b on a.Rec_ID = b.HouseHoldID where Code_Vill_T = '{$village}'";

		$rs = $this->db->query($sql)->result_array();

		$this->output->set_output(json_encode($rs));
	}

	public function getTDASummary()
	{
		$village = $this->input->post('vl');
        $year = $this->input->post('year');
        $month = $this->input->post('month');

        $where = '';
        if (!empty($year)) $where .= ' and year = ' . $year;
        if (!empty($year) && !empty($month)) $where .= ' and month = ' . $month;

		$sql = "WITH T as (
			select Code_Vill_T, a.Rec_ID, HouseNumber, TotalMember, LLIN, LLINLack, LLIHN, LLIHNLack, sum(iif(b.TDA = 'Yes', 1,0)) as TDA
			from tblLastmileHouseHold as a
			left join tblLastmileHouseMember as b on a.Rec_ID = b.HouseHoldID
			group by a.Rec_ID, Code_Vill_T, HouseNumber, TotalMember, LLIN, LLINLack, LLIHN, LLIHNLack
		),
		T2 as (
			select HouseHoldID,
			sum(iif(Date is not null and Date <> '' and Type = 1,1,0)) as TDA1Received,
			sum(iif(DoNotUse = 'Yes' and Type = 1, 1, 0)) as TDA1DoNotUse,
			sum(iif(SideEffect = 'Yes' and Type = 1,1,0)) as TDA1SideEffect,
			sum(iif(NotSick = 'Yes' and Type = 1,1,0)) as TDA1NotSick,
			sum(iif(RejectOtherReason is not null and RejectOtherReason <> '' and Type = 1,1,0)) as TDA1OtherReason,
			sum(iif(Absent = 'Yes' and Type = 1,1,0)) as TDA1Absent,

			sum(iif(Date is not null and Date <> '' and Type = 2,1,0)) as TDA2Received,
			sum(iif(DoNotUse = 'Yes' and Type = 2, 1, 0)) as TDA2DoNotUse,
			sum(iif(SideEffect = 'Yes' and Type = 2,1,0)) as TDA2SideEffect,
			sum(iif(NotSick = 'Yes' and Type = 2,1,0)) as TDA2NotSick,
			sum(iif(RejectOtherReason is not null and RejectOtherReason <> '' and Type = 2,1,0)) as TDA2OtherReason,
			sum(iif(Absent = 'Yes' and Type = 2,1,0)) as TDA2Absent
			from tblLastmileTDA
            where 1 = 1 $where
			group by HouseHoldID
		)

		select *
		from T
		left join T2 on T.Rec_ID = T2.HouseHoldID
		where Code_Vill_T = '{$village}' order by HouseNumber";

		$rs = $this->db->query( $sql )->result_array();

		array_walk($rs, function (&$a, $k) {
			unset($a['Code_Vill_T'], $a['Rec_ID']);
		});

		$this->output->set_output( json_encode( $rs ) );
	}

	public function getIPTSummary()
	{
		$village = $this->input->post('vl');
        $year = $this->input->post('year');
        $month = $this->input->post('month');

        $where = '';
        if (!empty($year)) $where .= ' and year = ' . $year;
        if (!empty($year) && !empty($month)) $where .= ' and month = ' . $month;

		$sql = "WITH T as (
					select Code_Vill_T, a.Rec_ID, HouseNumber, TotalMember
					from tblLastmileHouseHold as a
					left join tblLastmileHouseMember as b on a.Rec_ID = b.HouseHoldID
					group by a.Rec_ID, Code_Vill_T, HouseNumber, TotalMember, LLIN, LLINLack, LLIHN, LLIHNLack
				),
				T2 as (
					select HouseHoldID,
						sum(iif(Date is not null and Date <> '' ,1,0)) as Received,
						sum(iif(DoNotUse = 'Yes' , 1, 0)) as DoNotUse,
						sum(iif(SideEffect = 'Yes' ,1,0)) as SideEffect,
						sum(iif(NotSick = 'Yes' ,1,0)) as NotSick,
						sum(iif(RefuseOtherReason is not null and RefuseOtherReason <> '' ,1,0)) as OtherReason,
						sum(iif(Absent = 'Yes' ,1,0)) as Absent,
						sum(iif(NotEnterForest = 'Yes' ,1,0)) as NotEnterForest,
						sum(iif(NotEnterForest = 'No' ,1,0)) as EnterForest
					from tblLastmileIPT
                    where 1 = 1 $where
					group by HouseHoldID
				),
				T3 as (
					select HouseHoldID,
						sum(iif(W1='N/A',1,0)) as W1Absent,
						sum(iif(W1='Yes',1,0)) as W1Tested,
						sum(iif(W1='No',1,0)) as W1NotTested,
						sum(iif(W2='N/A',1,0)) as W2Absent,
						sum(iif(W2='Yes',1,0)) as W2Tested,
						sum(iif(W2='No',1,0)) as  W2NotTested,
						sum(iif(W3='N/A',1,0)) as W3Absent,
						sum(iif(W3='Yes',1,0)) as W3Tested,
						sum(iif(W3='No',1,0)) as  W3NotTested,
						sum(iif(W4='N/A',1,0)) as W4Absent,
						sum(iif(W4='Yes',1,0)) as W4Tested,
						sum(iif(W4='No',1,0)) as  W4NotTested
					from tblLastmileAFS
                    where 1 = 1 $where
					group by HouseHoldID
				)

				select * from T
				left join T2 on T.Rec_ID = T2.HouseHoldID
				left join T3 on T.Rec_ID = T3.HouseHoldID
				where Code_Vill_T = '{$village}' order by HouseNumber";

		$rs = $this->db->query( $sql )->result();
		$this->output->set_output( json_encode( $rs ) );
	}
}