<?php

/******************************************************************************/
/******************************************************************************/

class CBSPaymentStripe
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->paymentMethod=array
		(
			'alipay'=>array(__('Alipay','car-wash-booking-system')),
			'card'=>array(__('Cards','car-wash-booking-system')),			
			'ideal'=>array(__('iDEAL','car-wash-booking-system')),
			'fpx'=>array(__('FPX','car-wash-booking-system')),
			'bacs_debit'=>array(__('Bacs Direct Debit','car-wash-booking-system')),
			'bancontact'=>array(__('Bancontact','car-wash-booking-system')),
			'giropay'=>array(__('Giropay','car-wash-booking-system')),
			'p24'=>array(__('Przelewy24','car-wash-booking-system')),
			'eps'=>array(__('EPS','car-wash-booking-system')),
			'sofort'=>array(__('Sofort','car-wash-booking-system')),
			'sepa_debit'=>array(__('SEPA Direct Debit','car-wash-booking-system'))
		);
		
		$this->event=array
		(
			'payment_intent.canceled',
			'payment_intent.created',
			'payment_intent.payment_failed',
			'payment_intent.processing',
			'payment_intent.requires_action',
			'payment_intent.succeeded',
			'payment_method.attached'
		);
		
		asort($this->paymentMethod);
	}
	
	/**************************************************************************/
	
	function getPaymentMethod()
	{
		return($this->paymentMethod);
	}
	
	/**************************************************************************/
	
	function isPaymentMethod($paymentMethod)
	{
		return(array_key_exists($paymentMethod,$this->paymentMethod) ? true : false);
	}
	
	/**************************************************************************/
	
	function getWebhookEndpointUrlAdress()
	{
		$address=add_query_arg('action','payment_stripe',home_url().'/');
		return($address);
	}
	
	/**************************************************************************/
	
	function createWebhookEndpoint($location)
	{
		$StripeClient=new \Stripe\StripeClient($location['meta']['payment_stripe_api_key_secret']);
		
		$webhookEndpoint=$StripeClient->webhookEndpoints->create(['url'=>$this->getWebhookEndpointUrlAdress(),'enabled_events'=>$this->event]);		
		
		CBSOption::updateOption(array('payment_stripe_webhook_endpoint_id'=>$webhookEndpoint->id));
	}
	
	/**************************************************************************/
	
	function updateWebhookEndpoint($location,$webhookEndpointId)
	{
		$StripeClient=new \Stripe\StripeClient($location['meta']['payment_stripe_api_key_secret']);
		
		$StripeClient->webhookEndpoints->update($webhookEndpointId,['url'=>$this->getWebhookEndpointUrlAdress()]);
	}
	
	/**************************************************************************/
	
	function createSession($booking,$location)
	{
		try
		{
			$Validation=new CBSValidation();

			/***/

			Stripe\Stripe::setApiKey($location['meta']['payment_stripe_api_key_secret']);

			/***/

			$webhookEndpointId=CBSOption::getOption('payment_stripe_webhook_endpoint_id');

			if($Validation->isEmpty($webhookEndpointId)) $this->createWebhookEndpoint($location);
			else
			{
				try
				{
					$this->updateWebhookEndpoint($location,$webhookEndpointId);
				} 
				catch (Exception $ex) 
				{
					$this->createWebhookEndpoint($location);
				}
			}

			/***/

			$productId=$location['meta']['payment_stripe_product_id'];

			if($Validation->isEmpty($productId))
			{
				$product=\Stripe\Product::create(
				[
					'name'=>__('Car Wash Service','car-wash-booking-system')
				]);		

				$productId=$product->id;

				CBSPostMeta::updatePostMeta($booking['meta']['location_id'],'payment_stripe_product_id',$productId);
			}

			/***/

			$price=\Stripe\Price::create(
			[
				'product'=>$productId,
				'unit_amount'=>$booking['meta']['price']*100,
				'currency'=>$booking['meta']['currency_id'],
			]);

			/***/

			$currentURLAddress=home_url();
			if($Validation->isEmpty($location['meta']['payment_stripe_success_url_address']))
				$location['meta']['payment_stripe_success_url_address']=$currentURLAddress;
			if($Validation->isEmpty($location['meta']['payment_stripe_cancel_url_address']))
				$location['meta']['payment_stripe_cancel_url_address']=$currentURLAddress;

			$session=\Stripe\Checkout\Session::create
			(
				[
					'payment_method_types'=>$location['meta']['payment_stripe_method'],
					'mode'=>'payment',
					'line_items'=>[
						[
							'price'=>$price->id,
							'quantity'=>1
						]
					],
					'success_url'=>$location['meta']['payment_stripe_success_url_address'],
					'cancel_url'=>$location['meta']['payment_stripe_cancel_url_address']
				]		
			);

			CBSPostMeta::updatePostMeta($booking['post']->ID,'payment_stripe_intent_id',$session->payment_intent);

			return($session->id);
		}
  		catch(Exception $ex) 
		{
			$LogManager=new CBSLogManager();
			$LogManager->add('stripe',1,$ex->__toString());
			return(false);
		}
	}
	
	/**************************************************************************/
	
	function receivePayment()
	{
		if(!array_key_exists('action',$_REQUEST)) return(false);
		
		if($_REQUEST['action']=='payment_stripe')
		{
			global $post;
			
			$event=null;
			$content=@file_get_contents('php://input');
	
			try 
			{
				$event=\Stripe\Event::constructFrom(json_decode($content,true));
			} 
			catch(\UnexpectedValueException $e) 
			{
				http_response_code(400);
				exit();
			}	
			
			if(in_array($event->type,$this->event))
			{
				$Booking=new CBSBooking();
				$BookingStatus=new CBSBookingStatus();
				
				$argument=array
				(
					'post_type'=>PLUGIN_CBS_CONTEXT.'_booking',
					'posts_per_page'=>-1,
					'meta_query'=>array
					(
						array
						(
							'key'=>PLUGIN_CBS_CONTEXT.'_payment_stripe_intent_id',
							'value'=>$event->data->object->id
						)					  
					)
				);
				
				CBSHelper::preservePost($post,$bPost);
				
				$query=new WP_Query($argument);
				if($query!==false) 
				{
					while($query->have_posts())
					{
						$query->the_post();
					
						$meta=CBSPostMeta::getPostMeta($post);
						
						if(!array_key_exists('payment_stripe_data',$meta)) $meta['payment_stripe_data']=array();
						
						$meta['payment_stripe_data'][]=$event;
						
						CBSPostMeta::updatePostMeta($post->ID,'payment_stripe_data',$meta['payment_stripe_data']);
						
						if($event->type=='payment_intent.succeeded')
						{
							if(CBSOption::getOption('booking_status_payment_success')!=-1)
							{
								if($BookingStatus->isBookingStatus(CBSOption::getOption('booking_status_payment_success')))
								{
									$bookingOld=$Booking->getBooking($post->ID);
									
									CBSPostMeta::updatePostMeta($post->ID,'booking_status',CBSOption::getOption('booking_status_payment_success'));
									
									$bookingNew=$Booking->getBooking($post->ID);

									$emailSend=false;
									
									$WooCommerce=new CBSWooCommerce();
									$WooCommerce->changeStatus(-1,$post->ID,$emailSend);									
									
									if(!$emailSend)
										$Booking->sendEmailBookingChangeStatus($bookingOld,$bookingNew);
								}
							}
						}
						
						break;
					}
				}
			
				CBSHelper::preservePost($post,$bPost,0);
			}
		
			http_response_code(200);
			exit();
		}
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/