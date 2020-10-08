<?php
/**
 * The style "default" of the Matches
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.17
 */

$args = get_query_var('trx_addons_args_sc_matches');

$round = $args['round'];
if ($round == 'last' || $round == 'next') {
	$rounds = trx_addons_get_list_posts(false, array(
													'post_type' => TRX_ADDONS_CPT_ROUNDS_PT,
													'post_parent' => $args['competition'],
													'posts_per_page' => 1,
													'meta_key' => 'trx_addons_round_date',
													'meta_value' => date('Y-m-d H:i'),
													'meta_compare' => $round == 'last' ? '<=' : '>',
													'orderby' => 'meta_value',
													'order' => $round == 'last' ? 'DESC' : 'ASC',
													'not_selected' => false
													));
	if (count($rounds)>0) {
		foreach ($rounds as $k => $v) {
			$round = $k;
			break;
		}
	}
}

$query_args = array(
	'post_type' => TRX_ADDONS_CPT_MATCHES_PT,
	'post_status' => 'publish',
	'ignore_sticky_posts' => true,
);
if (empty($args['ids'])) {
	$query_args['post_parent'] = $round;
	$query_args['posts_per_page'] = $args['count'] > 0 ? $args['count'] : -1;
	$query_args['offset'] = $args['offset'];
}
$query_args = trx_addons_query_add_sort_order($query_args, str_replace('post_date', 'match_date', $args['orderby']), $args['order']);
$query_args = trx_addons_query_add_posts_and_cats($query_args, $args['ids']);
$query = new WP_Query( $query_args );
if ($query->found_posts > 0) {
	// Prepare matches
	$matches = array(
		'main' => array(),
		'other' => array()
	);
	while ( $query->have_posts() ) { $query->the_post();
		$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
		$matches[!empty($args['main_matches']) && !empty($meta['main_match']) && !empty($meta['player1']) ? 'main' : 'other'][] = array(
			'id' => get_the_ID(),
			'title' => get_the_title(),
			'link' => get_permalink(),
			'meta' => $meta
		);
	}
	wp_reset_postdata();
	// Show matches
	$main_matches = count($matches['main']);
	if ($main_matches == 0) $args['position'] = 'top';
	$other_matches = count($matches['other']);
	$args['slider'] = $args['slider'] > 0 && $main_matches > 1;
	?><div class="sc_matches sc_matches_<?php
			echo esc_attr($args['type']);
			echo ' sc_matches_main_'.esc_attr($args['position']);
			if (!empty($args['class'])) echo ' '.esc_attr($args['class']); 
			?>">
		<?php
		
		trx_addons_sc_show_titles('sc_matches', $args);

		// Additional container for 'left' or 'right' main position
		if ($args['position'] != 'top') {
			?><div class="sc_matches_content sc_item_content">
				<div class="sc_matches_side"><?php
		}
		
		// Main matches
		if ($main_matches > 0) {
			?><div class="sc_matches_main<?php
				if ($args['position'] == 'top') echo " sc_matches_content sc_item_content";
	    		if ($args['slider']) echo ' swiper-slider-container slider_swiper slider_noresize slider_controls slider_controls_side slider_pagination'; 
			?>"><?php
			if ($args['slider']) {
				?><div class="sc_matches_slider sc_item_slider slides swiper-wrapper"><?php
			}	
			
			foreach ($matches['main'] as $match) {
				if ($args['slider']) {
					?><div class="swiper-slide"><?php
				}
				set_query_var('trx_addons_args_sc_matches_item', $match);
				if (($fdir = trx_addons_get_file_dir('cpt/sport/tpl.sc_matches.default-main.php')) != '') { include $fdir; }
				if ($args['slider']) {
					?></div><?php
				}
			}

			if ($args['slider']) {
				?></div><!-- /.slider_swiper --><?php
				// Controls
				?><div class="slider_controls_wrap">
					<a class="slider_prev swiper-button-prev" href="#"></a>
					<a class="slider_next swiper-button-next" href="#"></a>
				</div><?php
				// Pagination
				?><div class="slider_pagination_wrap swiper-pagination"></div><?php
			}

			?></div><!-- /.sc_matches_main --><?php

		}

		// Additional container for 'left' or 'right' main position
		if ($args['position'] != 'top') {

			trx_addons_sc_show_links('sc_matches', $args);

			?></div><div class="sc_matches_side"><?php
		}
		
		// Other Matches
		if ($other_matches > 0) {
			?><div class="sc_matches_other<?php
				if ($main_matches == 0 && $args['position'] == 'top') echo " sc_matches_content sc_item_content";
				?>"><?php

			foreach ($matches['other'] as $match) {
				$match['position'] = $args['position'];
				set_query_var('trx_addons_args_sc_matches_item', $match);
				if (($fdir = trx_addons_get_file_dir('cpt/sport/tpl.sc_matches.default-other.php')) != '') { include $fdir; }
			}
		
			?></div><?php
		}
		
		// Additional container for 'left' or 'right' main position
		if ($args['position'] != 'top') {
			?></div></div><?php
		} else
			trx_addons_sc_show_links('sc_matches', $args);

	?></div><!-- /.sc_matches --><?php
}
?>