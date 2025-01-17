<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CaseReport extends MY_Controller
{
	public function hf()
	{
        if (!isset($_SESSION['permiss']['Health Center Data'])) redirect('Home');

		$data['title'] = "Health Facility Report";
		$data['main'] = 'hfcase_view';

		$this->load->view('layout', $data);
	}

    public function hfDataAccuracy()
    {
        if (!isset($_SESSION['permiss']['Health Center Data Accuracy'])) redirect('Home');

		$data['title'] = "Health Facility Data Accuracy Report";
		$data['main'] = 'hfdataaccuracy_view';

		$this->load->view('layout', $data);
    }

	public function vmw()
	{
		if($_SESSION['code_rg'] == '01') {

        } else {
            if (!isset($_SESSION['permiss']['VMW Data'])) redirect('Home');
        }
		$data['title'] = "VMW Report";
		$data['main'] = 'vmwcase_view';

		$this->load->view('layout', $data);
	}

    public function vmwDataAccuracy(){
        if (!isset($_SESSION['permiss']['VMW Data Accuracy'])) redirect('Home');

        $data['title'] = 'VMW Data Accuracy';
        $data['main'] = 'vmwdataaccuracy_view';

        $this->load->vars($data);
        $this->load->view('layout', $data);
    }

	public function ppm()
	{
        if (!isset($_SESSION['permiss']['Private Sector Data'])) redirect('Home');

		$data['title'] = "PPM Report";
		$data['main'] = 'ppmcase_view';

		$this->load->view('layout', $data);
	}

	public function ml()
	{
        if (!isset($_SESSION['permiss']['MMP Data'])) redirect('Home');

		$data['title'] = "MMP Report";
		$data['main'] = 'mlcase_view';

		$this->load->view('layout', $data);
	}

	public function pl()
	{
        if (!isset($_SESSION['permiss']['Police Data'])) redirect('Home');

		$data['title'] = "Police Report";
		$data['main'] = 'plcase_view';

		$this->load->view('layout', $data);
	}

	public function bednet()
	{
        if (!isset($_SESSION['permiss']['Bed Net Data'])) redirect('Home');

		$data['title'] = "Bednet Report";
		$data['main'] = 'bednet_view';

		$this->load->view('layout', $data);
	}

	public function bednetother()
	{
        if (!isset($_SESSION['permiss']['Bed Net Other Data'])) redirect('Home');

		$data['title'] = "Bednet Report";
		$data['main'] = 'bednetother_view';

		$this->load->view('layout', $data);
	}

	public function hfGetPreData()
	{
		$prov = $this->input->post('prov');

		$where = "Code_Prov_N = '$prov'";
		if ($_SESSION['code_od'] != '') {
			$code_od = $_SESSION['code_od'];
			$where = "Code_OD_T = '$code_od'";
		}

		$sql = "select distinct Code_OD_T as code, Name_OD_E as name, Name_OD_K as nameK
                from tblHFCodes as a
				left join tblHFActivity as b on a.Code_Facility_T = b.ID
                where $where and (IsTarget = 1 or b.ID is not null)
				order by name";
		$rs['od'] = $this->db->query($sql)->result();

		$sql = "select Treatment from tblTreatment where HF = 1 order by Treatment";
		$list = $this->db->query($sql)->result();
		$rs['treatmentList'] = array_column($list, 'Treatment');

		$this->output->set_output(json_encode($rs));
	}

    public function vmwGetPreData()
	{
		$prov = $this->input->post('prov');

		$where = "Code_Prov_N = '$prov'";
		if ($_SESSION['code_od'] != '') {
			$code_od = $_SESSION['code_od'];
			$where = "Code_OD_T = '$code_od'";
		}

		$sql = "select distinct Code_OD_T as code, Name_OD_E as name, Name_OD_K as nameK
                from tblHFCodes as a join tblCensusVillage as b on a.Code_Facility_T = b.HCCode
                where HaveVMW = 1 and $where order by name";
		$rs['od'] = $this->db->query($sql)->result();

		$sql = "select distinct Code_Facility_T as code, Name_Facility_E as name, Name_Facility_K as nameK, Code_OD_T as od
                from tblHFCodes as a join tblCensusVillage as b on a.Code_Facility_T = b.HCCode
                where HaveVMW = 1 and $where order by name";
		$rs['hc'] = $this->db->query($sql)->result();

		$sql = "select Treatment from tblTreatment where VMW = 1 order by Treatment";
		$list = $this->db->query($sql)->result();
		$rs['treatmentList'] = array_column($list, 'Treatment');

		$this->output->set_output(json_encode($rs));
	}

	public function mlGetPreData()
	{
		$role = $_SESSION['role'];
		$rg = $_SESSION['code_rg'];
		$unit = $_SESSION['code_unit'];

		$where = "";
		if ($role == 'ML' && $rg != '') $where = "where Code_Regional_T = '$rg'";

		$sql = "select Code_Regional_T as code, Name_Regional_K as name from tblMLRegion $where order by name";
		$rs['rg'] = $this->db->query($sql)->result();

		$where = "";
		if ($role == 'ML' && $unit != '') $where = "where Code_Unit_T = '$unit'";

		$sql = "select Code_Regional_T as rg, Code_Unit_T as code, Name_Unit_K as name
				from tblMLUnit $where order by name";

		$rs['unit'] = $this->db->query($sql)->result();

		$sql = "select Treatment from tblTreatment where HF = 1 order by Treatment";
		$array = $this->db->query($sql)->result();
		$list = [];
		foreach ($array as $r) $list[] = $r->Treatment;
		$rs['treatmentList'] = $list;

		$this->output->set_output(json_encode($rs));
	}

	public function hfGetReport()
	{
		$year = $this->input->post('year');
		$od = $this->input->post('od');

		$hp = $year > 2018 ? "and Type_Facility <> 'HP'" : '';

		$sql = "select a.Code_Facility_T, Name_Facility_E, Name_Facility_K, Type_Facility, isnull(b.Month,c.Month) as Month
				from tblHFCodes as a
				left join V_HFLog as b on a.Code_Facility_T = b.Code_Facility_T and b.Year = '$year'
				left join tblHFActivity as c on a.Code_Facility_T = c.ID and c.Year = '$year' and (b.Month = c.Month or b.Month is null)
				where Code_OD_T = '$od' and isnull(b.Month,c.Month) is not null $hp
				order by Name_Facility_E";
		$rs['hfs'] = $this->db->query($sql)->result();

		$sql = "select b.ID, b.Month
				from tblHFCodes as a join tblHFActivity as b on a.Code_Facility_T = b.ID
				where Code_OD_T = '$od' and Year = '$year'";
		$rs['reports'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

    public function hfDataAccuracyReport()
	{
		$year = $this->input->post('year');
		$od = $this->input->post('od');

		$hp = $year > 2018 ? "and Type_Facility <> 'HP'" : '';

		$sql = "select Code_Facility_T, Name_Facility_E, Name_Facility_K, Type_Facility
				from tblHFCodes
				where Code_OD_T = '$od' $hp order by Name_Facility_E";
		$rs['hfs'] = $this->db->query($sql)->result();

		$sql = "select b.ID, b.Month
				from tblHFCodes as a join tblHFDataAccuracy as b on a.Code_Facility_T = b.ID
				where Code_OD_T = '$od' and Year = '$year'";
		$rs['reports'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function vmwGetReport()
	{
		$year = $this->input->post('year');
		$hc = $this->input->post('hc');

		$sql = "select a.Code_Vill_T, Name_Vill_E, Name_Vill_K, HaveVMW, Month
				from tblCensusVillage as a
				join V_VMWLog as b on a.Code_Vill_T = b.Code_Vill_T
				where HCCode = '$hc' and Year = '$year'
				order by Name_Vill_E";
		$rs['vmws'] = $this->db->query($sql)->result();

		$sql = "select b.ID, b.Month
				from tblCensusVillage as a
				join tblVMWActivity as b on a.Code_Vill_T = b.ID
				where HCCode = '$hc' and Year = '$year'";
		$rs['reports'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

    public function vwmDataAccuracyReport()
    {
        $year = $this->input->post('year');
        $hc = $this->input->post('hc');

        $sql = "select Code_Vill_T, Name_Vill_E, Name_Vill_K, HaveVMW
				from tblCensusVillage where HCCode = '$hc' and HaveVMW = 1
				union
				select Code_Vill_T, Name_Vill_E, Name_Vill_K, HaveVMW
				from tblCensusVillage as a join tblVMWDataAccuracy as b on a.Code_Vill_T = b.ID
				where HCCode = '$hc' and Year = '$year' order by Name_Vill_E";
		$rs['vmws'] = $this->db->query($sql)->result();

		$sql = "select b.ID, b.Month
				from tblCensusVillage as a join tblVMWDataAccuracy as b on a.Code_Vill_T = b.ID
				where HCCode = '$hc' and Year = '$year'";
		$rs['reports'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
    }

	public function ppmGetReport()
	{
		$year = $this->input->post('year');
		$od = $this->input->post('od');

		$sql = "select Code_Vill_T, Name_Outlet_E, Type
				from tblDrugOutlets
				where PPM = 1 and Deleted = 0 and Code_OD_T = '$od' order by Name_Outlet_E";
		$rs['ppms'] = $this->db->query($sql)->result();

		$sql = "select Code_Vill_T, Name_Outlet_E, Month
				from tblDOActivity
				where Code_OD_T = '$od' and Year = '$year'";
		$rs['reports'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function mlGetReport()
	{
		$year = $this->input->post('year');
		$unit = $this->input->post('unit');

        $sql = "select Code_Group_T, Name_Group_E, Name_Group_K
                from tblMLGroup where Code_Unit_T = '$unit' order by Name_Group_E";
        $rs['groups'] = $this->db->query($sql)->result();

        $sql = "select distinct b.ID, b.Month
                from tblMLGroup as a join tblMLActivity as b on a.Code_Group_T = b.ID
                where a.Code_Unit_T = '$unit' and Year = '$year'";
        $rs['reports'] = $this->db->query($sql)->result();

		if( $unit == '03' ) {
			$sql = "select distinct a.Code_Vill_T as Code_Group_T, Name_Vill_E as Name_Group_E, Name_Vill_K as Name_Group_K, 1 HasPhone
				from tblCensusVillage as a
				join V_VMWLog as b on a.Code_Vill_T = b.Code_Vill_T
				where HCCode = '190107' and VMWType = 'MMP' and Year = '$year'
				order by Name_Vill_E";
            $groups = $this->db->query($sql)->result();

			foreach($groups as $g) {
                array_push( $rs['groups'], $g);
            }

            $sql = "select b.ID, b.Month
				from tblCensusVillage as a
				join tblVMWActivity as b on a.Code_Vill_T = b.ID
				where HCCode = '190107' and VMWType = 'MMP' and Year = '$year'";
            $rpts = $this->db->query($sql)->result();

			foreach( $rpts as $r ) {
                array_push( $rs['reports'], $r );
            }

        }

		$this->output->set_output(json_encode($rs));
	}

	public function bednetGetReport()
	{
		$year = $this->input->post('year');
		$od = $this->input->post('od');

		$sql = "select Code_Facility_T, Name_Facility_E, Name_Facility_K, Type_Facility
				from tblHFCodes where Code_OD_T = '$od' order by Name_Facility_E";
		$rs['hfs'] = $this->db->query($sql)->result();

		$sql = "select distinct b.ID, b.Month
				from tblHFCodes as a join tblMalBedNet as b on a.Code_Facility_T = b.ID
				where Code_OD_T = '$od' and Year = '$year'";
		$rs['reports'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function hfGetCase()
	{
		$where['ID'] = $this->input->post('id');
		$where['Year'] = $this->input->post('year');
		$where['Month'] = $this->input->post('month');

		$rs['detail'] = $this->db->order_by('Rec_ID')->get_where('tblHFActivityCases', $where)->result();

		$this->output->set_output(json_encode($rs));
	}

    public function hfGetDataAccuracy()
    {
        $id = $this->input->post('id');
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$has = $this->input->post('has');

		if (boolval($has)) {
			$sql = "select DateAdded from tblHFDataAccuracy where ID = '$id' and Year = '$year' and Month = '$month'";
			$rs['DateAdded'] = $this->db->query($sql)->row('DateAdded');
            $sql = "select CreatedBy from tblHFDataAccuracy where ID =  '$id' and Year = '$year' and Month = '$month'";
            $rs['CreatedBy'] = $this->db->query($sql)->row('CreatedBy');
		}

		$sql = "select ID, NumberPV, NumberPF, NumberMix, NumberTest, NumberPositive, NumberNegative, InitTime, IncludedSpecies from tblHFDataAccuracy
				where ID = '$id' and Year = '$year' and Month = '$month'";

		$rs['detail'] = $this->db->query($sql)->row();

		$this->output->set_output(json_encode($rs));
    }

	public function vmwGetCase()
	{
		$where['ID'] = $this->input->post('id');
		$where['Year'] = $this->input->post('year');
		$where['Month'] = $this->input->post('month');

		$rs['detail'] = $this->db->order_by('Rec_ID')->get_where('tblVMWActivityCases', $where)->result();

		$this->output->set_output(json_encode($rs));
	}

    public function vmwGetDataAccuracy()
	{
		$id = $this->input->post('id');
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$has = $this->input->post('has');

        if (boolval($has)) {
            $sql = "select DateAdded from tblVMWDataAccuracy where ID = '$id' and Year = '$year' and Month = '$month'";
            $rs['DateAdded'] = $this->db->query($sql)->row('DateAdded');
            $sql = "select CreatedBy from tblVMWDataAccuracy where ID = '$id' and Year = '$year' and Month = '$month'";
            $rs['CreatedBy'] = $this->db->query($sql)->row('CreatedBy');
        }

		$sql = "select ID, NumberPV, NumberPF, NumberMix, NumberTest, NumberPositive, NumberNegative, NumberReferred, InitTime, IncludedSpecies from tblVMWDataAccuracy
				where ID = '$id' and Year = '$year' and Month = '$month'";

		$rs['detail'] = $this->db->query($sql)->row();

		$this->output->set_output(json_encode($rs));
	}

	public function ppmGetCase()
	{
		$od = $this->input->post('od');
		$vl = $this->input->post('vl');
		$name = $this->input->post('name');
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$sql = "select DateAdded,SuspectedCases,RDTtest,[NoTest-NoRDT],[NoTest-NotAgree],[NoTest-Severe],[TotalRDT-NotCollect]
				from tblDOActivity
				where Code_OD_T = '$od' and Code_Vill_T = '$vl' and Name_Outlet_E = '$name' and Year = '$year' and Month = '$month'";
		$rs['master'] = $this->db->query($sql)->row();

		$sql = "select ExtraCode,Age,AgeType,Sex,PregnantMTHS,Treatment,Diagnosis,DateCase,OtherTreatment,RefReason
				from tblDOActivityCases
				where Code_OD_T = '$od' and Village = '$vl' and Name_Outlet_E = '$name' and Year = '$year' and Month = '$month'
				order by Rec_ID";

		$rs['detail'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function mlGetCase()
	{
		$id = $this->input->post('id');
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$has = $this->input->post('has');

		if (boolval($has)) {
			$sql = "select NumberPositive,NumberNeg,NumberRDT,NumberMicroscopy from tblMLActivity
					where ID = '$id' and Year = '$year' and Month = '$month'";
			$rs['master'] = $this->db->query($sql)->row();
		}

		$sql = "select DateCase,Name,Sex,Age,Participant,SickQty,ClinicSign,Severe,Pregnant,RDT,
				Microscopy,Treatment,OtherTreatment,Referred,Dead,Bednet,Note,Rec_ID from tblMLActivityCases
				where ID = '$id' and Year = '$year' and Month = '$month' order by Rec_ID";

		$rs['detail'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function bednetGetCase()
	{
		$id = $this->input->post('id');
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$sql = "select VillCode,LLIN,LLIHN,HammokNet,Pregnancy,Campaign,Continued,Mobile,Rec_ID from tblMalBedNet
				where ID = '$id' and Year = '$year' and Month = '$month' order by Rec_ID";

		$rs['detail'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function hfUpdateCase()
	{
		$submit = json_decode($this->input->post('submit'));
		$m = $submit->master;

		$ID = $m->ID;
		$Year = $m->Year;
		$Month = $m->Month;

		$where = ['ID' => $ID, 'Year' => $Year, 'Month' => $Month];
		$count = $this->db->where($where)->count_all_results('tblHFActivity');

		if ($count == 0) $this->db->insert('tblHFActivity', $m);

		$this->load->model('MPatient');

		foreach ($submit->details as $d)
		{
			if ($d->Rec_ID > 0) {
				$d->ModiUser = $_SESSION['username'];
				$d->ModiTime = sqlNow();

				if (isset($d->G6PDdL)) $d->G6PDdL = $d->G6PDdL == '' ? null : $d->G6PDdL;
				if (isset($d->G6PDHb)) $d->G6PDHb = $d->G6PDHb == '' ? null : $d->G6PDHb;

				$where = ['Rec_ID' => $d->Rec_ID];
				unset($d->Rec_ID);

				if ($d->Diagnosis == 'F' || $d->Diagnosis == 'N') $d->PatientCode = null;
				$d->PatientCode = $this->MPatient->createCode($ID, $d->Diagnosis, $d->PatientCode);

				$n = (array)$d;
				$n['ID'] = $ID;
				$n['Rec_ID'] = $where['Rec_ID'];

				$currentCase = $this->db->get_where('tblHFActivityCases', $where)->row_array();
				if (empty($currentCase['Primaquine75'])
					&& isset($n['Primaquine75'])
					&& !empty($n['Primaquine75'])
				) {
					$n['PrimaquineDate'] = date("Y-m-d");
					$d->PrimaquineDate = date("Y-m-d");
				}

				if (!empty($currentCase['Primaquine75'])
					 && empty($currentCase['PrimaquineDate'])
				) {
					$n['PrimaquineDate'] = $currentCase['DateCase'];
					$d->PrimaquineDate   = $currentCase['DateCase'];
				}

				$this->db->update('tblHFActivityCases', $d, $where);

				$hasVMW = isset($n['Code_Vill_t']) ? $this->MPatient->hasVMW($n['Code_Vill_t']) : false;

				if ($hasVMW) {
					$this->MPatient->createNotification($n);
				} else {
					$this->MPatient->createHFNotification($n);
				}

			} elseif ($d->Rec_ID < 0) {
				$this->load->model('Log_model');
				$this->Log_model->deleteCase('tblHFActivityCases', $d->Rec_ID * -1);
				$this->db->delete('tblHFActivityCases', ['Rec_ID' => $d->Rec_ID * -1]);
			} else {
				$d->ID = $ID;
				$d->Year = $Year;
				$d->Month = $Month;
				$d->Is_Mobile_Entry = 0;
				$d->InitUser = $_SESSION['username'];
				if (isset($d->G6PDdL)) $d->G6PDdL = $d->G6PDdL == '' ? null : $d->G6PDdL;
				if (isset($d->G6PDHb)) $d->G6PDHb = $d->G6PDHb == '' ? null : $d->G6PDHb;

				unset($d->Rec_ID);

				$d->PatientCode = $this->MPatient->createCode($ID, $d->Diagnosis);

				$n = json_decode(json_encode($d), true);
				if (isset($n['Primaquine75']) && !empty($n['Primaquine75'])) {
					$n['PrimaquineDate'] = $n['DateCase'];
					$d->PrimaquineDate = $n['DateCase'];
				} else {
					$n['PrimaquineDate'] = null;
				}

                if (in_array($d->Diagnosis, ['F', 'M'])) {
                    $this->load->model('MTelegram');
                    $data = (array) $d;
                    $recId = $this->MPatient->logPfMix($data, 'HC');
                    $this->MTelegram->notifyPfMix($data, $recId, 'HC');
                    continue;
                }

				$this->db->insert('tblHFActivityCases', $d);
				$Rec_ID = $this->db->insert_id();

				$n['Rec_ID'] = $Rec_ID;

				$hasVMW = isset($n['Code_Vill_t']) ? $this->MPatient->hasVMW($n['Code_Vill_t']) : false;
				if ($hasVMW) {
					$this->MPatient->createNotification($n);
				}else{
					$this->MPatient->createHFNotification($n);
				}
			}
		}
	}

    public function hfUpdateDataAccuracy()
	{
		$submit = json_decode($this->input->post('submit'));
		$m = $submit;

		$ID = $m->ID;
		$Year = $m->Year;
		$Month = $m->Month;

        $submit->InitTime = sqlNow();

		$sql = "select count(*) as count from tblHFDataAccuracy where ID = '$ID' and Year = '$Year' and Month = '$Month'";
		$count = $this->db->query($sql)->row()->count;
		if ($count > 0) {
            $value['NumberPF'] = $submit->NumberPF;
            $value['NumberPV'] = $submit->NumberPV;
            $value['NumberMix'] = $submit->NumberMix;
            $value['DateAdded'] = $submit->DateAdded;
            $value['NumberTest'] = $submit->NumberTest;
            $value['NumberPositive'] = $submit->NumberPositive;
            $value['NumberNegative'] = $submit->NumberNegative;
            $value['IncludedSpecies'] = $submit->IncludedSpecies;
			$where['ID'] = $ID;
			$where['Year'] = $Year;
			$where['Month'] = $Month;
			$this->db->update('tblHFDataAccuracy', $value, $where);
		} else {
			$this->db->insert('tblHFDataAccuracy', $submit);
		}
	}

    public function vmwUpdateDataAccuracy()
    {
        $submit = json_decode($this->input->post('submit'));

		$ID = $submit->ID;
		$Year = $submit->Year;
		$Month = $submit->Month;

		$submit->InitTime = sqlNow();

		$sql = "select count(*) as count from tblVMWDataAccuracy where ID = '$ID' and Year = '$Year' and Month = '$Month'";
		$count = $this->db->query($sql)->row()->count;
		if ($count > 0) {
			$value['DateAdded'] = $submit->DateAdded;
            $value['ModiTime'] = sqlNow();
			$value['NumberPF'] = $submit->NumberPF;
			$value['NumberPV'] = $submit->NumberPV;
			$value['NumberMix'] = $submit->NumberMix;
            $value['NumberTest'] = $submit->NumberTest;
            $value['NumberPositive'] = $submit->NumberPositive;
            $value['NumberNegative'] = $submit->NumberNegative;
            $value['IncludedSpecies'] = $submit->IncludedSpecies;
            $value['NumberReferred'] = null;//$submit->NumberReferred;
			$where['ID'] = $ID;
			$where['Year'] = $Year;
			$where['Month'] = $Month;
			$this->db->update('tblVMWDataAccuracy', $value, $where);
		} else {
			$this->db->insert('tblVMWDataAccuracy', $submit);
		}
    }

	public function vmwUpdateCase()
	{
		$submit = json_decode($this->input->post('submit'));
		$m = $submit->master;

		$ID = $m->ID;
		$Year = $m->Year;
		$Month = $m->Month;

		$where = ['ID' => $ID, 'Year' => $Year, 'Month' => $Month];
		$count = $this->db->where($where)->count_all_results('tblVMWActivity');

		if ($count == 0) $this->db->insert('tblVMWActivity', $m);

		$this->load->model('MPatient');

		foreach ($submit->details as $d)
		{
			if ($d->Rec_ID > 0) {
				$d->ModiUser = $_SESSION['username'];
				$d->ModiTime = sqlNow();

				if (isset($d->G6PDdL)) $d->G6PDdL = $d->G6PDdL == '' ? null : $d->G6PDdL;
				if (isset($d->G6PDHb)) $d->G6PDHb = $d->G6PDHb == '' ? null : $d->G6PDHb;

				$where = ['Rec_ID' => $d->Rec_ID];
				unset($d->Rec_ID);

				if ($d->Diagnosis == 'F' || $d->Diagnosis == 'N') $d->PatientCode = null;
				$d->PatientCode = $this->MPatient->createCode($ID, $d->Diagnosis, $d->PatientCode);

				$n = json_decode(json_encode($d), true);
				$n['Rec_ID'] = $where['Rec_ID'];
				$n['ID'] = $ID;

				$currentCase = $this->db->get_where('tblVMWActivityCases', $where)->row_array();

				if (empty($currentCase['Primaquine75'])
					&& isset($n['Primaquine75'])
					&& !empty($n['Primaquine75'])
				) {
					$n['PrimaquineDate'] = date("Y-m-d");
					$d->PrimaquineDate = date("Y-m-d");
				}

				if (!empty($currentCase['Primaquine75'])
					 && empty($currentCase['PrimaquineDate'])
				) {
					$n['PrimaquineDate'] = $currentCase['DateCase'];
					$d->PrimaquineDate   = $currentCase['DateCase'];
				}

				$this->db->update('tblVMWActivityCases', $d, $where);

				$this->MPatient->createNotification($n);
			} elseif ($d->Rec_ID < 0) {
				$this->load->model('Log_model');
				$this->Log_model->deleteCase('tblVMWActivityCases', $d->Rec_ID * -1);
				$this->db->delete('tblVMWActivityCases', ['Rec_ID' => $d->Rec_ID * -1]);
			} else {
				$d->ID = $ID;
				$d->Year = $Year;
				$d->Month = $Month;

				if (isset($d->G6PDdL)) $d->G6PDdL = $d->G6PDdL == '' ? null : $d->G6PDdL;
				if (isset($d->G6PDHb)) $d->G6PDHb = $d->G6PDHb == '' ? null : $d->G6PDHb;

				$d->Is_Mobile_Entry = 0;
				$d->InitUser = $_SESSION['username'];
				unset($d->Rec_ID);

				$d->PatientCode = $this->MPatient->createCode($ID, $d->Diagnosis);

				$n = json_decode(json_encode($d), true);
				if (isset($n['Primaquine75']) && !empty($n['Primaquine75'])) {
					$n['PrimaquineDate'] = $n['DateCase'];
					$d->PrimaquineDate = $n['DateCase'];
				} else {
					$n['PrimaquineDate'] = null;
				}

                if (in_array($d->Diagnosis, ['F', 'M'])) {
                    $this->load->model('MTelegram');
                    $data = (array) $d;
                    $recId = $this->MPatient->logPfMix($data, 'VMW');
                    $this->MTelegram->notifyPfMix($data, $recId, 'VMW');
                    continue;
                }

				$this->db->insert('tblVMWActivityCases', $d);
				$Rec_ID = $this->db->insert_id();

				$n['Rec_ID'] = $Rec_ID;
				$this->MPatient->createNotification($n);
			}
		}
	}

	public function mlUpdateCase()
	{
		$submit = json_decode($this->input->post('submit'));
		$m = $submit->master;

		$ID = $m->ID;
		$Year = $m->Year;
		$Month = $m->Month;

		$sql = "select count(*) as count from tblMLActivity where ID = '$ID' and Year = '$Year' and Month = '$Month'";
		$count = $this->db->query($sql)->row()->count;
		if ($count > 0) {
			$value['NumberTests'] = $m->NumberTests;
			$value['NumberPositive'] = $m->NumberPositive;
			$value['NumberNeg'] = $m->NumberNeg;
			$value['NumberRDT'] = $m->NumberRDT;
			$value['NumberMicroscopy'] = $m->NumberMicroscopy;
			$value['ModiUser'] = $_SESSION['username'];
			$value['ModiTime'] = sqlNow();

			$where['ID'] = $ID;
			$where['Year'] = $Year;
			$where['Month'] = $Month;
			$this->db->update('tblMLActivity', $value, $where);
		} else {
			$m->InitUser = $_SESSION['username'];
			$this->db->insert('tblMLActivity', $m);
		}

		foreach ($submit->details as $d)
		{
			if ($d->Rec_ID > 0) {
				$d->ModiUser = $_SESSION['username'];
				$d->ModiTime = sqlNow();
				$where = ['Rec_ID' => $d->Rec_ID];
				unset($d->Rec_ID);
				$this->db->update('tblMLActivityCases', $d, $where);
			} elseif ($d->Rec_ID < 0) {
				$this->db->delete('tblMLActivityCases', ['Rec_ID' => $d->Rec_ID * -1]);
			} else {
				$d->ID = $ID;
				$d->Year = $Year;
				$d->Month = $Month;
				$d->Positive = 'P';
				$d->InitUser = $_SESSION['username'];
				unset($d->Rec_ID);
				$this->db->insert('tblMLActivityCases', $d);
			}
		}
	}

	public function bednetUpdateCase()
	{
		$submit = json_decode($this->input->post('submit'));
		$m = $submit->master;

		foreach ($submit->details as $d)
		{
			if ($d->Rec_ID > 0) {
				$d->ModiUser = $_SESSION['username'];
				$d->ModiTime = sqlNow();
				$where = ['Rec_ID' => $d->Rec_ID];
				unset($d->Rec_ID);
				$this->db->update('tblMalBedNet', $d, $where);
			} elseif ($d->Rec_ID < 0) {
				$this->db->delete('tblMalBedNet', ['Rec_ID' => $d->Rec_ID * -1]);
			} else {
				$d->ID = $m->ID;
				$d->Year = $m->Year;
				$d->Month = $m->Month;
				$d->InitUser = $_SESSION['username'];
				unset($d->Rec_ID);
				$this->db->insert('tblMalBedNet', $d);
			}
		}
	}

    public function hfDeleteReport()
    {
        $where = $this->input->post('where');
        $this->db->delete('tblHFActivity', $where);
    }

    public function hfDataAccuracyDeleteReport()
    {
        $where = $this->input->post('where');
        $this->db->delete('tblHFDataAccuracy', $where);
    }

	public function vmwDeleteReport()
    {
        $where = $this->input->post('where');
        $this->db->delete('tblVMWActivity', $where);
    }

    public function vmwDataAccuracyDeleteRpt()
    {
        $where = $this->input->post('where');
        $this->db->delete('tblVMWDataAccuracy', $where);
    }

	public function mlDeleteReport()
    {
        $where = $this->input->post('where');
        $this->db->delete('tblMLActivity', $where);
    }

	public function ppmDeleteReport()
    {
        $where = $this->input->post('where');
        $this->db->delete('tblDOActivity', $where);
    }

	public function bednetDeleteReport()
    {
        $where = $this->input->post('where');
        $this->db->delete('tblMalBedNet', $where);
    }

	public function bednetOtherGetReport()
	{
		$sql = "select Code_Prov_T as code, Name_Prov_E as name
				from tblProvince where Code_Prov_T <> 30 order by name";
		$rs['prov'] = $this->db->query($sql)->result();

		$sql = "select * from tblMalBedNetOther order by Rec_ID";
		$rs['detail'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function bednetOtherUpdateReport()
	{
		$submit = json_decode($this->input->post('submit'));

		foreach ($submit as $d)
		{
			if ($d->Rec_ID > 0) {
				$d->ModiUser = $_SESSION['username'];
				$d->ModiTime = sqlNow();
				$where = ['Rec_ID' => $d->Rec_ID];
				unset($d->Rec_ID);
				$this->db->update('tblMalBedNetOther', $d, $where);
			} elseif ($d->Rec_ID < 0) {
				$this->db->delete('tblMalBedNetOther', ['Rec_ID' => $d->Rec_ID * -1]);
			} else {
				$d->InitUser = $_SESSION['username'];
				unset($d->Rec_ID);
				$this->db->insert('tblMalBedNetOther', $d);
			}
		}

		$sql = "select * from tblMalBedNetOther order by Rec_ID";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function bednetEnv()
	{
		if (!isset($_SESSION['permiss']['Environment Bed Net'])) redirect('Home');

		$data['title'] = "Environment Betnet Report";
		$data['main'] = 'envbednet_view';

		$this->load->view('layout', $data);
	}

	public function bednetML()
	{
		if (!isset($_SESSION['permiss']['MMP Bed Net'])) redirect('Home');

		$data['title'] = "MMP Betnet Report";
		$data['main'] = 'mlbednet_view';

		$this->load->view('layout', $data);
	}

	public function bednetMLGetReport()
	{
		$year = $this->input->post('year');
		$unit = $this->input->post('unit');

		$sql = "select Code_Group_T, Name_Group_E, Name_Group_K
				from tblMLGroup where Code_Unit_T = '$unit' order by Name_Group_E";
		$rs['groups'] = $this->db->query($sql)->result();

		$sql = "select distinct b.ID, b.Month
				from tblMLGroup as a join tblMLBednet as b on a.Code_Group_T = b.ID
				where a.Code_Unit_T = '$unit' and Year = '$year'";
		$rs['reports'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function bednetMLGetCase()
	{
		$id = $this->input->post('id');
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$sql = "select ID,LLIN,LLIHN, HamokNet,Rec_ID from tblMLBedNet
				where ID = '$id' and Year = '$year' and Month = '$month' order by Rec_ID";

		$rs['detail'] = $this->db->query($sql)->row();

		$this->output->set_output(json_encode($rs));
	}

	public function bednetMLUpdateCase()
	{
		$submit = json_decode($this->input->post('submit'), true);

		if ($submit['Rec_ID'] == -1){
			$submit['InitUser'] = $_SESSION['username'];
			unset($submit['Rec_ID']);
			$this->db->insert('tblMLBednet', $submit);
		} else {
			$submit['ModiTime']= sqlNow();
			$submit['ModiUser'] = $_SESSION['username'];
			$where['Rec_ID'] = $submit['Rec_ID'];
			unset($submit['Rec_ID']);
			$this->db->update('tblMLBednet', $submit, $where);
		}
	}

	public function bednetMLDeleteReport()
	{
        $where = $this->input->post('where');
        $this->db->delete('tblMLBedNet', $where);
	}

	public function bednetPL()
	{
		if (!isset($_SESSION['permiss']['Police Bed Net'])) redirect('Home');

		$data['title'] = "Police Betnet Report";
		$data['main'] = 'plbednet_view';

		$this->load->view('layout', $data);
	}

	public function envGetPreData()
	{
		$sql = "select distinct b.Code_Prov_T as code, Name_Prov_K as name
				from tblEnvOffice as a
				join tblProvince as b on a.Code_Prov_T = b.Code_Prov_T
				order by Name_Prov_K";
		$rs['prov'] = $this->db->query($sql)->result();

		$sql = "select Code_Prov_T, Name_Office_K as name, Code_Office_T as code from tblEnvOffice";
		$rs['office'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function bednetEnvGetReport()
	{
		$year = $this->input->post('year');
		$office = $this->input->post('office');

		$sql = "select Code_Community_T, Name_Community_E, Name_Community_K
				from tblEnvCommunity
				where Code_Office_T = '$office'";
		$rs['communities'] = $this->db->query($sql)->result();

		$sql = "select a.Code_Community_T, Month
				from tblEnvBednet as a
				join tblEnvCommunity as b on a.Code_Community_T = b.Code_Community_T
				where Code_Office_T = '$office' and Year = '$year'";
		$rs['reports'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function plGetPreData()
	{
		$sql = "select distinct b.Code_Prov_T as code, Name_Prov_K as name
				from tblPLTroopCodes as a
				join tblProvince as b on a.Code_Prov_T = b.Code_Prov_T
				order by Name_Prov_K";
		$rs['prov'] = $this->db->query($sql)->result();

		$sql = "select Code_Troop_T as code, Name_Troop_K as name, Code_Prov_T as prov
				from tblPLTroopCodes
				order by Name_Troop_K";
		$rs['troop'] = $this->db->query($sql)->result();

		$sql = "select Treatment from tblTreatment where HF = 1 order by Treatment";
		$array = $this->db->query($sql)->result();
		$rs['treatmentList'] = array_column($array, 'Treatment');

		$this->output->set_output(json_encode($rs));
	}

	public function bednetPLGetReport()
	{
		$year = $this->input->post('year');
		$prov = $this->input->post('prov');

		$sql = "select Code_Troop_T, Name_Troop_E, Name_Troop_K
				from tblPLTroopCodes
				where Code_Prov_T = '$prov'";
		$rs['troops'] = $this->db->query($sql)->result();

		$sql = "select a.Code_Troop_T, Month
				from tblPLBednet as a
				join tblPLTroopCodes as b on a.Code_Troop_T = b.Code_Troop_T
				where Code_Prov_T = '$prov' and Year = '$year'";
		$rs['reports'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function bednetEnvGetCase()
	{
		$id = $this->input->post('id');
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$sql = "select LLIN,LLIHN,Rec_ID from tblEnvBedNet
				where Code_Community_T = '$id' and Year = '$year' and Month = '$month'
				order by Rec_ID";

		$rs['detail'] = $this->db->query($sql)->row();

		$this->output->set_output(json_encode($rs));
	}

	public function bednetEnvUpdateCase()
	{
		$submit = json_decode($this->input->post('submit'), true);

		if ($submit['Rec_ID'] == -1){
			$submit['InitUser'] = $_SESSION['username'];
			$submit['InitTime'] = sqlNow();
			unset($submit['Rec_ID']);
			$this->db->insert('tblEnvBednet', $submit);
		} else {
			$submit['ModiTime']= sqlNow();
			$submit['ModiUser'] = $_SESSION['username'];
			$where['Rec_ID'] = $submit['Rec_ID'];
			unset($submit['Rec_ID']);
			$this->db->update('tblEnvBednet', $submit, $where);
		}
	}

	public function bednetEnvDeleteReport()
	{
        $where = $this->input->post('where');
        $this->db->delete('tblEnvBednet', $where);
	}

	public function bednetPLGetCase()
	{
		$id = $this->input->post('id');
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$sql = "select LLIN,LLIHN,HamokNet,Rec_ID from tblPLBedNet
				where Code_Troop_T = '$id' and Year = '$year' and Month = '$month'
				order by Rec_ID";

		$rs['detail'] = $this->db->query($sql)->row();

		$this->output->set_output(json_encode($rs));
	}

	public function bednetPLUpdateCase()
	{
		$submit = json_decode($this->input->post('submit'), true);

		if ($submit['Rec_ID'] == -1){
			$submit['InitUser'] = $_SESSION['username'];
			unset($submit['Rec_ID']);
			$this->db->insert('tblPLBednet', $submit);
		} else {
			$submit['ModiTime']= sqlNow();
			$submit['ModiUser'] = $_SESSION['username'];
			$where['Rec_ID'] = $submit['Rec_ID'];
			unset($submit['Rec_ID']);
			$this->db->update('tblPLBednet', $submit, $where);
		}
	}

	public function bednetPLDeleteReport()
	{
        $where = $this->input->post('where');
        $this->db->delete('tblPLBednet', $where);
	}

	public function plGetReport()
	{
		$year = $this->input->post('year');
		$prov = $this->input->post('prov');

		$sql = "select Code_Troop_T, Name_Troop_E, Name_Troop_K
				from tblPLTroopCodes
				where Code_Prov_T = '$prov'";
		$rs['troops'] = $this->db->query($sql)->result();

		$sql = "select distinct b.ID, b.Month
				from tblPLTroopCodes as a join tblPLActivity as b on a.Code_Troop_T = b.ID
				where a.Code_Prov_T = '$prov' and Year = '$year'";
		$rs['reports'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function plGetCase()
	{
		$id = $this->input->post('id');
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$has = $this->input->post('has');

		if (boolval($has)) {
			$sql = "select NumberPositive,NumberNeg,NumberRDT,NumberMicroscopy
					from tblPLActivity
					where ID = '$id' and Year = '$year' and Month = '$month'";
			$rs['master'] = $this->db->query($sql)->row();
		}

		$sql = "select DateCase,Name,Sex,Age,Participant,SickQty,ClinicSign,Severe,Pregnant,RDT,
				Microscopy,Treatment,OtherTreatment,Referred,Dead,Bednet,Note,TreatmentPlace,Rec_ID
				from tblPLActivityCases
				where ID = '$id' and Year = '$year' and Month = '$month' order by Rec_ID";

		$rs['detail'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function plUpdateCase()
	{
		$submit = json_decode($this->input->post('submit'));
		$m = $submit->master;

		$ID = $m->ID;
		$Year = $m->Year;
		$Month = $m->Month;

		$sql = "select count(*) as count from tblPLActivity where ID = '$ID' and Year = '$Year' and Month = '$Month'";
		$count = $this->db->query($sql)->row()->count;
		if ($count > 0) {
			$value['NumberTests'] = $m->NumberTests;
			$value['NumberPositive'] = $m->NumberPositive;
			$value['NumberNeg'] = $m->NumberNeg;
			$value['NumberRDT'] = $m->NumberRDT;
			$value['NumberMicroscopy'] = $m->NumberMicroscopy;
			$value['ModiUser'] = $_SESSION['username'];
			$value['ModiTime'] = sqlNow();

			$where['ID'] = $ID;
			$where['Year'] = $Year;
			$where['Month'] = $Month;
			$this->db->update('tblPLActivity', $value, $where);
		} else {
			$m->InitUser = $_SESSION['username'];
			$this->db->insert('tblPLActivity', $m);
		}

		foreach ($submit->details as $d)
		{
			if ($d->Rec_ID > 0) {
				$d->ModiUser = $_SESSION['username'];
				$d->ModiTime = sqlNow();
				$where = ['Rec_ID' => $d->Rec_ID];
				unset($d->Rec_ID);
				$this->db->update('tblPLActivityCases', $d, $where);
			} elseif ($d->Rec_ID < 0) {
				$this->db->delete('tblPLActivityCases', ['Rec_ID' => $d->Rec_ID * -1]);
			} else {
				$d->ID = $ID;
				$d->Year = $Year;
				$d->Month = $Month;
				$d->Positive = 'P';
				$d->InitUser = $_SESSION['username'];
				unset($d->Rec_ID);
				$this->db->insert('tblPLActivityCases', $d);
			}
		}
	}

	public function plDeleteReport()
    {
        $where = $this->input->post('where');
        $this->db->delete('tblPLActivity', $where);
    }

	public function investigation()
	{
		$data['title'] = "Case Investigation";
		$data['main'] = "investigation_view";

		$this->load->view('layout', $data);
	}

	public function getInvestigation()
	{
		$caseid = $this->input->post('caseid');
		$id = $this->input->post('id');

		if ($id == null) {
			$rs['model'] = $this->db->list_fields('tblInvestigationCases');

			$sql = "select Id,Date_Of_Invest,Name_K,Passive_Case_Id from tblInvestigationCases where Passive_Case_Id = '$caseid'";
			$rs['list'] = $this->db->query($sql)->result();
		}

		if ($id != null || count($rs['list']) > 0) {
			if ($id == null) $id = $rs['list'][0]->Id;
			$sql = "select Name_Vill_E, Name_Facility_E, Name_OD_E, Name_Prov_E, a.*
					from tblInvestigationCases as a
					left join tblCensusVillage as b on a.Vill_Of_Residence = b.Code_Vill_T
					left join tblHFCodes as c on b.HCCode = c.Code_Facility_T
					left join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
					where a.Id = $id";
			$rs['detail'] = $this->db->query($sql)->row();
		} else {
			$sql = "select ReferredFrom from tblHFActivityCases where convert(varchar,Rec_ID) + '_HC' = '$caseid'";
			$rs['referredFrom'] = $this->db->query($sql)->row('ReferredFrom');
		}

		$this->output->set_output(json_encode($rs));
	}

    public function getHFCase() {
        $caseId = $this->input->post('G6PDCode');
        $arr = explode('_', $caseId);
        $recId = $arr[0];
        $sql = "select c.*,
                Case when a.Diagnosis = 'V' then 'PV' when a.Diagnosis = 'F' then 'PF' else 'MIX' end as DiagnosisText, a.Diagnosis, a.NameK, FORMAT(a.DateCase, 'dd-MM-yy') as DateCaseText, a.DateCase, a.Weight, a.Sex, a.Age, Code_Facility_T ,Name_Facility_K, a.PatientCode
                from tblHFActivityCases as a
                join tblHFCodes as b on a.ID = b.Code_Facility_T
                left join tblG6PDInvestigation as c on CONCAT(CONVERT(nvarchar, a.Rec_ID), '_HC') = c.G6PDCode
                where a.Rec_ID = $recId";
        $rs = $this->db->query($sql)->row();

        $this->output->set_output(json_encode($rs));
    }

    public function updateG6PD() {
        $submit = (array) json_decode($this->input->post('submit'));
        $where['Rec_ID'] = $submit['Rec_ID'];
        $submit['Code_Facility_T'] = $submit['HCCode'];
		$submit['NameK'] = $submit['NameText'];
		$submit['Age'] = $submit['AgeText'];
		$submit['Sex'] = $submit['SexText'];
		$submit['Weight'] = $submit['WeightText'];
        $submit['G6PDCode'] = $submit['G6PDCodeText'];
		$submit['PatientCode'] = $submit['PatientCodeText'];
		$submit['Diagnosis'] = $submit['DiagnosisText'] == 'PV' ? 'V' : 'M';
		$submit['DateCase'] = date('Y-m-d',strtotime($submit['DateCaseText']));
		$submit['InitTime'] = sqlNow();
		$submit['InitUser'] = $_SESSION['username'];

		unset($submit['CaseType']);
        unset($submit['Rec_ID']);
        unset($submit['DiagnosisText']);
        unset($submit['DateCaseText']);
        unset($submit['NameText']);
		unset($submit['AgeText']);
		unset($submit['SexText']);
		unset($submit['WeightText']);
		unset($submit['G6PDCodeText']);
		unset($submit['PatientCodeText']);
		unset($submit['Code_Vill_t']);
		unset($submit['ID']);
		unset($submit['Month']);
		unset($submit['Year']);
		unset($submit['Is_G6PD']);
		unset($submit['HCCode']);
		unset($submit['Name_Vill_K']);
        if ($submit['Day1Code'] == '') $submit['Day1Code'] = null;
        if ($submit['Day3Code'] == '') $submit['Day3Code'] = null;
        if ($submit['Day7Code'] == '') $submit['Day7Code'] = null;
        if ($submit['Day14Code'] == '') $submit['Day14Code'] = null;
        if (empty($where['Rec_ID'])) {
            $this->db->insert('tblG6PDInvestigation', $submit);
            $last_id = $this->db->insert_id();
            $this->output->set_output(json_encode($last_id));
            return;
        }
        $this->db->update('tblG6PDInvestigation', $submit, $where);
    }

    public function g6pdInvestigation() {
        if (!isset($_SESSION['permiss']['G6PD'])) redirect('Home');

		$data['title'] = "G6PD Investigation";
		$data['main'] = 'g6pdinvestigation_view';

		$this->load->view('layoutV3', $data);
    }

	public function getG6PD()
	{
	    $year = $this->input->post('year');
	    $month = $this->input->post('month');
	    $hc = $this->input->post('hc');
	    $month = str_pad($month, 2, 0, STR_PAD_LEFT);

	    $rs = $this->db->query("SP_G6PDForm $hc, $year, $month")->result();
	    $this->output->set_output(json_encode($rs));
	}

	public function bednetAccuracy()
	{
		$data['title'] = "Bednet Data Accuracy";
		$data['main'] = 'bednetaccuracy_view';

		$this->load->view('layout', $data);
	}

	public function getBednetAccuracy()
	{
		$year = $this->input->post('year');
		$mf = $this->input->post('mf');
		$mt = $this->input->post('mt');
		$q = $this->input->post('q');

		$sql = "SP_Get_BednetAccurary {$year}, {$mf}, {$mt}, {$q}";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function updateBednetAccuracy()
	{
		$list = $this->input->post('list');

		foreach ($list as $r)
		{
			$this->db->delete('tblMalBedNetAccuracy', $r['where']);

			$r['value']['InitUser'] = $_SESSION['username'];
			$r['value']['InitTime'] = sqlNow();
			$this->db->insert('tblMalBedNetAccuracy', array_merge($r['where'], $r['value']));
		}
	}

	public function hfMoveData()
	{
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$detail_id = $this->input->post('detail_id');

		$count = $this->db->where($to)->count_all_results('tblHFActivity');
		if ($count == 0) $this->db->insert('tblHFActivity', $to);

		if ($detail_id == null) {
			$this->db->update('tblHFActivityCases', $to, $from);
			$this->db->delete('tblHFActivity', $from);
		} else {
		    $this->db->update('tblHFActivityCases', $to, ['Rec_ID' => $detail_id]);
		}
	}

	public function vmwMoveData()
	{
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$detail_id = $this->input->post('detail_id');

		$count = $this->db->where($to)->count_all_results('tblVMWActivity');
		if ($count == 0) $this->db->insert('tblVMWActivity', $to);

		if ($detail_id == null) {
			$this->db->update('tblVMWActivityCases', $to, $from);
			$this->db->delete('tblVMWActivity', $from);
		} else {
		    $this->db->update('tblVMWActivityCases', $to, ['Rec_ID' => $detail_id]);
		}
	}

    public function getWorm()
    {
        $submit = $this->input->post('submit');
        $rs = $this->db->get_where('tblVMWWormAbet', $submit)->row();
        $this->output->set_output(json_encode($rs));
    }

    public function saveWorm()
    {
        $submit = $this->input->post('submit');
        $where = [
          'Code_Vill_T' => $submit['Code_Vill_T'],
          'Year' => $submit['Year'],
          'Month' => str_pad($submit['Month'],2,"0",STR_PAD_LEFT )
        ];
        $submit['InitTime'] = sqlNow();
        $submit['InitUser'] = $_SESSION['username'];
        $this->db->delete('tblVMWWormAbet', $where);
        $this->db->insert('tblVMWWormAbet', $submit);
    }

    public function getEdu()
    {
        $submit = $this->input->post('submit');
        $rs = $this->db->get_where('tblVMWEdu', $submit)->row();
        $this->output->set_output(json_encode($rs));
    }

    public function saveEdu()
    {
        $submit = $this->input->post('submit');
        $where = [
          'Code_Vill_T' => $submit['Code_Vill_T'],
          'Year' => $submit['Year'],
          'Month' => str_pad($submit['Month'],2,"0",STR_PAD_LEFT )
        ];
        $submit['InitTime'] = sqlNow();
        $submit['InitUser'] = $_SESSION['username'];
        $this->db->delete('tblVMWEdu', $where);
        $this->db->insert('tblVMWEdu', $submit);
    }

    public function getCommodity()
    {
        $submit = $this->input->post('submit');

        $vl = $submit['Code_Vill_T'];
        $year = $submit['Year'];
        $month = str_pad($submit['Month'],2,"0",STR_PAD_LEFT );
        $rs = $this->db->query("SP_VMWCommodityForm '$vl', $year, '$month'")->result();
	    $this->output->set_output(json_encode($rs));
    }

    public function saveCommodity()
    {
        $submit = $this->input->post('submit');
        $where = [
          'Code_Vill_T' => $submit['Code_Vill_T'],
          'Year' => $submit['Year'],
          'Month' => str_pad($submit['Month'],2,"0",STR_PAD_LEFT )
        ];

        unset($submit['Code_Vill_T'],$submit['Year'],$submit['Month']);

        $this->db->delete('tblVMWCommodity', $where);

        foreach ($submit['Commodities'] as $item) {
            $item['Year'] = $where['Year'];
            $item['Month'] = $where['Month'];
            $item['Code_Vill_T'] = $where['Code_Vill_T'];
            $item['InitTime'] = sqlNow();
            $item['InitUser'] = $_SESSION['username'];

            unset($item['Name'], $item['NameK'], $item['Rec_ID']);

            $this->db->insert('tblVMWCommodity', $item);
        }

    }
}