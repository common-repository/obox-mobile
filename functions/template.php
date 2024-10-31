<?php
/**
 * All functions in this file are common elements accessed by all Pronto themes.
 **/
function obox_mobile_site_title() {
	global $page, $paged, $post;
	wp_title( '|', true, 'right' );
	bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'ocmx' ), max( $paged, $page ) );
} //obox_mobile_site_title

function obox_mobile_head_meta() {
	global $obox_mobile;
	$obox_mobile_options = $obox_mobile->get_options(); ?>
	<meta name="apple-mobile-web-app-capable" content="no" />
	<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta http-equiv="Content-Type" content="<?php bloginfo( "html_type" ); ?>; charset=<?php bloginfo( "charset" ); ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( "name" ); ?> RSS Feed" href="<?php bloginfo( "rss2_url" ); ?>" />
	<?php $fb_image = obox_mobile_get_fb_image();
	if(is_home()) { ?>
		<meta property="og:title" content="<?php bloginfo('name'); ?>"/>
		<meta property="og:description" content="<?php bloginfo('description'); ?>"/>
		<meta property="og:url" content="<?php echo home_url(); ?>"/>
		<?php if( isset( $fb_image ) && $fb_image != "" ){ ?>
			<meta property="og:image" content="<?php echo $fb_image; ?>"/>
		<?php } // if $fb_image ?>
		<meta property="og:type" content="<?php echo "website";?>"/>
		<meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>
	<?php } else {
		global $post; ?>
		<meta property="og:title" content="<?php the_title(); ?>"/>
		<meta property="og:description" content="<?php echo strip_tags($post->post_excerpt); ?>"/>
		<meta property="og:url" content="<?php the_permalink(); ?>"/>
		<?php if( isset( $fb_image ) && $fb_image != "" ){ ?>
			<meta property="og:image" content="<?php echo $fb_image; ?>"/>
		<?php } // if $fb_image ?>
		<meta property="og:type" content="<?php echo "article"; ?>"/>
		<meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>
	<?php } // is_home()
} // obox_mobile_head_meta

function obox_mobile_social_links() {
	global $post, $obox_mobile;
	$obox_mobile_options = $obox_mobile->get_options();

	if (
		( !isset( $obox_mobile_options[ "social_link_usage" ] ) ) ||
		( $obox_mobile_options[ "social_link_usage" ] == "off" ) ||
		( ( is_single() || is_archive() ) && $obox_mobile_options[ "social_link_usage" ] == "pages" ) ||
		( is_page() && $obox_mobile_options[ "social_link_usage" ] == "posts" )
	) {
		return FALSE;
	} // if

	$obox_mobile_facebook = $obox_mobile_options[ "facebook" ];
	$obox_mobile_twitter = $obox_mobile_options[ "twitter" ];
	$obox_mobile_googleplus = $obox_mobile_options[ "googleplus" ];
	if ( $obox_mobile_facebook !== false || $obox_mobile_twitter !== false || $obox_mobile_googleplus !== false ) : ?>
		<ul class="post-meta clearfix">
			<li class="social-links">
				<?php if ( $obox_mobile_facebook !== false ) : ?>
					<div class="social-facebook">
						<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo esc_url( get_permalink( $post->ID ) ); ?>&amp;send=false&amp;layout=button_count&amp;width=50&amp;show_faces=true&amp;font=tahoma&amp;colorscheme=light&amp;action=like&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:50px; height:21px;" allowTransparency="true"></iframe>
					</div>
				<?php endif; // obox_mobile_facebook ?>

				<?php if ( $obox_mobile_twitter !== false ) : ?>
					<div class="social-twitter">
						<a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?>">Tweet</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
					</div>
				<?php endif; // obox_mobile_twitter ?>

				<?php if ( $obox_mobile_googleplus !== false ) : ?>
					<div class="social-google">
						<!-- Place this tag where you want the +1 button to render -->
						<g:plusone size="medium" count="false" href="<?php echo get_permalink( $post->ID ); ?>"></g:plusone>

						<!-- Place this tag after the last plusone tag -->
						<script type="text/javascript">
						  (function() {
							var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
							po.src = 'https://apis.google.com/js/plusone.js';
							var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
						  })();
						</script>
					</div>
				<?php endif; // obox_mobile_googleplus ?>
			</li>
		</ul>
<?php endif; // if all
} // obox_mobile_social_links

