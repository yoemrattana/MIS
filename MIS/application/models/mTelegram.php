<?php
class MTelegram extends CI_Model
{
	public function sendDeviceRequest($table, $code, $appVersion, $RecID)
	{
	    if ($table == 'tblHFDevice') {
	        $sql = "select Name_Prov_K, Name_OD_K, Name_Facility_K
	                from tblHFCodes as a
	                join tblProvince as b on a.Code_Prov_N = b.Code_Prov_T
	                where Code_Facility_T = '$code'";
	        $found = $this->db->query($sql)->row();

	        $text = "HF Device Request:\n"
	            . "Province: $found->Name_Prov_K\n"
	            . "OD: $found->Name_OD_K\n"
	            . "HF: $found->Name_Facility_K\n"
	            . "Version: <code>$appVersion</code>";

	        $type = 'hf';
	    } else {
	        $sql = "select Name_Prov_K, Name_OD_K, Name_Facility_K, Name_Vill_K
	                from tblCensusVillage as a
	                join tblHFCodes as b on a.HCCode = b.Code_Facility_T
	                join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
	                where a.Code_Vill_T = '$code'";
	        $found = $this->db->query($sql)->row();

	        $text = "VMW Device Request:\n"
	            . "Province: $found->Name_Prov_K\n"
	            . "OD: $found->Name_OD_K\n"
	            . "HC: $found->Name_Facility_K\n"
	            . "VMW: $found->Name_Vill_K\n"
	            . "Version: <code>$appVersion</code>";

	        $type = 'vmw';
	    }

		$json = $this->db->get_where($table, ['Rec_ID' => $RecID])->row('TelegramMsg');

		$url = 'https://api.telegram.org/bot928034849:AAHpqOwQT8zUiM84W-mMmApUNFm8FQhYj_E';
	    $client = new GuzzleHttp\Client();

		if ($json != null) {
			$client->post($url . '/deleteMessage', [
				'verify' => FCPATH . '/media/ca-bundle.crt',
				'json' => [
					'chat_id' => '-1002206999850',
					'message_id' => json_decode($json)->id
				]
			]);
		}

	    $rs = $client->post($url . '/sendMessage', [
	        'verify' => FCPATH . '/media/ca-bundle.crt',
	        'json' => [
	            'chat_id' => '-1002206999850',
				'parse_mode' => 'HTML',
	            'text' => $text,
				'disable_web_page_preview' => true,
				'reply_markup' => [
				    'inline_keyboard' => [[
				        ['text' => 'Accept', 'callback_data' => "accept,$type,$RecID"],
	                    ['text' => 'Delete', 'callback_data' => "delete,$type,$RecID"]
				    ]]
				]
	        ]
	    ]);
	    $msgId = json_decode($rs->getBody())->result->message_id;

	    $json = json_encode(['id' => $msgId, 'text' => $text]);
	    $this->db->update($table, ['TelegramMsg' => $json], ['Rec_ID' => $RecID]);
	}

    public function notifyPfMix($data, $recId, $caseType)
    {
        $title = "ករណី Pf/Mix បានរាយការណ៍";
        $url = 'https://api.telegram.org/bot5111498968:AAFYuK1EtjQKROaEOFyaYC1EcrTV8UwA2R0/sendMessage';
        $client = new \GuzzleHttp\Client();

        $place = $caseType == 'VMW' ?  $this->getVMWPlace($data['ID']) : $this->getHCPlace($data['ID']) ;

        $obj = json_decode (json_encode ($data), FALSE);

        $name = str_replace("♣","", $obj->NameK);
        $age = $obj->Age;
        $sex = $obj->Sex;
        $specie = $obj->Diagnosis;
        $province = $place->Name_Prov_E;
        $od = $place->Name_OD_E ;
        $hc = $place->Name_Facility_E;
        $vl = isset($place->Name_Vill_E) ? $place->Name_Vill_E : '';

        $body = "អ្នកជំងឺឈ្មោះ:  $name \n";
        $body .= "អាយុ​: $age \n";
        $body .= "ភេទ​:  $sex \n";
        $body .= "ប្រភេទមេរោគ:  $specie \n";
        $body .= "Province:  $province \n";
        $body .= "OD:  $od\n";
        $body .= "HC:  $hc \n";
        $body .= "រកឃើញដោយ: $caseType  $vl";

        try{
            $response = $client->post($url, [
                'verify' => FCPATH . '/media/ca-bundle.crt',
                'json' => [
                    'chat_id' => '-1002207731081',
                    'parse_mode' => 'markdown',
                    'text' => "*" . $title . "* \n ```  " . $body . "```",
                ]
            ]);

            $msgId = json_decode($response->getBody())->result->message_id;

            $json = json_encode(['id' => $msgId, 'text' => $body]);
            $this->db->update('tblPreConfirmCase', ['TelegramMsg' => $json], ['Rec_ID' => $recId]);
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            $response = $e->getResponse();
        }
    }

    private function getHCPlace($hcCode)
    {
        $sql = "select * from tblHFCodes as a
                join tblProvince as b on a.Code_Prov_N = b.Code_Prov_T
                where a.Code_Facility_T = '$hcCode'";

        return $this->db->query($sql)->row();
    }

    private function getVMWPlace($villCode)
    {
        $sql = "select * from tblCensusVillage as a
                join tblHFCodes as b on a.HCCode = b.Code_Facility_T
                join tblProvince as c on b.Code_Prov_N = c.Code_Prov_T
                where a.Code_Vill_T = '$villCode'";

        return $this->db->query($sql)->row();
    }
}