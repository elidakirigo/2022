<?php

/******************************************************************************/
/******************************************************************************/

class CBSPlugin
{
	/**************************************************************************/	
	
	function __construct()
	{
		$this->libraryDefault=array
		(
			'script'=>array
			(
				'use'=>1,
				'inc'=>true,
				'path'=>PLUGIN_CBS_SCRIPT_URL,
				'file'=>'',
				'in_footer'=>true,
				'dependencies'=>array('jquery'),
			),
			'style'=>array
			(
				'use'=>1,
				'inc'=>true,
				'path'=>PLUGIN_CBS_STYLE_URL,
				'file'=>'',
				'dependencies'=>array()
			)
		);
		
		/***/
		
		$this->optionDefault=array
		(
			'duration_unit'=>1,
			'booking_status_payment_success'=>'-1',
			'booking_status_synchronization'=>'1'	
		);
	}
	
	/**************************************************************************/
	
	function prepareLibrary()
	{
		$this->library=array
		(
			'script'=>array
			(
				'jquery'=>array
				(
					'use'=>3,
					'path'=>'',
					'in_footer'=>false,
					'dependencies'=>array()
				),
				'jquery-ui-core'=>array
				(
					'path'=>''
				),
				'jquery-ui-tabs'=>array
				(
					'use'=>3,
					'path'=>''
				),
				'jquery-ui-button'=>array
				(
					'path'=>''
				),
				'jquery-ui-datepicker'=>array
				(
					'path'=>''
				),
				'jquery-timepikcer'=>array
				(
					'file'=>'jquery.timepicker.min.js'
				),	
				'jquery-bbq'=>array
				(
					'file'=>'jquery.ba-bbq.min.js'
				),	
				'jquery-colorpicker'=>array
				(
					'file'=>'jquery.colorpicker.js'
				),
				'jquery-dropkick'=>array
				(
					'file'=>'jquery.dropkick.min.js'
				),
				'jquery-qtip'=>array
				(
					'file'=>'jquery.qtip.min.js'
				),
				'jquery-blockUI'=>array
				(
					'file'=>'jquery.blockUI.js'
				),	
				'jquery-infieldlabel'=>array
				(
					'file'=>'jquery.infieldlabel.min.js'
				),
				'jquery-scrollTo'=>array
				(
					'use'=>2,
					'file'=>'jquery.scrollTo.min.js'
				),
				'jquery-table'=>array
				(
					'use'=>1,
					'file'=>'jquery.table.js'
				),
				'jquery-themeOption'=>array
				(
					'file'=>'jquery.themeOption.js'
				),
				'jquery-themeOptionElement'=>array
				(
					'file'=>'jquery.themeOptionElement.js'
				),
				'jquery-cbs-plugin'=>array
				(
					'use'=>2,
					'file'=>'jquery.cbs-plugin.js'
				),
				'jquery-cbs-plugin-admin'=>array
				(
					'use'=>1,
					'file'=>'jquery.cbs-plugin-admin.js'
				)
			),
			'style'=>array
			(
				'jquery-ui'=>array
				(
					'use'=>3,
					'file'=>'jquery.ui.min.css'
				),
				'jquery-timepikcer'=>array
				(
					'file'=>'jquery.timepicker.css'
				),	
				'jquery-colorpicker'=>array
				(
					'file'=>'jquery.colorpicker.css'
				),
				'jquery-dropkick'=>array
				(
					'file'=>'jquery.dropkick.css'
				),
				'jquery-dropkick-rtl'=>array
				(				
					'use'=>1,
					'inc'=>false,
					'file'=>'jquery.dropkick.rtl.css',
				),
				'jquery-qtip'=>array
				(
					'file'=>'jquery.qtip.min.css'
				),
				'google-font-open-sans'=>array
				(
					'path'=>'',
					'file'=>'//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
				),
				'google-font-lato'=>array
				(
					'use'=>2,
					'path'=>'',
					'file'=>'//fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic&subset=latin-ext,latin'
				),				
				'jquery-themeOption'=>array
				(
					'file'=>'jquery.themeOption.css'
				),
				'jquery-themeOption-rtl'=>array
				(
					'use'=>1,
					'inc'=>false,
					'file'=>'jquery.themeOption.rtl.css'
				),
				'cbs-jquery-themeOption-overwrite'=>array
				(
					'file'=>'jquery.themeOption.overwrite.css'
				),
				'cbs-public'=>array
				(
					'use'=>2,
					'file'=>'public.css'
				),
				'cbs-rtl'=>array
				(
					'use'=>2,
					'inc'=>false,
					'file'=>'rtl.css'
				),
				'cbs-admin'=>array
				(
					'file'=>'admin.css'
				),
				'cbs-admin-rtl'=>array
				(
					'use'=>1,
					'inc'=>false,
					'file'=>'admin.rtl.css'
				)
			)
		);		
	}	
	
