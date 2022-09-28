<?php

/******************************************************************************/
/******************************************************************************/

class CBSWooCommerce
{
	/**************************************************************************/
	
	function __construct()
	{
		
	}
	
	/**************************************************************************/
	
	function isEnable($meta)
	{
		return((class_exists('WooCommerce')) && ($meta['woocommerce_enable']));
	}
	
	/**************************************************************************/
	
	function isPayment($paymentId,$dictionary=null)
	{
		if(is_null($dictionary)) $dictionary=$this->getPaymentDictionary();

		foreach($dictionary as $value)
		{
			if($value->{'id'}==$paymentId) return(true);
		}
		
		return(false);
	}
	
	/**************************************************************************/
	
	function getPaymentDictionary()
	{
		$dictionary=WC()->payment_gateways->payment_gateways();
	
		foreach($dictionary as $index=>$value)
		{
			if(!(isset($value->enabled) && ($value->enabled==='yes')))
			{
				unset($dictionary[$index]);
			}
		}
		
		return($dictionary);
	}
	
	/**************************************************************************/
	
	function getPaymentName($paymentId,$dictionary=null)
	{
		if(is_null($dictionary)) $dictionary=$this->getPaymentDictionary();
		
		foreach($dictionary as $value)
		{
			if($value->{'id'}==$paymentId) return($value->{'method_title'});
		}		
		
		return(null);
	}
	
	/**************************************************************************/
	
