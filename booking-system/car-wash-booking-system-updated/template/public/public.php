<?php
		global $post;
		$Template=new CBSTemplatePublic();
		$stepsFlag=0;
		$step=1;
?>
		<div<?php CBSHelper::displayCSSClassAttribute('cbs-main','cbs-clear-fix','cbs-template-public','cbs-location-'.$this->data['locationId'],'cbs-location-content-type-'.$this->data['contentType']); ?> id="<?php echo esc_attr($this->data['id']); ?>">

			<div<?php CBSHelper::displayCSSClassAttribute('cbs-notice','cbs-notice-main'); ?>>
				<div class="cbs-notice-icon cbs-meta-icon"></div>
				<div class="cbs-notice-content">
					<div class="cbs-notice-header"></div>
					<div class="cbs-notice-text"></div>
				</div>
			</div>
			
			<form<?php CBSHelper::displayCSSClassAttribute('cbs-form'); ?>>
			
				<ul<?php CBSHelper::displayCSSClassAttribute('cbs-main-list','cbs-clear-fix','cbs-list-reset'); ?>>
					
<?php
		if($this->data['locationMeta']['enable_location_step'])
		{
			$stepsFlag=1;
			$class=array('cbs-main-list-item','cbs-main-list-item-location-list','cbs-first-step','cbs-clear-fix');
?>
					<!-- Location -->

					<li<?php CBSHelper::displayCSSClassAttribute($class); ?>>
<?php 
		$Template->output('list-element',array
		(
			'step'=>$step,
			'stepCount'=>$this->data['stepCount'],
			'header'=>array
			(
				__('Select location','car-wash-booking-system'),
			),
			'subheader'=>array
			(
				__('Select location below.','car-wash-booking-system')
			)
		));
?>
						<div<?php CBSHelper::displayCSSClassAttribute('cbs-main-list-item-section-content','cbs-clear-fix'); ?>>
<?php
		$Template->output('location-list',array
		(
			'locationId'=>$this->data['locationId'],
			'location'=>$this->data['location'],
			'locationDisplayMethod'=>$this->data['locationMeta']['location_display_method'],
			'locationsOptions'=>$this->data['locationMeta']['locations_options'],
		));
?>
						</div>
					
					</li>

<?php
			$step++;
		}

		$class=array('cbs-main-list-item','cbs-main-list-item-vehicle-list','cbs-clear-fix');
		if($this->data['locationMeta']['enable_vehicle_type'])
		{
			if($this->data['locationMeta']['steps'])
			{
				if($stepsFlag)
					array_push($class,'cbs-state-hidden');
				else
				{
					array_push($class,'cbs-first-step');
					$stepsFlag=1;
				}
			}
			elseif($this->data['locationMeta']['scroll_to_next_step'])
				array_push($class,'cbs-scroll-to-next-step');
		}
		else
		{
			array_push($class,'cbs-state-hidden','cbs-state-disable');
		}
?>
					<!-- Vehicle -->

					<li<?php CBSHelper::displayCSSClassAttribute($class); ?>>
<?php 
		$Template->output('list-element',array
		(
			'step'=>$step,
			'stepCount'=>$this->data['stepCount'],
			'header'=>array
			(
				__('Vehicle type','car-wash-booking-system'),
			),
			'subheader'=>array
			(
				__('Select vehicle type below.','car-wash-booking-system')
			)
		));
?>
						<div<?php CBSHelper::displayCSSClassAttribute('cbs-main-list-item-section-content','cbs-clear-fix'); ?>>
<?PHP
		$Template->output('vehicle-list',array
		(
			'vehicle'=>$this->data['vehicle'],
			'vehicleSelected'=>$this->data['vehicleSelected'],
		));
?>
						</div>
					
					</li>
<?php
		if($this->data['locationMeta']['enable_vehicle_type'])
			$step++;
?>
					
					<!-- Package -->
<?php
		if(in_array($this->data['locationMeta']['content_type'],array(2,3)))
		{
			$class=array('cbs-main-list-item','cbs-main-list-item-package-list','cbs-clear-fix');
			if(!count($this->data['package'])) array_push($class,'cbs-state-disable');
			if($this->data['locationMeta']['steps'])
			{
				if($stepsFlag)
					array_push($class,'cbs-state-hidden');
				else
				{
					array_push($class,'cbs-first-step');
					$stepsFlag=1;
				}
			}
			elseif($this->data['locationMeta']['scroll_to_next_step'])
				array_push($class,'cbs-scroll-to-next-step');
?>
					<li<?php CBSHelper::displayCSSClassAttribute($class); ?>>
<?php 
			$Template->output('list-element',array
			(
				'step'=>$step,
				'stepCount'=>$this->data['stepCount'],
				'header'=>array
				(
					__('Wash packages','car-wash-booking-system')
				),
				'subheader'=>array
				(
					__('Which wash is best for your vehicle?','car-wash-booking-system')
				)
			));
?>
						<div<?php CBSHelper::displayCSSClassAttribute('cbs-main-list-item-section-content','cbs-clear-fix'); ?>>
<?php
			$Template->output('package-list',array
			(
				'package'=>$this->data['package'],
				'currencySymbol'=>$this->data['currencySymbol'],
				'currencySymbolPosition'=>$this->data['currencySymbolPosition']
			));
?>
						</div>
						
					</li>
<?php
			$step++;
		}
