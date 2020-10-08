<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0.14
 */
$fsdriving_header_video = fsdriving_get_header_video();
if (!empty($fsdriving_header_video) && !fsdriving_is_from_uploads($fsdriving_header_video)) {
	global $wp_embed;
	if (is_object($wp_embed))
		$fsdriving_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($fsdriving_header_video) . '[/embed]' ));
	$fsdriving_embed_video = fsdriving_make_video_autoplay($fsdriving_embed_video);
	?><div id="background_video"><?php fsdriving_show_layout($fsdriving_embed_video); ?></div><?php
}
?>