<?php
global $post;
?>

<div class="title-meta medium">
	<h3 class="post-title"><a href="<?php echo get_permalink( $post->ID ); ?>"><?php the_title(); ?></a></h3>
	<?php if( !is_page() ) : ?>
		<?php do_action("obox_mobile_post_meta", "h5"); ?>
	<?php elseif( function_exists('is_cart') && is_cart() ) : ?>
		<?php echo  obox_mobile_breadcrumbs(); ?>
	<?php elseif( function_exists('is_checkout') && is_checkout() ) : ?>
		<?php echo  obox_mobile_breadcrumbs(); ?>
	<?php endif; ?>
</div>

<?php
echo get_obox_mobile_media(
	array(
		"postid" => $post->ID,
		"width" => 460,
		"height" => 345,
		"hide_href" => FALSE,
		"exclude_video" => FALSE,
		"imglink" => FALSE,
		"wrap" => "div",
		"wrap_class" =>
		"thumbnail single fitvid",
		"resizer" => "mobile-4-3"
	)
);  // get_obox_mobile_media
?>

<div class="post-content no-margin">
	<div class="copy">
		<?php the_content(); ?>
        <div class="pagelink"><?php wp_link_pages( "pagelink=Page %" ); ?></div>
	</div>
    
	<?php 
	obox_mobile_advert( "post" );
	do_action( "obox_mobile_author_bio" ); ?>

</div>

<?php
do_action( "obox_mobile_social_links" );

