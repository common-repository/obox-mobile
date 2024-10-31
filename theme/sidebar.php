<?php if( is_active_sidebar( 'mobile-sidebar' ) || class_exists('woocommerce') ) {
	// Get the Pronto Options
	global $obox_mobile;
	$obox_mobile_options = $obox_mobile->get_options();
	// Setup font classes

	if( isset( $obox_mobile_options[ 'sidebar_fonts' ] ) && $obox_mobile_options[ 'sidebar_fonts' ] != '')
		$font_class = $obox_mobile_options[ 'sidebar_fonts' ];
	else
		$font_class = ''; ?>

	<div id="sidebar-container">
		<?php if( class_exists('woocommerce') ) :
			global $woocommerce;?>
			<div class="header-cart">
				<div class="header-mini-cart">
					<?php woocommerce_mini_cart(); ?>
				</div>
			</div>
		<?php endif; ?>
		<span></span>
		<ul class="sidebar <?php echo $font_class; ?>">
			<?php dynamic_sidebar( 'mobile-sidebar' ); ?>
		</ul>
	</div>
<?php  } //if is_active_sidebar('mobile-sidebar')