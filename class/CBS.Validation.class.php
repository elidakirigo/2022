<?php

/******************************************************************************/
/******************************************************************************/

class CBSValidation
{
	/**************************************************************************/

	function __construct($Notice=null) 
	{ 
		$this->Notice=$Notice;
	}

	/**************************************************************************/

	function isNumber($value,$minValue,$maxValue,$empty=false)
	{
		if(($empty) && ($this->isEmpty($value))) return(true);
		if(!preg_match('/^(-)?[0-9]{1,}$/',$value,$result)) return(false);
		if(!(($value>=$minValue) && ($value<=$maxValue))) return(false);

		return(true);
	}
	
	/**************************************************************************/
	
	function isFloat($value,$minValue,$maxValue,$empty=false)
	{
		$value=preg_replace('/,/','.',$value);
		
		if($this->isEmpty($value)) return($empty);
		if(floatval($value)!=$value) return(false);
		if(!preg_match('/^(-)?[0-9]+[,\.]*[0-9]*$/',$value)) return(false);
		if(!(($value>=$minValue) && ($value<=$maxValue))) return(false);
		
		return(true);
	}

	/**************************************************************************/

	function isEmpty($value)
	{
		return(strlen(trim(strval($value))) ? false : true);
	}
	
	/**************************************************************************/

	function isNotEmpty($value)
	{
		return(!$this->isEmpty($value));
	}
	
	/**************************************************************************/
	
	function isEmailAddress($value,$empty=false)
	{
		if(($empty) && ($this->isEmpty($value))) return(true);
		if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i',$value)) return(false);
		
		return(true);
	}
	
	/**************************************************************************/
	
	function isColor($value,$empty=false)
	{
		if(($empty) && ($this->isEmpty($value))) return(true);

		if($value=='transparent') return(true);
		if(preg_match('/^[a-f0-9]{6,8}$/i',$value)) return(true);

		return(false);
	}
	
	/**************************************************************************/
	
	function isURL($value,$empty=false)
	{
		if(($empty) && ($this->isEmpty($value))) return(true);
		if(!preg_match('|^(http(s)?://)?[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i',$value)) return(false);
	
		return(true);
	}
	
	/**************************************************************************/
	
	function isBool($value,$empty=false,$strict=false)
	{
		if(($empty) && ($this->isEmpty($value))) return(true);
		
		if($strict)
			return(in_array($value,array(false,true),true));
		else
			return(in_array($value,array(0,1),false));
	}
	
	/**************************************************************************/
	
	function isTime($value,$empty=false)
	{
		if(($empty) && ($this->isEmpty($value))) return(true);
		
		if(!preg_match('/^[01]?[0-9]|2[0-3]:[0-5][0-9]$/i',$value)) return(false);
		
		return(true);
	}
	
	/**************************************************************************/
	
	function isDate($value,$empty=false)
	{
		if(($empty) && ($this->isEmpty($value))) return(true);
		
		$date=preg_split('/-/',$value);
		
		if(isset($date[0],$date[1],$date[2]))
			return(checkdate($date[1],$date[0],$date[2]));
		
		return(false);
	}
	
	/**************************************************************************/

	function notice($functionName,$functionArgument,$noticeArgument)
	{
		$result=call_user_func_array(array($this,$functionName),$functionArgument);
		if(!$result) $this->Notice->addError($noticeArgument[0],$noticeArgument[1]);
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/