add_action( "obox_mobile_social_links", "obox_mobile_social_links" );

function obox_mobile_post_meta( $wrap = "h5" ) {
	global $post, $obox_mobile;
	$obox_mobile_options = $obox_mobile->get_options();

	if (
		( $obox_mobile_options[ "post_meta" ] == "off" ) ||
		( ( is_single() || is_archive() ) && $obox_mobile_options[ "post_meta" ] == "pages" ) ||
		( is_page() && $obox_mobile_options[ "post_meta" ] == "posts" )
	) {
		return FALSE;
	} // if
	?>
	<<?php echo $wrap; ?> class="date">
		<?php
		if ( $obox_mobile_options[ "post_date" ] !== false ) {
			echo date( "F j, Y", strtotime( $post->post_date ) );
			$hasdate = 1;
		} // if obox_mobile_post_date

		if ( $obox_mobile_options[ "post_author" ] !== false ) {
			if ( isset( $hasdate ) ) {
				_e( " by", "obox-mobile" );
			} else {
				_e( "By", "obox-mobile" );
			}
		?>
			<?php echo the_author_posts_link(); ?>
		<?php
		} // obox_mobile_post_author

		if ( !is_page() ) {
			if ( $obox_mobile_options[ "post_tags" ] !== false ) {
				the_tags( _( "Tagged: " ), ', ' );
			} // if obox_mobile_post_tags

			if ( $obox_mobile_options[ "post_categories" ] !== false ) {
				_e( " Posted In ", "obox-mobile" );
				the_category( ', ' );
			} // if obox_mobile_post_categories
		} // if not page
		?>
	</<?php echo $wrap; ?>>
<?php
} // obox_mobile_post_meta

add_action( "obox_mobile_post_meta", "obox_mobile_post_meta" );

function obox_mobile_author_bio() {
	global $obox_mobile;
	$obox_mobile_options = $obox_mobile->get_options();
	if (
		( $obox_mobile_options[ "author_display" ] == "off" ) ||
		( ( is_single() || is_archive() ) && $obox_mobile_options[ "author_display" ] == "pages" ) ||
		( is_page() && $obox_mobile_options[ "author_display" ] == "posts" )
	) {
		return FALSE;
	} // if
	?>
	<div class="author">
		<a href="#" class="author-avatar"><?php echo get_avatar( get_the_author_meta( 'email' ), "45" ); ?></a>
		<div class="author-copy">
			<h4 class="author-name"><?php echo the_author_posts_link(); ?></h4>
			<p><?php the_author_meta( 'description' ); ?></p>
		</div>
	</div>
<?php
} // obox_mobile_author_bio

add_action( "obox_mobile_author_bio", "obox_mobile_author_bio" );

function obox_mobile_slider() {
	/* FEATURE WIDGET */
	global $obox_mobile, $slider_widget;
	$obox_mobile_options = $obox_mobile->get_options();
	if ( $obox_mobile->allow_slider() && !is_paged() ) {
		the_widget(
			'slider_widget',
			array(
				"post_category" => $obox_mobile_options[ "slider_category" ],
				"post_count" => $obox_mobile_options[ "slider_count" ],
			)
		); // widget
	} // if allow slider and is paged
} // obox_mobile_do_slider

