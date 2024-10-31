<?php
class obox_mobile_slider_widget extends WP_Widget {

	function __construct() {
			$widget_ops = array( 'classname' => 'obox_mobile_slider_widget', 'description' => 'Display a touch-friendly slider of post images or videos' );
			parent::__construct( 'obox_mobile_slider_widget', __('(Pronto) Slider Widget', 'obox-mobile'), $widget_ops );
    }

	public function widget( $args, $instance ) {
		extract( $args );
		rewind_posts();
		$count = $instance["post_count"] ? $instance["post_count"] : 3;
		if( isset( $instance["auto_interval"] ) && $instance["auto_interval"] != '' && is_numeric( $instance["auto_interval"] ))
			$interval = $instance["auto_interval"];
		else
			$interval = 0;

		if ( $instance["post_category"] ) {
			$use_catId = get_category_by_slug( $instance["post_category"] );
			$post_list = new WP_Query( "cat=" . $use_catId->term_id . "&posts_per_page=" . $count );
		} else {
			$post_list = new WP_Query( "posts_per_page=" . $count );
		} // if instance post category
	?>
		<div class="swipe" id="slider" <?php if( isset( $instance["auto_interval"] ) ) echo 'data-interval="'.$interval.'"'; ?>>
			<div class="swipe-wrap">
				<?php $post_count = 0;
;				while ( $post_list->have_posts() ) {
					$post_list->the_post();
					$media = get_obox_mobile_media(
						array(
							'postid' => $post_list->post->ID,
							'hide_href' => FALSE,
							'exclude_video' => TRUE,
							'imglink' => FALSE,
							'resizer' => 'mobile-4-3',
							'ignore_thumbnail_settings' => TRUE
						)
					); // get_obox_mobile_media

					if ( !empty( $media ) ) :
						$post_count++; ?>
						<div class="slide">
							<?php echo $media ?>
							<h2>
								<a href="<?php echo get_permalink( $post_list->post->ID ) ?>"><?php the_title() ?></a>
							</h2>
						</div>
					<?php endif; // media ?>
				<?php } // while posts ?>
			</div> <!-- touchslider-viewport -->
		</div> <!-- touchslider -->

		<nav>
			<ul id='position'>
				<?php for( $i = 0; $i < $post_count; $i++ ){ ?>
					<li <?php if( $i == 0 ) echo 'class="on"'; ?>></li>
				<?php } ?>
			</ul>
		</nav>
	<?php
	} // widget

	public function form( $instance ) {
		// Turn $instance array into variables
		$instance_defaults = array ( 'post_category' => 0, 'post_count' => 3, 'auto_interval' => 0);
		$instance_args = wp_parse_args( $instance, $instance_defaults );
		extract( $instance_args, EXTR_SKIP );
	?>
		<p>
			<label for="<?php echo $this->get_field_id('post_category'); ?>">Category</label>
			<select size="1" class="widefat" id="<?php echo $this->get_field_id("post_category") ?>" name="<?php echo $this->get_field_name("post_category") ?>">
				<option <?php if ( $post_category == 0 ) { echo "selected"; } ?> value="0">All</option>
				<?php foreach ( get_categories( array( 'hide_empty' => FALSE ) ) AS $option_label => $value ) { ?>
					<option <?php if ( $value->slug == esc_attr($post_category) ) { echo "selected"; } ?> value="<?php echo $value->slug ?>"><?php echo $value->cat_name ?></option>
				<?php } // foreach option loop ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('post_count'); ?>"><?php _e("Post Count", "ocmx"); ?></label>
			<select size="1" class="widefat" id="<?php echo $this->get_field_id('post_count'); ?>" name="<?php echo $this->get_field_name('post_count'); ?>">
				<?php  for($i = 1; $i < 11; $i++) { ?>
					<option <?php if($post_count == $i) : ?>selected="selected"<?php endif; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php }; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('auto_interval') ?>">Auto Slide Interval (seconds)<input class="shortfat" id="<?php echo $this->get_field_id('auto_interval') ?>" name="<?php echo $this->get_field_name('auto_interval') ?>" type="text" value="<?php echo $auto_interval; ?>" /><br /><em>(Set to 0 for no auto-sliding)</em></label>
		</p>
	<?php
	} // form

} // slider_widget
