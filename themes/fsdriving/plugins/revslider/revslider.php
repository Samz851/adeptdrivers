<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('fsdriving_revslider_theme_setup9')) {
	add_action( 'after_setup_theme', 'fsdriving_revslider_theme_setup9', 9 );
	function fsdriving_revslider_theme_setup9() {
		if (is_admin()) {
			add_filter( 'fsdriving_filter_tgmpa_required_plugins',	'fsdriving_revslider_tgmpa_required_plugins' );
		}
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'fsdriving_exists_revslider' ) ) {
	function fsdriving_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'fsdriving_revslider_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('fsdriving_filter_tgmpa_required_plugins',	'fsdriving_revslider_tgmpa_required_plugins');
	function fsdriving_revslider_tgmpa_required_plugins($list=array()) {
		if (in_array('revslider', fsdriving_storage_get('required_plugins'))) {
			$path = fsdriving_get_file_dir('plugins/revslider/revslider.zip');
			$list[] = array(
					'name' 		=> esc_html__('Revolution Slider', 'fsdriving'),
					'slug' 		=> 'revslider',
                    'version'	=> '6.0.1',
					'source'	=> !empty($path) ? $path : 'upload://revslider.zip',
					'required' 	=> false
			);
		}
		return $list;
	}
}
?>