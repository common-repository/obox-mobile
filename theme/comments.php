<?php
global $obox_mobile;
$obox_mobile_options = $obox_mobile->get_options();

if (
	( $obox_mobile_options[ "comments_usage" ] == "comments_off" ) ||
	( is_single() && $obox_mobile_options[ "comments_usage" ] == "comments_pages" ) ||
	( is_page() && $obox_mobile_options[ "comments_usage" ] == "comments_posts" )
) {
	return FALSE;
} // if comments

?>
<div class="comments">
	<?php
	comments_number(
		"",
		__( "<h3 class='section-title' id='comment-section-title'>1 Comment</h3>", "obox-mobile" ),
		__( "<h3 class='section-title' id='comment-section-title'>% Comments</h3>", "obox-mobile" )
	); // comments_number
	?>
	<ul class="comment-container">
		<?php wp_list_comments( array( 'callback' => 'obox_mobile_comments', 'style' => 'ul' ) ); ?>
	</ul>
</div> <!-- comments -->

<div class="leave-comment">
	<?php comment_form(); ?>
</div> <!-- leave-comment -->
