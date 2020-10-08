<?php
/**
 * The template to display posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0
 */

$fsdriving_post_id    = get_the_ID();
$fsdriving_post_date  = fsdriving_get_date();
$fsdriving_post_title = get_the_title();
$fsdriving_post_link  = get_permalink();
$fsdriving_post_author_id   = get_the_author_meta('ID');
$fsdriving_post_author_name = get_the_author_meta('display_name');
$fsdriving_post_author_url  = get_author_posts_url($fsdriving_post_author_id, '');

$fsdriving_args = get_query_var('fsdriving_args_widgets_posts');
$fsdriving_show_date = isset($fsdriving_args['show_date']) ? (int) $fsdriving_args['show_date'] : 1;
$fsdriving_show_image = isset($fsdriving_args['show_image']) ? (int) $fsdriving_args['show_image'] : 1;
$fsdriving_show_author = isset($fsdriving_args['show_author']) ? (int) $fsdriving_args['show_author'] : 1;
$fsdriving_show_counters = isset($fsdriving_args['show_counters']) ? (int) $fsdriving_args['show_counters'] : 1;
$fsdriving_show_categories = isset($fsdriving_args['show_categories']) ? (int) $fsdriving_args['show_categories'] : 1;

$fsdriving_output = fsdriving_storage_get('fsdriving_output_widgets_posts');

$fsdriving_post_counters_output = '';
if ( $fsdriving_show_counters ) {
	$fsdriving_post_counters_output = '<span class="post_info_item post_info_counters">'
								. fsdriving_get_post_counters('comments')
							. '</span>';
}


$fsdriving_output .= '<article class="post_item with_thumb">';

if ($fsdriving_show_image) {
	$fsdriving_post_thumb = get_the_post_thumbnail($fsdriving_post_id, fsdriving_get_thumb_size('tiny'), array(
		'alt' => get_the_title()
	));
	if ($fsdriving_post_thumb) $fsdriving_output .= '<div class="post_thumb">' . ($fsdriving_post_link ? '<a href="' . esc_url($fsdriving_post_link) . '">' : '') . ($fsdriving_post_thumb) . ($fsdriving_post_link ? '</a>' : '') . '</div>';
}

$fsdriving_output .= '<div class="post_content">'
			. ($fsdriving_show_categories 
					? '<div class="post_categories">'
						. fsdriving_get_post_categories()
						. $fsdriving_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($fsdriving_post_link ? '<a href="' . esc_url($fsdriving_post_link) . '">' : '') . ($fsdriving_post_title) . ($fsdriving_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('fsdriving_filter_get_post_info', 
								'<div class="post_info">'
									. ($fsdriving_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($fsdriving_post_link ? '<a href="' . esc_url($fsdriving_post_link) . '" class="post_info_date">' : '') 
											. esc_html($fsdriving_post_date) 
											. ($fsdriving_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($fsdriving_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'fsdriving') . ' ' 
											. ($fsdriving_post_link ? '<a href="' . esc_url($fsdriving_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($fsdriving_post_author_name) 
											. ($fsdriving_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$fsdriving_show_categories && $fsdriving_post_counters_output
										? $fsdriving_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
fsdriving_storage_set('fsdriving_output_widgets_posts', $fsdriving_output);
?>