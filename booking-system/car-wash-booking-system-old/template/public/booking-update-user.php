	<div class="cbs-main-list-item-section-content cbs-clear-fix <?php echo esc_attr($this->data['class']); ?>">
		<div class="cbs-clear-fix">
<?php
		$columnWidth=CBSHelper::getColumnWidth(3,array($this->data['client_company_name_enable']));
?>
			<div class="cbs-form-field cbs-form-field-first-name cbs-form-width-<?php echo $columnWidth; ?>">
				<label><?php esc_html_e('First name *','car-wash-booking-system'); ?></label>
				<input type="text" name="update_client_first_name" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['first_name']); ?>"/>
			</div>
			<div class="cbs-form-field cbs-form-field-last-name cbs-form-width-<?php echo $columnWidth; ?>">
				<label><?php esc_html_e('Last Name *','car-wash-booking-system'); ?></label>
				<input type="text" name="update_client_second_name" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['last_name']); ?>"/>
			</div>
<?php
		if($this->data['client_company_name_enable'])
		{
?>	
			<div class="cbs-form-field cbs-form-field-company-name cbs-form-width-<?php echo $columnWidth; ?>">
				<label><?php esc_html_e('Company name','car-wash-booking-system'); ?></label>
				<input type="text" name="update_client_company_name" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['company_name']); ?>"/>
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
				<input type="text" name="update_client_address_street" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['address_street']); ?>"/>
			</div>	
<?php
			}
			if($this->data['client_address_post_code_enable'])
			{
?>		
			<div class="cbs-form-field cbs-form-field-address-post-code cbs-form-width-<?php echo $columnWidth; ?>">
				<label><?php esc_html_e('ZIP Code','car-wash-booking-system'); ?></label>
				<input type="text" name="update_client_address_post_code" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['address_post_code']); ?>"/>
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
				<input type="text" name="update_client_address_city" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['address_city']); ?>"/>
			</div>
<?php
			}
			if($this->data['client_address_state_enable'])
			{
?>
		<div class="cbs-form-field cbs-form-field-address-state cbs-form-width-<?php echo $columnWidth; ?>">
			<label><?php esc_html_e('State','car-wash-booking-system'); ?></label>
			<input type="text" name="update_client_address_state" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['address_state']); ?>"/>
		</div>	
<?php
			}
			if($this->data['client_address_country_enable'])
			{
?>		
		<div class="cbs-form-field cbs-form-field-address-country cbs-form-width-<?php echo $columnWidth; ?>">
			<label><?php esc_html_e('Country','car-wash-booking-system'); ?></label>
			<input type="text" name="update_client_address_country" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['address_country']); ?>"/>
		</div>	
<?php
			}
		}
?>		
		</div>
		<div class="cbs-clear-fix">
			<div class="cbs-form-field cbs-form-field-email cbs-form-width-50">
				<label><?php esc_html_e('Your E-mail *','car-wash-booking-system'); ?></label>
				<input type="text" name="update_client_email_address" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['email_address']); ?>"/>
			</div>
			<div class="cbs-form-field cbs-form-field-phone cbs-form-width-50">
				<label><?php esc_html_e('Phone Number *','car-wash-booking-system'); ?></label>
				<input type="text" name="update_client_phone_number" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['phone_number']); ?>"/>
			</div>
		</div>
		<div class="cbs-clear-fix">
			<div class="cbs-form-field cbs-form-field-model cbs-form-width-100">
				<label><?php esc_html_e('Vehicle Make and Model *','car-wash-booking-system'); ?></label>
				<input type="text" name="update_client_vehicle" autocomplete="off" value="<?php echo esc_attr($this->data['user_contact_data']['vehicle']); ?>"/>
			</div>
		</div>
		<div class="cbs-form-summary cbs-clear-fix">
			<a class="cbs-button cbs-update-user-contact-details" href="#"><?php esc_html_e('Save','car-wash-booking-system'); ?></a>
		</div>
	</div>


		
