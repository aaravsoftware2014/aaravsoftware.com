<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SWM_Import_Customizer_Options {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu_subpage' ) );
	}

	public function add_menu_subpage() {
		add_submenu_page( 'swm-theme-panel', esc_html__('Customizer Import','gyan-elements'), esc_html__('Import Options','gyan-elements'), 'edit_theme_options', 'swm-import-customizer-settings', array( $this, 'gyan_customizer_import_callback' ),4 );
	}

	public function gyan_customizer_import_callback() {
	?>

	<div class="wrap">
		<h1 class="wp-heading-inline"><?php echo esc_html__('Import Customizer Options','gyan-elements'); ?></h1>
		<div class="nav-tab-wrapper">
			<?php if ( get_option('swm_enable_customizer_manager',true) ) { ?>
				<a class='nav-tab' href='?page=swm-customizer-manager'><?php echo esc_html__('Customizer Manager','gyan-elements'); ?></a>
			<?php } ?>
			<?php if ( get_option('swm_enable_import_export_options',true) ) { ?>
				<a class='nav-tab nav-tab-active' href='?page=swm-import-customizer-settings'><?php echo esc_html__('Import Options','gyan-elements'); ?></a>
				<a class='nav-tab' href='?page=swm-export-customizer-settings'><?php echo esc_html__('Export Options','gyan-elements'); ?></a>
				<a class='nav-tab' href='?page=swm-reset-customizer-settings'><?php echo esc_html__('Reset Options','gyan-elements'); ?></a>
			<?php } ?>
			<a class='nav-tab' href='customize.php' target="_blank"><?php echo esc_html__('Customizer','gyan-elements'); ?> <span class="dashicons dashicons-external"></span></a>
		</div>
		<div class="gyan-admin-container">
			<div class="gyan-admin-content">
				<div class="box-import-export-reset">

					<?php
					if ( isset( $_FILES['import'] ) && check_admin_referer( 'gyan-customizer-import' ) ) {
						if ( $_FILES['import']['error'] > 0 ) {
							wp_die( 'An error occured.' );
						} else {
							$gyan_import_file_name = $_FILES['import']['name'];
							$gyan_explode_filename = explode( '.', $gyan_import_file_name );
							$gyan_file_ext  = strtolower( end( $gyan_explode_filename ) );
							$gyan_file_size = $_FILES['import']['size'];
							if ( ( $gyan_file_ext == 'json' ) && ( $gyan_file_size < 500000 ) ) {
								$gyan_encode_options = file_get_contents( $_FILES['import']['tmp_name'] );
								$gyan_import_file_options = json_decode( $gyan_encode_options, true );
								foreach ( $gyan_import_file_options as $key => $value ) {
									update_option( $key, $value );
								}
								echo '<div class="import-export-success"><p><span class="dashicons dashicons-yes"></span>'.esc_html__('All options were restored successfully!','gyan-elements').'</p></div>';
							} else {
								echo '<div class="import-export-error"><p><span class="dashicons dashicons-no-alt"></span>'.esc_html__('Invalid file or file size too big.','gyan-elements').'</p></div>';
							}
						}
					}
					?>
					<form method="post" enctype="multipart/form-data">
						<?php wp_nonce_field( 'gyan-customizer-import' );
						echo '<p class="info_text">' . esc_html__('Click "Choose File" button and choose a JSON file from your computer that you backup before.','gyan-elements') . '</p>';
						?>
						<div class="import-export-input"><input type="file" id="customizer-upload" name="import"></p></div>
						<p class="submit"> <input type="submit" name="submit" id="customizer-submit" class="button" value="Import Customizer Settings" disabled> </p>
					</form>

				</div>
			</div>
		</div>
	</div>
	<?php
	}

}

new SWM_Import_Customizer_Options();