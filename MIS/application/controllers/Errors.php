<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends CI_Controller
{
	public function error404()
    {
        $this->load->view('errors/error404');
    }
}