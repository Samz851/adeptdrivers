<?php
/**
 * The template 'Style 2' to displaying related posts
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0
 */

$fsdriving_link = get_permalink();
$fsdriving_post_format = get_post_format();
$fsdriving_post_format = empty($fsdriving_post_format) ? 'standard' : str_replace('post-format-', '', $fsdriving_post_format);
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_2 post_format_'.esc_attr($fsdriving_post_format) ); ?>><?php
	fsdriving_show_post_featured(array(
		'thumb_size' => fsdriving_get_thumb_size( 'big' ),
		'show_no_image' => true,
		'singular' => false
		)
	);
	?><div class="post_header entry-header"><?php
		if ( in_array(get_post_type(), array( 'post', 'attachment' ) ) ) {
			?><span class="post_date"><a href="<?php echo esc_url($fsdriving_link); ?>"><?php echo fsdriving_get_date(); ?></a></span><?php
		}
		?>
		<h6 class="post_title entry-title"><a href="<?php echo esc_url($fsdriving_link); ?>"><?php echo the_title(); ?></a></h6>
	</div>
</div>