<?php

namespace Message;

class GroupMessage implements MessageInterface
{
	private $recipient;
	private $title;
	public $body;

    private $CI;
	function __construct() {
		$this->CI = & get_instance();
	}

	/*
	 * $recipients string
	 * $title string
	 * $body string
	 */
	public function setMessage($recipient, $title, $body)
	{
		$this->recipient = $recipient;
		$this->title = $title;
		$this->body = $body;
	}

	public function send()
	{
		$url = 'https://api.telegram.org/bot5111498968:AAFYuK1EtjQKROaEOFyaYC1EcrTV8UwA2R0/sendMessage';
		$client = new \GuzzleHttp\Client();

        try{
            $response = $client->post($url, [
			    'verify' => FCPATH . '/media/ca-bundle.crt',
			    'json' => [
				    'chat_id' => $this->recipient,
				    'parse_mode' => 'markdown',
				    'text' => "*" . $this->title . "* \n ```  " . $this->body . "```",
			    ]
		    ]);
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            $response = $e->getResponse();
        }

        $this->logMessage($response);
	}

    private function logMessage($response)
    {
        $statusCode =  $response->getStatusCode();
        $telegramGroup = $this->CI->db->get_where('tblTelegramGroup', ['ID'=>$this->recipient])->row_array();
        $data = [
            'GroupID' => $this->recipient,
            'GroupName' => $telegramGroup['Name'],
            'Message' => $statusCode == 200? nvarchar($this->body) : $response->getBody()->getContents(),
            'InitTime' => sqlNow(),
            'StatusCode' => $statusCode
        ];
        $this->CI->db->insert('tblLogTelegramMsg', $data);
    }
}