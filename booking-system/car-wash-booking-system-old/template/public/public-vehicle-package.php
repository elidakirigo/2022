<?php
		global $post;
		$Template=new CBSTemplatePublic();
?>
		<div data-package-button-url="<?php echo esc_url($this->data['packageButtonURL']); ?>" <?php CBSHelper::displayCSSClassAttribute('cbs-main','cbs-clear-fix','cbs-template-public-vehicle-package','cbs-location-'.$this->data['locationId'],'cbs-location-content-type-'.$this->data['contentType']); ?> id="<?php echo esc_attr($this->data['id']); ?>">

			
				<ul<?php CBSHelper::displayCSSClassAttribute('cbs-main-list','cbs-clear-fix','cbs-list-reset'); ?>>

				
					<!-- Vehicle -->

					<li<?php CBSHelper::displayCSSClassAttribute('cbs-main-list-item','cbs-main-list-item-vehicle-list','cbs-clear-fix'); ?>>

						<div<?php CBSHelper::displayCSSClassAttribute('cbs-main-list-item-section-content','cbs-clear-fix'); ?>>
<?PHP
		$Template->output('vehicle-list',array
		(
			'vehicle'=>$this->data['vehicle'],
			'vehicleSelected'=>$this->data['vehicleSelected'],
		));
?>
						</div>
					
					</li>

				
					<!-- Package -->
<?php
		if(in_array($this->data['locationMeta']['content_type'],array(2,3)))
		{
			$class=array('cbs-main-list-item','cbs-main-list-item-package-list','cbs-clear-fix');
			if(!count($this->data['package'])) array_push($class,'cbs-state-disable');
?>
					<li<?php CBSHelper::displayCSSClassAttribute($class); ?>>

						<div<?php CBSHelper::displayCSSClassAttribute('cbs-main-list-item-section-content','cbs-clear-fix'); ?>>
<?php
			$Template->output('package-list',array
			(
				'package'=>$this->data['package'],
				'packageButtonURL'=>$this->data['packageButtonURL'],
				'currencySymbol'=>$this->data['currencySymbol'],
				'currencySymbolPosition'=>$this->data['currencySymbolPosition'],
			));
?>
						</div>
						
					</li>
<?php
		}
?>
				</ul>
			
				<div id="cbs-preloader"></div>
				
			
		</div>

		<script type="text/javascript">
			jQuery(document).ready(function($) 
			{
				$('#<?php echo $this->data['id']; ?>').CBSPlugin({locationId:<?php echo $this->data['locationId']; ?>,pageId:<?php echo $post->ID; ?>});
			});
		</script>