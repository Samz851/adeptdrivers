<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0.10
 */

// Footer menu
$fsdriving_menu_footer = fsdriving_get_nav_menu('menu_footer');
if (!empty($fsdriving_menu_footer)) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php fsdriving_show_layout($fsdriving_menu_footer); ?>
		</div>
	</div>
	<?php
}
?>