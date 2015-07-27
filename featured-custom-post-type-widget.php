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

function featured_custom_post_type_widget_genesis_require() {
	require plugin_dir_path( __FILE__ ) . 'includes/class-featuredcustomposttypewidgetgenesis.php';
}
featured_custom_post_type_widget_genesis_require();

$featuredcustomposttypewidget = new Featured_Custom_Post_Type_Widget_Genesis();

$featuredcustomposttypewidget->run();
