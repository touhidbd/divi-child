<?php
/*
	Divi Child Functions
*/


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	
// plugin version, used to add version for scripts and styles
define( 'WPDC_VER', '1.0' );
define( 'WPDC_THEME_NAME', 'Divi Child Theme' );
	
// includes
include( 'inc/admin/settings.php' );
include( 'inc/customizer/customizer.php' );

// include builder integration
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
	
	include( 'inc/builder/class-divi-builder-integration-admin.php' );
	add_action( 'after_setup_theme', array( 'Divi_Builder_Integration_Admin', 'get_instance' ) );

}

add_action( 'wp_head', 'wpdc_remove_space_before_footer');

function wpdc_remove_space_before_footer() { 
	
	if ( ! is_single() ) return;
	//if ( $is_page_builder_used ) return;
	if ( comments_open() && 'false' != et_get_option( 'divi_show_postcomments', 'on' ) ) return;
	?>
<style>
/* BODY */
<?php echo '.single .post {padding-bottom: 0px;}'; ?>
</style>
<?php
}

