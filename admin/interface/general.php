<?php

function obox_mobile_form_options( $input ) {
	global $counter, $label_class;
	if ( $input ) :
?>
	<li class="admin-block-item">
		<!-- Admin label & descriptions-->
		<?php obox_mobile_admin_description_html( $input ) ; ?>

		<!-- Admin form items -->
		<?php obox_mobile_admin_content_html( $input ) ; ?>
	</li>
<?php
	endif; // input
} // obox_mobile_form_options

add_action( "obox_mobile_form_options", "obox_mobile_form_options" );

// This function outputs the form labels and description

function obox_mobile_admin_description_html( $input ) {
	global $counter, $label_class; ?>
	<div class="admin-description">
		<?php if ( isset( $input["main_section"] ) && $input["main_section"] ) : ?>
			<h4><?php _e( $input["main_section"] ); ?></h4>
			<?php if ( $input["main_description"] !== "" ) : ?>
				<p><?php _e( $input["main_description"] ); ?></p>
			<?php endif; // main description ?>
		<?php else : ?>
			<h4><?php _e( $input["label"] ); ?></h4>
			<?php if ( $input['description'] !== "" ) : ?>
				<p><?php _e( $input["description"] ); ?></p>
			<?php endif; // description ?>
		<?php endif; // main section ?>
	</div> <!-- admin-description -->
<?php } // obox_mobile_admin_description_html

// This function outputs the form item itself

function obox_mobile_admin_content_html( $input ) {
	global $counter, $label_class; ?>
	<div class="admin-content">
		<?php if ( isset( $input["main_section"] ) ) : ?>

			<?php if ( isset( $input["note"] ) ) : ?>
				<p><em><?php _e( $input["note"] ); ?></em></p>
			<?php endif; // note ?>

			<ul class="form-options contained-forms">
				<?php foreach( $input["sub_elements"] AS $sub_input ) :
					if ( isset( $sub_input["linked"] ) ) {
						$option = $sub_input["linked"];

						$hideme = ( get_option( $option ) == "false" || get_option( $option ) == "no" || get_option( $option ) == "off") ? TRUE : FALSE;

						$showif = "rel='" . $sub_input["linked"] . "'";
					} // sub_input linked
				?>
					<li <?php if ( isset( $hideme ) && $hideme ) : ?>class="no_display"<?php endif; ?> <?php if ( isset ($showif ) ) : echo $showif; endif; ?>>
						<?php if($sub_input["input_type"] == "checkbox") : ?>
							<div class="form-wrap checkboxes">
								<?php create_obox_mobile_form($sub_input, count($input), "child-form"); ?>
								<label class="child-label" for="<?php echo $sub_input["id"]; ?>"><?php echo $sub_input["label"]; ?></label>
							</div>
						<?php else : ?>
							<h4><?php echo $sub_input["label"] ?></h4>
							<div class="form-wrap">
								<?php create_obox_mobile_form( $sub_input, count( $input ), "child-form" ); ?>
							</div>
						<?php endif; ?>
						<?php if ( isset( $sub_input["description"] ) && $sub_input["description"] != "" ) : ?>
							<span class="tooltip"><?php echo $sub_input["description"] ?></span>
						<?php endif; // sub input description ?>
					</li>
				<?php endforeach; // sub element ?>
			</ul>
		<?php else :
			create_obox_mobile_form( $input, count( $input ), $label_class );
		endif; // input main section ?>
	</div> <!-- admin-content -->
<?php } // obox_mobile_admin_content_html

	
function obox_mobile_is_pro_active(){
	return apply_filters( 'mobile_is_pro_active', false );
}