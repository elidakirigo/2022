<?php

/******************************************************************************/
/******************************************************************************/

class CBSNexmo
{
	/**************************************************************************/
	
	function __construct()
	{
		
	}
	
	/**************************************************************************/
	
	function sendSMS($apiKey,$apiKeySecret,$senderName,$recipientPhoneNumber,$message)
	{
		$data=array
		(
			'api_key'=>$apiKey,
			'api_secret'=>$apiKeySecret,
			'from'=>$senderName,
			'to'=>$recipientPhoneNumber,
			'text'=>$message,
		);
		
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,'https://rest.nexmo.com/sms/json?'.http_build_query($data));
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
		$response=curl_exec($ch);
		
		$LogManager=new CBSLogManager();
		$LogManager->add('nexmo',1,print_r(json_decode($response),true));		
		
		curl_close($ch);
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/