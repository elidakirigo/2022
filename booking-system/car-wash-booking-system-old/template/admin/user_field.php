
		<h3><?php esc_html_e('Bookings','car-wash-booking-system'); ?></h3>
		<table class="form-table">
			<tr>
				<th><label for="twitter"><?php esc_html_e('Locations','car-wash-booking-system'); ?></label></th>
				<td>
					<select name="<?php CBSHelper::getFormName('location[]'); ?>" id="<?php CBSHelper::getFormName('location'); ?>" multiple>
						<option value="-2" <?php CBSHelper::selectedIf($this->data['meta']['location'],-2); ?>><?php esc_html_e('[None]','car-wash-booking-system') ?></option>
						<option value="-1" <?php CBSHelper::selectedIf($this->data['meta']['location'],-1); ?>><?php esc_html_e('[All locations]','car-wash-booking-system') ?></option>
<?php
		foreach($this->data['dictionary']['location'] as $locationId=>$locationData)
		{
?>
					<option value="<?php echo esc_attr($locationId); ?>" <?php CBSHelper::selectedIf($this->data['meta']['location'],$locationId); ?>><?php echo esc_html($locationData['post']->post_title); ?></option>
<?php			
		}
?>
					</select>
					<span class="description"><?php esc_html_e('Select from which location(s) user can manage bookings.','car-wash-booking-system'); ?></span>
				</td>
			</tr>
		</table>