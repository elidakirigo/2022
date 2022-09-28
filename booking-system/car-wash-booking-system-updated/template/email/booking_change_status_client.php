<?php
		$Template=new CBSTemplateEmail();
		
		$Template->output('part/booking_detail',$this->data);
		$Template->output('part/booking_service_list',$this->data);
		$Template->output('part/booking_client_address',$this->data);
		$Template->output('part/booking_location_address',$this->data);