	function sendBooking($bookingId,$data)
	{
		global $wpdb;
		
		$Coupon=new CBSCoupon();
		$Booking=new CBSBooking();
		$Validation=new CBSValidation();
		
		if(($booking=$Booking->getBooking($bookingId))===false) return(false);		
		
		$address=array
		(
			'first_name'=>$booking['meta']['client_first_name'],
			'last_name'=>$booking['meta']['client_second_name'],
			'company'=>$booking['meta']['client_company_name'],
			'address_1'=>$booking['meta']['client_address_street'],
			'address_2'=>'',
			'city'=>$booking['meta']['client_address_city'],
			'postcode'=>$booking['meta']['client_address_post_code'],
			'country'=>$booking['meta']['client_address_country'],
			'state'=>$booking['meta']['client_address_state'],
			'phone'=>$booking['meta']['client_phone_number'],
			'email'=>$booking['meta']['client_email_address']			
		);
				
		$order=wc_create_order();
		$order->set_address($address,'billing');
		$order->set_address($address,'shipping');
		
		if(array_key_exists('payment_type',$data))
		{
			$order->set_payment_method($data['payment_type']);
		}
		
		update_post_meta($order->get_id(),PLUGIN_CBS_CONTEXT.'_booking_id',$bookingId);
		update_post_meta($bookingId,PLUGIN_CBS_CONTEXT.'_woocommerce_booking_id',$order->get_id());
		
		$userId=get_current_user_id();
		if($userId==0 && $Validation->isNumber($booking['meta']['user'],1,999999))
		{
			$userId=$booking['meta']['user'];
		}

		if($Validation->isNumber($userId,1,999999))
		{
			update_post_meta($order->get_id(),'_customer_user',$userId);
		
			foreach($address as $index=>$value) 
			{
				update_user_meta($userId,'billing_'.$index,$value);
				update_user_meta($userId,'shipping_'.$index,$value);
			}
		}
		
		/***/
		
		$this->changeStatus($order->get_id(),$bookingId);
		
		/***/
		
		$productId=array();
		$product=null;
		
		//package
		if((array_key_exists('package_id',$booking['meta'])) && ($booking['meta']['package_id']!=0))
		{
			$product=$this->prepareProduct
			(
				array
				(
					'post'=>array
					(
						'post_title'=>$booking['meta']['package_name']
					),
					'meta'=>array
					(
						'CBS_price_gross'=>$booking['meta']['package_price'],
						'CBS_tax_value'=>$booking['meta']['package_tax_value'],
						'_regular_price'=>$booking['meta']['package_price_net'],
						'_sale_price'=>$booking['meta']['package_price_net'],
						'_price'=>$booking['meta']['package_price_net']
					)
				)
			);
			
			$productId[]=$this->createProduct($product);
			$order->add_product(wc_get_product(end($productId)));			
		}

		//services
		if((array_key_exists('detail',$booking)))
		{
			foreach($booking['detail'] as $detailIndex=>$detailData)
			{
				if($detailData->{'service_type'}!=2)
					continue;
				 
			   $product=$this->prepareProduct
				(
					array
					(
						'post'=>array
						(
							'post_title'=>$detailData->{'name'}
						),
						'meta'=>array
						(
							'CBS_price_gross'=>$detailData->{'service_price_gross_raw'},
							'CBS_tax_value'=>$detailData->{'tax_rate_value'},
							'_regular_price'=>$detailData->{'price'},
							'_sale_price'=>$detailData->{'price'},
							'_price'=>$detailData->{'price'}
						)
					)
				);
				
				$productId[]=$this->createProduct($product);

				$order->add_product(wc_get_product(end($productId)));
			}
		}

		//gratuity
		if(array_key_exists('gratuity',$booking['meta']) && $booking['meta']['gratuity']>0)
		{
			$product=$this->prepareProduct
			(
				array
				(
					'post'=>array
					(
						'post_title'=>__('Gratuity','car-wash-booking-system')
					),
					'meta'=>array
					(
						'CBS_price_gross'=>$booking['meta']['gratuity'],
						'CBS_tax_value'=>'0',
						'_regular_price'=>$booking['meta']['gratuity'],
						'_sale_price'=>$booking['meta']['gratuity'],
						'_price'=>$booking['meta']['gratuity']
					)
				)
			);
			
			$productId[]=$this->createProduct($product);
			$order->add_product(wc_get_product(end($productId)));
		}
		
		//coupon
		if(array_key_exists('coupon_id',$booking['meta']))
		{
			$coupon=$Coupon->getCoupon($booking['meta']['coupon_id']);
			$couponTitle=sprintf(__('Coupon: %s (Discount: %s%% and Deduction: %s)','car-wash-booking-system'),$coupon['meta']['coupon_code'],$coupon['meta']['discount'],$coupon['meta']['deduction']);
			$couponDeduction=-$booking['meta']['deduction'];

			$product=$this->prepareProduct
			(
				array
				(
					'post'=>array
					(
						'post_title'=>$couponTitle
					),
					'meta'=>array
					(
						'CBS_price_gross'=>$couponDeduction,
						'CBS_tax_value'=>'0',
						'_regular_price'=>$couponDeduction,
						'_sale_price'=>$couponDeduction,
						'_price'=>$couponDeduction,
					)
				)
			);
			$productId[]=$this->createProduct($product);
			$order->add_product(wc_get_product(end($productId)));
		}

		$order->calculate_totals();
			
		/***/
	
		$query=$wpdb->prepare('delete from '.$wpdb->prefix.'woocommerce_order_items where order_id=%d and order_item_type=%s',$order->get_id(),'tax');
	   
		$wpdb->query($query);
		
		/***/
		
		$taxRateId=1;
		$orderItem=$order->get_items();
			
		/***/
		
		$taxArray=array();
		foreach($orderItem as $item)
		{
			$priceNet=get_post_meta($item->get_product_id(),'_price',true);
			$priceGross=get_post_meta($item->get_product_id(),'CBS_price_gross',true);
			$taxValue=get_post_meta($item->get_product_id(),'CBS_tax_value',true);
			$taxAmount=round($priceGross-$priceNet,2);
			$taxLabel=sprintf(__('Tax %.2f','chauffeur-booking-system'),$taxValue);
			
			if(!isset($taxArray[$taxValue]))
			{
				$query=$wpdb->prepare('insert into '.$wpdb->prefix.'woocommerce_order_items(order_item_name,order_item_type,order_id) VALUES (%s,%s,%d)',array('TAX-'.$taxValue,'tax',$order->get_id()));
				$wpdb->query($query);

				$taxItemId=$wpdb->insert_id;

				$taxArray[$taxValue]=array
				(
					'taxItemId'=>$taxItemId,
					'rate_id'=>$taxRateId,
					'label'=>$taxLabel,
					'compound'=>'',
					'tax_amount'=>$taxAmount,
					'shipping_tax_amount'=>0,
				);
				
				wc_add_order_item_meta($taxArray[$taxValue]['taxItemId'],'rate_id',$taxArray[$taxValue]['rate_id']);
				wc_add_order_item_meta($taxArray[$taxValue]['taxItemId'],'label',$taxArray[$taxValue]['label']);
				wc_add_order_item_meta($taxArray[$taxValue]['taxItemId'],'compound',$taxArray[$taxValue]['compound']);
				wc_add_order_item_meta($taxArray[$taxValue]['taxItemId'],'tax_amount',$taxArray[$taxValue]['tax_amount']);
				wc_add_order_item_meta($taxArray[$taxValue]['taxItemId'],'shipping_tax_amount',$taxArray[$taxValue]['shipping_tax_amount']);
			}
			else
			{
				$taxArray[$taxValue]['tax_amount']+=$taxAmount;
				wc_update_order_item_meta($taxArray[$taxValue]['taxItemId'],'tax_amount',$taxArray[$taxValue]['tax_amount']);		
			}
			
			$taxData=array
			(
				'total'=>array
				(
					$taxArray[$taxValue]['rate_id']=>(string)$taxAmount,
				),
				'subtotal'=>array
				(
					$taxArray[$taxValue]['rate_id']=>(string)$taxAmount,
				)
			);
			
			wc_update_order_item_meta($item->get_id(),'_line_subtotal_tax',$taxAmount);
			wc_update_order_item_meta($item->get_id(),'_line_tax',$taxAmount);
			wc_update_order_item_meta($item->get_id(),'_line_tax_data',$taxData);
					
			$taxRateId++;
		}
				
		update_post_meta($order->get_id(),'_order_tax',$booking['meta']['price']-$booking['meta']['price_net']);
		update_post_meta($order->get_id(),'_order_total',$booking['meta']['price']);
				
		foreach($productId as $value) wp_delete_post($value);
		
		return($order->get_id());
	}
	