add_action( "obox_mobile_slider", "obox_mobile_slider" );
/**
* Print pagination
*
* @param    array           $args           Arguments for this function, including 'query', 'range'
* @param    string         $wrapper        Type of html wrapper
* @param    string         $wrapper_class  Class of HTML wrapper
* @echo     string                          Post Meta HTML
*/
if( !function_exists( 'obox_mobile_pagination' ) ) {
	function obox_mobile_pagination( $args = NULL , $wrapper = 'div', $wrapper_class = 'pagination' ) {

		// Set up some globals
		global $wp_query, $paged;

		// Get the current page
		if( empty($paged ) ) $paged = ( get_query_var('page') ? get_query_var('page') : 1 );

		// Set a large number for the 'base' argument
		$big = 99999;

		// Get the correct post query
		if( !isset( $args[ 'query' ] ) ){
			$use_query = $wp_query;
		} else {
			$use_query = $args[ 'query' ];
		} ?>

		<<?php echo $wrapper; ?> class="<?php echo $wrapper_class; ?>">
			<?php echo paginate_links( array(
				'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
				'prev_next' => true,
				'mid_size' => ( isset( $args[ 'range' ] ) ? $args[ 'range' ] : 3 ) ,
				'prev_text' => '&larr;',
				'next_text' => '&rarr;',
				'type' => 'list',
				'current' => $paged,
				'total' => $use_query->max_num_pages
			) ); ?>
		</<?php echo $wrapper; ?>>
	<?php }
} // obox_mobile_pagination

if( !function_exists( 'obox_mobile_breadcrumbs' ) ) {
	function obox_mobile_breadcrumbs( $wrapper = 'div', $wrapper_class = 'bread-crumbs', $seperator = '/' ) {
		global $post;

		$current = 1;
		$breadcrumbs = obox_mobile_get_bread_crumbs(); ?>
		<<?php echo $wrapper; ?> class="<?php echo esc_attr( $wrapper_class ); ?>">
			<ul>
				<?php foreach( $breadcrumbs as $bc_key => $bc_details ){ ?>
					<?php if( 1 != $current ) { ?>
						<li><?php echo esc_html( $seperator ); ?></li>
					<?php } ?>
					<?php if( $current == count( $breadcrumbs ) ) { ?>

						<li data-key="<?php echo $bc_key; ?>"><span class="current"><?php echo $bc_details[ 'label' ]; ?></span></li>
					<?php } elseif( FALSE == $bc_details[ 'link' ] ) { ?>

						<li data-key="<?php echo $bc_key; ?>"><?php echo $bc_details[ 'label' ]; ?></li>
					<?php } else { ?>

						<li data-key="<?php echo $bc_key; ?>"><a href="<?php echo $bc_details[ 'link' ]; ?>"><?php echo $bc_details[ 'label' ]; ?></a></li>
					<?php } ?>
				<?php $current++;
				} ?>
			</ul>
		</<?php echo $wrapper; ?>>
	<?php }
} // obox_mobile_post_meta

