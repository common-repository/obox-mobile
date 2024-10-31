jQuery(document).ready(function() {
	jQuery("#obox_mobile_license_button").live("click", function() {
		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth();
		var curr_year = d.getFullYear();
		myDate = curr_date + "-" + curr_month + "-" + curr_year;

		jQuery("#result").fadeIn();
		jQuery("#result .admin-content ul").html("<li>Validating...</li>");

		jQuery.get(
			ThemeAjax.ajaxurl,
			{
				action: "validate_key",
				hashkey: jQuery("#obox_mobile_license_key").attr("value"),
				timestamp: myDate
			},
			function(data) {
				jQuery("#result .admin-content ul").slideUp(function() {
					jQuery("#result .admin-content ul").html(jQuery("#result .admin-content ul").html() + data).slideDown();
				});

				if ( data.toString().indexOf("is Valid") !== -1 ) {
					jQuery("#result .admin-content ul").slideUp(function() {
						jQuery("#result .admin-content ul").html(jQuery("#result .admin-content ul").html() + "<li>Downloading Package</li>").slideDown();
					});

					jQuery.get(
						ThemeAjax.ajaxurl,
						{
							action: "do_obox_mobile_upgrade",
							hashkey: jQuery("#obox_mobile_license_key").attr("value"),
							timestamp: myDate
						},
						function(data) {
							var html_construct = jQuery("#result .admin-content ul").html() + data;
							if ( html_construct.toString().indexOf("success") !== -1) {
								html_construct = jQuery("#result .admin-content ul").html() + "<li>Well done! The upgrade was successful.</li>";
							}

							jQuery("#result .admin-content ul").slideUp(function() {
								jQuery("#result .admin-content ul").html(html_construct).slideDown();
							});
						} // response
					); // .get
				} // if valid
			} // response
		); // .get
	}); // obox_mobile_license_button.click

}); // document.ready
