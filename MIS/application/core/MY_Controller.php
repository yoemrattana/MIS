<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	protected $submit;

	public function __construct()
	{
        parent::__construct();

		if (in_array(get_class($this), ['Dashboard', 'Login'])) return;
		if (strtolower($_SERVER['REQUEST_URI']) == '/home/getplace') return;

		if (!isset($_SESSION['username']) || get_class($this) == 'Home') {
			$usr = get_cookie('usr');
			$pwd = get_cookie('pwd');
			if ($usr && $pwd) {
			    $success = $this->UpdateLoginInfo($usr, $pwd);
			    if ($success) return;
			}

			if ($this->input->is_ajax_request()) show_unauthorized();
			else redirect('/login/logout');
		}

		if ($this->input->is_ajax_request()) {
			$this->submit = json_decode($this->input->raw_input_stream);
		}
	}

    protected function UpdateLoginInfo($usr, $pwd = null)
    {
        $row = $this->db->get_where('MIS_User', ['Us' => $usr])->row();
		if ($row == null) return false;

		if ($pwd == null) {
			$this->UpdateUserSession($row);
			return true;
		}

        strlen($pwd) < 60 && $pwd = password_hash($pwd, PASSWORD_BCRYPT);
        if (password_verify($row->Ps, $pwd)) {
			$this->UpdateUserSession($row);
			$this->UpdateCookie($row->Us, $pwd);

            $ip = $this->input->ip_address();
            if ($ip != '::1') {
                set_error_handler('_error_handler');
                $json = @json_decode(file_get_contents("https://api.ipgeolocation.io/ipgeo?apiKey=242027f31cad42d39b0087fd5e8ec7e7&ip=$ip"));
                restore_error_handler();

                if (isset($json->country_name)) {
                    $value['Username'] = $_SESSION['username'];
                    $value['Module'] = 'System';
                    $value['Country'] = $json->country_name;
                    $value['City'] = $json->city != '' ? $json->city : $json->state_prov;
                    $this->db->insert('tblAccessLog', $value);
                }
            }
            return true;
        }

        return false;
    }

	protected function UpdateCookie($usr, $pwd)
	{
		set_cookie('usr', $usr, strtotime('+2 years') - time());
		set_cookie('pwd', $pwd, strtotime('+2 years') - time());
	}

	private function UpdateUserSession($row)
	{
		$_SESSION['username'] = $row->Us;
		$_SESSION['role'] = $row->Role;
		$_SESSION['code_prov'] = implode("','", explode(',', $row->Code_Prov));
		$_SESSION['prov'] = $row->Code_Prov;
		$_SESSION['code_od'] = $row->Code_OD;
		$_SESSION['code_hc'] = $row->Code_HC;
		$_SESSION['code_rg'] = $row->Code_RG;
		$_SESSION['code_unit'] = $row->Code_Unit;

		$sql = "select GroupName, Permission
				from MIS_PermissionGroup as a
				join MIS_Permission as b on a.GroupID = b.GroupID
				join MIS_RolePermission as c on b.PermissionID = c.PermissionID
				where Role = '{$row->Role}'";
		$rs = $this->db->query($sql)->result();

		$permiss = [];
		foreach ($rs as $v)
		{
			if (!isset($permiss[$v->GroupName])) $permiss[$v->GroupName] = [];
			$permiss[$v->GroupName][] = $v->Permission;
		}
		$_SESSION['permiss'] = $permiss;
	}
}