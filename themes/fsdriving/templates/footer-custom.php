<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0.10
 */

$fsdriving_footer_scheme =  fsdriving_is_inherit(fsdriving_get_theme_option('footer_scheme')) ? fsdriving_get_theme_option('color_scheme') : fsdriving_get_theme_option('footer_scheme');
$fsdriving_footer_id = str_replace('footer-custom-', '', fsdriving_get_theme_option("footer_style"));
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr($fsdriving_footer_id); ?> scheme_<?php echo esc_attr($fsdriving_footer_scheme); ?>">
	<?php
    // Custom footer's layout
    do_action('fsdriving_action_show_layout', $fsdriving_footer_id);
	?>
</footer><!-- /.footer_wrap -->
