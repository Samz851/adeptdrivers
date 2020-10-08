<?php
/* Theme-specific action to configure ThemeREX Addons components
------------------------------------------------------------------------------- */


/* ThemeREX Addons components
------------------------------------------------------------------------------- */

if (!function_exists('fsdriving_trx_addons_theme_specific_setup1')) {
	add_action( 'after_setup_theme', 'fsdriving_trx_addons_theme_specific_setup1', 1 );
	add_action( 'trx_addons_action_save_options', 'fsdriving_trx_addons_theme_specific_setup1', 8 );
	function fsdriving_trx_addons_theme_specific_setup1() {
		if (fsdriving_exists_trx_addons()) {
			add_filter( 'trx_addons_cv_enable',				'fsdriving_trx_addons_cv_enable');
			add_filter( 'trx_addons_cpt_list',				'fsdriving_trx_addons_cpt_list');
			add_filter( 'trx_addons_sc_list',				'fsdriving_trx_addons_sc_list');
			add_filter( 'trx_addons_widgets_list',			'fsdriving_trx_addons_widgets_list');
		}
	}
}

// CV
if ( !function_exists( 'fsdriving_trx_addons_cv_enable' ) ) {
	//Handler of the add_filter( 'trx_addons_cv_enable', 'fsdriving_trx_addons_cv_enable');
	function fsdriving_trx_addons_cv_enable($enable=false) {
		// To do: return false if theme not use CV functionality
		return false;
	}
}

// CPT
if ( !function_exists( 'fsdriving_trx_addons_cpt_list' ) ) {
	//Handler of the add_filter('trx_addons_cpt_list',	'fsdriving_trx_addons_cpt_list');
	function fsdriving_trx_addons_cpt_list($list=array()) {
		// To do: Enable/Disable CPT via add/remove it in the list
		return $list;
	}
}

// Shortcodes
if ( !function_exists( 'fsdriving_trx_addons_sc_list' ) ) {
	//Handler of the add_filter('trx_addons_sc_list',	'fsdriving_trx_addons_sc_list');
	function fsdriving_trx_addons_sc_list($list=array()) {
		// To do: Add/Remove shortcodes into list
		// If you add new shortcode - in the theme's folder must exists /trx_addons/shortcodes/new_sc_name/new_sc_name.php
		return $list;
	}
}

// Widgets
if ( !function_exists( 'fsdriving_trx_addons_widgets_list' ) ) {
	//Handler of the add_filter('trx_addons_widgets_list',	'fsdriving_trx_addons_widgets_list');
	function fsdriving_trx_addons_widgets_list($list=array()) {
		// To do: Add/Remove widgets into list
		// If you add widget - in the theme's folder must exists /trx_addons/widgets/new_widget_name/new_widget_name.php
		return $list;
	}
}


/* Add options in the Theme Options Customizer
------------------------------------------------------------------------------- */

