		<ul class="to-form-field-list">
			<li>
				<h5><?php esc_html_e('Duration unit','car-wash-booking-system'); ?></h5>
				<span class="to-legend"><?php esc_html_e('Select duration unit for packages/services.','car-wash-booking-system'); ?></span>
				<div class="to-radio-button">							
					<input type="radio" value="1" id="<?php CBSHelper::getFormName('duration_unit_1'); ?>" name="<?php CBSHelper::getFormName('duration_unit'); ?>" <?php CBSHelper::checkedIf($this->data['option']['duration_unit'],1); ?>/>
					<label for="<?php CBSHelper::getFormName('duration_unit_1'); ?>"><?php esc_html_e('Minutes','car-wash-booking-system'); ?></label>
					<input type="radio" value="2" id="<?php CBSHelper::getFormName('duration_unit_2'); ?>" name="<?php CBSHelper::getFormName('duration_unit'); ?>" <?php CBSHelper::checkedIf($this->data['option']['duration_unit'],2); ?>/>
					<label for="<?php CBSHelper::getFormName('duration_unit_2'); ?>"><?php esc_html_e('Hours/minutes','car-wash-booking-system'); ?></label>
				</div>
			</li> 
		</ul>