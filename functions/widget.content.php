<?php
class obox_mobile_content_widget extends WP_Widget {
	/** constructor */
	function __construct() {
			$widget_ops = array( 'classname' => 'obox_mobile_content_widget', 'description' => 'Display various kinds of content in a multi-column layout on your home page.' );
			parent::__construct( 'obox_mobile_content_widget', __('(Pronto) Content Widget', 'obox-mobile'), $widget_ops );
    }
	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		global $woocommerce;

		// Turn $args array into variables.
		extract( $args );

		// Turn $instance array into variables
		$instance_defaults = array ( 'excerpt_length' => 80 );
		$instance_args = wp_parse_args( $instance, $instance_defaults );
		extract( $instance_args, EXTR_SKIP );

		// Setup the post filter if it's defined
		if(isset($postfilter) && isset($instance[$postfilter]))
			$filterval = $instance[$postfilter];
		else
			$filterval = 0;

		// Set the base query args
		$post_args = array(
			"post_type" => $posttype,
			"posts_per_page" => $post_count
		);

		// Post type hack, register the post type if it does not exist
		if( !post_type_exists( $posttype ) )
			{ register_post_type( $posttype ); };

		// Filter by the chosen taxonomy
		if( isset( $postfilter ) && $postfilter != "" && $filterval != "0" ) :

			// Post type hack, register the post type if it does not exist
			if( ! taxonomy_exists( $postfilter ) )
				{ register_taxonomy( $postfilter, $posttype ); }

			$post_args['tax_query'] = array(
					array(
						"taxonomy" => $postfilter,
						"field" => "slug",
						"terms" => array( $filterval ),
						 'operator' => 'IN'
					)
				);
		endif;

		// Set the post order
		if(isset($post_order_by)) :
			$post_args['order'] = $post_order;
			$post_args['orderby'] = $post_order_by;
		endif;

		if( $layout_columns == 'one' ) {
			$last_element = 1;
		} elseif( $layout_columns == 'two' ) {
			$last_element = 2;
		} elseif( $layout_columns == 'three' ) {
			$last_element = 3;
		} elseif( $layout_columns == 'four' ) {
			$last_element = 4;
		}// if layout_columns

		// Main Post Query
		$loop = new WP_Query( $post_args ); ?>

		<li class="content-widget <?php echo $posttype; ?> clearfix">

			<?php if(isset($title) && $title != "") : ?>
				<h6 class="category-title"><?php echo $title; ?></h6>
			<?php endif; ?>

			<ul class="<?php echo $layout_columns; ?>-column content-widget-item <?php echo $posttype; ?> clearfix">
				<?php
					// Start the element counter
					$i = 1;
				?>
				<?php while ( $loop->have_posts() ) : $loop->the_post();
					global $post;

					// Setup legal post types to link through to
					$legal_post_types = array( 'post', 'page' );

					// Image settings
					$image_args  = array(
								'postid' => $post->ID,
								'width' => 500,
								'height' => 350,
								'exclude_video' => $post_thumb,
								'wrap' => 'div',
								'wrap_class' => 'post-image fitvid',
								'resizer' => 'mobile-4-3'
							);

					// If the layout is set to single column, change the image size
					if( $layout_columns == 'one' ) {
						$image_args[ 'resizer' ] = 'large';
					} elseif ( $layout_columns == 'four' ) {
						$image_args[ 'resizer' ] = 'thumbnail';
					}

					// Only allow certain post types to click through to
					if( in_array(get_post_type(), $legal_post_types ) ) :
						$link = get_permalink($post->ID);
					else :
						$link = '#';
						$image_args[ 'hide_href' ] = true;
					endif;

					$image = get_obox_mobile_media($image_args); ?>

					<li class="post-item column">

						<?php if( isset($show_title) && $show_title == "on") : ?>
							<h3 class="post-title"><a href="<?php echo $link; ?>"><?php the_title(); ?></a></h3>
						<?php endif; ?>

						<?php if( isset($show_date) && $show_date == "on") : ?>
							<h5 class="date"><?php echo date('F j, Y', strtotime($post->post_date)); ?></h5>
						<?php endif; ?>

						<?php if($post_thumb != 'none' && $image != ""):
							echo $image;
						endif; ?>

						<?php  if( isset( $show_excerpts ) && $show_excerpts == "on" ) :
							// Check if we're using a real excerpt or the content
							if( $post->post_excerpt != "") :
								$excerpt = get_the_excerpt();
								$excerpttext = strip_tags( $excerpt );
							else :
								$content = get_the_content();
								$excerpttext = strip_tags($content);
							endif;

							// If the Excerpt exists, continue
							if( $excerpttext != "" ) :
								// Check how long the excerpt is
								$counter = strlen( $excerpttext );

