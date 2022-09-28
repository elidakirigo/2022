
		<div class="to to-to">

			<form name="to_form" id="to_form" method="POST" action="#">

				<div id="to_notice"></div> 

				<div class="to-header to-clear-fix">

					<div class="to-header-left">

						<div>
							<h3><?php esc_html_e('QuanticaLabs','car-wash-booking-system'); ?></h3>
							<h6><?php esc_html_e('Plugin Options','car-wash-booking-system'); ?></h6>
						</div>

					</div>

					<div class="to-header-right">

						<div>
							<h3>
								<?php esc_html_e('Car Wash Booking System','car-wash-booking-system'); ?>
							</h3>
							<h6>
								<?php echo sprintf(esc_html__('WordPress Plugin ver. %s','car-wash-booking-system'),PLUGIN_CBS_VERSION); ?>
							</h6>
							&nbsp;&nbsp;
							<a href="<?php echo esc_url('http://support.quanticalabs.com'); ?>" target="_blank"><?php esc_html_e('Support Forum',PLUGIN_CBS_VERSION); ?></a>
							<a href="<?php echo esc_url('https://1.envato.market/car-wash-booking-system-for-wordpress'); ?>" target="_blank"><?php esc_html_e('Plugin site',PLUGIN_CBS_VERSION); ?></a>
						</div>

						<a href="<?php echo esc_url('http://quanticalabs.com'); ?>" class="to-header-right-logo"></a>

					</div>

				</div>

				<div class="to-content to-clear-fix">

					<div class="to-content-left">

						<ul class="to-menu" id="to_menu">
							<li>
								<a href="#main"><?php esc_html_e('Main','car-wash-booking-system'); ?><span></span></a>
							</li>
							<li>
								<a href="#import_dummy_content"><?php esc_html_e('Import dummy content','car-wash-booking-system'); ?><span></span></a>
							</li>
							<li>
								<a href="#payment"><?php esc_html_e('Payments','car-wash-booking-system'); ?><span></span></a>
							</li>
							<li>
								<a href="#generate_coupon_codes"><?php esc_html_e('Generate coupon codes','car-wash-booking-system'); ?><span></span></a>
							</li>
							<li>
								<a href="#google_calendar"><?php esc_html_e('Google Calendar','car-wash-booking-system'); ?><span></span></a>
							</li>
							<li>
								<a href="#log_manager"><?php esc_html_e('Log manager','car-wash-booking-system'); ?><span></span></a>
								<ul>
									<li><a href="#log_manager_mail"><?php esc_html_e('Mail','car-wash-booking-system'); ?></a></li>
									<li><a href="#log_manager_stripe"><?php esc_html_e('Stripe','car-wash-booking-system'); ?></a></li>
									<li><a href="#log_manager_twilio"><?php esc_html_e('Twilio','car-wash-booking-system'); ?></a></li>
									<li><a href="#log_manager_nexmo"><?php esc_html_e('Nexmo/Vonage','car-wash-booking-system'); ?></a></li>
									<li><a href="#log_manager_google_calendar"><?php esc_html_e('Google Calendar','car-wash-booking-system'); ?></a></li>
								</ul>		
							</li>
						</ul>

					</div>

					<div class="to-content-right" id="to_panel">
<?php
		$content=array
		(
			'main',
			'import_dummy_content',
			'payment',
			'generate_coupon_codes',
			'google_calendar',
			'log_manager_mail',
			'log_manager_nexmo',
			'log_manager_stripe',
			'log_manager_twilio',
			'log_manager_google_calendar'
		);
		
		foreach($content as $value)
		{
?>
						<div id="<?php echo $value; ?>">
<?php
			$Template=new CBSTemplate($this->data,PLUGIN_CBS_TEMPLATE_PATH.'admin/option_'.$value.'.php');
			echo $Template->output(false);
?>
						</div>
<?php
		}
?>
					</div>

				</div>

				<div class="to-footer to-clear-fix">

					<div class="to-footer-left">

						<ul class="to-social-list">
							<li><a href="<?php echo esc_url('http://themeforest.net/user/QuanticaLabs?ref=quanticalabs'); ?>" class="to-social-list-envato" title="<?php esc_attr_e('Envato','car-wash-booking-system'); ?>"></a></li>
							<li><a href="<?php echo esc_url('http://www.facebook.com/QuanticaLabs'); ?>" class="to-social-list-facebook" title="<?php esc_attr_e('Facebook','car-wash-booking-system'); ?>"></a></li>
							<li><a href="<?php echo esc_url('https://twitter.com/quanticalabs'); ?>" class="to-social-list-twitter" title="<?php esc_attr_e('Twitter','car-wash-booking-system'); ?>"></a></li>
							<li><a href="<?php echo esc_url('http://quanticalabs.tumblr.com/'); ?>" class="to-social-list-tumblr" title="<?php esc_attr_e('Tumblr','car-wash-booking-system'); ?>"></a></li>
						</ul>
						
					</div>
					
					<div class="to-footer-right">
						<input type="submit" value="<?php esc_attr_e('Save changes','car-wash-booking-system'); ?>" name="Submit" id="Submit" class="to-button"/>
					</div>			
				
				</div>
				
				<input type="hidden" name="action" id="action" value="<?php echo esc_attr(PLUGIN_CBS_CONTEXT.'_option_page_save'); ?>" />
				
				<script type="text/javascript">

					jQuery(document).ready(function($)
					{
						$('.to').themeOption();
						$('.to').themeOptionElement({init:true});
					});

				</script>

			</form>
			
		</div>