?>
					
					<!-- Service -->
<?php
		$class=array('cbs-main-list-item','cbs-main-list-item-service-list','cbs-clear-fix');
		if(!count($this->data['service'])) array_push($class,'cbs-state-disable');
		if($this->data['locationMeta']['steps'])
		{
			if($stepsFlag)
				array_push($class,'cbs-state-hidden');
			else
			{
				array_push($class,'cbs-first-step');
				$stepsFlag=1;
			}
		}
?>
					<li<?php CBSHelper::displayCSSClassAttribute($class); ?>>
<?php 
		$data=array
		(
			'step'=>$step,
			'stepCount'=>$this->data['stepCount'],
			'header'=>array
			(
				__('Services menu','car-wash-booking-system'),
				__('Add-on options','car-wash-booking-system')
			),
			'subheader'=>array
			(
				__('A la carte services menu.','car-wash-booking-system'),
				__('Add services to your package.','car-wash-booking-system')
			)			
		);

		if($this->data['contentType']==1) 
			unset($data['header'][1],$data['subheader'][1]);
		if($this->data['contentType']==2) 
			unset($data['header'][0],$data['subheader'][0]);
			
		$Template->output('list-element',$data);
?>
						<div<?php CBSHelper::displayCSSClassAttribute('cbs-main-list-item-section-content','cbs-clear-fix'); ?>>
<?php
		$Template->output('service-list',array
		(
			'service'=>$this->data['service'],
			'currencySymbol'=>$this->data['currencySymbol'],
			'currencySymbolPosition'=>$this->data['currencySymbolPosition'],
			'currencySeparator'=>$this->data['currencySeparator'],
			'currencyId'=>$this->data['currencyId'],
			'serviceVisibleNumber'=>$this->data['serviceVisibleNumber'],
			'serviceDescription'=>$this->data['serviceDescription']
		));
?>
						</div>
						
					</li>
<?php
		$step++;
?>
				
					<!-- Date and time -->
<?php
		$class=array('cbs-main-list-item','cbs-main-list-item-calendar','cbs-clear-fix');
		if($this->data['locationMeta']['steps'])
		{
			if($stepsFlag)
				array_push($class,'cbs-state-hidden');
		}
		elseif($this->data['locationMeta']['scroll_to_next_step'])
			array_push($class,'cbs-scroll-to-next-step');
?>
					<li<?php CBSHelper::displayCSSClassAttribute($class); ?>>
<?php 
		$Template->output('list-element',array
		(
			'step'=>$step,
			'stepCount'=>$this->data['stepCount'],
			'header'=>array
			(
				__('Select date and time','car-wash-booking-system'),
			),
			'subheader'=>array
			(
				__('Click on any time to make a booking.','car-wash-booking-system')
			)
		));
?>
					<div<?php CBSHelper::displayCSSClassAttribute('cbs-main-list-item-section-content','cbs-clear-fix'); ?>>
<?php
		$Template->output('calendar',array
		(
			'date'=>$this->data['calendar']['date'],
			'header'=>$this->data['calendar']['header'],
			'hourVisibleNumber'=>$this->data['hourVisibleNumber'],
			'calendarNavigationAdvancePeriod'=>$this->data['calendarNavigationAdvancePeriod'],
			'calendarMonthNavigation'=>$this->data['calendarMonthNavigation'],
		));
?>
						</div>
					
					</li>
<?php
		$step++;
?>
					
					<!-- Booking summary -->
<?php
		$class=array('cbs-main-list-item','cbs-main-list-item-booking','cbs-clear-fix');
		if($this->data['locationMeta']['steps'])
		{
			array_push($class,'cbs-last-step');
			if($stepsFlag)
				array_push($class,'cbs-state-hidden');
		}
?>
					<li<?php CBSHelper::displayCSSClassAttribute($class); ?>>
<?php 
		$Template->output('list-element',array
		(
			'step'=>$step,
			'stepCount'=>$this->data['stepCount'],
			'header'=>array
			(
				__('Booking summary','car-wash-booking-system')
			),
			'subheader'=>array
			(
				__('Please provide us with your contact information.','car-wash-booking-system')
			),
			'contentType'=>$this->data['contentType']
		));
?>
						<div<?php CBSHelper::displayCSSClassAttribute('cbs-main-list-item-section-content','cbs-clear-fix'); ?>>
