<?php
		$Validation=new CBSValidation();
?>
		<div class="cbs-main-list-item-section-content cbs-clear-fix <?php echo esc_attr($this->data['class']); ?>">
			<div class="cbs-clear-fix">
<?php
		$columnWidth=CBSHelper::getColumnWidth(3,array($this->data['client_company_name_enable']));
?>
				<div class="cbs-form-field cbs-form-field-first-name cbs-form-width-<?php echo $columnWidth; ?>">
					<label><?php esc_html_e('First name *','car-wash-booking-system'); ?></label>
					<input type="text" name="client_first_name" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['first_name']); ?>"/>
				</div>
				<div class="cbs-form-field cbs-form-field-last-name cbs-form-width-<?php echo $columnWidth; ?>">
					<label><?php esc_html_e('Last Name *','car-wash-booking-system'); ?></label>
					<input type="text" name="client_second_name" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['last_name']); ?>"/>
				</div>
<?php
		if($this->data['client_company_name_enable'])
		{
?>
				<div class="cbs-form-field cbs-form-field-company-name cbs-form-width-<?php echo $columnWidth; ?>">
					<label><?php esc_html_e('Company name','car-wash-booking-system'); ?></label>
					<input type="text" name="client_company_name" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['company_name']); ?>"/>
				</div>
<?php
		}
?>
			</div>
			<div class="cbs-clear-fix">
<?php
		if($this->data['client_address_enable'])
		{
			$columnWidth=CBSHelper::getColumnWidth(2,array($this->data['client_address_street_enable'],$this->data['client_address_post_code_enable']));
			if($this->data['client_address_street_enable'])
			{
?>	
				<div class="cbs-form-field cbs-form-field-address-street cbs-form-width-<?php echo $columnWidth; ?>">
					<label><?php esc_html_e('Street','car-wash-booking-system'); ?></label>
					<input type="text" name="client_address_street" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['address_street']); ?>"/>
				</div>
<?php
			}
			if($this->data['client_address_post_code_enable'])
			{
?>
				<div class="cbs-form-field cbs-form-field-address-post-code cbs-form-width-<?php echo $columnWidth; ?>">
					<label><?php esc_html_e('ZIP Code','car-wash-booking-system'); ?></label>
					<input type="text" name="client_address_post_code" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['address_post_code']); ?>"/>
				</div>
<?php
			}
?>
			</div>
			<div class="cbs-clear-fix">
<?php
			$columnWidth=CBSHelper::getColumnWidth(3,array($this->data['client_address_city_enable'],$this->data['client_address_state_enable'],$this->data['client_address_country_enable']));
			if($this->data['client_address_city_enable'])
			{
?>
				<div class="cbs-form-field cbs-form-field-address-city cbs-form-width-<?php echo $columnWidth; ?>">
					<label><?php esc_html_e('City','car-wash-booking-system'); ?></label>
					<input type="text" name="client_address_city" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['address_city']); ?>"/>
				</div>	
<?php
			}
			if($this->data['client_address_state_enable'])
			{
?>
				<div class="cbs-form-field cbs-form-field-address-state cbs-form-width-<?php echo $columnWidth; ?>">
					<label><?php esc_html_e('State','car-wash-booking-system'); ?></label>
					<input type="text" name="client_address_state" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['address_state']); ?>"/>
				</div>
<?php
			}
			if($this->data['client_address_country_enable'])
			{
?>
				<div class="cbs-form-field cbs-form-field-address-country cbs-form-width-<?php echo $columnWidth; ?>">
					<label><?php esc_html_e('Country','car-wash-booking-system'); ?></label>
					<input type="text" name="client_address_country" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['address_country']); ?>"/>
				</div>
<?php
			}
		}
?>		
			</div>
			<div class="cbs-clear-fix">
				<div class="cbs-form-field cbs-form-field-email cbs-form-width-50">
					<label><?php esc_html_e('Your E-mail *','car-wash-booking-system'); ?></label>
					<input type="text" name="client_email_address" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['email_address']); ?>"/>
				</div>
				<div class="cbs-form-field cbs-form-field-phone cbs-form-width-50">
					<label><?php esc_html_e('Phone Number *','car-wash-booking-system'); ?></label>
					<input type="text" name="client_phone_number" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['phone_number']); ?>"/>
				</div>
			</div>
			<div class="cbs-clear-fix">
				<div class="cbs-form-field cbs-form-field-model cbs-form-width-100">
					<label><?php esc_html_e('Vehicle Make and Model *','car-wash-booking-system'); ?></label>
					<input type="text" name="client_vehicle" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['vehicle']); ?>"/>
				</div>
			</div>
