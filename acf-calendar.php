<?php

/*
Plugin Name: Advanced Custom Fields: WP Booking System
Plugin URI: PLUGIN_URL
Description: A custom ACF field for picking WP Booking System Calendars and Forms
Version: 1.0.0
Author: AUTHOR_NAME
Author URI: AUTHOR_URL
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// Handle WP Booking System being deactivated
add_action( 'admin_init', function() {
	if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'wp-booking-system/wp-booking-system.php' ) ) {
			add_action( 'admin_notices', function(){?>
			<div class="error"><p>Advanced Custom Fields: WP Booking System plugin requires WP Booking System to be installed and active.</p></div>
			<?php } );

			deactivate_plugins( plugin_basename( __FILE__ ) ); 

			if ( isset( $_GET['activate'] ) ) {
					unset( $_GET['activate'] );
			}
	}
} );

// Handle the missing plugin
register_activation_hook( __FILE__, function(){

	if ( ! is_plugin_active( 'wp-booking-system/wp-booking-system.php' ) and current_user_can( 'activate_plugins' ) ) {
			// Stop activation redirect and show error
			wp_die('Sorry, but this plugin requires the WP Booking System to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
	}
} );


// check if class already exists
if( !class_exists('wbs_acf_plugin_calendar') ) :

class wbs_acf_plugin_calendar {
	
	// vars
	var $settings;
	
	
	/*
	*  __construct
	*
	*  This function will setup the class functionality
	*
	*  @type	function
	*  @date	17/02/2016
	*  @since	1.0.0
	*
	*  @param	void
	*  @return	void
	*/
	
	function __construct() {
		
		// settings
		// - these will be passed into the field class.
		$this->settings = array(
			'version'	=> '1.0.0',
			'url'		=> plugin_dir_url( __FILE__ ),
			'path'		=> plugin_dir_path( __FILE__ )
		);
		
		
		// include field
		add_action('acf/include_field_types', 	array($this, 'include_field')); // v5
		add_action('acf/register_fields', 		array($this, 'include_field')); // v4
	}
	
	
	/*
	*  include_field
	*
	*  This function will include the field type class
	*
	*  @type	function
	*  @date	17/02/2016
	*  @since	1.0.0
	*
	*  @param	$version (int) major ACF version. Defaults to false
	*  @return	void
	*/
	
	function include_field( $version = false ) {
		
		// support empty $version
		if( !$version ) $version = 4;
		
		
		// load textdomain
		load_plugin_textdomain( 'wbs', false, plugin_basename( dirname( __FILE__ ) ) . '/lang' ); 
		
		
		// include
		include_once('includes/helper.php');
		include_once('fields/class-wbs-acf-field-calendar-v' . $version . '.php');
		include_once('fields/class-wbs-acf-field-form-v' . $version . '.php');
	}
	
}


// initialize
new wbs_acf_plugin_calendar();


// class_exists check
endif;
	
?>