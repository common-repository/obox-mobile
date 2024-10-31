<?php get_header(); ?>

	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			get_template_part( "content" );
			if(comments_open()){comments_template();}
		} // while have posts
	} else {
		get_template_part( "content-empty" );
	} // if have opsts
	?>

<?php get_footer(); ?>
