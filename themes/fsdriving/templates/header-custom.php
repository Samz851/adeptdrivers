<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0.06
 */

$fsdriving_header_css = $fsdriving_header_image = '';
$fsdriving_header_video = fsdriving_get_header_video();
if (true || empty($fsdriving_header_video)) {
	$fsdriving_header_image = get_header_image();
	if (fsdriving_is_on(fsdriving_get_theme_option('header_image_override')) && apply_filters('fsdriving_filter_allow_override_header_image', true)) {
		if (is_category()) {
			if (($fsdriving_cat_img = fsdriving_get_category_image()) != '')
				$fsdriving_header_image = $fsdriving_cat_img;
		} else if (is_singular() || fsdriving_storage_isset('blog_archive')) {
			if (has_post_thumbnail()) {
				$fsdriving_header_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				if (is_array($fsdriving_header_image)) $fsdriving_header_image = $fsdriving_header_image[0];
			} else
				$fsdriving_header_image = '';
		}
	}
}

$fsdriving_header_id = str_replace('header-custom-', '', fsdriving_get_theme_option("header_style"));

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($fsdriving_header_id);
						echo !empty($fsdriving_header_image) || !empty($fsdriving_header_video) ? ' with_bg_image' : ' without_bg_image';
						if ($fsdriving_header_video!='') echo ' with_bg_video';
						if ($fsdriving_header_image!='') echo ' '.esc_attr(fsdriving_add_inline_style('background-image: url('.esc_url($fsdriving_header_image).');'));
						if (is_single() && has_post_thumbnail()) echo ' with_featured_image';
						if (fsdriving_is_on(fsdriving_get_theme_option('header_fullheight'))) echo ' header_fullheight trx-stretch-height';
						?> scheme_<?php echo esc_attr(fsdriving_is_inherit(fsdriving_get_theme_option('header_scheme')) 
														? fsdriving_get_theme_option('color_scheme') 
														: fsdriving_get_theme_option('header_scheme'));
						?>"><?php

	// Background video
	if (!empty($fsdriving_header_video)) {
		get_template_part( 'templates/header-video' );
	}
		
	// Custom header's layout
	do_action('fsdriving_action_show_layout', $fsdriving_header_id);

	// Header widgets area
	get_template_part( 'templates/header-widgets' );


		
?></header>