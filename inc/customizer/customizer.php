<?php

/**
 * Theme Customizer Boilerplate
 *
 * @package		Theme_Customizer_Boilerplate
 * @copyright	Copyright (c) 2012, Slobodan Manic
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 * @author		Slobodan Manic
 *
 * @since		Theme_Customizer_Boilerplate 1.0
 *
 * License:
 *	
 * Copyright 2013 Slobodan Manic (slobodan.manic@gmail.com)
 *	
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *	
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *	
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */


/**
 * Arrays of options
 */	
require( dirname(__FILE__) . '/options.php' );

/**
 * Helper functions
 */	
require( dirname(__FILE__) . '/helpers.php' );

/**
 * Adds Customizer Sections, Settings and Controls
 *
 * - Require Custom Customizer Controls
 * - Add Customizer Sections
 *   -- Add Customizer Settings
 *   -- Add Customizer Controls
 *
 * @uses	wpdc_customizerget_theme_customizer_sections()	Defined in helpers.php
 * @uses	wpdc_customizersettings_page_capability()			Defined in helpers.php
 * @uses	wpdc_customizerget_theme_customizer_fields()		Defined in options.php
 *
 * @link	$wp_customize->add_section				http://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_section
 * @link	$wp_customize->add_setting				http://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
 * @link	$wp_customize->add_control				http://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
 */
