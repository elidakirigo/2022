<?php
		$Validation=new CBSValidation();

		$detail=array
		(
			array
			(
				__('Name','car-wash-booking-system'),
				'address_name'
			),
			array
			(
				__('Street','car-wash-booking-system'),
				'address_street'
			),
			array
			(
				__('Postcode','car-wash-booking-system'),
				'address_postcode'
			),
			array
			(
				__('City','car-wash-booking-system'),
				'address_city'
			),
			array
			(
				__('State','car-wash-booking-system'),
				'address_state'
			),
			array
			(
				__('Country','car-wash-booking-system'),
				'address_country'
			),
			array
			(
				__('Phone number','car-wash-booking-system'),
				'address_phone_number'
			),
			array
			(
				__('Fax number','car-wash-booking-system'),
				'address_fax_number'
			),
			array
			(
				__('E-mail address','car-wash-booking-system'),
				'address_email_address'
			)		
		);
		
		foreach($detail as $detailIndex=>$detailData)
		{
			switch($detailData[1])
			{
				case 'address_email_address':
					
					if(!$Validation->isEmailAddress($this->data['location']['meta'][$detailData[1]]))
						unset($detail[$detailIndex]);
					
				break;
			
				default:
					
					if($Validation->isEmpty($this->data['location']['meta'][$detailData[1]]))
						unset($detail[$detailIndex]);					
			}
		}
		
		if(count($detail))
		{
?>
			<tr><td<?php echo $this->data['format']['separator'][2]; ?>><td></tr>
			<tr>
				<td<?php echo $this->data['format']['header']; ?>><?php esc_html_e('Location details','car-wash-booking-system'); ?></td>
			</tr>
			<tr><td<?php echo $this->data['format']['separator'][3]; ?>><td></tr>
			<tr>
				<td>
					<table cellspacing="0" cellpadding="0">
<?php	
			foreach($detail as $detailIndex=>$detailData)
			{
?>
						<tr>
							<td<?php echo $this->data['format']['cell'][1]; ?>><?php echo esc_html($detailData[0]); ?></td>
							<td<?php echo $this->data['format']['cell'][2]; ?>><?php echo esc_html($this->data['location']['meta'][$detailData[1]]); ?></td>
						</tr>
<?php				
			}
			
			if(($Validation->isNotEmpty($this->data['location']['meta']['coordinate_latitude'])) && ($Validation->isNotEmpty($this->data['location']['meta']['coordinate_longitude'])))
			{
?>				
						<tr>
							<td<?php echo $this->data['format']['cell'][1]; ?>><?php echo esc_html__('On the map','car-wash-booking-system'); ?></td>
							<td<?php echo $this->data['format']['cell'][2]; ?>><a href="https://www.google.com/maps/place/<?php echo esc_attr($this->data['location']['meta']['coordinate_latitude']); ?>,<?php echo esc_attr($this->data['location']['meta']['coordinate_longitude']); ?>"><?php esc_html_e('Click to show location on the map','car-wash-booking-system'); ?></a></td>
						</tr>			
<?php				
			}
?>
					</table>
				</td>
			</tr>
<?php
		}