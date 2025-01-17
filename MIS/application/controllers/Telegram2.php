<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Telegram2 extends CI_Controller
{
	public function callback()
    {
        $teleQuery = json_decode($this->input->raw_input_stream)->callback_query;
		list($action, $type, $id) = explode(',', $teleQuery->data);

        if ($action == 'accept') {
			$this->confirmCase($type, $id, $teleQuery);
		} else {
            $this->reject($id, $teleQuery);
		}
    }

    public function confirmCase($type, $recId, $teleQuery = null)
    {
        $data = $this->getPreConfirmCase($recId);
        $case = json_decode($data['Desciption'], true);
        $teleMsg = $data['TelegramMsg'];

        $this->updateMessage($teleMsg, $teleQuery, 'Accepted');

        $this->db->update('tblPreConfirmCase', ['IsConfirm'=>1], ['Rec_ID' => $recId]);

        if($type == 'VMW') $this->confirmCaseVMW($case);
        else $this->confirmCaseHF($case);
    }

    private function getPreConfirmCase($recId){
        return $this->get_where('tblPreConfirmCase', ['Rec_ID' => $recId])->result_array();
    }

    private function confirmCaseHF($description)
    {
        $data = json_decode($description, true);

        $this->db->insert('tblHFActivityCases', $data);
    }

    private function confirmCaseVMW($description)
    {
        $data = json_decode($description, true);

        $this->db->insert('tblVMWActivityCases', $data);
    }

    private function updateMessage($json, $obj, $action)
	{
		if ($obj == null) {
			$name = $_SESSION['username'] ?? 'admin';
		} else {
			$first = $obj->from->first_name ?? '';
			$last = $obj->from->last_name ?? '';
			$name = strlen($first) < strlen($last) ? $first.' '.$last : $last.' '.$first;
			$name = trim($name);
		}

		$url = 'https://api.telegram.org/id';
		$client = new GuzzleHttp\Client();
        $msgId = null;

		if ($json == null) {
            if ($obj != null) {
                $msgId = $obj->message->message_id;
                $text = $obj->message->text;
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

    private function reject($recId, $teleQuery)
    {
        $this->db->update('tblPreConfirmCase', ['IsConfirm' => 1], ['Rec_ID'=>$recId]);


        $data = $this->getPreConfirmCase($recId);
        $teleMsg = $data['TelegramMsg'];
        $this->updateMessage($teleMsg, $teleQuery, 'Rejected');
        $this->db->update('tblPreConfirmCase', ['IsConfirm'=>2], ['Rec_ID' => $recId]);
    }
}