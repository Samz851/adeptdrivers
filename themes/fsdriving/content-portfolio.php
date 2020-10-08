<?php
/**
 * The Portfolio template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0
 */

$fsdriving_blog_style = explode('_', fsdriving_get_theme_option('blog_style'));
$fsdriving_columns = empty($fsdriving_blog_style[1]) ? 2 : max(2, $fsdriving_blog_style[1]);
$fsdriving_post_format = get_post_format();
$fsdriving_post_format = empty($fsdriving_post_format) ? 'standard' : str_replace('post-format-', '', $fsdriving_post_format);
$fsdriving_animation = fsdriving_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($fsdriving_columns).' post_format_'.esc_attr($fsdriving_post_format) ); ?>
	<?php echo (!fsdriving_is_off($fsdriving_animation) ? ' data-animation="'.esc_attr(fsdriving_get_animation_classes($fsdriving_animation)).'"' : ''); ?>
	>

	<?php
	$fsdriving_image_hover = fsdriving_get_theme_option('image_hover');
	// Featured image
	fsdriving_show_post_featured(array(
		'thumb_size' => fsdriving_get_thumb_size(strpos(fsdriving_get_theme_option('body_style'), 'full')!==false || $fsdriving_columns < 4 ? 'masonry-big' : 'masonry'),
		'show_no_image' => true,
		'class' => $fsdriving_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $fsdriving_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>