	/**************************************************************************/
	
	function addLibrary($type,$use)
	{
		$Location=new CBSLocation();
		$location=$Location->getDictionary();
		
		foreach($location as $locationId=>$locationData)
		{
			
			if(CBSFile::fileExist(CBSFile::getMultisiteBlogCSS($locationId)))
			{
				$this->library['style']['cbs-public-location-'.$locationId]=array
				(
					'use'=>2,
					'path'=>'',
					'file'=>CBSFile::getMultisiteBlogCSS($locationId,'url')
				);
			}
		}
		
		foreach($this->library[$type] as $index=>$value)
			$this->library[$type][$index]=array_merge($this->libraryDefault[$type],$value);
		
		foreach($this->library[$type] as $index=>$data)
		{
			if(!$data['inc']) continue;
			
			if($data['use']!=3)
			{
				if($data['use']!=$use) continue;
			}			
			
			if($type=='script')
			{
				wp_enqueue_script($index,$data['path'].$data['file'],$data['dependencies'],false,$data['in_footer']);
			}
			else 
			{
				wp_enqueue_style($index,$data['path'].$data['file'],$data['dependencies'],false);
			}
		}
	}
	
	/**************************************************************************/
	
	function includeLibrary($test,$script=array(),$style=array())
	{
		if($test!=1) return;

		foreach((array)$script as $value)
		{
			if(array_key_exists($value,$this->library['script']))
				$this->library['script'][$value]['inc']=true;
		}
		foreach((array)$style as $value)
		{
			if(array_key_exists($value,$this->library['style']))
				$this->library['style'][$value]['inc']=true;	
		}
	}
	
	/**************************************************************************/
	
