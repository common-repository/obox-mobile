<?php
function obox_mobile_advert( $advert ) {
	global $obox_mobile;
	$obox_mobile_options = $obox_mobile->get_options();
	
	if ( $obox_mobile_options[ $advert . "_ad_non_users" ] == "true" && is_user_logged_in() ) {
		return FALSE;
	}

	if ( $obox_mobile_options[ $advert . "_ad_postst_only" ] == "true" && !is_page() && !is_single() ) {
		return FALSE;
	}

	if ( $obox_mobile_options[  $advert . "_ad_buysell_id" ] != "" ) : ?>
		<div class="post-advert"><?php echo stripslashes( $obox_mobile_options[  $advert . "_ad_buysell_id" ] ); ?></div>
	<?php elseif ( $obox_mobile_options[ $advert . "_ad_image" ] != "" ) : ?>
		<div class="post-advert">
			<a href="<?php echo esc_url( $obox_mobile_options[ $advert . "_ad_href" ] ); ?>" target="_blank" rel="nofollow" class="post-advert">
				<img src="<?php echo esc_url( $obox_mobile_options[ $advert . "_ad_image" ] ); ?>" alt="<?php echo esc_attr( $obox_mobile_options[ $advert . "_ad_title" ] ); ?>" />
			</a>
		</div>
	<?php endif;
} // obox_mobile_advert
