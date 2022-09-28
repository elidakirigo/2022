<?php

/******************************************************************************/
/******************************************************************************/

class CBSTemplateEmail
{
	/**************************************************************************/

	function output($file,$data=array(),$echo=true,$header=false,$footer=false)
	{
		$this->data=$data;
		ob_start();
		
		if($header) 
			include(PLUGIN_CBS_TEMPLATE_PATH.'email/part/header.php');
 		
		include(PLUGIN_CBS_TEMPLATE_PATH.'email/'.$file.'.php');
		
		if($footer) 
			include(PLUGIN_CBS_TEMPLATE_PATH.'email/part/footer.php');
		
		$value=ob_get_clean();
		
		if($echo) echo $value;
		else return($value);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/