	function pluginActivation()
	{
		CBSOption::createOption();
		
		$optionSave=array();
		$optionCurrent=CBSOption::getOptionObject();
			 
		foreach($this->optionDefault as $index=>$value)
		{
			if(!array_key_exists($index,$optionCurrent))
				$optionSave[$index]=$value;
		}
		
		$optionSave=array_merge((array)$optionSave,$optionCurrent);
		foreach($optionSave as $index=>$value)
		{
			if(!array_key_exists($index,$this->optionDefault))
				unset($optionSave[$index]);
		}
		
		CBSOption::resetOption();
		CBSOption::updateOption($optionSave);
		
		/***/
		
		global $wpdb;

		if(!function_exists('curl_version') )
		{
			exit(__('This plugin requires enabled cURL.'));
		}
		
		$collate=$wpdb->get_charset_collate();
		
		$sql=array();
		
		$sql[0]=
		'
			create table if not exists '.CBSHelper::getMySQLTableName('service_detail').'
			(
				service_id bigint(20) not null default 0,
				location_id bigint(20) not null default 0,
				vehicle_id bigint(20) not null default 0,
				enable tinyint(1) not null default 0,
				price double(11,2) default 0.00,
				duration int(9) not null default 0,
				unique key(service_id,location_id,vehicle_id)
			) '.$collate.';			
		';
		
		$sql[1]=
		'
			create table if not exists '.CBSHelper::getMySQLTableName('package_service').'
			(
				package_id bigint(20) not null default 0,
				service_id bigint(20) not null default 0,
				service_type tinyint(1) not null default 0,
				unique key(package_id,service_id)
			) '.$collate.';			
		';
		
		$sql[2]=
		'
			create table if not exists '.CBSHelper::getMySQLTableName('package_detail').'
			(
				package_id bigint(20) not null default 0,
				location_id bigint(20) not null default 0,
				vehicle_id bigint(20) not null default 0,
				enable tinyint(1) not null default 0,
				price double(11,2) default 0.00,
				unique key(package_id,location_id,vehicle_id)
			) '.$collate.';			
		';
		
		$sql[3]=
		'
			create table if not exists '.CBSHelper::getMySQLTableName('booking_service').'
			(
				booking_id bigint(20) not null default 0,
				service_id bigint(20) not null default 0,
				service_type tinyint(1) not null default 0,
				name varchar(255) not null,
				price double(11,2) default 0.00,
				duration int(9) not null default 0,
				service_order bigint(20) not null default 0,
				unique key(booking_id,service_id)
			) '.$collate.';			
		';
		
		$sql[4]=
		'
			create table if not exists '.CBSHelper::getMySQLTableName('booking_payment').'
			(
				booking_id bigint(20) not null default 0,
				txn_id varchar(100) null,
				payment_type varchar(255) null,
				payment_date datetime null,
				payment_status varchar(255) null,
				mc_gross double(11,2) default 0.00,
				mc_currency varchar(255) null,
				unique key(booking_id,txn_id)
			) '.$collate.';
		';
		
		foreach($sql as $query) $wpdb->query($query);

		$sql=array();
		
		$serviceDetailColumnTaxRateId=$wpdb->get_row('SHOW COLUMNS FROM '.CBSHelper::getMySQLTableName('service_detail').' WHERE field="tax_rate_id"');
		if(is_null($serviceDetailColumnTaxRateId))
		{
			$sql[]=
			'
				alter table '.CBSHelper::getMySQLTableName('service_detail').'
				add tax_rate_id bigint(20) not null default 0;		
			';	
		}
		
		$packageDetailColumnTaxRateId=$wpdb->get_row('SHOW COLUMNS FROM '.CBSHelper::getMySQLTableName('package_detail').' WHERE field="tax_rate_id"');
		if(is_null($packageDetailColumnTaxRateId))
		{
			$sql[]=
			'
				alter table '.CBSHelper::getMySQLTableName('package_detail').'
				add tax_rate_id bigint(20) not null default 0;		
			';
		}

		$bookingServiceColumnTaxRateValue=$wpdb->get_row('SHOW COLUMNS FROM '.CBSHelper::getMySQLTableName('booking_service').' WHERE field="tax_rate_value"');
		if(is_null($bookingServiceColumnTaxRateValue))
		{
			$sql[]=
			'
				alter table '.CBSHelper::getMySQLTableName('booking_service').'
				add tax_rate_value decimal(5,2) default 0.00;		
			';
		}
		
		foreach($sql as $query) $wpdb->query($query);
		
		$Location=new CBSLocation();
		$location=$Location->getDictionary();
		
		foreach($location as $locationId=>$locationData)
			$Location->createCSSFile($locationId);
		
		$Booking=new CBSBooking();
		$Booking->processOldBookings();
	}
	
	/**************************************************************************/
	
	function pluginDeactivation()
	{

	}
	
	/**************************************************************************/
	