// Theme init priorities:
// 3 - add/remove Theme Options elements
if (!function_exists('fsdriving_trx_addons_theme_specific_setup3')) {
	add_action( 'after_setup_theme', 'fsdriving_trx_addons_theme_specific_setup3', 3 );
	function fsdriving_trx_addons_theme_specific_setup3() {
		
		// Section 'Courses' - settings to show 'Courses' blog archive and single posts
		if (fsdriving_exists_courses()) {
			fsdriving_storage_merge_array('options', '', array(
				'courses' => array(
					"title" => esc_html__('Courses', 'fsdriving'),
					"desc" => wp_kses_data( __('Select parameters to display the courses pages', 'fsdriving') ),
					"type" => "section"
					),
				'expand_content_courses' => array(
					"title" => esc_html__('Expand content', 'fsdriving'),
					"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'fsdriving') ),
					"refresh" => false,
					"std" => 1,
					"type" => "checkbox"
					),
				'header_style_courses' => array(
					"title" => esc_html__('Header style', 'fsdriving'),
					"desc" => wp_kses_data( __('Select style to display the site header on the courses pages', 'fsdriving') ),
					"std" => 'inherit',
					"options" => fsdriving_get_list_header_styles(true),
					"type" => "select"
					),
				'header_position_courses' => array(
					"title" => esc_html__('Header position', 'fsdriving'),
					"desc" => wp_kses_data( __('Select position to display the site header on the courses pages', 'fsdriving') ),
					"std" => 'inherit',
					"options" => fsdriving_get_list_header_positions(true),
					"type" => "select"
					),
				'header_widgets_courses' => array(
					"title" => esc_html__('Header widgets', 'fsdriving'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on the courses pages', 'fsdriving') ),
					"std" => 'hide',
					"options" => fsdriving_get_list_sidebars(true, true),
					"type" => "select"
					),
				'sidebar_widgets_courses' => array(
					"title" => esc_html__('Sidebar widgets', 'fsdriving'),
					"desc" => wp_kses_data( __('Select sidebar to show on the courses pages', 'fsdriving') ),
					"std" => 'hide',
					"options" => fsdriving_get_list_sidebars(true, true),
					"type" => "select"
					),
				'sidebar_position_courses' => array(
					"title" => esc_html__('Sidebar position', 'fsdriving'),
					"desc" => wp_kses_data( __('Select position to show sidebar on the courses pages', 'fsdriving') ),
					"refresh" => false,
					"std" => 'left',
					"options" => fsdriving_get_list_sidebars_positions(true),
					"type" => "select"
					),
				'hide_sidebar_on_single_courses' => array(
					"title" => esc_html__('Hide sidebar on the single course', 'fsdriving'),
					"desc" => wp_kses_data( __("Hide sidebar on the single course's page", 'fsdriving') ),
					"std" => 0,
					"type" => "checkbox"
					),
				'widgets_above_page_courses' => array(
					"title" => esc_html__('Widgets above the page', 'fsdriving'),
					"desc" => wp_kses_data( __('Select widgets to show above page (content and sidebar)', 'fsdriving') ),
					"std" => 'hide',
					"options" => fsdriving_get_list_sidebars(true, true),
					"type" => "select"
					),
				'widgets_above_content_courses' => array(
					"title" => esc_html__('Widgets above the content', 'fsdriving'),
					"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'fsdriving') ),
					"std" => 'hide',
					"options" => fsdriving_get_list_sidebars(true, true),
					"type" => "select"
					),
				'widgets_below_content_courses' => array(
					"title" => esc_html__('Widgets below the content', 'fsdriving'),
					"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'fsdriving') ),
					"std" => 'hide',
					"options" => fsdriving_get_list_sidebars(true, true),
					"type" => "select"
					),
				'widgets_below_page_courses' => array(
					"title" => esc_html__('Widgets below the page', 'fsdriving'),
					"desc" => wp_kses_data( __('Select widgets to show below the page (content and sidebar)', 'fsdriving') ),
					"std" => 'hide',
					"options" => fsdriving_get_list_sidebars(true, true),
					"type" => "select"
					),
				'footer_scheme_courses' => array(
					"title" => esc_html__('Footer Color Scheme', 'fsdriving'),
					"desc" => wp_kses_data( __('Select color scheme to decorate footer area', 'fsdriving') ),
					"std" => 'dark',
					"options" => fsdriving_get_list_schemes(true),
					"type" => "select"
					),
				'footer_widgets_courses' => array(
					"title" => esc_html__('Footer widgets', 'fsdriving'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'fsdriving') ),
					"std" => 'footer_widgets',
					"options" => fsdriving_get_list_sidebars(true, true),
					"type" => "select"
					),
				'footer_columns_courses' => array(
					"title" => esc_html__('Footer columns', 'fsdriving'),
					"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'fsdriving') ),
					"dependency" => array(
						'footer_widgets_courses' => array('^hide')
					),
					"std" => 0,
					"options" => fsdriving_get_list_range(0,6),
					"type" => "select"
					),
				'footer_wide_courses' => array(
					"title" => esc_html__('Footer fullwide', 'fsdriving'),
					"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'fsdriving') ),
					"std" => 0,
					"type" => "checkbox"
					)
				)
			);
		}
		
		// Section 'Sport' - settings to show 'Sport' blog archive and single posts
		if (fsdriving_exists_sport()) {
			fsdriving_storage_merge_array('options', '', array(
				'sport' => array(
					"title" => esc_html__('Sport', 'fsdriving'),
					"desc" => wp_kses_data( __('Select parameters to display the sport pages', 'fsdriving') ),
					"type" => "section"
					),
				'expand_content_sport' => array(
					"title" => esc_html__('Expand content', 'fsdriving'),
					"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'fsdriving') ),
					"refresh" => false,
					"std" => 1,
					"type" => "checkbox"
					),
				'header_style_sport' => array(
					"title" => esc_html__('Header style', 'fsdriving'),
					"desc" => wp_kses_data( __('Select style to display the site header on the sport pages', 'fsdriving') ),
					"std" => 'inherit',
					"options" => fsdriving_get_list_header_styles(true),
					"type" => "select"
					),
				'header_position_sport' => array(
					"title" => esc_html__('Header position', 'fsdriving'),
					"desc" => wp_kses_data( __('Select position to display the site header on the sport pages', 'fsdriving') ),
					"std" => 'inherit',
					"options" => fsdriving_get_list_header_positions(true),
					"type" => "select"
					),
				'header_widgets_sport' => array(
					"title" => esc_html__('Header widgets', 'fsdriving'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on the sport pages', 'fsdriving') ),
					"std" => 'hide',
					"options" => fsdriving_get_list_sidebars(true, true),
					"type" => "select"
					),
				'sidebar_widgets_sport' => array(
					"title" => esc_html__('Sidebar widgets', 'fsdriving'),
					"desc" => wp_kses_data( __('Select sidebar to show on the sport pages', 'fsdriving') ),
					"std" => 'hide',
					"options" => fsdriving_get_list_sidebars(true, true),
					"type" => "select"
					),
				'sidebar_position_sport' => array(
					"title" => esc_html__('Sidebar position', 'fsdriving'),
					"desc" => wp_kses_data( __('Select position to show sidebar on the sport pages', 'fsdriving') ),
					"refresh" => false,
					"std" => 'left',
					"options" => fsdriving_get_list_sidebars_positions(true),
					"type" => "select"
					),
				'hide_sidebar_on_single_sport' => array(
					"title" => esc_html__('Hide sidebar on the single course', 'fsdriving'),
					"desc" => wp_kses_data( __("Hide sidebar on the single course's page", 'fsdriving') ),
					"std" => 0,
					"type" => "checkbox"
					),
				'widgets_above_page_sport' => array(
					"title" => esc_html__('Widgets above the page', 'fsdriving'),
					"desc" => wp_kses_data( __('Select widgets to show above page (content and sidebar)', 'fsdriving') ),
					"std" => 'hide',
					"options" => fsdriving_get_list_sidebars(true, true),
					"type" => "select"
					),
				'widgets_above_content_sport' => array(
					"title" => esc_html__('Widgets above the content', 'fsdriving'),
					"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'fsdriving') ),
					"std" => 'hide',
					"options" => fsdriving_get_list_sidebars(true, true),
					"type" => "select"
					),
				'widgets_below_content_sport' => array(
					"title" => esc_html__('Widgets below the content', 'fsdriving'),
					"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'fsdriving') ),
					"std" => 'hide',
					"options" => fsdriving_get_list_sidebars(true, true),
					"type" => "select"
					),
				'widgets_below_page_sport' => array(
					"title" => esc_html__('Widgets below the page', 'fsdriving'),
					"desc" => wp_kses_data( __('Select widgets to show below the page (content and sidebar)', 'fsdriving') ),
					"std" => 'hide',
					"options" => fsdriving_get_list_sidebars(true, true),
					"type" => "select"
					),
				'footer_scheme_sport' => array(
					"title" => esc_html__('Footer Color Scheme', 'fsdriving'),
					"desc" => wp_kses_data( __('Select color scheme to decorate footer area', 'fsdriving') ),
					"std" => 'dark',
					"options" => fsdriving_get_list_schemes(true),
					"type" => "select"
					),
				'footer_widgets_sport' => array(
					"title" => esc_html__('Footer widgets', 'fsdriving'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'fsdriving') ),
					"std" => 'footer_widgets',
					"options" => fsdriving_get_list_sidebars(true, true),
					"type" => "select"
					),
				'footer_columns_sport' => array(
					"title" => esc_html__('Footer columns', 'fsdriving'),
					"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'fsdriving') ),
					"dependency" => array(
						'footer_widgets_sport' => array('^hide')
					),
					"std" => 0,
					"options" => fsdriving_get_list_range(0,6),
					"type" => "select"
					),
				'footer_wide_sport' => array(
					"title" => esc_html__('Footer fullwide', 'fsdriving'),
					"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'fsdriving') ),
					"std" => 0,
					"type" => "checkbox"
					)
				)
			);
		}
	}
}

