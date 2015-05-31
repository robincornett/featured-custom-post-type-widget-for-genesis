<?php
/**
 * Featured Custom Post Type Widget For Genesis
 * @package FeaturedCustomPostTypeWidgetForGenesis
 * @author Jo Waltham
 * @license GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Featured Custom Post Type Widget for Genesis
 * Plugin URI:  http://calliaweb.co.uk/featured-custom-post-type-widget-genesis/
 * Description: Widget to Display Featured Custom Post Types - uses code from Genesis Featured Post Widget and adds support for custom post types and custom taxonomies
 * Version:     2.1.0
 * Author:      Jo Waltham
 * Author URI:  http://calliaweb.co.uk/
 * Text Domain: featured-custom-post-type-widget-for-genesis
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
*/

// if this file is called directly abort
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'init', 'gfcptw_init' );
function gfcptw_init() {
	if ( 'genesis' !== basename( get_template_directory() ) ) {
		add_action( 'admin_init', 'gfcptw_deactivate' );
		add_action( 'admin_notices', 'gfcptw_notice' );
		return;
	}
	add_action( 'plugins_loaded', 'gfcptw_load_textdomain' );
	add_action( 'admin_enqueue_scripts', 'gfcptw_admin_enqueue' );

}

function gfcptw_deactivate() {
	deactivate_plugins( plugin_basename( __FILE__ ) );
}

function gfcptw_notice() {
	$message = __( '<strong>Featured Custom Post Type Widget For Genesis</strong> works only with the Genesis Framework. It has been <strong>deactivated</strong>.', 'featured-custom-post-type-widget-for-genesis' );
	printf( '<div class="error"><p>%s</p></div>', esc_attr( $message ) );
}

// Register the widget
add_action( 'widgets_init', 'gfcptw_register_widget' );
function gfcptw_register_widget() {
	register_widget( 'Genesis_Featured_Custom_Post_Type' );
}

/**
 * Set up text domain for translations
 *
 * @since 2.0.0
 */
function gfcptw_load_textdomain() {
	load_plugin_textdomain( 'featured-custom-post-type-widget-for-genesis', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

/**
 * Enqueues the small bit of Javascript which will handle the Ajax
 * callback to correctly populate the custom term dropdown.
 */
function gfcptw_admin_enqueue() {
	$screen = get_current_screen()->id;
	if ( in_array( $screen, array( 'widgets', 'customize' ) ) ) {
		wp_enqueue_script( 'tax-term-ajax-script', plugins_url( 'includes/js/ajax_handler.js', __FILE__ ), array( 'jquery' ) );
		wp_localize_script( 'tax-term-ajax-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}
}

require plugin_dir_path( __FILE__ ) . 'includes/class-featured-custom-post-type-widget-registrations.php';
