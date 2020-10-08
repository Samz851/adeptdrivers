<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('fsdriving_mailchimp_theme_setup9')) {
	add_action( 'after_setup_theme', 'fsdriving_mailchimp_theme_setup9', 9 );
	function fsdriving_mailchimp_theme_setup9() {
		if (fsdriving_exists_mailchimp()) {
			add_action( 'wp_enqueue_scripts',							'fsdriving_mailchimp_frontend_scripts', 1100 );
			add_filter( 'fsdriving_filter_merge_styles',					'fsdriving_mailchimp_merge_styles');
			add_filter( 'fsdriving_filter_get_css',						'fsdriving_mailchimp_get_css', 10, 4);
		}
		if (is_admin()) {
			add_filter( 'fsdriving_filter_tgmpa_required_plugins',		'fsdriving_mailchimp_tgmpa_required_plugins' );
		}
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'fsdriving_exists_mailchimp' ) ) {
	function fsdriving_exists_mailchimp() {
		return function_exists('__mc4wp_load_plugin') || defined('MC4WP_VERSION');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'fsdriving_mailchimp_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('fsdriving_filter_tgmpa_required_plugins',	'fsdriving_mailchimp_tgmpa_required_plugins');
	function fsdriving_mailchimp_tgmpa_required_plugins($list=array()) {
		if (in_array('mailchimp-for-wp', fsdriving_storage_get('required_plugins')))
			$list[] = array(
				'name' 		=> esc_html__('MailChimp for WP', 'fsdriving'),
				'slug' 		=> 'mailchimp-for-wp',
				'required' 	=> false
			);
		return $list;
	}
}



// Custom styles and scripts
//------------------------------------------------------------------------

// Enqueue custom styles
if ( !function_exists( 'fsdriving_mailchimp_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'fsdriving_mailchimp_frontend_scripts', 1100 );
	function fsdriving_mailchimp_frontend_scripts() {
		if (fsdriving_exists_mailchimp()) {
			if (fsdriving_is_on(fsdriving_get_theme_option('debug_mode')) && fsdriving_get_file_dir('plugins/mailchimp-for-wp/mailchimp-for-wp.css')!='')
				wp_enqueue_style( 'fsdriving-mailchimp-for-wp',  fsdriving_get_file_url('plugins/mailchimp-for-wp/mailchimp-for-wp.css'), array(), null );
		}
	}
}
	
// Merge custom styles
if ( !function_exists( 'fsdriving_mailchimp_merge_styles' ) ) {
	//Handler of the add_filter( 'fsdriving_filter_merge_styles', 'fsdriving_mailchimp_merge_styles');
	function fsdriving_mailchimp_merge_styles($list) {
		$list[] = 'plugins/mailchimp-for-wp/mailchimp-for-wp.css';
		return $list;
	}
}

// Add css styles into global CSS stylesheet
if (!function_exists('fsdriving_mailchimp_get_css')) {
	//Handler of the add_filter('fsdriving_filter_get_css', 'fsdriving_mailchimp_get_css', 10, 4);
	function fsdriving_mailchimp_get_css($css, $colors, $fonts, $scheme='') {
		
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS

CSS;
		
			
			$rad = fsdriving_get_border_radius();
			$css['fonts'] .= <<<CSS

.mc4wp-form .mc4wp-form-fields input[type="email"],
.mc4wp-form .mc4wp-form-fields input[type="submit"] {
	-webkit-border-radius: {$rad};
	   -moz-border-radius: {$rad};
	    -ms-border-radius: {$rad};
			border-radius: {$rad};
}

CSS;
		}

		
		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

.mc4wp-form input[type="email"] {
	background-color: {$colors['alter_dark']};
	border-color: {$colors['alter_dark']};
	color: {$colors['bg_color']};
}
.mc4wp-form input[type="submit"] {
	color: {$colors['inverse_link']};
	background-color: transparent;
}
.mc4wp-form input[type="submit"]:hover {
	color: {$colors['inverse_hover']};
	background-color: transparent;
}
.footer_wrap .mc4wp-form .mc4wp-form-fields:after,
.footer_wrap .mc4wp-form input[type="submit"] {
	color: {$colors['accent4']};
}
.footer_wrap .mc4wp-form .mc4wp-form-fields:hover:after,
.footer_wrap .mc4wp-form input[type="submit"]:hover {
	color: {$colors['text_dark']};
}

CSS;
		}

		return $css;
	}
}
?>