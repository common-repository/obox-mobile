<?php
header( 'Content-type: text/css' );
global $obox_mobile, $obox_mobile_plugin_options;
$obox_mobile_options = $obox_mobile->get_options();

foreach ($obox_mobile_plugin_options[ 'customization_options' ] as $option ) {
	foreach( $option [ 'sub_elements' ] as $sub_element ) {
		if( isset( $sub_element[ 'effect' ] ) && isset( $obox_mobile_options [ $sub_element[ 'name' ] ] ) ) {

			if( '#' != $obox_mobile_options [ $sub_element[ 'name' ] ] ) {
				echo "\n".'/* Custom ' . $sub_element[ 'label' ] . ' */';

				echo "\n". str_replace(array("\r\n", "\r", "\t"), '', $sub_element[ 'selector' ]) . ' { ';
				echo $sub_element[ 'effect' ] . ' : ' . $obox_mobile_options [ $sub_element[ 'name' ] ];
				if(isset( $sub_element[ 'important' ]) )
					echo ' !important';
				echo ' ; }';
				echo "\n\n";
			} // If this element is empty
		}
	} // foreach sub element
}// foreach customization_options

if ( isset( $obox_mobile_options[ "custom_css" ] ) && $obox_mobile_options[ "custom_css" ] != '' ) {
	echo $obox_mobile_options[ "custom_css" ];
} // if obox_mobile_custom_css

if ( isset( $obox_mobile_options[ "custom_background" ] ) && $obox_mobile_options[ "custom_background" ] != '' ) : ?>
	body {
		background: url('<?php echo $obox_mobile_options[ "custom_background" ]; ?>') repeat;
	}
<?php endif; // if obox_mobile_custom_background