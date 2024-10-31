<?php

class OBOX_Mobile {
	public $obox_mobile_options;

	public function obox_mobile_template() {
		$template = "theme";
		return $template;
	} // obox_mobile_template

	public function obox_mobile_stylesheet() {
		$template = "theme";
		return $template;
	} // obox_mobile_stylesheet

	public function obox_mobile_template_dir() {
		$template_path = OBOXMOBILEDIR;
		return $template_path;
	} // obox_mobile_template_dir

	public function obox_mobile_template_uri() {
		$template_path = OBOXMOBILEURL;
		return $template_path;
	} // obox_mobile_template_uri

	public function remove_plugins() {
		// Disable  common plugins which can cause unwanted behaviour with Pronto, such as showing a cached version of  the wrong site! */

		// Facebook Like button
		remove_filter( 'the_content', 'Add_Like_Button' );

		// Sharebar Plugin
		remove_filter( 'the_content', 'sharebar_auto' );
		remove_action( 'wp_head', 'sharebar_header' );

		// Hyper Cache
		if ( function_exists( 'hyper_activate' ) ) {
			global $hyper_cache_stop;
			$hyper_cache_stop = TRUE;
		} // if hyper
	} // remove_plugins

	public function setup_post_types() {
		if(!is_admin()) {
			$post_types = get_post_types( array( 'public' => true ) );
			foreach($post_types as $type) {
				$post_type_atts = get_post_type_object($type);
				register_post_type($post_type_atts);
			} // forach post_types
		} // if !is_admin()

	} // setup_post_types

	public function allow_mobile() {
		$mobile = FALSE;

		// Get Mobile Options
		$obox_mobile_options = $this->get_options();

		// Current browser
		$browserAgent = $_SERVER['HTTP_USER_AGENT'];

		// Devices we allow
		$touch_devices = array(
			'iphone',
			'ipod',
			'aspen',
			'incognito',
			'webmate',
			'android',
			'dream',
			'cupcake',
			'froyo',
			'blackberry',
			'webos',
			'samsung',
			'bada',
			'IEMobile',
			'htc',
			'bb10'
		);

		// Loop through the devices and decide if we're allowed to use Mobile
		foreach ( $touch_devices AS $device ) {
			if ( preg_match( "/$device/i", $browserAgent ) ) {
				$mobile = TRUE;
			} // find
		} // for each device

		if ( isset( $obox_mobile_options[ "force" ] ) && $obox_mobile_options[ "force" ] == "yes" ) {
			$mobile = TRUE;
		} // if force

		if ( isset( $obox_mobile_options[ "exclude_posts" ] ) && $obox_mobile_options[ "exclude_posts" ] != '' ) {
			$server_url = strtolower( $_SERVER['REQUEST_URI'] );
			$exclusion = explode( ", " , $obox_mobile_options[ "exclude_posts" ] );
			foreach( $exclusion as $exclude ) {
				if ( strpos( $server_url, trim( $exclude ) ) !== false ) {
					$mobile = FALSE;
				}
			}
		} // if exclude_posts

		return $mobile;
	} // allow_mobile

	public function allow_slider() {
		$obox_mobile_options = $this->get_options();

		if ( $obox_mobile_options[ "slider" ] == true ) {
			return TRUE;
		} else {
			return FALSE;
		} // if apple device
	} // allow_slider

	public function site_style() {
		if ( TRUE === $this->allow_mobile() ) {
			if ( isset( $_GET["site_switch"] ) && $_GET["site_switch"] ) {
				$site_style = $_GET["site_switch"];
			} else {
				$site_style = "mobile";
			} // if switch
		} else if ( isset( $_GET["preview"] ) && $_GET["preview"] && $_GET["site_switch"] ) {
			$site_style = $_GET["site_switch"];
		} else {
			$site_style = "normal";
		} // if allow mobile

		if ( TRUE === $this->allow_mobile() ) {
			// $this->remove_plugins();
		}

		if ( !headers_sent() && !isset( $_GET["preview"] ) ) {
			setcookie( "ocmx_mobile", "", time() - 3600, COOKIEPATH, COOKIE_DOMAIN );
			setcookie( "ocmx_mobile", $site_style, 0, COOKIEPATH, COOKIE_DOMAIN );
		} // if

		return $site_style;
	} // site_style

