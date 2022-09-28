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
							<h5><?php esc_html_e('Tax rate','car-wash-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Percentage tax rate.','car-wash-booking-system'); ?></span>
							<div>
								<input type="text" name="<?php CBSHelper::getFormName('rate'); ?>" id="<?php CBSHelper::getFormName('rate'); ?>" value="<?php echo esc_attr($this->data['meta']['rate']); ?>" />
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
			});
		</script>
