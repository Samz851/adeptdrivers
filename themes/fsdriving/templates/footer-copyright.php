<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0.10
 */

// Copyright area
$fsdriving_footer_scheme =  fsdriving_is_inherit(fsdriving_get_theme_option('footer_scheme')) ? fsdriving_get_theme_option('color_scheme') : fsdriving_get_theme_option('footer_scheme');
$fsdriving_copyright_scheme = fsdriving_is_inherit(fsdriving_get_theme_option('copyright_scheme')) ? $fsdriving_footer_scheme : fsdriving_get_theme_option('copyright_scheme');
?> 
<div class="footer_copyright_wrap scheme_<?php echo esc_attr($fsdriving_copyright_scheme); ?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text"><?php
				// Replace {{...}} and [[...]] on the <i>...</i> and <b>...</b>
				$fsdriving_copyright = fsdriving_prepare_macros(fsdriving_get_theme_option('copyright'));
				if (!empty($fsdriving_copyright)) {
					// Replace {date_format} on the current date in the specified format
					if (preg_match("/(\\{[\\w\\d\\\\\\-\\:]*\\})/", $fsdriving_copyright, $fsdriving_matches)) {
						$fsdriving_copyright = str_replace($fsdriving_matches[1], date(str_replace(array('{', '}'), '', $fsdriving_matches[1])), $fsdriving_copyright);
					}
					// Display copyright
					echo wp_kses_data(nl2br($fsdriving_copyright));
				}
			?></div>
		</div>
	</div>
</div>
