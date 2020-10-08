<?php
/**
 * The template to display the featured image in the single post
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0
 */

if ( false && get_query_var('fsdriving_header_image')=='' && is_singular() && has_post_thumbnail() && in_array(get_post_type(), array('post', 'page')) )  {
	$fsdriving_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
	if (!empty($fsdriving_src[0])) {
		fsdriving_sc_layouts_showed('featured', true);
		?><div class="sc_layouts_featured with_image <?php echo esc_attr(fsdriving_add_inline_style('background-image:url('.esc_url($fsdriving_src[0]).');')); ?>"></div><?php
	}
}
?>