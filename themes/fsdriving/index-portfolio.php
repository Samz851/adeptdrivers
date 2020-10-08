<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0
 */

fsdriving_storage_set('blog_archive', true);

// Load scripts for both 'Gallery' and 'Portfolio' layouts!
wp_enqueue_script( 'classie', fsdriving_get_file_url('js/theme.gallery/classie.min.js'), array(), null, true );
wp_enqueue_script( 'imagesloaded', fsdriving_get_file_url('js/theme.gallery/imagesloaded.min.js'), array(), null, true );
wp_enqueue_script( 'masonry', fsdriving_get_file_url('js/theme.gallery/masonry.min.js'), array(), null, true );
wp_enqueue_script( 'fsdriving-gallery-script', fsdriving_get_file_url('js/theme.gallery/theme.gallery.js'), array(), null, true );

get_header(); 

if (have_posts()) {

	echo get_query_var('blog_archive_start');

	$fsdriving_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$fsdriving_sticky_out = is_array($fsdriving_stickies) && count($fsdriving_stickies) > 0 && get_query_var( 'paged' ) < 1;
	
	// Show filters
	$fsdriving_cat = fsdriving_get_theme_option('parent_cat');
	$fsdriving_post_type = fsdriving_get_theme_option('post_type');
	$fsdriving_taxonomy = fsdriving_get_post_type_taxonomy($fsdriving_post_type);
	$fsdriving_show_filters = fsdriving_get_theme_option('show_filters');
	$fsdriving_tabs = array();
	if (!fsdriving_is_off($fsdriving_show_filters)) {
		$fsdriving_args = array(
			'type'			=> $fsdriving_post_type,
			'child_of'		=> $fsdriving_cat,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'exclude'		=> '',
			'include'		=> '',
			'number'		=> '',
			'taxonomy'		=> $fsdriving_taxonomy,
			'pad_counts'	=> false
		);
		$fsdriving_portfolio_list = get_terms($fsdriving_args);
		if (is_array($fsdriving_portfolio_list) && count($fsdriving_portfolio_list) > 0) {
			$fsdriving_tabs[$fsdriving_cat] = esc_html__('All', 'fsdriving');
			foreach ($fsdriving_portfolio_list as $fsdriving_term) {
				if (isset($fsdriving_term->term_id)) $fsdriving_tabs[$fsdriving_term->term_id] = $fsdriving_term->name;
			}
		}
	}
	if (count($fsdriving_tabs) > 0) {
		$fsdriving_portfolio_filters_ajax = true;
		$fsdriving_portfolio_filters_active = $fsdriving_cat;
		$fsdriving_portfolio_filters_id = 'portfolio_filters';
		if (!is_customize_preview())
			wp_enqueue_script('jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true);
		?>
		<div class="portfolio_filters fsdriving_tabs fsdriving_tabs_ajax">
			<ul class="portfolio_titles fsdriving_tabs_titles">
				<?php
				foreach ($fsdriving_tabs as $fsdriving_id=>$fsdriving_title) {
					?><li><a href="<?php echo esc_url(fsdriving_get_hash_link(sprintf('#%s_%s_content', $fsdriving_portfolio_filters_id, $fsdriving_id))); ?>" data-tab="<?php echo esc_attr($fsdriving_id); ?>"><?php echo esc_html($fsdriving_title); ?></a></li><?php
				}
				?>
			</ul>
			<?php
			$fsdriving_ppp = fsdriving_get_theme_option('posts_per_page');
			if (fsdriving_is_inherit($fsdriving_ppp)) $fsdriving_ppp = '';
			foreach ($fsdriving_tabs as $fsdriving_id=>$fsdriving_title) {
				$fsdriving_portfolio_need_content = $fsdriving_id==$fsdriving_portfolio_filters_active || !$fsdriving_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr(sprintf('%s_%s_content', $fsdriving_portfolio_filters_id, $fsdriving_id)); ?>"
					class="portfolio_content fsdriving_tabs_content"
					data-blog-template="<?php echo esc_attr(fsdriving_storage_get('blog_template')); ?>"
					data-blog-style="<?php echo esc_attr(fsdriving_get_theme_option('blog_style')); ?>"
					data-posts-per-page="<?php echo esc_attr($fsdriving_ppp); ?>"
					data-post-type="<?php echo esc_attr($fsdriving_post_type); ?>"
					data-taxonomy="<?php echo esc_attr($fsdriving_taxonomy); ?>"
					data-cat="<?php echo esc_attr($fsdriving_id); ?>"
					data-parent-cat="<?php echo esc_attr($fsdriving_cat); ?>"
					data-need-content="<?php echo (false===$fsdriving_portfolio_need_content ? 'true' : 'false'); ?>"
				>
					<?php
					if ($fsdriving_portfolio_need_content) 
						fsdriving_show_portfolio_posts(array(
							'cat' => $fsdriving_id,
							'parent_cat' => $fsdriving_cat,
							'taxonomy' => $fsdriving_taxonomy,
							'post_type' => $fsdriving_post_type,
							'page' => 1,
							'sticky' => $fsdriving_sticky_out
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		fsdriving_show_portfolio_posts(array(
			'cat' => $fsdriving_cat,
			'parent_cat' => $fsdriving_cat,
			'taxonomy' => $fsdriving_taxonomy,
			'post_type' => $fsdriving_post_type,
			'page' => 1,
			'sticky' => $fsdriving_sticky_out
			)
		);
	}

	echo get_query_var('blog_archive_end');

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>