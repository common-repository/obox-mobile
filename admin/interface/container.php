<?php

class OBOX_obox_mobile_Container {

	public function load_container( $section_header, $ocmx_tabs = 0, $submit_text = "Save Changes", $note = "" ) {
		global $obox_mobile_plugin_options, $selected_tab, $ocmx_version;

		$selected_tab = ( isset( $_GET["obox_mobile_current_tab"] ) && is_numeric( $_GET["obox_mobile_current_tab"] ) ) ? $_GET["obox_mobile_current_tab"] : 1;

		wp_enqueue_style( 'obox-mobile-admin' ,  OBOXMOBILEURL  . 'admin/css/style.css?v=1.0' ); ?>

		<form action="" name="mobile-options" id="mobile-options" method="post" enctype="multipart/form-data">
			<?php wp_nonce_field( 'obox-mobile-save', '_obox_mobile_nonce' ); ?>
			<div class="mobile-container">
				<div class="wrap">
					<div class="mobile-title-block">
						<h2>
							Pronto
						</h2>
						<h5>
							<span>
								 &nbsp;|&nbsp;<a href="http://www.oboxthemes.com/">See what's new</a>
							</span>
							<span>
								Version <?php echo OBOXMOBILE_VER ?>
							</span>
						</h5>
					</div>
					<?php if ( isset($_GET["changes_done"]) ) : ?>
						<div class="updated below-h2" id="mobile-note">
							<p><?php _e( "Your changes were successful." ) ?></p>
						</div> <!-- mobile-note -->
					<?php elseif ( isset( $_GET["options_reset"] ) ) : ?>
						<div class="updated below-h2" id="mobile-note">
							<p><?php _e( "All Pronto Options Have Been Reset." ) ?></p>
						</div> <!-- mobile-note -->
					<?php endif; // changes or reset ?>

					<!-- All the form buttons -->
					<div id="header-block" class="clearfix">

						<?php if ( isset( $submit_text ) && $submit_text != "" ) :?>
							<input type="submit" class="obox-save" value="<?php _e( $submit_text ); ?>" />
							<input type="button" id="mobile-reset" class="obox-reset" value="<?php _e( "Reset" ); ?>" />
						<?php endif; // submit text ?>

						<h3><?php echo $section_header ?></h3>
					</div> <!-- header-block -->

					<!-- OBOX Tabs -->
					<?php if ( count( $ocmx_tabs ) > 1 ) : ?>
						<?php $tab_i = 1; ?>
						<div id="info-content-block">
							<ul id="tabs" class="tabs clearfix">
								<?php foreach ( $ocmx_tabs AS $tab ) : ?>
									<li <?php if ( $selected_tab == $tab_i ) : ?>class="selected" <?php endif; ?>>
										<a href="#" rel="#tab-<?php echo $tab_i; ?>"><?php echo $tab["option_header"] ?></a>
									</li>
									<?php $tab_i++; ?>
								<?php endforeach; // tab ?>
							</ul>
						</div> <!-- info-content-block -->
					<?php endif; // count ocmx_tabs ?>

					<!-- OBOX Form Content -->
					<?php $tab_i = 1; ?>
					<div id="content-block">
						<?php if ( $note != "" ) : ?>
							<p class="admin-note"><?php echo $note ?></p>
						<?php endif; // note ?>
						<?php foreach ( $ocmx_tabs AS $tab => $taboption ) : ?>
							<ul class="<?php echo $taboption["ul_class"] ?>" <?php if ( $selected_tab != $tab_i ) : ?>style="display: none;"<?php endif; ?> id="tab-<?php echo $tab_i ?>">
								<?php $use_options = $taboption["function_args"];
								if ( 'customization_options' != $use_options && isset($obox_mobile_plugin_options[ $use_options ] ) ) :
									foreach ( $obox_mobile_plugin_options[ $use_options ] AS $use_theme_options => $which_array ) :
										do_action( $taboption["use_function"], $which_array );
									endforeach; // mobile theme options
								else :
									do_action( $taboption["use_function"], array() );
								endif; // mobile theme options
								?>
							</ul>
							<?php $tab_i++; ?>
						<?php endforeach; // tab ?>

						<!-- Second row of form buttons -->
						<div class="base-controls clearfix">
							<?php if ( $submit_text != "" ) : ?>
								<input type="submit" class="obox-save" value="<?php _e( $submit_text ) ?>" />
								<input type="button" id="mobile-reset-1" class="obox-reset" value="<?php _e( "Reset" ) ?>" />
							<?php endif; // submit_text ?>

							<?php
							if ( count ( $ocmx_tabs ) >= 1 ) :
								$tab_i = 1;
								foreach ( $ocmx_tabs AS $tab => $taboption ) :
									if ( isset( $taboption["base_button"] ) && $taboption["base_button"] != NULL ) :
							?>
										<div <?php if ( $selected_tab != $tab_i ): ?>style="display: none;"<?php endif; ?> id="tab-<?php echo $tab_i ?>-href-1">
											<a href="<?php echo $taboption["base_button"]["href"] ?>" id="<?php echo $taboption["base_button"]["id"] ?>" rel="<?php echo $taboption["base_button"]["rel"] ?>" class="obox-save">
												<?php _e( $taboption["base_button"]["html"] ) ?>
											</a>
										</div>
							<?php
									endif; // taboption
									$tab_i++;
								endforeach; // ocmx tab
							endif; // count tabs
							?>
						</div> <!-- base-controls -->
					</div> <!-- content-block -->
				</div> <!-- wrap -->
			</div> <!-- mobile-container -->
			<input type="hidden" name="update_ocmx" value="<?php foreach ( $ocmx_tabs AS $tab ) : echo $tab['function_args'].","; endforeach; // tab ?>" />
			<input type="hidden" name="obox_mobile_save_list" value="<?php foreach ( $ocmx_tabs AS $tab ) : echo $tab['option_header'].","; endforeach; // tab ?>" />
		</form>
<?php
	} // load_container

} // OBOX_obox_mobile_Container
