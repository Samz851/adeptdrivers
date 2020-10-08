<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0
 */

$fsdriving_columns = max(1, min(3, count(get_option( 'sticky_posts' ))));
$fsdriving_post_format = get_post_format();
$fsdriving_post_format = empty($fsdriving_post_format) ? 'standard' : str_replace('post-format-', '', $fsdriving_post_format);
$fsdriving_animation = fsdriving_get_theme_option('blog_animation');

?><div class="column-1_<?php echo esc_attr($fsdriving_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_'.esc_attr($fsdriving_post_format) ); ?>
	<?php echo (!fsdriving_is_off($fsdriving_animation) ? ' data-animation="'.esc_attr(fsdriving_get_animation_classes($fsdriving_animation)).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	fsdriving_show_post_featured(array(
		'thumb_size' => fsdriving_get_thumb_size($fsdriving_columns==1 ? 'big' : ($fsdriving_columns==2 ? 'med' : 'avatar'))
	));

	if ( !in_array($fsdriving_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			fsdriving_show_post_meta();
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div>