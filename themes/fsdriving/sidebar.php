<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0
 */

$fsdriving_sidebar_position = fsdriving_get_theme_option('sidebar_position');
if (fsdriving_sidebar_present()) {
	ob_start();
	$fsdriving_sidebar_name = fsdriving_get_theme_option('sidebar_widgets');
	fsdriving_storage_set('current_sidebar', 'sidebar');
    if ( is_active_sidebar( $fsdriving_sidebar_name ) ) {
        dynamic_sidebar( $fsdriving_sidebar_name );
    }
	$fsdriving_out = trim(ob_get_contents());
	ob_end_clean();
	if (trim(strip_tags($fsdriving_out)) != '') {
		?>
		<div class="sidebar <?php echo esc_attr($fsdriving_sidebar_position); ?> widget_area<?php if (!fsdriving_is_inherit(fsdriving_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(fsdriving_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'fsdriving_action_before_sidebar' );
				fsdriving_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $fsdriving_out));
				do_action( 'fsdriving_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>