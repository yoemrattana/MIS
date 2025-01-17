<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mission extends MY_Controller
{
	public function index()
	{
        if ($_SESSION['role'] != 'AU') redirect('Home');

		$data['title'] = 'Mission';
		$data['main'] = 'mission_view';
		$this->load->view('layout', $data);
	}

	public function getData()
	{
		$year = $this->input->post('year');

		$sql = "select * from tblMission where year(DateFrom) = $year";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

    public function getQuarter()
    {
        $year = $this->input->post('year');

		$sql = "select *, isnull(Q1, 0)+isnull(Q2, 0)+isnull(Q3, 0)+isnull(Q4, 0) as Total from
                (
	                select Name, CONCAT('Q', DATEPART(quarter, DateFrom)) as Q, count(*) as Trip
	                from tblMission  where year(DateFrom) = $year
	                group by DATEPART(quarter, DateFrom) , Name
                ) as sub
                pivot(
	                sum(Trip) for
	                Q in ([Q1], [Q2], [Q3], [Q4])
                ) p
                order by Total desc";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
    }

	public function save()
	{
		$model = $this->input->post();

		$names = $model['names'];
		unset($model['names']);

		$rs = [];
		foreach ($names as $name)
		{
			$model['Name'] = $name;
			$this->db->insert('tblMission', $model);

			$id = $this->db->insert_id();
			$rs[] = $this->db->get_where('tblMission', "Rec_ID = $id")->row();
		}

		$this->output->set_output(json_encode($rs));
	}
}