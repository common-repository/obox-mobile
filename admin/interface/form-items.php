<?php
function create_obox_mobile_form( $input, $counter, $label_class = "" ) {
	global $obox_mobile;
	$obox_mobile_options = $obox_mobile->get_options();

	if( isset( $input['pro'] ) && !obox_mobile_is_pro_active() ) $disabled = 'disabled="disabled"'; else $disabled = '';

	if ( $label_class != "" ) : ?>
		<div class="<?php echo $label_class; ?>">
	<?php endif; // label class 

		if(isset($obox_mobile_options[ $input["name"] ]))
			$input_value = $obox_mobile_options[ $input["name"] ] ? $obox_mobile_options[ $input["name"] ] : $input["default"];
		else
			$input_value = $input["default"];

		// This denotes that we're using the wp-categories instead of set options
		if ( isset( $input["options"] ) ) {
			if ( ( $input["options"] == "loop_categories" ) || ( $input["options"] == "multi_categories" ) ) {
				$option_loop = get_categories( array( 'hide_empty' => FALSE ) );
			} elseif ( $input["options"] == "loop_pages" ) {
				$option_loop = get_pages();
			} else {
				$option_loop = $input["options"];
			} // if input options
		} else {
			$option_loop = NULL;
		} // if input options

		switch ( $input["input_type"] ) :
			case 'select';
				if ( isset( $input["linked"] ) && $input["linked"] ) :
		?>
					<select size="1" name="obox_mobile[<?php echo $input["name"] ?>]" id="<?php echo $input["id"] ?>" onchange="javacript: check_linked('<?php echo $input["id"] ?>', '<?php echo $input["linked"] ?>')" <?php echo $disabled; ?>>
				<?php else : ?>
					<select size="1" name="obox_mobile[<?php echo $input["name"] ?>]"
						id="<?php echo $input["id"] ?>"
						<?php if( isset($input["prefix"]) ) { ?>rel="<?php echo $input["prefix"] ?>"<?php }; ?>
						<?php if( isset($input["selector"]) ) { ?>data-selector="<?php echo $input["selector"] ?>"<?php }; ?>
						<?php echo $disabled; ?>
						>
				<?php endif;
					// Tiny little hack.. if we've set the options to loop through the categories, we must have an "All" option
					if ( $input["options"] == "loop_categories" ) : ?>
						<option <?php if ( $input_value == 0 ) { echo "selected"; } ?> value="0"><?php if ( $input["zero_wording"]) : echo $input["zero_wording"]; else : _e( "All" ); endif; ?></option>
				<?php elseif ( ( $input["options"] == "loop_pages" ) && $input["linked"] ) : ?>
						<option <?php if ( $input_value == 0 ) { echo "selected"; } ?> value="0"><?php if ( $input["zero_wording"] ) : echo $input["zero_wording"]; else : _e( "Use a Custom Description" ); endif; ?></option>
				<?php elseif ( $input["options"] == "loop_pages" ) : ?>
						<option <?php if ( $input_value == 0 ) { echo "selected"; } ?> value="0"><?php if ( $input["zero_wording"] ) : echo $input["zero_wording"]; else : _e( "None" ); endif; ?></option>
				<?php endif; ?>

				<?php
					foreach ( $option_loop AS $option_label => $value ) {
						if ( $input["options"] == "loop_categories" ) {
							$use_value = $value->slug;
							$label = $value->cat_name;
						} elseif ( $input["options"] == "loop_pages" ) {
							$use_value = $value->ID;
							$label = $value->post_title;
						} else {
							$use_value = $value;
							$label = $option_label;
						} // if input options
				?>
						<option value="<?php echo $use_value ?>" <?php if ( $use_value == $input_value ) { echo "selected"; } ?>><?php echo $label; ?></option>
					<?php } // for each option loop ?>

					<?php if( 'header_fonts' == $input["name"] || 'body_fonts' == $input["name"] || 'footer_fonts' == $input["name"]
				) : ?>
					<option disabled="disabled">Google Fonts (Pro)</option>
				<?php endif ; ?>
				</select>
				<?php if( isset($input['pro']) &&  !obox_mobile_is_pro_active() ) :?>
					<br />
					<a style="float: right;" href="https://oboxthemes.com/obox-mobile/?utm_source=obox%mobile&utm_medium=upsell&utm_campaign=Obox%20Mobile%20Upsell&utm_content=<?php echo $input["name"]; ?>">Upgrade Now</a>
				<?php endif; ?>
			<?php
			break;
			case 'checkbox' :
				if ( isset( $option_loop ) && is_array( $option_loop ) ) :
			?>
				<ul class="form-options contained-forms">
					<?php foreach ( $option_loop AS $option_label => $value ) :
						if ( $input["options"] == "loop_categories" || $input["options"] == "multi_categories") {
							$use_value = $value->slug;
							$label = $value->cat_name;
						} elseif ( $input["options"] == "loop_pages" ) {
							$use_value = $value->ID;
							$label = $value->post_title;
						} else {
							$use_value = $value;
							$label = $option_label;
						}
						?>
						<li><input type="checkbox" name="<?php echo $input["name"] . "_" . $counter; ?>" id="<?php echo $input["id"] ?>" value="<?php echo $use_value ?>" <?php if ( $use_value == $input_value ) { echo "checked"; } ?> <?php echo $disabled; ?> /> <?php echo $label ?></li>
					<?php endforeach; ?>
				</ul>
			<?php else : ?>
				<input type="checkbox" name="obox_mobile[<?php echo $input["name"] ?>]" id="<?php echo $input["id"] ?>"<?php if ( $input_value == "true" ) { echo "checked"; } ?> <?php echo $disabled; ?> /> <?php if ( isset( $label ) ) { echo $label; } ?>
			<?php endif; // option_loop
			break;
			case 'radio' :
			?>
				<ul class="form-options contained-forms">
					<?php foreach ( $option_loop AS $option_label => $value ) :
						if ( $input["options"] == "loop_categories" ) :
							$use_value = $value->slug;
							$label = $value->cat_name;
						else :
							$use_value = $value;
							$label = $option_label;
						endif;
					?>
						<li><input type="radio" name="<?php echo $input["name"]; ?>" value="<?php echo $use_value; ?>" <?php if ( $use_value == $input_value ) { echo "selected"; } ?> />&nbsp;<?php echo $option_label; ?></li>
					<?php endforeach; // option loop ?>
				</ul>
			<?php
			break;
			case 'memo':
				if ( isset( $input["linked"] ) && $input["linked"] ) :
					if ( ( $obox_mobile->get_option( $input["linked"] ) ) && $obox_mobile->get_option( $input["linked"] ) !== "0" ) :
						$disabled_element = "disabled";
					else :
						$disabled_element = "";
					endif;
				else :
					$disabled_element = "";
				endif;
			?>
				<textarea name="obox_mobile[<?php echo $input["name"] ?>]" id="<?php echo $input["id"] ?>" <?php echo $disabled_element ?> class="site-tracking" <?php echo $disabled; ?> ><?php echo stripslashes($input_value); ?></textarea>
			<?php
			break;
			case 'css':
			?>
				<textarea name="obox_mobile[<?php echo $input["name"] ?>]" id="<?php echo $input["id"] ?>" class="custom-css Codemirror" <?php echo $disabled; ?>><?php echo stripslashes($input_value); ?></textarea>
			<?php
			break;
			case 'file':
			?>
				<div class="logo-display">
					<a href="<?php echo $input_value ?>" class="std_link" rel="lightbox" target="_blank" id="<?php echo $input["id"] ?>_href" style="background: url('<?php echo $input_value ?>') no-repeat center;"></a>
				</div>

				<div class="file">
					<input type="text" name="obox_mobile[<?php echo $input["name"] ?>]" id="<?php echo $input["id"] ?>_text" value="<?php echo $input_value ?>" />
					<input type="button"name="<?php echo $input["name"] ?>_file" <?php if ( isset( $input["id"] ) ) : ?>id="<?php echo $input["id"] ?>"<?php endif; ?> value="<?php _e( "Browse" ); ?>" class="button" />
					<input type="button" id="obox_mobile_clear_<?php echo $input["id"] ?>" value="<?php _e( "Clear" ); ?>" class="button" />
					<span class="tooltip"><?php _e( "Your image will not be automatically resized." ); ?></span>
				</div> <!-- file -->

				<p id="<?php echo $input["id"] ?>_info" style="display: none;"></p>
			<?php
			break;
			case 'button':
			?>
				<input type="button" name="obox_mobile[<?php echo $input["name"] ?>]" id="<?php echo $input["id"] ?>" value="<?php echo $input_value ?>" class="button-primary" />
			<?php
			break;
			case 'colour':
			?>
				<?php if( isset( $input['pro'] ) && !obox_mobile_is_pro_active() ) : ?>
					<a href="https://oboxthemes.com/obox-mobile/?utm_source=obox%mobile&utm_medium=upsell&utm_campaign=Obox%20Mobile%20Upsell&utm_content=<?php echo $input["name"]; ?>">
						<img src="<?php echo OBOXMOBILEURL; ?>/admin/images/get-pro@2x.png" /><br />
						Upgrade Now
					</a>
				<?php else : ?>
					<input type="text" name="obox_mobile[<?php echo $input["name"] ?>]" id="<?php echo $input["id"] ?>" value="<?php echo $input_value ?>" data-default-color="#<?php $input[ 'default' ]; ?>"
					<?php if(isset( $input[ 'selector' ] ) ){ ?>
						data-selector="<?php echo $input[ 'selector' ]; ?>"
					<?php } // isset selector ?>
					<?php if(isset( $input[ 'effect' ] ) ){ ?>
						data-effect="<?php echo $input[ 'effect' ]; ?>"
					<?php } // isset selector ?>
					/>
				<?php endif; ?>
			<?php
			break;
			case 'hidden':
			?>
				<input type="hidden" name="obox_mobile[<?php echo $input["name"] ?>]" id="<?php echo $input["id"] ?>" value="<?php echo $input_value ?>" />
			<?php
			break;
			default :
				if ( isset( $input["linked"] ) && $input["linked"] ) :
					if ( $obox_mobile->get_option( $input["linked"] ) && ( $obox_mobile->get_option( $input["linked"] ) != "0" ) ) :
						$disabled_element = "disabled";
					else :
						$disabled_element = "";
					endif;
				else :
					$disabled_element = "";
				endif;
			?>
				<input type="text" name="obox_mobile[<?php echo $input["name"] ?>]" id="<?php echo $input["id"] ?>" value="<?php echo $input_value ?>" <?php echo $disabled_element ?> />
			<?php
			break;
		endswitch;

		if ( $label_class != "" ) :
	?>
			</div>
	<?php endif; // label class ?>
<?php
} // create_obox_mobile_form
