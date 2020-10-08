<?php
/* WPBakery Page Builder support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('fsdriving_vc_theme_setup9')) {
	add_action( 'after_setup_theme', 'fsdriving_vc_theme_setup9', 9 );
	function fsdriving_vc_theme_setup9() {
		if (fsdriving_exists_visual_composer()) {
			add_action( 'wp_enqueue_scripts', 								'fsdriving_vc_frontend_scripts', 1100 );
			add_filter( 'fsdriving_filter_merge_styles',						'fsdriving_vc_merge_styles' );
			add_filter( 'fsdriving_filter_merge_scripts',						'fsdriving_vc_merge_scripts' );
			add_filter( 'fsdriving_filter_get_css',							'fsdriving_vc_get_css', 10, 4 );
	
			// Add/Remove params in the standard VC shortcodes
			//-----------------------------------------------------
			add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,					'fsdriving_vc_add_params_classes', 10, 3 );
			
			// Color scheme
			$scheme = array(
				"param_name" => "scheme",
				"heading" => esc_html__("Color scheme", 'fsdriving'),
				"description" => wp_kses_data( __("Select color scheme to decorate this block", 'fsdriving') ),
				"group" => esc_html__('Colors', 'fsdriving'),
				"admin_label" => true,
				"value" => array_flip(fsdriving_get_list_schemes(true)),
				"type" => "dropdown"
			);
			vc_add_param("vc_row", $scheme);
			vc_add_param("vc_row_inner", $scheme);
			vc_add_param("vc_column", $scheme);
			vc_add_param("vc_column_inner", $scheme);
			vc_add_param("vc_column_text", $scheme);
			
			// Alter height and hide on mobile for Empty Space
			vc_add_param("vc_empty_space", array(
				"param_name" => "alter_height",
				"heading" => esc_html__("Alter height", 'fsdriving'),
				"description" => wp_kses_data( __("Select alternative height instead value from the field above", 'fsdriving') ),
				"admin_label" => true,
				"value" => array(
					esc_html__('Tiny', 'fsdriving') => 'tiny',
					esc_html__('Small', 'fsdriving') => 'small',
					esc_html__('Medium', 'fsdriving') => 'medium',
					esc_html__('Large', 'fsdriving') => 'large',
					esc_html__('Huge', 'fsdriving') => 'huge',
					esc_html__('From the value above', 'fsdriving') => 'none'
				),
				"type" => "dropdown"
			));
			vc_add_param("vc_empty_space", array(
				"param_name" => "hide_on_mobile",
				"heading" => esc_html__("Hide on mobile", 'fsdriving'),
				"description" => wp_kses_data( __("Hide this block on the mobile devices, when the columns are arranged one under another", 'fsdriving') ),
				"admin_label" => true,
				"std" => 0,
				"value" => array(
					esc_html__("Hide on mobile", 'fsdriving') => "1",
					esc_html__("Hide on tablet", 'fsdriving') => "3",
					esc_html__("Hide on notebook", 'fsdriving') => "2"
					),
				"type" => "checkbox"
			));
			
			// Add Narrow style to the Progress bars
			vc_add_param("vc_progress_bar", array(
				"param_name" => "narrow",
				"heading" => esc_html__("Narrow", 'fsdriving'),
				"description" => wp_kses_data( __("Use narrow style for the progress bar", 'fsdriving') ),
				"std" => 0,
				"value" => array(esc_html__("Narrow style", 'fsdriving') => "1" ),
				"type" => "checkbox"
			));
			
			// Add param 'Closeable' to the Message Box
			vc_add_param("vc_message", array(
				"param_name" => "closeable",
				"heading" => esc_html__("Closeable", 'fsdriving'),
				"description" => wp_kses_data( __("Add 'Close' button to the message box", 'fsdriving') ),
				"std" => 0,
				"value" => array(esc_html__("Closeable", 'fsdriving') => "1" ),
				"type" => "checkbox"
			));
		}
		if (is_admin()) {
			add_filter( 'fsdriving_filter_tgmpa_required_plugins',		'fsdriving_vc_tgmpa_required_plugins' );
			add_filter( 'vc_iconpicker-type-fontawesome',				'fsdriving_vc_iconpicker_type_fontawesome' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'fsdriving_vc_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('fsdriving_filter_tgmpa_required_plugins',	'fsdriving_vc_tgmpa_required_plugins');
	function fsdriving_vc_tgmpa_required_plugins($list=array()) {
		if (in_array('js_composer', fsdriving_storage_get('required_plugins'))) {
			$path = fsdriving_get_file_dir('plugins/js_composer/js_composer.zip');
			$list[] = array(
					'name' 		=> esc_html__('WPBakery Page Builder', 'fsdriving'),
					'slug' 		=> 'js_composer',
                    'version'	=> '6.0.3',
					'source'	=> !empty($path) ? $path : 'upload://js_composer.zip',
					'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if WPBakery Page Builder installed and activated
if ( !function_exists( 'fsdriving_exists_visual_composer' ) ) {
	function fsdriving_exists_visual_composer() {
		return class_exists('Vc_Manager');
	}
}

// Check if WPBakery Page Builder in frontend editor mode
if ( !function_exists( 'fsdriving_vc_is_frontend' ) ) {
	function fsdriving_vc_is_frontend() {
		return (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true')
			|| (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline');
	}
}
	
// Enqueue VC custom styles
if ( !function_exists( 'fsdriving_vc_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'fsdriving_vc_frontend_scripts', 1100 );
	function fsdriving_vc_frontend_scripts() {
		if (fsdriving_exists_visual_composer()) {
			if (fsdriving_is_on(fsdriving_get_theme_option('debug_mode')) && fsdriving_get_file_dir('plugins/js_composer/js_composer.css')!='')
				wp_enqueue_style( 'fsdriving-js_composer',  fsdriving_get_file_url('plugins/js_composer/js_composer.css'), array(), null );
			if (fsdriving_is_on(fsdriving_get_theme_option('debug_mode')) && fsdriving_get_file_dir('plugins/js_composer/js_composer.js')!='')
				wp_enqueue_script( 'fsdriving-js_composer', fsdriving_get_file_url('plugins/js_composer/js_composer.js'), array('jquery'), null, true );
		}
	}
}
	
// Merge custom styles
if ( !function_exists( 'fsdriving_vc_merge_styles' ) ) {
	//Handler of the add_filter('fsdriving_filter_merge_styles', 'fsdriving_vc_merge_styles');
	function fsdriving_vc_merge_styles($list) {
		$list[] = 'plugins/js_composer/js_composer.css';
		return $list;
	}
}
	
// Merge custom scripts
if ( !function_exists( 'fsdriving_vc_merge_scripts' ) ) {
	//Handler of the add_filter('fsdriving_filter_merge_scripts', 'fsdriving_vc_merge_scripts');
	function fsdriving_vc_merge_scripts($list) {
		$list[] = 'plugins/js_composer/js_composer.js';
		return $list;
	}
}
	
// Add theme icons into VC iconpicker list
if ( !function_exists( 'fsdriving_vc_iconpicker_type_fontawesome' ) ) {
	//Handler of the add_filter( 'vc_iconpicker-type-fontawesome',	'fsdriving_vc_iconpicker_type_fontawesome' );
	function fsdriving_vc_iconpicker_type_fontawesome($icons) {
		$list = fsdriving_get_list_icons();
		if (!is_array($list) || count($list) == 0) return $icons;
		$rez = array();
		foreach ($list as $icon)
			$rez[] = array($icon => str_replace('icon-', '', $icon));
		return array_merge( $icons, array(esc_html__('Theme Icons', 'fsdriving') => $rez) );
	}
}



// Shortcodes
//------------------------------------------------------------------------

// Add params to the standard VC shortcodes
if ( !function_exists( 'fsdriving_vc_add_params_classes' ) ) {
	//Handler of the add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'fsdriving_vc_add_params_classes', 10, 3 );
	function fsdriving_vc_add_params_classes($classes, $sc, $atts) {
		if (in_array($sc, array('vc_row', 'vc_row_inner', 'vc_column', 'vc_column_inner', 'vc_column_text'))) {
			if (!empty($atts['scheme']) && !fsdriving_is_inherit($atts['scheme']))
				$classes .= ($classes ? ' ' : '') . 'scheme_' . $atts['scheme'];
		} else if (in_array($sc, array('vc_empty_space'))) {
			if (!empty($atts['alter_height']) && !fsdriving_is_off($atts['alter_height']))
				$classes .= ($classes ? ' ' : '') . 'height_' . $atts['alter_height'];
			if (!empty($atts['hide_on_mobile'])) {
				if (strpos($atts['hide_on_mobile'], '1')!==false)	$classes .= ($classes ? ' ' : '') . 'hide_on_mobile';
				if (strpos($atts['hide_on_mobile'], '3')!==false)	$classes .= ($classes ? ' ' : '') . 'hide_on_tablet';
				if (strpos($atts['hide_on_mobile'], '2')!==false)	$classes .= ($classes ? ' ' : '') . 'hide_on_notebook';
			}
		} else if (in_array($sc, array('vc_progress_bar'))) {
			if (!empty($atts['narrow']) && (int) $atts['narrow']==1)
				$classes .= ($classes ? ' ' : '') . 'vc_progress_bar_narrow';
		} else if (in_array($sc, array('vc_message'))) {
			if (!empty($atts['closeable']) && (int) $atts['closeable']==1)
				$classes .= ($classes ? ' ' : '') . 'vc_message_box_closeable';
		}
		return $classes;
	}
}


// Add VC specific styles into color scheme
//------------------------------------------------------------------------

// Add styles into CSS
if ( !function_exists( 'fsdriving_vc_get_css' ) ) {
	//Handler of the add_filter( 'fsdriving_filter_get_css', 'fsdriving_vc_get_css', 10, 4 );
	function fsdriving_vc_get_css($css, $colors, $fonts, $scheme='') {
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS
.vc_tta.vc_tta-accordion .vc_tta-panel-title .vc_tta-title-text {
	{$fonts['p_font-family']}
}
.vc_progress_bar.vc_progress_bar_narrow .vc_single_bar .vc_label .vc_label_units {
	{$fonts['info_font-family']}
}

CSS;
		}

		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

/* Row and columns */
.scheme_self.wpb_row,
.scheme_self.wpb_column > .vc_column-inner > .wpb_wrapper,
.scheme_self.wpb_text_column {
	color: {$colors['text']};
	background-color: {$colors['bg_color']};
}
.scheme_self.vc_row.vc_parallax[class*="scheme_"] .vc_parallax-inner:before {
	background-color: {$colors['bg_color_08']};
}

