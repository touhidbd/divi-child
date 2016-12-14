<?php


/**
 * Customizer Directory
 *
 * @return	string	The directory in which Customizer Boilerplate is located, no trailing slash
 */
function wpdc_customizercbp_directory_uri() {

	//$wpdc_customizercbp_directory_uri = get_template_directory_uri() . '/inc/customizer';
	$wpdc_customizercbp_directory_uri = WPDC_CUSTOMIZER_INC_URL . '/customizer';
	
	
	return apply_filters( 'wpdc_customizercbp_directory_uri', $wpdc_customizercbp_directory_uri );

}


/**
 * Capability Required to Save Theme Options
 *
 * @return	string	The capability to actually use
 */
function wpdc_customizercbp_capability() {

	return apply_filters( 'wpdc_customizercbp_capability', 'edit_theme_options' );

}


/**
 * Dashboard menu link text
 *
 * Hook into this to make the text translatable, for example you could
 * return this
 * __( 'Theme Customizer', 'my_theme_textdomain' )
 *
 * @return	string	Menu link text
 */
function wpdc_customizercbp_menu_link_text() {

	return apply_filters( 'wpdc_customizercbp_menu_link_text', 'WPRS Customizer' );

}


/**
 * Name of DB entry under which options are stored if 'type' => 'option'
 * is used for Theme Customizer settings
 *
 * @return	string	DB entry
 */
function wpdc_customizercbp_option() {

	return apply_filters( 'wpdc_customizercbp_option', 'wpdc_customizercbp_theme_options' );

}


/**
 * Get Option Values
 * 
 * Array that holds all of the options values
 * Option's default value is used if user hasn't specified a value
 *
 * @uses	wpdc_customizerget_theme_customizer_defaults()	defined in /customizer/options.php
 * @return	array									Current values for all options
 * @since	Theme_Customizer_Boilerplate 1.0
 */
function wpdc_customizercbp_get_options_values() {

	// Get the option defaults
	$option_defaults = wpdc_customizercbp_get_options_defaults();
	
	// Parse the stored options with the defaults
	$wpdc_customizercbp_options = wp_parse_args( get_option( wpdc_customizercbp_option(), array() ), $option_defaults );
	
	// Return the parsed array
	return $wpdc_customizercbp_options;
	
}


/**
 * Get Option Defaults
 * 
 * Returns an array that holds default values for all options
 * 
 * @uses	wpdc_customizerget_theme_customizer_fields()	defined in /customizer/options.php
 * @return	array	$wpdc_customizeroption_defaults		Default values for all options
 * @since	Theme_Customizer_Boilerplate 1.0
 */
function wpdc_customizercbp_get_options_defaults() {

	// Get the array that holds all theme option fields
	$wpdc_customizersections = wpdc_customizercbp_get_fields();
	
	// Initialize the array to hold the default values for all theme options
	$wpdc_customizeroption_defaults = array();
	
	// Loop through the option parameters array
	foreach ( $wpdc_customizersections as $wpdc_customizersection ) {
	
		$wpdc_customizersection_fields = $wpdc_customizersection['fields'];
		
		foreach ( $wpdc_customizersection_fields as $wpdc_customizerfield_key => $wpdc_customizerfield_value ) {

			// Add an associative array key to the defaults array for each option in the parameters array
			if( isset( $wpdc_customizerfield_value['setting_args']['default'] ) ) {
				$wpdc_customizeroption_defaults[$wpdc_customizerfield_key] = $wpdc_customizerfield_value['setting_args']['default'];
			} else {
				$wpdc_customizeroption_defaults[$wpdc_customizerfield_key] = false;
			}
			
		}
		
	}
	
	// Return the defaults array
	return $wpdc_customizeroption_defaults;
	
}