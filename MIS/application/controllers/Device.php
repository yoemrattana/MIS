<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device extends MY_Controller
{
	public function index()
	{
        if ($_SESSION['role'] != 'AU' && !isset($_SESSION['permiss']['Device Management'])) redirect('Home');

        $data['title'] = 'Device Management';
        $data['main'] = 'device_view';
        $this->load->vars($data);
        $this->load->view('layout', $data);
	}

	public function hfGetRequest()
	{
		$sql = "select a.Rec_ID, Name_Prov_E, Name_OD_E, a.Code_Facility_T, Name_Facility_E, Name_Facility_K, Imei, MalariaAppVersion, QAAppVersion, CreatedOn
				from tblHFDevice as a
				left join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
				left join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
				where Active is null order by CreatedOn";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function vmwGetRequest()
	{
		$sql = "select a.Rec_ID, Name_Prov_E, Name_OD_E, Name_Facility_E, a.Code_Vill_T, Name_Vill_E, Name_Vill_K, Imei, MalariaAppVersion, CreatedOn
				from tblVMWDevice as a
				left join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				left join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				left join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				where Active is null order by CreatedOn";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getCMIDevices()
	{
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$where = empty($month) ? '' : " and Month(StartDate) = $month";

		$sql = "select iif(isnull(UserName,'') = '','Guest',UserName) as UserName
					  ,StartDate, PhoneModel, Lat, Long, LastOnline, Imei, City, AppVersion, Role
					  ,iif(HasUserAccount = 1,'Yes','No') as HasUserAccount
					  ,iif(left(PhoneModel, 2) = 'iP', 'IOS', 'Android') as OS
					  ,stuff((select ', ' + Name_Prov_E from tblProvince where Code_Prov_T in (select * from dbo.Split(Code_Prov)) for xml path('')),1,1,'') as Province
					  ,stuff((select ', ' + Name_OD_E from tblOD where Code_OD_T in (select * from dbo.Split(Code_OD)) for xml path('')), 1, 1, '') as OD
				from tblDeviceMalInfo as a
				left join MIS_User as b on b.Us = a.UserName
				where Year(StartDate) = $year $where
				order by UserName desc";
		$rs['users'] = $this->db->query($sql)->result();

		$sql = "with t
				as
				(
					select distinct UserName from tblDeviceMalInfo where UserName is not null and UserName <> ''
					union all
					select 'Guest' as UserName from tblDeviceMalInfo where UserName is null or UserName = ''
				)

				select sum(iif(UserName = 'Guest', 1, 0)) as Guest, sum(iif(UserName <> 'Guest',1, 0)) as HasUserName from t";

		$rs['total'] = $this->db->query($sql)->row();

		$this->output->set_output(json_encode($rs));
	}

	public function getCMIMap()
	{
		$sql = "select Imei, iif(UserName is null or UserName = '', 'Guest', UserName) as UserName,
				iif(Role is null, 'Guest', Role) as Role, Lat, Long
				from tblDeviceMalInfo as a
				left join MIS_User as b on a.UserName = b.Us
				where Lat is not null
				group by Imei, UserName, Role, Lat, Long";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function hfDeviceList()
	{
		$sql = "select Code_Prov_N as Code_Prov_T, Code_OD_T, Name_OD_K, Name_Facility_K, Rec_ID, a.Code_Facility_T,Phone,NewPhone,Imei,
				MalariaAppVersion,MalariaAppUsage,OtherAppUsage,DateFrom,DateTo,
				Active,QAAppVersion,ExpireEntry,ExpireStock,AutoPhone,UpdatedOn,
				iif(Model in ('samsung SM-P615', 'samsung SM-T505'), Model, 'Other') as Model,
				iif(Model in ('samsung SM-P615', 'samsung SM-T505'), Model, concat('<span class=\"label label-danger\">Other</span> - ', Model)) as Model2
				from tblHFDevice as a
				join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
				where Active is not null --and (Model is null or left(Model, 6) <> 'LENOVO')
				order by Name_OD_E, Name_Facility_K";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function vmwDeviceList()
	{
		$sql = "select Code_Prov_N as Code_Prov_T, Code_OD_T, Name_OD_K, Code_Facility_T, Name_Facility_K, Name_Vill_K,
				Rec_ID,a.Code_Vill_T,Phone,NewPhone,Imei,
				iif(Model in ('samsung SM-A315G'), Model, 'Other') as Model,
				iif(Model in ('samsung SM-A315G'), Model, concat('<span class=\"label label-danger\">Other</span> - ', Model)) as Model2,
				MalariaAppVersion,MalariaAppUsage,OtherAppUsage,DateFrom,DateTo,Active,ExpireEntry,AutoPhone,UpdatedOn
				from tblVMWDevice as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				where Active is not null and left(Model, 3) <> 'ZTE' and left(Model, 5) <> 'SUGAR' and left(Model, 4) <> 'WIKO'
				order by Name_OD_E, Name_Facility_E, Name_Vill_K";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getDeviceLog()
	{
		$sql = "select Code_Prov_T, Name_Prov_E, Code_OD_T, Name_OD_E, Name_Facility_E, a.*
				from tblDeviceLog as a
				left join tblHFCodes as b on a.Code = b.Code_Facility_T
				left join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
				where len(Code) = 6
				order by Name_Prov_E, Name_OD_E, Name_Facility_E";
		$rs['hf'] = $this->db->query($sql)->result();

		$sql = "select d.Code_Prov_T, Name_Prov_E, Code_OD_T, Name_OD_E, Code_Facility_T, Name_Facility_E, Name_Vill_E, a.*
				from tblDeviceLog as a
				left join tblCensusVillage as b on a.Code = b.Code_Vill_T
				left join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				left join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				where len(Code) = 10
				order by Name_Prov_E, Name_OD_E, Name_Facility_E, Name_Vill_E";
		$rs['vmw'] = $this->db->query($sql)->result();

		$sql = "select distinct Code_Prov_T, Name_Prov_E, Code_OD_T, Name_OD_E, a.*
				from tblDeviceLog as a
				left join tblHFCodes as b on a.Code = b.Code_OD_T
				left join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
				where len(Code) = 4
				order by Name_Prov_E, Name_OD_E";
		$rs['od'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getDeviceMap()
	{
		$sql = "select Code_Prov_N pc, Name_Prov_E pe, Name_Prov_K pk,
				b.Code_OD_T oc, b.Name_OD_E oe, b.Name_OD_K ok,
				Code_Facility_T hc, Name_Facility_E he, Name_Facility_K hk,
				'' ve, '' vk, lat, long, Code_Facility_T code
				from tblHFCodes as b
				join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
				where convert(float,Lat) > 0 and convert(float,long) > 0
				union all
				select Code_Prov_N pc, Name_Prov_E pe, Name_Prov_K pk,
				b.Code_OD_T oc, b.Name_OD_E oe, b.Name_OD_K ok,
				Code_Facility_T hc, Name_Facility_E he, Name_Facility_K hk,
				Name_Vill_E ve, Name_Vill_K vk, a.lat, a.long, a.Code_Vill_T code
				from tblCensusVillage as a
				join tblHFCodes as b on a.HCCode = b.Code_Facility_T
				join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
				where HaveVMW = 1 and convert(float,a.Lat) > 0 and convert(float,a.long) > 0";
		$rs['place'] = $this->db->query($sql)->result();

		$sql = "select Code_Prov_N pc, Name_Prov_E pe, Name_Prov_K pk,
				Code_OD_T oc, Name_OD_E oe, Name_OD_K ok,
				a.Code_Facility_T hc, Name_Facility_E he, Name_Facility_K hk,
				'' ve, '' vk, a.lat, a.long, a.Code_Facility_T code, UpdatedOn ud
				from tblHFDevice as a
				join tblHFCodes as b on a.Code_Facility_T = b.Code_Facility_T
				join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
				where convert(float,a.Lat) > 0 and convert(float,a.Long) > 0 and Model in ('samsung SM-P615', 'samsung SM-T505')
				union all
				select Code_Prov_N pc, Name_Prov_E pe, Name_Prov_K pk,
				Code_OD_T oc, Name_OD_E oe, Name_OD_K ok,
				Code_Facility_T hc, Name_Facility_E he, Name_Facility_K hk,
				Name_Vill_E ve, Name_Vill_K vk, a.lat, a.long, a.Code_Vill_T code, UpdatedOn ud
				from tblVMWDevice as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				where convert(float,a.Lat) > 0 and convert(float,a.long) > 0 and Model = 'samsung SM-A315G'";
		$rs['device'] = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getAppVersion()
	{
		$path = FCPATH . '/media/MobileApp/info.json';
		$this->output->set_output(file_get_contents($path));
	}

	public function uploadApp()
	{
		$base64 = $this->input->post('base64');
		$path = FCPATH . '/media/MobileApp/cnm_app.apk';
		file_put_contents($path, base64_decode($base64));

		$info['name'] = $this->input->post('name');
		$info['version'] = $this->input->post('version');
		$path = FCPATH . '/media/MobileApp/info.json';
		file_put_contents($path, json_encode($info));
	}

    public function updateMD0()
    {
        $submit = json_decode($this->input->post('submitM'));
        $code = $submit->code;
        $phone = $submit->phone;
        $user = $submit->user;

        $code = strlen($code) == 10 ? substr($code, 0, 8) : $code;
        $phone = preg_replace('/^0/', '855', $phone);

        $client = new GuzzleHttp\Client();
        $baseUrl = '';
        $url = "";

        $params = [
            "Username" => $user,
	        "Password"=> '',
	        "Email" => "",
	        "Phone" => $phone,
	        "Place" => $code,
	        "Role"  => "Default",
	        "Status" => 1
        ];

        $re = $client->post($url, [
            'headers' => ['Content-type' => 'application/json'],
            'auth' => ['user', 'password'],
            'json' => $params,
        ]);
        return $re;
    }
}