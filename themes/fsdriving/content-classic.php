<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0
 */

$fsdriving_blog_style = explode('_', fsdriving_get_theme_option('blog_style'));
$fsdriving_columns = empty($fsdriving_blog_style[1]) ? 2 : max(2, $fsdriving_blog_style[1]);
$fsdriving_expanded = !fsdriving_sidebar_present() && fsdriving_is_on(fsdriving_get_theme_option('expand_content'));
$fsdriving_post_format = get_post_format();
$fsdriving_post_format = empty($fsdriving_post_format) ? 'standard' : str_replace('post-format-', '', $fsdriving_post_format);
$fsdriving_animation = fsdriving_get_theme_option('blog_animation');

?><div class="<?php echo trim($fsdriving_blog_style[0]) == 'classic' ? 'column' : 'masonry_item masonry_item'; ?>-1_<?php echo esc_attr($fsdriving_columns); ?>"><article id="post-<?php the_ID(); ?>"
	<?php post_class( 'post_item post_format_'.esc_attr($fsdriving_post_format)
					. ' post_layout_classic post_layout_classic_'.esc_attr($fsdriving_columns)
					. ' post_layout_'.esc_attr($fsdriving_blog_style[0]) 
					. ' post_layout_'.esc_attr($fsdriving_blog_style[0]).'_'.esc_attr($fsdriving_columns)
					); ?>
	<?php echo (!fsdriving_is_off($fsdriving_animation) ? ' data-animation="'.esc_attr(fsdriving_get_animation_classes($fsdriving_animation)).'"' : ''); ?>
	>

	<?php

	// Featured image
	fsdriving_show_post_featured( array( 'thumb_size' => fsdriving_get_thumb_size($fsdriving_blog_style[0] == 'classic'
													? (strpos(fsdriving_get_theme_option('body_style'), 'full')!==false 
															? ( $fsdriving_columns > 2 ? 'big' : 'huge' )
															: (	$fsdriving_columns > 2
																? ($fsdriving_expanded ? 'big' : 'small')
																: ($fsdriving_expanded ? 'big' : 'big')
																)
														)
													: (strpos(fsdriving_get_theme_option('body_style'), 'full')!==false 
															? ( $fsdriving_columns > 2 ? 'masonry-big' : 'full' )
															: (	$fsdriving_columns <= 2 && $fsdriving_expanded ? 'masonry-big' : 'masonry')
														)
								) ) );

	if ( !in_array($fsdriving_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php 
			do_action('fsdriving_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );

			do_action('fsdriving_action_before_post_meta'); 

			// Post meta
			fsdriving_show_post_meta(array(
				'categories' => true,
				'date' => true,
				'edit' => $fsdriving_columns < 3,
				'seo' => false,
				'share' => false,
				'counters' => 'comments',
				)
			);
			?>
		</div><!-- .entry-header -->
		<?php
	}		
	?>

	<div class="post_content entry-content">
		<div class="post_content_inner">
			<?php
			$fsdriving_show_learn_more = false;
			if (has_excerpt()) {
				the_excerpt();
			} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
				the_content( '' );
			} else if (in_array($fsdriving_post_format, array('link', 'aside', 'status', 'quote'))) {
				the_content();
			} else if (substr(get_the_content(), 0, 1)!='[') {
				the_excerpt();
			}
			?>
		</div>
		<?php
		// Post meta
		if (in_array($fsdriving_post_format, array('link', 'aside', 'status', 'quote'))) {
			fsdriving_show_post_meta(array(
				'share' => false,
				'counters' => 'comments'
				)
			);
		}
		// More button
		if ( $fsdriving_show_learn_more ) {
			?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'fsdriving'); ?></a></p><?php
		}
		?>
	</div><!-- .entry-content -->

</article></div>