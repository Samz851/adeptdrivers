<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the WPBakery Page Builder to make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$fsdriving_content = '';
$fsdriving_blog_archive_mask = '%%CONTENT%%';
$fsdriving_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $fsdriving_blog_archive_mask);
if ( have_posts() ) {
	the_post(); 
	if (($fsdriving_content = apply_filters('the_content', get_the_content())) != '') {
		if (($fsdriving_pos = strpos($fsdriving_content, $fsdriving_blog_archive_mask)) !== false) {
			$fsdriving_content = preg_replace('/(\<p\>\s*)?'.$fsdriving_blog_archive_mask.'(\s*\<\/p\>)/i', $fsdriving_blog_archive_subst, $fsdriving_content);
		} else
			$fsdriving_content .= $fsdriving_blog_archive_subst;
		$fsdriving_content = explode($fsdriving_blog_archive_mask, $fsdriving_content);
	}
}

// Prepare args for a new query
$fsdriving_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$fsdriving_args = fsdriving_query_add_posts_and_cats($fsdriving_args, '', fsdriving_get_theme_option('post_type'), fsdriving_get_theme_option('parent_cat'));
$fsdriving_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($fsdriving_page_number > 1) {
	$fsdriving_args['paged'] = $fsdriving_page_number;
	$fsdriving_args['ignore_sticky_posts'] = true;
}
$fsdriving_ppp = fsdriving_get_theme_option('posts_per_page');
if ((int) $fsdriving_ppp != 0)
	$fsdriving_args['posts_per_page'] = (int) $fsdriving_ppp;
// Make a new query
query_posts( $fsdriving_args );
// Set a new query as main WP Query
$GLOBALS['wp_the_query'] = $GLOBALS['wp_query'];

// Set query vars in the new query!
if (is_array($fsdriving_content) && count($fsdriving_content) == 2) {
	set_query_var('blog_archive_start', $fsdriving_content[0]);
	set_query_var('blog_archive_end', $fsdriving_content[1]);
}

get_template_part('index');
?>