
		<div <?php CBSHelper::displayCSSClassAttribute('cbs-main-list-item-section-content cbs-clear-fix'); ?>>

			<div<?php CBSHelper::displayCSSClassAttribute('cbs-calendar-header'.($this->data['calendarMonthNavigation'] ? ' cbs-month-navigation' : '')); ?>>
				<a href="#" <?php CBSHelper::displayCSSClassAttribute('cbs-calendar-header-arrow-left cbs-meta-icon cbs-meta-icon-arrow-horizontal'); ?> data-advance-period="<?php esc_attr_e($this->data['calendarNavigationAdvancePeriod']); ?>"></a>
				<span <?php CBSHelper::displayCSSClassAttribute('cbs-calendar-header-caption'.($this->data['calendarMonthNavigation'] ? ' cbs-month-navigation-desktop' : '')); ?>>
<?php
		if($this->data['calendarMonthNavigation'])
		{
?>
					<a href="#" <?php CBSHelper::displayCSSClassAttribute('cbs-calendar-header-month-arrow-left cbs-meta-icon cbs-meta-icon-arrow-horizontal'); ?>></a>
<?php	
		}
		echo $this->data['header'];
		if($this->data['calendarMonthNavigation'])
		{
?>
					<a href="#" <?php CBSHelper::displayCSSClassAttribute('cbs-calendar-header-month-arrow-right cbs-meta-icon cbs-meta-icon-arrow-horizontal'); ?>></a>
<?php
		}
?>
				</span>
<?php
		if($this->data['calendarMonthNavigation'])
		{
?>
				<span <?php CBSHelper::displayCSSClassAttribute('cbs-calendar-header-caption cbs-month-navigation-responsive '); ?>>
<?php
		
			echo $this->data['header'];
?>
					<br>
					<a href="#" <?php CBSHelper::displayCSSClassAttribute('cbs-calendar-header-month-arrow-left cbs-meta-icon cbs-meta-icon-arrow-horizontal'); ?>></a>
					<a href="#" <?php CBSHelper::displayCSSClassAttribute('cbs-calendar-header-month-arrow-right cbs-meta-icon cbs-meta-icon-arrow-horizontal'); ?>></a>
				</span>
<?php
		}
?>
				<a href="#" <?php CBSHelper::displayCSSClassAttribute('cbs-calendar-header-arrow-right cbs-meta-icon cbs-meta-icon-arrow-horizontal'); ?> data-advance-period="<?php esc_attr_e($this->data['calendarNavigationAdvancePeriod']); ?>"></a>
			</div>
			
			<div<?php CBSHelper::displayCSSClassAttribute('cbs-calendar-table-wrapper'); ?>>
			
				<table <?php CBSHelper::displayCSSClassAttribute('cbs-calendar'); ?> cellpadding="0" cellspacing="0" border="0">
					
					<tr <?php CBSHelper::displayCSSClassAttribute('cbs-calendar-subheader'); ?>>
<?php
		foreach($this->data['date'] as $dateIndex=>$dateData)
		{
			$class=array('cbs-calendar-subheader-day-number');
			
			if($dateData['isToday'])
				array_push($class,'cbs-state-selected');
			elseif(!is_array($dateData['time']))
				array_push($class,'cbs-state-disable');
?>
						<th<?php CBSHelper::displayCSSClassAttribute('cbs-date-id-'.$dateData['date']['day']['number'].$dateData['date']['month']['number'].$dateData['date']['year']['number']); ?> data-date-full="<?php esc_attr_e($dateData['date']['full']); ?>">
							<div<?php CBSHelper::displayCSSClassAttribute('cbs-clear-fix'); ?>>
								<span<?php CBSHelper::displayCSSClassAttribute($class); ?>><?php echo $dateData['date']['day']['number']; ?></span>
								<span<?php CBSHelper::displayCSSClassAttribute('cbs-calendar-subheader-day-name'); ?>><?php echo $dateData['date']['day']['name']; ?></span>
							</div>
						</th>
<?php
		}
?>
					</tr>
					<tr <?php CBSHelper::displayCSSClassAttribute('cbs-calendar-data'); ?>>
<?php
		foreach($this->data['date'] as $dateIndex=>$dateData)
		{
?>
						<td>
							<div>
<?php
			if(is_array($dateData['time']))
			{
?>
								<ul<?php CBSHelper::displayCSSClassAttribute('cbs-list-reset','cbs-state-to-hidden','cbs-date-list'); ?>>
<?php
				$i=0;
				foreach($dateData['time'] as $timeIndex=>$timeData)
				{
					$class=array('cbs-date-id-'.$timeData['id']);
					
					if(((++$i)>$this->data['hourVisibleNumber']) && ($this->data['hourVisibleNumber']!=0)) array_push($class,'cbs-state-to-hidden');
?>
									<li<?php CBSHelper::displayCSSClassAttribute($class); ?>><a href="#"><?php echo esc_html(trim($timeData['hour']['number'].':'.$timeData['minute']['number'].' '.$timeData['postfix'])); ?></a></li>
<?php
				}
				
				if(($i>$this->data['hourVisibleNumber']) && ($this->data['hourVisibleNumber']!=0))
				{
?>
									<li>
										<a href="#"<?php CBSHelper::displayCSSClassAttribute('cbs-calendar-data-button-more'); ?>>
											<span><?php esc_html_e('More...','car-wash-booking-system') ?></span>
											<span class="cbs-state-hidden"><?php esc_html_e('Less...','car-wash-booking-system') ?></span>
										</a>
									</li>
<?php
				}
?>
								</ul>
<?php
			}
			else esc_html_e('Not available.','car-wash-booking-system');

?>
							</div>
						</td>
<?php
		}		
?>
					</tr>
				
				</table>
				
				<input type="hidden" name="cbs-calendar-column-count" value="0"/>
				
			</div>

		</div>