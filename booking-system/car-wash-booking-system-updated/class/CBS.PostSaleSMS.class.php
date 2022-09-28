<?php

/******************************************************************************/
/******************************************************************************/

class CBSPostSaleSMS
{
	/**************************************************************************/

	function __construct()
	{

	}

	/**************************************************************************/

	function send()
	{
		$CBSLocation=new CBSLocation();

		$booking=$this->getBooking();

		if($booking===false) return;
		if(!count($booking)) return;

		$dictionary=$CBSLocation->getDictionary();

		foreach($booking as $bookingId=>$bookingData)
		{
			if(!array_key_exists($bookingData['meta']['location_id'],$dictionary)) continue;

			$locationMeta=$dictionary[$bookingData['meta']['location_id']]['meta'];

			$message=__('Thank you for trusting in us. If you have a minute, please leave us a review on Google clicking on this link','car-wash-booking-system');

			$Twilio=new CBSTwilio();
			$Twilio->sendSMS($locationMeta['twilio_sms_api_sid'],$locationMeta['twilio_sms_api_token'],$locationMeta['twilio_sms_sender_phone_number'],$bookingData['meta']['client_phone_number'],$message);

			//$Nexmo=new CBSNexmo();
			//$Nexmo->sendSMS($locationMeta['nexmo_sms_api_key'],$locationMeta['nexmo_sms_api_key_secret'],$locationMeta['nexmo_sms_sender_name'],$bookingData['meta']['client_phone_number'],$message);
		}
	}

	/**************************************************************************/

	function getBooking()
	{
		global $post;

		$Validation=new CBSValidation();

		$data=array();

		$date=date_i18n('Y-m-d');
		$datetime=date_i18n('Y-m-d H:i');

		$argument=array
		(
			'post_type'=>PLUGIN_CBS_CONTEXT.'_booking',
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'meta_query'=>array
			(
				array
				(
					'key'=>PLUGIN_CBS_CONTEXT.'_date',
					'value'=>$date,
					'compare'=>'=',
					'type'=>'DATE'
				)
			),
		);

		$query=new WP_Query($argument);
		if($query===false) return(false);

		while($query->have_posts())
		{
			$query->the_post();

			$meta=CBSPostMeta::getPostMeta($post);

			if($Validation->isEmpty($meta['client_phone_number'])) continue;

			if(date('Y-m-d H:i',strtotime($meta['date'].' '.$meta['time'].'+'.((int)$meta['duration']+60).' minutes'))!==$datetime) continue;

			$data[$post->ID]['post']=$post;
			$data[$post->ID]['meta']=$meta;
		}

		return($data);
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/
