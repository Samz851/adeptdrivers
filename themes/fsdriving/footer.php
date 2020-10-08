<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0
 */

						// Widgets area inside page content
						fsdriving_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					fsdriving_create_widgets_area('widgets_below_page');

					$fsdriving_body_style = fsdriving_get_theme_option('body_style');
					if ($fsdriving_body_style != 'fullscreen') {
						?></div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$fsdriving_footer_style = fsdriving_get_theme_option("footer_style");
			if (strpos($fsdriving_footer_style, 'footer-custom-')===0) $fsdriving_footer_style = 'footer-custom';
			get_template_part( "templates/{$fsdriving_footer_style}");
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php if (fsdriving_is_on(fsdriving_get_theme_option('debug_mode')) && fsdriving_get_file_dir('images/makeup.jpg')!='') { ?>
		<img src="<?php echo esc_url(fsdriving_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>