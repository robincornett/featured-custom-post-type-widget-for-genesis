<?php

class Featured_Custom_Post_Type_Widget_Genesis {

	public function run() {
		if ( 'genesis' !== basename( get_template_directory() ) ) {
			add_action( 'admin_init', array( $this, 'deactivate' ) );
			add_action( 'admin_notices', array( $this, 'error_notice' ) );
			return;
		}
		add_action( 'widgets_init', array( $this, 'register' ) );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		require_once plugin_dir_path( __FILE__ ) . 'class-featuredcustomposttypewidgetgenesis-widget.php';

	}

	function deactivate() {
		$dirname = version_compare( PHP_VERSION, '5.3', '>=' ) ? __DIR__ : dirname( __FILE__ );
		deactivate_plugins( plugin_basename( dirname( $dirname ) ) . '/featured-custom-post-type-widget.php' );
	}

	function error_notice() {
		$message = __( '<strong>Featured Custom Post Type Widget For Genesis</strong> works only with the Genesis Framework. It has been <strong>deactivated</strong>.', 'featured-custom-post-type-widget-for-genesis' );
		printf( '<div class="error"><p>%s</p></div>', wp_kses_post( $message ) );
	}

	function register() {

		if ( function_exists( 'is_customize_preview' ) && is_customize_preview() && ! function_exists( 'genesis' ) ) {
			return;
		}
		register_widget( 'Genesis_Featured_Custom_Post_Type' );

	}

	/**
	 * Set up text domain for translations
	 *
	 * @since 2.0.0
	 */
	function load_textdomain() {
		load_plugin_textdomain( 'featured-custom-post-type-widget-for-genesis', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Enqueues the small bit of Javascript which will handle the Ajax
	 * callback to correctly populate the custom term dropdown.
	 */
	function enqueue_admin_scripts() {
		$screen = get_current_screen()->id;
		if ( in_array( $screen, array( 'widgets', 'customize' ) ) ) {
			wp_enqueue_script( 'tax-term-ajax-script', plugins_url( '/js/ajax_handler.js', __FILE__ ), array( 'jquery' ) );
			wp_localize_script( 'tax-term-ajax-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		}
	}

}
