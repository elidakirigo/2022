<?php

/******************************************************************************/
/******************************************************************************/

class CBSPrice
{
	/**************************************************************************/
	
	static function formatToDisplay($value,$separator=',',$symbol=null,$symbolPosition=null)
	{
		$Validation=new CBSValidation();
		if(!$Validation->isFloat($value,0,999999999.99)) return(0.00);
		
		$value=preg_replace('/,/','.',$value);
		
		$value=number_format($value,2,$separator,'');
		
		if((!is_null($symbol)) && (!is_null($symbolPosition)))
		{
			if($symbolPosition=='left') $value=$symbol.$value;
			else $value=$value.' '.$symbol;
		}
		
		return($value);
	}
	
	/**************************************************************************/
	
	function formatToDisplay2($value,$currencyId)
	{
		$Currency=new CBSCurrency();
		return($this->formatToDisplay($value,$Currency->getSeparator($currencyId),$Currency->getSymbol($currencyId),$Currency->getSymbolPosition($currencyId)));
	}
	
	/**************************************************************************/
	
	static function formatToSave($value)
	{
		return(preg_replace('/,/','.',$value));
	}
	
	/**************************************************************************/
	
	static function getUnity($price)
	{
		$price=preg_split('/,/',self::formatToDisplay($price));
		return($price[0]);
	}
	
	/**************************************************************************/
	
	static function getDecimal($price)
	{
		$price=preg_split('/,/',self::formatToDisplay($price));
		return($price[1]);
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/