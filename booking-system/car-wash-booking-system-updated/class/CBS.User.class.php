<?php

/******************************************************************************/
/******************************************************************************/

class CBSUser
{
	/**************************************************************************/
	
	function __construct()
	{

	}
	
	/**************************************************************************/
	
	function init()
	{
		add_action('show_user_profile',array($this,'createMeta'));
		add_action('edit_user_profile',array($this,'createMeta'));
		add_action('personal_options_update',array($this,'saveMeta'));
		add_action('edit_user_profile_update',array($this,'saveMeta'));
	}
	
	/**************************************************************************/
	
	function createMeta($user)
	{
		$data=array();
		
		$Location=new CBSLocation();
		
		$data['dictionary']['location']=$Location->getDictionary();
		
		$data['meta']=$this->getMeta($user->ID);
		
		$Template=new CBSTemplate($data,PLUGIN_CBS_TEMPLATE_PATH.'admin/user_field.php');
		echo $Template->output();			
	}
	
	/**************************************************************************/
	
	function saveMeta($userId)
	{
		if(!current_user_can('edit_user',$userId)) return(false);
		
		$Location=new CBSLocation();
		$dictionary=$Location->getDictionary();
		
		$location=array_map('intval',CBSHelper::getPostValue('location'));
		
		foreach($location as $locationValue)
		{
			if((!array_key_exists($locationValue,$dictionary)) && (!in_array($locationValue,array(-1,-2))))
				unset($location);
		}
		
		if(!count($location)) $location=array();
		
		$b=false;
		foreach($location as $locationValue)
		{
			if($locationValue>0)
			{
				$b=true;
				break;
			}
		}
		
		$index1=array_search(-2,$location,true);
		$index2=array_search(-1,$location,true);
		
		if($b)
		{
			if($index1!==false) unset($location[$index1]);
			if($index2!==false) unset($location[$index2]);			
		}
		
		if(($index1!==false) && ($index2!==false)) unset($location[$index2]);
		
		update_user_meta($userId,'location',$location);
	}
	
	/**************************************************************************/
	
	function getMeta($userId)
	{
		$meta=array();
		
		$meta['location']=get_user_meta($userId,'location',true);

		if(!is_array($meta['location'])) $meta['location']=array();
		if(!count($meta['location'])) $meta['location'][]=-1;
		
		return($meta);
	}
	
	/**************************************************************************/
	
	function canUserManageLocation($locationId,$userId=-1,$userMeta=null)
	{
		if($userId===-1) $userId=get_current_user_id();
		if(is_null($userMeta)) $userMeta=$this->getMeta($userId);
		
		if(in_array(-2,$userMeta['location'])) return(false);
		if(in_array(-1,$userMeta['location'])) return(true);
		
		foreach($userMeta['location'] as $userLocationId)
		{
			if((int)$locationId===(int)$userLocationId) return(true);
		}
		
		return(false);
	}
	
	/**************************************************************************/
	
	function canUserManageBooking($bookingId,$redirect=true)
	{
		if(get_post_type($bookingId)==PLUGIN_CBS_CONTEXT.'_booking')
		{
			$bookingMeta=CBSPostMeta::getPostMeta($bookingId);
			
			$User=new CBSUser();
			if(!$User->canUserManageLocation($bookingMeta['location_id']))
			{
				if($redirect) wp_redirect(admin_url('edit.php?post_type='.PLUGIN_CBS_CONTEXT.'_booking'));
				return(false);
			}
		}
		
		return(true);
	}
	
	/**************************************************************************/
	
	function createUser($data,$meta=array())
	{
		$user=wp_create_user($data['username'],$data['password'],$data['email']);
		if(is_wp_error($user))
			return($user->get_error_message());
		
		if(count($meta))
		{
			foreach($meta as $key=>$val)
				update_user_meta($user,$key,$val);
		}
		
		return($user);
	}
	
	/**************************************************************************/
	
