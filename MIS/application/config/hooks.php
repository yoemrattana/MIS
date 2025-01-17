<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['pre_controller'] = function()
{
	function my_error_handler(int $severity, string $message, string $filepath, int $line)
	{
	    _error_handler($severity, $message, $filepath, $line);
	    http_response_code(500);
	    exit;
	}
	set_error_handler('my_error_handler');

	ini_set('date.timezone', 'Asia/Phnom_Penh');
};