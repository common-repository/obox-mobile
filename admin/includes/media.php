<?php

function obox_mobile_ajax_upload() {

    /**
    * Check that we're only allowing files that are specified by Pronto
    **/
    
    if( 
        'custom_logo_file' == $_POST["obox_mobile_input_name"]
        || 'custom_background_file' == $_POST["obox_mobile_input_name"]
        || 'header_ad_image_file' == $_POST["obox_mobile_input_name"]
        || 'post_ad_image_file' == $_POST["obox_mobile_input_name"]
        || 'footer_ad_image_file' == $_POST["obox_mobile_input_name"]
    ) {

        $id = media_handle_upload( $_POST["obox_mobile_input_name"], 0 );

        if ( is_wp_error( $id ) || $id == 0 )
            die( "Upload Error" );

        update_option( str_replace( "_file", "", $_POST["obox_mobile_input_name"] ), wp_get_attachment_url( $id ) );
        die( wp_get_attachment_url( $id ) );
    } else {
        die( "Upload Error" );
    }
} // obox_mobile_ajax_upload
