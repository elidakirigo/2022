
			<tr><td<?php echo $this->data['format']['separator'][2]; ?>><td></tr>
			<tr>
				<td<?php echo $this->data['format']['header']; ?>><?php esc_html_e('Services','car-wash-booking-system'); ?></td>
			</tr>
			<tr><td<?php echo $this->data['format']['separator'][3]; ?>><td></tr>
			<tr>
				<td>
<?php	
			$i=0;
			foreach($this->data['booking']['detail'] as $detailIndex=>$detailData)
			{
?>
					<div>
						<?php echo (++$i).'. '; ?>
						<?php echo esc_html($detailData->{'name'}); ?>, 
						<?php echo esc_html($detailData->{'service_type_name'}); ?>, 
						<?php echo esc_html($detailData->{'service_price_gross'}); ?>,
						<?php echo CBSHelper::displayDuration($detailData->{'duration'}); ?>
					</div>
<?php				
			}
?>
				</td>
			</tr>