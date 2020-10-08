<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0
 */

$fsdriving_link = get_permalink();
$fsdriving_post_format = get_post_format();
$fsdriving_post_format = empty($fsdriving_post_format) ? 'standard' : str_replace('post-format-', '', $fsdriving_post_format);
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_1 post_format_'.esc_attr($fsdriving_post_format) ); ?>><?php
	$post_info = '<div class="post_header entry-header">'
		.'<div class="post_header-wrapper entry-header">'
		. '<h5 class="post_title entry-title"><a href="' . esc_url($fsdriving_link) . '">' . get_the_title() . '</a></h6>'
		. (in_array(get_post_type(), array('post', 'attachment'))
			? '<span class="post_date"><a href="' . esc_url($fsdriving_link) . '">' . fsdriving_get_date() . '</a></span>'
			: '')
		. '</div>'
		. '</div>';
	if ( has_post_thumbnail() ) {
		fsdriving_show_post_featured(array(
				'thumb_size' => fsdriving_get_thumb_size('big'),
				'show_no_image' => true,
				'singular' => false,
				'post_info' => $post_info
			)
		);
	} else fsdriving_show_layout($post_info);
?></div>