<?php if( ! function_exists( 'obox_mobile_setup_options' ) ) {
	function obox_mobile_setup_options(){
		global $obox_mobile_plugin_options, $advert_areas;

		$page_list = get_pages();
		$home_page_options["Your Latest Posts"] = 0;
		$home_page_options["Widgetized Home Page"] = 'widgetized';
		foreach($page_list as $page){
			$home_page_options[$page->post_title] = $page->ID;
		} // Each $page_list
		$obox_mobile_plugin_options = array(
			"general_site_options" => array(
				array(
					"main_section" => "Home Page",
					"main_description" => "These settings control how your content is displayed on the home page.",
					"sub_elements" => array(
						array(
							"label" => "Display",
							"description" => "Select a page to display on your home page or display your latest posts.",
							"name" => "home_page",
							"default" => "",
							"id" => "obox_mobile_home_page",
							"zero_wording" => "Latest Posts",
							"input_type" => "select",
							"options" => $home_page_options,
						),
						array(
							"label" => "Exclude Category",
							"description" => "Select a category to exclude from the home page (this is especially useful when using the slider).",
							"name" => "category_exclude",
							"default" => "",
							"id" => "",
							"zero_wording" => "Do not exclude any categories",
							"input_type" => "select",
							"options" => "loop_categories",
						),
					),
				),
				array(
					"main_section" => "Mobile Site Activation",
					"main_description" => "",
					"sub_elements" => array(
						array(
							"label" => "Disallow Pronto on the following Posts and Pages",
							"description" => "Fill in the page and post 'slugs' that you would like to exclude from using Pronto. Example: <code>/about, /contact</code>",
							"name" => "exclude_posts",
							"default" => "",
							"id" => "exclude_posts",
							"input_type" => "memo"
						),
						array(
							"label" => "Force Mobile Activation",
							"description" => "Do you want to allow the mobile site to be accessible regardless what browser or device is being used?",
							"name" => "force",
							"default" => "no",
							"id" => "obox_mobile_force",
							"input_type" => "select",
							"options" => array(
								"Yes" => "yes",
								"No" => "no",
							),
						),
					),
				),
			), // general_site_options
			"post_options" => array(
				array(
					"main_section" => "General",
					"main_description" => "These settings control how your content is displayed.",
					"sub_elements" => array(
						array(
							"label" => "Generate Excerpts Automatically",
							"description" => "Do you want an excerpt automatically generated for your posts on listing pages?",
							"name" => "auto_excerpt",
							"default" => false,
							"id" => "obox_mobile_auto_excerpt",
							"input_type" => "checkbox"
						),
						array(
							"label" => "Enable Woo Shortcodes",
							"description" => "Enable this option only if your site is making use of <a href='http://www.woothemes.com/woocodex/shortcodes/' target='_blank'>WooThemes Shortcodes</a>",
							"name" => "woo_shortcodes",
							"default" => "false",
							"id" => "obox_mobile_woo_shortcodes",
							"input_type" => "checkbox",
						),
						array(
							"label" => "Allow Comments on",
							"description" => "Where do you want comments displayed?",
							"name" => "comments_usage",
							"default" => "comments_posts",
							"id" => "obox_mobile_comments_usage",
							"input_type" => "select",
							"options" => array(
								"Posts and Pages" => "comments_posts_pages",
								"Posts Only" => "comments_posts",
								"Pages Only" => "comments_pages",
								"Neither" => "comments_off",
							),
						)
					),
				),
				array(
					"main_section" => "Thumbnail Settings",
					"main_description" => "These settings control how your thumbnails are displayed.",
					"sub_elements" => array(
						array(
							"label" => "Display on",
							"description" => "Where do you want your thumbnails to be displayed?",
							"name" => "image_usage",
							"default" => "image_posts_lists",
							"id" => "obox_mobile_thumbnail_usage",
							"input_type" => "select",
							"options" => array(
								"Posts, Lists and Pages" => "image_posts_lists",
								"Posts and Pages" => "posts",
								"Lists Only" => "lists",
								"Neither" => "off",
							),
						),
						array(
							"label" => "Enable Fallback",
							"description" => "Use this option to grab the first image attached to a post as the featured image.",
							"name" => "image_fallback",
							"default" => FALSE,
							"id" => "image_fallback",
							"input_type" => "checkbox"
						),
						array(
							"label" => "Post Video",
							"description" => "Specify the post meta used to add a featured video to your posts.",
							"name" => "video_usage",
							"default" => "main_video",
							"id" => "obox_mobile_video_usage",
							"input_type" => "text",
						),
					),
				),
				array(
					"main_section" => "Post Meta",
					"main_description" => "These settings control which post meta is displayed.",
					"sub_elements" => array(
						array(
							"label" => "Show the Author's Bio on",
							"description" => "Where do you want your author's avatar and bio displayed?",
							"name" => "author_display",
							"default" => "posts_pages",
							"id" => "obox_mobile_author_display",
							"input_type" => "select",
							"options" => array(
								"Posts and Pages" => "posts_pages",
								"Posts Only" => "posts",
								"Pages Only" => "pages",
								"Neither" => "off",
							)
						),
						array(
							"label" => "Show Post Meta on",
							"description" => "Where do you want to display the post meta?",
							"name" => "post_meta",
							"default" => "posts_pages",
							"id" => "obox_mobile_post_meta",
							"input_type" => "select",
							"options" => array(
								"Posts, Lists and Pages" => "posts_pages",
								"Posts and Lists Only" => "posts",
								"Pages Only" => "pages",
								"Neither" => "off",
							),
						),
						array(
							"label" => "Date",
							"name" => "post_date",
							"description" => "The date is located underneath the post title.",
							"default" => true,
							"id" => "obox_mobile_post_date",
							"input_type" => "checkbox",
							"linked" => "obox_mobile_post_meta",
						),
						array(
							"label" => "Author",
							"description" => "The author is located underneath the post title. <strong>NOTE: This option is different from the author's bio.</strong>",
							"name" => "post_author",
							"default" => true,
							"id" => "obox_mobile_post_author",
							"input_type" => "checkbox",
							"linked" => "obox_mobile_post_meta",
						),
						array(
							"label" => "Tags",
							"description" => "The tags are located underneath the post title.",
							"name" => "post_tags",
							"default" => "off",
							"id" => "obox_mobile_post_tags",
							"input_type" => "checkbox",
							"linked" => "obox_mobile_post_meta",
						),
						array(
							"label" => "Categories",
							"description" => "The categories are located underneath the post title.",
							"name" => "post_categories",
							"default" => "off",
							"id" => "obox_mobile_post_categories",
							"input_type" => "checkbox",
							"linked" => "obox_mobile_post_meta",
						),
					),
				),
				array(
					"main_section" => "Social Sharing",
					"main_description" => "These settings control how your users share your content.",
					"sub_elements" => array(
						array(
							"label" => "Allow Social Badges on",
							"description" => "Do you want to display social links on your posts?",
							"name" => "social_link_usage",
							"default" => "posts",
							"id" => "social_link_usage",
							"input_type" => "select",
							"options" => array(
								"Posts and Pages" => "posts_pages",
								"Posts Only" => "posts",
								"Pages Only" => "pages",
								"Neither" => "off",
							),
						),
						array(
							"label" => "Twitter",
							"description" => "",
							"name" => "twitter",
							"default" => true,
							"id" => "obox_mobile_twitter",
							"input_type" => "checkbox",
							"linked" => "obox_mobile_social_link_usage",
						),
						array(
							"label" => "Facebook",
							"description" => "",
							"name" => "facebook",
							"default" => true,
							"id" => "obox_mobile_facebook",
							"input_type" => "checkbox",
							"linked" => "obox_mobile_social_link_usage",
						),
						array(
							"label" => "Google Plus",
							"description" => "",
							"name" => "googleplus",
							"default" => true,
							"id" => "obox_mobile_googleplus",
							"input_type" => "checkbox",
							"linked" => "obox_mobile_social_link_usage",
						),
					),
				),
			), // post_options
			"footer_options" => array(
				array(
					"label" => "Copyright Text",
					"description" => "HTML is allowed. Leave blank to hide the Copyright Text.",
					"name" => "custom_copyright",
					"default" => "Copyright ".date( 'Y' ),
					"id" => "obox_mobile_custom_copyright",
					"input_type" => "memo",
				),
				array(
					"label" => "Custom Footer Text",
					"description" => "HTML is allowed. Leave blank to hide the Custom Footer Text.",
					"name" => "custom_footer",
					"default" => "<a href='http://www.oboxthemes.com/'>Mobile Plugin</a> by Obox",
					"id" => "obox_mobile_custom_footer",
					"input_type" => "memo",
				),
				array(
					"label" => "Site Analytics",
					"description" => "Enter in site tracking scripts, such as Google Analytics, here.",
					"name" => "googleAnalytics",
					"default" => "",
					"id" => "obox_mobile_googleAnalytics",
					"input_type" => "memo",
				),
			), //footer_options
			"image_options" => array(
				array(
					"label" => "Custom Logo",
					"description" => "<strong>Recommended Size: 240 x 45px</strong><br />If you are not using the image uploader please enter the full URL or folder path to your custom logo.",
					"name" => "custom_logo",
					"default" => "",
					"id" => "upload_button_logo",
					"input_type" => "file",
					"sub_title" => "mobile-logo",
				),
				array(
					"label" => "Custom Background",
					"description" => "<strong>Recommended Size: 460px wide</strong><br />If you are not using the image uploader please enter the full URL or folder path to your custom background.",
					"name" => "custom_background",
					"default" => "",
					"id" => "upload_button_background",
					"input_type" => "file",
					"sub_title" => "background",
				)
			), // image_options
			"customization_options" => array(
				array(
					"main_section" => "Header",
					"sub_elements" => array(
						array(
							"label" => "Title Font",
							"description" => '',
							"name" => "header_fonts",
							"default" => "",
							"id" => "header_fonts",
							"input_type" => "select",
							"options" => array(
									"-- Theme Default --" => "",
									"Sans Serif" => "sans-serif-style",
									"Serif" => "serif-style"
								),
							"selector" => ".logo"
						),
						array(
							"label" => "Site Title",
							"description" => '',
							"name" => "header_layout",
							"default" => "",
							"id" => "header_layout",
							"input_type" => "select",
							"options" =>
								array(
										"Show" => "",
										"Hide" =>"no-text"
									),
							"selector" => "#header-container"
						),
						array(
							"label" => "Logo Size",
							"description" => '',
							"name" => "logo_size",
							"default" => "",
							"id" => "logo_size",
							"input_type" => "select",
							"options" =>
								array(
										"Small" => "",
										"Medium" =>"medium",
										"Large" =>"large",
									),
							"selector" => '.logo-mark',
							"pro" => true
						),
						array(
							"label" => "Logo Position",
							"description" => '',
							"name" => "logo_size",
							"default" => "",
							"id" => "logo_size",
							"input_type" => "select",
							"options" =>
								array(
										"Left" => "",
										"Right" =>"right",
										"Center" =>"center",
									),
							"selector" => '.logo-mark',
							"pro" => true
						),
						array(
							"label" => "Site Title Color",
							"description" => '',
							"name" => "site_title_color",
							"default" => "#",
							"id" => "site_title",
							"input_type" => "colour",
							"selector" => '	.logo h1,
									.logo h1 a',
							"effect" => 'color'
						),
						array(
							"label" => "Header Background",
							"description" => '',
							"name" => "site_header_color",
							"default" => "#",
							"id" => "menu_bar",
							"input_type" => "colour",
							"selector" => '	#header-container,
									#respond input[type=submit]',
							"effect" => 'background'
						),
						array(
							"label" => "Header Buttons",
							"description" => '',
							"name" => "header_buttons",
							"default" => "#",
							"id" => "menu_bar",
							"input_type" => "colour",
							"selector" => '	.sidebar-toggle a,
											.menu-toggle .drop-down',
							"effect" => 'background-color',
							"pro" => true
						),
						array(
							"label" => "Menu Link Background",
							"description" => '',
							"name" => "menu_item_bg_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => 'ul.navigation li.menu-item',
							"effect" => 'background',
							"pro" => true
						),
						array(
							"label" => "Menu Link Border",
							"description" => '',
							"name" => "menu_border_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => 'ul.navigation li.menu-item',
							"effect" => 'border-color',
							"pro" => true
						),
						array(
							"label" => "Menu Link Text",
							"description" => '',
							"name" => "menu_item_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => 'ul.navigation li.menu-item a',
							"effect" => 'color',
							"pro" => true
						),
					)
				),// Header

				array(
					"main_section" => "Body",
					"sub_elements" => array(
						array(
							"label" => "Fonts",
							"description" => '',
							"name" => "body_fonts",
							"default" => "",
							"id" => "site_body_fonts",
							"input_type" => "select",
							"options" => array(
									"-- Theme Default --" => "",
									"Sans Serif" => "sans-serif-style",
									"Serif" => "serif-style"
								),
							"selector" => "#content-container, #sidebar-container, #footer"
						),
						array(
							"label" => "Background",
							"description" => '',
							"name" => "post_bg_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '	body',
							'effect' => 'background'
						),
						array(
							"label" => "Category Title Background",
							"description" => '',
							"name" => "category_bg_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '.category-title',
							'effect' => 'background-color',
							'pro' => true
						),
						array(
							"label" => "Category Title Text",
							"description" => '',
							"name" => "category_text_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '.category-title',
							'effect' => 'color',
							'pro' => true
						),
						array(
							"label" => "Content Block Background",
							"description" => '',
							"name" => "content_bg_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '	.post-list .copy,
											.two-column .column,
											.post-content,
											.author,
											.comment-container,
											#respond form,
											#disqus_thread',
							'effect' => 'background-color',
							'pro' => true
						),
						array(
							"label" => "Post Titles",
							"description" => '',
							"name" => "post_title_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '	h3.post-title a, h3.post-title a:hover,
											.page-title,
											.post-title,
											#commentform label,
											#respond h3,
											#reply-title,
											#comment-section-title',
							"effect" => 'color'
						),
						array(
							"label" => "Breadcrumbs",
							"description" => '',
							"name" => "breadcrumbs",
							"default" => "#",
							"id" => "breadcrumbs",
							"input_type" => "colour",
							"selector" => ".bread-crumbs li a",
							"effect" => 'color'
						),
						array(
							"label" => "Post Meta",
							"description" => '',
							"name" => "post_meta_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '.date',
							"effect" => 'color',
							'pro' => true
						),
						array(
							"label" => "Post Meta Border",
							"description" => '',
							"name" => "post_meta_border_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '.date',
							"effect" => 'border-color',
							'pro' => true
						),
						array(
							"label" => "Post Meta Links",
							"description" => '',
							"name" => "post_meta_color_links",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '.date a, .date a:hover',
							"effect" => 'color',
							'pro' => true
						),
						array(
							"label" => "Post Text",
							"description" => '',
							"name" => "text_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '	.copy,
											.author-copy p,
											.leave-comment,
											.comment',
							"effect" => 'color',
							'pro' => true
						),
						array(
							"label" => "Post Text Links",
							"description" => '',
							"name" => "link_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '.copy a, .copy a:hover, .author-copy a, .author-copy a:hover, logged-in-as a, logged-in-as a:hover, .comment a, .comment a:hover',
							"effect" => 'color',
							'pro' => true
						)
					)
				),// Body

				array(
					"main_section" => "WooCommerce",
					"sub_elements" => array(
						array(
							"label" => "Catalogue Titles",
							"description" => '',
							"name" => "woo_archive_product_title",
							"default" => "#",
							"id" => "woo_archive_product_title",
							"input_type" => "colour",
							"selector" => ".woocommerce-loop-product__title",
							"effect" => 'color'
						),
						array(
							"label" => "Catalogue Pricing",
							"description" => '',
							"name" => "woo_archive_price",
							"default" => "#",
							"id" => "woo_archive_price",
							"input_type" => "colour",
							"selector" => ".archive .price .woocommerce-Price-amount.amount",
							"effect" => 'color'
						),
						array(
							"label" => "Catalogue Tile Background",
							"description" => '',
							"name" => "woo_archive_tile",
							"default" => "#",
							"id" => "woo_archive_tile",
							"input_type" => "colour",
							"selector" => ".archive .products li",
							"effect" => 'background-color',
							"pro" => true
						),	
						array(
							"label" => "Catalogue Btn Background",
							"description" => '',
							"name" => "woo_archive_button_background",
							"default" => "#",
							"id" => "woo_archive_button_background",
							"input_type" => "colour",
							"selector" => ".archive .products li .add_to_cart_button,.archive .products li .button.product_type_variable",
							"effect" => 'background-color',
							"pro" => true
						),		
						array(
							"label" => "Catalogue Btn Text",
							"description" => '',
							"name" => "woo_archive_button_text",
							"default" => "#",
							"id" => "woo_archive_button_text",
							"input_type" => "colour",
							"selector" => ".archive .products li .add_to_cart_button",
							"effect" => 'color',
							"pro" => true
						),
						array(
							"label" => "Product Title",
							"description" => '',
							"name" => "woo_single_product_title",
							"default" => "#",
							"id" => "woo_single_product_title",
							"input_type" => "colour",
							"selector" => "h1.product_title",
							"effect" => 'color'
						),						
						array(
							"label" => "Product Pricing",
							"description" => '',
							"name" => "woo_single_product_price",
							"default" => "#",
							"id" => "woo_single_product_price",
							"input_type" => "colour",
							"selector" => ".single .price .woocommerce-Price-amount.amount",
							"effect" => 'color'
						),
						array(
							"label" => "Product Short Description",
							"description" => '',
							"name" => "woo_short_description",
							"default" => "#",
							"id" => "woo_short_description",
							"input_type" => "colour",
							"selector" => ".single .woocommerce-product-details__short-description p",
							"effect" => 'color',
							"pro" => true
						),

						array(
							"label" => "Product Btn Background",
							"description" => '',
							"name" => "woo_single_button_background",
							"default" => "#",
							"id" => "woo_single_button_background",
							"input_type" => "colour",
							"selector" => ".single .cart .button",
							"effect" => 'background-color',
							"pro" => true
						),		
						array(
							"label" => "Product Btn Text",
							"description" => '',
							"name" => "woo_single_button_text",
							"default" => "#",
							"id" => "woo_single_button_text",
							"input_type" => "colour",
							"selector" => ".single .cart .button",
							"effect" => 'color',
							"pro" => true
						),		

						array(
							"label" => "Tab Btn Background",
							"description" => '',
							"name" => "woo_tab_button_background",
							"default" => "#",
							"id" => "woo_tab_button_background",
							"input_type" => "colour",
							"selector" => ".woocommerce .woocommerce-tabs ul.tabs li:not(.active)",
							"effect" => 'background-color',
							"pro" => true
						),		
						array(
							"label" => "Active Tab Btn Background",
							"description" => '',
							"name" => "woo_tab_button_background",
							"default" => "#",
							"id" => "woo_tab_button_background",
							"input_type" => "colour",
							"selector" => ".woocommerce .woocommerce-tabs ul.tabs li.active",
							"effect" => 'background-color',
							"pro" => true
						),		
						array(
							"label" => "Tab Btn Text",
							"description" => '',
							"name" => "woo_tab_button_text",
							"default" => "#",
							"id" => "woo_tab_button_text",
							"input_type" => "colour",
							"selector" => ".woocommerce .woocommerce-tabs ul.tabs li a",
							"effect" => 'color',
							"pro" => true
						),	
						array(
							"label" => "Tab Body Text",
							"description" => '',
							"name" => "woo_tab_body_text",
							"default" => "#",
							"id" => "woo_tab_body_text",
							"input_type" => "colour",
							"selector" => ".woocommerce .woocommerce-Tabs-panel--description",
							"effect" => 'color',
							"pro" => true
						),			
					)
				),
				array(
					"main_section" => "Pagination",
					"sub_elements" => array(
						array(
							"label" => "Background",
							"description" => '',
							"name" => "pagination_bg_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '.pagination',
							"effect" => 'background',
							'pro' => true
						),
						array(
							"label" => "Page Number Text",
							"description" => '',
							"name" => "pagination_text_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '.pagination li',
							"effect" => 'color',
							'pro' => true
						),
						array(
							"label" => "Button Background",
							"description" => '',
							"name" => "pagination_button_bg_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '.pagination a',
							"effect" => 'background',
							'pro' => true
						),
						array(
							"label" => "Page Button Text Colour",
							"description" => '',
							"name" => "pagination_button_text_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '.pagination a',
							"effect" => 'color',
							'pro' => true
						)
					)
				), // Pagination
				array(
					"main_section" => "Footer",
					"sub_elements" => array(
						array(
							"label" => "Footer Background",
							"description" => '',
							"name" => "footer_bg_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '#footer',
							"effect" => 'background',
							'pro' => true
						),
						array(
							"label" => "Footer Text",
							"description" => '',
							"name" => "footer_text_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '#footer',
							"effect" => 'color',
							'pro' => true
						),
						array(
							"label" => "Footer Text Links",
							"description" => '',
							"name" => "footer_link_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '#footer a',
							"effect" => 'color',
							'pro' => true
						),
						array(
							"label" => "Mobile Switcher Background",
							"description" => '',
							"name" => "obox_mobile_background",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '.footer-secondary',
							"effect" => 'background',
							'pro' => true
						),
						array(
							"label" => "Mobile Switcher Button",
							"description" => '',
							"name" => "obox_mobile_button",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '.footer-switch',
							"effect" => 'background',
							'pro' => true
						),

					)
				),// Footer
				array(
					"main_section" => "Sidebar",
					"sub_elements" => array(
						array(
							"label" => "Fonts",
							"description" => '',
							"name" => "sidebar_fonts",
							"default" => "",
							"id" => "sidebar_fonts",
							"input_type" => "select",
							"options" => array(
									"-- Theme Default --" => "",
									"Sans Serif" => "sans-serif-style",
									"Serif" => "serif-style"
								),
							"selector" => "#sidebar-container"
						),
						array(
							"label" => "Widget Title Background",
							"description" => '',
							"name" => "widget_title_bg_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '	.widgettitle,
									#sidebar-container .sidebar li .widgettitle,
									#sidebar-container ul.sidebar li h3.widgettitle',
							"effect" => 'background-color',
							'pro' => true
						),
						array(
							"label" => "Widget Title ",
							"description" => '',
							"name" => "widget_title_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '.widgettitle,
									#sidebar-container .sidebar li .widgettitle',
							"effect" => 'color',
							'pro' => true
						),
						array(
							"label" => "Widget Body Background",
							"description" => '',
							"name" => "widget_body_bg_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => ' li.widget, .widget_pages,
								#sidebar-container ul.sidebar li
								',
							"effect" => 'background',
							'pro' => true
						),
						array(
							"label" => "Widget Body Text",
							"description" => '',
							"name" => "widget_body_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '.widget ul, .widget',
							"effect" => 'color',
							'pro' => true
						),
						array(
							"label" => "Widget Body Links",
							"description" => '',
							"name" => "widget_body_link_color",
							"default" => "#",
							"id" => "",
							"input_type" => "colour",
							"selector" => '
									.widget ul li a, .widget a,
									#sidebar-container .sidebar a',
							"effect" => 'color',
							'pro' => true
						)
					)
				) // Sidebar
			), // customization_options
			"custom_css_options" => array(
				array(
					"label" => "Custom CSS",
					"description" => "Any CSS placed into this text area will be output on the front-end of your mobile site.",
					"name" => "custom_css",
					"default" => "",
					"id" => "obox_mobile_custom_css",
					"input_type" => "css",
					'pro' => true
				)
			), // custom_css_options
		); // obox_mobile_theme_options

		$advert_areas = array(
			"Site Header" => "header",
			"Below Post" => "post",
			"Footer" => "footer",
		); // advert_areas

		foreach ( $advert_areas AS $ad_area => $option ) {
			$obox_mobile_plugin_options[ $option . "_adverts" ] = array(
				array(
					"label" => "Advert Title",
					"description" => "The title will be displayed in the event the advert image is unavailable.",
					"name" => $option . "_ad_title",
					"default" => "",
					"id" => $option . "_ad_title",
					"input_type" => "text",
				),
				array(
					"label" => "Advert Link",
					"description" => "Include the full url including the http://",
					"name" => $option . "_ad_href",
					"default" => "",
					"id" => "",
					"input_type" => "text",
				),
				array(
					"label" => "Image Url",
					"description" => "<strong>Recommended Size: 300 x 50px</strong>",
					"name" => $option . "_ad_image",
					"default" => "",
					"id" => "upload_button_" . $option."_ad_image",
					"input_type" => "file",
					"sub_title" => $option . "_ad_image",
				),
				array(
					"label" => "Advert Script",
					"description" => "Enter the script for your advert here.",
					"name" => $option."_ad_buysell_id",
					"default" => "",
					"id" => $option."_ad_buysell_id",
					"input_type" => "memo",
				),
				array(
					"main_section" => "Restrictions",
					"main_description" => "These settings control when your adverts will be displayed.",
					"sub_elements" => array(
						array(
							"label" => "Show Only in Posts",
							"description" => "Only show this advert when a user is viewing a single post or page.",
							"name" => $option . "_ad_postst_only",
							"default" => false,
							"id" => $option . "_ad_postst_only",
							"input_type" => "checkbox",
						),
						array(
							"label" => "Show for Guests Only",
							"description" => "Hide the adverts for users who are logged in.",
							"name" => $option."_ad_non_users", "default" => false,
							"id" => $option . "_ad_non_users",
							"input_type" => "checkbox",
						),
					),
				),
			); // option adverts
		} // foreach advert areas

	} //obox_mobile_setup_options
 	add_action( 'init' , 'obox_mobile_setup_options', 50 );
} // if function_exists( 'obox_mobile_setup_options' )