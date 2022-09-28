<?php 
		echo $this->data['nonce']; 
?>	
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-vehicle-1"><?php esc_html_e('General','car-wash-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-vehicle-1">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Icon','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Select an icon for this type of vehicle.','car-wash-booking-system'); ?></span>
							<div>
								<select name="<?php CBSHelper::getFormName('icon'); ?>" id="<?php CBSHelper::getFormName('icon'); ?>">
<?php
		foreach($this->data['dictionary']['icon'] as $iconIndex=>$iconData)
		{
?>
									<option value="<?php echo esc_attr($iconIndex); ?>" <?php CBSHelper::selectedIf($iconIndex,$this->data['meta']['icon']); ?>><?php echo esc_html($iconData['title']); ?></option>
<?php
		}
?>
								</select>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Featured image maximum height','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Maximum height of featured image (image used instead of icon) in pixels.','car-wash-booking-system'); ?></span>
							<div>
								<input type="text" name="<?php CBSHelper::getFormName('icon_image_height'); ?>" id="<?php CBSHelper::getFormName('icon_image_height'); ?>" value="<?php echo esc_attr($this->data['meta']['icon_image_height']); ?>" maxlength="3"/>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Initial fee','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Net value of initial fee for this vehicle.','car-wash-booking-system'); ?></span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Value:','car-wash-booking-system'); ?></span>
								<div>
									<input type="text" name="<?php CBSHelper::getFormName('initial_fee_value'); ?>" id="<?php CBSHelper::getFormName('initial_fee_value'); ?>" value="<?php echo esc_attr($this->data['meta']['initial_fee_value']); ?>"/>
								</div>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Tax rate:','car-wash-booking-system'); ?></span>
								<div class="to-clear-fix">
									<select name="<?php CBSHelper::getFormName('initial_fee_tax_rate'); ?>">
										<option value="0" <?php CBSHelper::selectedIf(0,$this->data['meta']['initial_fee_tax_rate']); ?>><?php esc_html_e('Default','car-wash-booking-system'); ?></option>
<?php
					if(is_array($this->data['dictionary']['taxRate']))
					{
						if(count($this->data['dictionary']['taxRate']))
						{
							foreach($this->data['dictionary']['taxRate'] as $taxRateId=>$taxRateData)
							{
?>
										<option value="<?php echo esc_attr($taxRateId); ?>" <?php CBSHelper::selectedIf($taxRateId,$this->data['meta']['tax_rate']); ?>><?php echo esc_html($taxRateData['post']->post_title); ?></option>		
<?php
							}
						}
					}
?>
									</select>
								</div>
							</div>							
						</li>						
					</ul>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($)
			{	
				$('.to').themeOptionElement({init:true});
				
				$('.dk_options_inner>li').each(function() 
				{
					var link=$(this).children('a:first');
					
					var icon=$(document.createElement('span'));
					var className='cbs-vehicle-icon-'+(link.attr('data-dk-dropdown-value'));
					icon.addClass('cbs-vehicle-icon').addClass(className);
					
					var label=$(document.createElement('span'));
					label.html(link.html());
					
					$(this).children('a:first').html('').append(label).append(icon);
				});
			});
		</script>
