<?php
		$Validation=new CBSValidation();

		$detail=array
		(
			array
			(
				__('First name','car-wash-booking-system'),
				'client_first_name'
			),
			array
			(
				__('Last Name','car-wash-booking-system'),
				'client_second_name'
			),
			array
			(
				__('Company name','car-wash-booking-system'),
				'client_company_name'
			),			
			array
			(
				__('Street','car-wash-booking-system'),
				'client_address_street'
			),			
			array
			(
				__('ZIP Code','car-wash-booking-system'),
				'client_address_post_code'
			),	
			array
			(
				__('City','car-wash-booking-system'),
				'client_address_city'
			),	
			array
			(
				__('State','car-wash-booking-system'),
				'client_address_state'
			),	
			array
			(
				__('Country','car-wash-booking-system'),
				'client_address_country'
			),	
			array
			(
				__('E-mail address','car-wash-booking-system'),
				'client_email_address'
			),
			array
			(
				__('Phone number','car-wash-booking-system'),
				'client_phone_number'
			),
			array
			(
				__('Vehicle make and model','car-wash-booking-system'),
				'client_vehicle'
			),
			array
			(
				__('Message','car-wash-booking-system'),
				'client_message'
			)
		);
		
		foreach($detail as $detailIndex=>$detailData)
		{
			switch($detailData[1])
			{
				case 'client_email_address':
					
					if(!$Validation->isEmailAddress($this->data['booking']['meta'][$detailData[1]]))
						unset($detail[$detailIndex]);
					
				break;
			
				default:
					
					if($Validation->isEmpty($this->data['booking']['meta'][$detailData[1]]))
						unset($detail[$detailIndex]);					
			}
		}
		
		if(count($detail))
		{
?>
			<tr><td<?php echo $this->data['format']['separator'][2]; ?>><td></tr>
			<tr>
				<td<?php echo $this->data['format']['header']; ?>><?php esc_html_e('Client details','car-wash-booking-system'); ?></td>
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
							<td<?php echo $this->data['format']['cell'][2]; ?>><?php echo nl2br(esc_html($this->data['booking']['meta'][$detailData[1]])); ?></td>
						</tr>
<?php				
			}
?>
					</table>
				</td>
			</tr>
<?php
		}