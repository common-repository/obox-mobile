<?php
/*
 * Plugin Name: Pronto
 * Plugin URI: http://oboxthemes.com/obox-mobile
 * Description: A framework which formats your site with a mobile theme for mobile devices.
 * Author: Obox Design
 * Version: 1.1.1
 * Author URI: http://www.oboxthemes.com/
 */

define( "OBOXMOBILE_VER", "1.1.1" );
define( "OBOXMOBILEDIR", plugin_dir_path(__FILE__) );
define( "OBOXMOBILEURL", plugin_dir_url(__FILE__) );

function obox_mobile_setup() {
	
	if( get_option( 'obox-mobile' ) )
		return;

	include( OBOXMOBILEDIR . "admin/config/options.php" );
	include( OBOXMOBILEDIR . "admin/includes/save-functions.php" );

	obox_mobile_setup_options();
	global $obox_mobile_plugin_options;
	foreach ( $obox_mobile_plugin_options AS $theme_option => $value ) {
		if ( function_exists( "obox_mobile_reset_option" ) ) {
			obox_mobile_reset_option( $theme_option );
		} // function exists
	} // for each theme option
} // obox_mobile_setup

register_activation_hook( __FILE__, "obox_mobile_setup" );

function obox_mobile_includes() {
	include_once( "admin/load-includes.php" );
} // obox_mobile_includes

add_action( "plugins_loaded", "obox_mobile_includes" );

// OBOX Mobile
function obox_mobile_init() {
	global $obox_mobile;

	$obox_mobile = new OBOX_Mobile();
	$obox_mobile->initiate();

	// Localization
	load_plugin_textdomain( "obox-mobile", FALSE, dirname( plugin_basename( __FILE__ ) ) . "/admin/lang/" );
} // begin_ocmx_mobile

add_action( "plugins_loaded", "obox_mobile_init" );