	/**************************************************************************/
	
	function prepareProduct($data)
	{
 		$argument=array
		(
			'post'=>array
			(
				'post_title'=>'',
				'post_content'=>'',
				'post_status'=>'publish',
				'post_type'=>'product',
			),
			'meta'=>array
			(
				'CBS_price_gross'=>0,
				'CBS_tax_value'=>0,
				'_visibility'=>'visible',
				'_stock_status'=>'instock',
				'_downloadable'=>'no',
				'_virtual'=>'yes',
				'_regular_price'=>0,
				'_sale_price'=>0,
				'_purchase_note'=>'',
				'_featured'=>'no',
				'_weight'=>'',
				'_length'=>'',
				'_width'=>'',
				'_height'=>'',
				'_sku'=>'',
				'_product_attributes'=>array(),
				'_sale_price_dates_from'=>'',
				'_sale_price_dates_to'=>'',
				'_price'=>0,
				'_sold_individually'=>'',
				'_manage_stock'=>'no',
				'_backorders'=>'no',
				'_stock'=>'',
				'total_sales'=>'0',
			),
		);
		
		if(isset($data['post']))
		{
			foreach($data['post'] as $index=>$value)
				$argument['post'][$index]=$value;
		}
		
		if(isset($data['meta']))
		{
			foreach($data['meta'] as $index=>$value)
				$argument['meta'][$index]=$value;
		}		
		
		return($argument);	   
	}
	
	/**************************************************************************/
	
	function createProduct($data)
	{
		$productId=wp_insert_post($data['post']);
		wp_set_object_terms($productId,'simple','product_type');
		foreach($data['meta'] as $key=>$value)
			update_post_meta($productId,$key,$value);
		return($productId);
	}
	
	/**************************************************************************/
	
	function locateTemplate($template,$templateName,$templatePath) 
	{
		global $woocommerce;
	   
		$templateTemp=$template;
		if(!$templatePath) $templatePath=$woocommerce->template_url;
 
		$pluginPath=PLUGIN_CBS_PATH.'woocommerce/';
	 
		$template=locate_template(array($templatePath.$templateName,$templateName));
 
		if((!$template) && (file_exists($pluginPath.$templateName)))
			$template=$pluginPath.$templateName;
 
		if(!$template) $template=$templateTemp;
   
		return ($template);
	}
	
	/**************************************************************************/
	
	function getUserData()
	{
		$userData=array();
		$userCurrent=wp_get_current_user();
		
		$Country=new WC_Countries();
		$Customer=new WC_Customer($userCurrent->ID);
		
		$billingAddress=$Customer->get_billing();
		
		$userData['client_contact_detail_first_name']=$userCurrent->user_firstname;
		$userData['client_contact_detail_last_name']=$userCurrent->user_lastname;
		$userData['client_contact_detail_email_address']=$userCurrent->user_email;
		$userData['client_contact_detail_phone_number']=null;
		
		$userData['client_billing_detail_enable']=1;
		$userData['client_billing_detail_company_name']=$billingAddress['company'];
		$userData['client_billing_detail_tax_number']=null;
		$userData['client_billing_detail_street_name']=$billingAddress['address_1'];
		$userData['client_billing_detail_street_number']=$billingAddress['address_2'];
		$userData['client_billing_detail_city']=$billingAddress['city'];
		$userData['client_billing_detail_state']=null;
		$userData['client_billing_detail_postal_code']=$billingAddress['postcode'];
		$userData['client_billing_detail_country_code']=$billingAddress['country'];
		
		$state=$billingAddress['state'];
		$country=$billingAddress['country'];
		
		$countryState=$Country->get_states();
		
		if((isset($countryState[$country])) && (isset($countryState[$country][$state])))
			$userData['client_billing_detail_state']=$countryState[$country][$state];
		
		return($userData);
	}
	
