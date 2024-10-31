<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

get_header();

if( have_posts() ) :
	while( have_posts() ) : the_post();  ?>

        <div class="title-meta medium">
            <h3 class="post-title"><a href="<?php echo get_permalink( $post->ID ); ?>"><?php the_title(); ?></a></h3>
            <?php obox_mobile_breadcrumbs(); ?>
        </div>
    
        <?php do_action( 'woocommerce_before_single_product' ); ?>

        <?php do_action( 'woocommerce_before_single_product_summary' ); ?>
        
        <div class="woocommerce-content">

            <div class="summary entry-summary">
                <?php do_action( 'woocommerce_single_product_summary' ); ?>
            </div>

            <?php do_action( 'woocommerce_after_single_product_summary' ); ?>
        </div>
	<?php endwhile; // while has_post();

endif; // if has_post()

get_footer();