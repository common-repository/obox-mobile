<?php function obox_mobile_customization_form(){
	global $obox_mobile_plugin_options;

	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style( 'wp-color-picker' );

	?>
    	<li class="customization-block column">
		<div class="admin-description">
			<h4>Theme Customization</h4>
		    	<p>Use the visual customizer below to modify the colors and fonts of your mobile site.</p>
		    	<small class="alignright"><a href="#" id="clear-form"> Clear Options</a></small>
		</div>
		<?php foreach ($obox_mobile_plugin_options[ 'customization_options' ] as $input ) { ?>
			<div class="accordian">
				<div class="accordian-title">
					<h4><?php _e( $input["main_section"] ); ?></h4>
					<?php if ( isset( $input["main_description"] ) ) : ?>
						<p><?php _e( $input["main_description"] ); ?></p>
					<?php endif; // main description ?>
				</div>
				<div class="accordian-body no_display">
					<ul class="customization-options">
						<?php foreach( $input["sub_elements"] AS $form_item ) : ?>
			                            <li class="customization-item">
			                                <label><?php echo $form_item["label" ]; ?></label>
			                                <div class="customization-option"><?php create_obox_mobile_form( $form_item, 1, '' ); ?></div>
			                            </li>
			                        <?php endforeach; ?>
			                    </ul>
				</div>
			</div>
		<?php } // for each obox_mobile_plugin_options ?>

	</li>
	<li class="mobile-block column">

		<iframe frameborder="0" hspace="0" src="<?php bloginfo( "url" ); ?>?site_switch=mobile&amp;preview=1" id="obox-mobile-customizer" name="obox-mobile-customizer">This feature requires inline frames. You have iframes disabled or your browser does not support them.</iframe>

	</li>
<?php }
add_action( 'obox_mobile_customization_form', 'obox_mobile_customization_form' );