function wpdc_customizercbp_customize_register( $wp_customize ) {

	/**
	 * Custom controls
	 */	
	require( dirname(__FILE__) . '/custom-controls.php' );


	/*
	 * Get all the fields using a helper function
	 */
	$wpdc_customizersections = wpdc_customizercbp_get_fields();


	/*
	 * Get name of DB entry under which options will be stored
	 */
	$wpdc_customizercbp_option = wpdc_customizercbp_option();


	/**
	 * Loop through the array and add Customizer sections
	 */
	foreach( $wpdc_customizersections as $wpdc_customizersection_key => $wpdc_customizersection_value ) {
		
		/**
		 * Adds Customizer section, if needed
		 */
		if( ! $wpdc_customizersection_value['existing_section'] ) {
			
			$wpdc_customizersection_args = $wpdc_customizersection_value['args'];
			
			// Add section
			$wp_customize->add_section(
				$wpdc_customizersection_key,
				$wpdc_customizersection_args
			);
			
		} // end if
		
		/*
		 * Loop through 'fields' array in each section
		 * and add settings and controls
		 */
		$wpdc_customizersection_fields = $wpdc_customizersection_value['fields'];
		foreach( $wpdc_customizersection_fields as $wpdc_customizerfield_key => $wpdc_customizerfield_value ) {

			/*
			 * Check if 'option' or 'theme_mod' is used to store option
			 *
			 * If nothing is set, $wp_customize->add_setting method will default to 'theme_mod'
			 * If 'option' is used as setting type its value will be stored in an entry in
			 * {prefix}_options table. Option name is defined by wpdc_customizercbp_option() function
			 */
			if ( isset( $wpdc_customizerfield_value['setting_args']['type'] ) && 'option' == $wpdc_customizerfield_value['setting_args']['type'] ) {
				$setting_control_id = $wpdc_customizercbp_option . '[' . $wpdc_customizerfield_key . ']';
			} else {
				$setting_control_id = $wpdc_customizerfield_key;
			}
			
			/*
			 * Add default callback function, if none is defined
			 */
			if ( ! isset( $wpdc_customizerfield_value['setting_args']['sanitize_cb'] ) ) {
				$wpdc_customizerfield_value['setting_args']['sanitize_cb'] = 'wpdc_customizercbp_sanitize_cb';
			}

			/**
			 * Adds Customizer settings
			 */
			$wp_customize->add_setting(
				$setting_control_id,
				$wpdc_customizerfield_value['setting_args']
			);

			/**
			 * Adds Customizer control
			 *
			 * 'section' value must be added to 'control_args' array
			 * so control can get added to current section
			 */
			$wpdc_customizerfield_value['control_args']['section'] = $wpdc_customizersection_key;
			
			/*
			 * $wp_customize->add_control method requires 'choices' to be a simple key => value pair
			 */
			if ( isset( $wpdc_customizerfield_value['control_args']['choices'] ) ) {
				$wpdc_customizercbp_choices = array();
				foreach( $wpdc_customizerfield_value['control_args']['choices'] as $wpdc_customizercbp_choice_key => $wpdc_customizercbp_choice_value ) {
					$wpdc_customizercbp_choices[$wpdc_customizercbp_choice_key] = $wpdc_customizercbp_choice_value['label'];
				}
				$wpdc_customizerfield_value['control_args']['choices'] = $wpdc_customizercbp_choices;		
			}
			
			
			// Check 
			if ( 'color' == $wpdc_customizerfield_value['control_args']['type'] ) {
				$wp_customize->add_control(
					new WP_Customize_Color_Control(
						$wp_customize,
						$setting_control_id,
						$wpdc_customizerfield_value['control_args']
					)
				);
			} elseif ( 'image' == $wpdc_customizerfield_value['control_args']['type'] ) { 
				$wp_customize->add_control(
					new WP_Customize_Image_Control(
						$wp_customize,
						$setting_control_id,
						$wpdc_customizerfield_value['control_args']
					)
				);
			} elseif ( 'upload' == $wpdc_customizerfield_value['control_args']['type'] ) { 
				$wp_customize->add_control(
					new WP_Customize_Upload_Control(
						$wp_customize,
						$setting_control_id,
						$wpdc_customizerfield_value['control_args']
					)
				);
			} elseif ( 'number' == $wpdc_customizerfield_value['control_args']['type'] ) { 
				$wp_customize->add_control(
					new WPDC_Customizer_Number_Control(
						$wp_customize,
						$setting_control_id,
						$wpdc_customizerfield_value['control_args']
					)
				);
			} elseif ( 'textarea' == $wpdc_customizerfield_value['control_args']['type'] ) { 
				$wp_customize->add_control(
					new WPDC_Customizer_Textarea_Control(
						$wp_customize,
						$setting_control_id,
						$wpdc_customizerfield_value['control_args']
					)
				);
			} elseif ( 'images_radio' == $wpdc_customizerfield_value['control_args']['type'] ) {
				$wp_customize->add_control(
					new WPDC_Customizer_Images_Radio_Control(
						$wp_customize,
						$setting_control_id,
						$wpdc_customizerfield_value['control_args']
					)
				);
			} else {
				$wp_customize->add_control(
					$setting_control_id,
					$wpdc_customizerfield_value['control_args']
				);
			}
				
		} // end foreach
		
	} // end foreach
	
	
	// Remove built-in Customizer sections
	$wpdc_customizercbp_remove_sections = apply_filters( 'tshp_cbp_remove_sections', array() );
	if ( is_array( $wpdc_customizercbp_remove_sections) ) {
		foreach( $wpdc_customizercbp_remove_sections as $wpdc_customizercbp_remove_section ) {
			$wp_customize->remove_section( $wpdc_customizercbp_remove_section );
		}
	}

	// Remove built-in Customizer settings
	$wpdc_customizercbp_remove_settings = apply_filters( 'tshp_cbp_remove_settings', array() );
	if ( is_array( $wpdc_customizercbp_remove_settings) ) {
		foreach( $wpdc_customizercbp_remove_settings as $wpdc_customizercbp_remove_setting ) {
			$wp_customize->remove_setting( $wpdc_customizercbp_remove_setting );
		}
	}	

	// Remove built-in Customizer controls
	$wpdc_customizercbp_remove_controls = apply_filters( 'tshp_cbp_remove_controls', array() );
	if ( is_array( $wpdc_customizercbp_remove_controls) ) {
		foreach( $wpdc_customizercbp_remove_controls as $wpdc_customizercbp_remove_control ) {
			$wp_customize->remove_control( $wpdc_customizercbp_remove_control );
		}
	}	

}
add_action( 'customize_register', 'wpdc_customizercbp_customize_register', 11 );


/**
 * Theme Customizer sanitization callback function
 */
function wpdc_customizercbp_sanitize_cb( $input ) {
	
	return wp_kses_post( $input );
	
}