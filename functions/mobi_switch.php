<?php

function obox_mobile_switch() {
	global $obox_mobile;
	if ( $obox_mobile->allow_mobile() === TRUE ) {
		if ( $obox_mobile->site_style() == "mobile" ) :
		?>
			<a class="footer-switch" href="?site_switch=normal" rel="external"><?php _e( "Desktop View" ); ?></a>
		<?php else : ?>
			<div class="footer-switch"><a href="?site_switch=mobile" class="clearfix" rel="external"><?php _e( "Mobile View" ); ?></a></div>
		<?php endif;
	} // if allow mobile
} // obox_mobile_switch

function ocmx_obox_mobile_styles() {
	wp_register_style( 'ocmx-mobile', OBOXMOBILEURL . "/default-style.css" );
	wp_enqueue_style( 'ocmx-mobile' );
} // ocmx_obox_mobile_styles

function add_obox_mobile_switch() {
	global $obox_mobile;
	if ( $obox_mobile->allow_mobile() === TRUE && $obox_mobile->site_style() != "mobile" ) {
		add_filter( "wp_footer", "obox_mobile_switch", 2 );
		add_action( "wp_print_styles", "ocmx_obox_mobile_styles" );
	} // if mobile switch
} // add_obox_mobile_switch

add_action( "init", "add_obox_mobile_switch" );
