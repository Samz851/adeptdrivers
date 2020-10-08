<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0.10
 */

// Footer sidebar
$fsdriving_footer_name = fsdriving_get_theme_option('footer_widgets');
$fsdriving_footer_present = !fsdriving_is_off($fsdriving_footer_name) && is_active_sidebar($fsdriving_footer_name);
if ($fsdriving_footer_present) { 
	fsdriving_storage_set('current_sidebar', 'footer');
	$fsdriving_footer_wide = fsdriving_get_theme_option('footer_wide');
	ob_start();
    if ( is_active_sidebar( $fsdriving_footer_name ) ) {
        dynamic_sidebar( $fsdriving_footer_name );
    }
	$fsdriving_out = trim(ob_get_contents());
	ob_end_clean();
	if (trim(strip_tags($fsdriving_out)) != '') {
		$fsdriving_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $fsdriving_out);
		$fsdriving_need_columns = true;
		if ($fsdriving_need_columns) {
			$fsdriving_columns = max(0, (int) fsdriving_get_theme_option('footer_columns'));
			if ($fsdriving_columns == 0) $fsdriving_columns = min(6, max(1, substr_count($fsdriving_out, '<aside ')));
			if ($fsdriving_columns > 1)
				$fsdriving_out = preg_replace("/class=\"widget /", "class=\"column-1_".esc_attr($fsdriving_columns).' widget ', $fsdriving_out);
			else
				$fsdriving_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($fsdriving_footer_wide) ? ' footer_fullwidth' : ''; ?>">
			<div class="footer_widgets_inner widget_area_inner">
				<?php 
				if (!$fsdriving_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($fsdriving_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'fsdriving_action_before_sidebar' );
				fsdriving_show_layout($fsdriving_out);
				do_action( 'fsdriving_action_after_sidebar' );
				if ($fsdriving_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$fsdriving_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>