<?php

/******************************************************************************/
/******************************************************************************/

class CBSFile
{
	/**************************************************************************/
	
	static function scanDir($dir)
	{
		if(!is_dir($dir)) return(false);
		
		$file=scandir($dir);
		
		unset($file[0],$file[1]);
		
		return($file);
	}
	
	/**************************************************************************/
	
	static function fileExist($path)
	{
		return(is_file($path) && file_exists($path));
	}
	
	/**************************************************************************/
	
	static function dirExist($path)
	{
		return(is_dir($path) && file_exists($path));
	}
	
	/**************************************************************************/
	
	static function getMultisiteBlog($type='path')
	{
		$prefix=$type==='path' ? PLUGIN_CBS_MULTISITE_PATH : PLUGIN_CBS_MULTISITE_URL;
		return($prefix.get_current_blog_id().'/');
	}
	
	/**************************************************************************/
	
	static function getMultisiteBlogCSS($locationId,$type='path')
	{
		return(self::getMultisiteBlog($type).$locationId.'.css');
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/