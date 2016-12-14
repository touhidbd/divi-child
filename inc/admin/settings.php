<?php  
/*
    Settings
    */
	
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	
    // register settings
    function wpdc_my_settings_init() {
        // register the settins for the plugin here   (you might want to give it more unique names)
		register_setting( 'wpdc_plugin_options_group', 'wpdc_options', 'wpdc_sanitize_wpdc_validate_options' );
    }
    add_action('admin_init', 'wpdc_my_settings_init');
	add_action('init', 'wpdc_check_active');

    // register the plugin admin page
    // this is called if the plugin is valid and ok
    function wpdc_my_add_plugin_admin_page(){
						
		$themename = 'Divi';

		add_theme_page(
						$themename . ' ' . esc_html__( 'Options', $themename ),
						$themename . ' ' . esc_html__( 'Child Options', $themename ),
						'switch_themes',
						'divi_child',
						'wpdc_divi_child_options_page'
					);
    }


	// Sanitize and validate input. Accepts an array, return a sanitized array.
	function wpdc_sanitize_wpdc_validate_options($input) {
		// do stuff with $options to check they are ok
        if(isset($_POST['reset'])){
			delete_option('wpdc_settings_license_option');
		}	
		return $input;
	}

			
	
    /**
    * call back function that renders your plugins settings page
    * 
    */
    function wpdc_divi_child_options_page(){
		
		$options = get_option('wpdc_options');
		
        echo '<div class="wrap">';
		echo '<h2>'.WPDC_THEME_NAME.' Options <span style="font-size:10px;">Ver '.WPDC_VER.'</span></h2>';
		echo '<form method="post" action="options.php">';
		settings_fields('wpdc_plugin_options_group');
		settings_errors();
		require_once ('views.php');		// load table settings
		echo '<div style="clear:both;"></div>';
		echo '</div>';
		echo '<div style="clear:both;"></div>';
        echo '</form>';
    }
	
    // this function should definitely be obfuscated or encrypted so hacker cannot bypass it
    // we call this function at the init action so it can set up all the proper actions and filters that the plugin would use.
    // we only do the actions required for validation if the plugin is not yet valid
    function wpdc_check_active(){      

            // plugin is ok
            // do the actions and filters
			add_action( 'admin_menu',	'wpdc_my_add_plugin_admin_page'); // the function to show the plugin settings page
    }

	
