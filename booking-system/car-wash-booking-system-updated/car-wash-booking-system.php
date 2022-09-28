<?php
/* 
Plugin Name: Car Wash Booking System
Plugin URI: https://1.envato.market/car-wash-booking-system-for-wordpress
Description: Car Wash Booking System is a powerful, easy to configure and customize, car wash booking plugin for WordPress. It will help you to setup a car wash reservation system for any of your websites.
Author: QuanticaLabs
Version: 2.4
Author URI: http://quanticalabs.com
*/

require_once('include.php');
require_once((is_admin() ? PLUGIN_CBS_ADMIN_PATH.'admin.php' : PLUGIN_CBS_PUBLIC_PATH.'public.php'));

load_plugin_textdomain(PLUGIN_CBS_DOMAIN,false,dirname(plugin_basename(__FILE__)).'/languages/');

$Plugin=new CBSPlugin();

register_activation_hook(__FILE__,array($Plugin,'pluginActivation'));
add_action('init',array($Plugin,'init'));

/*mod*/
add_action('wp_loaded',function()
{
	if((int)CBSHelper::getGetValue('post_sale_sms')===1)
	{
		$PostSaleSMS=new CBSPostSaleSMS();
		$PostSaleSMS->send();
		die();
	}
});
/*mod*/