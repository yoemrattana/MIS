<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MISData extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$auth = $this->input->get_request_header('Authorization');

		if (base64_decode(substr($auth, 6)) != 'cnm:CNM@2024api!') {
			$this->output->set_status_header(401);
			echo 'Unauthorized';
			exit;
		}

		set_time_limit(0);
		ini_set('memory_limit', '-1');
	}

    public function slide()
    {
		$fields = $this->input->get('fields') ?? '*';
		$where = $this->input->get('where');

		$rs = $this->db->select($fields)->get_where('V_MISDataSlide', $where)->result();

		$this->output->json($rs);
    }

    public function dipstick()
    {
		$fields = $this->input->get('fields') ?? '*';
		$where = $this->input->get('where');

		$rs = $this->db->select($fields)->get_where('V_MISDataDipstick', $where)->result();

		$this->output->json($rs);
    }

    public function dipstickByVMW()
    {
		$fields = $this->input->get('fields') ?? '*';
		$where = $this->input->get('where');

		$rs = $this->db->select($fields)->get_where('V_MISDataVMW', $where)->result();

		$this->output->json($rs);
    }

	public function treatment()
    {
		$fields = $this->input->get('fields') ?? '*';
		$where = $this->input->get('where');

		$rs = $this->db->select($fields)->get_where('V_MISDataTreat', $where)->result();

		$this->output->json($rs);
    }
}