<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0
 */

$fsdriving_args = get_query_var('fsdriving_logo_args');

// Site logo
$fsdriving_logo_image  = fsdriving_get_logo_image(isset($fsdriving_args['type']) ? $fsdriving_args['type'] : '');
$fsdriving_logo_text   = get_bloginfo( 'name' );
$fsdriving_logo_slogan = get_bloginfo( 'description', 'display' );
if ((fsdriving_get_theme_option('header_style') == 'header-default') && (!empty($fsdriving_logo_image) || !empty($fsdriving_logo_text))) {
	?><a class="sc_layouts_logo" href="<?php echo is_front_page() ? '#' : esc_url(home_url('/')); ?>"><?php
		if (!empty($fsdriving_logo_image)) {
			$fsdriving_attr = fsdriving_getimagesize($fsdriving_logo_image);
			echo '<img src="'.esc_url($fsdriving_logo_image).'" alt="'.esc_attr(basename($fsdriving_logo_image)).'"'.(!empty($fsdriving_attr[3]) ? sprintf(' %s', $fsdriving_attr[3]) : '').'>' ;
		} else {
			fsdriving_show_layout(fsdriving_prepare_macros($fsdriving_logo_text), '<span class="logo_text">', '</span>');
			fsdriving_show_layout(fsdriving_prepare_macros($fsdriving_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>