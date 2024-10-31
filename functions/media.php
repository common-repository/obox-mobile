<?php

function get_obox_mobile_image( $width = 590, $height = "", $href_class = "thumbnail", $wrap = "", $wrap_class = "", $hide_href = FALSE, $exclude_video = FALSE, $zc = 1, $imglink = FALSE, $imgnocontainer = FALSE, $resizer = "" ) {
	global $post;

	return get_obox_mobile_media(
		array(
			"postid" => $post->ID,
			"width" => $width,
			"height" => $height,
			"href_class" => $href_class,
			"wrap" => $wrap,
			"wrap_class" => $wrap_class,
			"hide_href" => $hide_href,
			"exclude_video" => $exclude_video,
			"zc" => $zc,
			"imglink" => $imglink,
			"imgnocontainer" => $imgnocontainer,
			"resizer" => $resizer,
		)
	); // get_obox_mobile_media
} // get_obox_mobile_image

function get_obox_mobile_media( $args ) {
	// Fire up the Pronto Class to get the plugin options
	global $obox_mobile;
	$obox_mobile_options = $obox_mobile->get_options();

	$args = wp_parse_args(
		$args,
		array(
			"postid" => 0,
			"width" => 590,
			"height" => "",
			"href_class" => "",
			"wrap" => "",
			"wrap_class" => "",
			"hide_href" => FALSE,
			"exclude_video" => FALSE,
			"zc" => 1,
			"imglink" => FALSE,
			"imgnocontainer" => FALSE,
			"resizer" => "medium",
			"imagefallback" => $obox_mobile_options[ 'image_fallback' ]
		)
	); // wp_parse_args

	extract( $args, EXTR_SKIP );

	// Set final HTML to nothing
	$html = "";

	if (
		( !isset( $ignore_thumbnail_settings ) ) &&
		(
			( $obox_mobile_options[ "image_usage" ] == "off" ) ||
			( !is_archive() && is_single() && $obox_mobile_options[ "image_usage" ] == "lists" ) ||
			( !is_page() && !is_single() && $obox_mobile_options[ "image_usage" ] == "posts" )
		)
	) {
		return FALSE;
	} // if display thumbnail

	if( isset( $obox_mobile_options[ "video_usage" ] ) && $obox_mobile_options[ "video_usage" ] != '' && $obox_mobile_options[ "video_usage" ] != 'main_video' ) {
		$embed_code = get_post_meta( $postid, $obox_mobile_options[ "video_usage" ], TRUE );
		$oembed_link = get_post_meta( $postid, $obox_mobile_options[ "video_usage" ], TRUE );
	} else {
		$embed_code = get_post_meta( $postid, "main_video", TRUE );
		$oembed_link = get_post_meta( $postid, "video_link", TRUE );
	}
	$self_hosted_video = get_post_meta( $postid, "video_hosted", TRUE );
	$videoheight = ( $height == "" ) ? round( $width * 0.75, 0 ) : $height;

	if ( $oembed_link != "" && ! ( strpos( $oembed_link, 'object' ) || strpos( $oembed_link, 'iframe' ) ) ) {
		$wp_embed = new WP_Embed();
		$video = $wp_embed->run_shortcode('[embed width="' . $width . '" height="' . $videoheight . '"]' . $oembed_link . '[/embed]');
	} else if ( $embed_code != "" ) {
		$video = preg_replace( "/(width\s*=\s*[\"\'])[0-9]+([\"\'])/i", "$1 $width \" wmode=\"transparent\"", $embed_code );
		$video = preg_replace( "/(height\s*=\s*[\"\'])[0-9]+([\"\'])/i", "$1 $videoheight $2", $video );
	} // if video type

	if ( $oembed_link != "" && ( strpos( $oembed_link, "vimeo" ) || strpos( $oembed_link, "youtube" ) ) ) {
		$oembed_info = get_post_meta( $postid, "oembed_info", TRUE );
	}

	if ( function_exists( "has_post_thumbnail" ) && has_post_thumbnail( $postid ) ) {
		$image = get_the_post_thumbnail( $postid, $resizer );
	} else if ( ( $oembed_link != "" ) && ( $exclude_video == TRUE ) && ( !empty( $oembed_info ) ) ) {
		$image = "<img src='" . $oembed_info['thumb_large'] . "' alt='" . $oembed_info['title'] . "' />";
	} else if ( $imagefallback == TRUE) {
		$attachments = get_posts(
			array(
				"post_type" => "attachment",
				"post_parent" => $postid,
				"numberposts" => "1",
				"orderby" => "menu_order",
				"order" => "ASC"
			)
		); // get_posts

		if( !empty( $attachments ) ) {
			$image = wp_get_attachment_image( $attachments[0]->ID, $resizer );
		}
	} // thumbnail

	if ( $imglink != TRUE) {
		$link = get_permalink( $postid );
	} else if ( $meta == "wordpress" && function_exists( "has_post_thumbnail" ) && has_post_thumbnail() ) {
		$link = wp_get_attachment_url( get_post_thumbnail_id( $postid ), "full" );
	} else {
		$link = get_post_meta( $postid, $meta, TRUE );
	} // if image link

	if ( isset( $audio ) ) {
		$html = $audio;
	} else if ( isset( $video ) && $exclude_video == FALSE ) {
		$html = $video;
	} else if ( $hide_href == FALSE && isset( $image ) ) {
		$html = "<a href='" . $link . "' class='" . $href_class . "'>" . $image . "</a>";
	} else if ( isset( $image ) ) {
		$html = $image;
	} // if setup html

	// Add the container to the whole dang thing
	if (
		!( ( $imgnocontainer == TRUE ) && isset($image) && !isset( $video ) && !$exclude_video ) &&
		( $html != "" && $wrap != "" )
	) {
		$html = "<" . $wrap . " class='" . $wrap_class . "'>" . $html . "</" . $wrap . ">";
	} // if wrap

	return $html;
} // get_obox_mobile_media

function obox_mobile_has_video( $post_id ) {
	return (
		( get_post_meta( $post_id, "main_video", TRUE ) != "" ) ||
		( get_post_meta( $post_id, "video_link", TRUE ) != "" ) ||
		( get_post_meta($post_id, "video_hosted", TRUE) != "" )
	);
} // obox_mobile_has_video

function obox_mobile_image_sizes() {
	add_image_size( "mobile-4-3", 640, 480, TRUE );
} // ocmx_setup_obox_mobile_image_sizes

add_action( "init", "obox_mobile_image_sizes" );

function obox_mobile_add_query_vars( $query_vars ) {
	$query_vars[] = "mobile-stylesheet";
	return $query_vars;
} // obox_mobile_add_query_vars

add_filter( "query_vars", "obox_mobile_add_query_vars" );

function obox_mobile_custom_css() {
	if ( isset( $_GET[ "mobile-stylesheet" ] ) && $_GET[ "mobile-stylesheet" ] == "mobile-custom" ) {
		get_template_part("/styles");
		exit;
	} // if stylesheet
} // obox_mobile_custom_css_raw

add_action( "template_redirect", "obox_mobile_custom_css" );