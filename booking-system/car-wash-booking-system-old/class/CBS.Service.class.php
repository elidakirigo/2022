<?php

/******************************************************************************/
/******************************************************************************/

class CBSService
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
			PLUGIN_CBS_CONTEXT.'_service',
			array
			(
				'labels'=>array
				(
					'name'=>__('Services','car-wash-booking-system'),
					'singular_name'=>__('Service','car-wash-booking-system'),
					'add_new'=>__('Add New','car-wash-booking-system'),
					'add_new_item'=>__('Add New Service','car-wash-booking-system'),
					'edit_item'=>__('Edit Service','car-wash-booking-system'),
					'new_item'=>__('New Service','car-wash-booking-system'),
					'all_items'=>__('Services','car-wash-booking-system'),
					'view_item'=>__('View Service','car-wash-booking-system'),
					'search_items'=>__('Search Services','car-wash-booking-system'),
					'not_found'=>__('No Services Found','car-wash-booking-system'),
					'not_found_in_trash'=>__('No Services Found in Trash','car-wash-booking-system'), 
					'parent_item_colon'=>'',
					'menu_name'=>__('Services','car-wash-booking-system')
				),	
				'public'=>false,  
				'show_ui'=>true, 
				'show_in_menu'=>'edit.php?post_type=cbs_booking',
				'capability_type'=>'post',
				'menu_position'=>2,
				'hierarchical'=>false,  
				'rewrite'=>false,  
				'supports'=>array('title','editor','page-attributes')  
			)
		);
		
		add_filter('manage_edit-'.PLUGIN_CBS_CONTEXT.'_service_columns',array($this,'manageEditColumn')); 
		add_action('manage_'.PLUGIN_CBS_CONTEXT.'_service_posts_custom_column',array($this,'manageColumn'));
		add_filter('manage_edit-'.PLUGIN_CBS_CONTEXT.'_service_sortable_columns',array($this,'manageEditSortableColumn'));
		add_filter('postbox_classes_'.PLUGIN_CBS_CONTEXT.'_service_cbs_meta_box_service',array($this,'adminCreateMetaBoxClass'));
		
		add_action('add_meta_boxes_'.PLUGIN_CBS_CONTEXT.'_service',array($this,'addMetaBox'));
		add_action('save_post',array($this,'savePost'));
	}
	
	/**************************************************************************/
	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_CBS_CONTEXT.'_meta_box_service',__('General','car-wash-booking-system'),array($this,'addMetaBoxGeneral'),PLUGIN_CBS_CONTEXT.'_service','normal','low');	
	}
	
	/**************************************************************************/
	
	function addMetaBoxGeneral()
	{
		global $post;
		
		$data=array();
		
		$Vehicle=new CBSVehicle();
		$Location=new CBSLocation();
		$TaxRate=new CBSTaxRate();
		
		$data['nonce']=CBSHelper::createNonceField(PLUGIN_CBS_CONTEXT.'_meta_box_service');
	
		$data['dictionary']['vehicle']=$Vehicle->getDictionary();
		$data['dictionary']['location']=$Location->getDictionary();
		$data['dictionary']['taxRate']=$TaxRate->getDictionary();
		
		$data['meta']=CBSPostMeta::getPostMeta($post);
		$data['detail']=$this->getServiceDetail($post->ID);
	
		
		$Template=new CBSTemplate($data,PLUGIN_CBS_TEMPLATE_PATH.'admin/meta_box_service.php');
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
			'name'=>__('Service Name','car-wash-booking-system'),
			'order'=>__('Order','car-wash-booking-system'),
			'detail'=>__('Details','car-wash-booking-system')	
		);   
		
		return($column);  
	}  
	
	/**************************************************************************/
	
	function manageEditSortableColumn($column)
	{
		$column['name']='title';
		$column['order']='menu_order';
		$column['detail']='title';
		
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
		
			case 'detail':
				echo $this->createServiceInfo($post->ID,'html');
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
			'service_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		
		CBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'post_type'=>PLUGIN_CBS_CONTEXT.'_service',
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'orderby'=>array('menu_order'=>'asc','title'=>'asc')
		);
		
		if($attribute['service_id'])
			$argument['p']=$attribute['service_id'];

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
	
	function getServiceDefault()
	{
		$default=array();
		
		$Vehicle=new CBSVehicle();
		$Location=new CBSLocation();		
		
		$vehicle=$Vehicle->getDictionary();
		$location=$Location->getDictionary();
		
		foreach($location as $locationId=>$locationData)
		{
			foreach($vehicle as $vehicleId=>$vehicleData)
			{
				$default[$locationId][$vehicleId]['enable']=0;
				$default[$locationId][$vehicleId]['price']='0.00';
				$default[$locationId][$vehicleId]['duration']=0;
				$default[$locationId][$vehicleId]['tax_rate']=0;
			}
		}
		
		return($default);
	}
	
	/**************************************************************************/
	
	function setPostMetaDefault(&$meta)
	{
		CBSHelper::setDefault($meta,'base_price','0.00');
		CBSHelper::setDefault($meta,'base_tax_rate','0');
		CBSHelper::setDefault($meta,'base_duration','0');
	}
	
	/**************************************************************************/
	/**************************************************************************/
	
	function savePost($postId)
	{
		if(!$_POST) return(false);
		
		if(CBSHelper::checkSavePost($postId,PLUGIN_CBS_CONTEXT.'_meta_box_service_noncename','savePost')===false) return(false);
		
		$TaxRate=new CBSTaxRate();
		$Validation=new CBSValidation();
		
		if($Validation->isFloat(CBSHelper::getPostValue('base_price'),0,999999999.99))
			CBSPostMeta::updatePostMeta($postId,'base_price',CBSPrice::formatToSave(CBSHelper::getPostValue('base_price')));
		else CBSPostMeta::updatePostMeta($postId,'base_price',0.00);

		if(CBSHelper::getPostValue('base_tax_rate')==0 || array_key_exists(CBSHelper::getPostValue('base_tax_rate'),$TaxRate->getDictionary()))
			CBSPostMeta::updatePostMeta($postId,'base_tax_rate',CBSHelper::getPostValue('base_tax_rate'));
		
		if($Validation->isNumber(CBSHelper::getPostValue('base_duration'),0,999999999))
			CBSPostMeta::updatePostMeta($postId,'base_duration',CBSHelper::getPostValue('base_duration'));
		else CBSPostMeta::updatePostMeta($postId,'base_duration',0);
		
		$detail=$this->getServiceDefault();

		foreach($detail as $locationId=>$vehicle)
		{
			foreach($vehicle as $vehicleId=>$vehicleData)
			{
				if($Validation->isBool(CBSHelper::getPostValue('detail_enable_'.$locationId.'_'.$vehicleId)))
					$detail[$locationId][$vehicleId]['enable']=CBSHelper::getPostValue('detail_enable_'.$locationId.'_'.$vehicleId);
				if($Validation->isFloat(CBSHelper::getPostValue('detail_price_'.$locationId.'_'.$vehicleId),0,999999999.99))
					$detail[$locationId][$vehicleId]['price']=CBSHelper::getPostValue('detail_price_'.$locationId.'_'.$vehicleId);
				if(CBSHelper::getPostValue('tax_rate')==0 || array_key_exists(CBSHelper::getPostValue('detail_tax_rate_'.$locationId.'_'.$vehicleId),$TaxRate->getDictionary()))
					$detail[$locationId][$vehicleId]['tax_rate']=CBSHelper::getPostValue('detail_tax_rate_'.$locationId.'_'.$vehicleId);
				if($Validation->isNumber(CBSHelper::getPostValue('detail_duration_'.$locationId.'_'.$vehicleId),0,999999999))
					$detail[$locationId][$vehicleId]['duration']=CBSHelper::getPostValue('detail_duration_'.$locationId.'_'.$vehicleId);				
			}	
		}
		
		$this->addServiceDetail($postId,$detail);
	}

	/**************************************************************************/
	
	function addServiceDetail($serviceId,$detail)
	{
		global $wpdb;
		
		$this->removeServiceDetail($serviceId);
		
		$query=null;
		
		$Validation=new CBSValidation();
		
		foreach($detail as $locationId=>$vehicle)
		{
			foreach($vehicle as $vehicleId=>$detailData)
			{
				if($Validation->isNotEmpty($query)) $query.=',';
				$query.=$wpdb->prepare('(%d,%d,%d,%d,%f,%d,%d)',$serviceId,$locationId,$vehicleId,$detailData['enable'],CBSPrice::formatToSave($detailData['price']),$detailData['duration'],$detailData['tax_rate']);
			}
		}

		$query='insert into '.CBSHelper::getMySQLTableName('service_detail').' values'.$query;
		
		$wpdb->query($query);
	}
	
	/**************************************************************************/
	
	function removeServiceDetail($serviceId)
	{
		global $wpdb;
		$query=$wpdb->prepare('delete from '.CBSHelper::getMySQLTableName('service_detail').' where service_id=%d',$serviceId);
		$wpdb->query($query);
	}
	
	/**************************************************************************/
	
	function getServiceDetail($serviceId)
	{
		global $wpdb;
		
		$query=$wpdb->prepare('select * from '.CBSHelper::getMySQLTableName('service_detail').' where service_id=%d',$serviceId);		
		
		$result=$wpdb->get_results($query);
		$default=$this->getServiceDefault();

		foreach($result as $line)
			$default[$line->{'location_id'}][$line->{'vehicle_id'}]=array('enable'=>$line->{'enable'},'price'=>$line->{'price'},'tax_rate'=>$line->{'tax_rate_id'},'duration'=>$line->{'duration'});
		
		return($default);
	}
		
	/**************************************************************************/
	/**************************************************************************/
	
	function getServicePublic($attr)
	{
		global $wpdb;

		$service=array();
		
		$default=array
		(
			'location_id'=>0,
			'vehicle_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		
		$dictionary=$this->getDictionary();
		
		/***/
		
		$line=array();	
		
		/***/
				
		if($attribute['location_id']!=0)
		{
			$add=null;
			if($attribute['vehicle_id']!=0) 
				$add='and vehicle_id='.(int)$attribute['vehicle_id'];
			
			$query=$wpdb->prepare('select service_id from '.CBSHelper::getMySQLTableName('service_detail').' where location_id=%d '.$add.' and enable=1',$attribute['location_id']);
		}
		$result=$wpdb->get_results($query);

		foreach($result as $line)
			$service[]=$line->{'service_id'};
		
		/***/
			
		$service=array_unique($service);
		foreach($dictionary as $dictionaryIndex=>$dictionaryValue)
		{
			if(!in_array($dictionaryIndex,$service))
				unset($dictionary[$dictionaryIndex]);
		}
		
		/***/	

		$serviceCost=$this->getServiceCost($attribute);
		foreach($dictionary as $dictionaryIndex=>$dictionaryValue)
		{
			$dictionary[$dictionaryIndex]['cost']=isset($serviceCost[$dictionaryIndex][$attribute['location_id']][$attribute['vehicle_id']]) ? $serviceCost[$dictionaryIndex][$attribute['location_id']][$attribute['vehicle_id']] : array();
		}
		
		/***/
		
		return($dictionary);
	}
	
	/**************************************************************************/
	
	function getServiceInfo($serviceId)
	{
		global $wpdb;
		
		$data=array();

		$service=$this->getDictionary(array('service_id'=>$serviceId));
		if(!isset($service[$serviceId])) return($data);
		
		$Vehicle=new CBSVehicle();
		$Location=new CBSLocation();
		
		$vehicle=$Vehicle->getDictionary();
		$location=$Location->getDictionary();
		
		if(!count($vehicle)) return($data);
		if(!count($location)) return($data);
		
		$query=$wpdb->prepare('select location_id,vehicle_id,enable,price,duration,tax_rate_id from '.CBSHelper::getMySQLTableName('service_detail').' where service_id=%d order by field(location_id,0,'.join(',',array_keys($location)).'),field(vehicle_id,'.join(',',array_keys($vehicle)).')',$serviceId);
		$result=$wpdb->get_results($query);
		
		$detail=array();
		foreach($result as $line)
			$detail[$line->{'location_id'}][$line->{'vehicle_id'}]=$line;
		
		foreach($location as $locationId=>$locationData)
		{
			foreach($vehicle as $vehicleId=>$vehicleData)
			{
				$enable=0;
				$price=0.00;
				$duration=0;
				$tax_rate_id=0;
				
				if(isset($detail[$locationId][$vehicleId]))
				{
					$enable=$detail[$locationId][$vehicleId]->{'enable'};
					$price=$detail[$locationId][$vehicleId]->{'price'};
					$duration=$detail[$locationId][$vehicleId]->{'duration'};
					$tax_rate_id=$detail[$locationId][$vehicleId]->{'tax_rate_id'};
					
					if($enable==1)
					{
						if($detail[$locationId][$vehicleId]->{'price'}==0.00) $price=$service[$serviceId]['meta']['base_price'];
						if($detail[$locationId][$vehicleId]->{'duration'}==0) $duration=$service[$serviceId]['meta']['base_duration'];		
						if($detail[$locationId][$vehicleId]->{'tax_rate_id'}==0) $tax_rate_id=$service[$serviceId]['meta']['base_tax_rate'];		
					}
				}
				
				$data[]=array
				(
					'location_id'=>$locationId,
					'location_name'=>$locationData['post']->post_title,
					'vehicle_id'=>$vehicleId,
					'vehicle_name'=>$vehicleData['post']->post_title,				
					'enable'=>$enable,
					'price'=>$price,
					'duration'=>$duration,
					'tax_rate_id'=>$tax_rate_id,
				);
			}
		}
		
		return($data);
	}
	
	/**************************************************************************/
	
	function createServiceInfo($postId=0,$type=null)
	{
		$type=is_null($type) ? CBSHelper::getPostValue('type',false) : $type;
		$postId=$postId==0 ? CBSHelper::getPostValue('serviceId',false) : $postId;
		
		$data=$this->getServiceInfo($postId);
		
		if(count($data))
		{
			$html=null;
			$locationIn=array();
			
			$locationCount=array();
			foreach($data as $dataValue)
			{
				if(isset($locationCount[$dataValue['location_id']]))
					$locationCount[$dataValue['location_id']]++;
				else $locationCount[$dataValue['location_id']]=1;
			}
			
			foreach($data as $dataValue)
			{
				$class=array();

				if($dataValue['enable']!=1) array_push($class,'to-strike');

				$locationName=null;
				if(!in_array($dataValue['location_id'],$locationIn))
					$locationName='<td rowspan="'.$locationCount[$dataValue['location_id']].'"><div><a href="'.get_edit_post_link($dataValue['location_id']).'">'.esc_html($dataValue['location_name']).'</a></div></td>';

				$html.=
				'
					<tr>
						'.$locationName.'
						<td'.CBSHelper::createCSSClassAttribute($class).'><div><a href="'.get_edit_post_link($dataValue['vehicle_id']).'">'.esc_html($dataValue['vehicle_name']).'</a></div></td>
						<td'.CBSHelper::createCSSClassAttribute($class).'><div>'.esc_html(CBSPrice::formatToDisplay($dataValue['price'])).'</div></td>
						<td'.CBSHelper::createCSSClassAttribute($class).'><div>'.esc_html($dataValue['duration']).'</div></td>
					</tr>
				';

				array_push($locationIn,$dataValue['location_id']);
			}

			$html=
			'
				<div class="to to-margin-top-0">
					<table class="to-table to-table-small">
						<thead>
							<th width="25%"><div>'.__('Location','car-wash-booking-system').'</div></th>
							<th width="25%"><div>'.__('Vehicle','car-wash-booking-system').'</div></th>
							<th width="25%"><div>'.__('Net Price','car-wash-booking-system').'</div></th>
							<th width="25%"><div>'.__('Duration','car-wash-booking-system').'</div></th>
						</thead>
						<tbody>
							'.$html.'
						</tbody>
					</table>
				</div>
			';

			if($type=='html') return($html);
			else CBSHelper::createJSONResponse(array('html'=>$html));
		}
	}
	
	/**************************************************************************/
	
	function getServiceCost($attr)
	{
		global $wpdb;
		
		$Location=new CBSLocation();
		$TaxRate=new CBSTaxRate();
		$Validation=new CBSValidation();
		
		$cost=array();
		
		$service=$this->getDictionary();
		
		$default=array
		(
			'location_id'=>0,
			'vehicle_id'=>0,
			'service_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		
		$location=$Location->getDictionary($attribute);
		
		$queryString=null;
		if($attribute['location_id']!=0)
			$queryString.=' and location_id='.(int)$attribute['location_id'];
		if($attribute['vehicle_id']!=0)
			$queryString.=' and vehicle_id='.(int)$attribute['vehicle_id'];	
		if(is_array($attribute['service_id']))
		{
			if(count($attribute['service_id']))
			{
				$set=join(',',(array)$attribute['service_id']);
				if($Validation->isNotEmpty($set)) $queryString.=' and service_id in ('.$set.')';	
			}
		}
		elseif($attribute['service_id']!=0)
			$queryString.=' and service_id='.(int)$attribute['service_id'];	
			
		$query='select service_id,location_id,vehicle_id,enable,price,duration,tax_rate_id from '.CBSHelper::getMySQLTableName('service_detail').' where 1=1'.$queryString;
		$result=$wpdb->get_results($query);
		
		foreach($result as $line)
		{
			if($line->{'price'}==0.00) $line->{'price'}=$service[$line->{'service_id'}]['meta']['base_price'];
			$priceNet=$line->{'price'};
			
			if($line->{'duration'}==0) $line->{'duration'}=$service[$line->{'service_id'}]['meta']['base_duration'];
			
			if($line->{'tax_rate_id'}==0)
			{
				if($service[$line->{'service_id'}]['meta']['base_tax_rate']==0)
					$line->{'tax_rate_id'}=$location[$attribute['location_id']]['meta']['tax_rate'];
				else
					$line->{'tax_rate_id'}=$service[$line->{'service_id'}]['meta']['base_tax_rate'];
			}
			
			$taxRateValue=0;
			if($line->{'tax_rate_id'}!=0)
			{
				$taxRate=$TaxRate->getDictionary(array('tax_rate_id'=>$line->{'tax_rate_id'}));
				$taxRateValue=$taxRate[$line->{'tax_rate_id'}]['meta']['rate'];
				$line->{'price'}+=round($line->{'price'}*($taxRateValue/100),2);
			}
			
			if($line->{'enable'}==0)
			{
				$line->{'price'}=0.00;
				$priceNet=0.00;
				$line->{'duration'}=0;
			}
			
			$cost[$line->{'service_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]=array
			(
				'priceNet'=>$priceNet,
				'price'=>$line->{'price'},
				'duration'=>$line->{'duration'},
				'tax_rate_id'=>$line->{'tax_rate_id'},
				'tax_rate'=>$taxRateValue
			);
		}
		
		return($cost);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/