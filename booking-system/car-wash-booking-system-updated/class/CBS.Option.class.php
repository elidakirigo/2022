<?php

/******************************************************************************/
/******************************************************************************/

class CBSOption
{
	/**************************************************************************/
	
	static function createOption($refresh=false)
	{
		return(CBSGlobalData::setGlobalData(PLUGIN_CBS_CONTEXT,array('CBSOption','createOptionObject'),$refresh));				
	}
		
	/**************************************************************************/
	
	static function createOptionObject()
	{	
		return((array)get_option(PLUGIN_CBS_CONTEXT.'_option'));
	}
	
	/**************************************************************************/
	
	static function refreshOption()
	{
		return(self::createOption(true));
	}
	
	/**************************************************************************/
	
	static function getOption($name)
	{
		global $cbsGlobalData;

		self::createOption();

		if(!array_key_exists($name,$cbsGlobalData[PLUGIN_CBS_CONTEXT])) return(null);
		return($cbsGlobalData[PLUGIN_CBS_CONTEXT][$name]);		
	}

	/**************************************************************************/
	
	static function getOptionObject()
	{
		global $cbsGlobalData;
		return($cbsGlobalData[PLUGIN_CBS_CONTEXT]);
	}
	
	/**************************************************************************/
	
	static function updateOption($option)
	{
		$nOption=array();
		foreach($option as $index=>$value) $nOption[$index]=$value;
		
		$oOption=self::refreshOption();

		update_option(PLUGIN_CBS_OPTION_PREFIX.'_option',array_merge($oOption,$nOption));
		
		self::refreshOption();
	}
	
	/**************************************************************************/
	
	static function resetOption()
	{
		update_option(PLUGIN_CBS_OPTION_PREFIX.'_option',array());
		self::refreshOption();		
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/