<?php

/******************************************************************************/
/******************************************************************************/

define('PLUGIN_CBS_VERSION','2.4');

define('PLUGIN_CBS_OPTION','cbs');
define('PLUGIN_CBS_CONTEXT','cbs');
define('PLUGIN_CBS_OPTION_PREFIX','cbs');
define('PLUGIN_CBS_DOMAIN','car-wash-booking-system');

define('PLUGIN_CBS_URL',preg_replace('/^http:/i','',plugins_url('car-wash-booking-system').'/'));
define('PLUGIN_CBS_PATH',plugin_dir_path(__FILE__));

define('PLUGIN_CBS_CLASS_PATH',PLUGIN_CBS_PATH.'class/');
define('PLUGIN_CBS_ADMIN_PATH',PLUGIN_CBS_PATH.'admin/');
define('PLUGIN_CBS_STYLE_PATH',PLUGIN_CBS_PATH.'style/');
define('PLUGIN_CBS_PUBLIC_PATH',PLUGIN_CBS_PATH.'public/');
define('PLUGIN_CBS_SCRIPT_PATH',PLUGIN_CBS_PATH.'script/');
define('PLUGIN_CBS_LIBRARY_PATH',PLUGIN_CBS_PATH.'library/');
define('PLUGIN_CBS_TEMPLATE_PATH',PLUGIN_CBS_PATH.'template/');
define('PLUGIN_CBS_MULTISITE_PATH',PLUGIN_CBS_PATH.'multisite/');
define('PLUGIN_CBS_DUMMY_CONTENT_PATH',PLUGIN_CBS_PATH.'dummy_content/');

define('PLUGIN_CBS_CLASS_URL',PLUGIN_CBS_URL.'class/');
define('PLUGIN_CBS_ADMIN_URL',PLUGIN_CBS_URL.'admin/');
define('PLUGIN_CBS_STYLE_URL',PLUGIN_CBS_URL.'style/');
define('PLUGIN_CBS_MEDIA_URL',PLUGIN_CBS_URL.'media/');
define('PLUGIN_CBS_PUBLIC_URL',PLUGIN_CBS_URL.'public/');
define('PLUGIN_CBS_SCRIPT_URL',PLUGIN_CBS_URL.'script/');
define('PLUGIN_CBS_LIBRARY_URL',PLUGIN_CBS_URL.'library/');
define('PLUGIN_CBS_TEMPLATE_URL',PLUGIN_CBS_URL.'template/');
define('PLUGIN_CBS_MULTISITE_URL',PLUGIN_CBS_URL.'multisite/');
define('PLUGIN_CBS_DUMMY_CONTENT_URL',PLUGIN_CBS_URL.'dummy_content/');

/*mod*/
define('PLUGIN_CBS_CUSTOM_DURATION',15);
/*mod*/

/******************************************************************************/
/******************************************************************************/