<?php

/******************************************************************************/
/******************************************************************************/

class CBSPaymentType
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->paymentType=array
		(
			'cash'=>array(__('Cash','car-wash-booking-system')),
			'paypal'=>array(__('PayPal','car-wash-booking-system')),
			'stripe'=>array(__('Stripe','car-wash-booking-system')),
		);
	}
	
	/**************************************************************************/
	
	function isPayment($paymentType)
	{
		return(isset($this->paymentType[$paymentType]));
	}
	
	/**************************************************************************/
	
	function getName($paymentType)
	{
		if(!$this->isPayment($paymentType)) return(null);
		return($this->paymentType[$paymentType][0]);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/