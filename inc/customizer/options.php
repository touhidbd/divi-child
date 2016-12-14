<?php

/**
 * Get Theme Customizer Fields
 *
 * @package		Theme_Customizer_Boilerplate
 * @copyright	Copyright (c) 2013, Slobodan Manic
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 * @author		Slobodan Manic
 *
 * @since		Theme_Customizer_Boilerplate 1.0
 */


/**
 * Helper function that holds array of theme options.
 *
 * @return	array	$options	Array of theme options
 * @uses	wpdc_customizerget_theme_customizer_fields()	defined in customizer/helpers.php
 */
function wpdc_customizercbp_get_fields() {

	/*
	 * Using helper function to get default required capability
	 */
	$wpdc_customizercbp_capability = wpdc_customizercbp_capability();
	
	$options = array(

		
		// Section ID
		'wpdc_settings' => array(
		
			/*
			 * We're checking if this is an existing section
			 * or a new one that needs to be registered
			 */
			'existing_section' => false,
			/*
			 * Section related arguments
			 * Codex - http://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_section
			 */
			'args' => array(
				'title' => __( 'Footer Attributes', 'Divi' ),
				'description' => __( 'Customize the footer attributes', 'Divi' ),
				//'priority' => 45
			),
			
			/* 
			 * This array contains all the fields that need to be
			 * added to this section
			 */
			'fields' => array(
				
				
				/*
				 * ==============
				 * ==============
				 * Footer Attributes field
				 * ==============
				 * ==============
				 */
				'wpdc_footer_attributes' => array(
					'setting_args' => array(
						'default' => 'Designed by <a href="http://www.elegantthemes.com" title="Premium WordPress Themes">Elegant Themes</a>
									 | Powered by <a href="http://www.wordpress.org">WordPress</a>',
						'type' => 'option',
						'capability' => $wpdc_customizercbp_capability,
						'transport' => 'refresh',
					),					
					'control_args' => array(
						'label' => __( 'Footer Attributes HTML', 'Divi' ),
						'type' => 'textarea', // Color field control
						'priority' => 2
					)
				),
				// end of Footer Attributes field

			),
			
		)

	);
	
	/* 
	 * 'wpdc_customizercbp_options_array' filter hook will allow you to 
	 * add/remove some of these options from a child theme
	 */
	return apply_filters( 'wpdc_customizercbp_options_array', $options );
	
}


/**
 * return footer attributes
 */
function wpdc_footer_attributes() {
		
	$options = wpdc_customizercbp_get_options_values();
		
	//if( '' == $options['wpdc_editor_rating_color']) return '';
		
	$footer_attributes = $options['wpdc_footer_attributes'];
	//$footer_attributes = get_theme_mod( 'wpdc_footer_attributes', get_option( 'wpdc_footer_attributes' ) );
		
	return $footer_attributes;
		
}

