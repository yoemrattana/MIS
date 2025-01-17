<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller
{
	public function index()
	{
		$data['linkDownload'] = '/media/MobileApp/CNM_App.apk';
		$this->load->view('app/mis', $data);
	}

	public function gallery()
	{
		$this->load->view('app/gallery');
	}

	public function web()
	{
		$this->load->view('app/web');
	}

	public function hc()
	{
		$this->load->view('app/hc');
	}

	public function vmw()
	{
		$this->load->view('app/vmw');
	}

	public function cmi()
	{
		$this->load->view('app/cmi');
	}

	public function qa()
	{
		$this->load->view('app/qa');
	}

	public function checklist()
	{
		$this->load->view('app/checklist');
	}
}