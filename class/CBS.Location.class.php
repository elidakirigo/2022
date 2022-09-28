<?php

/******************************************************************************/
/******************************************************************************/

class CBSLocation
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->contentType=array
		(
			1=>array(__('Services',PLUGIN_CBS_CONTEXT)),
			2=>array(__('Packages',PLUGIN_CBS_CONTEXT)),
			3=>array(__('Packages And Services',PLUGIN_CBS_CONTEXT))
		);
		
		$this->colorDefault=array
		(
			1=>'199CDB',
			2=>'FFFFFF',
			3=>'222222',
			4=>'777777',
			5=>'A8B1B6',
			6=>'E2E6E7',
			7=>'E0E0E0',
			8=>'FFFFFF',
			9=>'CCCCCC',
			10=>'A8B1B6'
		);
		
		$this->colorCount=count($this->colorDefault);
	}
	
	/**************************************************************************/
	
	function init()
	{
		register_post_type
		(
			PLUGIN_CBS_CONTEXT.'_location',
			array
			(
				'labels'=>array
				(
					'name'=>__('Location','car-wash-booking-system'),
					'singular_name'=>__('Locations','car-wash-booking-system'),
					'add_new'=>__('Add New','car-wash-booking-system'),
					'add_new_item'=>__('Add New Location','car-wash-booking-system'),
					'edit_item'=>__('Edit Location','car-wash-booking-system'),
					'new_item'=>__('New Location','car-wash-booking-system'),
					'all_items'=>__('Locations','car-wash-booking-system'),
					'view_item'=>__('View Location','car-wash-booking-system'),
					'search_items'=>__('Search Locations','car-wash-booking-system'),
					'not_found'=>__('No Locations Found','car-wash-booking-system'),
					'not_found_in_trash'=>__('No Locations Found in Trash','car-wash-booking-system'), 
					'parent_item_colon'=>'',
					'menu_name'=>__('Car Types','car-wash-booking-system')
				),	
				'public'=>false,  
				'show_ui'=>true, 
				'show_in_menu'=>'edit.php?post_type=cbs_booking',
				'capability_type'=>'post',
				'menu_position'=>2,
				'hierarchical'=>false,  
				'rewrite'=>false,  
				'supports'=>array('title','page-attributes')  
			)
		);	
		
		add_filter('manage_edit-'.PLUGIN_CBS_CONTEXT.'_location_columns',array($this,'manageEditColumn')); 
		add_action('manage_'.PLUGIN_CBS_CONTEXT.'_location_posts_custom_column',array($this,'manageColumn'));
		add_filter('manage_edit-'.PLUGIN_CBS_CONTEXT.'_location_sortable_columns',array($this,'manageEditSortableColumn'));
		add_filter('postbox_classes_'.PLUGIN_CBS_CONTEXT.'_location_cbs_meta_box_location',array($this,'adminCreateMetaBoxClass'));

		add_action('add_meta_boxes_'.PLUGIN_CBS_CONTEXT.'_location',array($this,'addMetaBox'));
		add_action('save_post',array($this,'savePost'));
		
		add_shortcode(PLUGIN_CBS_CONTEXT.'_location',array($this,'createLocation'));
	}
	
	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_CBS_CONTEXT.'_meta_box_location',__('General','car-wash-booking-system'),array($this,'addMetaBoxGeneral'),PLUGIN_CBS_CONTEXT.'_location','normal','low');		
	}
		
	/**************************************************************************/
	
	function addMetaBoxGeneral()
	{
		global $post;
		
		$data=array();
		
		$Email=new CBSEmail();
		$TaxRate=new CBSTaxRate();
		$Vehicle=new CBSVehicle();
		$Currency=new CBSCurrency();
		$PaymentStripe=new CBSPaymentStripe();
		
		$data['nonce']=CBSHelper::createNonceField(PLUGIN_CBS_CONTEXT.'_meta_box_location');
		
		$data['meta']=CBSPostMeta::getPostMeta($post);
		
		$data['colorCount']=$this->colorCount;
		
		$data['dictionary']['content_type']=$this->contentType;
		$data['dictionary']['location']=$this->getDictionary();
		$data['dictionary']['currency']=$Currency->getCurrency();
		$data['dictionary']['vehicle']=$Vehicle->getDictionary();
		$data['dictionary']['tax_rate']=$TaxRate->getDictionary();
		$data['dictionary']['secure_connection_type']=$Email->getSecureConnectionType();
		$data['dictionary']['payment_stripe_method']=$PaymentStripe->getPaymentMethod();
		
		$Template=new CBSTemplate($data,PLUGIN_CBS_TEMPLATE_PATH.'admin/meta_box_location.php');
		echo $Template->output();		
	}
	
	/**************************************************************************/
	
	function adminCreateMetaBoxClass($class) 
	{
		array_push($class,'to-postbox-1');
		return($class);
	}
	
	/**************************************************************************/
	/**************************************************************************/
	
	function manageEditColumn($column)
	{
		$column=array
		(  
			'cb'=>'<input type="checkbox"/>',
			'name'=>__('Title','car-wash-booking-system'),
			'address'=>__('Address','car-wash-booking-system')	
		);   
		
		return($column);  
	}  
	
	/**************************************************************************/
	
	function manageEditSortableColumn($column)
	{
		$column['name']='title';
		$column['address']='title';
		
		return($column);
	}
	
	/**************************************************************************/
	
	function manageColumn($column)
	{
		global $post;
		
		switch($column) 
		{
			case 'name':
				
				echo '<strong><a class="row-title" href="'.get_edit_post_link($post->ID).'">'.get_the_title().'</a></strong>'; 
			
			break;
		
			case 'address':
				
				$Validation=new CBSValidation();
				
				$meta=CBSPostMeta::getPostMeta($post);
				
				$html=array_fill(0,7,null);
				
				if($Validation->isNotEmpty($meta['address_name']))
					$html[0].='<b>'.esc_html($meta['address_name']).'</b>';
				
				if($Validation->isNotEmpty($meta['address_street']))
					$html[1].=esc_html($meta['address_street']);
				
				if(($Validation->isNotEmpty($meta['address_postcode'])) && ($Validation->isNotEmpty($meta['address_city'])))
					$html[2].=esc_html($meta['address_postcode'].' '.$meta['address_city']);
					
				if(($Validation->isNotEmpty($meta['address_state'])) && ($Validation->isNotEmpty($meta['address_country'])))
					$html[3].=esc_html($meta['address_state'].' '.$meta['address_country']);				
				
				if($Validation->isNotEmpty($meta['address_phone_number']))
					$html[4].=esc_html__('Phone: ','car-wash-booking-system').esc_html($meta['address_phone_number']);
	
				if($Validation->isNotEmpty($meta['address_fax_number']))
					$html[5].=esc_html__('Fax: ','car-wash-booking-system').esc_html($meta['address_fax_number']);
				
				if($Validation->isNotEmpty($meta['address_email_address']))
					$html[6].=esc_html__('E-mail: ','car-wash-booking-system').'<a href="mailto:'.esc_attr($meta['address_email_address']).'">'.esc_html($meta['address_email_address']).'</a>';
				
				foreach($html as $htmlData)
					echo '<div>'.$htmlData.'</div>';
				
			break;
		}
		
		return($column);
	}
	
	/**************************************************************************/
	/**************************************************************************/

	function getDictionary($attr=array())
	{
		global $post;
		
		$dictionary=array();
		
		$default=array
		(
			'location_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		
		CBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'post_type'=>PLUGIN_CBS_CONTEXT.'_location',
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'orderby'=>array('menu_order'=>'asc','title'=>'asc')
		);
		
		if($attribute['location_id'])
			$argument['p']=$attribute['location_id'];

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
	
	function setPostMetaDefault(&$meta)
	{
		CBSHelper::setDefault($meta,'currency','USD');
		CBSHelper::setDefault($meta,'tax_rate',0);
		CBSHelper::setDefault($meta,'content_type',3);
		CBSHelper::setDefault($meta,'enable_vehicle_type',1);
		CBSHelper::setDefault($meta,'default_vehicle_type',0);
		CBSHelper::setDefault($meta,'slot_number',1);		
		CBSHelper::setDefault($meta,'hour_visible_number',5);
		CBSHelper::setDefault($meta,'service_visible_number',5);
		CBSHelper::setDefault($meta,'reset_form_enable',0);
		CBSHelper::setDefault($meta,'service_description',0);
		CBSHelper::setDefault($meta,'client_address_enable',0);
		CBSHelper::setDefault($meta,'enable_logging',0);
		CBSHelper::setDefault($meta,'enable_coupons',0);
		CBSHelper::setDefault($meta,'woocommerce_enable',0);
		CBSHelper::setDefault($meta,'steps',0);
		CBSHelper::setDefault($meta,'scroll_to_next_step',0);
		CBSHelper::setDefault($meta,'text_1',__('We will confirm your appointment with you by phone or e-mail within 24 hours of receiving your request.','car-wash-booking-system'));
		CBSHelper::setDefault($meta,'service_location',array());		
		CBSHelper::setDefault($meta,'enable_location_step',0);
		CBSHelper::setDefault($meta,'location_display_method','blocks');
		CBSHelper::setDefault($meta,'locations_options',array());
		
		CBSHelper::setDefault($meta,'client_company_name_enable',1);
		CBSHelper::setDefault($meta,'client_address_street_enable',1);
		CBSHelper::setDefault($meta,'client_address_post_code_enable',1);
		CBSHelper::setDefault($meta,'client_address_city_enable',1);
		CBSHelper::setDefault($meta,'client_address_state_enable',1);
		CBSHelper::setDefault($meta,'client_address_country_enable',1);
		CBSHelper::setDefault($meta,'client_message_enable',1);
		CBSHelper::setDefault($meta,'gratuity_enable',0);
		CBSHelper::setDefault($meta,'service_location_enable',0);
		
		/***/
		
		for($i=1;$i<8;$i++)
		{
			if(!isset($meta['business_hour'][$i]))
			{
				$meta['business_hour'][$i]['start']=null;
				$meta['business_hour'][$i]['stop']=null;
			}
			
			if(!isset($meta['break_hour'][$i]))
				$meta['break_hour'][$i]=null;
		}	
		
		if(!array_key_exists('date_exclude',$meta))
			$meta['date_exclude']=array();
		
		CBSHelper::setDefault($meta,'booking_time_format','24');
		CBSHelper::setDefault($meta,'booking_date_format','');
		CBSHelper::setDefault($meta,'booking_time_interval','30');
		CBSHelper::setDefault($meta,'booking_day_count','21');
		CBSHelper::setDefault($meta,'calendar_navigation_advance_period','1');
		CBSHelper::setDefault($meta,'calendar_month_navigation',0);
		
		/***/
		
		CBSHelper::setDefault($meta,'sender_name','');
		CBSHelper::setDefault($meta,'sender_email','');
		CBSHelper::setDefault($meta,'sender_smtp_enable','0');
		CBSHelper::setDefault($meta,'sender_smtp_username','');
		CBSHelper::setDefault($meta,'sender_smtp_password','');
		CBSHelper::setDefault($meta,'sender_smtp_host','');
		CBSHelper::setDefault($meta,'sender_smtp_port','');
		CBSHelper::setDefault($meta,'sender_smtp_secure_connection_type','ssl');
		CBSHelper::setDefault($meta,'smtp_debug_enable',0);
		
		CBSHelper::setDefault($meta,'recipient_email','');
		
		CBSHelper::setDefault($meta,'nexmo_sms_enable',0);
		CBSHelper::setDefault($meta,'nexmo_sms_api_key','');
		CBSHelper::setDefault($meta,'nexmo_sms_api_key_secret','');
		CBSHelper::setDefault($meta,'nexmo_sms_sender_name','');
		CBSHelper::setDefault($meta,'nexmo_sms_recipient_phone_number','');
		CBSHelper::setDefault($meta,'nexmo_sms_message',__('New booking is received.','car-wash-booking-system'));
		
		CBSHelper::setDefault($meta,'twilio_sms_enable',0);
		CBSHelper::setDefault($meta,'twilio_sms_api_sid','');
		CBSHelper::setDefault($meta,'twilio_sms_api_token','');
		CBSHelper::setDefault($meta,'twilio_sms_sender_phone_number','');
		CBSHelper::setDefault($meta,'twilio_sms_recipient_phone_number','');
		CBSHelper::setDefault($meta,'twilio_sms_message',__('New booking is received.','car-wash-booking-system'));
		
		/***/
		
		CBSHelper::setDefault($meta,'address_name','');
		CBSHelper::setDefault($meta,'address_street','');
		CBSHelper::setDefault($meta,'address_postcode','');
		CBSHelper::setDefault($meta,'address_city','');
		CBSHelper::setDefault($meta,'address_state','');
		CBSHelper::setDefault($meta,'address_country','');
		CBSHelper::setDefault($meta,'address_phone_number','');
		CBSHelper::setDefault($meta,'address_fax_number','');
		CBSHelper::setDefault($meta,'address_email_address','');
		
		CBSHelper::setDefault($meta,'coordinate_latitude','');
		CBSHelper::setDefault($meta,'coordinate_longitude','');		
		
		/***/
		
		CBSHelper::setDefault($meta,'payment_selection_method','after-booking');
		CBSHelper::setDefault($meta,'payment_selection_required','0');
		
		CBSHelper::setDefault($meta,'payment_cash_enable',1);
		CBSHelper::setDefault($meta,'payment_cash_info','');
		CBSHelper::setDefault($meta,'payment_cash_thank_you_page_url_address','');

		CBSHelper::setDefault($meta,'payment_stripe_enable',0);
		CBSHelper::setDefault($meta,'payment_stripe_api_key_secret','');
		CBSHelper::setDefault($meta,'payment_stripe_api_key_publishable','');
		CBSHelper::setDefault($meta,'payment_stripe_method',array('card'));
		CBSHelper::setDefault($meta,'payment_stripe_product_id','');
		CBSHelper::setDefault($meta,'payment_stripe_success_url_address','');
		CBSHelper::setDefault($meta,'payment_stripe_cancel_url_address','');
		CBSHelper::setDefault($meta,'payment_stripe_info','');
		
		CBSHelper::setDefault($meta,'payment_paypal_enable',0);
		CBSHelper::setDefault($meta,'payment_paypal_email_address','');
		CBSHelper::setDefault($meta,'payment_paypal_success_url_address','');
		CBSHelper::setDefault($meta,'payment_paypal_cancel_url_address','');
		CBSHelper::setDefault($meta,'payment_paypal_sandbox_mode_enable',0);
		CBSHelper::setDefault($meta,'payment_paypal_info','');
		
		CBSHelper::setDefault($meta,'google_calendar_id','');		
		
		/***/

		for($i=1;$i<=$this->colorCount;$i++)
		{
			if(!isset($meta['color'][$i]))
				$meta['color'][$i]=null;
		}

		/***/
	}	
	
	/**************************************************************************/
	/**************************************************************************/
	
	function savePost($postId)
	{
		if(!$_POST) return(false);
		
		if(CBSHelper::checkSavePost($postId,PLUGIN_CBS_CONTEXT.'_meta_box_location_noncename','savePost')===false) return(false);
	
		$meta=array();
		
		$Date=new CBSDate();
		$Email=new CBSEmail();
		$Vehicle=new CBSVehicle();
		$TaxRate=new CBSTaxRate();
		$Currency=new CBSCurrency();
		$Validation=new CBSValidation();
		$PaymentStripe=new CBSPaymentStripe();
		
		$this->setPostMetaDefault($meta);
		
		/***/
		/***/
		
		if(array_key_exists(CBSHelper::getPostValue('currency'),$Currency->getCurrency()))
			$meta['currency']=CBSHelper::getPostValue('currency');		
		if((CBSHelper::getPostValue('tax_rate')==0) || (array_key_exists(CBSHelper::getPostValue('tax_rate'),$TaxRate->getDictionary())))
			$meta['tax_rate']=CBSHelper::getPostValue('tax_rate');
		if(array_key_exists(CBSHelper::getPostValue('content_type'),$this->contentType))
			$meta['content_type']=CBSHelper::getPostValue('content_type');		
		if($Validation->isBool(CBSHelper::getPostValue('enable_vehicle_type')))
			$meta['enable_vehicle_type']=CBSHelper::getPostValue('enable_vehicle_type');
		if((CBSHelper::getPostValue('default_vehicle_type')==0) || (array_key_exists(CBSHelper::getPostValue('default_vehicle_type'),$Vehicle->getDictionary())))
			$meta['default_vehicle_type']=CBSHelper::getPostValue('default_vehicle_type');		
		if($Validation->isNumber(CBSHelper::getPostValue('slot_number'),1,999))
			$meta['slot_number']=CBSHelper::getPostValue('slot_number');	   
		if($Validation->isNumber(CBSHelper::getPostValue('hour_visible_number'),0,999))
			$meta['hour_visible_number']=CBSHelper::getPostValue('hour_visible_number'); 
		if($Validation->isNumber(CBSHelper::getPostValue('service_visible_number'),0,999))
			$meta['service_visible_number']=CBSHelper::getPostValue('service_visible_number');
		if($Validation->isBool(CBSHelper::getPostValue('reset_form_enable')))
			$meta['reset_form_enable']=CBSHelper::getPostValue('reset_form_enable');	   
		if($Validation->isBool(CBSHelper::getPostValue('service_description')))
			$meta['service_description']=CBSHelper::getPostValue('service_description');
		if($Validation->isBool(CBSHelper::getPostValue('client_address_enable')))
			$meta['client_address_enable']=CBSHelper::getPostValue('client_address_enable');		
		if($Validation->isBool(CBSHelper::getPostValue('enable_logging')))
			$meta['enable_logging']=CBSHelper::getPostValue('enable_logging');
		if($Validation->isBool(CBSHelper::getPostValue('enable_coupons')))
			$meta['enable_coupons']=CBSHelper::getPostValue('enable_coupons');
		if($Validation->isBool(CBSHelper::getPostValue('woocommerce_enable')))
			$meta['woocommerce_enable']=CBSHelper::getPostValue('woocommerce_enable');		
		if($Validation->isBool(CBSHelper::getPostValue('steps')))
			$meta['steps']=CBSHelper::getPostValue('steps');		
		if($Validation->isBool(CBSHelper::getPostValue('scroll_to_next_step')))
			$meta['scroll_to_next_step']=CBSHelper::getPostValue('scroll_to_next_step');		
		
		$meta['text_1']=CBSHelper::getPostValue('text_1');
				   
		$meta['service_location']=array();
		$serviceLocation=array_map('trim',preg_split('/\R/',CBSHelper::getPostValue('service_location')));
		for($i=0,$count=count($serviceLocation);$i<$count;$i++)
		{
			if($Validation->isNotEmpty($serviceLocation[$i]))
				$meta['service_location'][]=$serviceLocation[$i];
		}

		if($Validation->isBool(CBSHelper::getPostValue('enable_location_step')))
			$meta['enable_location_step']=CBSHelper::getPostValue('enable_location_step');		
		if($Validation->isNotEmpty(CBSHelper::getPostValue('location_display_method')))
			$meta['location_display_method']=CBSHelper::getPostValue('location_display_method');
		
		if(is_array(CBSHelper::getPostValue('locations_options')))
		{
			if(count(CBSHelper::getPostValue('locations_options')))
				$meta['locations_options']=CBSHelper::getPostValue('locations_options');
		}
		
		if($Validation->isBool(CBSHelper::getPostValue('client_company_name_enable')))
			$meta['client_company_name_enable']=CBSHelper::getPostValue('client_company_name_enable');
		if($Validation->isBool(CBSHelper::getPostValue('client_address_street_enable')))
			$meta['client_address_street_enable']=CBSHelper::getPostValue('client_address_street_enable');
		if($Validation->isBool(CBSHelper::getPostValue('client_address_post_code_enable')))
			$meta['client_address_post_code_enable']=CBSHelper::getPostValue('client_address_post_code_enable');
		if($Validation->isBool(CBSHelper::getPostValue('client_address_city_enable')))
			$meta['client_address_city_enable']=CBSHelper::getPostValue('client_address_city_enable');
		if($Validation->isBool(CBSHelper::getPostValue('client_address_state_enable')))
			$meta['client_address_state_enable']=CBSHelper::getPostValue('client_address_state_enable');
		if($Validation->isBool(CBSHelper::getPostValue('client_address_country_enable')))
			$meta['client_address_country_enable']=CBSHelper::getPostValue('client_address_country_enable');
		if($Validation->isBool(CBSHelper::getPostValue('client_message_enable')))
			$meta['client_message_enable']=CBSHelper::getPostValue('client_message_enable');
		if($Validation->isBool(CBSHelper::getPostValue('gratuity_enable')))
			$meta['gratuity_enable']=CBSHelper::getPostValue('gratuity_enable');
		if($Validation->isBool(CBSHelper::getPostValue('service_location_enable')))
			$meta['service_location_enable']=CBSHelper::getPostValue('service_location_enable');
		
		$meta['form_agreement']=array();
		$formElementAgreementPost=CBSHelper::getPostValue('form_agreement');		
		
		if(isset($formElementAgreementPost['id']))
		{
			foreach($formElementAgreementPost['id'] as $index=>$value)
			{
				if(!isset($formElementAgreementPost['text'][$index])) continue;
				if($Validation->isEmpty($formElementAgreementPost['text'][$index])) continue;
				
				if($Validation->isEmpty($value))
					$value=CBSHelper::createId();
				
				$meta['form_agreement'][]=array('id'=>$value,'text'=>$formElementAgreementPost['text'][$index]);
			}
		}
		
		/***/
		/***/
		
		$breakHour=array();
		$businessHour=array();
		foreach($Date->day as $dayIndex=>$dayData)
		{
			$breakHour[$dayIndex]=array();
			$businessHour[$dayIndex]=array('start'=>null,'stop'=>null);
			
			if(($Validation->isTime(CBSHelper::getPostValue('business_hour_'.$dayIndex.'_start'),false)) && ($Validation->isTime(CBSHelper::getPostValue('business_hour_'.$dayIndex.'_stop'),false)))
			{
				$result=$Date->compareTime(CBSHelper::getPostValue('business_hour_'.$dayIndex.'_start'),CBSHelper::getPostValue('business_hour_'.$dayIndex.'_stop'));
				
				if($result==2)
				{
					$businessHour[$dayIndex]['start']=CBSHelper::getPostValue('business_hour_'.$dayIndex.'_start');
					$businessHour[$dayIndex]['stop']=CBSHelper::getPostValue('business_hour_'.$dayIndex.'_stop');
				}
			}
			
			if($Validation->isNotEmpty(CBSHelper::getPostValue('break_hour_'.$dayIndex)))
			{
				$breakHourList=explode(';',CBSHelper::getPostValue('break_hour_'.$dayIndex));
				
				foreach($breakHourList as $breakHourListData)
				{
					list($startTime,$stopTime)=explode('-',$breakHourListData);
					
					$result=$Date->compareTime($startTime,$stopTime);
					if($result==2)
						$breakHour[$dayIndex][]=array('start'=>$startTime,'stop'=>$stopTime);
				}
			}
		}
		
		$meta['break_hour']=$breakHour;
		$meta['business_hour']=$businessHour;
		
		/***/

		$dateExclude=array();
		$dateExcludePost=array();
		
		if((array_key_exists(PLUGIN_CBS_CONTEXT.'_date_exclude_start',$_POST)) && (array_key_exists(PLUGIN_CBS_CONTEXT.'_date_exclude_stop',$_POST)))
		{
			$dStart=CBSHelper::getPostValue('date_exclude_start');
			$dStop=CBSHelper::getPostValue('date_exclude_stop');
			
			$tStart=CBSHelper::getPostValue('time_exclude_start');
			$tStop=CBSHelper::getPostValue('time_exclude_stop');			
			
			foreach($dStart as $dStartIndex=>$dStartValue)
			{
				$dateExcludePost[$dStartIndex]['start']=$dStartValue;
				$dateExcludePost[$dStartIndex]['stop']=isset($dStop[$dStartIndex]) ? $dStop[$dStartIndex] : null;
				
				$dateExcludePost[$dStartIndex]['time_start']=isset($tStart[$dStartIndex]) ? $tStart[$dStartIndex] : null;
				$dateExcludePost[$dStartIndex]['time_stop']=isset($tStop[$dStartIndex]) ? $tStop[$dStartIndex] : null;
			}
		}

		foreach($dateExcludePost as $dateExcludePostIndex=>$dateExcludePostValue)
		{
			$dateStart=$dateExcludePostValue['start'];
			$dateStop=$dateExcludePostValue['stop'];

			$timeStart=$dateExcludePostValue['time_start'];
			$timeStop=$dateExcludePostValue['time_stop'];			
			
			if((!$Validation->isDate($dateStart)) && (!$Validation->isDate($dateStop))) continue;

			if(!$Validation->isDate($dateStart)) continue;
			if(!$Validation->isDate($dateStop)) continue;
			
			if($Validation->isEmpty($timeStart)) $timeStart='00:00';
			if($Validation->isEmpty($timeStop)) $timeStop='23:59';
			
			if(!$Validation->isTime($timeStart)) continue;
			if(!$Validation->isTime($timeStop)) continue;			

			if($Date->compareDate($dateStart.' '.$timeStart,$dateStop.' '.$timeStop)==1) continue;
			if($Date->compareDate(date_i18n('d-m-Y H:i'),$dateStop.' '.$timeStop)==1) continue;
			
			$dateExclude[]=array('start'=>$Date->reverse($dateStart),'stop'=>$Date->reverse($dateStop),'time_start'=>$timeStart,'time_stop'=>$timeStop);
		}
		$meta['date_exclude']=$dateExclude;
		
		if(array_key_exists(CBSHelper::getPostValue('booking_time_format'),$Date->timeFormat))
			$meta['booking_time_format']=CBSHelper::getPostValue('booking_time_format');	
		$meta['booking_date_format']=CBSHelper::getPostValue('booking_date_format');	 
		if($Validation->isNumber(CBSHelper::getPostValue('booking_time_interval'),1,999))
			$meta['booking_time_interval']=CBSHelper::getPostValue('booking_time_interval');		
		if($Validation->isNumber(CBSHelper::getPostValue('booking_day_count'),1,999))
			$meta['booking_day_count']=CBSHelper::getPostValue('booking_day_count');
		if($Validation->isNumber(CBSHelper::getPostValue('calendar_navigation_advance_period'),1,999))
			$meta['calendar_navigation_advance_period']=CBSHelper::getPostValue('calendar_navigation_advance_period');
		if($Validation->isBool(CBSHelper::getPostValue('calendar_month_navigation')))
			$meta['calendar_month_navigation']=CBSHelper::getPostValue('calendar_month_navigation');

		/***/
		/***/

		$meta['sender_name']=CBSHelper::getPostValue('sender_name');
		$meta['sender_email']=CBSHelper::getPostValue('sender_email');
		$meta['sender_smtp_username']=CBSHelper::getPostValue('sender_smtp_username');
		$meta['sender_smtp_password']=CBSHelper::getPostValue('sender_smtp_password');
		$meta['sender_smtp_host']=CBSHelper::getPostValue('sender_smtp_host');
		$meta['sender_smtp_port']=CBSHelper::getPostValue('sender_smtp_port');
		
		if($Validation->isBool(CBSHelper::getPostValue('sender_smtp_enable')))
			$meta['sender_smtp_enable']=CBSHelper::getPostValue('sender_smtp_enable');
		if(array_key_exists(CBSHelper::getPostValue('sender_smtp_secure_connection_type'),$Email->getSecureConnectionType()))
			$meta['sender_smtp_secure_connection_type']=CBSHelper::getPostValue('sender_smtp_secure_connection_type');
		if($Validation->isBool(CBSHelper::getPostValue('smtp_debug_enable')))
			$meta['smtp_debug_enable']=CBSHelper::getPostValue('smtp_debug_enable');
		
		$recipient=preg_split('/;/',CBSHelper::getPostValue('recipient_email'));
		foreach($recipient as $recipientData)
		{
			if($Validation->isEmailAddress($recipientData))
				$meta['recipient_email'].=$recipientData.';';
		}
		
		/***/
		
		$meta['nexmo_sms_enable']=CBSHelper::getPostValue('nexmo_sms_enable');
		if(!$Validation->isBool($meta['nexmo_sms_enable']))
			$meta['nexmo_sms_enable']=0;
		
		$meta['nexmo_sms_api_key']=CBSHelper::getPostValue('nexmo_sms_api_key');
		$meta['nexmo_sms_api_key_secret']=CBSHelper::getPostValue('nexmo_sms_api_key_secret');
		
		$meta['nexmo_sms_sender_name']=CBSHelper::getPostValue('nexmo_sms_sender_name');
		$meta['nexmo_sms_recipient_phone_number']=CBSHelper::getPostValue('nexmo_sms_recipient_phone_number');
		
		$meta['nexmo_sms_message']=CBSHelper::getPostValue('nexmo_sms_message');
		
		/***/
		
		$meta['twilio_sms_enable']=CBSHelper::getPostValue('twilio_sms_enable');
		if(!$Validation->isBool($meta['twilio_sms_enable']))
			$meta['twilio_sms_enable']=0;
		
		$meta['twilio_sms_api_sid']=CBSHelper::getPostValue('twilio_sms_api_sid');
		$meta['twilio_sms_api_token']=CBSHelper::getPostValue('twilio_sms_api_token');
		
		$meta['twilio_sms_sender_phone_number']=CBSHelper::getPostValue('twilio_sms_sender_phone_number');
		$meta['twilio_sms_recipient_phone_number']=CBSHelper::getPostValue('twilio_sms_recipient_phone_number');
		
		$meta['twilio_sms_message']=CBSHelper::getPostValue('twilio_sms_message');
		
		/***/
		/***/		
		
		$meta['address_name']=CBSHelper::getPostValue('address_name');
		$meta['address_street']=CBSHelper::getPostValue('address_street');
		$meta['address_postcode']=CBSHelper::getPostValue('address_postcode');
		$meta['address_city']=CBSHelper::getPostValue('address_city');
		$meta['address_state']=CBSHelper::getPostValue('address_state');
		$meta['address_country']=CBSHelper::getPostValue('address_country');
		$meta['address_phone_number']=CBSHelper::getPostValue('address_phone_number');
		$meta['address_fax_number']=CBSHelper::getPostValue('address_fax_number');
		$meta['address_email_address']=CBSHelper::getPostValue('address_email_address');
		
		$meta['coordinate_latitude']=CBSHelper::getPostValue('coordinate_latitude');
		$meta['coordinate_longitude']=CBSHelper::getPostValue('coordinate_longitude');
		
		/***/
		/***/
		
		if($Validation->isNotEmpty(CBSHelper::getPostValue('payment_selection_method')))
			$meta['payment_selection_method']=CBSHelper::getPostValue('payment_selection_method');
		if($Validation->isBool(CBSHelper::getPostValue('payment_selection_required')))
			$meta['payment_selection_required']=CBSHelper::getPostValue('payment_selection_required');
		
		/***/
		
		if($Validation->isBool(CBSHelper::getPostValue('payment_cash_enable')))
			$meta['payment_cash_enable']=CBSHelper::getPostValue('payment_cash_enable');
		$meta['payment_cash_info']=CBSHelper::getPostValue('payment_cash_info');
		$meta['payment_cash_thank_you_page_url_address']=CBSHelper::getPostValue('payment_cash_thank_you_page_url_address');
		
		/***/
			
		if($Validation->isBool(CBSHelper::getPostValue('payment_stripe_enable')))
			$meta['payment_stripe_enable']=CBSHelper::getPostValue('payment_stripe_enable');

		$meta['payment_stripe_api_key_secret']=CBSHelper::getPostValue('payment_stripe_api_key_secret');
		$meta['payment_stripe_api_key_publishable']=CBSHelper::getPostValue('payment_stripe_api_key_publishable');		
		
		$method=CBSHelper::getPostValue('payment_stripe_method');
		if(is_array($method))
		{
			foreach($method as $index=>$value)
			{
				if(!$PaymentStripe->isPaymentMethod($value))
					unset($method[$index]);
			}
		}
			
		if((!is_array($method)) || (!count($method)))
			$method=array('card');
		
		$meta['payment_stripe_method']=$method;
		
		$meta['payment_stripe_product_id']=CBSHelper::getPostValue('payment_stripe_product_id');
		$meta['payment_stripe_success_url_address']=CBSHelper::getPostValue('payment_stripe_success_url_address');
		$meta['payment_stripe_cancel_url_address']=CBSHelper::getPostValue('payment_stripe_cancel_url_address');
		$meta['payment_stripe_info']=CBSHelper::getPostValue('payment_stripe_info');
		
		/***/
		
		if($Validation->isBool(CBSHelper::getPostValue('payment_paypal_enable')))
			$meta['payment_paypal_enable']=CBSHelper::getPostValue('payment_paypal_enable');
		
		$meta['payment_paypal_email_address']=CBSHelper::getPostValue('payment_paypal_email_address');
		
		if($Validation->isBool(CBSHelper::getPostValue('payment_paypal_sandbox_mode_enable')))
			$meta['payment_paypal_sandbox_mode_enable']=CBSHelper::getPostValue('payment_paypal_sandbox_mode_enable');	
		
		$meta['payment_paypal_success_url_address']=CBSHelper::getPostValue('payment_paypal_success_url_address');
		$meta['payment_paypal_cancel_url_address']=CBSHelper::getPostValue('payment_paypal_cancel_url_address');
		$meta['payment_paypal_info']=CBSHelper::getPostValue('payment_paypal_info');
		
		/***/
		
		if($Validation->isNotEmpty(CBSHelper::getPostValue('google_calendar_id')))
			$meta['google_calendar_id']=CBSHelper::getPostValue('google_calendar_id');
		
		/***/
		/***/
		
		$color=array_fill(1,$this->colorCount,null);
		foreach($color as $colorIndex=>$colorData)
		{
			if($Validation->isColor(CBSHelper::getPostValue('color_'.$colorIndex)))
				$color[$colorIndex]=CBSHelper::getPostValue('color_'.$colorIndex);
		}
		$meta['color']=$color;
		
		/***/

		foreach($meta as $metaIndex=>$metaData)
			CBSPostMeta::updatePostMeta($postId,$metaIndex,$metaData);
		
		/***/
		
		$this->createCSSFile($postId);
	}
	
	/**************************************************************************/
	/**************************************************************************/
	
	function createLocation($attr)
	{
		$html=null;
		
		$default=array
		(
			'location_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		
		/***/
		
		$location=$this->getDictionary($attribute);
		if(count($location)!=1) return($html);
		
		$locationId=(int)$attribute['location_id'];
		
		if($location[$locationId]['meta']['enable_vehicle_type']==0 && $location[$locationId]['meta']['default_vehicle_type'])
		{
			$attribute['vehicle_id']=$location[$locationId]['meta']['default_vehicle_type'];
		}
		
		/***/
		
		$action=CBSHelper::getGetValue('action',false);
		if($action==='ipn')
		{
			$PaymentPaypal=new CBSPaymentPaypal();
			$PaymentPaypal->handleIPN();
		}

		/***/
		
		$stripeForm=CBSHelper::getPostValue('stripeForm',false);
		if($stripeForm=="show")
		{
			$Booking=new CBSBooking();
			$bookingId=CBSHelper::getPostValue('bookingId',false);			
			$html=
			'
				'.$Booking->createStripeForm($bookingId,false).'
				<script type="text/javascript">
					jQuery(function($) {
						$("#cbs-stripe-form button.stripe-button-el")[0].click();
					})
				</script>
			';
			return($html);
		}
		
		/***/

		$package=array();
		$service=array();
		
		$User=new CBSUser();
		$Package=new CBSPackage();
		$Service=new CBSService();
		$Vehicle=new CBSVehicle();
		
		if(in_array($location[$locationId]['meta']['content_type'],array(1,3)))
			$service=$Service->getServicePublic($attribute);
		if(in_array($location[$locationId]['meta']['content_type'],array(2,3)))
			$package=$Package->getPackagePublic($attribute);			
		
		$vehicle=$Vehicle->getVehiclePublic($attribute,$service,$package);
		
		/***/
		
		$data=array();
		
		if($location[$locationId]['meta']['content_type']==1)
			$data['stepCount']=3;
		else
			$data['stepCount']=4;
		if($location[$locationId]['meta']['enable_location_step'])
			$data['stepCount']++;
		if($location[$locationId]['meta']['enable_vehicle_type'])
			$data['stepCount']++;
		
		$Currency=new CBSCurrency();
		
		$data['id']=CBSHelper::createId('cbs');
		
		$data['locationId']=$attribute['location_id'];
		$data['locationMeta']=$location[$locationId]['meta'];
		
		if(array_key_exists('form_agreement',$location[$locationId]['meta']))
			$data['form_agreement']=$location[$locationId]['meta']['form_agreement'];
		else
			$data['form_agreement']=array();
		
		$data['location']=$this->getDictionary();
		$data['vehicle']=$vehicle;
		
		if(in_array($location[$locationId]['meta']['content_type'],array(2,3)))
		{
			if($location[$locationId]['meta']['default_vehicle_type'])
			{
				$package=$Package->getPackagePublic(array('location_id'=>$attribute['location_id'],'vehicle_id'=>$location[$locationId]['meta']['default_vehicle_type']));
				if(count($package))
				{
					$data['vehicleSelected']=$location[$locationId]['meta']['default_vehicle_type'];
					$data['package']=$package;
				}
			}
			else
			{
				foreach($vehicle as $vehicleIndex=>$vehicleData)
				{
					$package=$Package->getPackagePublic(array('location_id'=>$attribute['location_id'],'vehicle_id'=>$vehicleIndex));
					if(count($package))
					{
						$data['vehicleSelected']=$vehicleIndex;
						$data['package']=$package;
						break;
					}
				}
			}
		}
		else 
		{
			reset($vehicle);
			$data['vehicleSelected']=key($vehicle);
			$data['package']=$package;			
		}
		
		if(in_array($location[$locationId]['meta']['content_type'],array(1,3)))
		{
			if($location[$locationId]['meta']['default_vehicle_type'])
				$data['service']=$Service->getServicePublic(array('location_id'=>$attribute['location_id'],'vehicle_id'=>$location[$locationId]['meta']['default_vehicle_type']));
			else
				$data['service']=$Service->getServicePublic(array('location_id'=>$attribute['location_id'],'vehicle_id'=>$data['vehicleSelected']));
		}
		else
		{
			$data['service']=$service;
		}
		
		if(!$data['package'] && !$data['service'])
			return;
		
		$data['calendar']=$this->getDate($attribute['location_id']);
		
		$data['currencyId']=$location[$locationId]['meta']['currency'];
		$data['currencySymbol']=$Currency->getSymbol($location[$locationId]['meta']['currency']);
		$data['currencySymbolPosition']=$Currency->getSymbolPosition($location[$locationId]['meta']['currency']);
		$data['currencySeparator']=$Currency->getSeparator($location[$locationId]['meta']['currency']);
		
		$data['serviceVisibleNumber']=$location[$locationId]['meta']['service_visible_number'];
		$data['serviceDescription']=$location[$locationId]['meta']['service_description'];
		$data['hourVisibleNumber']=$location[$locationId]['meta']['hour_visible_number'];
		$data['calendarNavigationAdvancePeriod']=$location[$locationId]['meta']['calendar_navigation_advance_period'];
		$data['calendarMonthNavigation']=$location[$locationId]['meta']['calendar_month_navigation'];
		
		$data['contentType']=$location[$locationId]['meta']['content_type'];
		
		$data['text_1']=$location[$locationId]['meta']['text_1'];
		$data['client_address_enable']=$location[$locationId]['meta']['client_address_enable'];
		$data['enable_logging']=(int)$location[$locationId]['meta']['enable_logging'];
		$data['enable_coupons']=(int)$location[$locationId]['meta']['enable_coupons'];
		$data['client_company_name_enable']=(int)$location[$locationId]['meta']['client_company_name_enable'];
		$data['client_address_street_enable']=(int)$location[$locationId]['meta']['client_address_street_enable'];
		$data['client_address_post_code_enable']=(int)$location[$locationId]['meta']['client_address_post_code_enable'];
		$data['client_address_city_enable']=(int)$location[$locationId]['meta']['client_address_city_enable'];
		$data['client_address_state_enable']=(int)$location[$locationId]['meta']['client_address_state_enable'];
		$data['client_address_country_enable']=(int)$location[$locationId]['meta']['client_address_country_enable'];
		$data['client_message_enable']=(int)$location[$locationId]['meta']['client_message_enable'];
		$data['gratuity_enable']=(int)$location[$locationId]['meta']['gratuity_enable'];
		$data['service_location_enable']=(int)$location[$locationId]['meta']['service_location_enable'];
		$data['service_location']=$location[$locationId]['meta']['service_location'];
		$data['user_contact_data']=($location[$locationId]['meta']['enable_logging'] ? $User->getUserContactData() : $User->getUserContactDataEmpty());
		$data['stripe_enabled']=$this->isPaymentAvailable($locationId,'stripe');
		$data['payment_type']=$this->getAvailablePaymentMethods($locationId,$location);
		
		$Template=new CBSTemplate($data,PLUGIN_CBS_TEMPLATE_PATH.'public/public.php');
		return($Template->output());
	}
	
	/**************************************************************************/
	
	function createPackage()
	{
		$vehicleId=(int)CBSHelper::getPostValue('vehicleId',false);
		$locationId=(int)CBSHelper::getPostValue('locationId',false);
		$packageId=(int)CBSHelper::getPostValue('packageId',false);
		
		$Vehicle=new CBSVehicle();
		$Package=new CBSPackage();
		$Service=new CBSService();
		
		$Currency=new CBSCurrency();
		$Template=new CBSTemplatePublic();
		
		$package=array();
		$service=array();
		
		$response=array
		(
			'error'=>0,
			'package'=>$Template->output('package-list',array('package'=>$package),false),
			'service'=>$Template->output('service-list',array('service'=>$service),false)
		);		
		
		$attribute=array
		(
			'location_id'=>$locationId,
			'vehicle_id'=>$vehicleId,
			'package_id'=>$packageId
		);	
		
		$location=$this->getDictionary($attribute);
		if(count($location)!=1) 
			CBSHelper::createJSONResponse($response);
		
		$vehicle=$Vehicle->getDictionary($attribute);
		if(count($vehicle)!=1) 
			CBSHelper::createJSONResponse($response);		
		
		$package=$Package->getPackagePublic($attribute);
		
		$service=array();
		if(in_array((int)$location[$locationId]['meta']['content_type'],array(1,3))) 
			$service=$Service->getServicePublic($attribute);
			
		$currencySymbol=$Currency->getSymbol($location[$locationId]['meta']['currency']);
		$currencySymbolPosition=$Currency->getSymbolPosition($location[$locationId]['meta']['currency']);
		
		$currencySeparator=$Currency->getSeparator($location[$locationId]['meta']['currency']);

		$response['serviceCount']=count($service);
		$response['service']=$Template->output('service-list',array
		(
			'service'=>$service,
			'currencySymbol'=>$currencySymbol,
			'currencySymbolPosition'=>$currencySymbolPosition,
			'currencySeparator'=>$currencySeparator,
			'currencyId'=>$location[$locationId]['meta']['currency'],
			'serviceVisibleNumber'=>$location[$attribute['location_id']]['meta']['service_visible_number'],
			'serviceDescription'=>$location[$attribute['location_id']]['meta']['service_description']
		),false);
		
		$response['packageCount']=count($package);
		$response['package']=$Template->output('package-list',array
		(
			'package'=>$package,
			'packageButtonURL'=>CBSHelper::getPostValue('packageButtonURL',false),
			'currencySymbol'=>$currencySymbol,
			'currencySymbolPosition'=>$currencySymbolPosition,
			'currencySeparator'=>$currencySeparator
		),false);
		
		CBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
	
	function createService()
	{
		$vehicleId=(int)CBSHelper::getPostValue('vehicleId',false);
		$packageId=(int)CBSHelper::getPostValue('packageId',false);
		$locationId=(int)CBSHelper::getPostValue('locationId',false);
		$couponCode=CBSHelper::getPostValue('couponCode',false);
		
		$service=array();
		
		$Vehicle=new CBSVehicle();
		$Service=new CBSService();
		$Package=new CBSPackage();
		
		$Currency=new CBSCurrency();
		$Template=new CBSTemplatePublic();
		
		$response=array
		(
			'error'=>0,
			'service'=>$Template->output('service-list',array('service'=>$service),false)
		);
		
		$attribute=array
		(
			'location_id'=>$locationId,
			'vehicle_id'=>$vehicleId,
			'package_id'=>$packageId,
			'coupon_code'=>$couponCode
		);	
		
		$location=$this->getDictionary($attribute);
		if(count($location)!=1) 
			CBSHelper::createJSONResponse($response);
		
		$vehicle=$Vehicle->getDictionary($attribute);
		if(count($vehicle)!=1) 
			CBSHelper::createJSONResponse($response);	

		/***/
		
		$getServiceRelated=false;
		if($location[$locationId]['meta']['content_type']==1)
		{
			$service=$Service->getServicePublic($attribute);
		}
		elseif($location[$locationId]['meta']['content_type']==2)
		{
			if($packageId==0) $service=array();
			else $getServiceRelated=true;
		}
		elseif($location[$locationId]['meta']['content_type']==3)
		{
			if($packageId==0) $service=$Service->getServicePublic($attribute);
			else $getServiceRelated=true;
		}
		
		/***/
		
		if($getServiceRelated)
		{
			$package=$Package->getPackagePublic($attribute);
			if(!count($package)) CBSHelper::createJSONResponse($response);

			$servicePackage=$package[$packageId]['service'];
			$cost=$Service->getServiceCost($attribute);	
			
			foreach($servicePackage as $serviceId=>$serviceData)
			{
				if($serviceData['service_type']!=2) continue;
				
				$service[$serviceId]=$serviceData;
				$service[$serviceId]['cost']=isset($cost[$serviceId][$attribute['location_id']][$attribute['vehicle_id']]) ? $cost[$serviceId][$attribute['location_id']][$attribute['vehicle_id']] : array();
			}				
		}	
		
		/***/
		
		$currencySymbol=$Currency->getSymbol($location[$locationId]['meta']['currency']);
		$currencySymbolPosition=$Currency->getSymbolPosition($location[$locationId]['meta']['currency']);
		$currencySeparator=$Currency->getSeparator($location[$locationId]['meta']['currency']);
				
		$response['serviceCount']=count($service);
		
		$response['service']=$Template->output('service-list',array
		(
			'service'=>$service,
			'currencySymbol'=>$currencySymbol,
			'currencySymbolPosition'=>$currencySymbolPosition,
			'currencySeparator'=>$currencySeparator,
			'currencyId'=>$location[$locationId]['meta']['currency'],
			'serviceVisibleNumber'=>$location[$attribute['location_id']]['meta']['service_visible_number'],
			'serviceDescription'=>$location[$attribute['location_id']]['meta']['service_description'],
		),false);

		$response['cost']=$this->calculateCost($attribute);
		
		CBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
	
	function getDate($locationId,$dateStart=false,$duration=0,$checked=false)
	{
		/*mod*/
		$duration=PLUGIN_CBS_CUSTOM_DURATION;
		/*mod*/
		
		$Date=new CBSDate();
		$Booking=new CBSBooking();
		$Validation=new CBSValidation();
		
		$data=array();
		
		$attribute=array
		(
			'location_id'=>$locationId
		);
		
		$location=$this->getDictionary($attribute);
		if(count($location)!=1) return($data);
	
		/***/
		
		/* Set start date to current date if the first isn't set */
		$dateCurrent=date_i18n('d-m-Y');
		if($dateStart===false) $dateStart=$dateCurrent;
		
		/* Set start date to current date if the second is later */
		if($Date->compareDate($dateStart,$dateCurrent)===2)
			$dateStart=$dateCurrent;
		
		/***/
		
		/* Set stop date */
		$dateStop=date_i18n('d-m-Y',strtotime('+'.(int)$location[$locationId]['meta']['booking_day_count'].' day',strtotime($dateCurrent)));

		/* Set a new start date if start date + 6days > stop date */
		$dateLast=date_i18n('d-m-Y',strtotime('+6 day',strtotime($dateStart)));
		if(!$checked)
		{
			if($Date->compareDate($dateLast,$dateStop)==1)
			{
				if($location[$locationId]['meta']['booking_day_count']>=7) 
					$dateStart=date_i18n('d-m-Y',strtotime('-6 day',strtotime($dateStop)));
				else $dateStart=$dateCurrent;
				
				return($this->getDate($locationId,$dateStart,$duration,true));
			}
		}
		
		/* Get date unavailable */
		$dateUnavailable=$Booking->getUnavailableDate($locationId,$dateStart,$dateStop);

		/***/
		
		/* Generate dates */
		for($i=1;$i<8;$i++)
		{
			/* Processed date */
			$dateLoop=date_i18n('d-m-Y',strtotime('+'.($i-1).' day',strtotime($dateStart)));
			
			$data['date'][$i]['date']=array
			(
				'day'=>array
				(
					'number'=>date_i18n('d',strtotime($dateLoop)),
					'name'=>date_i18n('D',strtotime($dateLoop))
				),
				'month'=>array
				(
					'number'=>date_i18n('m',strtotime($dateLoop)),
					'name'=>date_i18n('F',strtotime($dateLoop))
				),
				'year'=>array
				(
					'number'=>date_i18n('Y',strtotime($dateLoop)),
				),
				'full'=>date_i18n($Validation->isEmpty($location[$locationId]['meta']['booking_date_format']) ? 'd-m-Y' : $location[$locationId]['meta']['booking_date_format'],strtotime($dateLoop))
			);
			
			$data['date'][$i]['isToday']=$dateLoop===date_i18n('d-m-Y') ? 1 : 0;

			/* Set time to -1 if processed date is exclude */
			$data['date'][$i]['time']=array();
			
			/* Generate hours */
			if(is_array($data['date'][$i]['time']))
			{
				if(array_key_exists('business_hour',$location[$locationId]['meta']))
				{
					$dayWeekNumber=date_i18n('N',strtotime($dateLoop));
					
					$breakHour=array();
					if((isset($location[$locationId]['meta']['break_hour'])) && (isset($location[$locationId]['meta']['break_hour'][$dayWeekNumber])))
						$breakHour=$location[$locationId]['meta']['break_hour'][$dayWeekNumber];
					
					$businessHour=$location[$locationId]['meta']['business_hour'];

					if(isset($businessHour[$dayWeekNumber],$businessHour[$dayWeekNumber]['start'],$businessHour[$dayWeekNumber]['stop']))
					{
						$j=-1;
						
						/* Start time */
						$timeStart=date_i18n('H:i',strtotime($dateLoop.' '.$businessHour[$dayWeekNumber]['start']));
						
						/* Stop time */
						$timeStop=date_i18n('H:i',strtotime($dateLoop.' '.$businessHour[$dayWeekNumber]['stop']));
						
						while(1)
						{
							$j++;
				
							/* Processed time */
							$timeLoop=date_i18n('H:i',strtotime('+'.($location[$locationId]['meta']['booking_time_interval']*$j).' minutes',strtotime($timeStart)));

							/* Processed time + duration */
							$timeLoopPlusDuration=date_i18n('d-m-Y H:i',strtotime($dateLoop.' '.$timeLoop.' + '.$duration.' minutes',strtotime($timeLoop)));
														
							/* Break hour */
							if(count($breakHour))
							{
								foreach($breakHour as $breakHourData)
								{
									if($Date->checkInRange($dateLoop.' '.$timeLoop,$dateLoop.' '.$breakHourData['start'],$dateLoop.' '.$breakHourData['stop'],true))
									{
										if($breakHourData['stop']!=$timeLoop) continue 2;
									}
									
									$d0=strtotime(date_i18n('d-m-Y H:i',strtotime($dateLoop.' '.$timeLoop)));
									$d1=strtotime($timeLoopPlusDuration);
									$d2=strtotime(date_i18n('d-m-Y H:i',strtotime($dateLoop.' '.$breakHourData['start'])));
									$d3=strtotime(date_i18n('d-m-Y H:i',strtotime($dateLoop.' '.$breakHourData['stop'])));
									
									if($d0<$d3)
									{
										if($d1>$d2 || $d1>$d3) continue 2;
									}
								}
							}
							
							/* If the processed time >= stop time */
							if(in_array($Date->compareTime(date_i18n('H',strtotime($timeLoop)).':'.date_i18n('i',strtotime($timeLoop)),date_i18n('H',strtotime($timeStop)).':'.date_i18n('i',strtotime($timeStop))),array(0,1))) break;

							/* If the processed time < current time in the same day of week */
							if($dateLoop===date_i18n('d-m-Y'))
							{
								if($Date->compareTime($timeLoop,date_i18n('G:i'))===2) continue;
							}
							
							/* If the processed time + duration > close hour */
							$timeBusinessHourStop=date_i18n('d-m-Y H:i',strtotime($dateLoop.' '.$businessHour[$dayWeekNumber]['stop']));
							if(strtotime($timeLoopPlusDuration)>strtotime($timeBusinessHourStop)) break;
	
							/* If the date is unavailable */
							if(!$Booking->isAvailableDate($dateLoop,$timeLoop,(int)$duration<$location[$locationId]['meta']['booking_time_interval'] ? $location[$locationId]['meta']['booking_time_interval'] : $duration,$location[$locationId]['meta']['slot_number'],array($businessHour[$dayWeekNumber]['start'],$businessHour[$dayWeekNumber]['stop']),$dateUnavailable)) continue;
							
							/* Exclude date/time */ 
							if(is_array($location[$locationId]['meta']['date_exclude']))
							{
								foreach($location[$locationId]['meta']['date_exclude'] as $dateExcludeValue)
								{
									$excludeStart=$Date->reverse($dateExcludeValue['start']).' '.(($Validation->isEmpty($dateExcludeValue['time_start'])) ? '00:00' : $dateExcludeValue['time_start']);
									$excludeStop=$Date->reverse($dateExcludeValue['stop']).' '.(($Validation->isEmpty($dateExcludeValue['time_stop'])) ? '23:59' : $dateExcludeValue['time_stop']);
									
									if($Date->checkInRange($dateLoop.' '.$timeLoop,$excludeStart,$excludeStop,true)) continue 2;
								}
							}
							
							/* Format time to 12/24 mode */
							$timeLoopPostfix=null;
							$timeLoopFormat=$timeLoop;
							$Date->formatTime($timeLoopFormat,$timeLoopPostfix,$location[$locationId]['meta']['booking_time_format']);
							
							$data['date'][$i]['time'][]=array
							(
								'hour'=>array
								(
									'number'=>date_i18n('H',strtotime($timeLoopFormat))
								),
								'minute'=>array
								(
									'number'=>date_i18n('i',strtotime($timeLoopFormat))
								),	
								'postfix'=>$timeLoopPostfix,
								'id'=>preg_replace('/-/','',$dateLoop).preg_replace('/:/','',$timeLoop)
							);
						}
					}
				}
			}
			
			if((is_array($data['date'][$i]['time'])) && (!count($data['date'][$i]['time'])))
				$data['date'][$i]['time']=-1;
		}

		/* Generate header */
		$data['header']=null;
		$headerMonth=array();
		foreach($data['date'] as $dateValue)
		{
			if(in_array($dateValue['date']['month']['number'],$headerMonth)) continue;
			
			$headerMonth[]=(int)$dateValue['date']['month']['number'];
			
			if(!$Validation->isEmpty($data['header'])) $data['header'].='<span class="cbs-calendar-month-number-0"> / </span>';
			$data['header'].='<span class="cbs-calendar-month-number-'.$dateValue['date']['month']['number'].'">'.$dateValue['date']['month']['name'].' '.$dateValue['date']['year']['number'].'</span>';
		}

		return($data);
	}
		
	/**************************************************************************/
	
	function calculateCost($attr)
	{			   
		$default=array
		(
			'location_id'=>0,
			'vehicle_id'=>0,
			'package_id'=>0,
			'service_id'=>0,
			'coupon_code'=>'',
			'gratuity'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		
		if(!is_array($attribute['service_id']))
			$attribute['service_id']=preg_split('/\./',$attribute['service_id']);
		
		$location=$this->getDictionary($attribute);
		if(!isset($location[$attribute['location_id']])) return(array());
					
		$price=0;
		$priceNet=0;
		$priceGross=0;
		$priceOld=0;		
		$deduction=0;
		$duration=0;
		
		$Vehicle=new CBSVehicle();
		$Package=new CBSPackage();
		$Service=new CBSService();
		$Coupon=new CBSCoupon();
		$Currency=new CBSCurrency();
		$TaxRate=new CBSTaxRate();
		
		$coupon=$Coupon->getDictionary($attribute);
		$couponId=0;
		$couponActive=0;
		if(count($coupon)===1)
		{
			$couponKeys=array_keys($coupon);
			$couponId=array_shift($couponKeys);
		}
		
		/***/	
		
		$priceVehicleNet=0;
		$priceVehicleGross=0;
		
		$dictionaryVehicle=$Vehicle->getDictionary(array('vehicle_id'=>$attribute['vehicle_id']));
		if(count($dictionaryVehicle)===1)
		{
			$priceVehicleNet=$dictionaryVehicle[$attribute['vehicle_id']]['meta']['initial_fee_value'];
			$priceVehicleGross=$priceVehicleNet;
			
			$taxRateId=$dictionaryVehicle[$attribute['vehicle_id']]['meta']['initial_fee_tax_rate'];
			if((int)$taxRateId>0)
			{
				$dictionaryTaxRate=$TaxRate->getDictionary(array('tax_rate_id'=>$taxRateId));
				if(count($dictionaryTaxRate)===1)
				{
					$priceVehicleGross*=(1+($dictionaryTaxRate[$taxRateId]['meta']['rate']/100));
				}
			}
		}
		
		$price+=$priceVehicleGross;
		$priceNet+=$priceVehicleNet;
				
		/***/
		
		$packageCost=$Package->getPackageCost($attribute,true);
		$serviceCost=$Service->getServiceCost($attribute);
		
		if(isset($packageCost[$attribute['package_id']][$attribute['location_id']][$attribute['vehicle_id']]))
		{
			$price+=$packageCost[$attribute['package_id']][$attribute['location_id']][$attribute['vehicle_id']]['priceReal'];
			$priceNet+=$packageCost[$attribute['package_id']][$attribute['location_id']][$attribute['vehicle_id']]['priceRealNet'];
			$duration=$packageCost[$attribute['package_id']][$attribute['location_id']][$attribute['vehicle_id']]['duration'];
		}

		if(count($serviceCost))
		{
			foreach($attribute['service_id'] as $serviceId)
			{
				if(isset($serviceCost[$serviceId][$attribute['location_id']][$attribute['vehicle_id']]))
				{
					$price+=$serviceCost[$serviceId][$attribute['location_id']][$attribute['vehicle_id']]['price'];
					$priceNet+=$serviceCost[$serviceId][$attribute['location_id']][$attribute['vehicle_id']]['priceNet'];
					$duration+=$serviceCost[$serviceId][$attribute['location_id']][$attribute['vehicle_id']]['duration'];
				}
			}
		}
		
		$priceGross=$price;
		
		if($Coupon->isActive($couponId,$attribute['location_id'],$price))
		{
			$couponActive=1;
			$priceOld=$price;
			$price=round((float)$price*((100-$coupon[$couponId]['meta']['discount'])/100)-(float)$coupon[$couponId]['meta']['deduction'],2);
			
			$deduction=$priceOld-$price;
			if($price<0)
				$price=0;
		}
		
		$Date=new CBSDate();
		$time=$Date->getHourMinute($duration);
		
		$price+=$attribute['gratuity'];
		
		$cost=array
		(
			'price'=>array
			(
				'unit'=>CBSPrice::getUnity($price),
				'decimal'=>CBSPrice::getDecimal($price),
				'separator'=>$Currency->getSeparator($location[$attribute['location_id']]['meta']['currency'])
			),
			'price_net'=>array
			(
				'unit'=>CBSPrice::getUnity($priceNet),
				'decimal'=>CBSPrice::getDecimal($priceNet),
				'separator'=>$Currency->getSeparator($location[$attribute['location_id']]['meta']['currency'])
			),
			'price_gross'=>array
			(
				'unit'=>CBSPrice::getUnity($priceGross),
				'decimal'=>CBSPrice::getDecimal($priceGross),
				'separator'=>$Currency->getSeparator($location[$attribute['location_id']]['meta']['currency'])
			),
			'deduction'=>array
			(
				'unit'=>CBSPrice::getUnity($deduction),
				'decimal'=>CBSPrice::getDecimal($deduction),
				'separator'=>$Currency->getSeparator($location[$attribute['location_id']]['meta']['currency'])
			),
			'duration'=>array
			(
				'hour'=>$time['hour'],
				'minute'=>$time['minute'],
				'minute_sum'=>($time['hour']*60)+$time['minute']
			),
			'duration_unit'=>CBSOption::getOption('duration_unit'),
			'coupon_active'=>$couponActive
		);
		
		/***/
 
		return($cost);
	}
	
	/**************************************************************************/
	
	function createCost()
	{
		$attribute=array
		(
			'location_id'=>CBSHelper::getPostValue('locationId',false),
			'vehicle_id'=>CBSHelper::getPostValue('vehicleId',false),
			'package_id'=>CBSHelper::getPostValue('packageId',false),
			'service_id'=>CBSHelper::getPostValue('serviceId',false),
			'coupon_code'=>CBSHelper::getPostValue('couponCode',false)
		);
		
		$response=array
		(
			'error'=>0,
			'cost'=>$this->calculateCost($attribute)
		);
		
		CBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
	
	function createCSSFile($locationId)
	{
		$location=$this->getDictionary(array('location_id'=>$locationId));
		if(!isset($location[$locationId])) return(false);
		
		/***/
		
		$path=array
		(
			CBSFile::getMultisiteBlog()
		);
		
		foreach($path as $pathData)
		{
			if(!CBSFile::dirExist($pathData)) @mkdir($pathData);			
			if(!CBSFile::dirExist($pathData)) return(false);
		}
		
		/***/
		
		$Validation=new CBSValidation();
		
		$color=$location[$locationId]['meta']['color'];
		for($i=1;$i<=$this->colorCount;$i++)
		{
			if((!isset($color[$i])) || (!$Validation->isColor($color[$i])))
				unset($color[$i]);
		}
		
		if(!count($color))
		{
			@unlink(CBSFile::getMultisiteBlogCSS($locationId));
			return;
		}
		
		for($i=1;$i<=$this->colorCount;$i++)
		{
			if(isset($color[$i]))
			{
				if(!$Validation->isColor($color[$i]))
					$color[$i]=$this->colorDefault[$i];
			}
		}
		
		$data=array();
		
		$data['color']=$color;
		$data['mainCSSClass']='.cbs-main.cbs-location-'.$locationId;

		$Template=new CBSTemplate($data,PLUGIN_CBS_TEMPLATE_PATH.'public/style.php');
		
		file_put_contents(CBSFile::getMultisiteBlogCSS($locationId),$Template->output());
	}
	
	/**************************************************************************/
	
	function createCalendarMonth()
	{
		$Validation=new CBSValidation();
		$Template=new CBSTemplatePublic();
		
		$response=array('error'=>1,'calendar'=>null);
		
		$step=(int)CBSHelper::getPostValue('step',false);
		$startDate=CBSHelper::getPostValue('startDate',false);
		$locationId=(int)CBSHelper::getPostValue('locationId',false);
		
		$location=$this->getDictionary(array('location_id'=>$locationId));
		if(count($location)!=1) 
			CBSHelper::createJSONResponse($response);
		
		if(!$Validation->isNumber($step,-999,999))
			CBSHelper::createJSONResponse($response);

		//always start with a first day of a month
		$startDate='01-'.substr($startDate,2,2).'-'.substr($startDate,4,4);
		if(!$Validation->isDate($startDate))
			CBSHelper::createJSONResponse($response);
		
		$cost=$this->calculateCost(array
		(
			'location_id'=>CBSHelper::getPostValue('locationId',false),
			'vehicle_id'=>CBSHelper::getPostValue('vehicleId',false),
			'package_id'=>CBSHelper::getPostValue('packageId',false),
			'service_id'=>CBSHelper::getPostValue('serviceId',false)			
		));
		
		$date=$this->getDate($locationId,date_i18n('d-m-Y',strtotime($startDate.' +'.$step.' Month')),$cost['duration']['minute_sum']);
		
		$response['error']=0;
		$response['calendar']=$Template->output('calendar',array
		(
			'date'=>$date['date'],
			'header'=>$date['header'],
			'hourVisibleNumber'=>$location[$locationId]['meta']['hour_visible_number'],
			'calendarNavigationAdvancePeriod'=>$location[$locationId]['meta']['calendar_navigation_advance_period'],
			'calendarMonthNavigation'=>$location[$locationId]['meta']['calendar_month_navigation'],
		),false);
		
		CBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
	
	function createCalendar()
	{
		$Validation=new CBSValidation();
		$Template=new CBSTemplatePublic();
		
		$response=array('error'=>1,'calendar'=>null);
		
		$step=(int)CBSHelper::getPostValue('step',false);
		$startDate=CBSHelper::getPostValue('startDate',false);
		$locationId=(int)CBSHelper::getPostValue('locationId',false);
		
		$location=$this->getDictionary(array('location_id'=>$locationId));
		if(count($location)!=1) 
			CBSHelper::createJSONResponse($response);
		
		if(!$Validation->isNumber($step,-999,999))
			CBSHelper::createJSONResponse($response);
		
		$startDate=substr($startDate,0,2).'-'.substr($startDate,2,2).'-'.substr($startDate,4,4);
		if(!$Validation->isDate($startDate))
			CBSHelper::createJSONResponse($response);
		
		$cost=$this->calculateCost(array
		(
			'location_id'=>CBSHelper::getPostValue('locationId',false),
			'vehicle_id'=>CBSHelper::getPostValue('vehicleId',false),
			'package_id'=>CBSHelper::getPostValue('packageId',false),
			'service_id'=>CBSHelper::getPostValue('serviceId',false)			
		));
		
		$date=$this->getDate($locationId,date_i18n('d-m-Y',strtotime($startDate.' +'.$step.' Day')),$cost['duration']['minute_sum']);
		
		$response['error']=0;
		$response['calendar']=$Template->output('calendar',array
		(
			'date'=>$date['date'],
			'header'=>$date['header'],
			'hourVisibleNumber'=>$location[$locationId]['meta']['hour_visible_number'],
			'calendarNavigationAdvancePeriod'=>$location[$locationId]['meta']['calendar_navigation_advance_period'],
			'calendarMonthNavigation'=>$location[$locationId]['meta']['calendar_month_navigation'],
		),false);
		
		CBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
	
	function validateAgreement($meta,$data)
	{
		if(!array_key_exists('form_agreement',$meta)) return(false);
	   
		foreach($meta['form_agreement'] as $value)
		{
			$name='form_agreement_'.$value['id'];
			
			if((!array_key_exists($name,$data)) || ((int)$data[$name]!==1))
				return(true);
		}
		
		return(false);
	}
	
	/**************************************************************************/
	
	function isPaymentAvailable($locationId,$paymentType=null)
	{
		$location=$this->getDictionary(array('location_id'=>$locationId));
		if(count($location)!=1) return(false);
		
		if(!is_null($paymentType))
		{
			if(!array_key_exists('payment_'.$paymentType.'_enable',$location[$locationId]['meta']))
				return(false);
			if($location[$locationId]['meta']['payment_'.$paymentType.'_enable']==1)
				return(true);
		}
		
		return(false);
	}
	
	/**************************************************************************/
	
	function createLoginForm()
	{
		$Template=new CBSTemplatePublic();
		$response=array
		(
			'error'=>0,
			'login_form'=>$Template->output('booking-login',array(),false)
		);
		CBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
	
	function createUserContactDetails()
	{
		$usernameOrEmail=CBSHelper::getPostValue('usernameOrEmail',false);
		$password=CBSHelper::getPostValue('password',false);
		$vehicleId=(int)CBSHelper::getPostValue('vehicleId',false);
		$packageId=(int)CBSHelper::getPostValue('packageId',false);
		$locationId=(int)CBSHelper::getPostValue('locationId',false);
		
		$User=new CBSUser();
		$Validation=new CBSValidation();
		$Template=new CBSTemplatePublic();
		
		$response=array
		(
			'error'=>1,
		);
		
		$attribute=array
		(
			'location_id'=>$locationId,
			'vehicle_id'=>$vehicleId,
			'package_id'=>$packageId
		);	
		
		$location=$this->getDictionary($attribute);
		
		if($Validation->isEmpty($usernameOrEmail))
		{
			$response['header']=__('Errors Found!','car-wash-booking-system');
			$response['message']=__('Please enter your username.','car-wash-booking-system');
			CBSHelper::createJSONResponse($response);
		}
		
		if($Validation->isEmpty($password))
		{
			$response['header']=__('Errors Found!','car-wash-booking-system');
			$response['message']=__('Please enter your password.','car-wash-booking-system');
			CBSHelper::createJSONResponse($response);
		}
		
		
		$creds = array();
		$creds['user_login']=$usernameOrEmail;
		$creds['user_password']=$password;
		$creds['remember']=true;
		$user=wp_signon($creds);
		if(is_wp_error($user))
		{
			$response['header']=__('Errors Found!','car-wash-booking-system');
			$response['message']=$user->get_error_message();
			CBSHelper::createJSONResponse($response);
		}
		else
		{
			$data=array();
			if(array_key_exists('form_agreement',$location[$locationId]['meta']))
				$data['form_agreement']=$location[$locationId]['meta']['form_agreement'];
			else
				$data['form_agreement']=array();
			$data['text_1']=$location[$locationId]['meta']['text_1'];
			$data['client_address_enable']=$location[$locationId]['meta']['client_address_enable'];
			$data['client_company_name_enable']=(int)$location[$locationId]['meta']['client_company_name_enable'];
			$data['client_address_street_enable']=(int)$location[$locationId]['meta']['client_address_street_enable'];
			$data['client_address_post_code_enable']=(int)$location[$locationId]['meta']['client_address_post_code_enable'];
			$data['client_address_city_enable']=(int)$location[$locationId]['meta']['client_address_city_enable'];
			$data['client_address_state_enable']=(int)$location[$locationId]['meta']['client_address_state_enable'];
			$data['client_address_country_enable']=(int)$location[$locationId]['meta']['client_address_country_enable'];
			$data['client_message_enable']=(int)$location[$locationId]['meta']['client_message_enable'];
			$data['gratuity_enable']=(int)$location[$locationId]['meta']['gratuity_enable'];
			$data['service_location_enable']=(int)$location[$locationId]['meta']['service_location_enable'];
			$data['service_location']=$location[$locationId]['meta']['service_location'];
			$data['user_contact_data']=$User->getUserContactData($user->ID);
			$data['enable_coupons']=$location[$locationId]['meta']['enable_coupons'];
			$data['payment_selection_method']=$location[$locationId]['meta']['payment_selection_method'];
			$data['payment_type']=$this->getAvailablePaymentMethods($locationId,$location);
			
			$response['error']=0;
			$response['header']=__('Success','car-wash-booking-system');
			$response['message']=__('User was logged in.','car-wash-booking-system');
			$response['client_details']=$Template->output('booking-user-contact-details',array
			(
				'class'=>'',
				'text_1'=>$data['text_1'],
				'client_address_enable'=>$data['client_address_enable'],
				'enable_coupons'=>$data['enable_coupons'],
				'user_contact_data'=>$data['user_contact_data'],
				'register_user'=>0,
				'client_company_name_enable'=>$data['client_company_name_enable'],
				'client_address_street_enable'=>$data['client_address_street_enable'],
				'client_address_post_code_enable'=>$data['client_address_post_code_enable'],
				'client_address_city_enable'=>$data['client_address_city_enable'],
				'client_address_state_enable'=>$data['client_address_state_enable'],
				'client_address_country_enable'=>$data['client_address_country_enable'],
				'client_message_enable'=>$data['client_message_enable'],
				'gratuity_enable'=>$data['gratuity_enable'],
				'service_location_enable'=>$data['service_location_enable'],
				'service_location'=>$data['service_location'],
				'form_agreement'=>$data['form_agreement'],
				'payment_selection_method'=>$data['payment_selection_method'],
				'payment_type'=>$data['payment_type'],
			),
			false);
			
			CBSHelper::createJSONResponse($response);
		}
	}
	
	/**************************************************************************/
	
	function createContactDetailsForm()
	{
		$vehicleId=(int)CBSHelper::getPostValue('vehicleId',false);
		$packageId=(int)CBSHelper::getPostValue('packageId',false);
		$locationId=(int)CBSHelper::getPostValue('locationId',false);
		
		$User=new CBSUser();
		$Template=new CBSTemplatePublic();
		
		$response=array
		(
			'error'=>0,
		);
		
		$attribute=array
		(
			'location_id'=>$locationId,
			'vehicle_id'=>$vehicleId,
			'package_id'=>$packageId
		);	
		
		$location=$this->getDictionary($attribute);
		
		$data['service_location_enable']=$location[$locationId]['meta']['service_location_enable'];
		$data['service_location']=$location[$locationId]['meta']['service_location'];
		if(array_key_exists('form_agreement',$location[$locationId]['meta']))
			$data['form_agreement']=$location[$locationId]['meta']['form_agreement'];
		else
			$data['form_agreement']=array();
		$data['text_1']=$location[$locationId]['meta']['text_1'];
		$data['client_address_enable']=$location[$locationId]['meta']['client_address_enable'];
		$data['client_company_name_enable']=$location[$locationId]['meta']['client_company_name_enable'];
		$data['client_address_street_enable']=$location[$locationId]['meta']['client_address_street_enable'];
		$data['client_address_post_code_enable']=$location[$locationId]['meta']['client_address_post_code_enable'];
		$data['client_address_city_enable']=$location[$locationId]['meta']['client_address_city_enable'];
		$data['client_address_state_enable']=$location[$locationId]['meta']['client_address_state_enable'];
		$data['client_address_country_enable']=$location[$locationId]['meta']['client_address_country_enable'];
		$data['client_message_enable']=$location[$locationId]['meta']['client_message_enable'];
		$data['gratuity_enable']=$location[$locationId]['meta']['gratuity_enable'];
		$data['enable_coupons']=$location[$locationId]['meta']['enable_coupons'];
		$data['user_contact_data']=$User->getUserContactDataEmpty();
		
		$data['payment_selection_method']=$location[$locationId]['meta']['payment_selection_method'];		
		$data['payment_type']=array();
		if($this->isPaymentAvailable($locationId,'cash'))
			$data['payment_type'][]=array('cash',__('Cash','car-wash-booking-system'));
		if($this->isPaymentAvailable($locationId,'stripe'))
			$data['payment_type'][]=array('stripe',__('Stripe','car-wash-booking-system'));
		if($this->isPaymentAvailable($locationId,'paypal'))
			$data['payment_type'][]=array('paypal',__('PayPal','car-wash-booking-system'));
		
		$response['order_form']=$Template->output('booking-form',array
		(
			'class'=>'cbs-contact-details-form',
			'text_1'=>$data['text_1'],
			'client_address_enable'=>$data['client_address_enable'],
			'user_contact_data'=>$data['user_contact_data'],
			'client_company_name_enable'=>$data['client_company_name_enable'],
			'client_address_street_enable'=>$data['client_address_street_enable'],
			'client_address_post_code_enable'=>$data['client_address_post_code_enable'],
			'client_address_city_enable'=>$data['client_address_city_enable'],
			'client_address_state_enable'=>$data['client_address_state_enable'],
			'client_address_country_enable'=>$data['client_address_country_enable'],
			'client_message_enable'=>$data['client_message_enable'],
			'enable_coupons'=>$data['enable_coupons'],			
			'gratuity_enable'=>$data['gratuity_enable'],
			'service_location_enable'=>$data['service_location_enable'],
			'service_location'=>$data['service_location'],
			'register_user'=>get_option('users_can_register'),
			'form_agreement'=>$data['form_agreement'],
			'payment_selection_method'=>$data['payment_selection_method'],
			'payment_type'=>$data['payment_type'],
		),
		false);
		
		CBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/

	function getAvailablePaymentMethods($locationId,$location)
	{
		$WooCommerce=new CBSWooCommerce();
		$data=array();
		if($WooCommerce->isEnable($location[$locationId]['meta']))
		{
			$paymentDictionary=$WooCommerce->getPaymentDictionary();
			if($paymentDictionary)
			{
				foreach($paymentDictionary as $paymentMethod)
				{
					$data[]=array($paymentMethod->id,$paymentMethod->method_title);
				}
			}
		}
		else
		{
			if($this->isPaymentAvailable($locationId,'cash'))
				$data[]=array('cash',__('Cash','car-wash-booking-system'));
			if($this->isPaymentAvailable($locationId,'stripe'))
				$data[]=array('stripe',__('Stripe','car-wash-booking-system'));
			if($this->isPaymentAvailable($locationId,'paypal'))
				$data[]=array('paypal',__('PayPal','car-wash-booking-system'));
		}
		return($data);
	}

	/**************************************************************************/

}

/******************************************************************************/
/******************************************************************************/