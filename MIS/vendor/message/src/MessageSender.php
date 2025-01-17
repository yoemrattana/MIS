<?php 

namespace Message;

class MessageSender
{
	private $message;

	public function __construct( MessageInterface $message )
	{
		$this->message = $message;
	}

    public function send()
    {
        $this->message->send();
    }
}