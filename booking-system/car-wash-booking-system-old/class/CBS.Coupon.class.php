<?php

/******************************************************************************/
/******************************************************************************/

class CBSCoupon
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
			PLUGIN_CBS_CONTEXT.'_coupon',
			array
			(
				'labels'=>array
				(
					'name'=>__('Coupon','car-wash-booking-system'),
					'singular_name'=>__('Coupons','car-wash-booking-system'),
					'add_new'=>__('Add New','car-wash-booking-system'),
					'add_new_item'=>__('Add New Coupon','car-wash-booking-system'),
					'edit_item'=>__('Edit Coupon','car-wash-booking-system'),
					'new_item'=>__('New Coupon','car-wash-booking-system'),
					'all_items'=>__('Coupons','car-wash-booking-system'),
					'view_item'=>__('View Coupon','car-wash-booking-system'),
					'search_items'=>__('Search Coupons','car-wash-booking-system'),
					'not_found'=>__('No Coupons Found','car-wash-booking-system'),
					'not_found_in_trash'=>__('No Coupons Found in Trash','car-wash-booking-system'), 
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
				'supports'=>array('')  
			)
		);	
		
		add_filter('manage_edit-'.PLUGIN_CBS_CONTEXT.'_coupon_columns',array($this,'manageEditColumn')); 
		add_action('manage_'.PLUGIN_CBS_CONTEXT.'_coupon_posts_custom_column',array($this,'manageColumn'));
		add_filter('manage_edit-'.PLUGIN_CBS_CONTEXT.'_coupon_sortable_columns',array($this,'manageEditSortableColumn'));
		add_filter('postbox_classes_'.PLUGIN_CBS_CONTEXT.'_coupon_cbs_meta_box_coupon',array($this,'adminCreateMetaBoxClass'));
		add_filter('wp_insert_post_data',array($this,'insertPostData'),'99',2);
		add_filter('enter_title_here',array($this,'changePostTitlePlaceholder'));
		
		add_action('add_meta_boxes_'.PLUGIN_CBS_CONTEXT.'_coupon',array($this,'addMetaBox'));
		add_action('save_post',array($this,'savePost'));
	}
	
	/**************************************************************************/
	
	function changePostTitlePlaceholder()
	{
		$screen=get_current_screen();
		if(PLUGIN_CBS_CONTEXT.'_coupon'==$screen->post_type)
		{
			$title=__('Please leave blank','car-wash-booking-system');
			return($title);
		}
	}
	
	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_CBS_CONTEXT.'_meta_box_coupon',__('General','car-wash-booking-system'),array($this,'addMetaBoxGeneral'),PLUGIN_CBS_CONTEXT.'_coupon','normal','low');
	}
		
	/**************************************************************************/
	
	function addMetaBoxGeneral()
	{
		global $post;
		
		$data=array();
		
		$Location=new CBSlocation();
		
		$data['nonce']=CBSHelper::createNonceField(PLUGIN_CBS_CONTEXT.'_meta_box_coupon');
		
		$data['meta']=CBSPostMeta::getPostMeta($post);
		$data['meta']['usage_count']=$this->usageCount($post->ID);
		
		$data['dictionary']['location']=$Location->getDictionary();
		
		$Template=new CBSTemplate($data,PLUGIN_CBS_TEMPLATE_PATH.'admin/meta_box_coupon.php');
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
			'coupon_code'=>__('Coupon code','car-wash-booking-system'),
			'coupon_location'=>__('Location','car-wash-booking-system'),
			'usage_limit'=>__('Usage limit','car-wash-booking-system'),
			'discount'=>__('Discount','car-wash-booking-system'),
			'deduction'=>__('Deduction','car-wash-booking-system'),
			'minimal_price'=>__('Minimal price','car-wash-booking-system'),
			'date_active'=>__('Active','car-wash-booking-system'),
		);   
		
		return($column);  
	}  
	
	/**************************************************************************/
	
	function manageEditSortableColumn($column)
	{
		return($column);
	}
	
	/**************************************************************************/
	
	function manageColumn($column)
	{
		global $post;
		
		switch($column) 
		{
			case 'coupon_code':
				
				$meta=CBSPostMeta::getPostMeta($post);
				echo '<strong><a class="row-title" href="'.get_edit_post_link($post->ID).'">'.$meta['coupon_code'].'</a></strong>'; 
			
			break;
		
			case 'coupon_location':
				
				$meta=CBSPostMeta::getPostMeta($post);
				$locationId=$meta['coupon_location'];
				
				$Location=new CBSLocation();
				$location=$Location->getDictionary(array('location_id'=>$locationId));
				if(isset($location[$locationId]))
					echo '<strong><a class="row-title" href="'.get_edit_post_link($post->ID).'">'.$location[$locationId]['post']->post_title.'</a></strong>'; 
				
			break;
			
			case 'usage_limit':
				
				$Validation=new CBSValidation();
				
				$meta=CBSPostMeta::getPostMeta($post);
				$couponUsageCount=$this->usageCount($post->ID);
				$couponUsageLimit=($Validation->isNumber($meta['usage_limit'],0,999999) ? $meta['usage_limit'] : 'Unlimited');
				
				echo esc_html($couponUsageCount.'/'.$couponUsageLimit);
				
			break;
		
			case 'discount':
				
				$Validation=new CBSValidation();
				
				$meta=CBSPostMeta::getPostMeta($post);
				
				if($Validation->isNotEmpty($meta['discount']))
					echo esc_html($meta['discount']).'%';
				
			break;
			
			case 'deduction':
				
				$Validation=new CBSValidation();
				
				$meta=CBSPostMeta::getPostMeta($post);
				
				if($Validation->isNotEmpty($meta['deduction']))
					echo esc_html($meta['deduction']);
				
			break;
			
			case 'minimal_price':
				
				$Validation=new CBSValidation();
				
				$meta=CBSPostMeta::getPostMeta($post);
				
				if($Validation->isNotEmpty($meta['minimal_price']))
					echo esc_html($meta['minimal_price']);
				
			break;
			
			case 'date_active':
				
				$Validation=new CBSValidation();
				
				$meta=CBSPostMeta::getPostMeta($post);
				
				$html=array_fill(0,2,null);
				
				if($Validation->isDate($meta['date_active_start']))
					$html[0].='From <b>'.esc_html($meta['date_active_start']).'</b> ';
				
				if($Validation->isDate($meta['date_active_stop']))
					$html[1].=(is_null($html[0]) ? 'To' : 'to').' <b>'.esc_html($meta['date_active_stop']).'</b>';
				
				foreach($html as $htmlData) echo $htmlData;
				
			break;
		}
		
		return($column);
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
			'coupon_code'=>''
		);
		
		$attribute=shortcode_atts($default,$attr);
		
		CBSHelper::preservePost($post,$bPost);
		
		if($Validation->isEmpty($attribute['coupon_code']))
			return($dictionary);
		
		$argument=array
		(
			'post_type'=>PLUGIN_CBS_CONTEXT.'_coupon',
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'orderby'=>array('menu_order'=>'asc','title'=>'asc'),
			'meta_key'=>PLUGIN_CBS_CONTEXT.'_coupon_code',
			'meta_value'=>$attribute['coupon_code'],
		);
		
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
	
	function getCoupon($couponId)
	{
		global $post;
		
		$data=array();
		
		CBSHelper::preservePost($post,$bPost);
		
		if(!$couponId) return($data);
		
		$argument=array
		(
			'p'=>$couponId,
			'post_type'=>PLUGIN_CBS_CONTEXT.'_coupon',
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
		
		return($data);
	}
	
	/**************************************************************************/
	
	function setPostMetaDefault(&$meta)
	{
		CBSHelper::setDefault($meta,'coupon_code',$this->generateCode());
		CBSHelper::setDefault($meta,'coupon_location',0);
		CBSHelper::setDefault($meta,'usage_limit','');
		CBSHelper::setDefault($meta,'discount',0);
		CBSHelper::setDefault($meta,'deduction',0);
		CBSHelper::setDefault($meta,'minimal_price',0);
		CBSHelper::setDefault($meta,'date_active_start','');
		CBSHelper::setDefault($meta,'date_active_stop','');
	}	
	
	/**************************************************************************/
	/**************************************************************************/
	
	function savePost($postId)
	{
		if(!$_POST) return(false);
		
		if(CBSHelper::checkSavePost($postId,PLUGIN_CBS_CONTEXT.'_meta_box_coupon_noncename','savePost')===false) return(false);
	
		$meta=array();
		
		$Validation=new CBSValidation();
		
		$this->setPostMetaDefault($meta);
		
		if($Validation->isNotEmpty($coupon_code=CBSHelper::getPostValue('coupon_code')))
		{
			if(!preg_match("/^[A-Z0-9]{4,12}$/",$coupon_code,$result))
				$coupon_code=$this->generateCode();
			
			$args=array
			(
				'post__not_in'												  =>	array($postId),
				'post_type'													 =>	PLUGIN_CBS_CONTEXT.'_coupon',
				'meta_query'													=>	array
				(
					array
					(
						'key'												   =>	PLUGIN_CBS_CONTEXT.'_coupon_code',
						'value'												 =>	$coupon_code
					)
				),
				'fields'														=>  'ids'
			);
			
			$query_result=new WP_Query($args);
			$coupons_ids=$query_result->posts;
			
			if(count($coupons_ids))
				$coupon_code=$this->generateCode();
			
			$meta['coupon_code']=$coupon_code;
		}
		else
		{
			$coupon_code=$this->generateCode();
			$meta['coupon_code']=$coupon_code;
		}
		
		if(($Validation->isNotEmpty(CBSHelper::getPostValue('coupon_location'))) && ($Validation->isNumber(CBSHelper::getPostValue('coupon_location'),1,999999)))
			$meta['coupon_location']=CBSHelper::getPostValue('coupon_location');
		else $meta['coupon_location']=0;
		
		if(($Validation->isNotEmpty(CBSHelper::getPostValue('usage_limit'))) && ($Validation->isNumber(CBSHelper::getPostValue('usage_limit'),0,999999)))
			$meta['usage_limit']=CBSHelper::getPostValue('usage_limit');
		else $meta['usage_limit']='';
		
		if(($Validation->isNotEmpty(CBSHelper::getPostValue('discount'))) && ($Validation->isFloat(CBSHelper::getPostValue('discount'),0,100)))
			$meta['discount']=str_replace(',','.',CBSHelper::getPostValue('discount'));
		else $meta['discount']=0;
		
		if(($Validation->isNotEmpty(CBSHelper::getPostValue('deduction'))) && ($Validation->isFloat(CBSHelper::getPostValue('deduction'),0,999999999.99)))
			$meta['deduction']=str_replace(',','.',CBSHelper::getPostValue('deduction'));
		else $meta['deduction']=0;
		
		if(($Validation->isNotEmpty(CBSHelper::getPostValue('minimal_price'))) && ($Validation->isFloat(CBSHelper::getPostValue('minimal_price'),0,999999999.99)))
			$meta['minimal_price']=str_replace(',','.',CBSHelper::getPostValue('minimal_price'));
		else $meta['minimal_price']=0;
		
		if(($Validation->isNotEmpty(CBSHelper::getPostValue('date_active_start'))) && ($Validation->isDate(CBSHelper::getPostValue('date_active_start'))))
			$meta['date_active_start']=CBSHelper::getPostValue('date_active_start');
		else $meta['date_active_start']='';
		
		if(($Validation->isNotEmpty(CBSHelper::getPostValue('date_active_stop'))) && ($Validation->isDate(CBSHelper::getPostValue('date_active_stop'))))
			$meta['date_active_stop']=CBSHelper::getPostValue('date_active_stop');
		else $meta['date_active_stop']='';
		
		/***/
		
		foreach($meta as $metaIndex=>$metaData)
			CBSPostMeta::updatePostMeta($postId,$metaIndex,$metaData);
	}
	
	/**************************************************************************/
	
	function insertPostData($data)
	{
		$Validation=new CBSValidation();
		
		if($data['post_type']==PLUGIN_CBS_CONTEXT.'_coupon' && $Validation->isEmpty($data['post_title']) && $Validation->isNotEmpty(CBSHelper::getPostValue('coupon_code')))
			$data['post_title']=CBSHelper::getPostValue('coupon_code');
		
		return($data);
	}
	
	/**************************************************************************/
	
	function generateCouponCodes()
	{
		$Notice=new CBSNotice();
		$Validation=new CBSValidation();
		$couponLocation=(int)CBSHelper::getPostValue('coupon_location');
		$count=(int)CBSHelper::getPostValue('count');
		$usageLimit=CBSHelper::getPostValue('usage_limit');
		$discount=CBSHelper::getPostValue('discount');
		$deduction=CBSHelper::getPostValue('deduction');
		$minimalPrice=CBSHelper::getPostValue('minimal_price');
		$dateActiveStart=CBSHelper::getPostValue('date_active_start');
		$dateActiveStop=CBSHelper::getPostValue('date_active_stop');
		
		$response=array('global'=>array('error'=>1));
		
		if(!$Validation->isNumber($couponLocation,1,999999))
		{
			$subtitle=__('Incorrect location, please select correct location.','car-wash-booking-system');
			$response['global']['notice']=$Notice->createHTML(PLUGIN_CBS_TEMPLATE_PATH.'admin/notice.php',true,$response['global']['error'],$subtitle);
			CBSHelper::createJSONResponse($response);
		}
		
		if(!$Validation->isNumber($count,1,1000))
		{
			$subtitle=__('Incorrect count value, please insert value between 1 and 1,000.','car-wash-booking-system');
			$response['global']['notice']=$Notice->createHTML(PLUGIN_CBS_TEMPLATE_PATH.'admin/notice.php',true,$response['global']['error'],$subtitle);
			CBSHelper::createJSONResponse($response);
		}
		
		if(!$Validation->isFloat($discount,0,100))
		{
			$subtitle=__('Incorrect discount value, please insert value between 0 and 100.','car-wash-booking-system');
			$response['global']['notice']=$Notice->createHTML(PLUGIN_CBS_TEMPLATE_PATH.'admin/notice.php',true,$response['global']['error'],$subtitle);
			CBSHelper::createJSONResponse($response);
		}
		
		if(!$Validation->isFloat($deduction,0,999999999.99))
		{
			$subtitle=__('Incorrect deduction value, please insert value between 0 and 999999999.99.','car-wash-booking-system');
			$response['global']['notice']=$Notice->createHTML(PLUGIN_CBS_TEMPLATE_PATH.'admin/notice.php',true,$response['global']['error'],$subtitle);
			CBSHelper::createJSONResponse($response);
		}
		
		if(!$Validation->isFloat($minimalPrice,0,999999999.99))
		{
			$subtitle=__('Incorrect minimal price value, please insert value between 0 and 999999999.99.','car-wash-booking-system');
			$response['global']['notice']=$Notice->createHTML(PLUGIN_CBS_TEMPLATE_PATH.'admin/notice.php',true,$response['global']['error'],$subtitle);
			CBSHelper::createJSONResponse($response);
		}
		
		$meta=array();
		$meta['coupon_location']=$couponLocation;
		$meta['usage_limit']=$usageLimit;
		$meta['discount']=$discount;
		$meta['deduction']=$deduction;
		$meta['minimal_price']=$minimalPrice;
		$meta['date_active_start']=$dateActiveStart;
		$meta['date_active_stop']=$dateActiveStop;
		
		for($i=0;$i<$count;$i++)
		{
			$coupon_code=$this->generateCode();
			$coupon_id=wp_insert_post
			(
				array
				(
					'comment_status'											=>	'closed',
					'ping_status'											   =>	'closed',
					'post_author'											   =>	get_current_user_id(),
					'post_title'												=>	$coupon_code,
					'post_status'											   =>	'publish',
					'post_type'												 =>  PLUGIN_CBS_CONTEXT.'_coupon'
				)
			);
			if(!$coupon_id)
			{
				$subtitle=__('There was a problem while creating a coupon code.','car-wash-booking-system');
				$response['global']['notice']=$Notice->createHTML(PLUGIN_CBS_TEMPLATE_PATH.'admin/notice.php',true,$response['global']['error'],$subtitle);
				CBSHelper::createJSONResponse($response);
			}
			$meta['coupon_code']=$coupon_code;
			
			/***/
			
			foreach($meta as $metaIndex=>$metaData)
				CBSPostMeta::updatePostMeta($coupon_id,$metaIndex,$metaData);
		}
		
		$subtitle=__('Seems, that coupon codes has been generated. To make sure if this process has been successfully completed, please visit Car Wash Booking System->Coupons panel.','car-wash-booking-system');
		$response['global']['error']=0;
		$response['global']['notice']=$Notice->createHTML(PLUGIN_CBS_TEMPLATE_PATH.'admin/notice.php',true,$response['global']['error'],$subtitle);
		
		CBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
	
	function isActive($couponId,$locationId,$price)
	{
		if(!(int)$couponId) return(false);
		
		$Validation=new CBSValidation();
		$Location=new CBSLocation();
		
		$coupon=$this->getCoupon($couponId);
		if(!count($coupon)) return(false);
		
		$location=$Location->getDictionary(array('location_id'=>$locationId));
		if(count($location)!=1) return(false);
		
		if($Validation->isNotEmpty($coupon['meta']['coupon_location']))
		{
			if((int)$coupon['meta']['coupon_location']!=(int)$locationId) return(false);
		}
		else return(false);
		
		if($Validation->isNotEmpty($coupon['meta']['usage_limit']))
		{
			$couponUsageCount=$this->usageCount($couponId);
			if($couponUsageCount>=(int)$coupon['meta']['usage_limit']) return(false);
		}
		
		if($Validation->isNotEmpty($coupon['meta']['minimal_price']))
		{
			if($price<$coupon['meta']['minimal_price']) return(false);
		}
		
		if($Validation->isNotEmpty($coupon['meta']['date_active_start']))
		{
			if(!(strtotime($coupon['meta']['date_active_start'])<strtotime('now'))) return(false);
		}
		
		if($Validation->isNotEmpty($coupon['meta']['date_active_stop']))
		{
			if(!(strtotime('-1 day')<strtotime($coupon['meta']['date_active_stop']))) return(false);
		}
		
		return(true);
	}
	
	/**************************************************************************/
	
	function usageCount($couponId)
	{
		global $wpdb;
		
		$query=$wpdb->prepare('select count(*) from '.$wpdb->postmeta.' where meta_key=%s and meta_value=%d',PLUGIN_CBS_CONTEXT.'_coupon_id',(int)$couponId);
		
		return((int)$wpdb->get_var($query));
	}
	
	/**************************************************************************/
	
	function generateCode($length=12)
	{
		$code="";
		$chars="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$chars_length=strlen($chars);
		for($i=0;$i<$length;$i++)
			$code.=$chars[rand(0,$chars_length-1)];
		return($code);
	}
	
	/**************************************************************************/
	
}

/******************************************************************************/
/******************************************************************************/