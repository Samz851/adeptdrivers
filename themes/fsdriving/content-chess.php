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
$fsdriving_columns = empty($fsdriving_blog_style[1]) ? 1 : max(1, $fsdriving_blog_style[1]);
$fsdriving_expanded = !fsdriving_sidebar_present() && fsdriving_is_on(fsdriving_get_theme_option('expand_content'));
$fsdriving_post_format = get_post_format();
$fsdriving_post_format = empty($fsdriving_post_format) ? 'standard' : str_replace('post-format-', '', $fsdriving_post_format);
$fsdriving_animation = fsdriving_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_chess post_layout_chess_'.esc_attr($fsdriving_columns).' post_format_'.esc_attr($fsdriving_post_format) ); ?>
	<?php echo (!fsdriving_is_off($fsdriving_animation) ? ' data-animation="'.esc_attr(fsdriving_get_animation_classes($fsdriving_animation)).'"' : ''); ?>
	>

	<?php
	// Add anchor
	if ($fsdriving_columns == 1 && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="post_'.esc_attr(get_the_ID()).'" title="'.esc_attr(get_the_title()).'"]');
	}

	// Featured image
	fsdriving_show_post_featured( array(
											'class' => $fsdriving_columns == 1 ? 'trx-stretch-height' : '',
											'show_no_image' => true,
											'thumb_bg' => true,
											'thumb_size' => fsdriving_get_thumb_size(
																	strpos(fsdriving_get_theme_option('body_style'), 'full')!==false
																		? ( $fsdriving_columns > 1 ? 'huge' : 'original' )
																		: (	$fsdriving_columns > 2 ? 'big' : 'huge')
																	)
											) 
										);

	?><div class="post_inner"><div class="post_inner_content"><?php 

		?><div class="post_header entry-header"><?php 
			do_action('fsdriving_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			
			do_action('fsdriving_action_before_post_meta'); 

			// Post meta
			$fsdriving_post_meta = fsdriving_show_post_meta(array(
									'categories' => true,
									'date' => true,
									'edit' => $fsdriving_columns == 1,
									'seo' => false,
									'share' => false,
									'counters' => $fsdriving_columns < 3 ? 'comments' : '',
									'echo' => false
									)
								);
			fsdriving_show_layout($fsdriving_post_meta);
		?></div><!-- .entry-header -->
	
		<div class="post_content entry-content">
			<div class="post_content_inner">
				<?php
				$fsdriving_show_learn_more = !in_array($fsdriving_post_format, array('link', 'aside', 'status', 'quote'));
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
				fsdriving_show_layout($fsdriving_post_meta);
			}
			// More button
			if ( $fsdriving_show_learn_more ) {
				?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'fsdriving'); ?></a></p><?php
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article>