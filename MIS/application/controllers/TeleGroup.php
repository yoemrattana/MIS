<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TeleGroup extends CI_Controller
{
	public function index()
	{
		if ($_SESSION['role'] != 'AU') redirect('Home');

		$data['title'] = "Telegram Group";
		$data['main'] = 'telegroup_view';

		$this->load->vars( $data );
		$this->load->view('layoutV3', $data);
	}

	public function getData()
	{
		$rs = $this->db->get('tblTelegramGroup')->result();
		$this->output->set_output( json_encode( $rs ) );
	}


	public function save()
	{
		$submit = $this->input->post('submit');
		$submit = json_decode($submit, true);

		$recID = $submit['Rec_ID'];
		unset($submit['Rec_ID']);

		if( empty ( $recID ) ) {
			$this->db->insert( 'tblTelegramGroup', $submit );
			$recID = $this->db->insert_id();
		} else {
			$this->db->update( 'tblTelegramGroup', $submit, ['Rec_ID' => $recID]);
		}

		$row = $this->db->get_where( 'tblTelegramGroup', ['Rec_ID' => $recID] )->row();
		$this->output->set_output( json_encode( $row ) );
	}

	public function delete()
	{
		$recID = $this->input->post('rec_id');
		$this->db->delete('tblTelegramGroup', ['Rec_ID' => $recID]);
	}

	public function getRequest() {
		$client = new GuzzleHttp\Client();
		$url = "";

		$res =  $client->get($url, [
		    'verify' => FCPATH . '/media/ca-bundle.crt',
		]);

		$rs = $res->getBody()->getContents();

		$this->output->set_output( json_encode( $rs ) );
	}

    public function getMessage()
    {
        $groupId = $this->input->post('groupId');

        $sql = "select * from tblLogTelegramMsg
                where InitTime < DATEADD(DAY, 30, InitTime)
                and GroupID = '{$groupId}'
                order by InitTime desc";
        $rs = $this->db->query( $sql )->result();

        $this->output->set_output( json_encode( $rs ) );
    }
}
