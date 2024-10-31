<?php
global $obox_mobile;
$obox_mobile_options = $obox_mobile->get_options();
?>


			<?php // Setup the body font classes
                if( isset( $obox_mobile_options[ 'body_fonts' ] ) && $obox_mobile_options[ 'body_fonts' ] != '')
                    $font_class = $obox_mobile_options[ 'body_fonts' ];
                else
                    $font_class = '' ;?>
                    
            <div id="footer-container" data-role="footer" class="<?php echo $font_class; ?>">
                <?php obox_mobile_advert("footer"); ?>
                <div id="footer">
                    <?php if ( $obox_mobile_options[ "custom_copyright" ] != "" ) : ?>
                        <p><?php echo $obox_mobile_options[ "custom_copyright" ]; ?></p>
                    <?php endif; // mobile custom copyright ?>
                    
                    <div class="footer-secondary">
                        <?php obox_mobile_switch(); ?>
                        <?php if ( stripslashes( $obox_mobile_options[ "custom_footer" ] ) != "" ) : ?>
                            <p class="obox"><?php echo stripslashes( $obox_mobile_options[ "custom_footer" ] ); ?></p>
                        <?php endif; // mobile custom footer ?>
                    </div>                
                </div> <!-- footer -->
                <?php wp_footer(); ?>
            </div> <!-- footer-container -->
        </div> <!-- #content-container -->
        
	</div><!-- #container -->
    
	<?php
	if ( $obox_mobile_options[ "googleAnalytics" ] ) {
		echo stripslashes( $obox_mobile_options[ "googleAnalytics" ] );
	} // obox_mobile_googleAnalytics
	?>
    
</body>
</html>
