<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0.10
 */


// Socials
if ( fsdriving_is_on(fsdriving_get_theme_option('socials_in_footer')) && ($fsdriving_output = fsdriving_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php fsdriving_show_layout($fsdriving_output); ?>
		</div>
	</div>
	<?php
}
?>