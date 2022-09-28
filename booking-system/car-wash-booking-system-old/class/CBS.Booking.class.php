<?php

/******************************************************************************/
/******************************************************************************/

class CBSBooking
{
	/**************************************************************************/
	
	function __construct()
	{
		
	}
	
	/**************************************************************************/
	
	function init()
	{
		register_post_type
		(
			PLUGIN_CBS_CONTEXT.'_booking',
			array
			(
				'labels'=>array
				(
					'name'=>__('Bookings','car-wash-booking-system'),
					'singular_name'=>__('Booking','car-wash-booking-system'),
					'edit_item'=>__('Edit Booking','car-wash-booking-system'),
					'all_items'=>__('Bookings','car-wash-booking-system'),
					'view_item'=>__('View Booking','car-wash-booking-system'),
					'search_items'=>__('Search Bookings','car-wash-booking-system'),
					'not_found'=>__('No Bookings Found','car-wash-booking-system'),
					'not_found_in_trash'=>__('No Bookings Found in Trash','car-wash-booking-system'), 
					'parent_item_colon'=>'',
					'menu_name'=>__('Car Wash Booking&nbsp;System','car-wash-booking-system')
				),	
				'public'=>false,  
				'menu_icon'=>'dashicons-calendar-alt',
				'show_ui'=>true,  
				'capability_type'=>'post',
				'capabilities'=>array
				(
					 'create_posts'=>'do_not_allow',
				),
				'map_meta_cap'=>true, 
				'menu_position'=>100,
				'hierarchical'=>false,  
				'rewrite'=>false,  
				'supports'=>array('title','page-attributes')  
			)
		);
		
		add_filter('manage_edit-'.PLUGIN_CBS_CONTEXT.'_booking_columns',array($this,'manageEditColumn')); 
		add_action('manage_'.PLUGIN_CBS_CONTEXT.'_booking_posts_custom_column',array($this,'manageColumn'));
		add_filter('manage_edit-'.PLUGIN_CBS_CONTEXT.'_booking_sortable_columns',array($this,'manageEditSortableColumn'));
		add_filter('postbox_classes_'.PLUGIN_CBS_CONTEXT.'_booking_cbs_meta_box_booking',array($this,'adminCreateMetaBoxClass'));

		add_action('add_meta_boxes_'.PLUGIN_CBS_CONTEXT.'_booking',array($this,'addMetaBox'));
		
		add_action('save_post',array($this,'savePost'));
		
		add_action('restrict_manage_posts',array($this,'manageBookingList'));
		add_filter('parse_query',array($this,'manageBookingListPostFiler'));
	}
	
	/**************************************************************************/
	/**************************************************************************/
	
	function addMetaBox()
	{
		global $post;
		
		$User=new CBSUser();
		$User->canUserManageBooking($post->ID);
		
		add_meta_box(PLUGIN_CBS_CONTEXT.'_meta_box_booking',__('General','car-wash-booking-system'),array($this,'addMetaBoxGeneral'),PLUGIN_CBS_CONTEXT.'_booking','normal','low');		
		add_meta_box(PLUGIN_CBS_CONTEXT.'_meta_box_booking_woocommerce',__('WooCommerce','car-wash-booking-system'),array($this,'addMetaBoxWooCommerce'),PLUGIN_CBS_CONTEXT.'_booking','side','low');
	}
	
	/**************************************************************************/
	
	function addMetaBoxGeneral()
	{
		global $post;
		
		$Date=new CBSDate();
		$Price=new CBSPrice();
		$Coupon=new CBSCoupon();
		$PaymentType=new CBSPaymentType();
		$WooCommerce=new CBSWooCommerce();
		
		$data=array();
		
		$BookingStatus=new CBSBookingStatus();
		
		$data['nonce']=CBSHelper::createNonceField(PLUGIN_CBS_CONTEXT.'_meta_box_booking');
		
		$booking=$this->getBooking($post->ID);
		
		if(array_key_exists('payment',$booking))
			$data['payment']=$booking['payment'];
		
		$data['meta']=$booking['meta'];
		
		$data['dictionary']['bookingStatus']=$BookingStatus->getBookingStatus();
		
		$data['other']['bookingPriceNet']=$Price->formatToDisplay2($data['meta']['price_net'],$data['meta']['currency_id']);
		$data['other']['bookingPriceGross']=$Price->formatToDisplay2($this->getBookingGrossPrice($booking),$data['meta']['currency_id']);		
		$data['other']['bookingPrice']=$Price->formatToDisplay2($data['meta']['price'],$data['meta']['currency_id']);
		$data['other']['bookingDuration']=$this->getBookingDuration($Date->reverse($data['meta']['date']).' '.$data['meta']['time'],$data['meta']['duration']);
		
		$data['other']['packageNetPrice']=$Price->formatToDisplay2($data['meta']['package_price_net'],$data['meta']['currency_id']);
		$data['other']['packageGrossPrice']=$Price->formatToDisplay2($data['meta']['package_price'],$data['meta']['currency_id']);
		$data['other']['packageTaxRate']=sprintf('%.02f%%',$data['meta']['package_tax_value']);
		$data['other']['packageIsPriceCalculated']=$data['meta']['package_is_price_calculated'];

		if(array_key_exists('payment_type',$data['meta']))
		{
			if(array_key_exists('wc_order_id',$data['meta']))
				$data['other']['payment_type_name']=$WooCommerce->getPaymentName($data['meta']['payment_type']);
			else
				$data['other']['payment_type_name']=$PaymentType->getName($data['meta']['payment_type']);
		}

		if(array_key_exists('coupon_id',$data['meta']))
		{
			$coupon=$Coupon->getCoupon($data['meta']['coupon_id']);
			$data['other']['couponCode']=(count($coupon) ? sprintf(__('%s (Discount: %s%% and Deduction: %s)','car-wash-booking-system'),$coupon['meta']['coupon_code'],$coupon['meta']['discount'],$coupon['meta']['deduction']) : '');
			$data['other']['couponId']=(count($coupon) ? $coupon['post']->ID : 0);
		}
		
		$data['other']['bookingGratuity']=$Price->formatToDisplay2($data['meta']['gratuity'],$data['meta']['currency_id']);
		
		$data['other']['serviceLocation']=$data['meta']['service_location'];
		
		$data['booking']=$this->getBooking($post->ID);
		
		$Template=new CBSTemplate($data,PLUGIN_CBS_TEMPLATE_PATH.'admin/meta_box_booking.php');
		echo $Template->output();			
	}
	
	/**************************************************************************/
	
