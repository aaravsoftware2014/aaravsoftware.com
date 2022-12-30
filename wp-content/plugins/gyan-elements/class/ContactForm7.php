<?php

class ContactForm7 {

	public function __construct() {

		if ( ! defined( 'CF7MSM_PLUGIN' ) && function_exists( 'wpcf7_enqueue_scripts' ) && apply_filters( 'swm_conditional_wpcf7_scripts', true ) ) {

			// Remove CSS Completely - theme adds styles
			add_filter( 'wpcf7_load_css', '__return_false' );

			// Remove JS
			add_filter( 'wpcf7_load_js', '__return_false' );

			// Conditionally load JS
			add_action( 'wpcf7_contact_form', array( $this, 'enqueue_scripts' ), 1 );

			// Custom CSS
			add_action('wpcf7_enqueue_styles', array(&$this, 'gyan_wpcf7_enqueue_styles') );

		}

	}

	public function enqueue_scripts() {
		wpcf7_enqueue_scripts();
		wpcf7_enqueue_styles();
	}

	public function gyan_wpcf7_enqueue_styles() {
		$gyan_min_css = get_option('swm_enable_minify_gyan_elements_css',true) ? '-min.css' : '.css';
		wp_enqueue_style( 'gyan-cf7-style', GYAN_PLUGIN_URL . 'addons/css/gyan-contact-form-7' . $gyan_min_css, NULL, GYAN_PLUGIN_VERSION, 'all' );
	}

}
new ContactForm7();