// Add mobile menu to the plugin's cached menu list
if ( !function_exists( 'fsdriving_trx_addons_menu_cache' ) ) {
	add_filter( 'trx_addons_filter_menu_cache', 'fsdriving_trx_addons_menu_cache');
	function fsdriving_trx_addons_menu_cache($list=array()) {
		if (in_array('#menu_main', $list)) $list[] = '#menu_mobile';
		return $list;
	}
}

// Add vars into localize array
if (!function_exists('fsdriving_trx_addons_localize_script')) {
	add_filter( 'fsdriving_filter_localize_script','fsdriving_trx_addons_localize_script' );
	function fsdriving_trx_addons_localize_script($arr) {
		$arr['alter_link_color'] = fsdriving_get_scheme_color('alter_link');
		return $arr;
	}
}


// Add theme-specific layouts to the list
if (!function_exists('fsdriving_trx_addons_theme_specific_default_layouts')) {
	add_filter( 'trx_addons_filter_default_layouts',	'fsdriving_trx_addons_theme_specific_default_layouts');
	function fsdriving_trx_addons_theme_specific_default_layouts($default_layouts=array()) {
		require_once trailingslashit( get_template_directory() ) . 'theme-specific/trx_addons.layouts.php';
		return isset($layouts) && is_array($layouts) && count($layouts) > 0
						? array_merge($default_layouts, $layouts)
						: $default_layouts;
	}
}

