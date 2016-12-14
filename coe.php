<?php

/**
 * Plugin Name: Center of Excellence
 * Plugin URI: http://www.coeaerospace.com/
 * Description: Custom Plugin for Center of Excellence
 * Author: Tony DeStefano
 * Author URI: https://www.facebook.com/TonyDeStefanoWebcom
 * Version: 1.0.0
 * Text Domain: coe
 *
 * Copyright 2016 Tony DeStefano
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

require_once ( 'classes/COE/Controller.php' );
require_once ( 'classes/COE/College.php' );
require_once ( 'classes/COE/Program.php' );
require_once ( 'classes/COE/ProgramCategory.php' );
require_once ( 'classes/COE/Award.php' );

/* controller object */
$coe_controller = new \COE\Controller;

/* activate */
register_activation_hook( __FILE__, array( $coe_controller, 'activate' ) );

/* enqueue js and css */
add_action( 'init', array( $coe_controller, 'init' ) );

/* Create custom post types */
add_action( 'init', array( $coe_controller, 'create_post_types' ) );

/* capture form post */
add_action ( 'init', array( $coe_controller, 'form_capture' ) );

/* register shortcode */
add_shortcode ( 'coe', array( $coe_controller, 'short_code' ) );

/* admin stuff */
if ( is_admin() )
{
	/* Add main menu and sub-menus */
	add_action( 'admin_menu', array( $coe_controller, 'admin_menus') );

	/* register settings */
	add_action( 'admin_init', array( $coe_controller, 'register_settings' ) );

	/* admin scripts */
	add_action( 'admin_init', array( $coe_controller, 'admin_scripts' ) );

	/* remove the "view" action from the custom post type */
	add_filter( 'post_row_actions', array( $coe_controller, 'remove_row_actions' ), 10, 1 );
	add_filter('post_updated_messages', array( $coe_controller, 'custom_post_type_messages' ) );

	/* add the settings page link */
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $coe_controller, 'settings_link' ) );

	/* add the instructions page link */
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $coe_controller, 'instructions_link' ) );

	/* add the settings page */
	add_action( 'admin_menu', array( $coe_controller, 'settings_page' ) );

	add_action( 'save_post', array( $coe_controller, 'save_custom_post_meta' ) );
	
	/* college meta */
	add_action( 'admin_init', array( $coe_controller, 'college_meta' ) );
	add_filter( 'manage_wbb_neighborhood_posts_columns', array( $coe_controller, 'add_new_collge_columns' ) );
	add_action( 'manage_posts_custom_column' , array( $coe_controller, 'custom_college_columns' ) );
}