	/**************************************************************************/
	
	function getPaymentURLAddress($bookingId)
	{
		$order=wc_get_order($bookingId);
		
		if($order!==false)
			return($order->get_checkout_payment_url());
		
		return(null);
	}
	
	/**************************************************************************/
	
	function addAction()
	{
		add_action('add_meta_boxes',array($this,'addMetaBox'));
		add_action('woocommerce_order_status_changed',array($this,'changeStatus'));
	}
	
	/**************************************************************************/
	
	function addMetaBox()
	{
		global $post;
	
		if($post->post_type=='shop_order')
		{
			$meta=CBSPostMeta::getPostMeta($post);
			
			if((is_array($meta)) && (array_key_exists('booking_id',$meta)) && ($meta['booking_id']>0))
			{
				add_meta_box(PLUGIN_CBS_CONTEXT.'_meta_box_woocommerce_product',__('Booking','car-wash-booking-system'),array($this,'addMetaBoxWooCommerceBooking'),'shop_order','side','low');		
			}
		}
	}
	
	/**************************************************************************/
	
	function addMetaBoxWooCommerceBooking()
	{
		global $post;
		
		$meta=CBSPostMeta::getPostMeta($post);
		
		echo 
		'
			<div>
				<div>'.esc_html__('This order has corresponding booking from "Car Wash Booking System" plugin. Click on button below to see its details in new window.','chauffeur-booking-system').'</div>
				<br/>
				<a class="button button-primary" href="'.esc_url(get_edit_post_link($meta['booking_id'])).'" target="_blank">'.esc_html__('Open booking','car-wash-booking-system').'</a>
			</div>
		';
	}
	
	/**************************************************************************/
	
	function changeStatus($orderId=-1,$bookingId=-1,&$emailSend=false)
	{
		$Booking=new CBSBooking();
		
		$bookingStatusSynchronizationId=(int)CBSOption::getOption('booking_status_synchronization');
		
		if($bookingStatusSynchronizationId===1) return(false);
		
		/***/
		
		$BookingStatus=new CBSBookingStatus();
		
		if((int)$orderId!==-1)
		{
			$orderMeta=CBSPostMeta::getPostMeta($orderId);		
			if((array_key_exists('booking_id',$orderMeta)) && ($orderMeta['booking_id']>0))
				$bookingId=(int)$orderMeta['booking_id'];
		}
		elseif((int)$bookingId!==-1)
		{
			if(($booking=$Booking->getBooking($bookingId))!==false) 		
			{
				if((array_key_exists('woocommerce_booking_id',$booking['meta'])) && ($booking['meta']['woocommerce_booking_id']>0))
					$orderId=$booking['meta']['woocommerce_booking_id'];
			}
		}
		
		/***/
		
		if((int)$bookingStatusSynchronizationId===2)
		{
			if($bookingId!=-1)
			{
				$order=new WC_Order($orderId);
				
				$status=$BookingStatus->mapBookingStatus($order->get_status());
				
				if($status!==false) 
				{	
					$bookingOld=$Booking->getBooking($bookingId);
					
					CBSPostMeta::updatePostMeta($bookingId,'booking_status',$status);
					
					$bookingNew=$Booking->getBooking($bookingId);
					
					$Booking->sendEmailBookingChangeStatus($bookingOld,$bookingNew);
					
					$emailSend=true;
				}
			}
		}
		else if((int)$bookingStatusSynchronizationId===3)
		{
			if($orderId!=-1)
			{
				$Booking=new CBSBooking();
				if(($booking=$Booking->getBooking($bookingId))!==false) 
				{
					$status=$BookingStatus->mapBookingStatus($booking['meta']['booking_status']);
					if($status!==false)
					{
						$order=new WC_Order($orderId);
						$order->update_status($status);
					}
				}
			}			
		}
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/