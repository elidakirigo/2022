<?php 
		global $post;
		echo $this->data['nonce']; 
		
		$Date=new CBSDate();
		$Validation=new CBSValidation();
?>	
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-location-1"><?php esc_html_e('General','car-wash-booking-system'); ?></a></li>
					<li><a href="#meta-box-location-2"><?php esc_html_e('Date & time','car-wash-booking-system'); ?></a></li>
					<li><a href="#meta-box-location-3"><?php esc_html_e('Notifications','car-wash-booking-system'); ?></a></li>
					<li><a href="#meta-box-location-4"><?php esc_html_e('Address','car-wash-booking-system'); ?></a></li>
					<li><a href="#meta-box-location-5"><?php esc_html_e('Payments','car-wash-booking-system'); ?></a></li>
					<li><a href="#meta-box-location-7"><?php esc_html_e('Google Calendar','car-wash-booking-system'); ?></a></li>
					<li><a href="#meta-box-location-6"><?php esc_html_e('Colors','car-wash-booking-system'); ?></a></li>					
				</ul>
				<div id="meta-box-location-1">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Shortcode','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('In order to create a new booking system for this location simply copy the shortcode snippet from below and then paste it into the WordPress page or post.','car-wash-booking-system'); ?></span>
							<div class="to-field-disabled"><?php echo '['.PLUGIN_CBS_CONTEXT.'_location location_id="'.$post->ID.'"]'; ?></div>
						</li>
						<li>
							<h5><?php esc_html_e('Currency','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Select currency.','car-wash-booking-system'); ?></span>
							<div>
								<select name="<?php CBSHelper::getFormName('currency'); ?>" id="<?php CBSHelper::getFormName('currency'); ?>">
<?php
		foreach($this->data['dictionary']['currency'] as $currencyIndex=>$currencyData)
		{
?>
									<option value="<?php echo esc_attr($currencyIndex); ?>" <?php CBSHelper::selectedIf($currencyIndex,$this->data['meta']['currency']); ?>><?php echo esc_html($currencyData['name']).' ('.$currencyData['symbol'].')'; ?></option>
<?php		
		}
?>
								</select>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Default tax rate','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Default tax rate.','car-wash-booking-system'); ?></span>
							<div>
								<select  name="<?php CBSHelper::getFormName('tax_rate'); ?>" id="<?php CBSHelper::getFormName('tax_rate'); ?>">
									<option value="0" <?php CBSHelper::selectedIf(0,$this->data['meta']['tax_rate']); ?>><?php esc_html_e('Not Set','car-wash-booking-system'); ?></option>
<?php
		if(count($this->data['dictionary']['tax_rate']))
		{
			foreach($this->data['dictionary']['tax_rate'] as $tax_rateId=>$tax_rateData)
			{
				
?>
									<option value="<?php echo esc_attr($tax_rateId); ?>" <?php CBSHelper::selectedIf($tax_rateId,$this->data['meta']['tax_rate']); ?>><?php echo esc_html($tax_rateData['post']->post_title); ?></option>		
<?php
			}
		}
?>
								</select>
							</div>
						</li>						
						<li>
							<h5><?php esc_html_e('Displaying content','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Specify how services are displayed.','car-wash-booking-system'); ?><br/>
								<?php _e('<b>Services</b>, will display all services and will not display packages.','car-wash-booking-system'); ?><br/>
								<?php _e('<b>Packages</b>, will display packages and related services only.','car-wash-booking-system'); ?><br/>
								<?php _e('<b>Packages and Services</b> will display both packages and all services.','car-wash-booking-system'); ?><br/>
							</span>
							<div class="to-radio-button">
<?php
		foreach($this->data['dictionary']['content_type'] as $content_typeIndex=>$content_typeData)
		{
?>
								<input type="radio" value="<?php echo esc_attr($content_typeIndex); ?>" id="<?php CBSHelper::getFormName('content_type_'.$content_typeIndex); ?>" name="<?php CBSHelper::getFormName('content_type'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['content_type'],$content_typeIndex); ?>/>
								<label for="<?php CBSHelper::getFormName('content_type_'.$content_typeIndex); ?>"><?php echo esc_html($content_typeData[0]); ?></label>							
<?php		
		}
?>
							</div>				
						</li>						
						<li>
							<h5><?php esc_html_e('Enable vehicle type','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Enable or disable first step in booking form.','car-wash-booking-system'); ?></span>
							<div class="to-radio-button">							
								<input type="radio" value="1" id="<?php CBSHelper::getFormName('enable_vehicle_type_1'); ?>" name="<?php CBSHelper::getFormName('enable_vehicle_type'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['enable_vehicle_type'],1); ?>/>
								<label for="<?php CBSHelper::getFormName('enable_vehicle_type_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>
								<input type="radio" value="0" id="<?php CBSHelper::getFormName('enable_vehicle_type_0'); ?>" name="<?php CBSHelper::getFormName('enable_vehicle_type'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['enable_vehicle_type'],0); ?>/>
								<label for="<?php CBSHelper::getFormName('enable_vehicle_type_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>
							</div>
						</li>						
						<li>
							<h5><?php esc_html_e('Default vehicle type','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Vehicle type selected by default on the booking form.','car-wash-booking-system'); ?></span>
							<div>
								<select name="<?php CBSHelper::getFormName('default_vehicle_type'); ?>" id="<?php CBSHelper::getFormName('default_vehicle_type'); ?>">
									<option value="0" <?php CBSHelper::selectedIf(0,$this->data['meta']['default_vehicle_type']); ?>><?php esc_html_e('Select vehicle','car-wash-booking-system'); ?></option>
<?php
		foreach($this->data['dictionary']['vehicle'] as $vehicleIndex=>$vehicleData)
		{
?>
									<option value="<?php echo esc_attr($vehicleIndex); ?>" <?php CBSHelper::selectedIf($vehicleIndex,$this->data['meta']['default_vehicle_type']); ?>><?php echo esc_html($vehicleData['post']->post_title); ?></option>
<?php		
		}