<?php
		$Template->output('booking-summary',array
		(
			'currencySymbol'=>$this->data['currencySymbol'],
			'currencySymbolPosition'=>$this->data['currencySymbolPosition'],
			'currencySeparator'=>$this->data['currencySeparator'],
		));
		
		if($this->data['enable_logging'])
		{
?>
							<div<?php CBSHelper::displayCSSClassAttribute('cbs-contact-details-options',(is_user_logged_in() ? 'cbs-state-hidden' : '')); ?>>
								<a class="cbs-button cbs-create-login-form" href="#"><?php esc_html_e('Log in','car-wash-booking-system'); ?></a>
								<?php esc_html_e('or','car-wash-booking-system'); ?>
								<a class="cbs-button cbs-create-contact-details-form" href="#"><?php esc_html_e('Place order','car-wash-booking-system'); ?></a>
							</div>
							<div<?php CBSHelper::displayCSSClassAttribute('cbs-notice','cbs-notice-contact-details'); ?>>
								<div class="cbs-notice-icon cbs-meta-icon"></div>
								<div class="cbs-notice-content">
									<div class="cbs-notice-header"></div>
									<div class="cbs-notice-text"></div>
								</div>
							</div>
<?php
		}
?>							
							<div<?php CBSHelper::displayCSSClassAttribute('cbs-main-list-item-contact-details'); ?>>
<?php
		if($this->data['enable_logging'] && is_user_logged_in())
		{
			$Template->output('booking-user-contact-details',array
			(
				'class'=>'',
				'text_1'=>$this->data['text_1'],
				'client_address_enable'=>$this->data['client_address_enable'],
				'user_contact_data'=>$this->data['user_contact_data'],
				'client_company_name_enable'=>$this->data['client_company_name_enable'],
				'client_address_street_enable'=>$this->data['client_address_street_enable'],
				'client_address_post_code_enable'=>$this->data['client_address_post_code_enable'],
				'client_address_city_enable'=>$this->data['client_address_city_enable'],
				'client_address_state_enable'=>$this->data['client_address_state_enable'],
				'client_address_country_enable'=>$this->data['client_address_country_enable'],
				'client_message_enable'=>$this->data['client_message_enable'],
				'gratuity_enable'=>$this->data['gratuity_enable'],
				'service_location_enable'=>$this->data['service_location_enable'],
				'service_location'=>$this->data['service_location'],
				'enable_coupons'=>$this->data['enable_coupons'],
				'register_user'=>0,
				'form_agreement'=>$this->data['form_agreement'],
				'payment_type'=>$this->data['payment_type'],
			));
		}
		if(!$this->data['enable_logging'])
		{
			$Template->output('booking-form',array
			(
				'class'=>'',
				'text_1'=>$this->data['text_1'],
				'client_address_enable'=>$this->data['client_address_enable'],				
				'user_contact_data'=>$this->data['user_contact_data'],
				'client_company_name_enable'=>$this->data['client_company_name_enable'],
				'client_address_street_enable'=>$this->data['client_address_street_enable'],
				'client_address_post_code_enable'=>$this->data['client_address_post_code_enable'],
				'client_address_city_enable'=>$this->data['client_address_city_enable'],
				'client_address_state_enable'=>$this->data['client_address_state_enable'],
				'client_address_country_enable'=>$this->data['client_address_country_enable'],
				'client_message_enable'=>$this->data['client_message_enable'],
				'enable_coupons'=>$this->data['enable_coupons'],
                'gratuity_enable'=>$this->data['gratuity_enable'],
				'service_location_enable'=>$this->data['service_location_enable'],
				'service_location'=>$this->data['service_location'],
				'register_user'=>0,
				'form_agreement'=>$this->data['form_agreement'],
				'payment_type'=>$this->data['payment_type'],
			));
		}
?>		
							</div>
						</div>
						
					</li>
					
<?php
		$step++;
		if($this->data['locationMeta']['steps'])
		{
			$class=array('cbs-main-list-item','cbs-main-list-item-navigation-list','cbs-clear-fix');
?>

					<!-- Section Navigation -->

					<li<?php CBSHelper::displayCSSClassAttribute($class); ?>>
						<div<?php CBSHelper::displayCSSClassAttribute('cbs-main-list-item-section-content','cbs-clear-fix'); ?>>
							<a class="cbs-button cbs-button-section-prev cbs-state-hidden" href="#">
								<span><?php esc_html_e('Prev','car-wash-booking-system'); ?></span>
							</a>
							<a class="cbs-button cbs-button-section-next" href="#">
								<span><?php esc_html_e('Next','car-wash-booking-system'); ?></span>
							</a>
						</div>
					</li>

<?php
		}
?>

				</ul>
				
				<div id="cbs-preloader"></div>
				
			</form>
<?php
		$PaymentPaypal=new CBSPaymentPaypal();
		echo $PaymentPaypal->createPaymentForm($post,$this->data['location'][$this->data['locationId']]);
?>
		</div>

		<script type="text/javascript">
			jQuery(document).ready(function($) 
			{
				$('#<?php echo $this->data['id']; ?>').CBSPlugin({locationId:<?php echo $this->data['locationId']; ?>,pageId:<?php echo $post->ID; ?>});
			});
		</script>