	function updateUserContactDetails()
	{
		$Validation=new CBSValidation();
		
		$response=array
		(
			'error'=>1,
			'header'=>__('Errors Found!','car-wash-booking-system'),
		);
		
		if(is_user_logged_in())
		{
			$contact_details=array
			(
				'first_name'=>CBSHelper::getPostValue('updateClientFirstName',false),
				'last_name'=>CBSHelper::getPostValue('updateClientSecondName',false),
				'company_name'=>CBSHelper::getPostValue('updateClientCompanyName',false),
				'vehicle'=>CBSHelper::getPostValue('updateClientVehicle',false),
				'email_address'=>CBSHelper::getPostValue('updateClientEmailAddress',false),
				'phone_number'=>CBSHelper::getPostValue('updateClientPhoneNumber',false),
				'address_street'=>CBSHelper::getPostValue('updateClientAddressStreet',false),
				'address_post_code'=>CBSHelper::getPostValue('updateClientAddressPostCode',false),
				'address_city'=>CBSHelper::getPostValue('updateClientAddressCity',false),
				'address_state'=>CBSHelper::getPostValue('updateClientAddressState',false),
				'address_country'=>CBSHelper::getPostValue('updateClientAddressCountry',false)
			);
			
			$message=array();
			if($Validation->isEmpty($contact_details['first_name']))
				array_push($message,__('Please enter your First Name.','car-wash-booking-system'));
			if($Validation->isEmpty($contact_details['last_name']))
				array_push($message,__('Please enter your Last Name.','car-wash-booking-system'));
			if($Validation->isEmpty($contact_details['vehicle']))
				array_push($message,__('Please enter your Vehicle Make and Model.','car-wash-booking-system'));
			if(!$Validation->isEmailAddress($contact_details['email_address']))
				array_push($message,__('Please enter valid E-mail.','car-wash-booking-system'));
			if($Validation->isEmpty($contact_details['phone_number']))
				array_push($message,__('Please enter your Phone Number.','car-wash-booking-system'));
			
			if(count($message))
			{
				$response['message']=implode('<br>',$message);
				CBSHelper::createJSONResponse($response);
			}
			
			$user=wp_get_current_user();
			if(is_wp_error($result=wp_update_user(array('ID'=>$user->ID,'user_email'=>$contact_details['email_address']))))
			{
				$response['message']=$result->get_error_message();
				CBSHelper::createJSONResponse($response);
			}
			
			foreach($contact_details as $key=>$val)
				update_user_meta($user->ID,$key,$val);

			$response['error']=0;
			$response['header']=__('Success','car-wash-booking-system');
			$response['message']=__('Contact details was updated.','car-wash-booking-system');
			CBSHelper::createJSONResponse($response);
		}
		else
		{
			$response['header']=__('Errors Found!','car-wash-booking-system');
			$response['message']=__('Please log in first.','car-wash-booking-system');
			CBSHelper::createJSONResponse($response);
		}
	}
	
	/**************************************************************************/
	
	function userLogOut()
	{
		wp_logout();
		
		$response=array
		(
			'error'=>0,
			'header'=>__('Success','car-wash-booking-system'),
			'message'=>__('You are now logged out.','car-wash-booking-system'),
		);
		CBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
	
	function getUserContactData($userId='')
	{
		$Validation=new CBSValidation();
		
		$userContactData=array
		(
			'first_name'=>'',
			'last_name'=>'',
			'email_address'=>'',
			'company_name'=>'',
			'phone_number'=>'',
			'vehicle'=>'',
			'address_street'=>'',
			'address_post_code'=>'',
			'address_city'=>'',
			'address_state'=>'',
			'address_country'=>'',
		);
		
		if(!$Validation->isNumber($userId,1,999999))
		{
			$userId=get_current_user_id();
			if(!$Validation->isNumber($userId,1,999999))
				return($userContactData);
		}
		
		$user=get_user_by('ID',$userId);
		if($user->ID===0)
			return($userContactData);
		
		foreach($userContactData as $key=>$val)
			$userContactData[$key]=$user->get($key);
		$userContactData['email_address']=$user->data->user_email;
		
		return($userContactData);
	}
	
	/**************************************************************************/
	
	function getUserContactDataEmpty()
	{
		$userContactData=array
		(
			'first_name'=>'',
			'last_name'=>'',
			'email_address'=>'',
			'company_name'=>'',
			'phone_number'=>'',
			'vehicle'=>'',
			'address_street'=>'',
			'address_post_code'=>'',
			'address_city'=>'',
			'address_state'=>'',
			'address_country'=>'',
		);
		return($userContactData);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/