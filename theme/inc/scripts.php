<?php
function obox_mobile_default_add_scripts() {
	global $themeid;

	if (
		!strpos( $_SERVER["REQUEST_URI"], "wp-login" ) &&
		( !is_admin() || ( is_admin() && is_user_logged_in() ) )
	) {
		wp_enqueue_script( "jquery" );

		wp_enqueue_script(
			"fitvid",
			get_template_directory_uri() . "/js/fitvid.js",
			array( "jquery" )
		); // wp_enqueue_script

		wp_enqueue_script(
			"touchslider",
			get_template_directory_uri() . "/js/swipe.js",
			array( "jquery" )
		); // wp_enqueue_script

		wp_enqueue_script(
			$themeid . "-jquery",
			get_template_directory_uri() . "/js/mobile.js",
			array( "jquery" )
		); // wp_enqueue_script

		wp_enqueue_script( "comment-reply" );
	} // if
} // obox_mobile_default_add_scripts

add_action( "wp_enqueue_scripts", "obox_mobile_default_add_scripts" );

function obox_mobile_default_add_styles() {
	// Fire up the Pronto Class to get the plugin options
	global $obox_mobile;
	$obox_mobile_options = $obox_mobile->get_options();
	wp_enqueue_style( "mobile-main", get_bloginfo( "stylesheet_url" ) );
	wp_enqueue_style( "mobile-custom", get_home_url() . "?mobile-stylesheet=mobile-custom" );

	if( class_exists( "woocommerce" ) ) {
		wp_enqueue_style( "mobile-ecommerce", get_template_directory_uri() . '/woocommerce.css' );
	}

} // obox_mobile_default_add_styles

add_action( "wp_enqueue_scripts", "obox_mobile_default_add_styles" );