	function init()
	{
		$User=new CBSUser();
		$Booking=new CBSBooking();
		$BookingReport=new CBSBookingReport();
		$Package=new CBSPackage();
		$Service=new CBSService();
		$Vehicle=new CBSVehicle();
		$Location=new CBSLocation();
		$Coupon=new CBSCoupon();
		$TaxRate=new CBSTaxRate();
		$PaymentStripe=new CBSPaymentStripe();
		$LogManager=new CBSLogManager();
		
		$User->init();
		$Booking->init();
		$BookingReport->init();
		$Location->init();
		$Package->init();
		$Service->init();
		$Vehicle->init();
		$Coupon->init();
		$TaxRate->init();
		
		add_action('admin_init',array($this,'adminInit'));
		add_action('admin_menu',array($this,'adminMenu'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_option_page_save',array($this,'adminOptionPanelSave'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_create_package',array($Location,'createPackage'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CBS_CONTEXT.'_create_package',array($Location,'createPackage'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_create_service',array($Location,'createService'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CBS_CONTEXT.'_create_service',array($Location,'createService'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_create_booking',array($Booking,'createBooking'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CBS_CONTEXT.'_create_booking',array($Booking,'createBooking'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_create_service_info',array($Service,'createServiceInfo'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_create_cost',array($Location,'createCost'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CBS_CONTEXT.'_create_cost',array($Location,'createCost'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_create_calendar',array($Location,'createCalendar'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CBS_CONTEXT.'_create_calendar',array($Location,'createCalendar'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_create_calendar_month',array($Location,'createCalendarMonth'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CBS_CONTEXT.'_create_calendar_month',array($Location,'createCalendarMonth'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_create_user_contact_details',array($Location,'createUserContactDetails'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CBS_CONTEXT.'_create_user_contact_details',array($Location,'createUserContactDetails'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_create_login_form',array($Location,'createLoginForm'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CBS_CONTEXT.'_create_login_form',array($Location,'createLoginForm'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_create_contact_details_form',array($Location,'createContactDetailsForm'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CBS_CONTEXT.'_create_contact_details_form',array($Location,'createContactDetailsForm'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_handle_stripe_token',array($PaymentStripe,'handleStripeToken'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CBS_CONTEXT.'_handle_stripe_token',array($PaymentStripe,'handleStripeToken'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_apply_coupon',array($Coupon,'applyCoupon'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CBS_CONTEXT.'_apply_coupon',array($Coupon,'applyCoupon'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_option_page_import_dummy_content',array($this,'importDummyContent'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CBS_CONTEXT.'_option_page_import_dummy_content',array($this,'importDummyContent'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_option_page_generate_coupon_codes',array($Coupon,'generateCouponCodes'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CBS_CONTEXT.'_option_page_generate_coupon_codes',array($Coupon,'generateCouponCodes'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_option_page_save_google_calendar_settings',array($this,'saveGoogleCalendarSettings'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CBS_CONTEXT.'_option_page_save_google_calendar_settings',array($this,'saveGoogleCalendarSettings'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_update_user_contact_details',array($User,'updateUserContactDetails'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CBS_CONTEXT.'_update_user_contact_details',array($User,'updateUserContactDetails'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_user_log_out',array($User,'userLogOut'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CBS_CONTEXT.'_user_log_out',array($User,'userLogOut'));
		
		add_action('wp_ajax_'.PLUGIN_CBS_CONTEXT.'_create_vehicle_package',array($Location,'createPackage'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CBS_CONTEXT.'_create_vehicle_package',array($Location,'createPackage'));
		
		add_action('admin_notices',array($this,'adminNotice'));
		
		add_action('wp_mail_failed',array($LogManager,'logWPMailError'));
		
		if(current_user_can('delete_posts'))
			add_action('delete_post',array($this,'deletePost'));
		
		if(!is_admin())
		{
			$PaymentStripe=new CBSPaymentStripe();
			
			add_action('wp_enqueue_scripts',array($this,'publicInit'));
			
			add_action('wp_loaded',array($PaymentStripe,'receivePayment'));
		}
		
		$WooCommerce=new CBSWooCommerce();
		$WooCommerce->addAction();
	}
	
	/**************************************************************************/
	
	function publicInit()
	{
		$this->prepareLibrary();
		
		if(is_rtl())
		{
			$this->library['style']['cbs-rtl']['inc']=true;
		}
		
		$this->addLibrary('style',2);
		$this->addLibrary('script',2);	
		
		/***/
		
		$data=array();
		
		$data['config']['ajaxurl']=admin_url('admin-ajax.php');
		$data['config']['isRtl']=is_rtl();
		
		$param=array
		(
			'l10n_print_after'=>'pluginOption='.json_encode($data).';'
		);
			
		wp_localize_script('jquery-cbs-plugin','pluginOption',$param);
	}
	
	/**************************************************************************/
	
	function adminInit()
	{
		$this->prepareLibrary();
		
		if(is_rtl())
		{
			$this->library['style']['jquery-themeOption-rtl']['inc']=true;
			$this->library['style']['jquery-dropkick-rtl']['inc']=true;
			$this->library['style']['cbs-admin-rtl']['inc']=true;
		}
		
		$this->addLibrary('style',1);
		$this->addLibrary('script',1);
		
		$data=array();
		
		$data['config']['ajaxurl']=admin_url('admin-ajax.php');
		$data['config']['isRtl']=is_rtl();
		
		$param=array
		(
			'l10n_print_after'=>'pluginOption='.json_encode($data).';'
		);
			
		wp_localize_script('jquery-cbs-plugin-admin','pluginOption',$param);
	}
	
	/**************************************************************************/
	
	function adminMenu()
	{
		global $submenu;
		unset($submenu['edit.php?post_type=cbs_booking'][10]);
		add_options_page(__('Car Wash Booking System','car-wash-booking-system'),__('Car Wash<br/>Booking System','car-wash-booking-system'),'edit_theme_options','cbs_system',array($this,'adminCreateOptionPage'));
	}
	
	/**************************************************************************/
	
	function adminCreateOptionPage()
	{
		CBSOption::createOption();
		
		$data=array();
		
		$Location=new CBSlocation();
		$BookingStatus=new CBSBookingStatus();
		
		$data['dictionary']['location']=$Location->getDictionary();
		$data['google_calendar_settings']=get_option(PLUGIN_CBS_CONTEXT.'_google_calendar_settings','');
		
		$data['dictionary']['booking_status']=$BookingStatus->getBookingStatus();
		$data['dictionary']['booking_status_synchronization']=$BookingStatus->getBookingStatusSynchronization();
		
		$data['option']=CBSOption::getOptionObject();
	
		$Template=new CBSTemplate($data,PLUGIN_CBS_TEMPLATE_PATH.'admin/option.php');
		echo $Template->output();			
	}
	
	/**************************************************************************/
	
	public function adminOptionPanelSave()
	{   
		$option=CBSHelper::getPostOption();

		$response=array('global'=>array('error'=>1));

		$Notice=new CBSNotice();
		$BookingStatus=new CBSBookingStatus();
		
		$invalidValue=__('This field includes invalid value.','car-wash-booking-system');

		/***/
		
		if(!in_array($option['duration_unit'],array(1,2)))
			$Notice->addError(CBSHelper::getFormName('duration_unit',false),$invalidValue);
		
		/***/
		
		if((int)$option['booking_status_payment_success']!==-1)
		{
			if(!$BookingStatus->isBookingStatus($option['booking_status_payment_success']))
				$Notice->addError(CBSHelper::getFormName('booking_status_payment_success',false),$invalidValue);	
		}
		if(!$BookingStatus->isBookingStatusSynchronization($option['booking_status_synchronization']))
			$Notice->addError(CBSHelper::getFormName('booking_status_synchronization',false),$invalidValue);	
		
		/***/
		
		if($Notice->isError())
		{
			$response['local']=$Notice->getError();
		}
		else
		{
			$response['global']['error']=0;
			CBSOption::updateOption($option);
		}

		$response['global']['notice']=$Notice->createHTML(PLUGIN_CBS_TEMPLATE_PATH.'admin/notice.php');

		echo json_encode($response);
		exit;
	}
	
	/**************************************************************************/
	
	function deletePost($postId)
	{
		global $wpdb;
		
		$post=get_post($postId);
		
		$query=array();
		
		switch($post->post_type)
		{
			case PLUGIN_CBS_CONTEXT.'_vehicle':
				
				$query[]=$wpdb->prepare('delete from '.CBSHelper::getMySQLTableName('service_detail').' where vehicle_id=%d',$postId);
				$query[]=$wpdb->prepare('delete from '.CBSHelper::getMySQLTableName('package_detail').' where vehicle_id=%d',$postId);
				
			break;

			case PLUGIN_CBS_CONTEXT.'_service':

				$query[]=$wpdb->prepare('delete from '.CBSHelper::getMySQLTableName('service_detail').' where service_id=%d',$postId);
				$query[]=$wpdb->prepare('delete from '.CBSHelper::getMySQLTableName('package_service').' where service_id=%d',$postId);

			break;

			case PLUGIN_CBS_CONTEXT.'_package':

				$query[]=$wpdb->prepare('delete from '.CBSHelper::getMySQLTableName('package_detail').' where package_id=%d',$postId);
				$query[]=$wpdb->prepare('delete from '.CBSHelper::getMySQLTableName('package_service').' where package_id=%d',$postId);

			break;	

			case PLUGIN_CBS_CONTEXT.'_location':

				$query[]=$wpdb->prepare('delete from '.CBSHelper::getMySQLTableName('service_detail').' where location_id=%d',$postId);
				$query[]=$wpdb->prepare('delete from '.CBSHelper::getMySQLTableName('package_detail').' where location_id=%d',$postId);	

			break;	

			case PLUGIN_CBS_CONTEXT.'_booking':
				
				$query[]=$wpdb->prepare('delete from '.CBSHelper::getMySQLTableName('booking_service').' where booking_id=%d',$postId);

			break;
		}
		
		foreach($query as $queryData)
			$wpdb->get_results($queryData);
	}
	
	/**************************************************************************/
	
	function adminNotice()
	{
		if(!is_writable(PLUGIN_CBS_MULTISITE_PATH))
		{
			echo 
			'
				<div class="error">
					<p>'.sprintf(__('<b>File %s cannot be created. Please make sure that this location is writable.</b>','car-wash-booking-system'),str_replace('\\','/',PLUGIN_CBS_MULTISITE_PATH)).'</p>
				</div>				
			';				
		}
	}
	
	/**************************************************************************/
	
	function importDummyContent()
	{
		$Demo=new CBSDemo();
		$Notice=new CBSNotice();
		$Validation=new CBSValidation();
		
		$response=array('global'=>array('error'=>1));
		
		$buffer=$Demo->import();
		
		if($buffer!==false)
		{
			$response['global']['error']=0;
			$subtitle=__('Seems, that demo data has been imported. To make sure if this process has been successfully completed,please check below content of buffer returned by external applications.','car-wash-booking-system');
		}
		else
		{
			$response['global']['error']=1;
			$subtitle=__('Dummy data cannot be imported.','car-wash-booking-system');
		}
			
		$response['global']['notice']=$Notice->createHTML(PLUGIN_CBS_TEMPLATE_PATH.'admin/notice.php',true,$response['global']['error'],$subtitle);
		
		if($Validation->isNotEmpty($buffer))
		{
			$response['global']['notice'].=
			'
				<div class="to-buffer-output">
					'.$buffer.'
				</div>
			';
		}
		
		echo json_encode($response);
		exit;					
	}
	
	/**************************************************************************/
	
	function saveGoogleCalendarSettings()
	{
		$Notice=new CBSNotice();
		
		$response=array('global'=>array('error'=>1));	
		$googleCalendarSettings=stripslashes(CBSHelper::getPostValue('google_calendar_settings'));
		
		if(json_last_error()===JSON_ERROR_NONE)
		{
			$response['global']['error']=0;
			update_option(PLUGIN_CBS_CONTEXT.'_google_calendar_settings',$googleCalendarSettings);
			$subtitle=__('Settings saved.','car-wash-booking-system');
		}
		else
		{
			$response['global']['error']=1;
			$subtitle=__('Settings are invalid.','car-wash-booking-system');
		}
		
		$response['global']['notice']=$Notice->createHTML(PLUGIN_CBS_TEMPLATE_PATH.'admin/notice.php',true,$response['global']['error'],$subtitle);
		
		echo json_encode($response);
		exit;					
	}
		
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/