<?php

/******************************************************************************/
/******************************************************************************/

class CBSTaxRate
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
			PLUGIN_CBS_CONTEXT.'_tax_rate',
			array
			(
				'labels'=>array
				(
					'name'=>__('Tax rates','car-wash-booking-system'),
					'singular_name'=>__('Tax rate','car-wash-booking-system'),
					'add_new'=>__('Add New','car-wash-booking-system'),
					'add_new_item'=>__('Add New Tax rate','car-wash-booking-system'),
					'edit_item'=>__('Edit Tax rate','car-wash-booking-system'),
					'new_item'=>__('New Tax rate','car-wash-booking-system'),
					'all_items'=>__('Tax rates','car-wash-booking-system'),
					'view_item'=>__('View Tax rate','car-wash-booking-system'),
					'search_items'=>__('Search Tax rates','car-wash-booking-system'),
					'not_found'=>__('No Tax rates Found','car-wash-booking-system'),
					'not_found_in_trash'=>__('No Tax rates Found in Trash','car-wash-booking-system'), 
					'parent_item_colon'=>'',
					'menu_name'=>__('Tax rates','car-wash-booking-system')
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
		
		add_filter('manage_edit-'.PLUGIN_CBS_CONTEXT.'_tax_rate_columns',array($this,'manageEditColumn')); 
		add_action('manage_'.PLUGIN_CBS_CONTEXT.'_tax_rate_posts_custom_column',array($this,'manageColumn'));
		add_filter('manage_edit-'.PLUGIN_CBS_CONTEXT.'_tax_rate_sortable_columns',array($this,'manageEditSortableColumn'));
		add_filter('postbox_classes_'.PLUGIN_CBS_CONTEXT.'_tax_rate_cbs_meta_box_tax_rate',array($this,'adminCreateMetaBoxClass'));
		
		add_action('save_post',array($this,'savePost'));
		add_action('add_meta_boxes_'.PLUGIN_CBS_CONTEXT.'_tax_rate',array($this,'addMetaBox'));
	}
	
	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_CBS_CONTEXT.'_meta_box_tax_rate',__('General','car-wash-booking-system'),array($this,'addMetaBoxGeneral'),PLUGIN_CBS_CONTEXT.'_tax_rate','normal','low');	
	}
   	
	/**************************************************************************/
	
	function addMetaBoxGeneral()
	{
		global $post;
		
		$data=array();
		
		$data['nonce']=CBSHelper::createNonceField(PLUGIN_CBS_CONTEXT.'_meta_box_tax_rate');
		
		$data['meta']=CBSPostMeta::getPostMeta($post);

		$Template=new CBSTemplate($data,PLUGIN_CBS_TEMPLATE_PATH.'admin/meta_box_tax_rate.php');
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
			'name'=>__('Tax Rate Name','car-wash-booking-system'),
			'order'=>__('Order','car-wash-booking-system'),
			'date'=>__('Date','car-wash-booking-system')	
		);   
		
		return($column);  
	}  
	
	/**************************************************************************/
	
	function manageEditSortableColumn($column)
	{
		$column['name']='title';
		$column['order']='menu_order';
		
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
			case 'order':
				echo esc_html($post->menu_order);
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
			'tax_rate_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);

		CBSHelper::preservePost($post,$bPost);

		$argument=array
		(
			'post_type'=>PLUGIN_CBS_CONTEXT.'_tax_rate',
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'orderby'=>array('menu_order'=>'asc','title'=>'asc')
		);
		
		if((int)$attribute['tax_rate_id']>0)
			$argument['p']=$attribute['tax_rate_id'];

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
		if(!$_POST) return(false);
		
		if(CBSHelper::checkSavePost($postId,PLUGIN_CBS_CONTEXT.'_meta_box_tax_rate_noncename','savePost')===false) return(false);
		
		$Validation=new CBSValidation();
		
		$taxRate=0.00;
		
		if($Validation->isFloat(CBSHelper::getPostValue('rate'),0,100))
			$taxRate=CBSHelper::getPostValue('rate');
		
		CBSPostMeta::updatePostMeta($postId,'rate',$taxRate);
	}
	
	/**************************************************************************/
	
	function setPostMetaDefault(&$meta)
	{
		CBSHelper::setDefault($meta,'rate','0.00');
	}
	
	/**************************************************************************/
	
	function getTaxRatePublic($argument,$service,$package)
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
		
		$query=$wpdb->prepare('select vehicle_id from '.CBSHelper::getMySQLTableName('service_detail').' where enable=1 and service_id in ('.join(',',$serviceIndex).') and location_id=%d',$attribute['location_id']);
		$result=$wpdb->get_results($query);
		
		$vehicle=array();
		foreach($result as $line)
			$vehicle[]=$line->{'vehicle_id'};
		
		$vehicle=array_unique($vehicle);
			
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
}

/******************************************************************************/
/******************************************************************************/