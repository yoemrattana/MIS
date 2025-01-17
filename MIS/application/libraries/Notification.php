<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification
{
	private $CI;
	function __construct() {
		$this->CI = & get_instance();
	}

	public function getTemplate($template)
	{
		$body = '';
		switch($template) {
			case 'VMW':
				$sql = "select * from tblSetting where Name = 'VMWTemplate'";
				$body = $this->CI->db->query($sql)->row('Value');
				break;
			case 'HC':
				$sql = "select * from tblSetting where Name = 'HFTemplate'";
				$body =  $this->CI->db->query($sql)->row('Value');
				break;
			case 'OD':
				$sql = "select * from tblSetting where Name = 'ODTemplate'";
				$body =  $this->CI->db->query($sql)->row('Value');
				break;
			case 'Stock':
				$sql = "select * from tblSetting where Name = 'StockHFTemplate'";
				$body = $this->CI->db->query($sql)->row('Value');
				break;
		}
		return $body;
	}

	public function notify($msg)
	{
		ini_set('MAX_EXECUTION_TIME', '-1');

		$url = 'https://fcm.googleapis.com/fcm/send';
	    $headers = array(
	        'Authorization: key=' . FIREBASE_TOKEN,
	        'Content-Type: application/json'
	    );

	    $ch = curl_init();

	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($msg));

	    $result = curl_exec($ch);

		//file_put_contents('c:\Note.txt', print_r($result, true));

	    curl_close($ch);
	}

	public function logCase($data)
	{
		if( empty($data['Imei']) ) return;

		$this->CI->db->insert("tblNotificationLog", $data);
	}

	public function logStock($data)
	{
		if( empty($data['Imei']) ) return;

		$this->CI->db->insert("tblNotificationLog", $data);
	}
}