<?php
final class Gyan_Elementor_Elements {

	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
	const MINIMUM_PHP_VERSION = '5.6';

	private static $_instance = null;

	/* Ensures only one instance of the class is loaded or can be loaded. */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
		add_action('admin_init', [ $this, 'redirection' ] );
		add_action( 'elementor/init', __CLASS__ . '::load_admin', 0 );
	}

	public static function load_admin() {
		add_action( 'elementor/editor/after_enqueue_styles', __CLASS__ . '::gyan_admin_enqueue_scripts' );
	}

	public static function gyan_admin_enqueue_scripts( $hook ) {
		$gyan_min_css = get_option('swm_enable_minify_gyan_elements_css',true) ? '-min.css' : '.css';


		wp_enqueue_style( 'gyan-elementor-editor-style', GYAN_PLUGIN_URL .'addons/css/gyan-elementor-editor-style' . $gyan_min_css, [], GYAN_PLUGIN_VERSION );
	}

	public function redirection() {
		global $gyan_addons_list;
		add_option( 'gyan_addons', $gyan_addons_list);
	}

	/* Warning when the site doesn't have a minimum required Elementor version. */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'gyan-elements' ),
			'<strong>' . esc_html__( 'Gyan Elements for Elementor', 'gyan-elements' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'gyan-elements' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/* Warning when the site doesn't have a minimum required PHP version. */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'gyan-elements' ),
			'<strong>' . esc_html__( 'Gyan Elements for Elementor', 'gyan-elements' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'gyan-elements' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/* Initialize the plugin */
	public function init() {

		require_once (GYAN_ADDONS_DIR . 'helpers.php');
		require_once (GYAN_PLUGIN_DIR . '/class/controls.php');

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Register Widget Category
		add_action( 'elementor/elements/categories_registered', [ $this, 'widget_category' ] );

		// Register Widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

		// Enqueue Widget Styles
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'widget_styles' ] );

		// Register Widget Scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
	}

	public function widget_styles() {
		wp_enqueue_style( 'owl-carousel', GYAN_PLUGIN_URL .'assets/css/owl.carousel.min.css', '', '2.3.4' );
		wp_enqueue_style( 'magnific-popup', GYAN_PLUGIN_URL .'assets/css/magnific-popup.min.css', '', '1.1.0' );

		$gyan_min_css = get_option('swm_enable_minify_gyan_elements_css',true) ? '-min.css' : '.css';

		wp_enqueue_style( 'gyan-global', GYAN_PLUGIN_URL .'addons/css/gyan-global'.$gyan_min_css, '', GYAN_PLUGIN_VERSION );
		wp_enqueue_style( 'gyan-grid', GYAN_PLUGIN_URL .'addons/css/gyan-grid'.$gyan_min_css, '', GYAN_PLUGIN_VERSION );
		wp_enqueue_style( 'gyan-basic-addons', GYAN_PLUGIN_URL .'addons/css/gyan-basic-addons'.$gyan_min_css, '', GYAN_PLUGIN_VERSION );
		wp_enqueue_style( 'gyan-advanced-addons', GYAN_PLUGIN_URL .'addons/css/gyan-advanced-addons'.$gyan_min_css, '', GYAN_PLUGIN_VERSION );

		if ( get_option('swm_enable_portfolio',true) ) {
			wp_enqueue_style( 'gyan-portfolio', GYAN_PLUGIN_URL .'addons/css/gyan-portfolio'.$gyan_min_css, '', GYAN_PLUGIN_VERSION );
		}

	}

	public function widget_scripts() {
		$ajax_url = admin_url('admin-ajax.php');

		wp_register_script( 'imagesloaded', GYAN_PLUGIN_URL .'addons/js/imagesloaded.pkgd.min.js', [], '4.1.4', true );
		wp_register_script( 'typed', GYAN_PLUGIN_URL .'addons/js/typed.min.js', ['jquery'], GYAN_PLUGIN_VERSION, true );
		wp_register_script( 'jquery-owl', GYAN_PLUGIN_URL .'assets/js/owl.carousel.min.js', ['jquery'], '2.3.4', true );
		wp_register_script( 'magnific-popup', GYAN_PLUGIN_URL .'addons/js/jquery.magnific-popup.min.js', ['jquery'], '1.1.0', true );
		wp_register_script( 'countdown', GYAN_PLUGIN_URL .'addons/js/jquery.countdown.min.js', ['jquery'], '2.2.0', true );
		wp_register_script( 'easypiechart', GYAN_PLUGIN_URL .'addons/js/jquery.easypiechart.min.js', ['jquery'], '2.1.7', true );
		wp_register_script( 'mailchimp', GYAN_PLUGIN_URL .'addons/js/jquery.ajaxchimp.min.js', ['jquery'], GYAN_PLUGIN_VERSION, true );
		wp_register_script( 'isotope', GYAN_PLUGIN_URL .'addons/js/isotope.min.js', ['jquery', 'imagesloaded', 'magnific-popup'], '3.0.6', true );
		wp_register_script( 'gyan-element-resize', GYAN_PLUGIN_URL .'addons/js/jquery_resize.min.js', ['jquery'], '0.5.3', true );

		$gyan_min_js = get_option('swm_enable_minify_gyan_elements_js',true) ? '-min.js' : '.js';

		wp_register_script( 'gyan-widgets', GYAN_PLUGIN_URL .'addons/js/gyan-widgets' . $gyan_min_js, ['jquery'], GYAN_PLUGIN_VERSION, true );

		wp_register_script( 'limarquee', GYAN_PLUGIN_URL .'addons/js/limarquee.min.js', ['jquery'], GYAN_PLUGIN_VERSION, true );
		wp_register_script( 'gyan-video-subscribe', 'https://apis.google.com/js/platform.js', [ 'jquery' ], GYAN_PLUGIN_VERSION, true );

		$apikey = get_option( 'gyan_map_apikey', true );
		if ( $apikey ) {
			wp_register_script( 'gyan-google-maps-api', 'https://maps.google.com/maps/api/js?key='. $apikey, [], GYAN_PLUGIN_VERSION, true );
			wp_register_script( 'gyan-google-maps-cluster', 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js', [ 'jquery' ], GYAN_PLUGIN_VERSION, true );
		}

		wp_localize_script( 'gyan-widgets', 'gyanAjax', ['ajaxURL' => $ajax_url] );

	}

	/* Create widget category */
	public function widget_category( $elements_manager ) {
		$elements_manager->add_category(
			'gyan-basic-addons',
			[
				'title' => esc_html__( 'Gyan Basic Addons', 'gyan-elements' ),
				'icon' => 'fa fa-plug',
			]
		);
		$elements_manager->add_category(
			'gyan-advanced-addons',
			[
				'title' => esc_html__( 'Gyan Advaced Addons', 'gyan-elements' ),
				'icon' => 'fa fa-plug',
			]
		);
	}

	/* Register widgets */
	public function register_widgets( $widgets_manager ) {
		$active_widgets = get_option( 'gyan_addons' );

		if ( is_array($active_widgets) ) {
			foreach ($active_widgets as $cat => $widgets) {
				foreach ($widgets as $widget => $status) {
					$file = GYAN_ADDONS_DIR . $cat . '/gyan-' . $widget . '.php';
					if (1 == $status && file_exists( $file )) {
						require_once( $file );
						$widget = str_replace(' ', '_', ucwords( str_replace('-', ' ', $widget) ) );
						$widget = 'Gyan_'.$widget;
						$widgets_manager->register_widget_type( new $widget() );
					}
				}
			}
		}
	}

}

Gyan_Elementor_Elements::instance();