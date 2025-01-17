<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller
{
	public function index()
	{
		if (isset($_SESSION['username']) && $_SESSION['role'] != 'GUEST') redirect('/Home');

        $usr = get_cookie('usr');
		$pwd = get_cookie('pwd');
		if ($usr && $pwd) {
            $success = $this->UpdateLoginInfo($usr, $pwd);
            if ($success) redirect('/Home');
        }

		if ($usr = $this->input->post('username')) {
            $pwd = $this->input->post('password');
            $success = $this->UpdateLoginInfo($usr, $pwd);

            if ($success) redirect('Home');
			else redirect('/Dashboard/index/true');
		}

        redirect('/Dashboard');
	}

	public function logout()
	{
		$quick = get_cookie('quick');

		session_unset();
		delete_cookie('usr');
		delete_cookie('pwd');
		delete_cookie('quick');

		$quick == 1 ? redirect('/login/quick') : redirect('/');
	}

	public function quick()
	{
		if (isset($_SESSION['username']) && $_SESSION['role'] != 'GUEST') redirect('/Home');

		$data['invalid'] = false;

		$usr = get_cookie('usr');
		$pwd = get_cookie('pwd');

		if (!$usr || !$pwd) {
		    $usr = $this->input->post('usr');
		    $pwd = $this->input->post('pwd');
		}

		if ($usr && $pwd) {
		    $success = $this->UpdateLoginInfo($usr, $pwd);
		    set_cookie('quick', 1, strtotime('+2 years') - time());

		    if ($success) redirect('/Home');

		    $data['invalid'] = true;
		}

		$this->load->view('login_view', $data);
	}

	public function pwa()
	{
		$usr = $this->input->post('usr');
		$pwd = $this->input->post('pwd');

		$row = $this->db->get_where('MIS_User', ['Us' => $usr])->row();
		$rs = 'incorrect';

		if ($row != null) {
			$pwd = password_hash($pwd, PASSWORD_BCRYPT);
			if (password_verify($row->Ps, $pwd)) {
				$this->UpdateCookie($row->Us, $pwd);
				$rs = 'correct';
			}
		}

		$this->output->set_output(json_encode($rs));
	}
}