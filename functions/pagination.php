<?php

function obox_mobile_pagination( $container_class = "clearfix", $ul_class = "clearfix" ) {
	global $wp_query;
	$request = $wp_query->request;
	$showpages = 12;
	$numposts = $wp_query->found_posts;
	$posts_per_page = get_option( "posts_per_page" );
	$startrow = 1;

	$pagenum = ceil( $numposts / $posts_per_page );

	if ( get_query_var( 'paged' ) ) {
		$currentpage = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
		$currentpage = get_query_var( 'page' );
	} else {
		$currentpage = 0;
	} // if get_query_var

	if ( $pagenum < $showpages ) {
		$maxpages = $pagenum;
	} elseif ( $currentpage > $showpages ) {
		$startrow = ( $currentpage - 1 );
		$maxpages = ( $startrow + $showpages - 1 );
		if ( $maxpages > $pagenum ) {
			$startrow = ( $startrow - ( $maxpages - $pagenum ) );
			$maxpages = ( $maxpages - ( $maxpages - $pagenum ) );
		}
	} else {
		$startrow = 1;
		$maxpages = $showpages;
	} // if page

	if ( $currentpage == 0 ) {
		$currentpage = 1;
	}

	if ( ( $posts_per_page && $numposts !== 0 ) && ( $numposts > $posts_per_page ) ) {
	?>
		<ul class="pagination">
			<?php if ( $currentpage !== ceil( $numposts / get_option( "posts_per_page" ) ) ) : ?>
				<li class="next"><?php next_posts_link( "Next" ); ?></li>
			<?php endif;
			if ( $currentpage != "1" ) : ?>
				<li class="previous"><?php previous_posts_link( "Prev" ); ?></li>
			<?php endif; ?>
			<li class="page-count"><?php _e("Page"); ?> <?php echo $currentpage?> of <?php echo $pagenum?></li>
		</ul>
	<?php
	} // if show pages
} // obox_mobile_pagination