?>
								</select>
							</div>
						</li>						
						<li>
							<h5><?php esc_html_e('Number of slots','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('The number of slots (car wash posts) in which services can be provided.','car-wash-booking-system'); ?></span>
							<div>
								<input type="text" maxlength="3" name="<?php CBSHelper::getFormName('slot_number'); ?>" id="<?php CBSHelper::getFormName('slot_number'); ?>" value="<?php echo esc_attr($this->data['meta']['slot_number']); ?>"/>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Number of time slots to display','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Specify how many time slots will be shown in calendar when the page first loads with "Show More" button at the bottom of the list. Enter "0" to display all time slots by default.','car-wash-booking-system'); ?></span>
							<div>
								<input type="text" maxlength="3" name="<?php CBSHelper::getFormName('hour_visible_number'); ?>" id="<?php CBSHelper::getFormName('hour_visible_number'); ?>" value="<?php echo esc_attr($this->data['meta']['hour_visible_number']); ?>"/>
							</div>
						</li>	
						<li>
							<h5><?php esc_html_e('Number of services to display','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Specify how many services will be shown when the page first loads with "Show More" button at the bottom of the list. Enter "0" to display all services by default.','car-wash-booking-system'); ?></span>
							<div>
								<input type="text" maxlength="3" name="<?php CBSHelper::getFormName('service_visible_number'); ?>" id="<?php CBSHelper::getFormName('service_visible_number'); ?>" value="<?php echo esc_attr($this->data['meta']['service_visible_number']); ?>"/>
							</div>
						</li>						
						<li>
							<h5><?php esc_html_e('Reset form','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enable or disable resetting (clearing) form values after successful submission.','car-wash-booking-system'); ?>
							</span>
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php CBSHelper::getFormName('reset_form_enable_1'); ?>" name="<?php CBSHelper::getFormName('reset_form_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['reset_form_enable'],1); ?>/>
								<label for="<?php CBSHelper::getFormName('reset_form_enable_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>							
								<input type="radio" value="0" id="<?php CBSHelper::getFormName('reset_form_enable_0'); ?>" name="<?php CBSHelper::getFormName('reset_form_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['reset_form_enable'],0); ?>/>
								<label for="<?php CBSHelper::getFormName('reset_form_enable_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>							
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Service description','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Enable or disable default visibility of service description.','car-wash-booking-system'); ?></span>
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php CBSHelper::getFormName('service_description_1'); ?>" name="<?php CBSHelper::getFormName('service_description'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['service_description'],1); ?>/>
								<label for="<?php CBSHelper::getFormName('service_description_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>
								<input type="radio" value="0" id="<?php CBSHelper::getFormName('service_description_0'); ?>" name="<?php CBSHelper::getFormName('service_description'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['service_description'],0); ?>/>
								<label for="<?php CBSHelper::getFormName('service_description_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>					
							</div>
						</li>					
						<li>
							<h5><?php esc_html_e('Customer address','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Collect customer address details. Visibility of specific fields can be controlled in "Form Fields" section located below.','car-wash-booking-system'); ?>
							</span>
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php CBSHelper::getFormName('client_address_enable_1'); ?>" name="<?php CBSHelper::getFormName('client_address_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['client_address_enable'],1); ?>/>
								<label for="<?php CBSHelper::getFormName('client_address_enable_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>							
								<input type="radio" value="0" id="<?php CBSHelper::getFormName('client_address_enable_0'); ?>" name="<?php CBSHelper::getFormName('client_address_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['client_address_enable'],0); ?>/>
								<label for="<?php CBSHelper::getFormName('client_address_enable_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>							
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Customer logging','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enable or disable customer login/register functionality.','car-wash-booking-system'); ?>
							</span>
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php CBSHelper::getFormName('enable_logging_1'); ?>" name="<?php CBSHelper::getFormName('enable_logging'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['enable_logging'],1); ?>/>
								<label for="<?php CBSHelper::getFormName('enable_logging_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>							
								<input type="radio" value="0" id="<?php CBSHelper::getFormName('enable_logging_0'); ?>" name="<?php CBSHelper::getFormName('enable_logging'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['enable_logging'],0); ?>/>
								<label for="<?php CBSHelper::getFormName('enable_logging_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>							
							</div>
						</li>						
						<li>
							<h5><?php esc_html_e('Coupons','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enable or disable coupon codes feature.','car-wash-booking-system'); ?>
							</span>
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php CBSHelper::getFormName('enable_coupons_1'); ?>" name="<?php CBSHelper::getFormName('enable_coupons'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['enable_coupons'],1); ?>/>
								<label for="<?php CBSHelper::getFormName('enable_coupons_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>							
								<input type="radio" value="0" id="<?php CBSHelper::getFormName('enable_coupons_0'); ?>" name="<?php CBSHelper::getFormName('enable_coupons'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['enable_coupons'],0); ?>/>
								<label for="<?php CBSHelper::getFormName('enable_coupons_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>							
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('WooCommerce','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enable or disable manage bookings and payments by WooCommerce plugin.','car-wash-booking-system'); ?>
							</span>
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php CBSHelper::getFormName('woocommerce_enable_1'); ?>" name="<?php CBSHelper::getFormName('woocommerce_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['woocommerce_enable'],1); ?>/>
								<label for="<?php CBSHelper::getFormName('woocommerce_enable_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>							
								<input type="radio" value="0" id="<?php CBSHelper::getFormName('woocommerce_enable_0'); ?>" name="<?php CBSHelper::getFormName('woocommerce_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['woocommerce_enable'],0); ?>/>
								<label for="<?php CBSHelper::getFormName('woocommerce_enable_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>							
							</div>
						</li>						
						<li>
							<h5><?php esc_html_e('Single step','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Enable or disable displaying only one booking step at a time.','car-wash-booking-system'); ?></span>
							<div class="to-radio-button">							
								<input type="radio" value="1" id="<?php CBSHelper::getFormName('steps_1'); ?>" name="<?php CBSHelper::getFormName('steps'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['steps'],1); ?>/>
								<label for="<?php CBSHelper::getFormName('steps_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>
								<input type="radio" value="0" id="<?php CBSHelper::getFormName('steps_0'); ?>" name="<?php CBSHelper::getFormName('steps'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['steps'],0); ?>/>
								<label for="<?php CBSHelper::getFormName('steps_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Scroll to next step','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Allows to automatically scroll window to next step, when the user makes a selection.','car-wash-booking-system'); ?></span>
							<div class="to-radio-button">							
								<input type="radio" value="1" id="<?php CBSHelper::getFormName('scroll_to_next_step_1'); ?>" name="<?php CBSHelper::getFormName('scroll_to_next_step'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['scroll_to_next_step'],1); ?>/>
								<label for="<?php CBSHelper::getFormName('scroll_to_next_step_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>
								<input type="radio" value="0" id="<?php CBSHelper::getFormName('scroll_to_next_step_0'); ?>" name="<?php CBSHelper::getFormName('scroll_to_next_step'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['scroll_to_next_step'],0); ?>/>
								<label for="<?php CBSHelper::getFormName('scroll_to_next_step_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Summary text','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Summary text (displayed above "Submit" button).','car-wash-booking-system'); ?></span>
							<div>
								<textarea cols="1" rows="0" name="<?php CBSHelper::getFormName('text_1'); ?>" id="<?php CBSHelper::getFormName('text_1'); ?>" ><?php echo nl2br(esc_html($this->data['meta']['text_1'])); ?></textarea>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Service locations','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Places where the service can be provided (one location per line).','car-wash-booking-system'); ?></span>
							<div>
								<textarea cols="1" rows="0" name="<?php CBSHelper::getFormName('service_location'); ?>" id="<?php CBSHelper::getFormName('service_location'); ?>" ><?php echo (esc_html(implode(chr(10),$this->data['meta']['service_location']))); ?></textarea>
							</div>
						</li>						
						<li>
							<h5><?php esc_html_e('Location Step','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Location step settings.','car-wash-booking-system'); ?></span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Enable location step.','car-wash-booking-system'); ?></span>
								<div class="to-radio-button">							
									<input type="radio" value="1" id="<?php CBSHelper::getFormName('enable_location_step_1'); ?>" name="<?php CBSHelper::getFormName('enable_location_step'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['enable_location_step'],1); ?>/>
									<label for="<?php CBSHelper::getFormName('enable_location_step_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php CBSHelper::getFormName('enable_location_step_0'); ?>" name="<?php CBSHelper::getFormName('enable_location_step'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['enable_location_step'],0); ?>/>
									<label for="<?php CBSHelper::getFormName('enable_location_step_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>
								</div>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Display method.','car-wash-booking-system'); ?></span>
								<div>
									<select name="<?php CBSHelper::getFormName('location_display_method'); ?>" id="<?php CBSHelper::getFormName('location_display_method'); ?>">
										<option value="blocks" <?php CBSHelper::selectedIf('blocks',$this->data['meta']['location_display_method']); ?>><?php esc_html_e('Blocks','car-wash-booking-system'); ?></option>
										<option value="drop-down" <?php CBSHelper::selectedIf('drop-down',$this->data['meta']['location_display_method']); ?>><?php esc_html_e('Drop-down list','car-wash-booking-system'); ?></option>
									</select>
								</div>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Locations options.','car-wash-booking-system'); ?></span>
								<table class="to-table">
									<thead>
										<tr>
											<th width="40%">
												<div>
													<?php esc_html_e('Location','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Location.','car-wash-booking-system'); ?></span>
												</div>
											</th>
											<th width="30%">
												<div>
													<?php esc_html_e('Location Status','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Whether location is visible or not.','car-wash-booking-system'); ?></span>
												</div>
											</th>
											<th width="30%">
												<div>
													<?php esc_html_e('Location Page','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('ID of the page that contains location booking form.','car-wash-booking-system'); ?></span>
												</div>
											</th>
										</tr>
									</thead>
									<tbody>
<?php
foreach($this->data['dictionary']['location'] as $locationIndex=>$locationData)
{
	if($locationIndex==get_the_ID()) continue;
	$locationEnable=(isset($this->data['meta']['locations_options'][$locationIndex]['enable']) ? $this->data['meta']['locations_options'][$locationIndex]['enable'] : 0);
	$locationPage=(isset($this->data['meta']['locations_options'][$locationIndex]['page']) ? $this->data['meta']['locations_options'][$locationIndex]['page'] : '');
?>
										<tr>
											<td>
												<div>
													<?php esc_html_e($locationData['post']->post_title); ?>
												</div>
											</td>
											<td>
												<div class="to-clear-fix">
													<div class="to-radio-button">
														<input type="radio" value="1" id="<?php CBSHelper::getFormName('locations_options_'.$locationIndex.'_enable_1'); ?>" name="<?php CBSHelper::getFormName('locations_options['.$locationIndex.'][enable]'); ?>" <?php CBSHelper::checkedIf($locationEnable,1); ?>/>
														<label for="<?php CBSHelper::getFormName('locations_options_'.$locationIndex.'_enable_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>
														<input type="radio" value="0" id="<?php CBSHelper::getFormName('locations_options_'.$locationIndex.'_enable_0'); ?>" name="<?php CBSHelper::getFormName('locations_options['.$locationIndex.'][enable]'); ?>" <?php CBSHelper::checkedIf($locationEnable,0); ?>/>
														<label for="<?php CBSHelper::getFormName('locations_options_'.$locationIndex.'_enable_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>
													</div>
												</div>
											</td>
											<td>
												<div>
													<input type="text" name="<?php CBSHelper::getFormName('locations_options['.$locationIndex.'][page]'); ?>" id="<?php CBSHelper::getFormName('locations_options_'.$locationData['post']->ID.'_page'); ?>" value="<?php esc_attr_e($locationPage); ?>"/>
												</div>
											</td>
										</tr>
<?php
}
?>
									</tbody>
								</table>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Form Fields','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Specify which form fields should be visible.','car-wash-booking-system'); ?><br/>						
							</span>
							<div class="to-overflow-y">
								<table class="to-table">
									<thead>
										<tr>
											<th width="50%">
												<div>
													<?php esc_html_e('Form Field','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Form field.','car-wash-booking-system'); ?></span>
												</div>
											</th>
											<th width="50%">
												<div>
													<?php esc_html_e('Field Status','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Whether field is visible or not.','car-wash-booking-system'); ?></span>
												</div>
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<div>
													<?php esc_html_e('Company name','car-wash-booking-system'); ?>
												</div>
											</td>
											<td>
												<div class="to-clear-fix">
													<div class="to-checkbox-button">
														<input type="radio" value="1" id="<?php CBSHelper::getFormName('client_company_name_enable_1'); ?>" name="<?php CBSHelper::getFormName('client_company_name_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['client_company_name_enable'],1); ?>/>
														<label for="<?php CBSHelper::getFormName('client_company_name_enable_1'); ?>"><?php esc_html_e('Enabled','car-wash-booking-system'); ?></label>
														<input type="radio" value="0" id="<?php CBSHelper::getFormName('client_company_name_enable_0'); ?>" name="<?php CBSHelper::getFormName('client_company_name_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['client_company_name_enable'],0); ?>/>
														<label for="<?php CBSHelper::getFormName('client_company_name_enable_0'); ?>"><?php esc_html_e('Disabled','car-wash-booking-system'); ?></label>
													</div>
												</div>
											</td>
										</tr>	
										<tr>
											<td>
												<div>
													<?php esc_html_e('Street','car-wash-booking-system'); ?>
												</div>
											</td>
											<td>
												<div class="to-clear-fix">
													<div class="to-checkbox-button">
														<input type="radio" value="1" id="<?php CBSHelper::getFormName('client_address_street_enable_1'); ?>" name="<?php CBSHelper::getFormName('client_address_street_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['client_address_street_enable'],1); ?>/>
														<label for="<?php CBSHelper::getFormName('client_address_street_enable_1'); ?>"><?php esc_html_e('Enabled','car-wash-booking-system'); ?></label>
														<input type="radio" value="0" id="<?php CBSHelper::getFormName('client_address_street_enable_0'); ?>" name="<?php CBSHelper::getFormName('client_address_street_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['client_address_street_enable'],0); ?>/>
														<label for="<?php CBSHelper::getFormName('client_address_street_enable_0'); ?>"><?php esc_html_e('Disabled','car-wash-booking-system'); ?></label>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td>
												<div>
													<?php esc_html_e('ZIP Code','car-wash-booking-system'); ?>
												</div>
											</td>
											<td>
												<div class="to-clear-fix">
													<div class="to-checkbox-button">
														<input type="radio" value="1" id="<?php CBSHelper::getFormName('client_address_post_code_enable_1'); ?>" name="<?php CBSHelper::getFormName('client_address_post_code_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['client_address_post_code_enable'],1); ?>/>
														<label for="<?php CBSHelper::getFormName('client_address_post_code_enable_1'); ?>"><?php esc_html_e('Enabled','car-wash-booking-system'); ?></label>
														<input type="radio" value="0" id="<?php CBSHelper::getFormName('client_address_post_code_enable_0'); ?>" name="<?php CBSHelper::getFormName('client_address_post_code_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['client_address_post_code_enable'],0); ?>/>
														<label for="<?php CBSHelper::getFormName('client_address_post_code_enable_0'); ?>"><?php esc_html_e('Disabled','car-wash-booking-system'); ?></label>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td>
												<div>
													<?php esc_html_e('City','car-wash-booking-system'); ?>
												</div>
											</td>
											<td>
												<div class="to-clear-fix">
													<div class="to-checkbox-button">
														<input type="radio" value="1" id="<?php CBSHelper::getFormName('client_address_city_enable_1'); ?>" name="<?php CBSHelper::getFormName('client_address_city_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['client_address_city_enable'],1); ?>/>
														<label for="<?php CBSHelper::getFormName('client_address_city_enable_1'); ?>"><?php esc_html_e('Enabled','car-wash-booking-system'); ?></label>
														<input type="radio" value="0" id="<?php CBSHelper::getFormName('client_address_city_enable_0'); ?>" name="<?php CBSHelper::getFormName('client_address_city_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['client_address_city_enable'],0); ?>/>
														<label for="<?php CBSHelper::getFormName('client_address_city_enable_0'); ?>"><?php esc_html_e('Disabled','car-wash-booking-system'); ?></label>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td>
												<div>
													<?php esc_html_e('State','car-wash-booking-system'); ?>
												</div>
											</td>
											<td>
												<div class="to-clear-fix">
													<div class="to-checkbox-button">
														<input type="radio" value="1" id="<?php CBSHelper::getFormName('client_address_state_enable_1'); ?>" name="<?php CBSHelper::getFormName('client_address_state_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['client_address_state_enable'],1); ?>/>
														<label for="<?php CBSHelper::getFormName('client_address_state_enable_1'); ?>"><?php esc_html_e('Enabled','car-wash-booking-system'); ?></label>
														<input type="radio" value="0" id="<?php CBSHelper::getFormName('client_address_state_enable_0'); ?>" name="<?php CBSHelper::getFormName('client_address_state_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['client_address_state_enable'],0); ?>/>
														<label for="<?php CBSHelper::getFormName('client_address_state_enable_0'); ?>"><?php esc_html_e('Disabled','car-wash-booking-system'); ?></label>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td>
												<div>
													<?php esc_html_e('Country','car-wash-booking-system'); ?>
												</div>
											</td>
											<td>
												<div class="to-clear-fix">
													<div class="to-checkbox-button">
														<input type="radio" value="1" id="<?php CBSHelper::getFormName('client_address_country_enable_1'); ?>" name="<?php CBSHelper::getFormName('client_address_country_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['client_address_country_enable'],1); ?>/>
														<label for="<?php CBSHelper::getFormName('client_address_country_enable_1'); ?>"><?php esc_html_e('Enabled','car-wash-booking-system'); ?></label>
														<input type="radio" value="0" id="<?php CBSHelper::getFormName('client_address_country_enable_0'); ?>" name="<?php CBSHelper::getFormName('client_address_country_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['client_address_country_enable'],0); ?>/>
														<label for="<?php CBSHelper::getFormName('client_address_country_enable_0'); ?>"><?php esc_html_e('Disabled','car-wash-booking-system'); ?></label>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td>
												<div>
													<?php esc_html_e('Message','car-wash-booking-system'); ?>
												</div>
											</td>
											<td>
												<div class="to-clear-fix">
													<div class="to-checkbox-button">
														<input type="radio" value="1" id="<?php CBSHelper::getFormName('client_message_enable_1'); ?>" name="<?php CBSHelper::getFormName('client_message_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['client_message_enable'],1); ?>/>
														<label for="<?php CBSHelper::getFormName('client_message_enable_1'); ?>"><?php esc_html_e('Enabled','car-wash-booking-system'); ?></label>
														<input type="radio" value="0" id="<?php CBSHelper::getFormName('client_message_enable_0'); ?>" name="<?php CBSHelper::getFormName('client_message_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['client_message_enable'],0); ?>/>
														<label for="<?php CBSHelper::getFormName('client_message_enable_0'); ?>"><?php esc_html_e('Disabled','car-wash-booking-system'); ?></label>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td>
												<div>
													<?php esc_html_e('Gratuity','car-wash-booking-system'); ?>
												</div>
											</td>
											<td>
												<div class="to-clear-fix">
													<div class="to-checkbox-button">
														<input type="radio" value="1" id="<?php CBSHelper::getFormName('gratuity_enable_1'); ?>" name="<?php CBSHelper::getFormName('gratuity_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['gratuity_enable'],1); ?>/>
														<label for="<?php CBSHelper::getFormName('gratuity_enable_1'); ?>"><?php esc_html_e('Enabled','car-wash-booking-system'); ?></label>
														<input type="radio" value="0" id="<?php CBSHelper::getFormName('gratuity_enable_0'); ?>" name="<?php CBSHelper::getFormName('gratuity_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['gratuity_enable'],0); ?>/>
														<label for="<?php CBSHelper::getFormName('gratuity_enable_0'); ?>"><?php esc_html_e('Disabled','car-wash-booking-system'); ?></label>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td>
												<div>
													<?php esc_html_e('Service location','car-wash-booking-system'); ?>
												</div>
											</td>
											<td>
												<div class="to-clear-fix">
													<div class="to-checkbox-button">
														<input type="radio" value="1" id="<?php CBSHelper::getFormName('service_location_enable_1'); ?>" name="<?php CBSHelper::getFormName('service_location_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['service_location_enable'],1); ?>/>
														<label for="<?php CBSHelper::getFormName('service_location_enable_1'); ?>"><?php esc_html_e('Enabled','car-wash-booking-system'); ?></label>
														<input type="radio" value="0" id="<?php CBSHelper::getFormName('service_location_enable_0'); ?>" name="<?php CBSHelper::getFormName('service_location_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['service_location_enable'],0); ?>/>
														<label for="<?php CBSHelper::getFormName('service_location_enable_0'); ?>"><?php esc_html_e('Disabled','car-wash-booking-system'); ?></label>
													</div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>	
						</li>
						<li>
							<h5><?php esc_html_e('Agreements','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Table includes list of agreements needed to accept by customer before sending the booking.','car-wash-booking-system'); ?><br/>
								<?php esc_html_e('Each agreement consists of approval field (checkbox) and text of agreement.','car-wash-booking-system'); ?>
							</span>
							<div class="to-clear-fix">
								<table class="to-table" id="to-table-form-element-agreement">
									<tr>
										<th style="width:85%">
											<div>
												<?php esc_html_e('Text','car-wash-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Text of the agreement.','car-wash-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:15%">
											<div>
												<?php esc_html_e('Remove','car-wash-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Remove this entry.','car-wash-booking-system'); ?>
												</span>
											</div>
										</th>
									</tr>
									<tr class="to-hidden">
										<td>
											<div>
												<input type="hidden" name="<?php CBSHelper::getFormName('form_agreement[id][]'); ?>"/>
												<input type="text" name="<?php CBSHelper::getFormName('form_agreement[text][]'); ?>" title="<?php esc_attr_e('Enter text.','car-wash-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-wash-booking-system'); ?></a>
											</div>
										</td>										
									</tr>
<?php
		if(isset($this->data['meta']['form_agreement']))
		{
			foreach($this->data['meta']['form_agreement'] as $agreementValue)
			{
?>
									<tr>
										<td>
											<div>
												<input type="hidden" value="<?php echo esc_attr($agreementValue['id']); ?>" name="<?php CBSHelper::getFormName('form_agreement[id][]'); ?>"/>
												<input type="text" value="<?php echo esc_attr($agreementValue['text']); ?>" name="<?php CBSHelper::getFormName('form_agreement[text][]'); ?>" title="<?php esc_attr_e('Enter text.','car-wash-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-wash-booking-system'); ?></a>
											</div>
										</td>										
									</tr>							   
<?php
			}
		}
?>
								</table>
								<div> 
									<a href="#" class="to-table-button-add"><?php esc_html_e('Add','car-wash-booking-system'); ?></a>
								</div>
							</div>				
						</li>
					</ul>
				</div>
				<div id="meta-box-location-2">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Business hours','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Specify working days / hours (in HH:MM time format).','car-wash-booking-system'); ?></span>
							<div>
								<table class="to-table">
									<tr>
										<th style="width:20%">
											<div>
												<?php esc_html_e('Weekday','car-wash-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Day of the week.','car-wash-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:25%">
											<div>
												<?php esc_html_e('Start Time','car-wash-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Start time in HH:MM time format.','car-wash-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:25%">
											<div>
												<?php esc_html_e('End Time','car-wash-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('End time in HH:MM time format.','car-wash-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:30%">
											<div>
												<?php esc_html_e('Breaks','car-wash-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Span hours (in format HH:MM-HH:MM) separated by semicolon. E.g: 09:00-11:00;14:00-15:00.','car-wash-booking-system'); ?>
												</span>
											</div>
										</th>
									</tr>
<?php
		for($i=1;$i<8;$i++)
		{
			$breakHour=null;
			if(isset($this->data['meta']['break_hour'][$i]))
			{
				foreach($this->data['meta']['break_hour'][$i] as $index=>$value)
				{
					if($Validation->isNotEmpty($breakHour)) $breakHour.=';';
					$breakHour.=$value['start'].'-'.$value['stop'];
				}
			}
?>
									<tr>
										<td>
											<div><?php echo $Date->getDayName($i); ?></div>
										</td>
										<td>
											<div>
												<input type="text" class="to-timepicker" maxlength="5" name="<?php CBSHelper::getFormName('business_hour_'.$i.'_start'); ?>" id="<?php CBSHelper::getFormName('business_hour_'.$i.'_start'); ?>" value="<?php echo esc_attr($this->data['meta']['business_hour'][$i]['start']); ?>" title="<?php esc_attr_e('Enter start time in format HH:MM.','car-wash-booking-system'); ?>"/>
											</div>
										</td>
										<td>
											<div>								
												<input type="text" class="to-timepicker" maxlength="5" name="<?php CBSHelper::getFormName('business_hour_'.$i.'_stop'); ?>" id="<?php CBSHelper::getFormName('business_hour_'.$i.'_stop'); ?>" value="<?php echo esc_attr($this->data['meta']['business_hour'][$i]['stop']); ?>" title="<?php esc_attr_e('Enter end time in format HH:MM.','car-wash-booking-system'); ?>"/>
											</div>
										</td>
										<td>
											<div>	
												<input type="text" name="<?php CBSHelper::getFormName('break_hour_'.$i); ?>" id="<?php CBSHelper::getFormName('break_hour_'.$i); ?>" value="<?php echo esc_attr($breakHour); ?>" title="<?php esc_attr_e('Enter end time in format HH:MM.','car-wash-booking-system'); ?>"/>
											</div>
										</td>
									</tr>
<?php
		}
?>
								</table>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Exclude dates','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Specify dates not available for booking. Past (or invalid date ranges) will be removed when saving.','car-wash-booking-system'); ?></span>
							<div>	
								<table class="to-table" id="to-table-date-exclude">
									<tr>
										<th style="width:20%">
											<div>
												<?php esc_html_e('Start Date','car-wash-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Start date in DD-MM-YYYY format.','car-wash-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:20%">
											<div>
												<?php esc_html_e('Start Time','car-wash-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Start time in HH:MM format.','car-wash-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:20%">
											<div>
												<?php esc_html_e('End Date','car-wash-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('End date in DD-MM-YYYY format.','car-wash-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:20%">
											<div>
												<?php esc_html_e('End Time','car-wash-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('End time in HH:MM format.','car-wash-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:20%">
											<div>
												<?php esc_html_e('Remove','car-wash-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Remove this entry.','car-wash-booking-system'); ?>
												</span>
											</div>
										</th>
									</tr>
									<tr class="to-hidden">
										<td>
											<div>
												<input type="text" maxlength="10" class="to-datepicker" name="<?php CBSHelper::getFormName('date_exclude_start[]'); ?>" title="<?php esc_attr_e('Enter start date in format DD-MM-YYYY.','car-wash-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="5" class="to-timepicker" name="<?php CBSHelper::getFormName('time_exclude_start[]'); ?>" title="<?php esc_attr_e('Enter start time in format HH:MM.','car-wash-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="10" class="to-datepicker" name="<?php CBSHelper::getFormName('date_exclude_stop[]'); ?>" title="<?php esc_attr_e('Enter stop date in format DD-MM-YYYY.','car-wash-booking-system'); ?>"/>
											</div>									
										</td>	
										<td>
											<div>
												<input type="text" maxlength="5" class="to-timepicker" name="<?php CBSHelper::getFormName('time_exclude_stop[]'); ?>" title="<?php esc_attr_e('Enter stop time in format HH:MM.','car-wash-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-wash-booking-system'); ?></a>
											</div>
										</td>
									</tr>
<?php
		if(count($this->data['meta']['date_exclude']))
		{
			foreach($this->data['meta']['date_exclude'] as $dateExcludeIndex=>$dateExcludeValue)
			{
?>
									<tr>
										<td>
											<div>
												<input type="text" maxlength="10" class="to-datepicker" value="<?php echo esc_attr($Date->reverse($dateExcludeValue['start'])); ?>" name="<?php CBSHelper::getFormName('date_exclude_start[]'); ?>" title="<?php esc_attr_e('Enter start date in format DD-MM-YYYY.','car-wash-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="5" class="to-timepicker" value="<?php echo esc_attr($dateExcludeValue['time_start']); ?>" name="<?php CBSHelper::getFormName('time_exclude_start[]'); ?>" title="<?php esc_attr_e('Enter start time in format HH:MM.','car-wash-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="10" class="to-datepicker" value="<?php echo esc_attr($Date->reverse($dateExcludeValue['stop'])); ?>" name="<?php CBSHelper::getFormName('date_exclude_stop[]'); ?>" title="<?php esc_attr_e('Enter stop date in format DD-MM-YYYY.','car-wash-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="5" class="to-timepicker" value="<?php echo esc_attr($dateExcludeValue['time_stop']); ?>" name="<?php CBSHelper::getFormName('time_exclude_stop[]'); ?>" title="<?php esc_attr_e('Enter stop time in format HH:MM.','car-wash-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-wash-booking-system'); ?></a>
											</div>
										</td>
									</tr>							
<?php
			}
		}
?>
								</table>
								<div> 
									<a href="#" class="to-table-button-add"><?php esc_html_e('Add','car-wash-booking-system'); ?></a>
								</div>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Time format','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Select the time format to be displayed in calendar.','car-wash-booking-system'); ?></span>
							<div class="to-radio-button">
<?php
		foreach($Date->timeFormat as $timeFormatIndex=>$timeFormatData)
		{
?>
								<input type="radio" value="<?php echo esc_attr($timeFormatIndex); ?>" id="<?php CBSHelper::getFormName('booking_time_format_'.$timeFormatIndex); ?>" name="<?php CBSHelper::getFormName('booking_time_format'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['booking_time_format'],$timeFormatIndex); ?>/>
								<label for="<?php CBSHelper::getFormName('booking_time_format_'.$timeFormatIndex); ?>"><?php echo esc_html($timeFormatData[0]); ?></label>							
<?php
		}
?>
							</div>
						</li>	
						<li>
							<h5><?php esc_html_e('Date format','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php echo sprintf(esc_html('Select the date format to be displayed in summary. More info you can find here %s.','car-wash-booking-system'),'<a href="https://codex.wordpress.org/Formatting_Date_and_Time">Formatting Date and Time</a>'); ?></span>
							<div>
								<input type="text" maxlength="255" name="<?php CBSHelper::getFormName('booking_date_format'); ?>" id="<?php CBSHelper::getFormName('booking_date_format'); ?>" value="<?php echo esc_attr($this->data['meta']['booking_date_format']); ?>"/>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Booking slot size','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Value in minutes, e.g. 30 min slots will show open slots at 8:00, 8:30, 9:00 etc.','car-wash-booking-system'); ?></span>
							<div>
								<input type="text" maxlength="3" name="<?php CBSHelper::getFormName('booking_time_interval'); ?>" id="<?php CBSHelper::getFormName('booking_time_interval'); ?>" value="<?php echo esc_attr($this->data['meta']['booking_time_interval']); ?>"/>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Advance booking period','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Allow booking up to this number of days in advance.','car-wash-booking-system'); ?></span>
							<div>
								<input type="text" maxlength="3" name="<?php CBSHelper::getFormName('booking_day_count'); ?>" id="<?php CBSHelper::getFormName('booking_day_count'); ?>" value="<?php echo esc_attr($this->data['meta']['booking_day_count']); ?>"/>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Calendar navigation advance period','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Number of days by which the calendar will be shifted.','car-wash-booking-system'); ?></span>
							<div>
								<select  name="<?php CBSHelper::getFormName('calendar_navigation_advance_period'); ?>" id="<?php CBSHelper::getFormName('calendar_navigation_advance_period'); ?>">
<?php
		for($i=1;$i<=7;$i++)
		{
?>
									<option value="<?php echo $i; ?>" <?php CBSHelper::selectedIf($i,$this->data['meta']['calendar_navigation_advance_period']); ?>><?php echo $i; ?></option>
<?php
		}
?>
								</select>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Calendar month navigation','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Whether month navigation is visible.','car-wash-booking-system'); ?></span>
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php CBSHelper::getFormName('calendar_month_navigation_1'); ?>" name="<?php CBSHelper::getFormName('calendar_month_navigation'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['calendar_month_navigation'],1); ?>/>
								<label for="<?php CBSHelper::getFormName('calendar_month_navigation_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>
								
								<input type="radio" value="0" id="<?php CBSHelper::getFormName('calendar_month_navigation_0'); ?>" name="<?php CBSHelper::getFormName('calendar_month_navigation'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['calendar_month_navigation'],0); ?>/>
								<label for="<?php CBSHelper::getFormName('calendar_month_navigation_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>
							</div>
						</li>
					</ul>					
				</div>
				<div id="meta-box-location-3">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Sender','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Sender account.','car-wash-booking-system'); ?></span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Name:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('sender_name'); ?>" id="<?php CBSHelper::getFormName('sender_name'); ?>" value="<?php echo esc_attr($this->data['meta']['sender_name']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('E-mail address:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('sender_email'); ?>" id="<?php CBSHelper::getFormName('sender_email'); ?>" value="<?php echo esc_attr($this->data['meta']['sender_email']); ?>"/>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('SMTP Auth','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('SMTP authentication settings.','car-wash-booking-system'); ?></span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Status:','car-wash-booking-system'); ?></span>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php CBSHelper::getFormName('sender_smtp_enable_1'); ?>" name="<?php CBSHelper::getFormName('sender_smtp_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['sender_smtp_enable'],1); ?>/>
									<label for="<?php CBSHelper::getFormName('sender_smtp_enable_1'); ?>"><?php esc_html_e('Enabled','car-wash-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php CBSHelper::getFormName('sender_smtp_enable_0'); ?>" name="<?php CBSHelper::getFormName('sender_smtp_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['sender_smtp_enable'],0); ?>/>
									<label for="<?php CBSHelper::getFormName('sender_smtp_enable_0'); ?>"><?php esc_html_e('Disabled','car-wash-booking-system'); ?></label>							
								</div>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Username:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('sender_smtp_username'); ?>" id="<?php CBSHelper::getFormName('sender_smtp_username'); ?>" value="<?php echo esc_attr($this->data['meta']['sender_smtp_username']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Password:','car-wash-booking-system'); ?></span>
								<input type="password" name="<?php CBSHelper::getFormName('sender_smtp_password'); ?>" id="<?php CBSHelper::getFormName('sender_smtp_password'); ?>" value="<?php echo esc_attr($this->data['meta']['sender_smtp_password']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Host:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('sender_smtp_host'); ?>" id="<?php CBSHelper::getFormName('sender_smtp_host'); ?>" value="<?php echo esc_attr($this->data['meta']['sender_smtp_host']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Port:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('sender_smtp_port'); ?>" id="<?php CBSHelper::getFormName('sender_smtp_port'); ?>" value="<?php echo esc_attr($this->data['meta']['sender_smtp_port']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Connection type:','car-wash-booking-system'); ?></span>
								<div class="to-radio-button">
<?php
		foreach($this->data['dictionary']['secure_connection_type'] as $secure_connection_typeIndex=>$secure_connection_typeData)
		{
?>
									<input type="radio" value="<?php echo esc_attr($secure_connection_typeIndex); ?>" id="<?php CBSHelper::getFormName('sender_smtp_secure_connection_type_'.$secure_connection_typeIndex); ?>" name="<?php CBSHelper::getFormName('sender_smtp_secure_connection_type'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['sender_smtp_secure_connection_type'],$secure_connection_typeIndex); ?>/>
									<label for="<?php CBSHelper::getFormName('sender_smtp_secure_connection_type_'.$secure_connection_typeIndex); ?>"><?php echo esc_html($secure_connection_typeData[0]); ?></label>							
<?php		
		}
?>									
								</div>
							</div>
							<div>
								<span class="to-legend-field">
									<?php esc_html_e('Debugging (you can check result of debugging in Chrome/Firebug console - after submit form).','car-wash-booking-system'); ?>
								</span>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php CBSHelper::getFormName('smtp_debug_enable_1'); ?>" name="<?php CBSHelper::getFormName('smtp_debug_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['smtp_debug_enable'],1); ?>/>
									<label for="<?php CBSHelper::getFormName('smtp_debug_enable_1'); ?>"><?php esc_html_e('Enabled','car-wash-booking-system'); ?></label>							
									<input type="radio" value="0" id="<?php CBSHelper::getFormName('smtp_debug_enable_0'); ?>" name="<?php CBSHelper::getFormName('smtp_debug_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['smtp_debug_enable'],0); ?>/>
									<label for="<?php CBSHelper::getFormName('smtp_debug_enable_0'); ?>"><?php esc_html_e('Disabled','car-wash-booking-system'); ?></label>							
								</div>								
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Recipient e-mail addresses','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Recipient e-mail addresses separated by semicolon.','car-wash-booking-system'); ?></span>
							<div>
								<input type="text" name="<?php CBSHelper::getFormName('recipient_email'); ?>" id="<?php CBSHelper::getFormName('recipient_email'); ?>" value="<?php echo esc_attr($this->data['meta']['recipient_email']); ?>"/>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Nexmo SMS notifications','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php echo __('Enter details to be notified via SMS about new booking through <a href="https://www.nexmo.com/" target="_blank">Nexmo</a>.','car-wash-booking-system'); ?>
							</span> 
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Status:','car-wash-booking-system'); ?></span>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php CBSHelper::getFormName('nexmo_sms_enable_1'); ?>" name="<?php CBSHelper::getFormName('nexmo_sms_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['nexmo_sms_enable'],1); ?>/>
									<label for="<?php CBSHelper::getFormName('nexmo_sms_enable_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php CBSHelper::getFormName('nexmo_sms_enable_0'); ?>" name="<?php CBSHelper::getFormName('nexmo_sms_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['nexmo_sms_enable'],0); ?>/>
									<label for="<?php CBSHelper::getFormName('nexmo_sms_enable_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>
								</div>								
							</div>
<?php
		$class=array('to-clear-fix');
		if((int)$this->data['meta']['nexmo_sms_enable']!==1)
			array_push($class,'to-hidden');
?>
							<div<?php echo CBSHelper::createCSSClassAttribute($class); ?>>
								<span class="to-legend-field"><?php esc_html_e('API key:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('nexmo_sms_api_key'); ?>" value="<?php echo esc_attr($this->data['meta']['nexmo_sms_api_key']); ?>"/>
							</div>								
							<div<?php echo CBSHelper::createCSSClassAttribute($class); ?>>
								<span class="to-legend-field"><?php esc_html_e('Secret API key:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('nexmo_sms_api_key_secret'); ?>" value="<?php echo esc_attr($this->data['meta']['nexmo_sms_api_key_secret']); ?>"/>
							</div>									
							<div<?php echo CBSHelper::createCSSClassAttribute($class); ?>>
								<span class="to-legend-field"><?php esc_html_e('Sender name:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('nexmo_sms_sender_name'); ?>" value="<?php echo esc_attr($this->data['meta']['nexmo_sms_sender_name']); ?>"/>
							</div>							   
							<div<?php echo CBSHelper::createCSSClassAttribute($class); ?>>
								<span class="to-legend-field"><?php esc_html_e('Recipient phone number:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('nexmo_sms_recipient_phone_number'); ?>" value="<?php echo esc_attr($this->data['meta']['nexmo_sms_recipient_phone_number']); ?>"/>
							</div>								
							<div<?php echo CBSHelper::createCSSClassAttribute($class); ?>>
								<span class="to-legend-field"><?php esc_html_e('Message:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('nexmo_sms_message'); ?>" value="<?php echo esc_attr($this->data['meta']['nexmo_sms_message']); ?>"/>
							</div>							  
						</li>
						<li>
							<h5><?php esc_html_e('Twilio SMS notifications','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php echo __('Enter details to be notified via SMS about new booking through <a href="https://www.twilio.com" target="_blank">Twilio</a>.','car-wash-booking-system'); ?>
							</span> 
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Status:','car-wash-booking-system'); ?></span>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php CBSHelper::getFormName('twilio_sms_enable_1'); ?>" name="<?php CBSHelper::getFormName('twilio_sms_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['twilio_sms_enable'],1); ?>/>
									<label for="<?php CBSHelper::getFormName('twilio_sms_enable_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php CBSHelper::getFormName('twilio_sms_enable_0'); ?>" name="<?php CBSHelper::getFormName('twilio_sms_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['twilio_sms_enable'],0); ?>/>
									<label for="<?php CBSHelper::getFormName('twilio_sms_enable_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>
								</div>								
							</div>
<?php
		$class=array('to-clear-fix');
		if((int)$this->data['meta']['twilio_sms_enable']!==1)
			array_push($class,'to-hidden');
?>
							<div<?php echo CBSHelper::createCSSClassAttribute($class); ?>>
								<span class="to-legend-field"><?php esc_html_e('API SID:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('twilio_sms_api_sid'); ?>" value="<?php echo esc_attr($this->data['meta']['twilio_sms_api_sid']); ?>"/>
							</div>								
							<div<?php echo CBSHelper::createCSSClassAttribute($class); ?>>
								<span class="to-legend-field"><?php esc_html_e('API token:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('twilio_sms_api_token'); ?>" value="<?php echo esc_attr($this->data['meta']['twilio_sms_api_token']); ?>"/>
							</div>									
							<div<?php echo CBSHelper::createCSSClassAttribute($class); ?>>
								<span class="to-legend-field"><?php esc_html_e('Sender phone number:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('twilio_sms_sender_phone_number'); ?>" value="<?php echo esc_attr($this->data['meta']['twilio_sms_sender_phone_number']); ?>"/>
							</div>							   
							<div<?php echo CBSHelper::createCSSClassAttribute($class); ?>>
								<span class="to-legend-field"><?php esc_html_e('Recipient phone number:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('twilio_sms_recipient_phone_number'); ?>" value="<?php echo esc_attr($this->data['meta']['twilio_sms_recipient_phone_number']); ?>"/>
							</div>								
							<div<?php echo CBSHelper::createCSSClassAttribute($class); ?>>
								<span class="to-legend-field"><?php esc_html_e('Message:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('twilio_sms_message'); ?>" value="<?php echo esc_attr($this->data['meta']['twilio_sms_message']); ?>"/>
							</div>							  
						</li>
					</ul>					
				</div>
				<div id="meta-box-location-4">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Location address','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Location address.','car-wash-booking-system'); ?></span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Name:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('address_name'); ?>" id="<?php CBSHelper::getFormName('address_name'); ?>" value="<?php echo esc_attr($this->data['meta']['address_name']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Street:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('address_street'); ?>" id="<?php CBSHelper::getFormName('address_street'); ?>" value="<?php echo esc_attr($this->data['meta']['address_street']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Postcode:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('address_postcode'); ?>" id="<?php CBSHelper::getFormName('address_postcode'); ?>" value="<?php echo esc_attr($this->data['meta']['address_postcode']); ?>"/>
							</div>							
							<div>
								<span class="to-legend-field"><?php esc_html_e('City:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('address_city'); ?>" id="<?php CBSHelper::getFormName('address_city'); ?>" value="<?php echo esc_attr($this->data['meta']['address_city']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('State:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('address_state'); ?>" id="<?php CBSHelper::getFormName('address_state'); ?>" value="<?php echo esc_attr($this->data['meta']['address_state']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Country:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('address_country'); ?>" id="<?php CBSHelper::getFormName('address_country'); ?>" value="<?php echo esc_attr($this->data['meta']['address_country']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Phone number:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('address_phone_number'); ?>" id="<?php CBSHelper::getFormName('address_phone_number'); ?>" value="<?php echo esc_attr($this->data['meta']['address_phone_number']); ?>"/>
							</div> 
							<div>
								<span class="to-legend-field"><?php esc_html_e('Fax number:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('address_fax_number'); ?>" id="<?php CBSHelper::getFormName('address_fax_number'); ?>" value="<?php echo esc_attr($this->data['meta']['address_fax_number']); ?>"/>
							</div>   
							<div>
								<span class="to-legend-field"><?php esc_html_e('E-mail address:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('address_email_address'); ?>" id="<?php CBSHelper::getFormName('address_email_address'); ?>" value="<?php echo esc_attr($this->data['meta']['address_email_address']); ?>"/>
							</div>							   
						</li>
						<li>
							<h5><?php esc_html_e('Coordinates','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Coordinates (in order: latitude, longitude) of location.','car-wash-booking-system'); ?></span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Latitude:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('coordinate_latitude'); ?>" id="<?php CBSHelper::getFormName('coordinate_latitude'); ?>" value="<?php echo esc_attr($this->data['meta']['coordinate_latitude']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Longitude:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('coordinate_longitude'); ?>" id="<?php CBSHelper::getFormName('coordinate_longitude'); ?>" value="<?php echo esc_attr($this->data['meta']['coordinate_longitude']); ?>"/>
							</div>
						</li>
					</ul>					
				</div>
				<div id="meta-box-location-5">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Payment selection required','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Whether user must select a payment type.','car-wash-booking-system'); ?></span>
							<div>
								<div class="to-radio-button">							
									<input type="radio" value="1" id="<?php CBSHelper::getFormName('payment_selection_required_1'); ?>" name="<?php CBSHelper::getFormName('payment_selection_required'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['payment_selection_required'],1); ?>/>
									<label for="<?php CBSHelper::getFormName('payment_selection_required_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php CBSHelper::getFormName('payment_selection_required_0'); ?>" name="<?php CBSHelper::getFormName('payment_selection_required'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['payment_selection_required'],0); ?>/>
									<label for="<?php CBSHelper::getFormName('payment_selection_required_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>
								</div>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Cash','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Enter settings for Cash.','car-wash-booking-system'); ?></span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Status:','car-wash-booking-system'); ?></span>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php CBSHelper::getFormName('payment_cash_enable_1'); ?>" name="<?php CBSHelper::getFormName('payment_cash_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['payment_cash_enable'],1); ?>/>
									<label for="<?php CBSHelper::getFormName('payment_cash_enable_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>							
									<input type="radio" value="0" id="<?php CBSHelper::getFormName('payment_cash_enable_0'); ?>" name="<?php CBSHelper::getFormName('payment_cash_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['payment_cash_enable'],0); ?>/>
									<label for="<?php CBSHelper::getFormName('payment_cash_enable_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>							
								</div>
							</div>	
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('"Thank you" page URL address:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('payment_cash_thank_you_page_url_address'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_cash_thank_you_page_url_address']); ?>"/>
							</div>	
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Additional information for customer:','car-wash-booking-system'); ?></span>
								<textarea rows="1" cols="1" name="<?php CBSHelper::getFormName('payment_cash_info'); ?>"><?php echo esc_html($this->data['meta']['payment_cash_info']); ?></textarea>
							</div>
						</li>						
						<li>
							<h5><?php esc_html_e('Stripe','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Enter settings for Stripe gateway.','car-wash-booking-system'); ?></span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Status:','car-wash-booking-system'); ?></span>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php CBSHelper::getFormName('payment_stripe_enable_1'); ?>" name="<?php CBSHelper::getFormName('payment_stripe_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['payment_stripe_enable'],1); ?>/>
									<label for="<?php CBSHelper::getFormName('payment_stripe_enable_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>							
									<input type="radio" value="0" id="<?php CBSHelper::getFormName('payment_stripe_enable_0'); ?>" name="<?php CBSHelper::getFormName('payment_stripe_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['payment_stripe_enable'],0); ?>/>
									<label for="<?php CBSHelper::getFormName('payment_stripe_enable_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>							
								</div>
							</div>
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Secret API key:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('payment_stripe_api_key_secret'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_stripe_api_key_secret']); ?>"/>
							</div>
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Publishable API key:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('payment_stripe_api_key_publishable'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_stripe_api_key_publishable']); ?>"/>
							</div>
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Payment methods (you need to set up each of them in your "Stripe" dashboard under "Settings / Payment methods"):','car-wash-booking-system'); ?></span>
								<div class="to-checkbox-button">
<?php
		foreach($this->data['dictionary']['payment_stripe_method'] as $index=>$value)
		{
?>
									<input type="checkbox" value="<?php echo esc_attr($index); ?>" id="<?php CBSHelper::getFormName('payment_stripe_method_'.$index); ?>" name="<?php CBSHelper::getFormName('payment_stripe_method[]'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['payment_stripe_method'],$index); ?>/>
									<label for="<?php CBSHelper::getFormName('payment_stripe_method_'.$index); ?>"><?php echo esc_html($value[0]); ?></label>							
<?php		
		}
?>
								</div>	
							</div>
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Product ID:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('payment_stripe_product_id'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_stripe_product_id']); ?>"/>
							</div>
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Stripe "success" URL address:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('payment_stripe_success_url_address'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_stripe_success_url_address']); ?>"/>
							</div>
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Stripe "cancel" URL address:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('payment_stripe_cancel_url_address'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_stripe_cancel_url_address']); ?>"/>
							</div>							
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Additional information for customer:','car-wash-booking-system'); ?></span>
								<textarea rows="1" cols="1" name="<?php CBSHelper::getFormName('payment_stripe_info'); ?>"><?php echo esc_html($this->data['meta']['payment_stripe_info']); ?></textarea>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('PayPal','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Enter settings for PayPal gateway.','car-wash-booking-system'); ?></span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Status:','car-wash-booking-system'); ?></span>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php CBSHelper::getFormName('payment_paypal_enable_1'); ?>" name="<?php CBSHelper::getFormName('payment_paypal_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['payment_paypal_enable'],1); ?>/>
									<label for="<?php CBSHelper::getFormName('payment_paypal_enable_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>							
									<input type="radio" value="0" id="<?php CBSHelper::getFormName('payment_paypal_enable_0'); ?>" name="<?php CBSHelper::getFormName('payment_paypal_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['payment_paypal_enable'],0); ?>/>
									<label for="<?php CBSHelper::getFormName('payment_paypal_enable_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>							
								</div>
							</div>
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('E-mail address:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('payment_paypal_email_address'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_paypal_email_address']); ?>"/>
							</div>
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Sandbox mode:','car-wash-booking-system'); ?></span>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php CBSHelper::getFormName('payment_paypal_sandbox_mode_enable_1'); ?>" name="<?php CBSHelper::getFormName('payment_paypal_sandbox_mode_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['payment_paypal_sandbox_mode_enable'],1); ?>/>
									<label for="<?php CBSHelper::getFormName('payment_paypal_sandbox_mode_enable_1'); ?>"><?php esc_html_e('Enable','car-wash-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php CBSHelper::getFormName('payment_paypal_sandbox_mode_enable_0'); ?>" name="<?php CBSHelper::getFormName('payment_paypal_sandbox_mode_enable'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['payment_paypal_sandbox_mode_enable'],0); ?>/>
									<label for="<?php CBSHelper::getFormName('payment_paypal_sandbox_mode_enable_0'); ?>"><?php esc_html_e('Disable','car-wash-booking-system'); ?></label>
								</div>
							</div>
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('PayPal "success" URL address:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('payment_paypal_success_url_address'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_paypal_success_url_address']); ?>"/>
							</div>
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('PayPal "cancel" URL address:','car-wash-booking-system'); ?></span>
								<input type="text" name="<?php CBSHelper::getFormName('payment_paypal_cancel_url_address'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_paypal_cancel_url_address']); ?>"/>
							</div>	
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Additional information for customer:','car-wash-booking-system'); ?></span>
								<textarea rows="1" cols="1" name="<?php CBSHelper::getFormName('payment_paypal_info'); ?>"><?php echo esc_html($this->data['meta']['payment_paypal_info']); ?></textarea>
							</div>
						</li> 
					</ul>					
				</div>
				<div id="meta-box-location-6">
					<ul class="to-form-field-list">
<?php
		$text=array
		(
			__('Main color scheme'),
			__('Secondary color scheme','car-wash-booking-system'),
			__('Heading text','car-wash-booking-system'),
			__('Body text','car-wash-booking-system'),
			__('Subtle body text','car-wash-booking-system'),
			__('Border','car-wash-booking-system'),
			__('Inactive step background','car-wash-booking-system'),
			__('Inactive step text','car-wash-booking-system'),
			__('Inactive body text','car-wash-booking-system'),
			__('Icon','car-wash-booking-system')
		);

		for($i=1;$i<=$this->data['colorCount'];$i++)
		{
?>
						<li>
							<h5><?php echo $text[$i-1]; ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Select color in HEX format for elements in this group. Leave the field blank to use the default color.','car-wash-booking-system'); ?><br/>
								<?php echo sprintf(esc_html__('More info about colors you can find %shere%s.','car-wash-booking-system'),'<a href="'.PLUGIN_CBS_MEDIA_URL.'image/admin/color.png" target="_blank">','</a>'); ?>
							</span>
							<div>
								<input type="text" class="to-color-picker" name="<?php CBSHelper::getFormName('color_'.$i); ?>" id="<?php CBSHelper::getFormName('color_'.$i); ?>" value="<?php echo esc_attr($this->data['meta']['color'][$i]); ?>"/>
							</div>
						</li>
<?php
		}
?>
					</ul>					
				</div>
				<div id="meta-box-location-7">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Google Calendar ID','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Google Calendar ID.','car-wash-booking-system'); ?></span>
							<div>
								<input type="text" name="<?php CBSHelper::getFormName('google_calendar_id'); ?>" id="<?php CBSHelper::getFormName('google_calendar_id'); ?>" value="<?php echo esc_attr($this->data['meta']['google_calendar_id']); ?>"/>
							</div>
						</li>
					</ul>					
				</div>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($)
			{	
				 /***/
				 
				$('.to').themeOptionElement({init:true});
				$('#to-table-date-exclude').table();
				$('#to-table-form-element-agreement').table();
				
				 /***/
				 
				 $('input[name="<?php CBSHelper::getFormName('nexmo_sms_enable'); ?>"],input[name="<?php CBSHelper::getFormName('twilio_sms_enable'); ?>"]').on('change',function()
				{
					var value=parseInt($(this).val());
					var option=$(this).parent('div').parents('div:first').nextAll('div');
					
					if(value===1) option.removeClass('to-hidden');
					else option.addClass('to-hidden');
				});
				
				 /***/
				 
			});
		</script>
