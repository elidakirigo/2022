<?php
		if(count($this->data['package']))
		{
?>
		<ul<?php CBSHelper::displayCSSClassAttribute('cbs-package-list','cbs-list-reset','cbs-clear-fix'); ?>>
<?php
			foreach($this->data['package'] as $packageId=>$packageData)
			{				
?>
			<li<?php CBSHelper::displayCSSClassAttribute('cbs-package-id-'.$packageId); ?>>
				<h5<?php CBSHelper::displayCSSClassAttribute('cbs-package-name'); ?>><?php echo esc_html($packageData['post']->post_title); ?></h5>
				<div<?php CBSHelper::displayCSSClassAttribute('cbs-package-price'); ?>>
<?php
		if($this->data['currencySymbolPosition']=='left')
		{
?>			
					<span<?php CBSHelper::displayCSSClassAttribute('cbs-package-price-currency'); ?>><?php echo $this->data['currencySymbol']; ?></span>
<?php
		}
?>
					<span<?php CBSHelper::displayCSSClassAttribute('cbs-package-price-unit'); ?>><?php echo CBSPrice::getUnity($packageData['cost']['priceReal']); ?></span>
					<span<?php CBSHelper::displayCSSClassAttribute('cbs-package-price-decimal'); ?>><?php echo CBSPrice::getDecimal($packageData['cost']['priceReal']); ?></span>
<?php
		if($this->data['currencySymbolPosition']=='right')
		{
?>			
					<span<?php CBSHelper::displayCSSClassAttribute('cbs-package-price-currency'); ?>><?php echo $this->data['currencySymbol']; ?></span>
<?php
		}
?>
				</div>
				<div<?php CBSHelper::displayCSSClassAttribute('cbs-package-duration'); ?>>
					<span<?php CBSHelper::displayCSSClassAttribute('cbs-meta-icon','cbs-meta-icon-duration'); ?>></span>
					<span><?php CBSHelper::displayDuration($packageData['cost']['duration']); ?></span>
				</div>
				<ul<?php CBSHelper::displayCSSClassAttribute('cbs-package-service-list','cbs-list-reset','cbs-clear-fix'); ?>>
<?php
				foreach($packageData['service'] as $serviceId=>$serviceData)
				{
					if($serviceData['service_type']!=1) continue;
?>
					<li><?php echo esc_html($serviceData['post']->post_title); ?></li>
<?php				
				}
?>
				</ul>
				<div class="cbs-button-box">
					<a<?php CBSHelper::displayCSSClassAttribute('cbs-button'); ?> href="<?php echo (isset($this->data['packageButtonURL']) ? esc_url($this->data['packageButtonURL']) : '#'); ?>"><?php esc_html_e('Book Now','car-wash-booking-system'); ?></a>
				</div>
			</li>
<?php			
			}
?>
		</ul>
<?php
		}