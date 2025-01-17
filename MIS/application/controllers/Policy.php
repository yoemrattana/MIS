<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Policy extends CI_Controller
{
	public function index()
    {
        $this->load->view('policy/cmi_view');
    }

	public function qa()
	{
		$this->load->view('policy/qa_view');
	}

	public function checklist()
	{
		$this->load->view('policy/checklist_view');
	}
}