								// If we've set a limit on the excerpt, put it into play
								if( !isset( $excerpt_length ) || ( isset ($excerpt_length ) && $excerpt_length == '' ) ) :
									$excerpttext = $excerpttext;
								else :
									$excerpttext = substr( $excerpttext, 0, $excerpt_length );
								endif;

								// Use an ellipsis if the excerpt is longer than the count
								if ( $excerpt_length < $counter )
									$excerpttext .= '&hellip;';
									echo '<div class="copy"><p>'.$excerpttext.'</div></p>';
							endif;
						endif; ?>
					</li>
				<?php
					// Count up the li's so that we can set the "last" class to clear the last column in the list
					$i++;
					if( $i > $last_element )
						$i = 1;
				endwhile; ?>
			</ul>
		</li>

<?php
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {

		// Turn $instance array into variables
		$instance_defaults = array ( 'excerpt_length' => 80, 'post_thumb' => 1, 'posttype' => 'post', 'postfilter' => '0', 'post_count' => 4, 'layout_columns' => 2);
		$instance_args = wp_parse_args( $instance, $instance_defaults );
		extract( $instance_args, EXTR_SKIP );

		// Setup the post filter if it's defined
		if(isset($postfilter) && isset($instance[$postfilter]))
			$filterval = esc_attr($instance[$postfilter]);
		else
			$filterval = 0;

		$post_type_args = array("public" => true, "exclude_from_search" => false, "show_ui" => true);
		$post_types = get_post_types( $post_type_args, "objects");
?>

	<p><em><?php _e("Click Save after selecting a filter from each menu to load the next filter", 'obox-mobile'); ?></em></p>

	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Title", 'obox-mobile'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php if(isset($title)) echo $title; ?>" /></label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('posttype'); ?>"><?php _e("Display", 'obox-mobile'); ?></label>
		<select size="1" class="widefat" id="<?php echo $this->get_field_id("posttype"); ?>" name="<?php echo $this->get_field_name("posttype"); ?>">
			<option <?php if(!isset($posttype) || $posttype == ""){echo "selected=\"selected\"";} ?> value="">--- Select a Content Type ---</option>
			<?php foreach($post_types as $post_type => $details) :
				if( $post_type == 'media' )
					break; ?>
				<option <?php if(isset($posttype) && $posttype == $post_type){echo "selected=\"selected\"";} ?> value="<?php echo $post_type; ?>"><?php echo $details->labels->name; ?></option>
			<?php endforeach; ?>
		</select>
	</p>

	<?php if($posttype != "" && $posttype != "page") :
		$taxonomyargs = array('post_type' => $posttype, "public" => true, "exclude_from_search" => false, "show_ui" => true);
		$taxonomies = get_object_taxonomies($taxonomyargs,'objects');
		if(is_array($taxonomies) && !empty($taxonomies)) : ?>
			<p>
				<label for="<?php echo $this->get_field_id('postfilter'); ?>"><?php _e("Filter by", 'obox-mobile'); ?></label>
				<select size="1" class="widefat" id="<?php echo $this->get_field_id("postfilter"); ?>" name="<?php echo $this->get_field_name("postfilter"); ?>">
					<option <?php if($postfilter == ""){echo "selected=\"selected\"";} ?> value="">--- Select a Filter ---</option>
					<?php foreach($taxonomies as $taxonomy => $details) : ?>
						<option <?php if($postfilter == $taxonomy){echo "selected=\"selected\"";} ?> value="<?php echo $taxonomy; ?>"><?php echo $details->labels->name; ?></option>
					<?php $validtaxes[] = $taxonomy;
					endforeach; ?>
				</select>
			</p>
		<?php endif; // !empty($taxonomies)

		if(isset($validtaxes) && $postfilter != "" && ( (is_array($validtaxes) && in_array($postfilter, $validtaxes)) || !is_array($validtaxes) ) ) :
			$tax = get_taxonomy($postfilter);
			$terms = get_terms($postfilter, "orderby=count&hide_empty=0"); ?>
			<p><label for="<?php echo $this->get_field_id($postfilter); ?>"><?php echo $tax->labels->name; ?></label>
			   <select size="1" class="widefat" id="<?php echo $this->get_field_id($postfilter); ?>" name="<?php echo $this->get_field_name($postfilter); ?>">
					<option <?php if($filterval == 0){echo "selected=\"selected\"";} ?> value="0">All</option>
					<?php foreach($terms as $term => $details) :?>
						<option  <?php if($filterval == $details->slug){echo "selected=\"selected\"";} ?> value="<?php echo $details->slug; ?>"><?php echo $details->name; ?></option>
					<?php endforeach;?>
				</select>
			</p>
		<?php endif; // isset($postfilter) && $postfilter != ""
	 endif;  // $posttype != "page" &&  $posttype != ""

	// Setup the column layouts
	$layout_options = array('one' => 1, 'two' => '2'); ?>
	<p>
		<label for="<?php echo $this->get_field_id('layout_columns'); ?>"><?php _e("Column Layout", 'obox-mobile'); ?></label>
		<select size="1" class="widefat" id="<?php echo $this->get_field_id('layout_columns'); ?>" name="<?php echo $this->get_field_name('layout_columns'); ?>">
			<?php foreach($layout_options as $value => $label) : ?>
				<option <?php if($layout_columns == $value) : ?>selected="selected"<?php endif; ?> value="<?php echo $value; ?>"><?php echo $label; ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('post_count'); ?>"><?php _e("Post Count", 'obox-mobile'); ?></label>
		<select size="1" class="widefat" id="<?php echo $this->get_field_id('post_count'); ?>" name="<?php echo $this->get_field_name('post_count'); ?>">
			<?php $i = 1;
			while($i < 13) :?>
				<option <?php if($post_count == $i) : ?>selected="selected"<?php endif; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php if($i < 1) :
					$i++;
				else:
					$i=($i+1);
				endif;
			endwhile; ?>
		</select>
	</p>
	<?php  // Setup the order values
	$order_params = array("date" => "Post Date", "title" => "Post Title", "rand" => "Random",  "comment_count" => "Comment Count",  "menu_order" => "Menu Order"); ?>
	<p>
		<label for="<?php echo $this->get_field_id('post_order_by'); ?>"><?php _e("Order By", 'obox-mobile'); ?></label>
		<select size="1" class="widefat" id="<?php echo $this->get_field_id('post_order_by'); ?>" name="<?php echo $this->get_field_name('post_order_by'); ?>">
			<?php foreach($order_params as $value => $label) :?>
				<option  <?php if(isset($post_order_by) && $post_order_by == $value){echo "selected=\"selected\"";} ?> value="<?php echo $value; ?>"><?php echo $label; ?></option>
			<?php endforeach;?>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('post_order'); ?>"><?php _e("Order", 'obox-mobile'); ?></label>
		<select size="1" class="widefat" id="<?php echo $this->get_field_id('post_order'); ?>" name="<?php echo $this->get_field_name('post_order'); ?>">
			<option <?php if(!isset($post_order) || isset($post_order) && $post_order == "DESC") : ?>selected="selected"<?php endif; ?> value="DESC"><?php _e("Descending", 'ocmx'); ?></option>
			<option <?php if(isset($post_order) && $post_order == "ASC") : ?>selected="selected"<?php endif; ?> value="ASC"><?php _e("Ascending", 'ocmx'); ?></option>
		</select>
	</p>
	 <p>
		<label for="<?php echo $this->get_field_id('post_thumb'); ?>"><?php _e("Prioritize Images or Videos?", 'obox-mobile'); ?></label>
		<select size="1" class="widefat" id="<?php echo $this->get_field_id('post_thumb'); ?>" name="<?php echo $this->get_field_name('post_thumb'); ?>">
				<option <?php if($post_thumb == "none") : ?>selected="selected"<?php endif; ?> value="none"><?php _e("None", 'obox-mobile'); ?></option>
				<option <?php if($post_thumb == "1") : ?>selected="selected"<?php endif; ?> value="1"><?php _e("Featured Thumbnails", 'obox-mobile'); ?></option>
				<option <?php if($post_thumb == "0") : ?>selected="selected"<?php endif; ?> value="0"><?php _e("Videos", 'obox-mobile'); ?></option>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('show_title'); ?>">
			<input type="checkbox" <?php if(isset($show_title) && $show_title == "on") : ?>checked="checked"<?php endif; ?> id="<?php echo $this->get_field_id('show_title'); ?>" name="<?php echo $this->get_field_name('show_title'); ?>">
			<?php _e("Show Titles", 'obox-mobile'); ?>
		</label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('show_date'); ?>">
			<input type="checkbox" <?php if(isset($show_date) && $show_date == "on") : ?>checked="checked"<?php endif; ?> id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>">
			<?php _e("Show Date", 'obox-mobile'); ?>
		</label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('show_excerpts'); ?>">
			<input type="checkbox" <?php if(isset($show_excerpts) && $show_excerpts == "on") : ?>checked="checked"<?php endif; ?> id="<?php echo $this->get_field_id('show_excerpts'); ?>" name="<?php echo $this->get_field_name('show_excerpts'); ?>">
			<?php if($posttype == "team"): _e("Show Social Links", 'obox-mobile'); else : _e("Show Excerpts", 'obox-mobile'); endif; ?>
		</label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('excerpt_length'); ?>"><?php _e("Excerpt Length (character count)", 'obox-mobile'); ?><input class="shortfat" id="<?php echo $this->get_field_id('excerpt_length'); ?>" name="<?php echo $this->get_field_name('excerpt_length'); ?>" type="text" value="<?php echo $excerpt_length; ?>" /><br /></label>
	</p>
<?php
	} // form

}// class