// Disable override header image on team pages
if ( !function_exists( 'fsdriving_trx_addons_allow_override_header_image' ) ) {
	add_filter( 'fsdriving_filter_allow_override_header_image', 'fsdriving_trx_addons_allow_override_header_image' );
	function fsdriving_trx_addons_allow_override_header_image($allow) {
		return fsdriving_is_team_page() || fsdriving_is_portfolio_page() ? false : $allow;
	}
}

// Hide sidebar on the team pages
if ( !function_exists( 'fsdriving_trx_addons_sidebar_present' ) ) {
	add_filter( 'fsdriving_filter_sidebar_present', 'fsdriving_trx_addons_sidebar_present' );
	function fsdriving_trx_addons_sidebar_present($present) {
		return !is_single() && (fsdriving_is_team_page() || fsdriving_is_portfolio_page()) ? false : $present;
	}
}


// WP Editor addons
//------------------------------------------------------------------------
// Theme-specific configure of the WP Editor
if ( !function_exists( 'fsdriving_trx_addons_editor_init' ) ) {
	if (is_admin()) add_filter( 'tiny_mce_before_init', 'fsdriving_trx_addons_editor_init', 11);
	function fsdriving_trx_addons_editor_init($opt) {
		if (fsdriving_exists_trx_addons()) {
			// Add style 'Arrow' to the 'List styles'
			// Remove 'false &&' from condition below to add new style to the list
			if (!empty($opt['style_formats'])) {
				$style_formats = json_decode($opt['style_formats'], true);
				if (is_array($style_formats) && count($style_formats)>0 ) {
					foreach ($style_formats as $k=>$v) {
						if ( $v['title'] == esc_html__('Inline', 'fsdriving') ) {
							$style_formats[$k]['items'][] = array(
										'title' => esc_html__('Accent background alter', 'fsdriving'),
										'inline' => 'span',
										'classes' => 'trx_addons_accent_bg_alter'
									);
						}
						if ( $v['title'] == esc_html__('List styles', 'fsdriving') ) {
							$style_formats[$k]['items'][] = array(
										'title' => esc_html__('Arrow', 'fsdriving'),
										'selector' => 'ul',
										'classes' => 'trx_addons_list trx_addons_list_arrow'
									);
						}
					}

					// List style
					unset($style_formats[2]['items'][1]); // Custom
					unset($style_formats[2]['items'][2]); // Parameters
					unset($style_formats[2]['items'][3]); // Success
					unset($style_formats[2]['items'][4]); // Error
					unset($style_formats[2]['items'][5]); // Info
					unset($style_formats[2]['items'][6]); // Plus
					unset($style_formats[2]['items'][7]); // Minus
					unset($style_formats[2]['items'][8]); // Help
					unset($style_formats[2]['items'][9]); // Attention
					unset($style_formats[2]['items'][10]); // Success (circled)
					unset($style_formats[2]['items'][11]); // Error (circled)
					unset($style_formats[2]['items'][12]); // Info (circled)
					unset($style_formats[2]['items'][13]); // Plus (circled)
					unset($style_formats[2]['items'][14]); // Minus (circled)
					unset($style_formats[2]['items'][15]); // Help (circled)
					unset($style_formats[2]['items'][16]); // Attention (circled)

					// Blockquotes style
					unset($style_formats[1]); // Style
					unset($style_formats[1]['items'][0]); // style 1
					unset($style_formats[1]['items'][1]); // style 2

					// Inline style
					unset($style_formats[3]['items'][2]); // Dark text
					unset($style_formats[3]['items'][3]); // Inverse text
					unset($style_formats[3]['items'][4]); // Big font
					unset($style_formats[3]['items'][5]); // Small font
					unset($style_formats[3]['items'][6]); // Tiny text
					unset($style_formats[3]['items'][7]); // Dropcap 1
					unset($style_formats[3]['items'][8]); // Dropcap 1
					
					$opt['style_formats'] = json_encode( $style_formats );		
				}
			}
		}
		return $opt;
	}
}


