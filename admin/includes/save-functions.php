<?php /** This file is used to process the theme options panel settings upon Save & Reset  **/
function obox_mobile_update_options() {
	global $obox_mobile_plugin_options;

	// Turn the POST data into an array
	parse_str( $_POST[ 'data' ], $data );

	// Check the referrer
	check_ajax_referer( 'obox-mobile-save', 'obox_mobile_nonce' );

	// Get the original options
	$original_options = get_option( 'obox-mobile' );

	// Tell us which options we're saving
	$options_to_save = explode( ",", $data[ "update_ocmx" ] );

	// Tell us which options we're saving
	$options_to_save_labels = explode( ",", $data[ "obox_mobile_save_list" ] );

 	// Get the data we've posted
	$post_data = $data[ 'obox_mobile' ];

	 // Build options array
	$updated_options = array();

	// Loop through all the plugin options and save them as we go along
	foreach ( $obox_mobile_plugin_options AS $option_group => $options) {
		foreach( $options as $option) {
			if ( isset( $option["main_section"] ) ) {
				$option_array = $option["sub_elements"];
			} else {
				$option_array = array();
				$option_array[0] = $option;
			} // if main_section

			foreach ( $option_array AS $final_option) {
				if( in_array( $option_group, $options_to_save) ) {
					if( 'checkbox' == $final_option[ 'input_type' ] ){
						$updated_options[ $final_option[ 'name' ] ] = isset( $post_data[ $final_option[ 'name' ] ] );
					} else {
						if( isset( $post_data[ $final_option[ 'name' ] ] ) ) {

							if( 'text' == $final_option[ 'input_type' ] || 'hidden' == $final_option[ 'input_type' ] ) {
								$sanitized_form_data = sanitize_text_field( $post_data[ $final_option[ 'name' ] ] );
							} else if( 'memo' == $final_option[ 'input_type' ] || 'css' == $final_option[ 'input_type' ] ) {
								$sanitized_form_data = wp_filter_post_kses( $post_data[ $final_option[ 'name' ] ] );
							} else if( 'colour' == $final_option[ 'typinput_type' ] )  {
								$sanitized_form_data = sanitize_hex_color( $post_data[ $final_option[ 'name' ] ] );
							} else {
								$sanitized_form_data = sanitize_text_field( $post_data[ $final_option[ 'name' ] ] );
							}

							$updated_options[ $final_option[ 'name' ] ] = $sanitized_form_data;
						} // if isset option
					}// if checkbox
				}

			} // for each sub elements
		} // for each options
	} // for each mobile options

	// Combine all the new options
	if( is_array( $original_options ) ) {
		$new_options = array_merge( $original_options, $updated_options );
	} else {
		$new_options = $updated_options;
	}

	// Re-save the new options
	$save_notice['success'] = update_option( 'obox-mobile' , $new_options );
	$save_notice['css_class'] = ( true === $save_notice['success'] ) ? 'updated' : 'error';
	$save_notice['fade_out'] = ( true === $save_notice['success'] ) ? '2500' : '1500';

	if ( true === $save_notice['success'] ){
		$save_html = "<p><b>The following settings have been updated:</b><ul>";
		foreach($options_to_save_labels as $label){
			$save_html .= "<li>" .  $label ."</li>";
		}
		$save_html .= "</ul></p>";
	} else {
		$save_html = "<p>There were no changes to update.</p>";
	} // If update success

	$save_notice['message'] = $save_html;

	die( json_encode( $save_notice ) );
} // obox_mobile_update_options

function obox_mobile_reset_option( $option_set ) {
	global $obox_mobile_plugin_options;

	if(isset( $_POST[ 'data' ] )) {
		// Turn the POST data into an array
		parse_str( $_POST[ 'data' ], $data );

		// Tell us which options we're saving
		$options_to_save = explode( ",", $data[ "update_ocmx" ] );

	} elseif( isset( $option_set ) ) {
		$options_to_save = array();
		$options_to_save[0] = $option_set;
	}

	// Get the original options
	$original_options = get_option( 'obox-mobile' );

	 // Build options array
	$updated_options = array();

	// Loop through all the plugin options and save them as we go along
	foreach ( $obox_mobile_plugin_options AS $option_group => $options) {
		foreach( $options as $option) {
			if ( isset( $option["main_section"] ) ) {
				$option_array = $option["sub_elements"];
			} else {
				$option_array = array();
				$option_array[0] = $option;
			} // if main_section

			foreach ( $option_array AS $final_option) {
				if( in_array( $option_group, $options_to_save) ) {
					if( isset( $final_option["default"] ) ) { // If there is a default to set
						$updated_options[ $final_option["name"] ] = $final_option["default"];
					} elseif ( in_array( $final_option["name"], $original_options ) ){ // If there is no default, remove the key
						unset( $original_options[ $final_option["name"] ] );
					}
				}
			} // for each sub elements
		} // for each options
	} // for each mobile options

	// Combine all the new options
	if( is_array( $original_options ) ) {
		$new_options = array_merge( $original_options, $updated_options );
	} else {
		$new_options = $updated_options;
	}

	// Re-save the new options
	update_option( 'obox-mobile' , $new_options );

	if( isset( $_REQUEST['action'] ) && $_REQUEST['action'] != 'activate' ) {
		die();
	}
} // obox_mobile_reset_option

function obox_mobile_data_update() {
	global $wpdb;

	if(!get_option( 'obox-mobile' )) {
		$old_options = $wpdb->get_results ( "SELECT * FROM `" . $wpdb->options . "` WHERE `option_name` LIKE 'obox_mobile_%'", OBJECT );

		// Build options array
		$updated_options = array();

		foreach($old_options as $option){
			$option_name = str_replace('obox_mobile_', '', $option->option_name);
		 	$updated_options[$option_name] = $option->option_value;
		};

		// Save the new options
		update_option( 'obox-mobile' , $updated_options );
	}
} // obox_mobile_data_update

add_action( "plugins_loaded", "obox_mobile_data_update", 5 );
add_action( "obox_mobile_update_options", "obox_mobile_update_options" );
add_action( "obox_mobile_reset_option", "obox_mobile_reset_option" );