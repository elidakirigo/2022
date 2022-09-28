<?php
		$Price=new CBSPrice();
		$Validation=new CBSValidation();
		if(count($this->data['service']))
		{
?>
		<ul<?php CBSHelper::displayCSSClassAttribute('cbs-service-list','cbs-list-reset','cbs-clear-fix','cbs-state-to-hidden'); ?>>
<?php
			$i=0;
			foreach($this->data['service'] as $serviceId=>$serviceData)
			{
				$class=array('cbs-clear-fix','cbs-service-id-'.$serviceId);
				if(((++$i)>$this->data['serviceVisibleNumber']) && ($this->data['serviceVisibleNumber']!=0)) array_push($class,'cbs-state-to-hidden');
?>
			<li<?php CBSHelper::displayCSSClassAttribute($class); ?>>
				<div<?php CBSHelper::displayCSSClassAttribute('cbs-service-name'); ?>>
					<div<?php CBSHelper::displayCSSClassAttribute('cbs-title-link'); ?>>
						<span><?php esc_html_e($serviceData['post']->post_title); ?></span>
<?php
				if($Validation->isNotEmpty($serviceData['post']->post_content))
				{
?>
						<a<?php CBSHelper::displayCSSClassAttribute('cbs-more-link'); ?> href="#">
							<span<?php ($this->data['serviceDescription'] ? CBSHelper::displayCSSClassAttribute('cbs-state-hidden') : ''); ?>><?php esc_html_e('More...','car-wash-booking-system'); ?></span>
							<span<?php ($this->data['serviceDescription'] ? '' : CBSHelper::displayCSSClassAttribute('cbs-state-hidden')); ?>><?php esc_html_e('Less...','car-wash-booking-system'); ?></span>
						</a>
<?php
				}
?>
					</div>
<?php
				if($Validation->isNotEmpty($serviceData['post']->post_content))
				{
?>
					<div<?php CBSHelper::displayCSSClassAttribute('cbs-more-content'.($this->data['serviceDescription'] ? '' : ' cbs-state-hidden')); ?>>
						<?php echo $serviceData['post']->post_content; ?>
					</div>
<?php
				}
?>
				</div>
				<div<?php CBSHelper::displayCSSClassAttribute('cbs-service-duration'); ?>>
					<span<?php CBSHelper::displayCSSClassAttribute('cbs-meta-icon','cbs-meta-icon-duration'); ?>></span>
					<?php CBSHelper::displayDuration($serviceData['cost']['duration']); ?>
				</div>
				<div<?php CBSHelper::displayCSSClassAttribute('cbs-service-price'); ?>>
					<span<?php CBSHelper::displayCSSClassAttribute('cbs-meta-icon','cbs-meta-icon-price'); ?>></span>
					<?php echo $Price->formatToDisplay2($serviceData['cost']['price'],$this->data['currencyId']); ?>
				</div>
				<div<?php CBSHelper::displayCSSClassAttribute('cbs-button-box'); ?>>
					<a<?php CBSHelper::displayCSSClassAttribute('cbs-button'); ?> href="#"><?php esc_html_e('Select','car-wash-booking-system'); ?></a>
				</div>
			</li>
<?php			
			}
?>
		</ul>
<?php
			if(($i>$this->data['serviceVisibleNumber']) && ($this->data['serviceVisibleNumber']!=0))
			{
?>	
			<a<?php CBSHelper::displayCSSClassAttribute('cbs-button cbs-button-service-more'); ?> href="#">
				<span><?php esc_html_e('More...','car-wash-booking-system'); ?></span>
				<span class="cbs-state-hidden"><?php esc_html_e('Less...','car-wash-booking-system'); ?></span>
			</a>
<?php
			}
		}