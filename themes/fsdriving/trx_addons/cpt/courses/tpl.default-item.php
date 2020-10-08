<?php
/**
 * The style "default" of the Courses
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

$args = get_query_var('trx_addons_args_sc_courses');

$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);

if ($args['slider']) {
	?><div class="swiper-slide"><?php
} else if ($args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?>"><?php
}
?>
<div class="sc_courses_item trx_addons_hover trx_addons_hover_style_links">
	<?php if (has_post_thumbnail()) { ?>
		<div class="sc_courses_item_thumb">
			<?php the_post_thumbnail( trx_addons_get_thumb_size($args['columns'] > 2 ? 'big' : 'big'), array('alt' => get_the_title()) ); ?>
			<span class="sc_courses_item_categories"><?php echo trim(trx_addons_get_post_terms(' ', get_the_ID(), TRX_ADDONS_CPT_COURSES_TAXONOMY)); ?></span>
			<div class="trx_addons_hover_mask"></div>
			<div class="sc_courses_hover_links">
				<a href="<?php echo esc_url(get_permalink()); ?>" class="sc_courses_hover_link"><?php esc_html_e('More Info', 'fsdriving'); ?></a>
			</div>
		</div>
	<?php } ?>
	<div class="sc_courses_item_info">
		<div class="sc_courses_item_header">
			<h4 class="sc_courses_item_title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h4>
			<?php if (!empty($meta['duration'])) { ?>
			<span class="sc_courses_item_meta_item sc_courses_item_meta_duration"><?php echo esc_html($meta['duration']); ?></span>
			<?php } ?>
		</div>
		<div class="sc_courses_item_price"><?php
			$price = explode('/', $meta['price']);
			echo esc_html($price[0]) . (!empty($price[1]) ? '<span class="sc_courses_item_period">'.$price[1].'</span>' : '');
		?></div>
	</div>
</div>
<?php
if ($args['slider'] || $args['columns'] > 1) {
	?></div><?php
}

?>