// Theme-specific thumb sizes
//------------------------------------------------------------------------

// Replace thumb sizes to the theme-specific
if ( !function_exists( 'fsdriving_trx_addons_add_thumb_sizes' ) ) {
	add_filter( 'trx_addons_filter_add_thumb_sizes', 'fsdriving_trx_addons_add_thumb_sizes');
	function fsdriving_trx_addons_add_thumb_sizes($list=array()) {
		if (is_array($list)) {
			foreach ($list as $k=>$v) {
				if (in_array($k, array(
								'trx_addons-thumb-huge',
								'trx_addons-thumb-big',
								'trx_addons-thumb-medium',
								'trx_addons-thumb-tiny',
								'trx_addons-thumb-masonry-big',
								'trx_addons-thumb-masonry',
								)
							)
						) unset($list[$k]);
			}
		}
		return $list;
	}
}

// Return theme-specific thumb size instead removed plugin's thumb size
if ( !function_exists( 'fsdriving_trx_addons_get_thumb_size' ) ) {
	add_filter( 'trx_addons_filter_get_thumb_size', 'fsdriving_trx_addons_get_thumb_size');
	function fsdriving_trx_addons_get_thumb_size($thumb_size='') {
		return str_replace(array(
							'trx_addons-thumb-huge',
							'trx_addons-thumb-huge-@retina',
							'trx_addons-thumb-big',
							'trx_addons-thumb-big-@retina',
							'trx_addons-thumb-medium',
							'trx_addons-thumb-medium-@retina',
							'trx_addons-thumb-tiny',
							'trx_addons-thumb-tiny-@retina',
							'trx_addons-thumb-masonry-big',
							'trx_addons-thumb-masonry-big-@retina',
							'trx_addons-thumb-masonry',
							'trx_addons-thumb-masonry-@retina',
							),
							array(
							'fsdriving-thumb-huge',
							'fsdriving-thumb-huge-@retina',
							'fsdriving-thumb-big',
							'fsdriving-thumb-big-@retina',
							'fsdriving-thumb-med',
							'fsdriving-thumb-med-@retina',
							'fsdriving-thumb-tiny',
							'fsdriving-thumb-tiny-@retina',
							'fsdriving-thumb-masonry-big',
							'fsdriving-thumb-masonry-big-@retina',
							'fsdriving-thumb-masonry',
							'fsdriving-thumb-masonry-@retina',
							),
							$thumb_size);
	}
}

