<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invitation extends CI_Controller {

    public function index($eventId, $participantId = 0)
    {
        $data['eventId'] = $eventId;
        $data['participantId'] = $participantId;

		$participant =  $this->getParticipant($participantId);

		$data['participant'] = json_encode($participant);

        $this->load->view('invitation2_view', $data);
    }

    private function getParticipant($participantId)
	{
		$sql = "select * from tblEventParticipant where Rec_ID = '$participantId'";
		return  $this->db->query($sql)->row();
	}

    public function getData()
    {
        $recId = $this->input->post('Rec_ID');
        $rs =  $this->db->get_where('tblEvent', ['Rec_ID'=> $recId])->row();

        $this->output->set_output(json_encode($rs));
    }

    public function getList()
    {
        $data['title'] = 'event';
		$data['main'] = 'event_view';
		$this->load->view('layout', $data);
    }

    public function confirm()
    {
        $submit = $this->input->post('submit');
        $submit['ConfirmedDate'] = sqlNow();

        $where['Rec_ID'] = $submit['Rec_ID'];
        unset($submit['Rec_ID']);

        $uuid = uniqid();

        if($where['Rec_ID'] == 0) {
            $submit['Rec_ID'] = $uuid;
            $this->db->insert('tblEventParticipant', $submit);
        } else {
            $this->db->update('tblEventParticipant', $submit, $where);
        }

        $participant = $this->db->get_where('tblEventParticipant', ['Rec_ID' => $uuid])->row();

        $this->output->set_output(json_encode($participant));
    }
}