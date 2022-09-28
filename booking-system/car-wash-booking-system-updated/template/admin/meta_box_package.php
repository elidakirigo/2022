<?php 
		echo $this->data['nonce']; 
?>
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-package-1"><?php esc_html_e('Services','car-wash-booking-system'); ?></a></li>
					<li><a href="#meta-box-package-2"><?php esc_html_e('Details','car-wash-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-package-1">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Services','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Add at least one service to the package (included services).','car-wash-booking-system'); ?><br/>
								<?php esc_html_e('Packages without included services are unusable and will not be displayed.','car-wash-booking-system'); ?><br/>
								<?php esc_html_e('Related services are not included in the package but will be available for selection after selecting the package.','car-wash-booking-system'); ?><br/>
							</span>
<?php
		if(count($this->data['dictionary']['service']))
		{
?>
							<div class="to-overflow-y">
								<table class="to-table">
									<thead>
										<tr>
											<th width="30%">
												<div>
													<?php esc_html_e('Service','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Service.','car-wash-booking-system'); ?></span>
												</div>
											</th>
											<th width="30%">
												<div>
													<?php esc_html_e('Service Status','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Assign service to the package.','car-wash-booking-system'); ?></span>
												</div>
											</th>
											<th width="40%">
												<div>
													<?php esc_html_e('Details','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Click on the link to get more details about the service.','car-wash-booking-system'); ?></span>
												</div>
											</th>
										</tr>
									</thead>
									<tbody>
<?php
			foreach($this->data['dictionary']['service'] as $serviceId=>$serviceData)
			{
?>
										<tr>
											<td>
												<div>
													<a href="<?php echo get_edit_post_link($serviceId); ?>"><?php echo esc_html($serviceData['post']->post_title); ?></a>
												</div>
											</td>
											<td>
												<div class="to-clear-fix">
													<div class="to-checkbox-button">
														<input type="radio" value="1" id="<?php CBSHelper::getFormName('service_type_'.$serviceId.'_1'); ?>" name="<?php CBSHelper::getFormName('service_type_'.$serviceId); ?>" <?php CBSHelper::checkedIf($this->data['service'][$serviceId],1); ?>/>
														<label for="<?php CBSHelper::getFormName('service_type_'.$serviceId.'_1'); ?>"><?php esc_html_e('Included','car-wash-booking-system'); ?></label>
														<input type="radio" value="0" id="<?php CBSHelper::getFormName('service_type_'.$serviceId.'_0'); ?>" name="<?php CBSHelper::getFormName('service_type_'.$serviceId); ?>" <?php CBSHelper::checkedIf($this->data['service'][$serviceId],0); ?>/>
														<label for="<?php CBSHelper::getFormName('service_type_'.$serviceId.'_0'); ?>"><?php esc_html_e('Not Included','car-wash-booking-system'); ?></label>
														<input type="radio" value="2" id="<?php CBSHelper::getFormName('service_type_'.$serviceId.'_2'); ?>" name="<?php CBSHelper::getFormName('service_type_'.$serviceId); ?>" <?php CBSHelper::checkedIf($this->data['service'][$serviceId],2); ?>/>
														<label for="<?php CBSHelper::getFormName('service_type_'.$serviceId.'_2'); ?>"><?php esc_html_e('Related','car-wash-booking-system'); ?></label>
													</div>
												</div>
											</td>
											<td>
												<div class="to-clear-fix">
													<a href="#" class="to-more-details to-value-<?php echo esc_attr($serviceId); ?>">
														<span><?php esc_html_e('Get more details','car-wash-booking-system'); ?></span>
														<span class="to-hidden"><?php esc_html_e('Hide details','car-wash-booking-system'); ?></span>
													</a>
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
?>
						</li>
					</ul>
				</div>
				<div id="meta-box-package-2">
<?php
		if((count($this->data['dictionary']['location'])) && (count($this->data['dictionary']['vehicle'])))
		{
?>
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Prices','car-wash-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enter the package price depending on the location and vehicle type.','car-wash-booking-system'); ?><br/>
								<?php esc_html_e('Leave the price field blank or enter "0" to display the price calculated (which is the sum of the prices of individual services included in the package).','car-wash-booking-system'); ?><br/>
							</span>
							<div class="to-overflow-y">
								<table class="to-table">
									<thead>
										<tr>
											<th style="width:15%">
												<div>
													<?php esc_html_e('Location','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Location.','car-wash-booking-system'); ?></span>
												</div>
											</th>
											<th style="width:10%">
												<div>
													<?php esc_html_e('Vehicle Type','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Vehicle type.','car-wash-booking-system'); ?></span>
												</div>
											</th>	
											<th style="width:14%">
												<div>
													<?php esc_html_e('Enable/Disable','car-wash-booking-system'); ?>
													<span class="to-legend">
														<?php esc_html_e('Assign package to vehicle.','car-wash-booking-system'); ?></br>
													</span>
												</div>
											</th>
											<th style="width:14%">
												<div>
													<?php esc_html_e('Duration','car-wash-booking-system'); ?>
													<span class="to-legend">
														<?php esc_html_e('Total duration in minutes.','car-wash-booking-system'); ?></br>
													</span>
												</div>
											</th>
											<th style="width:14%">
												<div>
													<?php esc_html_e('Price Calculated','car-wash-booking-system'); ?>
													<span class="to-legend">
														<?php esc_html_e('The sum of the prices.','car-wash-booking-system'); ?></br>
													</span>
												</div>
											</th>
											<th style="width:14%">
												<div>
													<?php esc_html_e('Price','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('New price of the package.','car-wash-booking-system'); ?></span>
												</div>
											</th>
											<th style="width:14%">
												<div>
													<?php esc_html_e('Tax Rate','car-wash-booking-system'); ?>
													<span class="to-legend"><?php esc_html_e('Tax Rate (for new prices).','car-wash-booking-system'); ?></span>
												</div>
											</th>
										</tr>
									</thead>
									<tbody>
<?php
			foreach($this->data['dictionary']['location'] as $locationId=>$locationData)
			{
				$title=true;
				foreach($this->data['dictionary']['vehicle'] as $vehicleId=>$vehicleData)
				{
?>
										<tr class="<?php echo ($title ? 'to-table-line-separator' : null); ?>">
<?php
					if($title)
					{
?>	
											<td rowspan="<?php echo count($this->data['dictionary']['vehicle']); ?>">
												<div>
													<a href="<?php echo get_edit_post_link($locationId); ?>"><?php echo esc_html($locationData['post']->post_title); ?></a>
												</div>
											</td>
<?php
					}
?>
											<td>
												<div>
													<a href="<?php echo get_edit_post_link($vehicleId); ?>"><?php echo esc_html($vehicleData['post']->post_title); ?></a>
												</div>
											</td>
											<td>
												<div class="to-clear-fix">
													<div class="to-radio-button">
														<input type="radio" value="1" id="<?php CBSHelper::getFormName('detail_enable_'.$locationId.'_'.$vehicleId.'_1'); ?>" name="<?php CBSHelper::getFormName('detail_enable_'.$locationId.'_'.$vehicleId); ?>" <?php CBSHelper::checkedIf($this->data['detail'][$locationId][$vehicleId]['enable'],1); ?>/>
														<label for="<?php CBSHelper::getFormName('detail_enable_'.$locationId.'_'.$vehicleId.'_1'); ?>" title="<?php echo sprintf(esc_attr__('Enable this package for vehicle "%s" in location "%s".'),$vehicleData['post']->post_title,$locationData['post']->post_title); ?>"><?php esc_html_e('Enabled','car-wash-booking-system'); ?></label>
														<input type="radio" value="0" id="<?php CBSHelper::getFormName('detail_enable_'.$locationId.'_'.$vehicleId.'_0'); ?>" name="<?php CBSHelper::getFormName('detail_enable_'.$locationId.'_'.$vehicleId); ?>" <?php CBSHelper::checkedIf($this->data['detail'][$locationId][$vehicleId]['enable'],0); ?>/>
														<label for="<?php CBSHelper::getFormName('detail_enable_'.$locationId.'_'.$vehicleId.'_0'); ?>" title="<?php echo sprintf(esc_attr__('Enable this package for vehicle "%s" in location "%s".'),$vehicleData['post']->post_title,$locationData['post']->post_title); ?>"><?php esc_html_e('Disabled','car-wash-booking-system'); ?></label>
													</div>
												</div>
											</td>
											<td>
												<div>
<?php 
					$duration=isset($this->data['cost'][$locationId][$vehicleId]['duration']) ? $this->data['cost'][$locationId][$vehicleId]['duration'] : 0.00;
					echo $duration; 
?>

												</div>
											</td>
											<td>
												<div>
<?php 
					$price=isset($this->data['cost'][$locationId][$vehicleId]['priceCalcNet']) ? $this->data['cost'][$locationId][$vehicleId]['priceCalcNet'] : 0.00;
					echo CBSPrice::formatToDisplay($price); 
?>
												</div>
											</td>
											<td>
												<div>
													<input type="text" value="<?php echo CBSPrice::formatToDisplay($this->data['detail'][$locationId][$vehicleId]['price']); ?>" id="<?php CBSHelper::getFormName('detail_price_'.$locationId.'_'.$vehicleId); ?>" name="<?php CBSHelper::getFormName('detail_price_'.$locationId.'_'.$vehicleId); ?>" maxlength="12" title="<?php echo sprintf(esc_attr__('Enter package price for vehicle "%s" in location "%s".'),$vehicleData['post']->post_title,$locationData['post']->post_title); ?>"/>
												</div>
											</td>
											<td>
												<div class="to-clear-fix">
													<select name="<?php CBSHelper::getFormName('detail_tax_rate_'.$locationId.'_'.$vehicleId); ?>">
														<option value="0" <?php CBSHelper::selectedIf(0,$this->data['detail'][$locationId][$vehicleId]['tax_rate']); ?>><?php esc_html_e('Default','car-wash-booking-system'); ?></option>
<?php
					if(count($this->data['dictionary']['taxRate']))
					{
						foreach($this->data['dictionary']['taxRate'] as $taxRateId=>$taxRateData)
						{
?>
														<option value="<?php echo esc_attr($taxRateId); ?>" <?php CBSHelper::selectedIf($taxRateId,$this->data['detail'][$locationId][$vehicleId]['tax_rate']); ?>><?php echo esc_html($taxRateData['post']->post_title); ?></option>		
<?php
						}
					}
?>
													</select>
												</div>
											</td>
										</tr>								
<?php
					$title=false;
				}
			}
?>
									</tbody>
								</table>
							</div>		
						</li>
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

				$('.to .to-table a.to-more-details').bind('click',function(e)
				{
					e.preventDefault();

					var $this=$(this);

					if($this.next('div').length===1)
						$this.next('div').remove();

					if($this.children('span:eq(0)').hasClass('to-hidden'))
					{
						$this.children('span:eq(1)').addClass('to-hidden');
						$this.children('span:eq(0)').removeClass('to-hidden');
						return;
					}

					var plugin=$().CBSPluginAdmin();

					var data=
					{
						action		:	'<?php echo PLUGIN_CBS_CONTEXT.'_create_service_info'; ?>',
						serviceId	:	plugin.getValueFromClass(this,'to-value-')
					};

					plugin.post(data,function(response)
					{
						var object=$(response.html);
						object.removeClass('to-margin-top-0');
						$this.parent().remove('.to').append(object);

						$this.children('span:eq(0)').addClass('to-hidden');
						$this.children('span:eq(1)').removeClass('to-hidden');
					});
				});
			});
		</script>