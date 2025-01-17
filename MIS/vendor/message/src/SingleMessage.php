<?php
namespace Message;

class SingleMessage implements MessageInterface
{
	private $recipient;
	private $title;
	public $body;

	/*
	* $recipients string
	* $title string
	* $body string
	*/
	function setMessage($recipient, $title, $body)
	{
		$this->recipient = $recipient;
		$this->title = $title;
		$this->body = $body;
	}

	public function getMsg()
    {
        return [
			"message" => [
				"token" => $this->recipient,
				"notification" => [
					"title" => $this->title,
					"body" => $this->body,
				],

			]
		];
    }

	public function send()
	{
		$token = new Token();
        $token->setCurl($this->getMsg());
	}
}
