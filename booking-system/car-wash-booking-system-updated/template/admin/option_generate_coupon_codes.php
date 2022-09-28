		<ul class="to-form-field-list">
			<li>
				<h5><?php esc_html_e('Generate coupon codes','car-wash-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('To generate multiple coupon codes please fill form below.','car-wash-booking-system'); ?><br/>
				</span>
			</li>
			<li>
				<h5><?php esc_html_e('Location','car-wash-booking-system'); ?></h5>
				<span class="to-legend"><?php esc_html_e('Coupon will be active for selected location.','car-wash-booking-system'); ?></span>
				<div>
<?php
		if(count($this->data['dictionary']['location']))
		{
?>
					<select name="<?php CBSHelper::getFormName('coupon_location'); ?>" id="<?php CBSHelper::getFormName('coupon_location'); ?>">
<?php
			foreach($this->data['dictionary']['location'] as $locationId=>$locationData)
			{
?>
						<option value="<?php echo esc_attr($locationId); ?>"><?php echo esc_html($locationData['post']->post_title); ?></option>		
<?php
			}
?>
					</select>
<?php
		}
?>
				</div>
			</li>
			<li>
				<h5><?php esc_html_e('Count','car-wash-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('How many coupon codes should be generated (Min: 1, Max: 1,000).','car-wash-booking-system'); ?><br/>
				</span>
				<div class="to-clear-fix">
					<input type="text" name="<?php CBSHelper::getFormName('count'); ?>" id="<?php CBSHelper::getFormName('count'); ?>" value="1"/>
				</div>
			</li>
			<li>
				<h5><?php esc_html_e('Usage limit','car-wash-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('How many times the coupon can be used. Leave blank for unlimited.','car-wash-booking-system'); ?><br/>
				</span>
				<div class="to-clear-fix">
					<input type="text" name="<?php CBSHelper::getFormName('usage_limit'); ?>" id="<?php CBSHelper::getFormName('usage_limit'); ?>" value=""/>
				</div>
			</li>
			<li>
				<h5><?php esc_html_e('Discount','car-wash-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('Percentage discount (Min: 0, Max: 100).','car-wash-booking-system'); ?><br/>
				</span>
				<div class="to-clear-fix">
					<input type="text" name="<?php CBSHelper::getFormName('discount'); ?>" id="<?php CBSHelper::getFormName('discount'); ?>" value="0"/>
				</div>
			</li>
			<li>
				<h5><?php esc_html_e('Deduction','car-wash-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('Fixed amount.','car-wash-booking-system'); ?><br/>
				</span>
				<div class="to-clear-fix">
					<input type="text" name="<?php CBSHelper::getFormName('deduction'); ?>" id="<?php CBSHelper::getFormName('deduction'); ?>" value="0"/>
				</div>
			</li>
			<li>
				<h5><?php esc_html_e('Minimal price','car-wash-booking-system'); ?></h5>
				<span class="to-legend"><?php esc_html_e('Note, that coupon won\'t be applied if the total value of the order will be lower than specified.','car-wash-booking-system'); ?></span>
				<div>
					<input type="text" name="<?php CBSHelper::getFormName('minimal_price'); ?>" id="<?php CBSHelper::getFormName('minimal_price'); ?>" value="0" maxlength="12"/>
				</div>
			</li>
			<li>
				<h5><?php esc_html_e('Active from','car-wash-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('Start date in DD-MM-YYYY format. Leave blank for no start date.','car-wash-booking-system'); ?><br/>
				</span>
				<div class="to-clear-fix">
					<input type="text" maxlength="10" class="to-datepicker" value="" name="<?php CBSHelper::getFormName('date_active_start'); ?>" title="<?php esc_attr_e('Enter start date in format DD-MM-YYYY.','car-wash-booking-system'); ?>"/>
				</div>
			</li>
			<li>
				<h5><?php esc_html_e('Active to','car-wash-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('End date in DD-MM-YYYY format. Leave blank for no end date.','car-wash-booking-system'); ?><br/>
				</span>
				<div class="to-clear-fix">
					<input type="text" maxlength="10" class="to-datepicker" value="" name="<?php CBSHelper::getFormName('date_active_stop'); ?>" title="<?php esc_attr_e('Enter end date in format DD-MM-YYYY.','car-wash-booking-system'); ?>"/>
				</div>
			</li>
			<li>
				<input type="button" name="<?php CBSHelper::getFormName('generate_coupon_codes'); ?>" id="<?php CBSHelper::getFormName('generate_coupon_codes'); ?>" class="to-button to-margin-0" value="<?php esc_attr_e('Generate','car-wash-booking-system'); ?>"/>
			</li>
		</ul>
		<script type="text/javascript">
			jQuery(document).ready(function($) 
			{
				$('#<?php CBSHelper::getFormName('generate_coupon_codes'); ?>').bind('click',function(e) 
				{
					e.preventDefault();
					$('#action').val('<?php echo PLUGIN_CBS_CONTEXT.'_option_page_generate_coupon_codes'; ?>');
					$('#to_form').submit();
					$('#action').val('<?php echo PLUGIN_CBS_CONTEXT.'_option_page_save'; ?>');
				});
			});
		</script>