<?php
		if($this->data['client_message_enable'])
		{
?>
			<div class="cbs-clear-fix">
				<div class="cbs-form-field cbs-form-field-message cbs-form-width-100">
					<label><?php esc_html_e('Message','car-wash-booking-system'); ?></label>
					<textarea rows="1" cols="1" name="client_message"></textarea>
				</div>
			</div>
<?php
		}
		if($this->data['gratuity_enable'])
		{
?>
			<div class="cbs-clear-fix">
				<div class="cbs-form-field cbs-form-field-model cbs-form-width-100">
					<label><?php esc_html_e('Gratuity','car-wash-booking-system'); ?></label>
					<input type="text" name="gratuity" autocomplete="off" value="0.00"/>
				</div>
			</div>
<?php
		}
		if($this->data['register_user'])
		{
?>
			<div class="cbs-clear-fix">
				<div class="cbs-form-field cbs-form-field-username cbs-form-width-33 cbs-state-hidden">
					<label><?php esc_html_e('Username','car-wash-booking-system'); ?></label>
					<input type="text" name="register_username" autocomplete="off"/>
				</div>			
				<div class="cbs-form-field cbs-form-field-password cbs-form-width-33 cbs-state-hidden">
					<label><?php esc_html_e('Password','car-wash-booking-system'); ?></label>
					<input type="password" name="register_password" autocomplete="off"/>
				</div>
				<div class="cbs-form-field cbs-form-field-password-check cbs-form-width-33 cbs-state-hidden">
					<label><?php esc_html_e('Repeat password','car-wash-booking-system'); ?></label>
					<input type="password" name="register_password_check" autocomplete="off"/>
				</div>
			</div>
<?php
		}
		if($this->data['service_location_enable'] && $this->data['service_location'])
		{
?>
			<div class="cbs-clear-fix">
				<div class="cbs-form-field cbs-form-field-model cbs-form-width-100">
					<label><?php esc_html_e('Service Location','car-wash-booking-system'); ?></label>
					<select name="service_location" autocomplete="off">
						<option value="" selected><?php esc_html_e('Select a location','car-wash-booking-system'); ?></option>
<?php
			foreach($this->data['service_location'] as $service_location)
			{
?>
						<option value="<?php echo esc_attr($service_location); ?>"><?php echo esc_html($service_location); ?></option>
<?php
			}
?>
					</select>
				</div>
			</div>
<?php
		}
?>
			<div class="cbs-clear-fix">
				<div class="cbs-form-field cbs-form-field-model cbs-form-width-100">
					<label><?php esc_html_e('Payment type','car-wash-booking-system'); ?></label>
					<select name="payment_type" autocomplete="off">
						<option value="" selected><?php esc_html_e('Choose a payment','car-wash-booking-system'); ?></option>
<?php
		foreach($this->data['payment_type'] as $paymentType)
		{
?>
						<option value="<?php echo esc_attr($paymentType[0]); ?>"><?php echo esc_html($paymentType[1]); ?></option>
<?php
		}
?>
					</select>
				</div>
			</div>

			<div class="cbs-form-summary cbs-clear-fix">
<?php
		if($this->data['register_user'])
		{
?>			
				<div class="cbs-register cbs-clear-fix">
					<span class="cbs-form-checkbox">
						<span class="cbs-meta-icon cbs-meta-icon-check"></span>
					</span>
					<input type="hidden" name="register_user" value="0" autocomplete="off"/> 
					<div><?php esc_html_e('Do you want to create an account ?','car-wash-booking-system'); ?></div>
				</div>
<?php
		}
		if($this->data['enable_coupons'])
		{
?>
				<div class="cbs-coupon-code cbs-clear-fix">
					<a class="cbs-show-coupon" href="#"><?php esc_html_e('Do you have a coupon code ?','car-wash-booking-system'); ?></a>				
					<input type="text" name="coupon_code" autocomplete="off"/>
					<a class="cbs-button cbs-button-apply-coupon" href="#"><?php esc_html_e('Apply','car-wash-booking-system'); ?></a>				
					<div class="cbs-coupon-code-success">
						<?php esc_html_e('The provided coupon is valid, total order value was reduced respectively.','car-wash-booking-system'); ?><br/>
						<?php esc_html_e('Please note that if you change your booking details then you will have to insert coupon code once again.','car-wash-booking-system'); ?>
					</div>
					<div class="cbs-coupon-code-failure"><?php esc_html_e('It seems that your coupon code is invalid. Possible reasons: total price is lower than minimum price, code is incorrect, it was used too many times or it\'s no longer active.','car-wash-booking-system'); ?></div>
				</div>
<?php
		}
		if($this->data['form_agreement'])
		{
?>
				<div class="cbs-agreement">
<?php
			foreach($this->data['form_agreement'] as $value)
			{
?>				
					<div class="cbs-clear-fix">
						<span class="cbs-form-checkbox">
							<span class="cbs-meta-icon cbs-meta-icon-check"></span>
						</span>
						<input type="hidden" name="<?php echo esc_attr('form_agreement_'.$value['id']) ?>" value="0" autocomplete="off"/> 
						<div><?php echo $value['text']; ?></div>
					</div>
<?php
			}
?>
				</div>
<?php		
		}
		if($Validation->isNotEmpty($this->data['text_1']))
		{
?>
				<div class="cbs-form-info"><?php echo nl2br(esc_html($this->data['text_1'])); ?></div>
<?php
		}
?>
				<input type="submit" class="cbs-button" value="<?php esc_attr_e('Confirm Booking','car-wash-booking-system'); ?>" />
			</div>
		</div>


		
