<?php

/******************************************************************************/
/******************************************************************************/

class CBSVehicle
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->icon=array
		(
			'4x4'=>array('title'=>__('4x4','car-wash-booking-system')),
			'bicycle'=>array('title'=>__('Bicycle','car-wash-booking-system')),
			'boat'=>array('title'=>__('Boat','car-wash-booking-system')),
			'bus'=>array('title'=>__('Bus','car-wash-booking-system')),
			'car-mid-size'=>array('title'=>__('Car mid size','car-wash-booking-system')),
			'caravan'=>array('title'=>__('Caravan','car-wash-booking-system')),
			'double-decker'=>array('title'=>__('Double decker','car-wash-booking-system')),
			'heavy-equipment'=>array('title'=>__('Heavy equipment','car-wash-booking-system')),
			'jetski'=>array('title'=>__('Jetski','car-wash-booking-system')),
			'limousine'=>array('title'=>__('Limousine','car-wash-booking-system')),
			'midibus'=>array('title'=>__('Midibus','car-wash-booking-system')),
			'mini-car'=>array('title'=>__('Mini car','car-wash-booking-system')),
			'minibus'=>array('title'=>__('Minibus','car-wash-booking-system')),
			'minivan'=>array('title'=>__('Minivan','car-wash-booking-system')),
			'motorcycle'=>array('title'=>__('Motorcycle','car-wash-booking-system')),
			'pickup'=>array('title'=>__('Pickup','car-wash-booking-system')),
			'small-car'=>array('title'=>__('Small car','car-wash-booking-system')),
			'station-wagon'=>array('title'=>__('Station wagon','car-wash-booking-system')),
			'suv'=>array('title'=>__('Suv','car-wash-booking-system')),
			'trailer'=>array('title'=>__('Trailer','car-wash-booking-system')),
			'truck-large'=>array('title'=>__('Truck large','car-wash-booking-system')),
			'truck-mid-size'=>array('title'=>__('Truck mid size','car-wash-booking-system')),
			'truck'=>array('title'=>__('Truck','car-wash-booking-system')),
			'van'=>array('title'=>__('Van','car-wash-booking-system')),
		);
	}
	
	/**************************************************************************/
	
	function init()
	{
		register_post_type
		(
			PLUGIN_CBS_CONTEXT.'_vehicle',
			array
			(
				'labels'=>array
				(
					'name'=>__('Vehicles','car-wash-booking-system'),
					'singular_name'=>__('Vehicle','car-wash-booking-system'),
					'add_new'=>__('Add New','car-wash-booking-system'),
					'add_new_item'=>__('Add New Vehicle','car-wash-booking-system'),
					'edit_item'=>__('Edit Vehicle','car-wash-booking-system'),
					'new_item'=>__('New Vehicle','car-wash-booking-system'),
					'all_items'=>__('Vehicles','car-wash-booking-system'),
					'view_item'=>__('View Vehicle','car-wash-booking-system'),
					'search_items'=>__('Search Vehicles','car-wash-booking-system'),
					'not_found'=>__('No Vehicles Found','car-wash-booking-system'),
					'not_found_in_trash'=>__('No Vehicles Found in Trash','car-wash-booking-system'), 
					'parent_item_colon'=>'',
					'menu_name'=>__('Vehicles','car-wash-booking-system')
				),	
				'public'=>false,  
				'show_ui'=>true, 
				'show_in_menu'=>'edit.php?post_type=cbs_booking',
				'capability_type'=>'post',
				'menu_position'=>2,
				'hierarchical'=>false,  
				'rewrite'=>false,  
				'supports'=>array('title','page-attributes','thumbnail')  
			)
		);
		
		add_filter('manage_edit-'.PLUGIN_CBS_CONTEXT.'_vehicle_columns',array($this,'manageEditColumn')); 
		add_action('manage_'.PLUGIN_CBS_CONTEXT.'_vehicle_posts_custom_column',array($this,'manageColumn'));
		add_filter('manage_edit-'.PLUGIN_CBS_CONTEXT.'_vehicle_sortable_columns',array($this,'manageEditSortableColumn'));
		add_filter('postbox_classes_'.PLUGIN_CBS_CONTEXT.'_vehicle_cbs_meta_box_vehicle',array($this,'adminCreateMetaBoxClass'));
		
		add_action('save_post',array($this,'savePost'));
		add_action('add_meta_boxes_'.PLUGIN_CBS_CONTEXT.'_vehicle',array($this,'addMetaBox'));
	}
	
	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_CBS_CONTEXT.'_meta_box_vehicle',__('General','car-wash-booking-system'),array($this,'addMetaBoxGeneral'),PLUGIN_CBS_CONTEXT.'_vehicle','normal','low');	
	}
   	
	/**************************************************************************/
	
	function addMetaBoxGeneral()
	{
		global $post;
		
		$data=array();
		
		$data['nonce']=CBSHelper::createNonceField(PLUGIN_CBS_CONTEXT.'_meta_box_vehicle');
		
		$data['dictionary']['icon']=$this->icon;
		
		$data['meta']=CBSPostMeta::getPostMeta($post);

		$Template=new CBSTemplate($data,PLUGIN_CBS_TEMPLATE_PATH.'admin/meta_box_vehicle.php');
		echo $Template->output();
	}
	
	/**************************************************************************/
	
	function adminCreateMetaBoxClass($class) 
	{
		array_push($class,'to-postbox-1');
		return($class);
	}
	
	/**************************************************************************/
	
	function getDictionary($attr=array())
	{
		global $post;
		
		$dictionary=array();
		
		$default=array
		(
			'vehicle_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);

		CBSHelper::preservePost($post,$bPost);

		$argument=array
		(
			'post_type'=>PLUGIN_CBS_CONTEXT.'_vehicle',
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'orderby'=>array('menu_order'=>'asc','title'=>'asc')
		);
		
		if($attribute['vehicle_id'])
			$argument['p']=$attribute['vehicle_id'];

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
	
	function manageEditColumn($column)
	{
		$column=array
		(  
			'cb'=>'<input type="checkbox"/>',
			'name'=>__('Vehicle Type','car-wash-booking-system'),
			'icon'=>__('Icon','car-wash-booking-system'),
			'order'=>__('Order','car-wash-booking-system'),
		);   
		
		return($column);  
	}  
	
	/**************************************************************************/
	
	function manageEditSortableColumn($column)
	{
		$column['name']='title';
		$column['icon']='title';
		$column['order']='menu_order';
		
		return($column);
	}
	
	/**************************************************************************/
	
	function manageColumn($column)
	{
		global $post;
		
		$meta=CBSPostMeta::getPostMeta($post);
		
		switch($column) 
		{
			case 'name':
				echo '<strong><a class="row-title" href="'.get_edit_post_link($post->ID).'">'.get_the_title().'</a></strong>'; 
			break;
			case 'order':
				echo esc_html($post->menu_order);
			break;
			case 'icon':
				echo $this->getVehicleIcon($post->ID,$meta);
			break;
		}
		
		return($column);
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{
		if(!$_POST) return(false);
		
		if(CBSHelper::checkSavePost($postId,PLUGIN_CBS_CONTEXT.'_meta_box_vehicle_noncename','savePost')===false) return(false);
		
		$TaxRate=new CBSTaxRate();
		$Validation=new CBSValidation();
		
		CBSPostMeta::updatePostMeta($postId,'icon',CBSHelper::getPostValue('icon'));	
		
		if($Validation->isFloat(CBSHelper::getPostValue('initial_fee_value'),0,999999999.99))
			CBSPostMeta::updatePostMeta($postId,'initial_fee_value',CBSPrice::formatToSave(CBSHelper::getPostValue('initial_fee_value')));
		else CBSPostMeta::updatePostMeta($postId,'initial_fee_value',0.00);
		
		$dictionary=$TaxRate->getDictionary();
		if(array_key_exists(CBSHelper::getPostValue('initial_fee_tax_rate'),$dictionary))
			CBSPostMeta::updatePostMeta($postId,'initial_fee_tax_rate',CBSHelper::getPostValue('initial_fee_tax_rate'));
		else CBSPostMeta::updatePostMeta($postId,'initial_fee_tax_rate',0);
		
		if($Validation->isNumber(CBSHelper::getPostValue('icon_image_height'),0,999))
			CBSPostMeta::updatePostMeta($postId,'icon_image_height',CBSHelper::getPostValue('icon_image_height'));
	}
	
	/**************************************************************************/
	
	function setPostMetaDefault(&$meta)
	{
		CBSHelper::setDefault($meta,'icon','icon-1');
		CBSHelper::setDefault($meta,'icon_image_height','42');
		
		CBSHelper::setDefault($meta,'initial_fee_value',0.00);
		CBSHelper::setDefault($meta,'initial_fee_tax_rate',0);
	}
	
	/**************************************************************************/
	
	function getVehiclePublic($argument,$service,$package)
	{
		global $wpdb;
		
		$default=array
		(
			'location_id'=>0,
			'vehicle_id'=>0
		);
		
		$attribute=shortcode_atts($default,$argument);
		
		/***/
		$serviceIndex=array_keys($service);
		
		foreach($package as $packageData)
		{
			if(is_array($packageData['service']))
				$serviceIndex+=array_keys($packageData['service']);
		}
		
		/***/
		
		$vehicle=array();
		
		if($attribute['vehicle_id'])
		{
			$vehicle[]=$attribute['vehicle_id'];
		}
		else
		{
			$query=$wpdb->prepare('select vehicle_id from '.CBSHelper::getMySQLTableName('service_detail').' where enable=1 and service_id in ('.join(',',$serviceIndex).') and location_id=%d',$attribute['location_id']);
			$result=$wpdb->get_results($query);
			foreach($result as $line)
				$vehicle[]=$line->{'vehicle_id'};

			$vehicle=array_unique($vehicle);
		}
		
		/***/
		
		$dictionary=$this->getDictionary();
		
		foreach($dictionary as $dictionaryIndex=>$dictionaryValue)
		{
			if(!in_array($dictionaryIndex,$vehicle))
				unset($dictionary[$dictionaryIndex]);
		}
	
		/***/
		
		return($dictionary);
	}
	
	/**************************************************************************/
	
	function getVehicleIcon($postId,$postMeta=null,$tag='span')
	{
		$html=null;
		
		if(is_null($postMeta)) $postMeta=CBSPostMeta::getPostMeta($postId);
		
		if(has_post_thumbnail($postId))
			$html='<img src="'.esc_url(wp_get_attachment_url(get_post_thumbnail_id($postId))).'" style="max-height:'.(int)$postMeta['icon_image_height'].'px" alt="" />';
		else $html='<'.$tag.' class="cbs-vehicle-icon cbs-vehicle-icon-'.esc_attr($postMeta['icon']).'"></'.$tag.'>';

		return($html);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/