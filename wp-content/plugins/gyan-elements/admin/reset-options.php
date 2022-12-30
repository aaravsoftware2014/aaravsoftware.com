<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SWM_Reset_Customizer_Options {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu_subpage' ) );
	}

	public function add_menu_subpage() {
		add_submenu_page( 'swm-theme-panel', esc_html__('Customizer Reset','gyan-elements'), esc_html__('Reset Options','gyan-elements'), 'edit_theme_options', 'swm-reset-customizer-settings', array( $this, 'gyan_customizer_reset_callback' ),6 );
	}

	public function gyan_customizer_reset_callback() { ?>
		<div class="wrap">
			<h1 class="wp-heading-inline"><?php echo esc_html__('Reset Customizer Options','gyan-elements'); ?></h1>
			<div class="nav-tab-wrapper">
				<?php if ( get_option('swm_enable_customizer_manager',true) ) { ?>
					<a class='nav-tab' href='?page=swm-customizer-manager'><?php echo esc_html__('Customizer Manager','gyan-elements'); ?></a>
				<?php } ?>
				<?php if ( get_option('swm_enable_import_export_options',true) ) { ?>
					<a class='nav-tab' href='?page=swm-import-customizer-settings'><?php echo esc_html__('Import Options','gyan-elements'); ?></a>
					<a class='nav-tab' href='?page=swm-export-customizer-settings'><?php echo esc_html__('Export Options','gyan-elements'); ?></a>
					<a class='nav-tab nav-tab-active' href='?page=swm-reset-customizer-settings'><?php echo esc_html__('Reset Options','gyan-elements'); ?></a>
				<?php } ?>
				<a class='nav-tab' href='customize.php' target="_blank"><?php echo esc_html__('Customizer','gyan-elements'); ?> <span class="dashicons dashicons-external"></span></a>
			</div>
			<div class="gyan-admin-container">
				<div class="gyan-admin-content">
					<div class="box-import-export-reset export-p">

							<?php
								if ( isset( $_POST['reset'] ) && check_admin_referer( 'gyan-customizer-options-reset' ) ) {

									$gyan_customizer_options_list = gyan_customizer_options_list();

									foreach (  $gyan_customizer_options_list as $key => $value ) {
										delete_option( $key );
									}

									echo '<div class="import-export-success"><p>'.esc_html__('All Customizer settings were successfully reset.','gyan-elements').'</p></div>';

								}
							?>
							<form method="post">
								<?php wp_nonce_field( 'gyan-customizer-options-reset' ); ?>
								<p><?php echo esc_html__('When you click the button below WordPress will reset your Customizer settings as if it were a brand new installation.','gyan-elements'); ?></p>
								<p><span class="red-col bold"><?php echo esc_html__('Be extremely careful using this option','gyan-elements'); ?></span> <?php echo esc_html__('as there is no way to revert this option once it has been made unless you previously exported your settings to use as a backup.','gyan-elements'); ?></p>
								<p class="submit">
									<input type="submit" id="gyan-customizer-options-reset-submit" class="button button-primary" value="Reset Customizer Settings">
									<input type="hidden" name="reset" value="reset">
								</p>
							</form>

					</div>
				</div>
			</div>
		</div>
	<?php }

}

new SWM_Reset_Customizer_Options();