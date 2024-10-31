<?php
function obox_mobile_general_options() {
	$ocmx_tabs = array(
		array(
			"option_header" => "General",
			"use_function" => "obox_mobile_form_options",
			"function_args" => "general_site_options",
			"ul_class" => "admin-block-list clearfix",
		),
		array(
			"option_header" => "Post &amp; Discussion",
			"use_function" => "obox_mobile_form_options",
			"function_args" => "post_options",
			"ul_class" => "admin-block-list clearfix",
		),
		array(
			"option_header" => "Footer",
			"use_function" => "obox_mobile_form_options",
			"function_args" => "footer_options",
			"ul_class" => "admin-block-list clearfix",
		)
	);

	$ocmx_container = new OBOX_obox_mobile_Container();
	$ocmx_container->load_container( "General Options", $ocmx_tabs, "Save Changes" );
} // obox_mobile_general_options

function obox_mobile_customization_options() {
	$ocmx_tabs = array(
		array(
			"option_header" => "Colors &amp; Fonts",
			"use_function" => "obox_mobile_customization_form",
			"function_args" => "customization_options",
			"ul_class" => "customization clearfix",
		),
		array(
			"option_header" => "Logo &amp; Images",
			"use_function" => "obox_mobile_form_options",
			"function_args" => "image_options",
			"ul_class" => "admin-block-list clearfix",
		),
		array(
			"option_header" => "Custom CSS",
			"use_function" => "obox_mobile_form_options",
			"function_args" => "custom_css_options",
			"ul_class" => "admin-block-list clearfix",
		)
	);

	$ocmx_container = new OBOX_obox_mobile_Container();
	$ocmx_container->load_container( "Customization", $ocmx_tabs, "Save Changes" );
} // obox_mobile_image_options

function obox_mobile_theme_options() {
	$ocmx_tabs = array(
		array(
			"option_header" => "Themes",
			"use_function" => "obox_mobile_theme_list",
			"function_args" => "",
			"ul_class" => "clearfix",
			"base_button" => array(
				"id" => "theme-list-edit-1",
				"rel" => "",
				"href" => "#",
				"html" => "Edit List",
			),
			"top_button" => array(
				"id" => "theme-list-edit",
				"rel" => "",
				"href" => "#",
				"html" => "Edit List",
			),
		),
	);

	$ocmx_container = new OBOX_obox_mobile_Container();
	$ocmx_container->load_container( "Themes", $ocmx_tabs, "", "We recommend that you use a WebKit browser, such as Google Chrome or Safari to preview themes." );
} // obox_mobile_theme_options

function obox_mobile_advert_options() {
	global $advert_areas;
	$ocmx_tabs = array();

	foreach ( $advert_areas as $ad_area => $option ) {
		$ocmx_tabs[] = array(
			"option_header" => $ad_area,
			"use_function" => "obox_mobile_form_options",
			"function_args" => $option . "_adverts",
			"ul_class" => "admin-block-list advert clearfix",
		);
	} // for each advert area

	$ocmx_container = new OBOX_obox_mobile_Container();
	$ocmx_container->load_container( "Adverts", $ocmx_tabs );
} // obox_mobile_advert_options
