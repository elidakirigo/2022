<?php 
		$Validation=new CBSValidation();
		echo $this->data['nonce'];	
?>
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-booking-1"><?php esc_html_e('General','car-wash-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-2"><?php esc_html_e('Details','car-wash-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-3"><?php esc_html_e('Client','car-wash-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-4"><?php esc_html_e('Payment','car-wash-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-booking-1">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Booking status','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Select booking status.','car-wash-booking-system'); ?><br/>
							</span>
							<div>
							<div class="to-radio-button">
<?php
		foreach($this->data['dictionary']['bookingStatus'] as $bookingStatusIndex=>$bookingStatusData)
		{
?>
								<input type="radio" value="<?php echo esc_attr($bookingStatusIndex); ?>" id="<?php CBSHelper::getFormName('booking_status_'.$bookingStatusIndex); ?>" name="<?php CBSHelper::getFormName('booking_status'); ?>" <?php CBSHelper::checkedIf($this->data['meta']['booking_status'],$bookingStatusIndex); ?>/>
								<label for="<?php CBSHelper::getFormName('booking_status_'.$bookingStatusIndex); ?>"><?php echo esc_html($bookingStatusData[0]); ?></label>							
<?php		
		}
?>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Duration','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Duration.','car-wash-booking-system'); ?><br/>
							</span>
							<div class="to-field-disabled">
								<?php echo esc_html($this->data['other']['bookingDuration']); ?>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Price','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Price.','car-wash-booking-system'); ?><br/>
							</span>
							<div>
								<span class="to-legend-field">
									<?php esc_html_e('Net:','car-wash-booking-system'); ?><br/>
								</span>
								<div class="to-field-disabled">
									<?php echo esc_html($this->data['other']['bookingPriceNet']); ?>
								</div>
							</div>
							<div>
								<span class="to-legend-field">
									<?php esc_html_e('Gross:','car-wash-booking-system'); ?><br/>
								</span>
								<div class="to-field-disabled">
									<?php echo esc_html($this->data['other']['bookingPriceGross']); ?>
								</div>
							</div>
							<div>
								<span class="to-legend-field">
									<?php esc_html_e('To pay (including gratuity and coupon):','car-wash-booking-system'); ?><br/>
								</span>
								<div class="to-field-disabled">
									<?php echo esc_html($this->data['other']['bookingPrice']); ?>
								</div>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Gratuity','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Gratuity.','car-wash-booking-system'); ?><br/>
							</span>
							<div class="to-field-disabled">
								<?php echo esc_html($this->data['other']['bookingGratuity']); ?>
							</div>
						</li>
<?php
		if($Validation->isNotEmpty($this->data['other']['serviceLocation']))
		{
?>
						<li>
							<h5><?php esc_html_e('Service location','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Service location.','car-wash-booking-system'); ?><br/>
							</span>
							<div class="to-field-disabled">
								<?php echo esc_html($this->data['other']['serviceLocation']); ?>
							</div>
						</li>
<?php
		}
		if(array_key_exists('coupon_id',$this->data['meta']))
		{
?>			
						<li>
							<h5><?php esc_html_e('Coupon','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Coupon.','car-wash-booking-system'); ?><br/>
							</span>
							<div class="to-field-disabled">
								<?php echo esc_html($this->data['other']['couponCode']); ?>
<?php
			if($this->data['other']['couponId'])
			{
?>
								<a href="<?php echo get_edit_post_link($this->data['other']['couponId']); ?>" class="to-float-right"><?php esc_html_e('Edit','car-wash-booking-system'); ?></a>
<?php
			}
?>
							</div>
						</li>
<?php
		}
?>
						<li>
							<h5><?php esc_html_e('Location','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Selected location.','car-wash-booking-system'); ?><br/>
							</span>
							<div class="to-field-disabled">
								<?php esc_html_e($this->data['meta']['location_name']); ?>
								<a href="<?php echo get_edit_post_link($this->data['meta']['location_id']); ?>" class="to-float-right"><?php esc_html_e('Edit','car-wash-booking-system'); ?></a>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Vehicle','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Selected vehicle type.','car-wash-booking-system'); ?><br/>
							</span>
							<div class="to-field-disabled">
								<?php esc_html_e($this->data['meta']['vehicle_name']); ?>
								<a href="<?php echo get_edit_post_link($this->data['meta']['vehicle_id']); ?>" class="to-float-right"><?php esc_html_e('Edit','car-wash-booking-system'); ?></a>
							</div>
						</li>
<?php
		if((array_key_exists('package_id',$this->data['meta'])) && ($this->data['meta']['package_id']!=0))
		{
?>
						<li>
							<h5><?php esc_html_e('Package','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Package.','car-wash-booking-system'); ?><br/>
							</span>
							<div>
								<span class="to-legend-field">
									<?php esc_html_e('Selected package.','car-wash-booking-system'); ?><br/>
								</span>
								<div class="to-field-disabled">
									<?php echo esc_html_e($this->data['meta']['package_name']); ?>
									<a href="<?php echo get_edit_post_link($this->data['meta']['package_id']); ?>" class="to-float-right"><?php esc_html_e('Edit','car-wash-booking-system'); ?></a>
								</div>
							</div>
<?php

			if((array_key_exists('packageNetPrice',$this->data['other'])) && ($this->data['other']['packageNetPrice']!=''))
			{
?>
							<div>
								<span class="to-legend-field">
									<?php esc_html_e('Package net price.','car-wash-booking-system'); ?><br/>
								</span>
								<div class="to-field-disabled">
									<?php echo esc_html($this->data['other']['packageNetPrice']); ?>
								</div>
							</div>
<?php
			}
			if((array_key_exists('packageGrossPrice',$this->data['other'])) && ($this->data['other']['packageGrossPrice']!=''))
			{
?>
							<div>
								<span class="to-legend-field">
									<?php esc_html_e('Package gross price.','car-wash-booking-system'); ?><br/>
								</span>
								<div class="to-field-disabled">
									<?php echo esc_html($this->data['other']['packageGrossPrice']); ?>
								</div>
							</div>
<?php
			}
			if((array_key_exists('packageTaxRate',$this->data['other'])) && ($this->data['other']['packageTaxRate']!='' && array_key_exists('packageIsPriceCalculated',$this->data['other'])) && ($this->data['other']['packageIsPriceCalculated']==0))
			{
?>
							<div>
								<span class="to-legend-field">
									<?php esc_html_e('Package tax rate.','car-wash-booking-system'); ?><br/>
								</span>
								<div class="to-field-disabled">
									<?php echo esc_html($this->data['other']['packageTaxRate']); ?>
								</div>
							</div>
<?php
			}
?>
						</li>
<?php
		}
?>
					</ul>
				</div>
				<div id="meta-box-booking-2">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('List of services','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('List of services.','car-wash-booking-system'); ?><br/>
							</span>
							<div>
								<table class="to-table">
									<thead>
										<tr>
											<th style="width:25%">
												<div>
													<?php esc_html_e('Name','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Name','car-wash-booking-system'); ?></span>
												</div>
											</th>
											<th style="width:15%">
												<div>
													<?php esc_html_e('Type','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Type','car-wash-booking-system'); ?></span>
												</div>
											</th>
											<th style="width:15%">
												<div>
													<?php esc_html_e('Net price','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Net price','car-wash-booking-system'); ?></span>
												</div>
											</th>
											<th style="width:15%">
												<div>
													<?php esc_html_e('Gross price','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Gross price','car-wash-booking-system'); ?></span>
												</div>
											</th>
											<th style="width:15%">
												<div>
													<?php esc_html_e('Tax rate','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Tax rate','car-wash-booking-system'); ?></span>
												</div>
											</th>
											<th style="width:15%">
												<div>
													<?php esc_html_e('Duration','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Duration in minutes','car-wash-booking-system'); ?></span>
												</div>
											</th>
										</tr>
									</thead>
									<tbody>
<?php
		foreach($this->data['booking']['detail'] as $line)
		{
?>
										<tr>
											<td>
												<div><a href="<?php echo get_edit_post_link($line->{'service_id'}); ?>"><?php esc_html_e($line->{'name'}); ?></a></div>
											</td>
											<td>
												<div>
													<?php echo esc_html($line->{'service_type_name'}); ?>
												</div>
											</td>
											<td>
												<div>
													<?php echo esc_html($line->{'service_price'}); ?>
												</div>
											</td>
											<td>
												<div>
													<?php echo esc_html($line->{'service_price_gross'}); ?>
												</div>
											</td>
											<td>
												<div>
													<?php echo esc_html($line->{'service_tax_rate'}); ?>
												</div>
											</td>
											<td>
												<div><?php esc_html_e($line->{'duration'}); ?></div>
											</td>
										</tr>								
<?php
		}
?>
									<tbody>
								</table>
							</div>
						</li>
					</ul>
				</div>
				<div id="meta-box-booking-3">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Client','car-wash-booking-system'); ?></h5>
							<span class="to-legend"> <?php esc_html_e('Client details.','car-wash-booking-system'); ?></span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('First name:','car-wash-booking-system'); ?></span>
								<div class="to-field-disabled">
									<?php echo esc_html($this->data['meta']['client_first_name']); ?>
								</div>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Last name:','car-wash-booking-system'); ?></span>
								<div class="to-field-disabled">
									<?php echo esc_html($this->data['meta']['client_second_name']); ?>
								</div>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Company name:','car-wash-booking-system'); ?></span>
								<div class="to-field-disabled">
									<?php echo esc_html($this->data['meta']['client_company_name']); ?>
								</div>	 
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Street:','car-wash-booking-system'); ?></span>
								<div class="to-field-disabled">
									<?php echo esc_html($this->data['meta']['client_address_street']); ?>
								</div>
							</div>							
							<div>
								<span class="to-legend-field"><?php esc_html_e('ZIP Code:','car-wash-booking-system'); ?></span>
								<div class="to-field-disabled">
									<?php echo esc_html($this->data['meta']['client_address_post_code']); ?>
								</div>	
							</div>
							<div>								
								<span class="to-legend-field"><?php esc_html_e('City:','car-wash-booking-system'); ?></span>
								<div class="to-field-disabled">
									<?php echo esc_html($this->data['meta']['client_address_city']); ?>
								</div>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('State:','car-wash-booking-system'); ?></span>
								<div class="to-field-disabled">
									<?php echo esc_html($this->data['meta']['client_address_state']); ?>
								</div>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Country:','car-wash-booking-system'); ?></span>
								<div class="to-field-disabled">
									<?php echo esc_html($this->data['meta']['client_address_country']); ?>
								</div>	
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('E-mail address:','car-wash-booking-system'); ?></span>
								<div class="to-field-disabled">
									<?php echo esc_html($this->data['meta']['client_email_address']); ?>
								</div>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Phone number:','car-wash-booking-system'); ?></span>
								<div class="to-field-disabled">
									<?php echo esc_html($this->data['meta']['client_phone_number']); ?>
								</div>	
							</div>							
						</li>
						<li>
							<h5><?php esc_html_e('Vehicle','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Vehicle Make and Model.','car-wash-booking-system'); ?><br/>
							</span>
							<div class="to-field-disabled">
								<?php echo esc_html($this->data['meta']['client_vehicle']); ?>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Message','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Message.','car-wash-booking-system'); ?><br/>
							</span>
							<div class="to-field-disabled">
								<?php echo esc_html($this->data['meta']['client_message']); ?>
							</div>
						</li>
					</ul>
				</div>
				<div id="meta-box-booking-4">
<?php
		if(array_key_exists('payment_type_name',$this->data['other']))
		{
?>
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Payment type','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Payment type.','car-wash-booking-system'); ?><br/>
							</span>
							<div class="to-field-disabled">
								<?php echo esc_html_e($this->data['other']['payment_type_name']); ?>
							</div>
						</li>							
<?php
			if(in_array($this->data['meta']['payment_type'],array('stripe','paypal')))
			{
?>
						<li>
							<h5><?php esc_html_e('Transactions','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('List of registered transactions for this payment.','car-wash-booking-system'); ?><br/>
							</span>
<?php
				if(array_key_exists('payment_stripe_data',$this->data['meta']))
				{
					if((is_array($this->data['meta']['payment_stripe_data'])) && (count($this->data['meta']['payment_stripe_data'])))
					{
?>						
							<div>	
								<table class="to-table to-table-fixed-layout">
									 <thead>
										<tr>
											<th style="width:15%">
												<div>
													<?php esc_html_e('Transaction ID','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Transaction ID.','car-wash-booking-system'); ?></span>
												</div>
											</th>
											<th style="width:15%">
												<div>
													<?php esc_html_e('Type','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Type.','car-wash-booking-system'); ?></span>
												</div>
											</th>
											<th style="width:15%">
												<div>
													<?php esc_html_e('Date','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Date.','car-wash-booking-system'); ?></span>
												</div>
											</th>	
											<th style="width:55%">
												<div>
													<?php esc_html_e('Details','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Status.','car-wash-booking-system'); ?></span>
												</div>
											</th>
										</tr>
									</thead>	
									<tbody>
<?php
						foreach($this->data['meta']['payment_stripe_data'] as $index=>$value)
						{
?>
										<tr>
											<td><div><?php echo esc_html($value->id); ?></div></td>
											<td><div><?php echo esc_html($value->type); ?></div></td>
											<td><div><?php echo esc_html($value->created); ?></div></td>
											<td>
												<div class="to-toggle-details">
													<a href="#"><?php esc_html_e('Toggle details','car-wash-booking-system'); ?></a>
													<div class="to-hidden">
														<pre>
															<?php var_dump($value); ?>
														</pre>
													</div>
												</div>
											</td>
										</tr>
<?php
						}
?>
									</tbody>
								</table>
							</div>
<?php						
					}
				}
				else if(array_key_exists('payment_paypal_data',$this->data['meta']))
				{
					if((is_array($this->data['meta']['payment_paypal_data'])) && (count($this->data['meta']['payment_paypal_data'])))
					{
?>

							<div>	
								<table class="to-table">
									<thead>
										<tr>
											<th style="width:15%">
												<div>
													<?php esc_html_e('Transaction ID','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Transaction ID.','car-wash-booking-system'); ?></span>
												</div>
											</th>
											<th style="width:15%">
												<div>
													<?php esc_html_e('Status','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Type.','car-wash-booking-system'); ?></span>
												</div>
											</th>
											<th style="width:15%">
												<div>
													<?php esc_html_e('Date','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Date.','car-wash-booking-system'); ?></span>
												</div>
											</th>	
											<th style="width:55%">
												<div>
													<?php esc_html_e('Details','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Details.','car-wash-booking-system'); ?></span>
												</div>
											</th>
										</tr>
									</thead>
									<tbody>
<?php
						foreach($this->data['meta']['payment_paypal_data'] as $index=>$value)
						{
?>
										<tr>
											<td><div><?php echo esc_html($value['txn_id']); ?></div></td>
											<td><div><?php echo esc_html($value['payment_status']); ?></div></td>
											<td><div><?php echo esc_html($value['payment_date']); ?></div></td>
											<td>
												<div class="to-toggle-details">
													<a href="#"><?php esc_html_e('Toggle details','car-wash-booking-system'); ?></a>
													<div class="to-hidden">
														<pre>
															<?php var_dump($value); ?>
														</pre>
													</div>
												</div>
											</td>
										</tr>
<?php
						}
?>
									</tbody>
								</table>
							</div>
<?php				
					}
				}
?>
						</li>
<?php
			}
?>
					</ul>
<?php
		}
?>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($)
			{	
				$('.to').themeOptionElement({init:true});
				
				$('.to-toggle-details>a').on('click',function(e)
				{
					e.preventDefault();
					$(this).parents('td:first').css('max-width','0px');
					$(this).next('div').toggleClass('to-hidden');
				});
			});
		</script>