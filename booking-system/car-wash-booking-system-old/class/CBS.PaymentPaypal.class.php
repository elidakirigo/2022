<?php

/******************************************************************************/
/******************************************************************************/

class CBSPaymentPaypal
{
	/**************************************************************************/
	
	function __construct()
	{

	}
	
	/**************************************************************************/
	
	function createPaymentForm($postId,$location)
	{
		$Validation=new CBSValidation();
		
		$formURL='https://www.paypal.com/cgi-bin/webscr';
		if((int)$location['meta']['payment_paypal_sandbox_mode_enable']===1)
			$formURL='https://www.sandbox.paypal.com/cgi-bin/webscr';
		
		$successUrl=$location['meta']['payment_paypal_success_url_address'];
		if($Validation->isEmpty($successUrl)) $successUrl=add_query_arg('action','success',get_the_permalink($postId));
		
		$cancelUrl=$location['meta']['payment_paypal_cancel_url_address'];
		if($Validation->isEmpty($cancelUrl)) $cancelUrl=add_query_arg('action','cancel',get_the_permalink($postId));	
		
		$html=
		'
			<form action="'.esc_url($formURL).'" method="post" name="cbs-form-paypal">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="'.esc_attr($location['meta']['payment_paypal_email_address']).'">				
				<input type="hidden" name="item_name" value="">
				<input type="hidden" name="item_number" value="0">
				<input type="hidden" name="amount" value="0.00">	
				<input type="hidden" name="currency_code" value="'.esc_attr(CBSOption::getOption('currency')).'">
				<input type="hidden" value="1" name="no_shipping">
				<input type="hidden" value="'.get_the_permalink($postId).'?action=ipn" name="notify_url">				
				<input type="hidden" value="'.esc_url($successUrl).'" name="return">
				<input type="hidden" value="'.esc_url($cancelUrl).'" name="cancel_return">
			</form>
		';
		
		return($html);
	}
	
	/**************************************************************************/
	
	function handleIPN()
	{
		$Booking=new CBSBooking();
		$Location=new CBSLocation();
		$BookingStatus=new CBSBookingStatus();
		
		$bookingId=(int)$_POST['item_number'];
		
		$booking=$Booking->getBooking($bookingId);
		if(!count($booking)) return;
		
		$locationId=$booking['meta']['location_id'];
		if(($dictionary=$Location->getDictionary(array('location_id'=>$locationId)))===false) return(false);
		if(count($dictionary)!=1) return(false);
				
		$request='cmd='.urlencode('_notify-validate');
		
		$postData=CBSHelper::stripslashes($_POST);
		
		foreach($postData as $key=>$value) 
			$request.='&'.$key.'='.urlencode($value);

		$address='https://ipnpb.paypal.com/cgi-bin/webscr';
		if($dictionary[$locationId]['meta']['payment_paypal_sandbox_mode_enable']==1)
			$address='https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
		
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,$address);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$request);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,1);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);
		curl_setopt($ch,CURLOPT_HTTPHEADER,array('Host: www.paypal.com'));
		$response=curl_exec($ch);
		
		if(curl_errno($ch)) return;
		if(!strcmp($response,'VERIFIED')==0) return;
		
		$meta=CBSPostMeta::getPostMeta($bookingId);
						
		if(!((array_key_exists('payment_paypal_data',$meta)) && (is_array($meta['payment_paypal_data']))))
			$meta['payment_paypal_data']=array();
		
		$meta['payment_paypal_data'][]=$postData;
		
		CBSPostMeta::updatePostMeta($bookingId,'payment_paypal_data',$meta['payment_paypal_data']);
		
		if($postData['payment_status']=='Completed')
		{
			if(CBSOption::getOption('booking_status_payment_success')!=-1)
			{
				if($BookingStatus->isBookingStatus(CBSOption::getOption('booking_status_payment_success')))
				{
					$bookingOld=$Booking->getBooking($bookingId);

					CBSPostMeta::updatePostMeta($bookingId,'booking_status',CBSOption::getOption('booking_status_payment_success'));

					$bookingNew=$Booking->getBooking($bookingId);

					$emailSend=false;

					$WooCommerce=new CBSWooCommerce();
					$WooCommerce->changeStatus(-1,$bookingId,$emailSend);									

					if(!$emailSend)
						$Booking->sendEmailBookingChangeStatus($bookingOld,$bookingNew);
				}
			}			
		}
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/