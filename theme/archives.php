<?php
get_header();
global $wpdb;

$fetch_archive = get_posts();
$last_month = date_i18n( "m Y", strtotime( $fetch_archive[0]->post_date ) ); ?>

	<h2 class="page-title"><?php the_title(); ?></h2>
	<ul class="archive-list">
		<li class="month"><?php echo date_i18n( "M Y", strtotime( $fetch_archive[0]->post_date ) ); ?></li>
		<?php
		foreach ( $fetch_archive AS $archive_data ) {
			$author = get_userdata( $archive_data->post_author );

			if ( date_i18n( "m Y", strtotime( $archive_data->post_date ) ) !== $last_month ) :
		?>
				<li class="month"><?php echo date_i18n( "M Y", strtotime( $archive_data->post_date ) ); ?></li>
			<?php endif; ?>

			<li class="clearfix">
				<h3 class="post-title">
					<a href="<?php echo get_permalink( $archive_data->ID ); ?>"><?php echo substr( $archive_data->post_title, 0, 45 ); ?></a>
				</h3>

				<h5 class="date">
					<?php echo date_i18n( 'F dS', strtotime( $archive_data->post_date ) ); ?>,
					by <?php echo $author->display_name ?>,
					<a href="<?php echo get_permalink( $archive_data->ID ) ?>/#comments" title="Comment on <?php echo get_permalink( $archive_data->post_title ) ?>">
						<?php echo $archive_data->comment_count ?> <?php _e( "Comments", "obox-mobile" ); ?>
					</a>
				</h5>
			</li>
		<?php
			$last_month = date_i18n( "m Y", strtotime( $archive_data->post_date ) );
		} // for each archive data
		?>
		<?php obox_mobile_pagination(); ?>
	</ul>
<?php get_footer(); ?>
