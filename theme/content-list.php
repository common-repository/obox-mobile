<?php
global $slider_widget,$obox_mobile;
$obox_mobile_options = $obox_mobile->get_options();

$link = get_permalink( $post->ID );

$image_class = "";
if ( ( $post->current_post == 1 ) && ( !isset( $slider_widget ) ) ) {
	$image_class = "large";
	$resizer = "mobile-4-3";
} else {
	$resizer = "thumbnail";
}

$post_image = get_obox_mobile_media(
	array(
		"postid" => $post->ID,
		"width" => 460,
		"height" => 345,
		"hide_href" => FALSE,
		"exclude_video" => FALSE,
		"imglink" => FALSE,
		"wrap" => "div",
		"wrap_class" => "post-thumbnail fitvid",
		"resizer" => $resizer,
	)
); // get_obox_mobile_media

if ( $post_image == "" ) {
	$image_class = "no-image";
}

if ( obox_mobile_has_video( $post->ID ) ) {
	$image_class = "large";
} ?>
<li class="post-item clearfix <?php echo $image_class ?>">
	<!-- Display Comment Count -->
	<?php
		if (
			( $obox_mobile_options[ "comments_usage" ] != "comments_off" ) &&
			comments_open() &&
			( $post->comment_count != "0" )
		) {
	?>
		<a href="<?php echo $link; ?>#comments" class="comment-count"><?php comments_number( "0","1","%" ); ?></a>
	<?php } ?>

	<!-- Post Image Here -->
	<?php echo $post_image ?>

	<h3 class="post-title"><a href="<?php echo $link ?>"><?php the_title() ?></a></h3>
	<?php do_action("obox_mobile_post_meta", "h5"); ?>
	<div class="copy">
		<?php
		if ( ( $post->post_excerpt != "" ) || ( $obox_mobile_options[ "auto_excerpt" ] == true ) ) {
			the_excerpt();
		} else {
			the_content( __( "Read more", "obox-mobile" ) );
		} // if excerpt
		?>
	</div>
</li>
