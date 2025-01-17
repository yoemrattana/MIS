<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Patient extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();

		$this->load->model('MPatient');
	}

    public function list_post()
	{
        $code = $this->post('maxPatientCode');

        $condition = $code == null ? "is not null" : "> '$code'";

        $sql = "select PatientCode, Fingerprint
                from tblHFActivityCases
                where Fingerprint is not null and PatientCode $condition
                union
                select PatientCode, Fingerprint
				from tblVMWActivityCases
				where Fingerprint is not null and PatientCode $condition";

        $rs = $this->db->query($sql)->result();
        $this->response($rs);
	}

	public function getNewCode_post()
	{
		$rs['PatientCode'] = $this->MPatient->getNewCode();
		$this->response($rs);
	}
}