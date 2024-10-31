<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo obox_mobile_site_title(); ?></title>
	<?php obox_mobile_head_meta(); ?>
	<?php wp_head() ?>
</head>

<?php // Get the Pronto Options
global $obox_mobile;
$obox_mobile_options = $obox_mobile->get_options(); ?>
<body <?php body_class('show_normal'); ?>>
	<div id="container" data-role="page">
		

		<?php // Setup the header & font classes
		$header_class = array();

		if ( isset($obox_mobile_options[ "custom_logo" ] ) && $obox_mobile_options[ "custom_logo" ] != "" )
			$header_class[] = 'has-logo';

		if( isset( $obox_mobile_options[ 'header_fonts' ] ) && $obox_mobile_options[ 'header_fonts' ] != '')
			$header_class[] = $obox_mobile_options[ 'header_fonts' ];

		if( isset( $obox_mobile_options[ 'header_layout' ] ) && $obox_mobile_options[ 'header_layout' ] != '')
			$header_class[] = $obox_mobile_options[ 'header_layout' ]; ?>

		<div id="header-container" class="<?php if( !empty( $header_class ) ) echo implode( " ", $header_class ); ?>">
			<div id="header">
				<?php if( is_active_sidebar( 'mobile-sidebar' ) || class_exists('woocommerce') ) { ?>
					<div class="sidebar-toggle">
						<a href="#" class="sidebar-button <?php if( !empty( $header_class ) ) echo implode( " ", $header_class ); ?>">
							Sidebar
						</a>
					</div><!-- sidebar -->
				<?php } ?>

				<div class="logo <?php echo ( isset( $obox_mobile_options[ "logo_size" ] ) ? : '' ); ?>">
					<?php if ( isset($obox_mobile_options[ "custom_logo" ] ) && $obox_mobile_options[ "custom_logo" ] != "" ) : ?>
						<a href="<?php bloginfo( "url" ); ?>" class="logo-mark">
							<img src="<?php echo $obox_mobile_options[ "custom_logo" ]; ?>" alt="<?php bloginfo( "name" ); ?>" />
						</a>
					<?php endif; // mobile custom logo ?>
					<h1><a href="<?php bloginfo( "url" ); ?>"><?php bloginfo( "name" ); ?></a></h1>
				</div><!-- logo -->
				<?php if ( has_nav_menu( 'mobile' ) ) : ?>
					<div class="menu-toggle">
						<a href="#" class="drop-down <?php if ( isset( $obox_mobile_options[ "menu_label" ] ) ) { echo $obox_mobile_options[ "menu_label" ]; } ?>">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
					</div><!-- menu -->
				<?php endif; ?>

			</div><!-- header -->
		</div><!-- header-container -->

		<div id="menu-container" class="menu-container <?php if( !empty( $header_class ) ) echo implode( " ", $header_class ); ?>">
			<?php
				wp_nav_menu(
					array(
						"theme_location" => 'mobile',
						"container" => false,
						"menu_class" => "navigation menu",
						"fallback_cb" => "obox_mobile_menu_fallback",
						"depth" => 0
					)
				); // wp_nav_menu
			?>
		</div><!-- menu container -->
		<?php get_sidebar(); ?>

		<?php // Setup the body font classes
		if( isset( $obox_mobile_options[ 'body_fonts' ] ) && $obox_mobile_options[ 'body_fonts' ] != '')
			$font_class = $obox_mobile_options[ 'body_fonts' ];
		else
			$font_class = '' ;?>
		<div id="content-container" class="<?php echo $font_class; ?>">
        <?php obox_mobile_advert( "header" ); ?>
