<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Document extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function list_get()
	{
        $sql = "select Rec_ID, Title, PublishYear, Thumbnail, FileName, Language from tblDocument order by PublishYear desc";
        $rs = $this->db->query( $sql )->result_array();

        array_walk($rs, function (&$a, $k) {
		    $a['File'] = $_SERVER['SERVER_NAME'] . '/media/Documents/' . $a['FileName'];
		    $a['Thumbnail'] = $_SERVER['SERVER_NAME'] . '/media/Documents/Thumbnail/' . $a['Thumbnail'];
            unset($a['FileName']);
		});

        $response = [
			"code"		=> 200,
			"message"	=> "success",
			"data"		=> $rs
		];

		$this->response($response);
    }

}