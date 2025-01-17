<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller
{
	public function index()
	{
        if ($_SESSION['role'] != 'AU') redirect('Home');

		$data['title'] = 'User Management';
		$data['main'] = 'user_view';

		$this->load->view('layout', $data);
	}

    public function getAllData()
    {
        $sql = "select ID, Us, Ps, Role, Code_Prov, Code_OD, Code_HC, Code_RG, Code_Unit, Code_Prov_Notification, Code_OD_Notification, Specie_Notification from MIS_User order by Us";
		$rs['user'] = $this->db->query($sql)->result();

        $sql = "select * from MIS_Role";
        $rs['role'] = $this->db->query($sql)->result();

        $sql = "select * from MIS_PermissionGroup order by GroupName";
        $rs['permissGroup'] = $this->db->query($sql)->result();

        $sql = "select * from MIS_Permission order by Permission";
        $rs['permiss'] = $this->db->query($sql)->result();

        $sql = "select * from MIS_RolePermission";
        $rs['rolePermiss'] = $this->db->query($sql)->result();

        $this->output->set_output(json_encode($rs));
    }

	public function saveUser()
	{
		$submit = $this->input->post('submit');

		if ($submit['ID'] == '') {
			unset($submit['ID']);
			$submit['Activate'] = 1;
			$this->db->insert('MIS_User', $submit);
		} else {
			unset($submit['ID']);
			$where['Us'] = $submit['Us'];
			$this->db->update('MIS_User', $submit, $where);
		}

		$sql = "select * from MIS_User where Us = '{$submit['Us']}'";
		$rs = $this->db->query($sql)->row();

		$this->output->set_output(json_encode($rs));
	}

	public function deleteUser()
	{
		$where['Us'] = $this->input->post('us');
		$this->db->delete('MIS_User', $where);
	}

	public function saveRole()
	{
		$role = $this->input->post('Role');
		$pid = $this->input->post('PermissionID');

		if ($pid == null) $pid = [];

		$this->db->delete('MIS_RolePermission', ['Role' => $role]);
		foreach ($pid as $id)
		{
			$value['Role'] = $role;
			$value['PermissionID'] = $id;
			$this->db->insert('MIS_RolePermission', $value);
		}
	}

	public function getUserInfo()
	{
		$sql = "select Us as username, role, Code_Prov as prov, Code_OD as od, Code_RG as rg
				from MIS_User where Activate = 1 and Role <> 'GUEST'";
		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}
}