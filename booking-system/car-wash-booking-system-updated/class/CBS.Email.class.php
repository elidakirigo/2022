<?php

/******************************************************************************/
/******************************************************************************/

class CBSEmail
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->secureConnectionType=array
		(
			'ssl'=>array(__('SSL','car-wash-booking-system')),
			'tls'=>array(__('TLS','car-wash-booking-system')),
		);
	}
	
	/**************************************************************************/
	
	function getSecureConnectionType()
	{
		return($this->secureConnectionType);
	}
	
	/**************************************************************************/
	
	function phpMailerInit($mail)
	{
		global $cbs_phpmailer;
		
		$mail->CharSet='UTF-8';
		$mail->SetFrom($cbs_phpmailer['account']['email'],$cbs_phpmailer['account']['name']);
		
		if($cbs_phpmailer['smtp']['enable'])
		{
			$mail->IsSMTP();
			$mail->SMTPAuth=true; 
			
			if($cbs_phpmailer['smtp']['debug_enable']==1) $mail->SMTPDebug=1;
			
			$mail->Username=$cbs_phpmailer['smtp']['username'];
			$mail->Password=$cbs_phpmailer['smtp']['password'];
			
			$mail->Host=$cbs_phpmailer['smtp']['host'];
			$mail->Port=$cbs_phpmailer['smtp']['port'];
			
			$mail->SMTPSecure=$cbs_phpmailer['smtp']['secure_connection_type'];
		}		
	}
	
	/**************************************************************************/
	
	function send($recipient,$subject,$body)
	{
		$Validation=new CBSValidation();
		foreach($recipient as $recipientIndex=>$recipientData)
		{
			if(!$Validation->isEmailAddress($recipientData))
				unset($recipient[$recipientIndex]);
		}
		
		if(!count($recipient)) return;
		
		$header=array();
		$header[]='Content-type: text/html';	
		
		add_action('phpmailer_init',array($this,'phpMailerInit'));
		
		return(wp_mail($recipient,$subject,$body,$header)); 
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/