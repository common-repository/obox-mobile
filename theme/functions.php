<?php

global $themename, $input_prefix;

$themename = "OBOX Mobile - Default";
$themeid = "ocmx-mobile";

include_once( get_template_directory() . '/inc/scripts.php' );
if( file_exists ( get_stylesheet_directory() . '/inc/scripts.php' ) ) {
	include_once( get_stylesheet_directory() . '/inc/scripts.php' );
}

// Remove image dimensions to allow images to fit inside content container
add_filter( "the_content", "remove_thumbnail_dimensions", 10 );
function remove_thumbnail_dimensions( $html ) {
	return preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
} // remove_thumbnail_dimensions