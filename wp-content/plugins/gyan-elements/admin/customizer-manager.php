<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SWM_Customizer_Manager {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu_subpage' ) );
		add_action( 'admin_init', array( $this, 'theme_options_setting' ) );
	}

	public function add_menu_subpage() {
		add_submenu_page( 'swm-theme-panel', esc_html__('Customizer Manager','gyan-elements'), esc_html__('Customizer Manager','gyan-elements'), 'edit_theme_options', 'swm-customizer-manager', array( $this, 'gyan_customizer_manager_callback' ),3 );
	}

	public function gyan_customizer_manager_callback(){
		?>
		<div id="gyan-customizer-manager-admin-page" class="wrap">
			<h1 class="wp-heading-inline"><?php echo esc_html__('Customizer Manager','gyan-elements'); ?></h1>

			<div class="nav-tab-wrapper">
				<a class='nav-tab nav-tab-active' href='?page=swm-customizer-manager'><?php echo esc_html__('Customizer Manager','gyan-elements'); ?></a>
				<?php if ( get_option('swm_enable_import_export_options',true) ) { ?>
					<a class='nav-tab' href='?page=swm-import-customizer-settings'><?php echo esc_html__('Import Options','gyan-elements'); ?></a>
					<a class='nav-tab' href='?page=swm-export-customizer-settings'><?php echo esc_html__('Export Options','gyan-elements'); ?></a>
					<a class='nav-tab' href='?page=swm-reset-customizer-settings'><?php echo esc_html__('Reset Options','gyan-elements'); ?></a>
				<?php } ?>
				<a class='nav-tab' href='customize.php' target="_blank"><?php echo esc_html__('Customizer','gyan-elements'); ?> <span class="dashicons dashicons-external"></span></a>
			</div>

			<p><?php echo esc_html__('Enable/Disable Customizer Options Panel. You can increase customizer load speed by disabling sections ( like Fonts, Social Media, etc. which requires one time settings ).','gyan-elements'); ?></p>

			<div class="gyan-check-uncheck">
				<a href="#" class="gyan-customizer-check-all"><?php esc_html_e( 'Check all', 'gyan-elements' ); ?></a> | <a href="#" class="gyan-customizer-uncheck-all"><?php esc_html_e( 'Uncheck all', 'gyan-elements' ); ?></a>
			</div>

			<form action="options.php" method="post">
				<div class="swm-customizer-manager-table"><?php
				settings_errors();
				settings_fields('customizer_manager_section');
				do_settings_sections('customizer_manager_options');
				submit_button();
				?>
				</div>
			</form>
		</div><?php
	}

	// theme options settings page
	public function theme_options_setting(){

		// this code basically provides an area where you can register your fields
		add_settings_section('customizer_manager_section', '', '', 'customizer_manager_options');

		register_setting('customizer_manager_section','customizer_theme_panel');

		$gyan_customizer_all_options = array(
			'general'            =>	'1',
			'layout'             =>	'1',
			'styling'            =>	'1',
			'top-bar'            =>	'1',
			'header'             =>	'1',
			'sub-header'         =>	'1',
			'sidebar'            =>	'1',
			'footer'             =>	'1',
			'fonts'              =>	'1',
			'blog'               =>	'1',
			'page'               =>	'1',
			'portfolio'          =>	'1',
			'social-media-icons' => '1',
		);

		foreach ($gyan_customizer_all_options as $options => $status) {

			$settings_slug = str_replace('-', '_', $options);
			$settings_title = __(ucwords( str_replace('-', ' ', $options) ), 'gyan-elements');

			add_settings_field( $settings_slug, $settings_title, array( $this, 'get_customizer_options_html' ),'customizer_manager_options', 'customizer_manager_section',['customizer_field' => $settings_slug] );

		}

	}

	public function get_customizer_options_html($data) {
		$customizer_field = $data['customizer_field'];
		$options          = 'customizer_theme_panel';
		$get_option       = get_option( $options );
		$checked          = isset( $get_option[ $customizer_field ] ) && 1 == $get_option[ $customizer_field ]  ? 'checked' : '';

		$gyan_checkbox_current_status = 0;
		if ( $get_option === false ) {
		    // nothing is set, so apply the default here
		    $gyan_checkbox_current_status = 1;
		}
		else if( is_array( $get_option ) && isset( $get_option[$customizer_field] ) ) {
		    // gyan_checkbox_current_status is checked
		    $gyan_checkbox_current_status = $get_option[$customizer_field];
		}

		echo '<input class="gyan-customizer-editor-checkbox" type="checkbox" id="'. $customizer_field .'" name="customizer_theme_panel[' . $customizer_field . ']' . '" value="1" '. checked( $gyan_checkbox_current_status, 1, false ).'>
				';
	}


}

new SWM_Customizer_Manager();