/**
* Get breadcrumbs
*
* @return     array        Breadcrumb array
*/
if( !function_exists( 'obox_mobile_get_bread_crumbs' ) ) {
	function obox_mobile_get_bread_crumbs(){
		global $post;

		$breadcrumbs = array();

		$breadcrumbs[ 'home' ] = array(
			'link' => home_url(),
			'label' => __( 'Home', 'layerswp')
		);

		if( is_search() ) {

			$breadcrumbs[ 'search' ] = array(
				'link' => FALSE,
				'label' => __( 'Search', 'layerswp' ),
			);

		} elseif( function_exists('is_shop') && ( is_post_type_archive( 'product' ) || ( get_post_type() == "product") ) ) {

			if( function_exists( 'wc_get_page_id' )  && '-1' != wc_get_page_id('shop') ) {

				$shop_page_id = wc_get_page_id('shop');
				$shop_page = get_post( $shop_page_id );

				if( is_object ( $shop_page ) ) {

					$breadcrumbs[ 'shop_page' ] = array(
						'link' => get_permalink( $shop_page->ID ),
						'label' => $shop_page->post_title,
					);

				}

			} else {

				$breadcrumbs[ 'shop_page' ] = array(
					'link' => FALSE,
					'label' => __( 'Shop' , 'layerswp' ),
				);
			}

		} elseif( is_post_type_archive() || is_singular() || is_tax() ) {

			// Get the post type object
			$post_type = get_post_type_object( get_post_type() );

			// Check if we have the relevant information we need to query the page
			if( !empty( $post_type ) ) {

				// Query template
				if( isset( $post_type->has_archive) ) {

					$pt_slug = $post_type->has_archive;
				} elseif( isset( $post_type->labels->slug ) ) {

					$pt_slug = $post_type->labels->slug;
				}

				// Display page if it has been found
				if( !empty( $parentpage ) ) {


					$breadcrumbs[ $pt_slug. '_archive_page' ] = array(
						'link' => get_permalink( $parentpage->ID ),
						'label' => $parentpage->post_title,
					);

				}

			};

		} elseif( is_category() ){

			if( empty( $parentpage ) ) {
				$parentpage = get_page( get_option( 'page_for_posts' ) );
			}

			// Display page if it has been found
			if( !empty( $parentpage ) && 'post' !== $parentpage->post_type ) {


				$breadcrumbs[ 'post_archive_page' ] = array(
					'link' => get_permalink( $parentpage->ID ),
					'label' => $parentpage->post_title,
				);

			}
		}

		/* Categories, Taxonomies & Parent Pages

			- Page parents
			- Category & Taxonomy parents
			- Category for current post
			- Taxonomy for current post
		*/

		if( is_page() ) {

			// Start with this page's parent ID
			$parent_id = $post->post_parent;

			// Loop through parent pages and grab their IDs
			while( $parent_id ) {

				$page = get_post($parent_id);
				$parent_pages[] = $page->ID;
				$parent_id = $page->post_parent;

			}

			// If there are parent pages, output them
			if( isset( $parent_pages ) && is_array($parent_pages) ) {

				$parent_pages = array_reverse($parent_pages);

				foreach ( $parent_pages as $page_id ) {

					$c_page = get_page( $page_id );

					$breadcrumbs[ $c_page->post_name . '_page' ] = array(
						'link' => get_permalink( $page_id ),
						'label' => $c_page->post_title,
					);
				}

			}

		} elseif( is_category() || is_tax() ) {

			// Get the taxonomy object
			if( is_category() ) {

				$category_title = single_cat_title( "", false );
				$category_id = get_cat_ID( $category_title );
				$category_object = get_category( $category_id );

				if( is_object( $category_object ) ) {
					$term = $category_object->slug;
				} else {
					$term = '';
				}

				$taxonomy = 'category';
				$term_object = get_term_by( 'slug', $term , $taxonomy );

			} else {

				$term = get_query_var('term' );
				$taxonomy = get_query_var( 'taxonomy' );
				$term_object = get_term_by( 'slug', $term , $taxonomy );

			}

			if( is_object( $term_object ) )
				$parent_id = $term_object->parent;
			else
				$parent_id = FALSE;

			// Start with this terms's parent ID

			// Loop through parent terms and grab their IDs
			while( $parent_id ) {

				$cat = get_term_by( 'id' , $parent_id , $taxonomy );
				$parent_terms[] = $cat->term_id;
				$parent_id = $cat->parent;

			}

			// If there are parent terms, output them
			if( isset( $parent_terms ) && is_array($parent_terms) ) {

				$parent_terms = array_reverse($parent_terms);

				foreach ( $parent_terms as $term_id ) {

					$term = get_term_by( 'id' , $term_id , $taxonomy );

					$breadcrumbs[ $term->slug ] = array(
						'link' => get_term_link( $term_id , $taxonomy ),
						'label' => $term->name,
					);
				}

			}

		} elseif ( is_single() && get_post_type() == 'post' ) {

			// Get all post categories but use the first one in the array
			$category_array = get_the_category();

			foreach ( $category_array as $category ) {

				$breadcrumbs[  $category->slug ] = array(
					'link' => get_category_link( $category->term_id ),
					'label' => get_cat_name( $category->term_id ),
				);

			}

		} elseif( is_singular() ) {

			// Get the post type object
			$post_type = get_post_type_object( get_post_type() );

			// If this is a product, make sure we're using the right term slug
			if( is_post_type_archive( 'product' ) || ( get_post_type() == "product" ) ) {
				$taxonomy = 'product_cat';
			} elseif( !empty( $post_type ) && isset( $post_type->taxonomies[0] ) ) {
				$taxonomy = $post_type->taxonomies[0];
			};

			if( isset( $taxonomy ) && !is_wp_error( $taxonomy ) ) {
				// Get the terms
				$terms = get_the_terms( get_the_ID(), $taxonomy );

				// If this term is legal, proceed
				if( is_array( $terms ) ) {

					// Loop over the terms for this post
					foreach ( $terms as $term ) {

						$breadcrumbs[  $term->slug ] = array(
							'link' => get_term_link( $term->slug, $taxonomy ),
							'label' => $term->name,
						);
					}
				}
			}
		}

		/* Current Page / Post / Post Type

			- Page / Page / Post type title
			- Search term
			- Curreny Taxonomy
			- Current Tag
			- Current Category
		*/

		if( is_singular() ) {

			$breadcrumbs[ $post->post_name ] = array(
				'link' => get_the_permalink(),
				'label' => get_the_title(),
			);

		} elseif ( is_search() ) {

			$breadcrumbs[ 'search_term' ] = array(
				'link' => FALSE,
				'label' => get_search_query(),
			);

		} elseif( is_tax() ) {

			// Get this term's details
			$term = get_term_by( 'slug', get_query_var('term' ), get_query_var( 'taxonomy' ) );

			$breadcrumbs[ 'taxonomy' ] = array(
				'link' => FALSE,
				'label' => $term->name,
			);

		} elseif( is_tag() ) {

			// Get this term's details
			$term = get_term_by( 'slug', get_query_var('term' ), get_query_var( 'taxonomy' ) );

			$breadcrumbs[ 'tag' ] = array(
				'link' => FALSE,
				'label' => single_tag_title( '', FALSE ),
			);

		} elseif( is_category() ) {

			// Get this term's details
			$term = get_term_by( 'slug', get_query_var('term' ), get_query_var( 'taxonomy' ) );

			$breadcrumbs[ 'category' ] = array(
				'link' => FALSE,
				'label' => single_cat_title( '', FALSE ),
			);

		} elseif ( is_archive() && is_month() ) {

			$breadcrumbs[ 'month' ] = array(
				'link' => FALSE,
				'label' => get_the_date( 'F Y' ),
			);

		} elseif ( is_archive() && is_year() ) {

			$breadcrumbs[ 'year' ] = array(
				'link' => FALSE,
				'label' => get_the_date( 'F Y' ),
			);


		} elseif ( is_archive() && is_author() ) {

			$breadcrumbs[ 'author' ] = array(
				'link' => FALSE,
				'label' => get_the_author(),
			);

		}

		return apply_filters( 'obox_mobile_breadcrumbs' , $breadcrumbs );
	}
}

