<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('fsdriving_cf7_theme_setup9')) {
	add_action( 'after_setup_theme', 'fsdriving_cf7_theme_setup9', 9 );
	function fsdriving_cf7_theme_setup9() {
		
		if (fsdriving_exists_cf7()) {
			add_action( 'wp_enqueue_scripts', 								'fsdriving_cf7_frontend_scripts', 1100 );
			add_filter( 'fsdriving_filter_merge_styles',						'fsdriving_cf7_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'fsdriving_filter_tgmpa_required_plugins',			'fsdriving_cf7_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'fsdriving_cf7_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('fsdriving_filter_tgmpa_required_plugins',	'fsdriving_cf7_tgmpa_required_plugins');
	function fsdriving_cf7_tgmpa_required_plugins($list=array()) {
		if (in_array('contact-form-7', fsdriving_storage_get('required_plugins'))) {
			// CF7 plugin
			$list[] = array(
					'name' 		=> esc_html__('Contact Form 7', 'fsdriving'),
					'slug' 		=> 'contact-form-7',
					'required' 	=> false
			);
			$list[] = array(
					'name' 		=> esc_html__('Contact Form 7 Datepicker', 'fsdriving'),
					'slug' 		=> 'contact-form-7-datepicker',
					'required' 	=> false
			);
		}
		return $list;
	}
}



// Check if cf7 installed and activated
if ( !function_exists( 'fsdriving_exists_cf7' ) ) {
	function fsdriving_exists_cf7() {
		return class_exists('WPCF7');
	}
}
	
// Enqueue custom styles
if ( !function_exists( 'fsdriving_cf7_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'fsdriving_cf7_frontend_scripts', 1100 );
	function fsdriving_cf7_frontend_scripts() {
		if (fsdriving_is_on(fsdriving_get_theme_option('debug_mode')) && fsdriving_get_file_dir('plugins/contact-form-7/contact-form-7.css')!='')
			wp_enqueue_style( 'fsdriving-contact-form-7',  fsdriving_get_file_url('plugins/contact-form-7/contact-form-7.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'fsdriving_cf7_merge_styles' ) ) {
	//Handler of the add_filter('fsdriving_filter_merge_styles', 'fsdriving_cf7_merge_styles');
	function fsdriving_cf7_merge_styles($list) {
		$list[] = 'plugins/contact-form-7/contact-form-7.css';
		return $list;
	}
}
?>