<?php
function obox_mobile_add_scripts() {
	if ( is_admin() ) {
		wp_enqueue_script( "jquery" );
		wp_enqueue_script( "jquery-ui-draggable" );
		wp_enqueue_script( "jquery-ui-droppable" );
		wp_enqueue_script( "jquery-ui-sortable" );
		wp_enqueue_script( "jquery-ui-tabs" );

		wp_enqueue_script( "ajaxupload", OBOXMOBILEURL . "admin/js/ajaxupload.js", array( "jquery" ) );

		if ( FALSE !== strpos( $_SERVER["REQUEST_URI"], "mobile" ) ) {
			wp_enqueue_script( "mobile-admin", OBOXMOBILEURL . "admin/js/admin.js", array( "jquery" ) );
			wp_localize_script( "mobile-admin", "ThemeAjax", array( "ajaxurl" => admin_url( "admin-ajax.php" ) ) );
			wp_enqueue_script( "mobile-upgrade", OBOXMOBILEURL . "admin/js/upgrade.js", array( "jquery" ) );
		} // if mobile
	} // if is admin

	add_action( "wp_ajax_validate_key", "obox_mobile_validate_key" );
	add_action( "wp_ajax_do_obox_mobile_upgrade", "do_obox_mobile_upgrade" );
	add_action( "wp_ajax_obox_mobile_save-options", "obox_mobile_update_options" );
	add_action( "wp_ajax_obox_mobile_reset-options", "obox_mobile_reset_option" );
	add_action( "wp_ajax_obox_mobile_ads-remove", "obox_mobile_ads_remove" );
	add_action( "wp_ajax_obox_mobile_ajax-upload", "obox_mobile_ajax_upload" );
	add_action( "wp_ajax_obox_mobile_theme-upload", "obox_mobile_theme_upload" );
	add_action( "wp_ajax_obox_mobile_theme-remove", "obox_mobile_theme_remove" );
	add_action( "wp_ajax_obox_mobile_remove-image", "obox_mobile_ajax_remove_image" );
} // obox_mobile_add_scripts

add_action( "init", "obox_mobile_add_scripts" );