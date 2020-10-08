..<?php
/**
 * The template to display any sport's type archive
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.17
 */

get_header(); 

if (have_posts()) {

	do_action('trx_addons_action_start_archive');
	
	global $post;
	$trx_addons_slug = trx_addons_cpt_param($post->post_type, 'post_type_slug');

	?><div class="sc_sport sc_sport_default<?php if (!empty($trx_addons_slug)) echo ' sc_'.esc_attr($trx_addons_slug).' sc_'.esc_attr($trx_addons_slug).'_default'; ?>">

		<div class="sc_sport_columns<?php if (!empty($trx_addons_slug)) echo ' sc_'.esc_attr($trx_addons_slug).'_columns'; ?> <?php echo esc_attr(trx_addons_get_columns_wrap_class()); ?> columns_padding_bottom"><?php

			$trx_addons_style   = explode('_', trx_addons_get_option('competitions_style'));
			$trx_addons_type    = $trx_addons_style[0];
			$trx_addons_columns = empty($trx_addons_style[1]) ? 1 : max(1, $trx_addons_style[1]);
			
			set_query_var('trx_addons_args_sc_sport', array(
					'type' => $trx_addons_type,
					'columns' => $trx_addons_columns,
					'slug' => $trx_addons_slug,
					'hide_excerpt' => false,
					'slider' => false
				)
			);
		
			$fdir_archive_item = '';
			while ( have_posts() ) { the_post(); 
				if (!empty($fdir_archive_item)) { include $fdir_archive_item; } 
				else if (($fdir_archive_item = trx_addons_get_file_dir('cpt/sport/tpl.'.trim($trx_addons_slug).'.'.trim($trx_addons_type).'-item.php')) != '') { include $fdir_archive_item; }
				else if (($fdir_archive_item = trx_addons_get_file_dir('cpt/sport/tpl.'.trim($trx_addons_slug).'.archive-item.php')) != '') { include $fdir_archive_item; }
				else if (($fdir_archive_item = trx_addons_get_file_dir('cpt/sport/tpl.archive-item.php')) != '') { include $fdir_archive_item; }
			}
	
		?></div><!-- .trx_addons_columns_wrap --><?php

    ?></div><!-- .sc_sport --><?php

	the_posts_pagination( array(
		'mid_size'  => 2,
		'prev_text' => esc_html__( '<', 'trx_addons' ),
		'next_text' => esc_html__( '>', 'trx_addons' ),
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'trx_addons' ) . ' </span>',
	) );

	do_action('trx_addons_action_end_archive');

} else {
	do_action('trx_addons_action_none_archive');
}

get_footer();
?>