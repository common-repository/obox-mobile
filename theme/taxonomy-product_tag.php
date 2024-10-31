<?php
/**
 * The template for displaying Woo Commerce products
 *
 * @package Layers
 * @since Layers 1.0.0
 * @version 3.5.0
 */

get_header(); ?>

<div class="title-meta medium">
    <h3 class="post-title"><?php woocommerce_page_title(); ?></h3>
    <?php obox_mobile_breadcrumbs(); ?>
</div>


<?php // Sub category listing
if( function_exists( 'woocommerce_product_loop_start' ) )  woocommerce_product_loop_start(); ?>

<?php woocommerce_product_loop_end(); ?>

<ul class="products grid">

    <?php while (have_posts()) :  the_post(); ?>
            <?php wc_get_template_part( 'content' , 'product' ); ?>
    <?php endwhile; ?>
</ul>

<?php get_footer();