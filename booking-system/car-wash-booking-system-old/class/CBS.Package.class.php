<?php

/******************************************************************************/
/******************************************************************************/

class CBSPackage
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
			PLUGIN_CBS_CONTEXT.'_package',
			array
			(
				'labels'=>array
				(
					'name'=>__('Packages','car-wash-booking-system'),
					'singular_name'=>__('Package','car-wash-booking-system'),
					'add_new'=>__('Add New','car-wash-booking-system'),
					'add_new_item'=>__('Add New Package','car-wash-booking-system'),
					'edit_item'=>__('Edit Package','car-wash-booking-system'),
					'new_item'=>__('New Package','car-wash-booking-system'),
					'all_items'=>__('Packages','car-wash-booking-system'),
					'view_item'=>__('View Package','car-wash-booking-system'),
					'search_items'=>__('Search Packages','car-wash-booking-system'),
					'not_found'=>__('No Packages Found','car-wash-booking-system'),
					'not_found_in_trash'=>__('No Packages Found in Trash','car-wash-booking-system'), 
					'parent_item_colon'=>'',
					'menu_name'=>__('Packages','car-wash-booking-system')
				),	
				'public'=>false,  
				'show_ui'=>true, 
				'show_in_menu'=>'edit.php?post_type=cbs_booking',
				'capability_type'=>'post',
				'menu_position'=>1,
				'hierarchical'=>false,  
				'rewrite'=>false,  
				'supports'=>array('title','page-attributes')
			)
		);		
		
		add_filter('manage_edit-'.PLUGIN_CBS_CONTEXT.'_package_columns',array($this,'manageEditColumn')); 
		add_action('manage_'.PLUGIN_CBS_CONTEXT.'_package_posts_custom_column',array($this,'manageColumn'));
		add_filter('manage_edit-'.PLUGIN_CBS_CONTEXT.'_package_sortable_columns',array($this,'manageEditSortableColumn'));
		add_filter('postbox_classes_'.PLUGIN_CBS_CONTEXT.'_package_cbs_meta_box_package',array($this,'adminCreateMetaBoxClass'));
		
		add_action('save_post',array($this,'savePost'));
		add_action('add_meta_boxes_'.PLUGIN_CBS_CONTEXT.'_package',array($this,'addMetaBox'));
		
		add_shortcode(PLUGIN_CBS_CONTEXT.'_vehicle_package',array($this,'createPackage'));
	}
	
	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_CBS_CONTEXT.'_meta_box_package',__('General','car-wash-booking-system'),array($this,'addMetaBoxGeneral'),PLUGIN_CBS_CONTEXT.'_package','normal','low');		
	}
		
	/**************************************************************************/
	
	function addMetaBoxGeneral()
	{
		global $post;
		
		$Service=new CBSService();
		$Vehicle=new CBSVehicle();
		$Location=new CBSLocation();
		$TaxRate=new CBSTaxRate();
		
		$data=array();
		
		$data['nonce']=CBSHelper::createNonceField(PLUGIN_CBS_CONTEXT.'_meta_box_package');
		
		$data['dictionary']['service']=$Service->getDictionary();
		$data['dictionary']['vehicle']=$Vehicle->getDictionary();
		$data['dictionary']['location']=$Location->getDictionary();
		$data['dictionary']['taxRate']=$TaxRate->getDictionary();
		
		$data['service']=$this->getPackageService($post->ID);
		
 		$data['detail']=$this->getPackageDetail($post->ID);
		
		$cost=$this->getPackageCost(array('package_id'=>$post->ID));
		
		$data['cost']=isset($cost[$post->ID]) ? $cost[$post->ID] : array();	   
		
		$Template=new CBSTemplate($data,PLUGIN_CBS_TEMPLATE_PATH.'admin/meta_box_package.php');
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
			'name'=>__('Package Name','car-wash-booking-system'),
			'order'=>__('Order','car-wash-booking-system'),
			'service'=>__('Services','car-wash-booking-system'),
			'detail'=>__('Details','car-wash-booking-system'),
		);   
		
		return($column);  
	}  
	
	/**************************************************************************/
	
	function manageEditSortableColumn($column)
	{
		$column['name']='title';
		$column['order']='menu_order';
		$column['service']='title';
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
		
			case 'service':
				
				$data=$this->getPackageInfo($post->ID);
				
				if(count($data['service']))
				{
					$service=array();
					
					foreach($data['service'] as $serviceData)
						$service[$serviceData['service_type']][]='<a href="'.get_edit_post_link($serviceData['service_id']).'">'.esc_html($serviceData['service_name']).'</a>';
						
					if(isset($service[1]))
						echo '<div><b>'.__('Included:','car-wash-booking-system').'</b> '.join(', ',$service[1]).'</div>';
					if(isset($service[2]))
						echo '<div><b>'.__('Related:','car-wash-booking-system').'</b> '.join(', ',$service[2]).'</div>';					
				}
				
			break;
			
			case 'detail':
				
				$data=$this->getPackageInfo($post->ID);

				if(count($data['detail']))
				{
					$html=null;
					$locationIn=array();
					
					$locationCount=array();
					foreach($data['detail'] as $dataValue)
					{
						if(isset($locationCount[$dataValue['location_id']]))
							$locationCount[$dataValue['location_id']]++;
						else $locationCount[$dataValue['location_id']]=1;
					}
					
					foreach($data['detail'] as $dataValue)
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
								<td'.CBSHelper::createCSSClassAttribute($class).'><div>'.CBSPrice::formatToDisplay($dataValue['priceRealNet']).'</div></td>
								<td'.CBSHelper::createCSSClassAttribute($class).'><div>'.$dataValue['duration'].'</div></td>
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
					
					echo $html;
				}
				
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
			'package_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		
		CBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'post_type'=>PLUGIN_CBS_CONTEXT.'_package',
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'orderby'=>array('menu_order'=>'asc','title'=>'asc')
		);
		
		if($attribute['package_id'])
			$argument['p']=$attribute['package_id'];

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
	
	function getPackageServiceDefault()
	{
		$Service=new CBSService();
		
		$default=array();
		$service=$Service->getDictionary();
		
		foreach($service as $serviceId=>$serviceData)
			$default[$serviceId]['service_type']=0;
		
		return($default);
	}
	
	/**************************************************************************/
	
	function getPackageDetailDefault()
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
				$default[$locationId][$vehicleId]['tax_rate']=0;
			}
		}	
		
		return($default);		
	}
	
	/**************************************************************************/
	
	function setPostMetaDefault(&$meta)
	{

	}
	
	/**************************************************************************/
	/**************************************************************************/

	function savePost($postId)
	{
		if(!$_POST) return(false);
		
		if(CBSHelper::checkSavePost($postId,PLUGIN_CBS_CONTEXT.'_meta_box_package_noncename','savePost')===false) return(false);

		/***/
		
		$TaxRate=new CBSTaxRate();
		$Validation=new CBSValidation();
		
		/***/
			
		$service=$this->getPackageServiceDefault();
		
		foreach($service as $serviceId=>$serviceData)
		{
			if(in_array(CBSHelper::getPostValue('service_type_'.$serviceId),array(0,1,2)))
				$service[$serviceId]['service_type']=CBSHelper::getPostValue('service_type_'.$serviceId);
		}
		
		$this->addPackageService($postId,$service);
		
		/***/
		
		$detail=$this->getPackageDetailDefault();
		
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
			}
		}
		
		/***/
		
		$this->addPackageDetail($postId,$detail);
	}

	/**************************************************************************/
	
	function addPackageService($packageId,$service)
	{
		global $wpdb;
		
		$this->removePackageService($packageId);
		
		$query=null;
		
		$Validation=new CBSValidation();
		
		foreach($service as $serviceId=>$serviceData)
		{
			if($Validation->isNotEmpty($query)) $query.=',';
			$query.=$wpdb->prepare('(%d,%d,%d)',$packageId,$serviceId,$serviceData['service_type']);
		}
		
		if($Validation->isEmpty($query)) return;
		
		$query='insert into '.CBSHelper::getMySQLTableName('package_service').' values'.$query;

		$wpdb->query($query);
	}
	
	/**************************************************************************/
	
	function addPackageDetail($packageId,$detail)
	{
		global $wpdb;
		
		$this->removePackageDetail($packageId);
		
		$query=null;
		
		$Validation=new CBSValidation();
		
		foreach($detail as $locationId=>$vehicle)
		{
			foreach($vehicle as $vehicleId=>$detailData)
			{
				if($Validation->isNotEmpty($query)) $query.=',';
				$query.=$wpdb->prepare('(%d,%d,%d,%d,%f,%d)',$packageId,$locationId,$vehicleId,$detailData['enable'],CBSPrice::formatToSave($detailData['price']),$detailData['tax_rate']);
			}
		}
		
		if($Validation->isEmpty($query)) return;
		
		$query='insert into '.CBSHelper::getMySQLTableName('package_detail').' values'.$query;

		$wpdb->query($query);
	}
	
	/**************************************************************************/
	
	function removePackageService($packageId)
	{
		global $wpdb;
		$query=$wpdb->prepare('delete from '.CBSHelper::getMySQLTableName('package_service').' where package_id=%d',$packageId);
		$wpdb->query($query);		
	}
	
	/**************************************************************************/
	
	function removePackageDetail($packageId)
	{
		global $wpdb;
		$query=$wpdb->prepare('delete from '.CBSHelper::getMySQLTableName('package_detail').' where package_id=%d',$packageId);
		$wpdb->query($query);			
	}
	
	/**************************************************************************/
	
	function getPackageService($packageId)
	{
		global $wpdb;
		
		$query=$wpdb->prepare('select * from '.CBSHelper::getMySQLTableName('package_service').' where package_id=%d',$packageId);		
		
		$result=$wpdb->get_results($query);
		$default=$this->getPackageServiceDefault();
		
		foreach($result as $line)
			$default[$line->{'service_id'}]=array('service_type'=>$line->{'service_type'});
		
		return($default);		
	}
	
	/**************************************************************************/
	
	function getPackageDetail($packageId)
	{
		global $wpdb;
		
		$query=$wpdb->prepare('select * from '.CBSHelper::getMySQLTableName('package_detail').' where package_id=%d',$packageId);		
		
		$result=$wpdb->get_results($query);
		$default=$this->getPackageDetailDefault();
		
		foreach($result as $line)
			$default[$line->{'location_id'}][$line->{'vehicle_id'}]=array('enable'=>$line->{'enable'},'price'=>$line->{'price'},'tax_rate'=>$line->{'tax_rate_id'});
		
		return($default);		
	}
	
	/**************************************************************************/
	/**************************************************************************/
	
	function getPackagePublic($attr)
	{
		global $wpdb;

		$package=array();
		
		$default=array
		(
			'package_id'=>0,
			'location_id'=>0,
			'vehicle_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		
		if($attribute['package_id']!=0)
			$dictionary=$this->getDictionary($attribute['package_id']);
		else
			$dictionary=$this->getDictionary();

		/***/
		
		$line=array();
		$query=array();
		$result=array();		
		
		/***/
		
		if($attribute['location_id']!=0)
		{
			$query[0]=$wpdb->prepare('select package_id,count(package_id) as package_count from '.CBSHelper::getMySQLTableName('package_detail').' where location_id=%d group by package_id',$attribute['location_id']);
			$query[1]=$wpdb->prepare('select package_id,count(package_id) as package_count from '.CBSHelper::getMySQLTableName('package_detail').' where location_id=%d and enable=0 group by package_id',$attribute['location_id']);
		}
		
		/***/
		
		if($attribute['vehicle_id']!=0)
		{
			$query[2]=$wpdb->prepare('select package_id from '.CBSHelper::getMySQLTableName('package_detail').' where enable=0 and location_id=%d and vehicle_id=%d',$attribute['location_id'],$attribute['vehicle_id']);
		}
		
		foreach($query as $queryIndex=>$queryData)
			$result[$queryIndex]=$wpdb->get_results($queryData);
			
		/***/

		if(isset($result[0],$result[1]))
		{
			foreach($result[0] as $line[0])
			{
				foreach($result[1] as $line[1])
				{
					if(($line[0]->{'package_id'}==$line[1]->{'package_id'}) && ($line[0]->{'package_count'}==$line[1]->{'package_count'}))
						$package[]=$line[0]->{'package_id'};
				}
			}			
		}
		
		if(isset($result[2]))
		{
			foreach($result[2] as $line[2])
				$package[]=$line[2]->{'package_id'};
		}	
		
		/***/

		foreach($package as $packageValue)
			unset($dictionary[$packageValue]);
		
		/***/
		
		$packageCost=$this->getPackageCost($attribute,true);
		foreach($dictionary as $dictionaryIndex=>$dictionaryValue)
		{
			$dictionary[$dictionaryIndex]['cost']=isset($packageCost[$dictionaryIndex][$attribute['location_id']][$attribute['vehicle_id']]) ? $packageCost[$dictionaryIndex][$attribute['location_id']][$attribute['vehicle_id']] : array();
		}
		
		/***/
		
		$Service=new CBSService();
		$service=$Service->getServicePublic($attribute);
		
		foreach($dictionary as $dictionaryIndex=>$dictionaryValue)
		{
			$query=$wpdb->prepare('select service_id,service_type from '.CBSHelper::getMySQLTableName('package_service').' where package_id=%d and service_type in (1,2) order by field(service_id,'.join(',',array_keys($service)).')',$dictionaryIndex);
			$result=$wpdb->get_results($query);
			
			$dictionary[$dictionaryIndex]['service']=array();
			
			foreach($result as $line)
			{
				if(!array_key_exists($line->{'service_id'},$service)) continue;
				$dictionary[$dictionaryIndex]['service'][$line->{'service_id'}]=array('service_type'=>$line->{'service_type'},'post'=>$service[$line->{'service_id'}]['post']);
			}
			
			$i=0;
			foreach($dictionary[$dictionaryIndex]['service'] as $serviceData)
			{
				if($serviceData['service_type']==1) $i++;
			}
			
			if($i==0) unset($dictionary[$dictionaryIndex]);
		}
		
		return($dictionary);
	}
	
	/**************************************************************************/
	
	function getPackageInfo($packageId)
	{
		global $wpdb;
		
		$data=array('service'=>array(),'detail'=>array());

		$package=$this->getDictionary(array('package_id'=>$packageId));
		if(!isset($package[$packageId])) return($data);	
			
		$cost=$this->getPackageCost(array('package_id'=>$packageId),true);
		$cost=isset($cost[$packageId]) ? $cost[$packageId] : array();

		$Service=new CBSService();
		$Vehicle=new CBSVehicle();
		$Location=new CBSLocation();
		
		$service=$Service->getDictionary();
		$vehicle=$Vehicle->getDictionary();
		$location=$Location->getDictionary();
		
		if(!count($vehicle)) return($data);
		if(!count($location)) return($data);
		
		/***/
		
		if(count($service))
		{
			$query=$wpdb->prepare('select service_id,service_type from '.CBSHelper::getMySQLTableName('package_service').' where service_id in ('.join(',',array_keys($service)).') and service_type in (1,2) and package_id=%d order by field(service_id,'.join(',',array_keys($service)).')',$packageId);
			$result=$wpdb->get_results($query);

			foreach($result as $line)
			{
				if(!isset($service[$line->{'service_id'}])) continue;
				
				$data['service'][$line->{'service_id'}]=array
				(
					'service_id'=>$line->{'service_id'},
					'service_name'=>$service[$line->{'service_id'}]['post']->post_title,
					'service_type'=>$line->{'service_type'}
				);
			}
		}
		
		/***/
		
		$query=$wpdb->prepare('select location_id,vehicle_id,enable,price from '.CBSHelper::getMySQLTableName('package_detail').' where package_id=%d order by field(location_id,0,'.join(',',array_keys($location)).'),field(vehicle_id,0,'.join(',',array_keys($vehicle)).')',$packageId);
		$result=$wpdb->get_results($query);
		
		$detail=array();
		foreach($result as $line)
			$detail[$line->{'location_id'}][$line->{'vehicle_id'}]=$line;
		
		foreach($location as $locationId=>$locationData)
		{
			foreach($vehicle as $vehicleId=>$vehicleData)
			{
				$data['detail'][]=array
				(
					'location_id'=>$locationId,
					'location_name'=>$locationData['post']->post_title,
					'vehicle_id'=>$vehicleId,
					'vehicle_name'=>$vehicleData['post']->post_title,				
					'enable'=>isset($detail[$locationId][$vehicleId]) ? $detail[$locationId][$vehicleId]->{'enable'} : '0',
					'priceReal'=>isset($cost[$locationId][$vehicleId]['priceReal']) ? $cost[$locationId][$vehicleId]['priceReal'] : '0.00',
					'priceRealNet'=>isset($cost[$locationId][$vehicleId]['priceRealNet']) ? $cost[$locationId][$vehicleId]['priceRealNet'] : '0.00',
					'priceCalc'=>isset($cost[$locationId][$vehicleId]['priceCalc']) ? $cost[$locationId][$vehicleId]['priceCalc'] : '0.00',
					'duration'=>isset($cost[$locationId][$vehicleId]['duration']) ? $cost[$locationId][$vehicleId]['duration'] : '0'
				);				
			}
		}

		/***/
		
		return($data);
	}
	
	/**************************************************************************/
	
	function getPackageCost($attr,$calcRealPrice=false)
	{
		global $wpdb;
		
		$cost=array();
		
		$Service=new CBSService();
		
		$service=$Service->getDictionary();
		if(!count($service)) return($cost);
		
		$default=array
		(
			'location_id'=>0,
			'vehicle_id'=>0,
			'package_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		
		/***/
		
		$Vehicle=new CBSVehicle();
		$Package=new CBSPackage();
		$Location=new CBSLocation();
		$TaxRate=new CBSTaxRate();
	
		$location=$Location->getDictionary($attribute);
		if(!count($location)) return($cost);
		
		$vehicle=$Vehicle->getDictionary($attribute);
		if(!count($vehicle)) return($cost);
		
		$package=$Package->getDictionary($attribute);
		if(!count($package)) return($cost);	
		
		/***/
		
		$queryString=array(null,null);
		if($attribute['location_id']!=0)
		{
			$queryString[0].=' and a.location_id='.(int)$attribute['location_id'];
			$queryString[1].=' and a.location_id='.(int)$attribute['location_id'];
		}
		if($attribute['vehicle_id']!=0)
		{
			$queryString[0].=' and a.vehicle_id='.(int)$attribute['vehicle_id'];	
			$queryString[1].=' and a.vehicle_id='.(int)$attribute['vehicle_id'];	
		}
		if($attribute['package_id']!=0) 
		{
			$queryString[0].=' and b.package_id='.(int)$attribute['package_id'];
			$queryString[1].=' and a.package_id='.(int)$attribute['package_id'];
		}
		
		$query='select a.*,b.package_id from '.CBSHelper::getMySQLTableName('service_detail').' a,'.CBSHelper::getMySQLTableName('package_service').' b where a.service_id=b.service_id and a.service_id in ('.join(',',array_keys($service)).') and a.location_id in ('.join(',',array_keys($location)).') and a.vehicle_id in ('.join(',',array_keys($vehicle)).') and b.package_id in ('.join(',',array_keys($package)).') and b.service_type=1'.$queryString[0];
		$result=$wpdb->get_results($query);
		
		foreach($result as $line)
		{
			if(!isset($service[$line->{'service_id'}])) continue;
	
			if($line->{'enable'}==0)
			{
				$price=0.00;
				$duration=0;
				$taxRateId=0;
			}
			else 
			{
				$price=$line->{'price'};
				$duration=$line->{'duration'};
				$taxRateId=$line->{'tax_rate_id'};
				
				if($price==0.00) $price=$service[$line->{'service_id'}]['meta']['base_price'];
				if($duration==0) $duration=$service[$line->{'service_id'}]['meta']['base_duration'];
				if($taxRateId==0)
				{
					if($service[$line->{'service_id'}]['meta']['base_tax_rate']==0)
						$taxRateId=$location[$line->{'location_id'}]['meta']['tax_rate'];
					else
						$taxRateId=$service[$line->{'service_id'}]['meta']['base_tax_rate'];
				}
			}
			
			if(!isset($cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceCalc']))
			{
				$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceCalcNet']=0.00;
				$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceCalc']=0.00;
			}
			
			$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceCalcNet']+=$price;
			$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceCalc']+=$price;
			
			if($taxRateId!=0 && $price>0.00)
			{
				$taxRate=$TaxRate->getDictionary(array('tax_rate_id'=>$taxRateId));
				$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceCalc']+=round($price*($taxRate[$taxRateId]['meta']['rate']/100),2);
			}
				
			if(!isset($cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['duration']))
				$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['duration']=0;				
			$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['duration']+=$duration;
			$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['taxRateValue']=0;
		}
		
		if($calcRealPrice)
		{
			$query='select a.* from '.CBSHelper::getMySQLTableName('package_detail').' a where 1=1 and a.package_id in ('.join(',',array_keys($package)).')'.$queryString[1];
			$result=$wpdb->get_results($query);			
			
			foreach($result as $line)
			{
				if(!isset($cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceReal']))
				{
					$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceRealNet']=0;
					$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceReal']=0;
					$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['isPriceCalculated']=0;
				}
				
				if($line->{'enable'}==0)
				{
					$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['duration']=0;
					$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceRealNet']=0.00;
					$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceReal']=0.00;
					$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['isPriceCalculated']=0;
				}
				elseif($line->{'price'}>0.00)
				{
					$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceRealNet']=$line->{'price'};
					$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceReal']=$line->{'price'};
					$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['isPriceCalculated']=0;
				}
				else
				{
					$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['isPriceCalculated']=1;
					
					if(isset($cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceCalc']))
					{
						$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceRealNet']=$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceCalcNet'];
						$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceReal']=$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceCalc'];
					}
					else
					{
						$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceRealNet']=0.00;
						$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceReal']=0.00;
					}
				}
				
				$taxRateId=$line->{'tax_rate_id'};
				if($taxRateId==0) $taxRateId=$location[$line->{'location_id'}]['meta']['tax_rate'];
				if($taxRateId!=0 && $line->{'price'}>0.00)
				{
					$taxRate=$TaxRate->getDictionary(array('tax_rate_id'=>$taxRateId));
					$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceReal']+=round($cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['priceReal']*($taxRate[$taxRateId]['meta']['rate']/100),2);
					$cost[$line->{'package_id'}][$line->{'location_id'}][$line->{'vehicle_id'}]['taxRateValue']=round($taxRate[$taxRateId]['meta']['rate'],2);
				}
			}
		}
		
		return($cost);
	}
	
	/**************************************************************************/
	
	function createPackage($attr)
	{
		$html=null;
		$Location=new CBSLocation();
		$Validation=new CBSValidation();
		
		$default=array
		(
			'location_id'=>(int)CBSHelper::getPostValue('locationId',false),
			'package_button_url'=>CBSHelper::getPostValue('packageButtonURL',false)
		);
		
		$attribute=shortcode_atts($default,$attr);
		
		if($Validation->isEmpty($attribute['package_button_url'])) return($html);
		
		/***/
		
		$location=$Location->getDictionary($attribute);
		
		if(count($location)!=1) return($html);
		
		$locationId=(int)$attribute['location_id'];		
		
		/***/
		
		$Package=new CBSPackage();
		$Vehicle=new CBSVehicle();
		
		$package=$Package->getPackagePublic($attribute);			
		$vehicle=$Vehicle->getVehiclePublic($attribute,array(),$package);
		
		/***/
		
		$data=array();
		
		$Currency=new CBSCurrency();
		
		$data['id']=CBSHelper::createId('cbs');
		
		$data['locationId']=$attribute['location_id'];
		$data['locationMeta']=$location[$locationId]['meta'];
		
		$data['vehicle']=$vehicle;
		$data['package']=$package;
		
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
		
		$data['packageButtonURL']=$attribute['package_button_url'];

		$data['currencyId']=$location[$locationId]['meta']['currency'];
		$data['currencySymbol']=$Currency->getSymbol($location[$locationId]['meta']['currency']);
		$data['currencySymbolPosition']=$Currency->getSymbolPosition($location[$locationId]['meta']['currency']);
		$data['currencySeparator']=$Currency->getSeparator($location[$locationId]['meta']['currency']);
		
		$data['contentType']=$location[$locationId]['meta']['content_type'];
		
		$Template=new CBSTemplate($data,PLUGIN_CBS_TEMPLATE_PATH.'public/public-vehicle-package.php');
		return($Template->output());
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/