<?php get_header();
	global $obox_mobile;
	$obox_mobile_options = $obox_mobile->get_options();

	// Slider Area
	if( !is_paged() ){
		dynamic_sidebar("mobile-slider");
	}
	if( $obox_mobile_options['home_page'] == 'widgetized' ) { ?>
		<ul class="post-list">
			<?php if( is_active_sidebar( 'mobile-home-page' ) ) dynamic_sidebar( 'mobile-home-page' ); ?>
		</ul>
	<?php } else {
		get_template_part( 'blog-home' );
		obox_mobile_pagination();
	} // if home_page = widgetized
get_footer(); ?>