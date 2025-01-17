<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Telegram extends CI_Controller
{
	public function acceptDevice($type, $id, $obj = null)
	{
		$value = ['Active' => 1, 'ExpireEntry' => 0, 'AutoPhone' => 1, 'TelegramMsg' => null];
		$where = ['Rec_ID' => $id];

		if ($type == 'hf') {
			$table = 'tblHFDevice';
			$value['ExpireStock'] = 0;
		} else {
			$table = 'tblVMWDevice';
		}

		$json = $this->db->get_where($table, $where)->row('TelegramMsg');

		$this->db->update($table, $value, $where);
		$this->updateMessage($table, $json, $obj, 'Accepted');
	}

	public function deleteDevice($type, $id, $obj = null)
	{
		$table = $type == 'hf' ? 'tblHFDevice' : 'tblVMWDevice';
		$where = ['Rec_ID' => $id];

		$json = $this->db->get_where($table, $where)->row('TelegramMsg');

		$this->db->delete($table, $where);
		$this->updateMessage($table, $json, $obj, 'Deleted');
	}

	public function onCallback()
	{
		$obj = json_decode($this->input->raw_input_stream)->callback_query;
		list($action, $type, $id) = explode(',', $obj->data);

		if ($action == 'accept') {
			$this->acceptDevice($type, $id, $obj);
		} else {
			$this->deleteDevice($type, $id, $obj);
		}
	}

	private function updateMessage($table, $json, $obj, $action)
	{
		if ($obj == null) {
			$name = $_SESSION['username'] ?? 'admin';
		} else {
			$first = $obj->from->first_name ?? '';
			$last = $obj->from->last_name ?? '';
			$name = strlen($first) < strlen($last) ? $first.' '.$last : $last.' '.$first;
			$name = trim($name);
		}

		$url = '';
		$client = new GuzzleHttp\Client();
        $msgId = null;

		if ($json == null) {
            if ($obj != null) {
                $msgId = $obj->message->message_id;
                $text = str_replace('Version: ', 'Version: <code>', $obj->message->text) . '</code>';
            }
		} else {
			$msg = json_decode($json);
			$msgId = $msg->id;
			$text = $msg->text;
		}

        if ($msgId != null) {
            $client->post($url . '/editMessageText', [
                'verify' => FCPATH . '/media/ca-bundle.crt',
                'json' => [
                    'chat_id' => '',
                    'message_id' => $msgId,
                    'parse_mode' => 'HTML',
                    'text' => $text . "\n\n$action: $name"
                ]
            ]);
        }

		if ($obj != null) {
			$client->post($url . '/answerCallbackQuery', [
				'verify' => FCPATH . '/media/ca-bundle.crt',
				'json' => ['callback_query_id' => $obj->id]
			]);
		}
	}
}