	function obox_mobile_trim_excerpt($text) {
		global $post;
		if ( '' == $text ) {
			$text = get_the_content('');
			$text = apply_filters('the_content', $text);
			$text = str_replace('\]\]\>', ']]&gt;', $text);
			$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
			$text = strip_tags($text, '<p>');
			$excerpt_length = 80;
			$words = explode(' ', $text, $excerpt_length + 1);
			if (count($words)> $excerpt_length) {
				array_pop($words);
				array_push($words, '...');
				$text = implode(' ', $words);
			}
		}
		return $text;
	} // obox_mobile_trim_excerpt

	public function set_home_page() {
		$obox_mobile_options = $this->get_options();

		// Make sure we're not using the WordPress static home page
		$root = $this->obox_mobile_template_dir() . '/' . $this->obox_mobile_template();

		$obox_mobile_home_page =  $obox_mobile_options[ "home_page" ];
		if ( ! isset( $_GET[ "mobile-stylesheet" ] ) && $obox_mobile_home_page != "widgetized" && $obox_mobile_home_page != "0" && ( is_home() || is_front_page() ) ) {
			global $post;
			query_posts( 'page_id=' . $obox_mobile_home_page );
			include( $root . '/page.php' );
			exit;
		} else if ( is_home() || is_front_page() ) {
			$exclude_category = $obox_mobile_options[ "category_exclude" ];

			if ( $exclude_category && $exclude_category !== 0 ) {
				$fetch_category = get_category_by_slug( $exclude_category );
				$category_query = "cat=-" . $fetch_category->term_id . "&";
			} else {
				$category_query = "";
			} // if category exclude

			if ( get_query_var( 'paged' ) ) {
				$currentpage = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) {
				$currentpage = get_query_var( 'page' );
			} else {
				$currentpage = 0;
			} // if get_query_var

			query_posts( $category_query . 'post_type=post&paged=' . $currentpage );
		} // if not homepage
	} // set_home_page

	public function reset_home_page() {
		$home_page = get_option( "orig_page_on_front" );
		if ( $home_page !== "" ) {
			update_option( "page_on_front", $home_page );
		}
	} // reset_home_page

	public function get_option( $key ){
		if( isset ($this->obox_mobile_options[$key]) ) {
			return $this->obox_mobile_options[$key];
		} else {
			return null;
		}
	} // get_option


	public function get_options(){
		return $this->obox_mobile_options;
	} // get_options

	public function initiate() {

		// Set the Pronto options
		$this->obox_mobile_options = get_option( 'obox-mobile' );

		if ( ( $this->site_style() == "mobile" && FALSE === strpos( $_SERVER['REQUEST_URI'], '/wp-admin' ) ) ) {
			add_filter( 'stylesheet', array( &$this, 'obox_mobile_stylesheet' ) );
			add_filter( 'template', array( &$this, 'obox_mobile_template' ) );
			add_filter( 'theme_root', array( &$this, 'obox_mobile_template_dir' ) );
			add_filter( 'theme_root_uri', array( &$this, 'obox_mobile_template_uri' ) );
			remove_filter('get_the_excerpt', 'wp_trim_excerpt');
			add_filter('get_the_excerpt', array( &$this, 'obox_mobile_trim_excerpt' ) );

			add_filter( "show_admin_bar", "__return_false" );

			add_action( 'wp', array( &$this, 'set_home_page' ) );

			// Setup theme support
			add_theme_support( "post-thumbnails" );
 			add_theme_support( 'woocommerce' );
			//WooCommerce Gallery
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );

		} // if mobile
	} // initiate

} // OBOX_Mobile
