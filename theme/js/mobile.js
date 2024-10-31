function set_slider_height(id, pos){
	$height = jQuery(id).find(".slide").eq(pos).find('img').height();

	if($height < 260)
		$height = 260;
	jQuery(id).css( { height: $height } );
}
jQuery(document).ready(function() {
	$contentcontainer = jQuery("#content-container");
	$sidebarcontainer = jQuery("#sidebar-container");
	$sidebarheight = jQuery(".sidebar").css( 'height' );
	$menu_container = jQuery("#menu-container");

	jQuery(".drop-down").live("click", function(e) {
		e.preventDefault();

		if( $sidebarcontainer.hasClass( 'open' ) ){
			$sidebarcontainer.removeClass( 'open' );
			$contentcontainer.removeClass( 'sidebar-open' );
			$delay = 300;
		} else {
			$delay = 1;
		}

		setTimeout(function(){
			if( $menu_container.hasClass( 'open' ) ){
				$menu_container.removeClass( 'open' );
			} else {
				$menu_container.addClass( 'open' );
			}
		}, $delay);

	}); // drop-down.bind click

	jQuery(".sidebar-button, #sidebar-container span").live("click", function(e) {
		e.preventDefault(); // Don't send us away

		// Hide Navigation if it's open
		if( $menu_container.hasClass( 'open' ) ){
			$menu_container.removeClass( 'open' );
			$delay = 300;
		} else {
			$delay = 1;
		}

		setTimeout(function(){
			$sidebarcontainer.toggleClass( 'open' );
			$contentcontainer.toggleClass( 'sidebar-open' );

			if( $sidebarcontainer.hasClass( 'open' ) ){ // If the sidebar is open
				jQuery("#container").css( 'height', $sidebarheight ); // Set the height of the content container
			} else { // If the sidebar is closed
				jQuery("#container").css( 'height', 'auto' ); // Reset the height of the container
			}
		}, $delay);
	}); // sidebar-button.bind click


	jQuery(".fitvid").fitVids();
	jQuery("iframe, object").each(function(){
		jQuery(this).parent().fitVids();
		jQuery("p .fluid-width-video-wrapper").css({"padding-top": "75%"});

	})
	if( document.getElementById('position') ){
		var bullets = document.getElementById('position').getElementsByTagName('li');
		var interval = jQuery("[data-interval]").attr('data-interval');
		var slider =
			Swipe(document.getElementById('slider'), {
				auto: +interval*1000,
				continuous: true,
				speed: 700,
				callback: function(pos) {
					var i = bullets.length;
					while (i--) {
						bullets[i].className = ' ';
					}
					bullets[pos].className = ' on ';
					set_slider_height('#slider', pos);
				}
			});
	}

	jQuery('#position li').live('click', function(){
		slider.slide( jQuery(this).index(), 300 );
		var i = bullets.length;
		while (i--) {
			bullets[i].className = ' ';
		};
		jQuery(this).addClass(' on ');
		set_slider_height('#slider', jQuery(this).index());
	});
	set_slider_height('#slider', 0);
}); // document.ready
