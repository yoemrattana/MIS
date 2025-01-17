<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Chart extends REST_Controller
{
    public function cases_post()
    {
        $year = $this->post('year');
        $mf = $this->post('mf');
        $mt = $this->post('mt');
        $hf = $this->post('hc_code');

        $sql = "SP_API_MalariaCases '$hf', '$year', '$mf', '$mt'";
        $rs = $this->db->query($sql)->result();

        $this->response($rs);
    }

    public function piechart_post()
    {
        $year = $this->post('year');
        $mf = $this->post('mf');
        $mt = $this->post('mt');
        $hf = $this->post('hc_code');

        $sql = "SP_API_PieChartTop10Villages '$hf', '$year', '$mf', '$mt'";
        $rs = $this->db->query($sql)->result();

        $this->response($rs);
    }

    public function api_villages_post()
    {
        $year = $this->post('year');
        $mf = $this->post('mf');
        $mt = $this->post('mt');
        $hf = $this->post('hc_code');

        $sql = "SP_API_APIVillages '$hf', '$year', '$mf', '$mt'";
        $rs = $this->db->query($sql)->result();

        $this->response($rs);
    }
}