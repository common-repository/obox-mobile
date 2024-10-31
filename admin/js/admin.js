function check_nan(element, element_value, max_value) {
	if (isNaN(element_value)) {
		alert("Only number vlues are allow in this input.");
		element.value = element_value.substring(0, (element_value.length/1)-1);
	}

	if (max_value && ((element_value/1) > (max_value/1))) {
		alert("The maximum value allowed for this input is " + max_value);
		element.value = max_value;
	} // if max value
} // check_nan

function check_linked(this_id, link_id) {
	this_id = "#" + this_id;
	link_div_id = "#" + link_id + "_div";
	link_id = "#" + link_id;

	if (jQuery(this_id).attr("value") !== "0") {
		jQuery(link_div_id).slideUp();
		jQuery(link_id).attr("disabled", "true");
	} else {
		jQuery(link_div_id).slideDown();
		jQuery(link_id).removeAttr("disabled");
	}
} // check_linked

jQuery(document).ready(function() {

	var is_dirty = false;
	jQuery(':input').on('change', function() {
		is_dirty = true;
	});
	// Don't warn when submitting a form!
	jQuery("form").submit(function() {
		jQuery(window).unbind("beforeunload");
	});

	jQuery(window).bind('beforeunload', function() {
		if (is_dirty || (active_load_state !== jQuery("#active").is(":checked")))
			return "The changes you made will be lost if you navigate away from this page.";
	});

	// General Options Save & Reset functions
	jQuery("#mobile-options").submit(function(e) {
		e.preventDefault();

		jQuery("#content-block").animate({opacity: 0.50}, 500);

		if (document.getElementById("mobile-note")) {
			jQuery("#mobile-note").html("<p>Saving...</p>");
		} else {
			jQuery("<div id='mobile-note' class='updated below-h2'><p>Saving...</p></div>").insertBefore("#header-block");
		}

		jQuery.post(
			ThemeAjax.ajaxurl,
			{
				action : 'obox_mobile_save-options',
				data: jQuery("#mobile-options").serialize(),
				obox_mobile_nonce: jQuery('#_obox_mobile_nonce').val()
			},
			function(data) {
				var results = jQuery.parseJSON(data);
				console.log(data);
				jQuery("#content-block").animate({opacity: 1}, 500);
				jQuery("#mobile-note").html(results.message).attr( { "class": results.css_class } ).fadeIn();
				setTimeout(function(){
					jQuery("#mobile-note").slideUp( { duration: 350 } );
				}, results.fade_out);
			} // callback
		); // post
		return false;
	}); // mobile-options.submit

	jQuery("[id^='mobile-reset']").click(function() {
		if (!confirm("Are you sure you want reset these options to default?"))
			return;

		jQuery("#content-block").animate({opacity: 0.50}, 500);

		if (document.getElementById("mobile-note")) {
			jQuery("#mobile-note").html("<p>Saving...</p>");
		} else {
			jQuery("#header-block").before("<div id='mobile-note' class='updated below-h2'><p>Saving...</p></div>");
		}

		jQuery.post(
			ThemeAjax.ajaxurl,
			{
				action : 'obox_mobile_reset-options',
				data: jQuery("#mobile-options").serialize()
			},
			function(data) {
				jQuery("#mobile-note").html("<p>Refreshing Page...</p>");
				jQuery("#content-block").animate({opacity: 1}, 500);
				window.location = jQuery("#mobile-options").attr("action").replace("&changes_done=1", "").replace("&options_reset=1", "") + "&options_reset=1";
			} // callback
		); // post
	}); // mobile-reset.click

	// Admin Tabs
	jQuery("#tabs a").click(function(e) {
		e.preventDefault();

		oldtabid = jQuery(".selected").children("a").attr("rel");
		tabid = jQuery(this).attr("rel");

		if (!(jQuery(this).parent().hasClass("selected"))) {
			jQuery(".selected").removeClass("selected");
			jQuery(this).parent().addClass("selected");
			jQuery(oldtabid).slideUp();
			jQuery(tabid).slideDown();

			formaction = jQuery("form").attr("action");
			findtab = formaction.indexOf("tab=");
			action_len = formaction.length;
			tabno = jQuery(this).attr("rel").replace("#tab-", "");

			if (findtab == -1) {
				jQuery("form").attr("action", formaction + "&obox_mobile_current_tab=" + tabno);
			} else {
				formaction = formaction.substr(0,(findtab + 4));
				jQuery("form").attr("action", formaction + tabno);
			}

			jQuery(oldtabid + "-href").fadeOut();
			jQuery(tabid + "-href").fadeIn();
			jQuery(oldtabid + "-href-1").fadeOut();
			jQuery(tabid + "-href-1").fadeIn();
		} // if not selected
		return false;
	}); // tabs a.click

	// Related form item showing and hiding
	jQuery(".contained-forms input, .contained-forms select").live("change", function() {
		relid = jQuery(this).attr("name");
		element = jQuery(this);

		jQuery("[rel^='" + relid + "']").each(function() {
			if (element.val() == "off" || element.val() == "no") {
				jQuery(this).slideUp();
			} else if (element.attr("type") == "checkbox" && element.attr("checked") == "checked") {
				jQuery(this).slideDown();
			} else if (element.attr("type") == "checkbox") {
				jQuery(this).slideUp();
			} else {
				jQuery(this).slideDown();
			}
		});
	}); // contained-forms.change

	// Image Ajaxi Upload & Clear functions
	jQuery("input[id^='obox_mobile_clear_upload_']").click(function(e) {
		e.preventDefault();

		input_id = jQuery(this).attr("id").replace("obox_mobile_clear_", "") + "_text";
		image_link_id = input_id.replace("_text", "_href");

		if (confirm("Are you sure you want to clear this image?")) {
			jQuery("#" + image_link_id).css({background: 'url("") no-repeat center'}).fadeIn();
			jQuery("#" + input_id).attr("value", "");
		}
	}); // input clear upload.click

	jQuery("input[id^='upload_button_']").each(function() {
		var input_id = "#" + jQuery(this).attr("id");

		// Make sure we're only talking about the button, and not the text field, that'll get messy
		if (input_id.indexOf("_text") <= -1) {
			var $image_link = jQuery(input_id + "_href");
			var $image_input = jQuery(input_id + "_text");
			var $info = jQuery(input_id + "_info");

			new AjaxUpload(jQuery(this).attr("id"), {
				action:	ThemeAjax.ajaxurl,
				name: jQuery(this).attr("name"),
				data: {
					action:  "obox_mobile_ajax-upload",
					obox_mobile_input_name: jQuery(this).attr("name"),
					type: "upload",
					meta_key: jQuery(this).attr("id").replace("upload_button_", "").replace("_href", ""),
					data: jQuery(this).id,
				},
				autoSubmit: true,
				responseType: false,
				onChange: function(file, extension) {
					$info.html("<img src='images/loading.gif' alt='' /></a>").fadeIn();
				},
				onSubmit: function(file, extension) {},
				onComplete: function(file, response) {
					if (response.search('Upload Error') > -1) {
						$info.html(response);
						setTimeout(function() {
							$info.remove();
						}, 2000);
					} else {
						$image_link.fadeOut(function() {
							$info.fadeOut();
							$image_input.attr("value", response);
							$image_link.css({background: 'url("' + response + '") no-repeat center'}).fadeIn();
						});
					} // If there was an error
				} // onComplete
			}); // AjaxUpload
		} // element match
	}); // each upload button

	// Customization Page

	jQuery(document).on('click', "#clear-form", function(e){
		e.preventDefault();
		var clearform = confirm ( 'Are you sure you want to clear your customization options?' );
		if( !clearform ){
			return;
		} else {
			// Clear the colour options
			jQuery(".wp-picker-default").click();
			jQuery("input[data-default-color*='#']").each(function(){
				var selector = jQuery(this).attr("data-selector");
				var effect = jQuery(this).attr("data-effect");
				jQuery("#obox-mobile-customizer").contents().find(selector).css(effect, '' );
			});

			// Clear the font & other selectors
			jQuery("select").each(function(){
				if( undefined !== jQuery(this).attr("data-selector") &&  jQuery(this).val() !== '' ) {
					var clearClass = jQuery(this).val();
					alert( clearClass );
					var selector = jQuery(this).attr("data-selector");
					jQuery("#obox-mobile-customizer").contents().find(selector).removeClass( clearClass );
				}
			});

			// Make sure the text and other options are cleared
			jQuery(".accordian").find('form, select, textarea').val( '' );
		}
	})

	if(jQuery.isFunction(jQuery.fn.wpColorPicker)){
		jQuery("input[data-default-color*='#']").each(function(){
				var element = jQuery(this);
				var selector = jQuery(this).attr("data-selector");
				var effect = jQuery(this).attr("data-effect");
				console.log(selector);
				console.log(effect);
				jQuery(this).wpColorPicker({
				change: function(event, ui){
					jQuery("#obox-mobile-customizer").contents().find(selector).css(effect, ui.color.toString());
				},
			});
		});
	}
	jQuery("#obox-mobile-customizer").on("load", function () {
		jQuery("input[data-default-color*='#']").each(function(){
			var element = jQuery(this);
			var selector = jQuery(this).attr("data-selector");
			var effect = jQuery(this).attr("data-effect");
			jQuery("#obox-mobile-customizer").contents().find(selector).css(effect, element.val());
		});
	})

	function reloadStyles(){
	}

	jQuery(".wp-picker-default").val("Clear");
	jQuery("select").live("change", function(){
		if( undefined !== jQuery(this).attr("data-selector") ) {
			var id = jQuery(this).attr("id");
			var selector = jQuery(this).attr("data-selector");
			var iframe = jQuery("#obox-mobile-customizer").contents();

			// Clear the font class from the element
			jQuery("#"+id+" option").each(function(){
				var classes = jQuery(this).val().split(' ');
				jQuery.each( classes , function(index, value){
	    				if( iframe.find(selector).hasClass( value ) )
						{ iframe.find(selector).removeClass( value ) }
				})
			});

			// Add the font class
			var new_classes = jQuery(this).val().split(' ');
			jQuery.each( new_classes , function(index, value){
				iframe.find(selector).addClass( value )
			});
		}
	});

	jQuery("#content-block .accordian-title").live("click", function(){
		if( ! jQuery( this ).hasClass("active") ) {
			var isactive = 0;
		} else {
			var isactive = 1;
		}
		// Titles
		jQuery("#content-block .accordian-title").removeClass("active");

		// Body
		jQuery("#content-block .accordian-body").slideUp({duration: 275});

		if( 0 == isactive ) {
			jQuery( this ).addClass("active");
			jQuery( this ).parent().children(".accordian-body").slideDown({duration: 175});
		}
		return false;
	});

	jQuery(".layout-options li").live("click", function(){

		value = jQuery(this).attr( "data-value" );
		jQuery(this).parent().parent().children('input').val( value );


		if( undefined !== jQuery("#obox-mobile-customizer") ) {
			var iframe = jQuery("#obox-mobile-customizer").contents();
			var selector = jQuery(this).parent().attr( "data-selector" );

			// Clear the font class from the element
			jQuery(this).parent().children("li").each(function(){
				var classes = jQuery(this).attr( "data-value" ).split(' ');
				jQuery.each( classes , function(index, value){
	    				if( iframe.find(selector).hasClass( value ) )
						{ iframe.find(selector).removeClass( value ) }
				})
			});

			// Add the font class
			var new_classes = value.split(' ');
			jQuery.each( new_classes , function(index, value){
				iframe.find(selector).addClass( value )
			});
		}

		return false;
	});


}); // document.ready
