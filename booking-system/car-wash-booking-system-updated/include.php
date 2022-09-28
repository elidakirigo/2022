<?php

/******************************************************************************/
/******************************************************************************/

require_once('define.php');

/******************************************************************************/

require_once(PLUGIN_CBS_CLASS_PATH.'CBS.File.class.php');
require_once(PLUGIN_CBS_CLASS_PATH.'CBS.Include.class.php');

CBSInclude::includeClass(PLUGIN_CBS_LIBRARY_PATH.'/stripe/init.php',array('Stripe\Stripe'));
CBSInclude::includeFileFromDir(PLUGIN_CBS_CLASS_PATH);

/******************************************************************************/
/******************************************************************************/