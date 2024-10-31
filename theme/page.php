<?php get_header(); ?>

	<?php
	if ( $post->post_name == "mobile-archives" ) {
		get_template_part( "content-archives" );
	} elseif ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			get_template_part( "content" );
			if(comments_open()){comments_template();}
		} // while have_posts
	} else {
		get_template_part( "content-empty" );
	} // if post
	?>

<?php get_footer(); ?>
