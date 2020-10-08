<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0.10
 */

// Logo
if (fsdriving_is_on(fsdriving_get_theme_option('logo_in_footer'))) {
	$fsdriving_logo_image = '';
	if (fsdriving_get_retina_multiplier(2) > 1)
		$fsdriving_logo_image = fsdriving_get_theme_option( 'logo_footer_retina' );
	if (empty($fsdriving_logo_image)) 
		$fsdriving_logo_image = fsdriving_get_theme_option( 'logo_footer' );
	$fsdriving_logo_text   = get_bloginfo( 'name' );
	if (!empty($fsdriving_logo_image) || !empty($fsdriving_logo_text)) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if (!empty($fsdriving_logo_image)) {
					$fsdriving_attr = fsdriving_getimagesize($fsdriving_logo_image);
					echo '<a href="'.esc_url(home_url('/')).'"><img src="'.esc_url($fsdriving_logo_image).'" class="logo_footer_image" alt="'.esc_attr(basename($fsdriving_logo_image)).'"'.(!empty($fsdriving_attr[3]) ? sprintf(' %s', $fsdriving_attr[3]) : '').'></a>' ;
				} else if (!empty($fsdriving_logo_text)) {
					echo '<h1 class="logo_footer_text"><a href="'.esc_url(home_url('/')).'">' . esc_html($fsdriving_logo_text) . '</a></h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
?>