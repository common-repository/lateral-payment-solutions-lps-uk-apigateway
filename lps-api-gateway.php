<?php
/*
Plugin Name: LPS Payment Gateway (API)
Plugin URI: http://www.lateralpaymentsolutions.com/cms/plugins
Description: Plugin to integrate with Lateral Payment Solutions (UK) payment gateway based on API model. For more information contact info@lpsmail.com
Version: 4.0.3
Author: LPS Tech Team
Author URI: http://www.digisource.co.in
*/
 
$active_plugins = apply_filters('active_plugins', get_option('active_plugins'));
if(in_array('woocommerce/woocommerce.php', $active_plugins)){
	add_filter('woocommerce_payment_gateways', 'add_lpsapi_payment_gateway');
	function add_lpsapi_payment_gateway( $gateways ){
		$gateways[] = 'WC_lpsapi_Payment_Gateway';
		return $gateways; 
	}

	add_action('plugins_loaded', 'init_lpsapi_payment_gateway');
	function init_lpsapi_payment_gateway(){
		require 'class-woocommerce-lpsapi-payment-gateway.php';
	}

 
	    
}
     
 