/**
* Get Page Title
*
* Returns an array including the title and excerpt used across the site
*
* @param    array           $args           Arguments for this function, including 'query', 'range'
* @echo     array           $title_array    Section Title & Excerpt
*/
if( !function_exists( 'obox_mobile_get_page_title' ) ) {
	function obox_mobile_get_page_title() {
		global $post;

		// Setup return
		$title_array = array();

		if(!empty($parentpage) && !is_search()) {
			$title_array['title'] = $parentpage->post_title;
			if($parentpage->post_excerpt != ''){ $title_array['excerpt'] = $parentpage->post_excerpt; }

		} elseif( function_exists('is_shop') && ( is_post_type_archive( 'product' ) || ( get_post_type() == "product") ) ) {
			if( function_exists( 'wc_get_page_id' )  && -1 != wc_get_page_id('shop') ) {
				$shop_page = get_post( wc_get_page_id('shop') );
				if( is_object( $shop_page ) ) {
					$title_array['title' ] = $shop_page->post_title;
				}
			} else {
				$title_array['title' ] = __( 'Shop' , 'layerswp' );
			}
		} elseif( is_page() ) {
			while ( have_posts() ) { the_post();
				$title_array['title'] = get_the_title();
				if( $post->post_excerpt != "") $title_array['excerpt'] = strip_tags( get_the_excerpt() );
			};
		} elseif( is_search() ) {
			$title_array['title'] = __( 'Search' , 'layerswp' );
			$title_array['excerpt'] = get_search_query();
		} elseif( is_tag() ) {
			$title_array['title'] = single_tag_title( '' , false );
			$title_array['excerpt'] = get_the_archive_description();
		} elseif( !is_page() && is_category() ) {
			$title_array['title'] = single_cat_title( '', false );
			$title_array['excerpt'] = get_the_archive_description();
		} elseif (!is_page() && get_query_var('term' ) != '' ) {
			$term = get_term_by( 'slug', get_query_var('term' ), get_query_var( 'taxonomy' ) );
			$title_array['title'] = $term->name;
			$title_array['excerpt'] = $term->description;
		} elseif( is_author() ) {
			$title_array['title'] = get_the_author();
			$title_array['excerpt'] =  get_the_author_meta('user_description');
		} elseif ( is_day() ) {
			$title_array['title' ] = sprintf( __( 'Daily Archives: %s' , 'layerswp' ), get_the_date() );
		} elseif ( is_month() ) {
			$title_array['title' ] = sprintf( __( 'Monthly Archives: %s' , 'layerswp' ), get_the_date( _x( 'F Y', 'monthly archives date format' , 'layerswp' ) ) );
		} elseif ( is_year() ) {
			$title_array['title' ] = sprintf( __( 'Yearly Archives: %s' , 'layerswp' ), get_the_date( _x( 'Y', 'yearly archives date format' , 'layerswp' ) ) );
		} elseif( is_single() ) {
			$title_array['title' ] = get_the_title();
		} else {
			$title_array['title' ] = __( 'Archives' , 'layerswp' );
		}

		return apply_filters( 'obox_mobile_get_page_title' , $title_array );
	}
}

