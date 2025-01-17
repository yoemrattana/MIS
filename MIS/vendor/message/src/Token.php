<?php
namespace Message;
require_once FCPATH.'/vendor/autoload.php';
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;

class Token
{
    /**
     * get server token
     * @return string of token from GCM
     */
    function getToken()
    {
        $credential = new ServiceAccountCredentials(
			"https://www.googleapis.com/auth/firebase.messaging",
			json_decode(file_get_contents(FCPATH."/media/certification/notification-38c9f-firebase-adminsdk-s9dwx-ef83d6d8fa.json"), true)
		);

        $token = $credential->fetchAuthToken(HttpHandlerFactory::build());
        return $token['access_token'];
    }

    function getHeader()
    {
        return array(
           'Authorization: Bearer ' . $this->getToken(),
           'Content-Type: application/json'
       );
    }

    function setCurl($msg)
    {
        $url = GCM_URL;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeader());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($msg));

        $result = curl_exec($ch);

		//file_put_contents('d:\Note.txt', print_r($result, true));
        //file_put_contents('d://Note.txt',  print_r($result, true), FILE_APPEND );

        curl_close($ch);
    }
}