	function addMetaBoxWooCommerce()
	{
		global $post;

		$booking=$this->getBooking($post->ID);

		if((int)$booking['meta']['woocommerce_booking_id'] > 0)
		{
			echo
			'
				<div>
					<div>'.esc_html__('This booking has corresponding wooCommerce order. Click on button below to see its details in new window.','chauffeur-booking-system').'</div>
					<br/>
					<a class="button button-primary" href="'.esc_url(get_edit_post_link($booking['meta']['woocommerce_booking_id'])).'" target="_blank">'.esc_html__('Open booking','car-wash-booking-system').'</a>
				</div>
			';
		} 
		else
		{
			echo
			'
				<div>
					<div>'.esc_html__('This booking hasn\'t corresponding wooCommerce order.','car-wash-booking-system').'</div>
				</div>
			';
		}
	}
	
	/**************************************************************************/
	
	function adminCreateMetaBoxClass($class) 
	{
		array_push($class,'to-postbox-1');
		return($class);
	}
	
	/**************************************************************************/
	/**************************************************************************/
	
	function manageBookingList()
	{
		if(!is_admin()) return;
		if(CBSHelper::getGetValue('post_type',false)!==PLUGIN_CBS_CONTEXT.'_booking') return;
				
		$Date=new CBSDate();
		
		$html=array_fill(0,3,null);
		
		/***/
		
		$Location=new CBSLocation();
		$location=$Location->getDictionary();
		
		if(!count($location)) return;
		
		$directory=array();
		foreach($location as $locationId=>$locationData)
			$directory[$locationId]=$locationData['post']->{'post_title'};
		
		asort($directory,SORT_STRING);
		
		$User=new CBSUser();
		$userMeta=$User->getMeta(get_current_user_id());
		
		foreach($directory as $directoryIndex=>$directoryValue)
		{
			if(!$User->canUserManageLocation($directoryIndex,get_current_user_id(),$userMeta))
				unset($directory[$directoryIndex]);
		}
		
		foreach($directory as $directoryId=>$directoryData)
			$html[0].='<option value="'.(int)$directoryId.'" '.(((int)CBSHelper::getGetValue('location_id',false)==$directoryId) ?  'selected' : null).'>'.esc_html($directoryData).'</option>';
		
		$html[0]=
		'
			<select name="location_id">
				<option value="0">'.__('All locations','car-wash-booking-system').'</option>
				'.$html[0].'
			</select>
		';
		
		/***/
		
		$BookingStatus=new CBSBookingStatus();
		$bookingStatus=$BookingStatus->getBookingStatus();
		
		if(!count($bookingStatus)) return;
		
		$directory=array();
		foreach($bookingStatus as $bookingStatusId=>$bookingStatusData)
			$directory[$bookingStatusId]=$bookingStatusData[0];
		
		$directory[-2]=__('New & accepted','car-wash-booking-system');
		
		asort($directory,SORT_STRING);
		
		if(!array_key_exists('booking_status_id',$_GET))
			$_GET['booking_status_id']=-2;

		foreach($directory as $directoryId=>$directoryData)
			$html[1].='<option value="'.(int)$directoryId.'" '.(((int)CBSHelper::getGetValue('booking_status_id',false)==$directoryId) ?  'selected' : null).'>'.esc_html($directoryData).'</option>';
		
		$html[1]=
		'
			<select name="booking_status_id">
				<option value="0">'.__('All statuses','car-wash-booking-system').'</option>
				'.$html[1].'
			</select>
		';		
		
		/***/
		
		if(!array_key_exists('booking_date_operator',$_GET))
			$_GET['booking_date_operator']='gt';
		
		foreach($Date->compareOperator as $compareOperatorId=>$compareOperatorData)
			$html[2].='<option value="'.esc_attr($compareOperatorId).'" '.((CBSHelper::getGetValue('booking_date_operator',false)==$compareOperatorId) ?  'selected' : null).'>'.esc_html($compareOperatorData).'</option>';
			
		$html[2]=
		'
			<span>'.esc_html__('Booking date:','car-wash-booking-system').'</span>
			<select name="booking_date_operator">
				'.$html[2].'
			</select>				
			<input type="text" name="booking_date" class="to-datepicker" value="'.esc_attr(CBSHelper::getGetValue('booking_date',false)).'" />
		';
		
		/***/
		
		echo 
		'
			'.join('',$html).'
			<script type="text/javascript">
				jQuery(document).ready(function($)
				{
					var element=$(\'#posts-filter\').themeOptionElement({init:false});
					element.createDatePicker();
				});
			</script>
		';
	}
	
	/**************************************************************************/
	
	function manageBookingListPostFiler($query)
	{
		if(!is_admin()) return;
		if(CBSHelper::getGetValue('post_type',false)!==PLUGIN_CBS_CONTEXT.'_booking') return;
		if($query->query['post_type']!==PLUGIN_CBS_CONTEXT.'_booking') return;

		$metaQuery=array();
		
		$Date=new CBSDate();
		$User=new CBSUser();
		$Validation=new CBSValidation();
		
		/***/
		
		$locationId=(int)CBSHelper::getGetValue('location_id',false);

		global $cbsLocationQuery;
		
		if(!is_array($cbsLocationQuery))
		{
			$cbsLocationQuery=array(-2);
			
			$userMeta=$User->getMeta(get_current_user_id());
			
			if($locationId!=0)
			{
				if($User->canUserManageLocation($locationId,get_current_user_id(),$userMeta))
					$cbsLocationQuery=array($locationId);
			}
			else
			{
				if($User->canUserManageLocation(-1,get_current_user_id(),$userMeta)) $cbsLocationQuery=array();
				else $cbsLocationQuery=$userMeta['location'];
			}
		}
			
		if(count($cbsLocationQuery))
		{
			array_push($metaQuery,array
			(
				'key'=>PLUGIN_CBS_CONTEXT.'_location_id',
				'value'=>$cbsLocationQuery,
				'compare'=>'IN'
			));
		}
		
		/***/
		
		$bookingStatusId=CBSHelper::getGetValue('booking_status_id',false);
		if($Validation->isEmpty($bookingStatusId)) $bookingStatusId=-2;

		if($bookingStatusId!=0)
		{
			array_push($metaQuery,array
			(
				'key'=>PLUGIN_CBS_CONTEXT.'_booking_status',
				'value'=>$bookingStatusId==-2 ? array(1,2) : array($bookingStatusId),
				'compare'=>'IN'
			));
		}
		
		/***/
		
		$date=CBSHelper::getGetValue('booking_date',false);
		$dateOperator=array_key_exists('booking_date_operator',$_GET) ? CBSHelper::getGetValue('booking_date_operator',false) : 'gt';

		if(($Validation->isDate($date)) && (isset($Date->compareOperator[$dateOperator])))
		{
			array_push($metaQuery,array
			(
				'key'=>PLUGIN_CBS_CONTEXT.'_date',
				'value'=>$Date->reverse($date),
				'compare'=>$Date->compareOperator[$dateOperator],
				'type'=>'DATE'
			));			
		}

		/***/
		
		$order=CBSHelper::getGetValue('order',false);
		$orderby=CBSHelper::getGetValue('orderby',false);
		
		if($orderby=='title')
		{
			$query->set('orderby','title');
		}
		else
		{
			switch($orderby)
			{


				case 'location':

					$query->set('meta_key',PLUGIN_CBS_CONTEXT.'_location_name');

					$metaQuery[]=array
					(
						'key'=>PLUGIN_CBS_CONTEXT.'_location_name'
					);

				break;

				case 'price':

					$query->set('meta_key',PLUGIN_CBS_CONTEXT.'_price');
					$query->set('meta_type','DECIMAL');

				break;	

				case 'duration':

					$query->set('meta_key',PLUGIN_CBS_CONTEXT.'_duration');
					$query->set('meta_type','DECIMAL');

				break;	

				case 'client':

					$query->set('meta_key',PLUGIN_CBS_CONTEXT.'_client_second_name');

				break;	

				default:

					$query->set('meta_key',PLUGIN_CBS_CONTEXT.'_datetime');
					$query->set('meta_type','DATETIME');

					if($Validation->isEmpty($order)) $order='asc';
			}

			$query->set('orderby','meta_value');
		}

		$query->set('order',$order);
			
		if(count($metaQuery)) $query->set('meta_query',$metaQuery);
	}
	
	/**************************************************************************/
	
	function manageEditColumn($column)
	{
		$column=array
		(  
			'cb'=>'<input type="checkbox"/>',
			'name'=>__('Name','car-wash-booking-system'),
			'location'=>__('Location','car-wash-booking-system'),
			'status'=>__('Status','car-wash-booking-system'),
			'price'=>__('Price','car-wash-booking-system'),
			'duration'=>__('Duration','car-wash-booking-system'),
			'booking_date'=>__('Booking Date','car-wash-booking-system'),
			'client'=>__('Client','car-wash-booking-system')
		);   
		
		return($column);  
	}  
	
	/**************************************************************************/
	
	function manageEditSortableColumn($column)
	{
		$column['name']='title';
		$column['location']='location';
		$column['price']='price';
		$column['duration']='duration';
		$column['booking_date']='booking_date';
		$column['client']='client';
		return($column);
	}
	
	/**************************************************************************/
	
	function manageColumn($column)
	{		
		global $post;
		
		$Date=new CBSDate();
		$Price=new CBSPrice();
		$BookingStatus=new CBSBookingStatus();
		
		$booking=$this->getBooking($post->ID);
		
		$meta=CBSPostMeta::getPostMeta($post);
		
		switch($column) 
		{
			case 'name':
				
				echo '<strong><a class="row-title" href="'.get_edit_post_link($post->ID).'">'.get_the_title().'</a></strong>'; 
			
			break;
			
			case 'location':
				
				echo '<a href="'.get_edit_post_link($booking['meta']['location_id']).'">'.esc_html($booking['meta']['location_name']).'</a>'; 
				
			break;
		
			case 'status':
				
				echo '<div class="to-booking-status to-booking-status-'.(int)$meta['booking_status'].'">'.esc_html($BookingStatus->bookingStatus[$booking['meta']['booking_status']][0]).'</div>';
				
			break;
		
			case 'price':
				
				echo $Price->formatToDisplay2($meta['price'],$meta['currency_id']);
				
			break;
		
			case 'duration':
				
				echo $meta['duration'].' '.esc_html__('min ','car-wash-booking-system');
				
			break;	
		
			case 'booking_date':
				
				esc_html_e($this->getBookingDuration($Date->reverse($meta['date']).' '.$meta['time'],$meta['duration'])); 
				
			break;
		
			case 'client':
				
				echo '<b>'.esc_html($booking['meta']['client_second_name']).'</b> '.esc_html($booking['meta']['client_first_name']);
				
			break;
		}
	}

	/**************************************************************************/
	/**************************************************************************/

	function getDictionary($attr=array())
	{
		global $post;
		
		$Validation=new CBSValidation();
		$dictionary=array();
		
		$default=array
		(
			'coupon_id'=>0,
			'booking_from'=>'',
			'booking_to'=>'',
			'orderby_booking_date'=>0,
		);
		
		$attribute=shortcode_atts($default,$attr);
		
		CBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'post_type'=>PLUGIN_CBS_CONTEXT.'_booking',
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'orderby'=>array('menu_order'=>'asc','title'=>'asc'),
			'meta_query'=>array(),
		);
		
		if($attribute['coupon_id'])
		{
			$argument['meta_key']=PLUGIN_CBS_CONTEXT.'_coupon_id';
			$argument['meta_value']=$attribute['coupon_id'];
		}
		
		if($attribute['orderby_booking_date'])
		{
			$argument['meta_key']=PLUGIN_CBS_CONTEXT.'_datetime';
			$argument['meta_type']='DATETIME';
			$argument['orderby']='meta_value';
			$argument['order']='asc';
		}
		
		if($attribute['booking_from'])
		{
			$argument['meta_query'][]=array
			(
				'key'=>PLUGIN_CBS_CONTEXT.'_date',
				'value'=>$attribute['booking_from'],
				'compare'=>'>=',
				'type'=>'DATE',
			);
		}
		
		if($attribute['booking_to'])
		{
			$argument['meta_query'][]=array
			(
				'key'=>PLUGIN_CBS_CONTEXT.'_date',
				'value'=>$attribute['booking_to'],
				'compare'=>'<=',
				'type'=>'DATE'	
			);
		}
		
		$query=new WP_Query($argument);
		if($query===false) return($dictionary);
		
		while($query->have_posts())
		{
			$query->the_post();
			$dictionary[$post->ID]['post']=$post;
			$dictionary[$post->ID]['meta']=CBSPostMeta::getPostMeta($post);
		}
		
		CBSHelper::preservePost($post,$bPost,0);	
		
		return($dictionary);
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{		
		if(CBSHelper::checkSavePost($postId,PLUGIN_CBS_CONTEXT.'_meta_box_booking_noncename','savePost')===false) return(false);
	
		$User=new CBSUser();
		if(!$User->canUserManageBooking($postId,false)) return(false);
		
		$bookingOld=$this->getBooking($postId);
		
		$BookingStatus=new CBSBookingStatus();
		if($BookingStatus->isBookingStatus(CBSHelper::getPostValue('booking_status')))
		   CBSPostMeta::updatePostMeta($postId,'booking_status',CBSHelper::getPostValue('booking_status')); 
		  
		$bookingNew=$this->getBooking($postId);
		
		$emailSend=false;
		
		$WooCommerce=new CBSWooCommerce();
		$WooCommerce->changeStatus(-1,$postId,$emailSend);
		
		if(!$emailSend)
			$this->sendEmailBookingChangeStatus($bookingOld,$bookingNew);		
	}
	
	/**************************************************************************/
	
	function processOldBookings()
	{
		$bookings=$this->getDictionary();
		if(!$bookings)
			return;
		
		foreach($bookings as $bookingId=>$bookingData)
		{
			if(!array_key_exists('price_old',$bookingData['meta']))
				continue;
			
			$deduction=0;
			$priceNet=0;
			if((float)$bookingData['meta']['price_old']>0)
			{
				$gratuity=(array_key_exists('gratuity',$bookingData['meta']) ? $bookingData['meta']['gratuity'] : 0);
				$deduction=round($bookingData['meta']['price_old']-$bookingData['meta']['price']+$gratuity,2);
				$priceNet=$bookingData['meta']['price']+$deduction-$gratuity;
			}

			CBSPostMeta::updatePostMeta($bookingId,'deduction',$deduction);
			CBSPostMeta::updatePostMeta($bookingId,'price_net',$priceNet);
			CBSPostMeta::deletePostMeta($bookingId,'price_old');
		}
	}
	
	/**************************************************************************/
	
	function setPostMetaDefault(&$meta)
	{
		CBSHelper::setDefault($meta,'booking_status','1');
		
		CBSHelper::setDefault($meta,'date','');
		CBSHelper::setDefault($meta,'time','');
		CBSHelper::setDefault($meta,'duration','');
		CBSHelper::setDefault($meta,'price','');
		CBSHelper::setDefault($meta,'price_net','');
		CBSHelper::setDefault($meta,'gratuity','');
		CBSHelper::setDefault($meta,'deduction','');
		CBSHelper::setDefault($meta,'currency_id','');
		CBSHelper::setDefault($meta,'service_location','');
		
		CBSHelper::setDefault($meta,'package_price_net','');
		CBSHelper::setDefault($meta,'package_price','');
		CBSHelper::setDefault($meta,'package_tax_value','');
		CBSHelper::setDefault($meta,'package_is_price_calculated','');
		
		CBSHelper::setDefault($meta,'client_first_name','');
		CBSHelper::setDefault($meta,'client_second_name','');
		CBSHelper::setDefault($meta,'client_company_name','');
		CBSHelper::setDefault($meta,'client_vehicle','');
		CBSHelper::setDefault($meta,'client_email_address','');
		CBSHelper::setDefault($meta,'client_phone_number','');
		CBSHelper::setDefault($meta,'client_message','');
		
		CBSHelper::setDefault($meta,'client_address_street','');
		CBSHelper::setDefault($meta,'client_address_post_code','');
		CBSHelper::setDefault($meta,'client_address_city','');
		CBSHelper::setDefault($meta,'client_address_state','');
		CBSHelper::setDefault($meta,'client_address_country','');
	}
	
	/**************************************************************************/
	
	function createBooking()
	{
		$Date=new CBSDate();
		
		global $wpdb;
		
		$response=array('error'=>1,'message'=>null,'reset'=>0,'form'=>null,'bookingId'=>0);
		
		$attribute=array
		(
			'location_id'=>(int)CBSHelper::getPostValue('locationId',false),
			'vehicle_id'=>(int)CBSHelper::getPostValue('vehicleId',false),
			'package_id'=>(int)CBSHelper::getPostValue('packageId',false),
			'service_id'=>CBSHelper::getPostValue('serviceId',false),
			'coupon_code'=>CBSHelper::getPostValue('couponCode',false),
			'gratuity'=>CBSHelper::getPostValue('gratuity',false),
			'service_location'=>CBSHelper::getPostValue('serviceLocation',false),
			'form_agreement'=>CBSHelper::getPostValue('formAgreement',false),
			'payment_type'=>CBSHelper::getPostValue('paymentType',false),
		);
		
		$client=array
		(
			'client_first_name'=>CBSHelper::getPostValue('clientFirstName',false),
			'client_second_name'=>CBSHelper::getPostValue('clientSecondName',false),
			'client_company_name'=>CBSHelper::getPostValue('clientCompanyName',false),
			'client_vehicle'=>CBSHelper::getPostValue('clientVehicle',false),
			'client_email_address'=>CBSHelper::getPostValue('clientEmailAddress',false),
			'client_phone_number'=>CBSHelper::getPostValue('clientPhoneNumber',false),
			'client_message'=>CBSHelper::getPostValue('clientMessage',false),
			'client_address_street'=>CBSHelper::getPostValue('clientAddressStreet',false),
			'client_address_post_code'=>CBSHelper::getPostValue('clientAddressPostCode',false),
			'client_address_city'=>CBSHelper::getPostValue('clientAddressCity',false),
			'client_address_state'=>CBSHelper::getPostValue('clientAddressState',false),
			'client_address_country'=>CBSHelper::getPostValue('clientAddressCountry',false),
		);
		
		$registerUser=array
		(
			'register'=>(int)CBSHelper::getPostValue('registerUser',false),
			'username'=>CBSHelper::getPostValue('username',false),
			'password'=>CBSHelper::getPostValue('password',false),
			'password_check'=>CBSHelper::getPostValue('passwordCheck',false),
		);
		
		$User=new CBSUser();
		$Price=new CBSPrice();
		$Package=new CBSPackage();
		$Service=new CBSService();
		$Coupon=new CBSCoupon();
		$Vehicle=new CBSVehicle();
		$Location=new CBSLocation();
		$GoogleCalendar=new CBSGoogleCalendar();
		$WooCommerce=new CBSWooCommerce();
		$Validation=new CBSValidation();
		
		$package=array();
		$service=array();
		
		$locationId=$attribute['location_id'];
		$packageId=$attribute['package_id'];
		
		$serviceId=CBSHelper::getPostValue('serviceId',false);
		if(!is_array($serviceId)) $serviceId=array();
		
		$dateId=CBSHelper::getPostValue('dateId',false);
		
		$date=null;
		$time=null;
		
		if(strlen($dateId)==12)
		{
			$date=substr($dateId,0,2).'-'.substr($dateId,2,2).'-'.substr($dateId,4,4);
			$time=substr($dateId,8,2).':'.substr($dateId,10,2);		
		}
		
		/***/
		
		$location=$Location->getDictionary($attribute);
		if(count($location)!=1)
		{
			$response['message']=__('Please select valid location.','car-wash-booking-system');
			$this->createBookingJSONResponse($response);
		}
		
		$response['reset']=$location[$locationId]['meta']['reset_form_enable'];

		/***/
	
		$service=$Service->getServicePublic($attribute);
		if(in_array($location[$locationId]['meta']['content_type'],array(2,3))&&$attribute['package_id'])
			$package=$Package->getPackagePublic($attribute);
		
		/***/
		
		$vehicle=$Vehicle->getVehiclePublic($attribute,$service,$package);
		if(!isset($vehicle[$attribute['vehicle_id']]))
		{
			$response['message']=__('Please select valid car type.','car-wash-booking-system');
			$this->createBookingJSONResponse($response);			
		}
		
		/***/
		
		$coupon=$Coupon->getDictionary($attribute);
		$couponId=0;
		if(count($coupon)===1)
		{
			$couponKeys=array_keys($coupon);
			$couponId=array_shift($couponKeys);
		}
		
		/***/
		
		if($location[$locationId]['meta']['content_type']==1)
		{
			$packageId=0;
			
			foreach($serviceId as $serviceIndex)
			{
				if(!array_key_exists($serviceIndex,$service))
					unset($serviceId[$serviceIndex]);
			}
			if(!count($serviceId))
			{
				$response['message']=__('Please select at least one service.','car-wash-booking-system');
				$this->createBookingJSONResponse($response);					
			}
		}
		elseif($location[$locationId]['meta']['content_type']==2)
		{
			if(!isset($package[$attribute['package_id']]))
			{
				$response['message']=__('Please select valid package.','car-wash-booking-system');
				$this->createBookingJSONResponse($response);			
			}			
		}
		elseif($location[$locationId]['meta']['content_type']==3)
		{
			if(isset($package[$packageId]))
			{
				foreach($serviceId as $serviceIndex)
				{		
					if(!array_key_exists($serviceIndex,$package[$packageId]['service']))
						unset($serviceId[$serviceIndex]);	
					elseif($package[$packageId]['service'][$serviceIndex]['service_type']!=2)
						unset($serviceId[$serviceIndex]);
				}
			}
			else
			{
				foreach($serviceId as $serviceIndex)
				{
					if(!array_key_exists($serviceIndex,$service))
						unset($serviceId[$serviceIndex]);	
				}
				
				if(!count($serviceId))
				{
					$response['message']=__('Please select at least one package/service.','car-wash-booking-system');
					$this->createBookingJSONResponse($response);					
				}				
			}
		}		
		
		/***/

		if($Validation->isDate($date) && $Validation->isTime($time))
		{
			$dayNumber=date_i18n('N',strtotime($date));
			
			$cost=$Location->calculateCost($attribute);
			$dateUnavailable=$this->getUnavailableDate($locationId,$date,$date);
			
			$businessHour=$location[$locationId]['meta']['business_hour'][$dayNumber];

			if(!$this->isAvailableDate($date,$time,$cost['duration']['minute_sum'],$location[$locationId]['meta']['slot_number'],array($businessHour['start'],$businessHour['stop']),$dateUnavailable))
			{
				$response['message']=__('Please select valid date/time.','car-wash-booking-system');
				$this->createBookingJSONResponse($response);					
			}			
		}
		else
		{
			$response['message']=__('Please select valid date/time.','car-wash-booking-system');
			$this->createBookingJSONResponse($response);			
		}
		
		/***/
		
		$message=array();
		
		if($Validation->isEmpty($client['client_first_name']))
			array_push($message,__('Please enter your First Name.','car-wash-booking-system'));
		if($Validation->isEmpty($client['client_second_name']))
			array_push($message,__('Please enter your Last Name.','car-wash-booking-system'));
		if($Validation->isEmpty($client['client_vehicle']))
			array_push($message,__('Please enter your Vehicle Make and Model.','car-wash-booking-system'));
		if(!$Validation->isEmailAddress($client['client_email_address']))
			array_push($message,__('Please enter valid E-mail.','car-wash-booking-system'));
		if($Validation->isEmpty($client['client_phone_number']))
			array_push($message,__('Please enter your Phone Number.','car-wash-booking-system'));
		if($location[$locationId]['meta']['service_location_enable'] && $Validation->isEmpty($attribute['service_location']))
			array_push($message,__('Please select a Service Location.','car-wash-booking-system'));
		
		if($location[$locationId]['meta']['gratuity_enable']==1)
		{
			if(!$Validation->isFloat($attribute['gratuity'],0,9999999999.99,true))
				array_push($message,__('Please enter valid value of Gratuity.','car-wash-booking-system'));
		}
		else $attribute['gratuity']=0;
		
		$attribute['gratuity']=preg_replace('/,/','.',$attribute['gratuity']);
		
		$error=$Location->validateAgreement($location[$locationId]['meta'],$attribute['form_agreement']);
		if($error)
			array_push($message,__('Approve all agreements.','car-wash-booking-system'));
		
		
		if($location[$locationId]['meta']['payment_selection_required'] && $Validation->isEmpty($attribute['payment_type']))
			array_push($message,__('Please select a payment type.','car-wash-booking-system'));
		
		if(count($message))
		{
			$response['message']=$message;
			$this->createBookingJSONResponse($response);
		}
		
		$user=get_current_user_id();
		if($user==0 && $registerUser['register'] && get_option('users_can_register'))
		{
			if($Validation->isEmpty($registerUser['username']))
			{
				$response['message']=__('Please enter your username.','car-wash-booking-system');
				$this->createBookingJSONResponse($response);
			}
			
			if($Validation->isEmpty($registerUser['password']) || $Validation->isEmpty($registerUser['password_check']))
			{
				$response['message']=__('Please enter your password.','car-wash-booking-system');
				$this->createBookingJSONResponse($response);
			}
			
			if($registerUser['password']!=$registerUser['password_check'])
			{
				$response['message']=__('Passwords doesn\'t match.','car-wash-booking-system');
				$this->createBookingJSONResponse($response);
			}
			
			$userData=array
			(
				'username'=>$registerUser['username'],
				'password'=>$registerUser['password'],
				'email'=>$client['client_email_address'],
			);
			$userMeta=array
			(
				'first_name'=>$client['client_first_name'],
				'last_name'=>$client['client_second_name'],
				'company_name'=>$client['client_company_name'],
				'phone_number'=>$client['client_phone_number'],
				'vehicle'=>$client['client_vehicle'],
				'address_street'=>$client['client_address_street'],
				'address_post_code'=>$client['client_address_post_code'],
				'address_city'=>$client['client_address_city'],
				'address_state'=>$client['client_address_state'],
				'address_country'=>$client['client_address_country'],
				'show_admin_bar_front'=>false,
			);
			$user=$User->createUser($userData,$userMeta);
			if(!$Validation->isNumber($user,1,999999))
			{
				$response['message']=$user;
				$this->createBookingJSONResponse($response);
			}
		}
		
		/***/
		$booking=array
		(
			'post_type'=>PLUGIN_CBS_CONTEXT.'_booking',
			'post_status'=>'publish'
		);
		
		$bookingId=wp_insert_post($booking);
		if($bookingId==0)
		{
			$response['message']=__('We cannot send this booking.','car-wash-booking-system');
			$this->createBookingJSONResponse($response);
		}
		
		$booking=array
		(
			'ID'=>$bookingId,
			'post_title'=>$this->getBookingTitle($bookingId)
		);
		
		wp_update_post($booking);
		
		/***/

		CBSPostMeta::updatePostMeta($bookingId,'user',$user);
		
		CBSPostMeta::updatePostMeta($bookingId,'booking_status',1);
		
		CBSPostMeta::updatePostMeta($bookingId,'location_id',$attribute['location_id']);
		CBSPostMeta::updatePostMeta($bookingId,'location_name',$location[$attribute['location_id']]['post']->post_title);
		
		CBSPostMeta::updatePostMeta($bookingId,'vehicle_id',$attribute['vehicle_id']);
		CBSPostMeta::updatePostMeta($bookingId,'vehicle_name',$vehicle[$attribute['vehicle_id']]['post']->post_title);
		CBSPostMeta::updatePostMeta($bookingId,'enable_vehicle_type',$location[$locationId]['meta']['enable_vehicle_type']);
		
		if(in_array($location[$locationId]['meta']['content_type'],array(2,3))&&$attribute['package_id'])		
		{
			CBSPostMeta::updatePostMeta($bookingId,'package_id',$attribute['package_id']);
			CBSPostMeta::updatePostMeta($bookingId,'package_name',$package[$attribute['package_id']]['post']->post_title);
			CBSPostMeta::updatePostMeta($bookingId,'package_price_net',$package[$attribute['package_id']]['cost']['priceRealNet']);
			CBSPostMeta::updatePostMeta($bookingId,'package_price',$package[$attribute['package_id']]['cost']['priceReal']);
			CBSPostMeta::updatePostMeta($bookingId,'package_tax_value',$package[$attribute['package_id']]['cost']['taxRateValue']);
			CBSPostMeta::updatePostMeta($bookingId,'package_is_price_calculated',$package[$attribute['package_id']]['cost']['isPriceCalculated']);
		}
		
		if($Coupon->isActive($couponId,$locationId,(float)$Price->formatToSave($cost['price']['unit'].','.$cost['price']['decimal'])))
			CBSPostMeta::updatePostMeta($bookingId,'coupon_id',$couponId);
		
		CBSPostMeta::updatePostMeta($bookingId,'content_type',$location[$locationId]['meta']['content_type']);
		
		foreach($client as $clientIndex=>$clientData)
			CBSPostMeta::updatePostMeta($bookingId,$clientIndex,$clientData);
		
		CBSPostMeta::updatePostMeta($bookingId,'duration',$cost['duration']['minute_sum']);
		CBSPostMeta::updatePostMeta($bookingId,'currency_id',$location[$locationId]['meta']['currency']);
		CBSPostMeta::updatePostMeta($bookingId,'price',$Price->formatToSave($cost['price']['unit'].','.$cost['price']['decimal']));
		CBSPostMeta::updatePostMeta($bookingId,'price_net',$Price->formatToSave($cost['price_net']['unit'].','.$cost['price_net']['decimal']));
		CBSPostMeta::updatePostMeta($bookingId,'deduction',$Price->formatToSave($cost['deduction']['unit'].','.$cost['deduction']['decimal']));
		CBSPostMeta::updatePostMeta($bookingId,'gratuity',$attribute['gratuity']);
		CBSPostMeta::updatePostMeta($bookingId,'time',$time);
		CBSPostMeta::updatePostMeta($bookingId,'date',$Date->reverse($date));
		CBSPostMeta::updatePostMeta($bookingId,'datetime',date_i18n('Y-m-d H:i',strtotime($date.' '.$time)));		
		CBSPostMeta::updatePostMeta($bookingId,'service_location',$attribute['service_location']);
		
		/****/

		$query=null;
		if(in_array($location[$locationId]['meta']['content_type'],array(2,3))&&$attribute['package_id'])
		{
			if(isset($package[$packageId]))
			{
				$i=0;
				foreach($service as $serviceIndex=>$serviceData)
				{
					if(!isset($package[$packageId]['service'][$serviceIndex])) continue;
					if($package[$packageId]['service'][$serviceIndex]['service_type']!=1) continue;
					
					if($Validation->isNotEmpty($query)) $query.=',';
					$query.=$wpdb->prepare('(%d,%d,%d,%s,%f,%d,%d,%f)',$bookingId,$serviceIndex,1,$serviceData['post']->{'post_title'},$serviceData['cost']['priceNet'],$serviceData['cost']['duration'],(++$i),$serviceData['cost']['tax_rate']);
				}
			}			
		}
		
		$i=0;
		foreach($service as $serviceIndex=>$serviceData)
		{
			if(!in_array($serviceIndex,$serviceId)) continue;
			
			if($Validation->isNotEmpty($query)) $query.=',';
			$query.=$wpdb->prepare('(%d,%d,%d,%s,%f,%d,%d,%f)',$bookingId,$serviceIndex,2,$serviceData['post']->{'post_title'},$serviceData['cost']['priceNet'],$serviceData['cost']['duration'],(++$i),$serviceData['cost']['tax_rate']);
		}

		$query='insert into '.CBSHelper::getMySQLTableName('booking_service').'(booking_id,service_id,service_type,name,price,duration,service_order,tax_rate_value) values'.$query;
		$wpdb->query($query);
		
		/****/
		
		$GoogleCalendar->insertBooking($bookingId);
		
		/****/
		
		if($WooCommerce->isEnable($location[$locationId]['meta']))
		{
			$orderId=$WooCommerce->sendBooking($bookingId,$attribute);
			CBSPostMeta::updatePostMeta($bookingId,'wc_order_id',$orderId);
		}

		/****/
		
		if($Validation->isNotEmpty($attribute['payment_type']))
		{
			$this->setPayment($bookingId,$attribute['payment_type']);
		}

		$this->sendEmail($bookingId,'booking_new_client',sprintf(__('New booking "%s" is received','car-wash-booking-system'),$booking['post_title']),array($client['client_email_address']));
		$this->sendEmail($bookingId,'booking_new_admin',sprintf(__('New booking "%s" is received','car-wash-booking-system'),$booking['post_title']),preg_split('/;/',$location[$locationId]['meta']['recipient_email']));
		
		if($location[$locationId]['meta']['nexmo_sms_enable']==1)
		{
			$Nexmo=new CBSNexmo();
			$Nexmo->sendSMS($location[$locationId]['meta']['nexmo_sms_api_key'],$location[$locationId]['meta']['nexmo_sms_api_key_secret'],$location[$locationId]['meta']['nexmo_sms_sender_name'],$location[$locationId]['meta']['nexmo_sms_recipient_phone_number'],$location[$locationId]['meta']['nexmo_sms_message']);
		}
		
		if($location[$locationId]['meta']['twilio_sms_enable']==1)
		{
			$Twilio=new CBSTwilio();
			$Twilio->sendSMS($location[$locationId]['meta']['twilio_sms_api_sid'],$location[$locationId]['meta']['twilio_sms_api_token'],$location[$locationId]['meta']['twilio_sms_sender_phone_number'],$location[$locationId]['meta']['twilio_sms_recipient_phone_number'],$location[$locationId]['meta']['twilio_sms_message']);
		}
		
		/***/
		
		$booking=$this->getBooking($bookingId);
		if(!count($booking)) return(null);
		
		$response['error']=0;
		$response['payment_type']=$booking['meta']['payment_type'];
		
		if($WooCommerce->isEnable($location[$locationId]['meta']))
		{
			$response['payment_type']='woocommerce';
			
			$order=wc_get_order($booking['meta']['wc_order_id']);
			
			$response['woocommerce_checkout_url']=$order->get_checkout_payment_url();	
			
			$response['message']=__('Booking has been sent. You are redirecting to the payment page.','car-wash-booking-system');
		}
		else
		{
			if($booking['meta']['payment_type']=='paypal')
			{
				$response['form']['item_name']=$booking['post']->post_title;
				$response['form']['item_number']=$booking['post']->ID;
							
				$response['form']['currency_code']=$booking['meta']['currency_id'];

				$response['form']['amount']=$booking['meta']['price'];	
				
				$response['message']=__('Booking has been sent. You are redirecting to the payment page.','car-wash-booking-system');
			}
			else if($booking['meta']['payment_type']=='stripe')
			{	
				$PaymentStripe=new CBSPaymentStripe();
							
				$sessionId=$PaymentStripe->createSession($booking,$location[$locationId]);
							
				$response['stripe_session_id']=$sessionId;
				$response['stripe_publishable_key']=$location[$locationId]['meta']['payment_stripe_api_key_publishable'];
						
				if($sessionId===false)
				{
					$response['error']=1;
					$response['message']=__('An error occurs during processing this payment. Plugin cannot continue the work.','car-wash-booking-system');
				}
				else
				{
					$response['message']=__('Booking has been sent. You are redirecting to the payment page.','car-wash-booking-system');
				}
			}		
			else
			{
				if($Validation->isNotEmpty($location[$locationId]['meta']['payment_cash_thank_you_page_url_address']))
					$response['thank_you_page_url_address']=$location[$locationId]['meta']['payment_cash_thank_you_page_url_address'];
				
				$response['message']=__('Booking has been sent.','car-wash-booking-system');
			}
		}
		
		$this->createBookingJSONResponse($response);
	}
	
	/**************************************************************************/
	
	function createBookingJSONResponse($response)
	{
		$response['notice']['text']='';
		$response['notice']['header']=$response['error']==1 ? __('Errors Found!','car-wash-booking-system') : __('Thank you!','car-wash-booking-system');
		
		if(is_array($response['message']))
		{
			foreach($response['message'] as $dataValue)
				$response['notice']['text'].='<div>'.$dataValue.'</div>';
		}
		else $response['notice']['text']='<div>'.$response['message'].'</div>';
		
		CBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
	
	function getBookingTitle($bookingId)
	{
		return(__('Booking #','car-wash-booking-system').$bookingId);
	}
	
	/**************************************************************************/
	
	function getBooking($bookingId)
	{
		global $post,$wpdb;
		
		$data=array();

		CBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'p'=>$bookingId,
			'post_type'=>PLUGIN_CBS_CONTEXT.'_booking',
			'post_status'=>'publish',
			'posts_per_page'=>-1
		);
		
		$query=new WP_Query($argument);
		if($query===false) return($data);
		
		while($query->have_posts())
		{
			$query->the_post();
			$data['post']=$post;
			$data['meta']=CBSPostMeta::getPostMeta($post);
		}
		
		CBSHelper::preservePost($post,$bPost,0);	
		
		/***/
		
		$query=$wpdb->prepare('select * from '.CBSHelper::getMySQLTableName('booking_service').' where booking_id=%d order by service_type,service_order',$bookingId);
		$result=$wpdb->get_results($query);
		
		foreach($result as $line)
			$data['detail'][]=$line;

		if(isset($data['detail']))
		{
			foreach($data['detail'] as $detailIndex=>$detailData)
			{
				$data['detail'][$detailIndex]->{'service_price'}=$this->getBookingServicePrice($detailData->{'price'},$data['meta']['currency_id'],$detailData->{'service_type'});
				$data['detail'][$detailIndex]->{'service_tax_rate'}=$this->getBookingServiceTaxRate($detailData->{'tax_rate_value'},$detailData->{'service_type'});
				
				$data['detail'][$detailIndex]->{'service_price_gross'}=$detailData->{'price'};
				if($detailData->{'tax_rate_value'}>0)
					$data['detail'][$detailIndex]->{'service_price_gross'}+=round($data['detail'][$detailIndex]->{'service_price_gross'}*($detailData->{'tax_rate_value'}/100),2);
				$data['detail'][$detailIndex]->{'service_price_gross_raw'}=$data['detail'][$detailIndex]->{'service_price_gross'};
				$data['detail'][$detailIndex]->{'service_price_gross'}=$this->getBookingServicePrice($data['detail'][$detailIndex]->{'service_price_gross'},$data['meta']['currency_id'],$detailData->{'service_type'});

				$data['detail'][$detailIndex]->{'service_type_name'}=$this->getBookingServiceTypeName($detailData->{'service_type'},(isset($data['meta']['package_name']) ? $data['meta']['package_name'] : null));
			}
		}
		
		/***/
		
		$query=$wpdb->prepare('select * from '.CBSHelper::getMySQLTableName('booking_payment').' where booking_id=%d order by payment_date desc',$bookingId);
		$result=$wpdb->get_results($query);
		
		foreach($result as $line)
			$data['payment'][]=$line;
		
		return($data);		
	}
	
	/**************************************************************************/
	
	function sendEmail($bookingId,$file,$subject,$recipient)
	{
		$Date=new CBSDate();
		$Price=new CBSPrice();
		$Email=new CBSEmail();
		$Booking=new CBSBooking();
		$Coupon=new CBSCoupon();
		$Location=new CBSLocation();
		$Validation=new CBSValidation();
		$BookingStatus=new CBSBookingStatus();
		$PaymentType=new CBSPaymentType();
		$WooCommerce=new CBSWooCommerce();
		
		$booking=$Booking->getBooking($bookingId);
		if(!count($booking)) return(false);

		$locationId=$booking['meta']['location_id'];
		
		$location=$Location->getDictionary(array('location_id'=>$locationId));
		if(!isset($location[$locationId])) return(false);

		if(!$Validation->isEmailAddress($location[$locationId]['meta']['sender_email'])) return;
		if($Validation->isEmpty($location[$locationId]['meta']['sender_name'])) return;
		
		global $cbs_phpmailer;
			
		$cbs_phpmailer['account']['name']=$location[$locationId]['meta']['sender_name'];
		$cbs_phpmailer['account']['email']=$location[$locationId]['meta']['sender_email'];
		
		$cbs_phpmailer['smtp']['enable']=$location[$locationId]['meta']['sender_smtp_enable'];
		$cbs_phpmailer['smtp']['username']=$location[$locationId]['meta']['sender_smtp_username'];
		$cbs_phpmailer['smtp']['password']=$location[$locationId]['meta']['sender_smtp_password'];
		$cbs_phpmailer['smtp']['host']=$location[$locationId]['meta']['sender_smtp_host'];
		$cbs_phpmailer['smtp']['port']=$location[$locationId]['meta']['sender_smtp_port'];
		$cbs_phpmailer['smtp']['secure_connection_type']=$location[$locationId]['meta']['sender_smtp_secure_connection_type'];
		$cbs_phpmailer['smtp']['debug_enable']=$location[$locationId]['meta']['smtp_debug_enable'];
		
		$data=array();
		
		$data['booking']=$booking;
		$data['location']=$location[$locationId];
		
		$data['admin']=($file=='booking_new_admin' ? 1 : 0);
		
		$data['format']=$this->getEmailStyle();
		
		$data['other']['bookingUrl']=admin_url('post.php').'?post='.$bookingId.'&action=edit';
		$data['other']['bookingStatus']=$BookingStatus->bookingStatus[$booking['meta']['booking_status']][0];
		$data['other']['bookingDuration']=$this->getBookingDuration($Date->reverse($booking['meta']['date']).' '.$booking['meta']['time'],$booking['meta']['duration'],$locationId);

		$data['other']['bookingPriceGross']=$Price->formatToDisplay2($this->getBookingGrossPrice($booking),$booking['meta']['currency_id']);
		$data['other']['bookingPrice']=$Price->formatToDisplay2($booking['meta']['price'],$booking['meta']['currency_id']);
		
		$data['other']['gratuity']=$booking['meta']['gratuity'];
		$data['other']['serviceLocation']=$booking['meta']['service_location'];
		$data['other']['bookingGratuity']=$Price->formatToDisplay2($booking['meta']['gratuity'],$booking['meta']['currency_id']);
		
		if(array_key_exists('coupon_id', $booking['meta']))
		{
			$couponId=$booking['meta']['coupon_id'];
			$coupon=$Coupon->getCoupon($couponId);
			$data['other']['couponCode']=(count($coupon) ? sprintf(__('%s (Discount: %s%% and Deduction: %s)','car-wash-booking-system'),$coupon['meta']['coupon_code'],$coupon['meta']['discount'],$coupon['meta']['deduction']) : '');
			$data['other']['bookingPrice'].=sprintf(__(' (Before %s%% discount and %s deduction: %s)','car-wash-booking-system'),$coupon['meta']['discount'],$coupon['meta']['deduction'],$data['other']['bookingPriceGross']);
		}
		
		if(array_key_exists('payment_type',$booking['meta']))
		{
			if($WooCommerce->isEnable($location[$locationId]['meta']))
			{
				$order=wc_get_order($booking['meta']['wc_order_id']);
				
				$data['other']['payment_type']=$WooCommerce->getPaymentName($booking['meta']['payment_type']);
				$data['other']['payment_form']='<a href="'.esc_attr($order->get_checkout_payment_url()) . '" class="cbs-wc-checkout-link">'.__('Click to pay via WooCommerce.','car-wash-booking-system').'</a>';
			}
			else		
			{
				$data['other']['payment_type']=$PaymentType->getName($booking['meta']['payment_type']);
			}
		}
		
		$Template=new CBSTemplateEmail();
		$body=$Template->output($file,$data,false,true,true);

		$Email->send($recipient,$subject,$body);
	}
	
	/**************************************************************************/
	
	function sendEmailBookingChangeStatus($bookingOld,$bookingNew)
	{
		if($bookingOld['meta']['booking_status']==$bookingNew['meta']['booking_status']) return;
		
		$BookingStatus=new CBSBookingStatus();
		$bookingStatus=$BookingStatus->getBookingStatus($bookingNew['meta']['booking_status']);
			
		$recipient=array();
		$recipient[0]=array($bookingNew['meta']['client_email_address']);
	   
		$subject=sprintf(__('Booking "%s" has changed status to "%s"','car-wash-booking-system'),$bookingNew['post']->post_title,$bookingStatus[0]);
		
		global $cbs_logEvent;
		
		$cbs_logEvent=3;
		$this->sendEmail($bookingNew['post']->ID,'booking_change_status_client',$subject,array($bookingNew['meta']['client_email_address']));
	}
	
	/**************************************************************************/
	
	function getEmailStyle()
	{
		$style=array();
		
		$style['separator'][1]=' style="height:45px" height="45px" ';
		$style['separator'][2]=' style="height:30px" height="30px" ';
		$style['separator'][3]=' style="height:15px" height="15px" ';

		$style['base']=' style="font-family:Arial;font-size:15px;color:#777777;line-height:150%;" ';
		
		$style['cell'][1]=' style="width:250px;" ';
		$style['cell'][2]=' style="width:300px;" ';
		
		$style['header']=' style="font-weight:bold;color:#444444;border-bottom:dotted 1px #AAAAAA;padding:0px 0px 5px 0px;text-transform:uppercase" ';
		
		return($style);
	}
	
	/**************************************************************************/
	
	function getUnavailableDate($locationId,$dateStart,$dateStop)
	{
		global $post;
		
		$Date=new CBSDate();
		
		$date=array();
		
		CBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'post_type'=>PLUGIN_CBS_CONTEXT.'_booking',
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'meta_query'=>array
			(
				array
				(
					'key'=>PLUGIN_CBS_CONTEXT.'_location_id',
					'value'=>$locationId,
					'compare'=>'=',
				),
				array
				(
					'key'=>PLUGIN_CBS_CONTEXT.'_date',
					'value'=>array($Date->reverse($dateStart),$Date->reverse($dateStop)),
					'compare'=>'BETWEEN',
					'type'=>'DATE'
				),
				array
				(
					'key'=>PLUGIN_CBS_CONTEXT.'_booking_status',
					'value'=>array(3),
					'compare'=>'NOT IN',
				)
			)
		);
		
		$query=new WP_Query($argument);
		if($query===false) return($date);
		
		while($query->have_posts())
		{
			$query->the_post();
			
			$meta=CBSPostMeta::getPostMeta($post);
			
			/*mod*/
			$meta['duration']=PLUGIN_CBS_CUSTOM_DURATION;
			/*mod*/
			
			$dateStart=$Date->reverse($meta['date']).' '.$meta['time'];
			$dateStop=date_i18n('d-m-Y H:i',strtotime($dateStart.' + '.($meta['duration']==0 ? 1 : $meta['duration']).' minute'));
			
			$date[]=array($dateStart,$dateStop);
		}
		
		CBSHelper::preservePost($post,$bPost,0);	
		
		return($date);		
	}
	
	/**************************************************************************/
	
	function isAvailableDate($dateToCheck,$timeToCheck,$duration,$slotCount,$businessHour,$dateUnavailable)
	{
		/*mod*/
		$duration=PLUGIN_CBS_CUSTOM_DURATION;
		/*mod*/
		
		$Date=new CBSDate();
		
		$dateToCheckStart=date_i18n('d-m-Y H:i',strtotime($dateToCheck.' '.$timeToCheck));
		$dateToCheckStop=date_i18n('d-m-Y H:i',strtotime($dateToCheck.' '.$timeToCheck.' + '.$duration.' minute'));
		
		$count=0;
		foreach($dateUnavailable as $dateUnavailableValue)
		{
			$colision=false;
			
			if(strtotime($dateToCheckStart)===strtotime($dateUnavailableValue[0])) $colision=true;
			if(strtotime($dateToCheckStop)===strtotime($dateUnavailableValue[1])) $colision=true;
			
			if(($Date->checkInRange($dateToCheckStart,$dateUnavailableValue[0],$dateUnavailableValue[1])) || ($Date->checkInRange($dateToCheckStop,$dateUnavailableValue[0],$dateUnavailableValue[1])) || ($Date->checkInRange($dateUnavailableValue[0],$dateToCheckStart,$dateToCheckStop)) || ($Date->checkInRange($dateUnavailableValue[1],$dateToCheckStart,$dateToCheckStop)))
				$colision=true;
			
			if($colision)
			{
				$count++;
				if($count>=$slotCount) return(false);
			}
		}

		if(!(($Date->checkInRange($dateToCheckStart,date_i18n('d-m-Y',strtotime($dateToCheckStart)).' '.$businessHour[0],date_i18n('d-m-Y',strtotime($dateToCheckStart)).' '.$businessHour[1],true)) || ($Date->checkInRange($dateToCheckStop,date_i18n('d-m-Y',strtotime($dateToCheckStop)).' '.$businessHour[0],date_i18n('d-m-Y',strtotime($dateToCheckStop)).' '.$businessHour[1],true)))) return(false);
		
		return(true);
	}
	
	/**************************************************************************/
	
	function getBookingGrossPrice($booking)
	{
		$Price=new CBSPrice();
		$Location=new CBSLocation();
		$Coupon=new CBSCoupon();
		
		$serviceId=array();
		$packageId=0;
		$couponCode='';
		
		if(array_key_exists('package_id',$booking['meta']))
			$packageId=$booking['meta']['package_id'];
		
		foreach($booking['detail'] as $line)
		{
			if($line->service_type==2)
				$serviceId[]=$line->service_id;
		}

		if(array_key_exists('coupon_id',$booking['meta']))
		{
			$coupon=$Coupon->getCoupon($booking['meta']['coupon_id']);
			if(count($coupon)) 
				$couponCode=$coupon['meta']['coupon_code'];
		}
		
		$attribute=array(
			'location_id'=>$booking['meta']['location_id'],
			'vehicle_id'=>$booking['meta']['vehicle_id'],
			'package_id'=>$packageId,
			'service_id'=>$serviceId,
			'coupon_code'=>$couponCode,
			'gratuity'=>$booking['meta']['gratuity'],
		);
		
		$cost=$Location->calculateCost($attribute);
		$priceGross=$Price->formatToSave($cost['price_gross']['unit'].','.$cost['price_gross']['decimal']);
		return($priceGross);
	}
	
	/**************************************************************************/
	
	function getBookingDuration($date,$duration,$locationId=0)
	{
		$Date=new CBSDate();
		$Validation=new CBSValidation();
		
		$startDate=date_i18n('d-m-Y',strtotime($date));
		$startTime=date_i18n('H:i',strtotime($date));
		
		$stopTime=date_i18n('H:i',strtotime('+ '.$duration.' minutes',strtotime($date)));
		
		if($locationId!=0)
		{
			$Location=new CBSLocation();
			$location=$Location->getDictionary(array('location_id'=>$locationId));
			
			if(isset($location[$locationId]))
			{
				if($Validation->isNotEmpty($location[$locationId]['meta']['booking_date_format']))
					$startDate=date_i18n($Validation->isEmpty($location[$locationId]['meta']['booking_date_format']) ? 'd-m-Y' : $location[$locationId]['meta']['booking_date_format'],strtotime($startDate));
				
				$postfix=null;
				$Date->formatTime($startTime,$postfix,$location[$locationId]['meta']['booking_time_format']);
				$startTime=$startTime.$postfix;
				
				$postfix=null;
				$Date->formatTime($stopTime,$postfix,$location[$locationId]['meta']['booking_time_format']);
				$stopTime=$stopTime.$postfix;
			}
		}
		
		return($startDate.': '.$startTime.' - '.$stopTime.' '.sprintf(__('(%d min)','car-wash-booking-system'),$duration));
	}
	
	/**************************************************************************/
	
	function getBookingServiceTypeName($serviceType,$packageName)
	{
		return($serviceType==1 ? sprintf(__('%s Package','car-wash-booking-system'),$packageName) : __('Single Service','car-wash-booking-system'));
	}
	
	/**************************************************************************/
	
	function getBookingServicePrice($price,$currencyId,$serviceType)
	{
		$Price=new CBSPrice();
		
		$price=$serviceType==1 ? 0.00 : $price;
		return($Price->formatToDisplay2($price,$currencyId));
	}
	
	/**************************************************************************/
	
	function getBookingServiceTaxRate($taxRate,$serviceType)
	{
		$taxRate=$serviceType==1 ? 0 : $taxRate;
		return(sprintf('%.02f%%',$taxRate));
	}
	
	/**************************************************************************/
	
	function createPaypalForm($bookingId,$submitButton=false)
	{
		$Location=new CBSLocation();
		
		$booking=$this->getBooking($bookingId);
		if(!count($booking)) return(null);
		
		$locationId=$booking['meta']['location_id'];

		$location=$Location->getDictionary(array('location_id'=>$locationId));
		if(count($location)!=1) return(null);
		
		$pageId=(int)CBSHelper::getPostValue('pageId',false);
		
		$html=
		'
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" id="cbs-paypal-form">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="'.esc_attr($location[$locationId]['meta']['payment_paypal_email_address']).'">				
				<input type="hidden" name="item_name" value="'.esc_attr(get_the_title($bookingId)).'">
				<input type="hidden" name="item_number" value="'.(int)$bookingId.'">
				<input type="hidden" name="amount" value="'.esc_attr($booking['meta']['price']).'">	
				<input type="hidden" name="currency_code" value="'.esc_attr($booking['meta']['currency_id']).'">
				<input type="hidden" value="1" name="no_shipping">
				<input type="hidden" value="'.get_the_permalink($pageId).'?action=ipn" name="notify_url">				
				<input type="hidden" value="'.get_the_permalink($pageId).'?action=success" name="return">
				<input type="hidden" value="'.get_the_permalink($pageId).'?action=cancel" name="cancel_return">
				'.($submitButton ? __('Click on this link to pay for booking:','car-wash-booking-system').'<input type="submit" value="'.esc_attr__('Click to pay via Paypal','car-wash-booking-system').'" style="background:none;border:none;cursor:pointer;text-decoration:underline;color:#1155CC">' : null).'
			</form>
		';
		
		return($html);
	}
	
	/**************************************************************************/
	
	function createStripeForm($bookingId,$submitButton=false)
	{
		$booking=$this->getBooking($bookingId);
		if(!count($booking)) return(null);

		$locationId=$booking['meta']['location_id'];
		$Location=new CBSLocation();
		$location=$Location->getDictionary(array('location_id'=>$locationId));
		if(count($location)!=1) return(null);
		
		$pageId=(int)CBSHelper::getPostValue('pageId',false);
		$amount=$booking['meta']['price']*100;
		
		$html='';
		
		if($submitButton)
		{
			$html.=
			'
				<form id="cbs-stripe-form" action="'.get_the_permalink($pageId).'" method="post" target="_blank">
					<input type="hidden" name="bookingId" value="'.esc_attr($bookingId).'"/>
					<input type="hidden" name="pageId" value="'.esc_attr($pageId).'"/>
					<input type="hidden" name="stripeForm" value="show"/>
					'.__('Click on this link to pay for booking:','car-wash-booking-system').'<input type="submit" value="'.esc_attr__('Click to pay via Stripe','car-wash-booking-system').'" style="background:none;border:none;cursor:pointer;text-decoration:underline;color:#1155CC">'.'
				</form>
			';
		}
		else
		{
			$html.=
			'
				<form id="cbs-stripe-form" action="'.get_the_permalink($pageId).'?bookingId='.$bookingId.'" method="POST">
				<script
					src="https://checkout.stripe.com/checkout.js" class="stripe-button"
					data-key="'.$location[$locationId]['meta']['payment_stripe_publishable_key'].'"
					data-amount="'.$amount.'"
					data-name="'.esc_attr(get_the_title($bookingId)).'"
					data-description="'.esc_attr__('New order','car-wash-booking-system').'"
					data-currency="'.esc_attr($booking['meta']['currency_id']).'"
					data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
					data-locale="auto">
					</script>
					<button type="submit" formtarget="_blank" style="display:none !important;"></button>
				</form>';
		}
		return($html);
	}
	
	/**************************************************************************/
	
	function createStripeHandler($locationId)
	{
		$locationId=$locationId;
		$Location=new CBSLocation();
		$location=$Location->getDictionary(array('location_id'=>$locationId));
		if(count($location)!=1) return(null);
		
		$html='';
		
		$html.=
		'
			<script>
			if(typeof(StripeCheckout)!=="undefined")
			{
				var stripeHandler = StripeCheckout.configure({
					key: "'.$location[$locationId]['meta']['payment_stripe_publishable_key'].'",
					image: "https://stripe.com/img/documentation/checkout/marketplace.png",
					description: "New order",
					locale: "auto",
					token: function(token)
					{
						var data={};
						data.action="cbs_handle_stripe_token";
						data.token=token;
						data.bookingId=stripeHandler.bookingId;
						jQuery.post(pluginOption.config.ajaxurl,data,function(response){},"json");
					},
					opened: function() {
						jQuery.scrollTo(jQuery(".stripe_checkout_app").offset().top,{offset:-60});
					}
				});
				window.addEventListener("popstate", function() {
					stripeHandler.close();					
				});
			}
			</script>
		';
		
		return $html;
	}
	
	/**************************************************************************/
	
	function setPayment($bookingId,$paymentType)
	{
		$PaymentType=new CBSPaymentType();
		$Location=new CBSLocation();
		$WooCommerce=new CBSWooCommerce();
		
		$booking=$this->getBooking($bookingId);

		if((!count($booking))) 
			return(false);

		$locationId=$booking['meta']['location_id'];
		$location=$Location->getDictionary(array('location_id'=>$locationId));
		if(!isset($location[$locationId])) return(false);

		if($WooCommerce->isEnable($location[$locationId]['meta']))
		{
			if(!$WooCommerce->isPayment($paymentType))
				return(false);
		}
		else
		{
			if(!$PaymentType->isPayment($paymentType)) 
				return(false);
		}
		
		CBSPostMeta::updatePostMeta($bookingId,'payment_type',$paymentType);
		
		return(true);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/