<?php
		if(count($this->data['vehicle']))
		{
			$Vehicle=new CBSVehicle();
?>
		<ul<?php CBSHelper::displayCSSClassAttribute('cbs-vehicle-list','cbs-list-reset','cbs-clear-fix'); ?>>
<?php
			foreach($this->data['vehicle'] as $vehicleId=>$vehicleData)
			{
				$class=array();
			
				$class[0]=array('cbs-vehicle-id-'.$vehicleId);
			
				if($this->data['vehicleSelected']==$vehicleId)
					array_push($class[0],'cbs-state-selected');
?>
			<li<?php CBSHelper::displayCSSClassAttribute($class[0]); ?>>
				<div>
					<?php echo $Vehicle->getVehicleIcon($vehicleId,$vehicleData['meta'],'div'); ?>
					<div><?php echo esc_html($vehicleData['post']->post_title); ?></div>
				</div>
			</li>
<?php
			}
?>
		</ul>
<?php
		}