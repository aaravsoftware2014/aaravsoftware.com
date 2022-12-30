<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

ob_start();

add_action( 'admin_menu', 'add_menu_subpage' );

function add_menu_subpage() {
	add_submenu_page( 'swm-theme-panel', esc_html__('Customizer Export','gyan-elements'), esc_html__('Export Options','gyan-elements'), 'edit_theme_options', 'swm-export-customizer-settings', 'gyan_customizer_export_callback',5 );
}

function gyan_customizer_export_callback() {
	if ( ! isset( $_POST['export'] ) ) {
	?>
	<div class="wrap">
		<h1 class="wp-heading-inline"><?php echo esc_html__('Export Customizer Options','gyan-elements'); ?></h1>
		<div class="nav-tab-wrapper">
			<?php if ( get_option('swm_enable_customizer_manager',true) ) { ?>
				<a class='nav-tab' href='?page=swm-customizer-manager'><?php echo esc_html__('Customizer Manager','gyan-elements'); ?></a>
			<?php } ?>
			<?php if ( get_option('swm_enable_import_export_options',true) ) { ?>
				<a class='nav-tab' href='?page=swm-import-customizer-settings'><?php echo esc_html__('Import Options','gyan-elements'); ?></a>
				<a class='nav-tab nav-tab-active' href='?page=swm-export-customizer-settings'><?php echo esc_html__('Export Options','gyan-elements'); ?></a>
				<a class='nav-tab' href='?page=swm-reset-customizer-settings'><?php echo esc_html__('Reset Options','gyan-elements'); ?></a>
			<?php } ?>
			<a class='nav-tab' href='customize.php' target="_blank"><?php echo esc_html__('Customizer','gyan-elements'); ?> <span class="dashicons dashicons-external"></span></a>
		</div>
		<div class="gyan-admin-container">
			<div class="gyan-admin-content">
				<div class="box-import-export-reset export-p">
					<form method="post">
						<?php wp_nonce_field( 'gyan-customizer-export' );

						echo '<p>'.esc_html__('When you click the button below WordPress will create an JSON file for you to save to your computer.','gyan-elements').'</p>';
						echo '<p>'.esc_html__('This format, which we call WordPress Customizer Settings, will contain your customizer settings for this theme.','gyan-elements').'</p>';

						echo '<p>'.esc_html__('Once you have saved the download file, you can use the Customizer Import function to import previously exported settings.','gyan-elements').'</p>';
						?>
						<p class="submit"><input type="submit" name="export" class="button button-primary" value="Export Customizer Settings"></p>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
	} elseif ( check_admin_referer( 'gyan-customizer-export' ) ) {

		$gyan_export_file_blogname  = strtolower( str_replace(' ', '', get_option( 'blogname' ) ) );
		$gyan_export_file_date      = date( 'm-d-Y' );
		$gyan_export_file_json_name = $gyan_export_file_blogname . '-customizer-' . $gyan_export_file_date;
		$gyan_export_file_options   = gyan_customizer_options_list();

		foreach ( $gyan_export_file_options as $key => $value ) {
			$gyan_export_file_get_value = maybe_unserialize( get_option( $key ) );

			if ( $gyan_export_file_get_value == '' ) {
				$gyan_export_file_get_value = $value;
			}

			$data[$key] = $gyan_export_file_get_value;
		}

		$gyan_export_json_file = json_encode( $data );

		ob_clean();

		echo $gyan_export_json_file;

		header( 'Content-Type: text/json; charset=' . get_option( 'blog_charset' ) );
		header( 'Content-Disposition: attachment; filename=' . $gyan_export_file_json_name . '.json' );

		exit();

	}
}