// Get thumb size for the team items
if ( !function_exists( 'fsdriving_trx_addons_thumb_size' ) ) {
	add_filter( 'trx_addons_filter_thumb_size',	'fsdriving_trx_addons_thumb_size', 10, 2);
	function fsdriving_trx_addons_thumb_size($thumb_size='', $type='') {
		if ($type == 'team-default')
			$thumb_size = fsdriving_get_thumb_size('med');
		return $thumb_size;
	}
}



// Shortcodes support
//------------------------------------------------------------------------

// Return tag for the item's title
if ( !function_exists( 'fsdriving_trx_addons_sc_item_title_tag' ) ) {
	add_filter( 'trx_addons_filter_sc_item_title_tag', 'fsdriving_trx_addons_sc_item_title_tag');
	function fsdriving_trx_addons_sc_item_title_tag($tag='') {
		return $tag=='h1' ? 'h2' : $tag;
	}
}

// Return args for the item's button
if ( !function_exists( 'fsdriving_trx_addons_sc_item_button_args' ) ) {
	add_filter( 'trx_addons_filter_sc_item_button_args', 'fsdriving_trx_addons_sc_item_button_args');
	function fsdriving_trx_addons_sc_item_button_args($args, $sc='') {
		if (false && $sc != 'sc_button') {
			$args['type'] = 'simple';
			$args['icon_type'] = 'fontawesome';
			$args['icon_fontawesome'] = 'icon-down-big';
			$args['icon_position'] = 'top';
		}
		return $args;
	}
}

// Add new types in the shortcodes
if ( !function_exists( 'fsdriving_trx_addons_sc_type' ) ) {
	add_filter( 'trx_addons_sc_type', 'fsdriving_trx_addons_sc_type', 10, 2);
	function fsdriving_trx_addons_sc_type($list, $sc) {
		if ($sc == 'trx_sc_button') {
			$list[esc_html__('Style 2', 'fsdriving')] = 'style_2';
			$list[esc_html__('Style 3', 'fsdriving')] = 'style_3';
		}		
		return $list;
	}
}

// Add new styles to the Google map
if ( !function_exists( 'fsdriving_trx_addons_sc_googlemap_styles' ) ) {
	add_filter( 'trx_addons_filter_sc_googlemap_styles',	'fsdriving_trx_addons_sc_googlemap_styles');
	function fsdriving_trx_addons_sc_googlemap_styles($list) {
		$list[esc_html__('Dark', 'fsdriving')] = 'dark';
		return $list;
	}
}


