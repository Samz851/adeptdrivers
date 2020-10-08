<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0
 */

// Header sidebar
$fsdriving_header_name = fsdriving_get_theme_option('header_widgets');
$fsdriving_header_present = !fsdriving_is_off($fsdriving_header_name) && is_active_sidebar($fsdriving_header_name);
if ($fsdriving_header_present) { 
	fsdriving_storage_set('current_sidebar', 'header');
	$fsdriving_header_wide = fsdriving_get_theme_option('header_wide');
	ob_start();
    if ( is_active_sidebar( $fsdriving_header_name ) ) {
        dynamic_sidebar( $fsdriving_header_name );
    }
	$fsdriving_widgets_output = ob_get_contents();
	ob_end_clean();
	if (trim(strip_tags($fsdriving_widgets_output)) != '') {
		$fsdriving_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $fsdriving_widgets_output);
		$fsdriving_need_columns = strpos($fsdriving_widgets_output, 'columns_wrap')===false;
		if ($fsdriving_need_columns) {
			$fsdriving_columns = max(0, (int) fsdriving_get_theme_option('header_columns'));
			if ($fsdriving_columns == 0) $fsdriving_columns = min(6, max(1, substr_count($fsdriving_widgets_output, '<aside ')));
			if ($fsdriving_columns > 1)
				$fsdriving_widgets_output = preg_replace("/class=\"widget /", "class=\"column-1_".esc_attr($fsdriving_columns).' widget ', $fsdriving_widgets_output);
			else
				$fsdriving_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($fsdriving_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$fsdriving_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($fsdriving_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'fsdriving_action_before_sidebar' );
				fsdriving_show_layout($fsdriving_widgets_output);
				do_action( 'fsdriving_action_after_sidebar' );
				if ($fsdriving_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$fsdriving_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>