function obox_mobile_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<a href="#" class="comment-avatar"><?php echo get_avatar($comment, 45); ?> </a>
		<div class="comment-post">
			<h4 class="comment-name">
				<a href="<?php comment_author_url(); ?>" class="commentor_url" name="comment-<?php echo $comment->comment_ID; ?>" rel="nofollow"><?php comment_author(); ?></a>
			</h4>
			<h5 class="date"><?php comment_date("d M Y"); ?></h5>
			<?php if ( $comment->comment_approved == "0" ) : ?>
				<p><?php _e( "Comment is awaiting moderation.", "obox-mobile" ); ?></p>
			<?php else :
				comment_text();
			endif; ?>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</div>
<?php } // obox_mobile_comments

function obox_mobile_get_fb_image() {
	global $post;
	$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', '' );
	$fbimage = null;
	if ( has_post_thumbnail($post->ID) ) {
		$fbimage = $src[0];
	} else {
		global $post, $posts;
		$fbimage = '';
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i',
		$post->post_content, $matches);
		if(!empty($matches[1]))
			$fbimage = $matches [1] [0];
	}
	if(empty($fbimage)) {
		$fbimage = get_the_post_thumbnail($post->ID);
	}
	return $fbimage;
} // obox_mobile_get_fb_image

function obox_mobile_register_widgets() {
	register_widget("obox_mobile_content_widget");
	register_widget("obox_mobile_slider_widget");
}
add_action( 'widgets_init', 'obox_mobile_register_widgets' );
