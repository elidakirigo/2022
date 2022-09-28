<?php
		if(count($this->data['locationsOptions']))
		{
			if($this->data['locationDisplayMethod']=='blocks')
			{
?>
		<ul<?php CBSHelper::displayCSSClassAttribute('cbs-location-list','cbs-list-reset','cbs-clear-fix'); ?>>
<?php
			foreach($this->data['location'] as $locationId=>$locationData)
			{
				$class=array('cbs-location-id-'.$locationId);
				$enableLocation=(isset($this->data['locationsOptions'][$locationId]['enable']) ? $this->data['locationsOptions'][$locationId]['enable'] : 0);
				$pageLocation=(isset($this->data['locationsOptions'][$locationId]['page']) ? get_permalink($this->data['locationsOptions'][$locationId]['page']) : '#');
				if($this->data['locationId']==$locationId)
				{
					$enableLocation=1;
					array_push($class,'cbs-state-selected');
				}
				if(!$enableLocation)
					continue;
?>
			<li<?php CBSHelper::displayCSSClassAttribute($class); ?>>
				<div>
					<div><?php esc_html_e($locationData['post']->post_title); ?></div>
					<a<?php CBSHelper::displayCSSClassAttribute('cbs-location-url'); ?> href="<?php echo $pageLocation; ?>"><?php esc_html_e('Select','car-wash-booking-system'); ?></a>
				</div>
			</li>
<?php
			}
?>
		</ul>
<?php
			}
			elseif($this->data['locationDisplayMethod']=='drop-down')
			{
?>
		<div<?php CBSHelper::displayCSSClassAttribute('cbs-location-drop-down'); ?>>
			<select>
<?php
				foreach($this->data['location'] as $locationId=>$locationData)
				{
					$selectLocation=0;
					$enableLocation=(isset($this->data['locationsOptions'][$locationId]['enable']) ? $this->data['locationsOptions'][$locationId]['enable'] : 0);
					$pageLocation=(isset($this->data['locationsOptions'][$locationId]['page']) ? get_permalink($this->data['locationsOptions'][$locationId]['page']) : '#');
					if($this->data['locationId']==$locationId)
					{
						$selectLocation=1;
						$pageLocation='';
						$enableLocation=1;
					}
					if(!$enableLocation)
						continue;
?>
				<option value="<?php echo $pageLocation; ?>" <?php echo ($selectLocation ? 'selected' : ''); ?>><?php esc_html_e($locationData['post']->post_title); ?></option>
<?php
				}
?>
			</select>
		</div>
<?php				
			}
		}