<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . '/vendor/autoload.php';
use Message\MultiMessage;
use Message\MessageSender;

class Broadcast extends CI_Controller
{
	private $tokenArr = [
		'cxV4ZTNRTf2sUsaYPITY8i:APA91bEjQqwHsshl-fwW84Sp4XJ4M2mj4UkW1PzjcZZMstpOO3XX22wvQobfqjS1aPm2RHP4NegO8XMgcZnRi1D_IoSJeMQm6ifAlF8Auy9KO68rZ2s0uifYE9MvqxVFM8Cb8ksBTc9B',
		'cghGE-BQX0o:APA91bGGZDlM6eo2OL_dHodYYZmhtFrZcRoYcuvclGF3aLpB_wf5_vS1GGKr1x6KhTqR4XCoRpqrZJSKl4wjit2kWBPT3cMH9Q_iegBaPME6w5MiPOUGsIsmVsenivUM8F311RAkQYu3'
	];

	public function index()
	{
		if ($_SESSION['role'] != 'AU') redirect('Home');

		$data['title'] = "Broadcast";
		$data['main'] = 'broadcast_view';

		$this->load->view('layoutV3', $data);
	}

	public function getData()
	{
		$sql = "select top 30 * from tblBroadcastLog order by Rec_ID desc";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function send()
	{
		$recipient = $this->input->post('recipient');
		$isLogedin = $this->input->post('logedin');
		$title = $this->input->post('title');
		$body = $this->input->post('body');

		$tokenArr = $this->getTokens($recipient, $isLogedin);
		$tokenArr = array_chunk($tokenArr, 999);

		$msg = new MultiMessage();
		$sender = new MessageSender( $msg );

		foreach( $tokenArr as $tokens ) {
			$msg->setMessage( $tokens, $title, $body );
			$sender->send();
		}

		$data = [
			'Title' => $title,
			'Recipient' => $recipient,
			'Message' => $body,
			'InitTime' => sqlNow()
		];

		$this->log($data);
	}

	private function getTokens($recipient, $isLogedin)
	{
		if( $recipient == 'vmw' ) $sql = "select Token from tblToken where len(CodePlace) = 10";
		else if( $recipient == 'hc' ) $sql = "select Token from tblToken where len(CodePlace) = 6";
		else if( $recipient == 'cmi' ) $sql = "select Token from tblMalariaInfoToken";
		else if( $recipient == 'cmi' && $isLogedin) $sql = "select Token from tblMalariaInfoToken where Username is not null or Username <> ''";
		else $sql = "select Token from tblMalariaInfoToken union all select Token from tblToken";

		$tokens = $this->db->query($sql)->result_array();
		return array_flatten($tokens);
	}

	private function log($data)
	{
		$this->db->insert('tblBroadCastLog', $data);
	}
}