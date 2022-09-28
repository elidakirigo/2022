		<ul class="to-form-field-list">
			<li>
				<h5><?php esc_html_e('Google Calendar','car-wash-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('Configure if you want to include booking information in Google Calendar.','car-wash-booking-system'); ?><br/>
				</span>
			</li>
			<li>
				<h5><?php esc_html_e('Settings','car-wash-booking-system'); ?></h5>
				<span class="to-legend"><?php esc_html_e('Copy/paste the contents of downloaded *.json file.','car-wash-booking-system'); ?></span>
				<div>
					<textarea name="<?php CBSHelper::getFormName('google_calendar_settings'); ?>" id="<?php CBSHelper::getFormName('google_calendar_settings'); ?>"><?php echo esc_html($this->data['google_calendar_settings']); ?></textarea>
				</div>
			</li>
			<li>
				<input type="button" name="<?php CBSHelper::getFormName('save_google_calendar_settings'); ?>" id="<?php CBSHelper::getFormName('save_google_calendar_settings'); ?>" class="to-button to-margin-0" value="<?php esc_attr_e('Save','car-wash-booking-system'); ?>"/>
			</li>
		</ul>
		<script type="text/javascript">
			jQuery(document).ready(function($) 
			{
				$('#<?php CBSHelper::getFormName('save_google_calendar_settings'); ?>').bind('click',function(e) 
				{
					e.preventDefault();
					$('#action').val('<?php echo PLUGIN_CBS_CONTEXT.'_option_page_save_google_calendar_settings'; ?>');
					$('#to_form').submit();
					$('#action').val('<?php echo PLUGIN_CBS_CONTEXT.'_option_page_save'; ?>');
				});
			});
		</script>