/* Accordion */
.vc_tta.vc_tta-accordion .vc_tta-panel-heading .vc_tta-controls-icon {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_dark']};
}
.vc_tta.vc_tta-accordion .vc_tta-panel-heading .vc_tta-controls-icon:before,
.vc_tta.vc_tta-accordion .vc_tta-panel-heading .vc_tta-controls-icon:after {
	border-color: {$colors['inverse_link']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title > a {
	color: {$colors['text_dark']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a,
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title > a:hover {
	color: {$colors['text_link']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a .vc_tta-controls-icon,
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title > a:hover .vc_tta-controls-icon {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a .vc_tta-controls-icon:before,
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a .vc_tta-controls-icon:after {
	border-color: {$colors['inverse_link']};
}

/* Tabs */
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-tabs-list .vc_tta-tab > a {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_dark']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-tabs-list .vc_tta-tab > a:hover,
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-tabs-list .vc_tta-tab.vc_active > a {
	color: {$colors['inverse_hover']};
	background-color: {$colors['text_link']};
}

/* Separator */
.vc_separator.vc_sep_color_grey .vc_sep_line {
	border-color: {$colors['bd_color']};
}

/* Progress bar */
.vc_progress_bar.vc_progress_bar_narrow .vc_single_bar {
	background-color: {$colors['alter_bg_color']};
}
.vc_progress_bar.vc_progress_bar_narrow.vc_progress-bar-color-bar_red .vc_single_bar .vc_bar {
	background-color: {$colors['alter_link']};
}
.vc_progress_bar.vc_progress_bar_narrow .vc_single_bar .vc_label {
	color: {$colors['text_dark']};
}
.vc_progress_bar.vc_progress_bar_narrow .vc_single_bar .vc_label .vc_label_units {
	color: {$colors['accent4']};
}

/* Toggle */
.vc_toggle_title {
	background-color: {$colors['alter_bg_color']};
}
.vc_toggle_active .vc_toggle_title,
.vc_toggle_title:hover {
	background-color: {$colors['accent2']};
}
.vc_toggle_active .vc_toggle_title > h4,
.vc_toggle_title:hover > h4 {
	color: {$colors['alter_light']};
}

CSS;
		}
		
		return $css;
	}
}
?>