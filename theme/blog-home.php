<ul class="post-list">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			setup_postdata( $post );
			get_template_part( "content-list" );
		} // while have posts
	} else {
		get_template_part( "content-empty" );
	} // have_posts
	?>
</ul>