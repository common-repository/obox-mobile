<?php

/*
This page is used to setup all the Mobile Menus and Sidebars.
*/

if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
			'mobile' => __( 'Mobile Navigation', 'mobile' ),
		)
	); // register_nav_menus
} // if function exists

function obox_mobile_set_menus() {
	return array(
		"mobile" => array(
			"label" => "Pages",
			"class" => "pages",
			"rel" => "pages",
			"allowfallback" => true,
		),
	);
} // obox_mobile_set_menus

function obox_mobile_menu_fallback() {
?>
<?php
} // obox_mobile_menu_fallback

function obox_mobile_setup_sidebars(){

	register_sidebar(
			array(
				'name' => 'Pronto Slider',
				'id' => 'mobile-slider',
				'description' => 'Place only the "(Pronto) - Slider" widget in this block.'
			)
	);
	register_sidebar(
			array(
				'name' => 'Pronto Home Page',
				'id' => 'mobile-home-page',
				'before_title' => '<h3 class="post-title">',
				'after_title' => '</h3>',
				'before_widget' => '<li id="%1$s" class="post-item clearfix large %2$s"><div class="copy">',
				'after_widget' => '</div></li>',
				'description' => 'Place only the "(Pronto) Content Widget" widget in this block.'
			)
	);
	register_sidebar(
			array(
				'name' => 'Pronto Sidebar',
				'id' => 'mobile-sidebar',
				'before_title' => '<h3 class="widgettitle">',
				'after_title' => '</h3>',
				'before_widget' => '<li id="%1$s" class="widget %2$s">',
				'after_widget' => '</li>',
				'description' => 'Place any standard WordPress widget here, they will display in the slide out sidebar when Pronto is active.'
			)
	); // register_sidebar

} // obox_mobile_setup_sidebars
add_action( 'init' , 'obox_mobile_setup_sidebars' );