<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
	function index($invalid = false)
	{
        if ($this->isGuest()) $this->setGuestMode();
        if (!isset($_SESSION['permiss']['Dashboard'])) redirect('/Home');

		$value['Username'] = $_SESSION['username'];
		$value['Module'] = 'Dashboard';

		$ip = $this->input->ip_address();
		if ($ip != '::1') {
            set_error_handler('_error_handler');
            $json = @json_decode(file_get_contents("https://api.ipgeolocation.io/ipgeo?apiKey=242027f31cad42d39b0087fd5e8ec7e7&ip=$ip"));
            restore_error_handler();

            if (isset($json->country_name)) {
                $value['Username'] = $_SESSION['username'];
                $value['Module'] = 'Dashboard';
                $value['Country'] = $json->country_name;
                $value['City'] = $json->city != '' ? $json->city : $json->state_prov;
                $this->db->insert('tblAccessLog', $value);
            }
		}

        $data['invalid'] = $invalid;
		$data['title'] = "Malaria Dashboard V2";
		$data['main'] = 'dashboard_v2_view';
		$data['percent'] = file_get_contents(FCPATH . '/media/Dashboard/Preload Data/ReportCompletenessLastMonth.txt');

		$this->load->view('layoutV3', $data);
	}

	public function tabOverview($part)
	{
		$year = $this->input->post('year');
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$prov = $this->input->post('prov');
		$fdc = $this->input->post('filterDateCase');

        if ($prov == '' && isset($_SESSION['prov']) && $_SESSION['prov'] != '') $prov = $_SESSION['prov'];

        if($part==1) {
            try{
                $cache_config = new \Phpfastcache\Drivers\Files\Config([
                    'path' => FCPATH . '\cache',
                    'securityKey' => 'mis',
                    'preventCacheSlams' => true,
                    'cacheSlamsTimeout' => 20,
                    'secureFileManipulation' => true
                ]);

                \Phpfastcache\CacheManager::setDefaultConfig($cache_config);
                $cache = \Phpfastcache\CacheManager::getInstance('Files');

                $cache_instance = $cache->getItem('overview?year='.$year.'from='.$from.'to='.$to.'prov='.$prov.'fdc='.$fdc);
            }
            catch(Exception $e){
                die($e);
            }

			$data = $cache_instance->get();

			$this->load->model('Dashboard_model');
            //if(empty($prov) && $from == 1 && $to == date('m') && $year == date('Y')){
            //    $data = $cache_instance->get();
            //} else {
            //    $data = $this->Dashboard_model->getOverViewData($year,$from,$to,$prov,$fdc);
            //}

			if (is_null($data)) {
			    $data = $this->Dashboard_model->getOverViewData($year,$from,$to,$prov,$fdc);
			    $cache->save(
			        $cache_instance->set($data)->expiresAfter(0)
			    );
			}
        }
        else if($part == 2) {
            $data['dailyCase'] = $this->db->query("SP_Dashboard_DailyCase $year,$from,$to,'$prov',$fdc")->result();
            $data['visit'] = $this->getVisitCount();
        }
        else if($part == 3) {
            $data['monthlyCase'] = $this->db->query("SP_Dashboard_MonthlyCase $year,$from,$to,'$prov',$fdc")->result();
        }

		$this->output->set_output(json_encode($data));
	}

    private function getVisitCount()
	{
        $sql = "select sum(iif(CONVERT(date, AccessDate) = CONVERT(date, GETDATE()),1,0)) as today,
                sum(iif(CONVERT(date, AccessDate) = CONVERT(date, DATEADD(day, -1, GETDATE())),1,0)) as yesterday
                from tblAccessLog";
		return $this->db->query($sql)->row();
	}

	public function tabSurveillance()
	{
		$year = $this->input->post('year');
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$prov = $this->input->post('prov');
		$fdc = $this->input->post('filterDateCase');

		if ($prov == '' && $_SESSION['prov'] != '') $prov = $_SESSION['prov'];

		$rs = $this->db->query("SP_Dashboard_SurveillanceData $year,$from,$to,'$prov',$fdc")->result();

		$this->output->set_output(json_encode($rs));
	}

	public function tabStock()
	{
		$year = $this->input->post('year');
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$prov = $this->input->post('prov');
		$fdc = $this->input->post('filterDateCase');
		$stockPart = $this->input->post('stockPart');

		foreach (explode('|', urldecode($stockPart)) as $name)
		{
			$rs[$name] = $this->db->query("SP_Dashboard_$name $year,$from,$to,'$prov',$fdc")->result();
		}

		$this->output->set_output(json_encode($rs));
	}

	public function tabStockMonitor()
	{
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$prov = $this->input->post('prov');
		$store = $this->input->post('store');

		if ($prov == '' && $_SESSION['prov'] != '') $prov = $_SESSION['prov'];
		$od = $_SESSION['code_od'];

		if ($store == null || $store == 'StockMonitorOD') {
			$rs['monitorOD'] = $this->db->query("SP_Dashboard_StockMonitorOD $year,$month,'$prov','$od'")->result();
		}
		if ($store == null || $store == 'StockMonitorHC') {
			$rs['monitorHC'] = $this->db->query("SP_Dashboard_StockMonitorHC $year,$month,'$prov','$od'")->result();
		}
		if ($store == null) {
			$rs['table'] = $this->db->query("SP_Dashboard_StockTable $year,$month,'$prov','$od'")->result();
		}

		$this->output->set_output(json_encode($rs));
	}

	public function tabBorder()
	{
		$year = $this->input->post('year');
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$prov = $this->input->post('prov');
		$fdc = $this->input->post('filterDateCase');

		if ($prov == '' && $_SESSION['prov'] != '') $prov = $_SESSION['prov'];

		$rs['borderChart'] = $this->db->query("SP_Dashboard_BorderChart $year,$from,$to,'$prov',$fdc")->result();
		$rs['borderMap'] = $this->db->query("SP_Dashboard_BorderMap $year,$from,$to,'$prov',$fdc")->result();
        $rs['borderMapPfMix'] = $this->db->query("SP_Dashboard_BorderPfMixMap $year,$from,$to,'$prov',$fdc")->result();
        $rs['borderMapPv'] = $this->db->query("SP_Dashboard_BorderPvMap $year,$from,$to,'$prov',$fdc")->result();

		$from = str_pad($from, 2, '0', STR_PAD_LEFT);
		$to = str_pad($to, 2, '0', STR_PAD_LEFT);

		$sql = "select PlaceCode
					  ,sum(Positive) as Positive
					  ,sum(Pf + Mix) as PfMix
					  ,sum(Pv) as Pv
				from tblBorderData
				where YearMonth between '$year$from' and '$year$to'
				group by PlaceCode";
		$rs['borderData'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function tabMap()
	{
		$year = $this->input->post('year');
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$prov = $this->input->post('prov');
		$fdc = $this->input->post('filterDateCase');

		if ($prov == '' && $_SESSION['prov'] != '') $prov = $_SESSION['prov'];

		$data['chartTop10OD'] = $this->db->query("SP_Dashboard_ChartTop10OD $year,$from,$to,'$prov',$fdc")->result();
		$data['mapTop30Vill'] = $this->db->query("SP_Dashboard_MapTop30Vill $year,$from,$to,'$prov',$fdc")->result();
		$data['mapAber'] = $this->db->query("SP_Dashboard_MapAber $year,$from,$to,'$prov',$fdc")->result();
		$data['mapFoci'] = $this->db->query("SP_Dashboard_MapFoci $year,$from,$to,'$prov',$fdc")->result();
		$data['mapODInc'] = $this->db->query("SP_Dashboard_MapODInc $year,$from,$to,'$prov',$fdc")->result();

		$this->output->set_output(json_encode($data));
	}

	public function tabTable()
	{
		$year = $this->input->post('year');
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$prov = $this->input->post('prov');
		$fdc = $this->input->post('filterDateCase');

		if ($prov == '' && $_SESSION['prov'] != '') $prov = $_SESSION['prov'];

		$data['tableSpecieProvinceMonth'] = $this->db->query("SP_Dashboard_TableSpecieProvinceMonth $year,$from,$to,'$prov',$fdc")->result();
		$data['tableSevereMonth'] = $this->db->query("SP_Dashboard_TableSevereMonth $year,$from,$to,'$prov',$fdc")->result();
		$data['tableAgeSex'] = $this->db->query("SP_Dashboard_TableAgeSex $year,$from,$to,'$prov',$fdc")->result();
		$data['tableAgeSexSpecie'] = $this->db->query("SP_Dashboard_TableAgeSexSpecie $year,$from,$to,'$prov',$fdc")->result();
		$data['tableAgeSexSevere'] = $this->db->query("SP_Dashboard_TableAgeSexSevere $year,$from,$to,'$prov',$fdc")->result();

		$this->output->set_output(json_encode($data));
	}

	public function tabOutbreakDetection()
    {
        $yearFrom = 2017;
        $yearTo   = 2022;
        $prov     = $this->input->post('pv');
        $od       = $this->input->post('od');
        $hc       = $this->input->post('hc');
        $v        = $this->input->post('v');
        $f        = $this->input->post('f');
        $m        = $this->input->post('m');
		$fdc      = $this->input->post('filterDateCase');

        $data['outbreakDetection'] = $this->db->query("SP_Dashboard_OutbreakDetection $yearFrom,$yearTo,'$prov','$od','$hc','$v','$f','$m',$fdc")->result_array();
        $data['hfvmwPC'] = $this->db->query("SP_Dashboard_HFWMWPositiveCase $yearFrom,$yearTo,'$prov','$od','$hc','$v','$f','$m',$fdc")->result_array();
        $data['hfReportCompleteness'] = $this->db->query("SP_Dashboard_HFReportCompleteness $yearFrom,$yearTo,'$prov','$od','$hc'")->result_array();
        $data['vmwReportCompleteness'] = $this->db->query("SP_Dashboard_VMWReportCompleteness $yearFrom,$yearTo,'$prov','$od','$hc'")->result_array();
        $this->output->set_output(json_encode($data));
    }

    public function tabIntensification()
    {
		$year = $this->input->post('year');
		$from = $this->input->post('from');
		$to   = $this->input->post('to');
		$prov = $this->input->post('prov');
		$ip   = $this->input->post('ip');
		$fdc  = $this->input->post('filterDateCase');

		$data['chartIntensification'] = $this->db->query("SP_Dashboard_ChartIntensification $year,$from,$to,'$prov',$ip,$fdc")->result();
		$data['chartIntensificationTop10Vill'] = $this->db->query("SP_Dashboard_ChartIntensificationTop10Vill $year,$from,$to,'$prov',$ip,$fdc")->result();
		$data['tableOutreach'] = $this->db->query("SP_Dashboard_IP2TableOutreach $year,$from,$to,'$prov',$fdc")->result();
		$data['IP2Map'] = $this->db->query("SP_Dashboard_IP2Map $year,$from,$to,'$prov',$fdc")->result();
		$data['IP2SLDP'] = $this->db->query("SP_Dashboard_IP2SLDP $year,$from,$to,'$prov',$fdc")->result();
		$data['placeCount'] = $this->getIPPlaceCount($ip);

        $this->output->set_output(json_encode($data));
    }

	public function tabPFMap()
    {
		$year = $this->input->post('year');
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$prov = $this->input->post('prov');
		$fdc = $this->input->post('filterDateCase');

		$rs['pfMap'] = $this->db->query("SP_Dashboard_PFMap $year,$from,$to,'$prov',$fdc")->result();
		$rs['pfMapCount'] = $this->db->query("SP_Dashboard_PFMapCount $year,$from,$to,'$prov',$fdc")->result();

        $this->output->set_output(json_encode($rs));
    }

    public function tabDoc()
    {
        $sql = "select * from tblDocument order by PublishYear desc";
        $rs = $this->db->query($sql)->result();
        $this->output->set_output(json_encode($rs));
    }

    public function getAPIVill()
    {
        $year = $this->input->post('year');
		$from = $this->input->post('from');
		$to   = $this->input->post('to');
        $prov = $this->input->post('pv');
        $od   = $this->input->post('od');
        $hc   = $this->input->post('hc');
        $v    = $this->input->post('v');
        $f    = $this->input->post('f');
        $m    = $this->input->post('m');
		$fdc  = $this->input->post('filterDateCase');

		$data['apiVill'] = $this->db->query("SP_Dashboard_APIByVillageMap $year,$from,$to,'$prov','$od','$hc','','$v','$f','$m',$fdc")->result();
        $this->output->set_output(json_encode($data));
    }

	public function exportExcel()
	{
		set_time_limit(0);
		$tab = $this->input->post('tab');
		$images = $this->input->post('images');
		$tempFolder = TEMPPATH . GUID();

		mkdir($tempFolder);
		for ($i = 0; $i < count($images); $i++)
		{
			file_put_contents("$tempFolder\\$i.png", base64_decode($images[$i]));
		}

		$args['tab'] = $tab;
		$args['tempFolder'] = $tempFolder;
		$args = base64_encode(json_encode($args));

		$path = FCPATH . '\media\ExportExcel\MISExcel.exe';
		//$path = 'D:\Projects\MIS Excel\MIS Excel\bin\Release\MISExcel.exe';
		$filepathOrError = exec("\"$path\" Dashboard $args");
		if (strpos($filepathOrError, 'Error') === 0) {
			$error = 'MISExcel.exe: ' . base64_decode(explode(':', $filepathOrError)[1]);
			$error = str_replace("\r\n", '<br>', $error);
			show_error($error);
		}
		$this->output->set_header('Content-Length: ' . filesize($filepathOrError));
		$this->output->set_content_type('xlsx');
		$this->output->set_output(file_get_contents($filepathOrError));
		unlink($filepathOrError);
	}

	public function ipMapPopup($hfcode, $yearmonth)
	{
		$data['title'] = "Malaria Dashboard";
		$data['main'] = 'dashboard_ipmappopup_view';

		$yearmonth = $yearmonth == 'all' ? ">= '201912'" : "= '$yearmonth'";

		$sql = "select Name_Vill_E, Lat, long, count(*) as Positive
				from (
					select Name_Vill_E, Lat, long
					from tblHFActivityCases as a
					left join tblCensusVillage as b on a.Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS = b.Code_Vill_T
					where Positive = 'P' and Year + Month $yearmonth and ID = '$hfcode'
					union all
					select Name_Vill_E, Lat, long
					from tblCensusVillage as a
					join tblVMWActivityCases as b on a.Code_Vill_T = b.ID
					where Positive = 'P' and Year + Month $yearmonth and HCCode = '$hfcode'
				) as a group by Name_Vill_E, Lat, long";

		$data['data']['list'] = $this->db->query($sql)->result();

		$sql = "select Name_Facility_E, Lat, long from tblHFCodes where Code_Facility_T = '$hfcode'";
		$data['data']['hc'] = $this->db->query($sql)->row();

		$this->load->view('layout', $data);
	}

	private function getIPPlaceCount($ip)
	{
		$colIP = $ip == 1 ? 'IP1' : 'IP2';
		$sql = "select Code_Facility_T
					  ,sum(iif(HaveVMW = 1 and Name_Vill_E not like '%(M)',1,0)) as VMW
					  ,sum(iif(b.$colIP = 0 and Name_Vill_E like '%(M)',1,0)) as MMW
					  ,sum(iif(b.$colIP = 1,1,0)) as MMWIP
				from tblHFCodes as a
				join tblCensusVillage as b on a.Code_Facility_T = b.HCCode
				where a.$colIP = 1
				group by Code_Facility_T";

		return $this->db->query($sql)->result();
	}

	public function googleMapTester()
	{
		$this->load->view('googleMapTester_view');
	}

    private function setGuestMode() {
        $sql = "select GroupName, Permission
				from MIS_PermissionGroup as a
				join MIS_Permission as b on a.GroupID = b.GroupID
				join MIS_RolePermission as c on b.PermissionID = c.PermissionID
				where Role = 'GUEST'";
        $rs = $this->db->query($sql)->result();

        $permiss = [];
        foreach ($rs as $v)
        {
            if (!isset($permiss[$v->GroupName])) $permiss[$v->GroupName] = [];
            $permiss[$v->GroupName][] = $v->Permission;
        }
        $_SESSION['permiss'] = $permiss;
        $_SESSION['username'] = 'GUEST';
        $_SESSION['role'] = 'GUEST';
        $_SESSION['code_prov'] = '';
        $_SESSION['prov']    = '';
        $_SESSION['code_od'] = '';
        $_SESSION['code_rg'] = '';
    }

    private function isGuest(){
        if (!isset($_SESSION['username']) && !isset($_SESSION['role']) || $_SESSION['role'] == 'GUEST') return true;
        else return false;
    }

    public function getDailyCase()
    {
        $specie = $this->input->post('specie');
        $sql = $this->getCaseSql();
        $sql .= " where CAST(DateCase as DATE) = CAST(GETDATE() as DATE)";
        $sql .= " and Diagnosis = '{$specie}' order by Rec_ID desc";

        $rs = $this->db->query( $sql )->result();

        $this->output->set_output(json_encode($rs));
    }

    public function getMonthlyCase()
    {
        $specie = $this->input->post('specie');
        $month = $this->input->post('month');
        $sql = $this->getCaseSql();
        $sql .= " where Year = Year(GETDATE()) and Month = '$month'";
        $sql .= " and Diagnosis in ('{$specie}') order by Rec_ID desc";

        $rs = $this->db->query( $sql )->result();

        $this->output->set_output(json_encode($rs));
    }

    public function getPfMix()
    {
        $hc = $this->input->post('Code_Facility_T');
        $year = $this->input->post('Year');
        $from = $this->input->post('From');
        $to = $this->input->post('To');

        $sql = $this->getCaseSql();
        $sql .= " where Year = {$year} and Month between {$from} and {$to}";
        $sql .= " and Diagnosis in ('F', 'M') and Code_Facility_T = '{$hc}' order by Name_OD_E, Name_Facility_E";

        $rs = $this->db->query( $sql )->result();

        $this->output->set_output(json_encode($rs));
    }

    private function getCaseSql()
    {
        return "WITH T as (
	            select
	            d.Name_Prov_E, c.Name_OD_E,Name_Facility_E, c.Code_Facility_T, iif(Name_Vill_E is null, a.Code_Vill_t, Name_Vill_E) as Village
	            , Month, Year, NameK, a.Diagnosis, a.Age, a.Sex, a.DateCase, a.Rec_ID

				,CASE WHEN Classify = 'LocallyAcquired' or (Classify is null and L1 = 1) THEN 'L1'
				WHEN Classify = 'DomesticallyImported' or (Classify is null and LC = 1) THEN 'LC'
				WHEN Classify = 'InternationalImported' or (Classify is null and IMP = 1) THEN 'IMP'
				WHEN Classify = 'Relapse' or (Classify is null and Relapse = 1) THEN 'Relapse'
				WHEN Classify = 'Induce' THEN 'Induce'
				END as Clasify


	            from tblHFActivityCases as a
	            left join tblCensusVillage as b on a.Code_Vill_t = b.Code_Vill_T
	            join tblHFCodes as c on a.ID = c.Code_Facility_T
				join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				left join tblMRRT_CICC as e on a.Rec_ID = e.Case_ID and e.Case_Type = 'HC'
	            where a.Diagnosis <> 'N' and c.IsTarget=1

	            union all

	            select
	            d.Name_Prov_E,c.Name_OD_E,Name_Facility_E, c.Code_Facility_T,Name_Vill_E,
	            Month, Year, NameK, a.Diagnosis, a.Age, a.Sex, a.DateCase, a.Rec_ID

				,CASE WHEN Classify = 'LocallyAcquired' or (Classify is null and L1 = 1) THEN 'L1'
				WHEN Classify = 'DomesticallyImported' or (Classify is null and LC = 1) THEN 'LC'
				WHEN Classify = 'InternationalImported' or (Classify is null and IMP = 1) THEN 'IMP'
				WHEN Classify = 'Relapse' or (Classify is null and Relapse = 1) THEN 'Relapse'
				WHEN Classify = 'Induce' THEN 'Induce'
				END as Clasify

	            from tblVMWActivityCases as a
	            join tblCensusVillage as b on b.Code_Vill_T = a.ID
	            join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				left join tblMRRT_CICC as e on a.Rec_ID = e.Case_ID and e.Case_Type = 'VMW'
	            where a.Diagnosis <> 'N' and c.IsTarget=1
            )

            select * from T  ";
    }

	public function stockPopup()
	{
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$prov = $this->input->post('prov');
		$type = $this->input->post('type');

		if ($prov == '' && $_SESSION['prov'] != '') $prov = $_SESSION['prov'];

		$rs = $this->db->query("SP_Dashboard_StockIncomplete{$type} $year,$month,'$prov'")->result();

		$this->output->set_output(json_encode($rs));
	}
}