<?php
function obox_mobile_add_admin() {
	global $add_general_page, $add_themes_page, $add_adverts_page, $add_update_page;
	add_menu_page(
		"Pronto",
		"Pronto",
		"manage_options",
		basename( __FILE__ ),
		"",
		"dashicons-smartphone"
	); // add_object_page

	$add_general_page = add_submenu_page(
		basename( __FILE__ ),
		"General Options",
		"General",
		"manage_options",
		basename( __FILE__ ),
		"obox_mobile_general_options"
	); // add_submenu_page

	$add_themes_page = add_submenu_page(
		basename( __FILE__ ),
		"Customization",
		"Customization",
		"manage_options",
		"mobile-customize",
		"obox_mobile_customization_options"
	); // add_update_page

	$add_adverts_page = add_submenu_page(
		basename( __FILE__ ),
		"Adverts",
		"Adverts",
		"manage_options",
		"mobile-adverts",
		"obox_mobile_advert_options"
	); // add_update_page

} // obox_mobile_add_admin

add_action( "admin_menu", "obox_mobile_add_admin" );