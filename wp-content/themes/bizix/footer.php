		<div class="clear"></div>
	</div> <!-- .swm-main-container -->
<?php if ( swm_customizer_metabox_onoff('swm_widget_footer_on','swm_meta_widget_footer_on','on','default') == 'on' || swm_customizer_metabox_onoff('swm_contact_footer_on','swm_meta_contact_footer_on','off','default') == 'on' || swm_customizer_metabox_onoff('swm_small_footer_on','swm_meta_small_footer_on','on','default') == 'on' ) { ?>
	<div class="swm-main-container">

		<footer class="footer swm-css-transition" id="footer">

			<?php if ( swm_customizer_metabox_onoff('swm_widget_footer_on','swm_meta_widget_footer_on','on','default') == 'on' ) { ?>

				<div class="swm-container">
					<?php swm_display_footer_column(); ?>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>

			<?php } ?>

			<?php
			if ( swm_customizer_metabox_onoff('swm_contact_footer_on','swm_meta_contact_footer_on','off','default') == 'on' ) {

				$swm_cf_call = swm_get_option('swm_cf_call','+1 (888) 456 7890');
				$swm_cf_email = swm_get_option('swm_cf_email','info@example.com');
				$swm_cf_address = swm_get_option('swm_cf_address', '65 St. Road, NY USA');
				$swm_s_footer_s_icons_on = swm_get_option('swm_s_footer_s_icons_on','on');
				?>

				<div class="swm_contact_footer">
					<div class="swm-container">
						<div class="swm_contact_footer_holder swm-row">

							<?php if ( $swm_cf_email != '') { ?>
								<div class="swm-column swm-column<?php echo intval(swm_get_option('swm_cf_column','3')); ?> swm-cf-column">
									<span class="swm_cf_icon"><i class="swm-ficon swm-fi-envelope"></i></span>
									<span class="swm_cf_email swm-cf-title swm-heading-text"><a href="mailto:<?php
									echo antispambot($swm_cf_email,1)

									?>"><?php echo esc_html($swm_cf_email); ?></a></span>
									<span class="swm-cf-subtitle"><?php echo esc_html(swm_get_option('swm_cf_email_s_title','Drop Us a Line')); ?></span>
								</div>
							<?php } ?>

							<?php if ( $swm_cf_call != '') { ?>
								<div class="swm-column swm-column<?php echo intval(swm_get_option('swm_cf_column','3')); ?> swm-cf-column swm-cf-m-column">
									<span class="swm_cf_icon"><i class="swm-ficon swm-fi-phone-call"></i></span>
									<span class="swm_cf_call swm-cf-title swm-heading-text"><?php echo esc_html($swm_cf_call); ?></span>
									<span class="swm-cf-subtitle"><?php echo esc_html(swm_get_option('swm_cf_call_s_title','Call Us Now')); ?></span>
								</div>
							<?php } ?>

							<?php if ( $swm_cf_address != '') { ?>
								<div class="swm-column swm-column<?php echo intval(swm_get_option('swm_cf_column','3')); ?> swm-cf-column">
									<span class="swm_cf_icon"><i class="swm-ficon swm-fi-placeholder"></i></span>
									<span class="swm_cf_address swm-cf-title swm-heading-text"><?php echo esc_html($swm_cf_address); ?></span>
									<span class="swm-cf-subtitle"><?php echo esc_html(swm_get_option('swm_cf_address_s_title','Get Direction')); ?></span>
								</div>
							<?php } ?>

							<div class="clear"></div>
						</div>
					</div>
				</div>

			<?php } ?>

			<?php
			if ( swm_customizer_metabox_onoff('swm_small_footer_on','swm_meta_small_footer_on','on','default') == 'on' ) {

				$swm_small_footer_copyright = swm_get_option( 'swm_small_footer_copyright', 'Copyright 2020 Bizix, All rights reserved.' );
				?>

				<div class="swm-container">
					<div class="swm-small-footer">
						<div><span><?php echo wp_kses($swm_small_footer_copyright,swm_kses_allowed_textarea()); ?></span><?php echo swm_footer_menu(); ?></div>
					</div>
				</div>

			<?php } ?>

		</footer>

	</div>

	<?php } ?>

		</div><!-- #wrap -->
	</div><!-- #outer-wrap -->

	<?php
	if ( swm_get_option( 'swm_bottom_go_top_scroll_btn_on','off' ) == 'on') { ?>
		<div class="swm-go-top-scroll-btn-wrap"><a id="swm-go-top-scroll-btn"><i class="fas fa-angle-up"></i></a></div> <?php
	}

	if ( is_single() && comments_open() ) { wp_enqueue_script( 'comment-reply' ); }
	wp_footer();
	?>
</div>  <!-- end #swm-page -->
</body>
</html>