<?php 

namespace Message;

interface MessageInterface {
	public function setMessage($recipient, $title, $body);
	public function send();
}