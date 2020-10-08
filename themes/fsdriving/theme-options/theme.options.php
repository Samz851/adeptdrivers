<?php
/**
 * Default Theme Options and Internal Theme Settings
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0
 */

// Theme init priorities:
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)

if ( !function_exists('fsdriving_options_theme_setup1') ) {
	add_action( 'after_setup_theme', 'fsdriving_options_theme_setup1', 1 );
	function fsdriving_options_theme_setup1() {
		
		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		fsdriving_storage_set('settings', array(
			
			'ajax_views_counter'		=> true,						// Use AJAX for increment posts counter (if cache plugins used) 
																		// or increment posts counter then loading page (without cache plugin)
			'disable_jquery_ui'			=> false,						// Prevent loading custom jQuery UI libraries in the third-party plugins
		
			'max_load_fonts'			=> 3,							// Max fonts number to load from Google fonts or from uploaded fonts
		
			'use_mediaelements'			=> true,						// Load script "Media Elements" to play video and audio
		
			'max_excerpt_length'		=> 60,							// Max words number for the excerpt in the blog style 'Excerpt'.
																		// For style 'Classic' - get half from this value
			'message_maxlength'			=> 1000							// Max length of the message from contact form
			
		));
		
		
		
		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------
		
		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// For example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		fsdriving_storage_set('load_fonts', array(
			// Google font
			array(
				'name'	 => 'Open Sans',
				'family' => 'sans-serif',
				'styles' => '300,300i,400,400i,600,600i,700,700i,800,800i',		// Parameter 'style' used only for the Google fonts
				),
			array(
				'name'	 => 'Exo',
				'family' => 'sans-serif',
				'styles' => '400,400i,500,500i,600,600i,700,700i'
				)
		));
		
		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		fsdriving_storage_set('load_fonts_subset', 'latin,latin-ext');
		
		// Settings of the main tags
		fsdriving_storage_set('theme_fonts', array(
			'p' => array(
				'title'				=> esc_html__('Main text', 'fsdriving'),
				'description'		=> esc_html__('Font settings of the main text of the site', 'fsdriving'),
				'font-family'		=> 'Open Sans, sans-serif',
				'font-size' 		=> '1em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.72em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '',
				'margin-top'		=> '0',
				'margin-bottom'		=> '1.8em'
				),
			'h1' => array(
				'title'				=> esc_html__('Heading 1', 'fsdriving'),
				'font-family'		=> 'Open Sans, sans-serif',
				'font-size' 		=> '3em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.19em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '',
				'margin-top'		=> '1.35em',
				'margin-bottom'		=> '0.8em'
				),
			'h2' => array(
				'title'				=> esc_html__('Heading 2', 'fsdriving'),
				'font-family'		=> 'Open Sans, sans-serif',
				'font-size' 		=> '2.357em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.454em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '',
				'margin-top'		=> '1.9em',
				'margin-bottom'		=> '0.95em'
				),
			'h3' => array(
				'title'				=> esc_html__('Heading 3', 'fsdriving'),
				'font-family'		=> 'Open Sans, sans-serif',
				'font-size' 		=> '1.857em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.2em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '',
				'margin-top'		=> '1.5em',
				'margin-bottom'		=> '0.55em'
				),
			'h4' => array(
				'title'				=> esc_html__('Heading 4', 'fsdriving'),
				'font-family'		=> 'Open Sans, sans-serif',
				'font-size' 		=> '1.4285em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.3em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '',
				'margin-top'		=> '2.45em',
				'margin-bottom'		=> '1.1em'
				),
			'h5' => array(
				'title'				=> esc_html__('Heading 5', 'fsdriving'),
				'font-family'		=> 'Open Sans, sans-serif',
				'font-size' 		=> '1.2857em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.44em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '',
				'margin-top'		=> '2.4em',
				'margin-bottom'		=> '0.35em'
				),
			'h6' => array(
				'title'				=> esc_html__('Heading 6', 'fsdriving'),
				'font-family'		=> 'Open Sans, sans-serif',
				'font-size' 		=> '1.1428em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '',
				'margin-top'		=> '2.5em',
				'margin-bottom'		=> '0.4em'
				),
			'logo' => array(
				'title'				=> esc_html__('Logo text', 'fsdriving'),
				'description'		=> esc_html__('Font settings of the text case of the logo', 'fsdriving'),
				'font-family'		=> 'Open Sans, sans-serif',
				'font-size' 		=> '1.8em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px'
				),
			'button' => array(
				'title'				=> esc_html__('Buttons', 'fsdriving'),
				'font-family'		=> 'Exo, sans-serif',
				'font-size' 		=> '12px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '2.416em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px'
				),
			'input' => array(
				'title'				=> esc_html__('Input fields', 'fsdriving'),
				'description'		=> esc_html__('Font settings of the input fields, dropdowns and textareas', 'fsdriving'),
				'font-family'		=> 'Open Sans, sans-serif',
				'font-size' 		=> '1em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.2em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0'
				),
			'info' => array(
				'title'				=> esc_html__('Post meta', 'fsdriving'),
				'description'		=> esc_html__('Font settings of the post meta: date, counters, share, etc.', 'fsdriving'),
				'font-family'		=> 'Open Sans, sans-serif',
				'font-size' 		=> '13px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '0.4em',
				'margin-bottom'		=> ''
				),
			'menu' => array(
				'title'				=> esc_html__('Main menu', 'fsdriving'),
				'description'		=> esc_html__('Font settings of the main menu items', 'fsdriving'),
				'font-family'		=> 'Exo, sans-serif',
				'font-size' 		=> '14px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '2.071em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1.5px'
				),
			'submenu' => array(
				'title'				=> esc_html__('Dropdown menu', 'fsdriving'),
				'description'		=> esc_html__('Font settings of the dropdown menu items', 'fsdriving'),
				'font-family'		=> 'Exo, sans-serif',
				'font-size' 		=> '12px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px'
				)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		fsdriving_storage_set('schemes', array(
		
			// Color scheme: 'default'
			'default' => array(
				'title'	 => esc_html__('Default', 'fsdriving'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'				=> '#ffffff',
					'bd_color'				=> '#dcdde0',
		
					// Text and links colors
					'text'					=> '#676770',
					'text_light'			=> '#949494',
					'text_dark'				=> '#282d33',
					'text_link'				=> '#419de6',
					'text_hover'			=> '#2e7eee',
		
					// Alternative blocks (submenu, buttons, tabs, etc.)
					'alter_bg_color'		=> '#f6f7fb',
					'alter_bg_hover'		=> '#1d1d22',
					'alter_bd_color'		=> '#dadada',
					'alter_bd_hover'		=> '#282d33',
					'alter_text'			=> '#a5a6a8',
					'alter_light'			=> '#ffffff',
					'alter_dark'			=> '#1d1d1d',
					'alter_link'			=> '#419de6',
					'alter_hover'			=> '#df172e',
		
					// Input fields (form's fields and textarea)
					'input_bg_color'		=> '#f6f7fb',
					'input_bg_hover'		=> '#f6f7fb',
					'input_bd_color'		=> '#f6f7fb',
					'input_bd_hover'		=> '#dcdde0',
					'input_text'			=> '#949494',
					'input_light'			=> '#dcdde0',
					'input_dark'			=> '#282d33',
					
					// Inverse blocks (text and links on accented bg)
					'inverse_text'			=> '#a5a6a8',
					'inverse_light'			=> '#333333',
					'inverse_dark'			=> '#000000',
					'inverse_link'			=> '#ffffff',
					'inverse_hover'			=> '#1d1d1d',
		
					// Additional accented colors (if used in the current theme)
					// For example:
					'accent2'				=> '#f6b416',
					'accent3'				=> '#419de6',
					'accent4'				=> '#df172e'

				)
			),
		
			// Color scheme: 'dark'
			'dark' => array(
				'title'  => esc_html__('Dark', 'fsdriving'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'				=> '#1d1d22',
					'bd_color'				=> '#4a4a4e',
		
					// Text and links colors
					'text'					=> '#a5a6a8',
					'text_light'			=> '#87888a',
					'text_dark'				=> '#ffffff',
					'text_link'				=> '#ffffff',
					'text_hover'			=> '#419de6',
		
					// Alternative blocks (submenu, buttons, tabs, etc.)
					'alter_bg_color'		=> '#ffffff',
					'alter_bg_hover'		=> '#28272e',
					'alter_bd_color'		=> '#3d3d3d',
					'alter_bd_hover'		=> '#282d33',
					'alter_text'			=> '#333333',
					'alter_light'			=> '#ffffff',
					'alter_dark'			=> '#ffffff',
					'alter_link'			=> '#419de6',
					'alter_hover'			=> '#df172e',
		
					// Input fields (form's fields and textarea)
					'input_bg_color'		=> '#2e2d32',
					'input_bg_hover'		=> '#2e2d32',
					'input_bd_color'		=> '#2e2d32',
					'input_bd_hover'		=> '#353535',
					'input_text'			=> '#b7b7b7',
					'input_light'			=> '#5f5f5f',
					'input_dark'			=> '#ffffff',
					
					// Inverse blocks (text and links on accented bg)
					'inverse_text'			=> '#a5a6a8',
					'inverse_light'			=> '#5f5f5f',
					'inverse_dark'			=> '#000000',
					'inverse_link'			=> '#ffffff',
					'inverse_hover'			=> '#1d1d1d',
				
					// Additional accented colors (if used in the current theme)
					// For example:
					'accent2'				=> '#f6b416',
					'accent3'				=> '#df172e',
					'accent4'				=> '#419de6'
		
				)
			)
		
		));
	}
}


// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if (!function_exists('fsdriving_options_create')) {

	function fsdriving_options_create() {

		fsdriving_storage_set('options', array(
		
			// Section 'Title & Tagline' - add theme options in the standard WP section
			'title_tagline' => array(
				"title" => esc_html__('Title, Tagline & Site icon', 'fsdriving'),
				"desc" => wp_kses_data( __('Specify site title and tagline (if need) and upload the site icon', 'fsdriving') ),
				"type" => "section"
				),
		
		
			// Section 'Header' - add theme options in the standard WP section
			'header_image' => array(
				"title" => esc_html__('Header', 'fsdriving'),
				"desc" => wp_kses_data( __('Select or upload logo images, select header type and widgets set for the header', 'fsdriving') ),
				"type" => "section"
				),
			'header_image_override' => array(
				"title" => esc_html__('Header image override', 'fsdriving'),
				"desc" => wp_kses_data( __("Allow override the header image with the page's/post's/product's/etc. featured image", 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'fsdriving')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'header_fullheight' => array(
				"title" => esc_html__('Header fullheight', 'fsdriving'),
				"desc" => wp_kses_data( __("Enlarge header area to fill whole screen. Used only if header have a background image", 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'fsdriving')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'header_wide' => array(
				"title" => esc_html__('Header fullwide', 'fsdriving'),
				"desc" => wp_kses_data( __('Do you want to stretch the header widgets area to the entire window width?', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'fsdriving')
				),
				"std" => 1,
				"type" => "checkbox"
				),
			'header_style' => array(
				"title" => esc_html__('Header style', 'fsdriving'),
				"desc" => wp_kses_data( __('Select style to display the site header', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'fsdriving')
				),
				"std" => 'header-default',
				"options" => fsdriving_get_list_header_styles(),
				"type" => "select"
				),
			'header_position' => array(
				"title" => esc_html__('Header position', 'fsdriving'),
				"desc" => wp_kses_data( __('Select position to display the site header', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'fsdriving')
				),
				"std" => 'default',
				"options" => fsdriving_get_list_header_positions(),
				"type" => "select"
				),
			'header_widgets' => array(
				"title" => esc_html__('Header widgets', 'fsdriving'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on each page', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'fsdriving'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on this page', 'fsdriving') ),
				),
				"std" => 'hide',
				"options" => fsdriving_get_list_sidebars(false, true),
				"type" => "select"
				),
			'header_columns' => array(
				"title" => esc_html__('Header columns', 'fsdriving'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'fsdriving')
				),
				"dependency" => array(
					'header_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => fsdriving_get_list_range(0,6),
				"type" => "select"
				),
			'header_scheme' => array(
				"title" => esc_html__('Header Color Scheme', 'fsdriving'),
				"desc" => wp_kses_data( __('Select color scheme to decorate header area', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'fsdriving')
				),
				"std" => 'inherit',
				"options" => fsdriving_get_list_schemes(true),
				"refresh" => false,
				"type" => "select"
				),
			'menu_info' => array(
				"title" => esc_html__('Menu settings', 'fsdriving'),
				"desc" => wp_kses_data( __('Select main menu style, position, color scheme and other parameters', 'fsdriving') ),
				"type" => "info"
				),
			'menu_style' => array(
				"title" => esc_html__('Menu position', 'fsdriving'),
				"desc" => wp_kses_data( __('Select position of the main menu', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'fsdriving')
				),
				"std" => 'top',
				"options" => array(
					'top'	=> esc_html__('Top',	'fsdriving'),
					'left'	=> esc_html__('Left',	'fsdriving'),
					'right'	=> esc_html__('Right',	'fsdriving')
				),
				"type" => "switch"
				),
			'menu_scheme' => array(
				"title" => esc_html__('Menu Color Scheme', 'fsdriving'),
				"desc" => wp_kses_data( __('Select color scheme to decorate main menu area', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'fsdriving')
				),
				"std" => 'inherit',
				"options" => fsdriving_get_list_schemes(true),
				"refresh" => false,
				"type" => "select"
				),
			'menu_side_stretch' => array(
				"title" => esc_html__('Stretch sidemenu', 'fsdriving'),
				"desc" => wp_kses_data( __('Stretch sidemenu to window height (if menu items number >= 5)', 'fsdriving') ),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 1,
				"type" => "checkbox"
				),
			'menu_side_icons' => array(
				"title" => esc_html__('Iconed sidemenu', 'fsdriving'),
				"desc" => wp_kses_data( __('Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'fsdriving') ),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 1,
				"type" => "checkbox"
				),
			'menu_mobile_fullscreen' => array(
				"title" => esc_html__('Mobile menu fullscreen', 'fsdriving'),
				"desc" => wp_kses_data( __('Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'fsdriving') ),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 1,
				"type" => "checkbox"
				),
			'logo_info' => array(
				"title" => esc_html__('Logo settings', 'fsdriving'),
				"desc" => wp_kses_data( __('Select logo images for the normal and Retina displays', 'fsdriving') ),
				"type" => "info"
				),
			'logo' => array(
				"title" => esc_html__('Logo', 'fsdriving'),
				"desc" => wp_kses_data( __('Select or upload site logo', 'fsdriving') ),
				"std" => '',
				"type" => "image"
				),
			'logo_retina' => array(
				"title" => esc_html__('Logo for Retina', 'fsdriving'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'fsdriving') ),
				"std" => '',
				"type" => "image"
				),
			'logo_inverse' => array(
				"title" => esc_html__('Logo inverse', 'fsdriving'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it on the dark background', 'fsdriving') ),
				"std" => '',
				"type" => "image"
				),
			'logo_inverse_retina' => array(
				"title" => esc_html__('Logo inverse for Retina', 'fsdriving'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'fsdriving') ),
				"std" => '',
				"type" => "image"
				),
			'logo_side' => array(
				"title" => esc_html__('Logo side', 'fsdriving'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu', 'fsdriving') ),
				"std" => '',
				"type" => "image"
				),
			'logo_side_retina' => array(
				"title" => esc_html__('Logo side for Retina', 'fsdriving'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'fsdriving') ),
				"std" => '',
				"type" => "image"
				),
			'logo_text' => array(
				"title" => esc_html__('Logo from Site name', 'fsdriving'),
				"desc" => wp_kses_data( __('Do you want use Site name and description as Logo if images above are not selected?', 'fsdriving') ),
				"std" => 1,
				"type" => "hidden"
				),
			
		
		
			// Section 'Content'
			'content' => array(
				"title" => esc_html__('Content', 'fsdriving'),
				"desc" => wp_kses_data( __('Options for the content area', 'fsdriving') ),
				"type" => "section",
				),
			'body_style' => array(
				"title" => esc_html__('Body style', 'fsdriving'),
				"desc" => wp_kses_data( __('Select width of the body content', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'fsdriving')
				),
				"refresh" => false,
				"std" => 'wide',
				"options" => array(
					'boxed'		=> esc_html__('Boxed',		'fsdriving'),
					'wide'		=> esc_html__('Wide',		'fsdriving'),
					'fullwide'	=> esc_html__('Fullwide',	'fsdriving'),
					'fullscreen'=> esc_html__('Fullscreen',	'fsdriving')
				),
				"type" => "select"
				),
			'color_scheme' => array(
				"title" => esc_html__('Site Color Scheme', 'fsdriving'),
				"desc" => wp_kses_data( __('Select color scheme to decorate whole site. Attention! Case "Inherit" can be used only for custom pages, not for root site content in the Appearance - Customize', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'fsdriving')
				),
				"std" => 'default',
				"options" => fsdriving_get_list_schemes(true),
				"refresh" => false,
				"type" => "select"
				),
			'expand_content' => array(
				"title" => esc_html__('Expand content', 'fsdriving'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'fsdriving') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'fsdriving')
				),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),
			'remove_margins' => array(
				"title" => esc_html__('Remove margins', 'fsdriving'),
				"desc" => wp_kses_data( __('Remove margins above and below the content area', 'fsdriving') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'fsdriving')
				),
				"refresh" => false,
				"std" => 0,
				"type" => "checkbox"
				),
			'seo_snippets' => array(
				"title" => esc_html__('SEO snippets', 'fsdriving'),
				"desc" => wp_kses_data( __('Add structured data markup to the single posts and pages', 'fsdriving') ),
				"std" => 0,
				"type" => "checkbox"
				),
            'privacy_text' => array(
                "title" => esc_html__("Text with Privacy Policy link", 'fsdriving'),
                "desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'fsdriving') ),
                "std"   => wp_kses_post( __( 'I agree that my submitted data is being collected and stored.', 'fsdriving') ),
                "type"  => "text"
            ),
			'border_radius' => array(
				"title" => esc_html__('Border radius', 'fsdriving'),
				"desc" => wp_kses_data( __('Specify the border radius of the form fields and buttons in pixels or other valid CSS units', 'fsdriving') ),
				"std" => 0,
				"type" => "text"
				),
			'boxed_bg_image' => array(
				"title" => esc_html__('Boxed bg image', 'fsdriving'),
				"desc" => wp_kses_data( __('Select or upload image, used as background in the boxed body', 'fsdriving') ),
				"dependency" => array(
					'body_style' => array('boxed')
				),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'fsdriving')
				),
				"std" => '',
				"type" => "image"
				),
			'no_image' => array(
				"title" => esc_html__('No image placeholder', 'fsdriving'),
				"desc" => wp_kses_data( __('Select or upload image, used as placeholder for the posts without featured image', 'fsdriving') ),
				"std" => '',
				"type" => "image"
				),
			'sidebar_widgets' => array(
				"title" => esc_html__('Sidebar widgets', 'fsdriving'),
				"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'fsdriving') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'fsdriving')
				),
				"std" => 'sidebar_widgets',
				"options" => fsdriving_get_list_sidebars(false, true),
				"type" => "select"
				),
			'sidebar_scheme' => array(
				"title" => esc_html__('Sidebar Color Scheme', 'fsdriving'),
				"desc" => wp_kses_data( __('Select color scheme to decorate sidebar', 'fsdriving') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'fsdriving')
				),
				"std" => 'inherit',
				"options" => fsdriving_get_list_schemes(true),
				"refresh" => false,
				"type" => "select"
				),
			'sidebar_position' => array(
				"title" => esc_html__('Sidebar position', 'fsdriving'),
				"desc" => wp_kses_data( __('Select position to show sidebar', 'fsdriving') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'fsdriving')
				),
				"refresh" => false,
				"std" => 'right',
				"options" => fsdriving_get_list_sidebars_positions(),
				"type" => "select"
				),
			'hide_sidebar_on_single' => array(
				"title" => esc_html__('Hide sidebar on the single post', 'fsdriving'),
				"desc" => wp_kses_data( __("Hide sidebar on the single post's pages", 'fsdriving') ),
				"std" => 0,
				"type" => "checkbox"
				),
			'widgets_above_page' => array(
				"title" => esc_html__('Widgets above the page', 'fsdriving'),
				"desc" => wp_kses_data( __('Select widgets to show above page (content and sidebar)', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Widgets', 'fsdriving')
				),
				"std" => 'hide',
				"options" => fsdriving_get_list_sidebars(false, true),
				"type" => "select"
				),
			'widgets_above_content' => array(
				"title" => esc_html__('Widgets above the content', 'fsdriving'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Widgets', 'fsdriving')
				),
				"std" => 'hide',
				"options" => fsdriving_get_list_sidebars(false, true),
				"type" => "select"
				),
			'widgets_below_content' => array(
				"title" => esc_html__('Widgets below the content', 'fsdriving'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Widgets', 'fsdriving')
				),
				"std" => 'hide',
				"options" => fsdriving_get_list_sidebars(false, true),
				"type" => "select"
				),
			'widgets_below_page' => array(
				"title" => esc_html__('Widgets below the page', 'fsdriving'),
				"desc" => wp_kses_data( __('Select widgets to show below the page (content and sidebar)', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Widgets', 'fsdriving')
				),
				"std" => 'hide',
				"options" => fsdriving_get_list_sidebars(false, true),
				"type" => "select"
				),
		
		
		
			// Section 'Footer'
			'footer' => array(
				"title" => esc_html__('Footer', 'fsdriving'),
				"desc" => wp_kses_data( __('Select set of widgets and columns number for the site footer', 'fsdriving') ),
				"type" => "section"
				),
			'footer_style' => array(
				"title" => esc_html__('Footer style', 'fsdriving'),
				"desc" => wp_kses_data( __('Select style to display the site footer', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Footer', 'fsdriving')
				),
				"std" => 'footer-default',
				"options" => apply_filters('fsdriving_filter_list_footer_styles', array(
					'footer-default' => esc_html__('Default Footer',	'fsdriving')
				)),
				"type" => "select"
				),
			'footer_scheme' => array(
				"title" => esc_html__('Footer Color Scheme', 'fsdriving'),
				"desc" => wp_kses_data( __('Select color scheme to decorate footer area', 'fsdriving') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'fsdriving')
				),
				"std" => 'dark',
				"options" => fsdriving_get_list_schemes(true),
				"refresh" => false,
				"type" => "select"
				),
			'footer_widgets' => array(
				"title" => esc_html__('Footer widgets', 'fsdriving'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'fsdriving') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'fsdriving')
				),
				"std" => 'footer_widgets',
				"options" => fsdriving_get_list_sidebars(false, true),
				"type" => "select"
				),
			'footer_columns' => array(
				"title" => esc_html__('Footer columns', 'fsdriving'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'fsdriving') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'fsdriving')
				),
				"dependency" => array(
					'footer_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => fsdriving_get_list_range(0,6),
				"type" => "select"
				),
			'footer_wide' => array(
				"title" => esc_html__('Footer fullwide', 'fsdriving'),
				"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'fsdriving') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'fsdriving')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_in_footer' => array(
				"title" => esc_html__('Show logo', 'fsdriving'),
				"desc" => wp_kses_data( __('Show logo in the footer', 'fsdriving') ),
				'refresh' => false,
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_footer' => array(
				"title" => esc_html__('Logo for footer', 'fsdriving'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the footer', 'fsdriving') ),
				"dependency" => array(
					'logo_in_footer' => array('1')
				),
				"std" => '',
				"type" => "image"
				),
			'logo_footer_retina' => array(
				"title" => esc_html__('Logo for footer (Retina)', 'fsdriving'),
				"desc" => wp_kses_data( __('Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'fsdriving') ),
				"dependency" => array(
					'logo_in_footer' => array('1')
				),
				"std" => '',
				"type" => "image"
				),
			'socials_in_footer' => array(
				"title" => esc_html__('Show social icons', 'fsdriving'),
				"desc" => wp_kses_data( __('Show social icons in the footer (under logo or footer widgets)', 'fsdriving') ),
				"std" => 0,
				"type" => "checkbox"
				),
			'copyright' => array(
				"title" => esc_html__('Copyright', 'fsdriving'),
				"desc" => wp_kses_data( __('Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'fsdriving') ),
				"std" => esc_html__('ThemeREX &copy; {Y}. All rights reserved. Terms of use and Privacy Policy', 'fsdriving'),
				"refresh" => false,
				"type" => "textarea"
				),
		
		
		
			// Section 'Homepage' - settings for home page
			'homepage' => array(
				"title" => esc_html__('Homepage', 'fsdriving'),
				"desc" => wp_kses_data( __('Select blog style and widgets to display on the homepage', 'fsdriving') ),
				"type" => "section"
				),
			'expand_content_home' => array(
				"title" => esc_html__('Expand content', 'fsdriving'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden on the Homepage', 'fsdriving') ),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),
			'blog_style_home' => array(
				"title" => esc_html__('Blog style', 'fsdriving'),
				"desc" => wp_kses_data( __('Select posts style for the homepage', 'fsdriving') ),
				"std" => 'excerpt',
				"options" => fsdriving_get_list_blog_styles(),
				"type" => "select"
				),
			'first_post_large_home' => array(
				"title" => esc_html__('First post large', 'fsdriving'),
				"desc" => wp_kses_data( __('Make first post large (with Excerpt layout) on the Classic layout of the Homepage', 'fsdriving') ),
				"dependency" => array(
					'blog_style_home' => array('classic')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'header_style_home' => array(
				"title" => esc_html__('Header style', 'fsdriving'),
				"desc" => wp_kses_data( __('Select style to display the site header on the homepage', 'fsdriving') ),
				"std" => 'inherit',
				"options" => fsdriving_get_list_header_styles(true),
				"type" => "select"
				),
			'header_position_home' => array(
				"title" => esc_html__('Header position', 'fsdriving'),
				"desc" => wp_kses_data( __('Select position to display the site header on the homepage', 'fsdriving') ),
				"std" => 'inherit',
				"options" => fsdriving_get_list_header_positions(true),
				"type" => "select"
				),
			'header_widgets_home' => array(
				"title" => esc_html__('Header widgets', 'fsdriving'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on the homepage', 'fsdriving') ),
				"std" => 'header_widgets',
				"options" => fsdriving_get_list_sidebars(true, true),
				"type" => "select"
				),
			'sidebar_widgets_home' => array(
				"title" => esc_html__('Sidebar widgets', 'fsdriving'),
				"desc" => wp_kses_data( __('Select sidebar to show on the homepage', 'fsdriving') ),
				"std" => 'inherit',
				"options" => fsdriving_get_list_sidebars(true, true),
				"type" => "select"
				),
			'sidebar_position_home' => array(
				"title" => esc_html__('Sidebar position', 'fsdriving'),
				"desc" => wp_kses_data( __('Select position to show sidebar on the homepage', 'fsdriving') ),
				"refresh" => false,
				"std" => 'inherit',
				"options" => fsdriving_get_list_sidebars_positions(true),
				"type" => "select"
				),
			'widgets_above_page_home' => array(
				"title" => esc_html__('Widgets above the page', 'fsdriving'),
				"desc" => wp_kses_data( __('Select widgets to show above page (content and sidebar)', 'fsdriving') ),
				"std" => 'hide',
				"options" => fsdriving_get_list_sidebars(true, true),
				"type" => "select"
				),
			'widgets_above_content_home' => array(
				"title" => esc_html__('Widgets above the content', 'fsdriving'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'fsdriving') ),
				"std" => 'hide',
				"options" => fsdriving_get_list_sidebars(true, true),
				"type" => "select"
				),
			'widgets_below_content_home' => array(
				"title" => esc_html__('Widgets below the content', 'fsdriving'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'fsdriving') ),
				"std" => 'hide',
				"options" => fsdriving_get_list_sidebars(true, true),
				"type" => "select"
				),
			'widgets_below_page_home' => array(
				"title" => esc_html__('Widgets below the page', 'fsdriving'),
				"desc" => wp_kses_data( __('Select widgets to show below the page (content and sidebar)', 'fsdriving') ),
				"std" => 'hide',
				"options" => fsdriving_get_list_sidebars(true, true),
				"type" => "select"
				),
			
		
		
			// Section 'Blog archive'
			'blog' => array(
				"title" => esc_html__('Blog archive', 'fsdriving'),
				"desc" => wp_kses_data( __('Options for the blog archive', 'fsdriving') ),
				"type" => "section",
				),
			'expand_content_blog' => array(
				"title" => esc_html__('Expand content', 'fsdriving'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden on the blog archive', 'fsdriving') ),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),
			'blog_style' => array(
				"title" => esc_html__('Blog style', 'fsdriving'),
				"desc" => wp_kses_data( __('Select posts style for the blog archive', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'fsdriving')
				),
				"dependency" => array(
                    '#page_template' => array( 'blog.php' ),
                    '.editor-page-attributes__template select' => array( 'blog.php' )
				),
				"std" => 'excerpt',
				"options" => fsdriving_get_list_blog_styles(),
				"type" => "select"
				),
			'blog_columns' => array(
				"title" => esc_html__('Blog columns', 'fsdriving'),
				"desc" => wp_kses_data( __('How many columns should be used in the blog archive (from 2 to 4)?', 'fsdriving') ),
				"std" => 2,
				"options" => fsdriving_get_list_range(2,4),
				"type" => "hidden"
				),
			'post_type' => array(
				"title" => esc_html__('Post type', 'fsdriving'),
				"desc" => wp_kses_data( __('Select post type to show in the blog archive', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'fsdriving')
				),
				"dependency" => array(
                    '#page_template' => array( 'blog.php' ),
                    '.editor-page-attributes__template select' => array( 'blog.php' )
				),
				"linked" => 'parent_cat',
				"refresh" => false,
				"hidden" => true,
				"std" => 'post',
				"options" => fsdriving_get_list_posts_types(),
				"type" => "select"
				),
			'parent_cat' => array(
				"title" => esc_html__('Category to show', 'fsdriving'),
				"desc" => wp_kses_data( __('Select category to show in the blog archive', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'fsdriving')
				),
				"dependency" => array(
                    '#page_template' => array( 'blog.php' ),
                    '.editor-page-attributes__template select' => array( 'blog.php' )
				),
				"refresh" => false,
				"hidden" => true,
				"std" => '0',
				"options" => fsdriving_array_merge(array(0 => esc_html__('- Select category -', 'fsdriving')), fsdriving_get_list_categories()),
				"type" => "select"
				),
			'posts_per_page' => array(
				"title" => esc_html__('Posts per page', 'fsdriving'),
				"desc" => wp_kses_data( __('How many posts will be displayed on this page', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'fsdriving')
				),
				"dependency" => array(
                    '#page_template' => array( 'blog.php' ),
                    '.editor-page-attributes__template select' => array( 'blog.php' )
				),
				"hidden" => true,
				"std" => '10',
				"type" => "text"
				),
			"blog_pagination" => array( 
				"title" => esc_html__('Pagination style', 'fsdriving'),
				"desc" => wp_kses_data( __('Show Older/Newest posts or Page numbers below the posts list', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'fsdriving')
				),
				"std" => "pages",
				"options" => array(
					'pages'	=> esc_html__("Page numbers", 'fsdriving')
				),
				"type" => "select"
				),
			'show_filters' => array(
				"title" => esc_html__('Show filters', 'fsdriving'),
				"desc" => wp_kses_data( __('Show categories as tabs to filter posts', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'fsdriving')
				),
				"dependency" => array(
                    '#page_template' => array( 'blog.php' ),
                    '.editor-page-attributes__template select' => array( 'blog.php' ),
					'blog_style' => array('portfolio', 'gallery')
				),
				"hidden" => true,
				"std" => 0,
				"type" => "checkbox"
				),
			'first_post_large' => array(
				"title" => esc_html__('First post large', 'fsdriving'),
				"desc" => wp_kses_data( __('Make first post large (with Excerpt layout) on the Classic layout of blog archive', 'fsdriving') ),
				"dependency" => array(
					'blog_style' => array('classic')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			"blog_content" => array( 
				"title" => esc_html__('Posts content', 'fsdriving'),
				"desc" => wp_kses_data( __("Show full post's content in the blog or only post's excerpt", 'fsdriving') ),
				"std" => "excerpt",
				"options" => array(
					'excerpt'	=> esc_html__('Excerpt',	'fsdriving'),
					'fullpost'	=> esc_html__('Full post',	'fsdriving')
				),
				"type" => "select"
				),
			'time_diff_before' => array(
				"title" => esc_html__('Time difference', 'fsdriving'),
				"desc" => wp_kses_data( __("How many days show time difference instead post's date", 'fsdriving') ),
				"std" => 5,
				"type" => "text"
				),
			'related_posts' => array(
				"title" => esc_html__('Related posts', 'fsdriving'),
				"desc" => wp_kses_data( __('How many related posts should be displayed in the single post?', 'fsdriving') ),
				"std" => 2,
				"options" => fsdriving_get_list_range(2,4),
				"type" => "hidden"
				),
			'related_style' => array(
				"title" => esc_html__('Related posts style', 'fsdriving'),
				"desc" => wp_kses_data( __('Select style of the related posts output', 'fsdriving') ),
				"std" => 1,
				"options" => fsdriving_get_list_styles(1,2),
				"type" => "hidden"
				),
			"blog_animation" => array( 
				"title" => esc_html__('Animation for the posts', 'fsdriving'),
				"desc" => wp_kses_data( __('Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'fsdriving')
				),
				"dependency" => array(
                    '#page_template' => array( 'blog.php' ),
                    '.editor-page-attributes__template select' => array( 'blog.php' )
				),
				"std" => "none",
				"options" => fsdriving_get_list_animations_in(),
				"type" => "select"
				),
			'header_style_blog' => array(
				"title" => esc_html__('Header style', 'fsdriving'),
				"desc" => wp_kses_data( __('Select style to display the site header on the blog archive', 'fsdriving') ),
				"std" => 'inherit',
				"options" => fsdriving_get_list_header_styles(true),
				"type" => "select"
				),
			'header_position_blog' => array(
				"title" => esc_html__('Header position', 'fsdriving'),
				"desc" => wp_kses_data( __('Select position to display the site header on the blog archive', 'fsdriving') ),
				"std" => 'inherit',
				"options" => fsdriving_get_list_header_positions(true),
				"type" => "select"
				),
			'header_widgets_blog' => array(
				"title" => esc_html__('Header widgets', 'fsdriving'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on the blog archive', 'fsdriving') ),
				"std" => 'inherit',
				"options" => fsdriving_get_list_sidebars(true, true),
				"type" => "select"
				),
			'sidebar_widgets_blog' => array(
				"title" => esc_html__('Sidebar widgets', 'fsdriving'),
				"desc" => wp_kses_data( __('Select sidebar to show on the blog archive', 'fsdriving') ),
				"std" => 'inherit',
				"options" => fsdriving_get_list_sidebars(true, true),
				"type" => "select"
				),
			'sidebar_position_blog' => array(
				"title" => esc_html__('Sidebar position', 'fsdriving'),
				"desc" => wp_kses_data( __('Select position to show sidebar on the blog archive', 'fsdriving') ),
				"refresh" => false,
				"std" => 'inherit',
				"options" => fsdriving_get_list_sidebars_positions(true),
				"type" => "select"
				),
			'hide_sidebar_on_single_blog' => array(
				"title" => esc_html__('Hide sidebar on the single post', 'fsdriving'),
				"desc" => wp_kses_data( __("Hide sidebar on the single post", 'fsdriving') ),
				"std" => 0,
				"type" => "checkbox"
				),
			'widgets_above_page_blog' => array(
				"title" => esc_html__('Widgets above the page', 'fsdriving'),
				"desc" => wp_kses_data( __('Select widgets to show above page (content and sidebar)', 'fsdriving') ),
				"std" => 'inherit',
				"options" => fsdriving_get_list_sidebars(true, true),
				"type" => "select"
				),
			'widgets_above_content_blog' => array(
				"title" => esc_html__('Widgets above the content', 'fsdriving'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'fsdriving') ),
				"std" => 'inherit',
				"options" => fsdriving_get_list_sidebars(true, true),
				"type" => "select"
				),
			'widgets_below_content_blog' => array(
				"title" => esc_html__('Widgets below the content', 'fsdriving'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'fsdriving') ),
				"std" => 'inherit',
				"options" => fsdriving_get_list_sidebars(true, true),
				"type" => "select"
				),
			'widgets_below_page_blog' => array(
				"title" => esc_html__('Widgets below the page', 'fsdriving'),
				"desc" => wp_kses_data( __('Select widgets to show below the page (content and sidebar)', 'fsdriving') ),
				"std" => 'inherit',
				"options" => fsdriving_get_list_sidebars(true, true),
				"type" => "select"
				),
			
		
		
		
			// Section 'Colors' - choose color scheme and customize separate colors from it
			'scheme' => array(
				"title" => esc_html__('* Color scheme editor', 'fsdriving'),
				"desc" => wp_kses_data( __("<b>Simple settings</b> - you can change only accented color, used for links, buttons and some accented areas.", 'fsdriving') )
						. '<br>'
						. wp_kses_data( __("<b>Advanced settings</b> - change all scheme's colors and get full control over the appearance of your site!", 'fsdriving') ),
				"priority" => 1000,
				"type" => "section"
				),
		
			'color_settings' => array(
				"title" => esc_html__('Color settings', 'fsdriving'),
				"desc" => '',
				"std" => 'simple',
				"options" => array(
					"simple"  => esc_html__("Simple", 'fsdriving'),
					"advanced" => esc_html__("Advanced", 'fsdriving')
				),
				"refresh" => false,
				"type" => "switch"
				),
		
			'color_scheme_editor' => array(
				"title" => esc_html__('Color Scheme', 'fsdriving'),
				"desc" => wp_kses_data( __('Select color scheme to edit colors', 'fsdriving') ),
				"std" => 'default',
				"options" => fsdriving_get_list_schemes(),
				"refresh" => false,
				"type" => "select"
				),
		
			'scheme_storage' => array(
				"title" => esc_html__('Colors storage', 'fsdriving'),
				"desc" => esc_html__('Hidden storage of the all color from the all color shemes (only for internal usage)', 'fsdriving'),
				"std" => '',
				"refresh" => false,
				"type" => "hidden"
				),
		
			'scheme_info_single' => array(
				"title" => esc_html__('Colors for single post/page', 'fsdriving'),
				"desc" => wp_kses_data( __('Specify colors for single post/page (not for alter blocks)', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"type" => "info"
				),
				
			'bg_color' => array(
				"title" => esc_html__('Background color', 'fsdriving'),
				"desc" => wp_kses_data( __('Background color of the whole page', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'bd_color' => array(
				"title" => esc_html__('Border color', 'fsdriving'),
				"desc" => wp_kses_data( __('Color of the bordered elements, separators, etc.', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
		
			'text' => array(
				"title" => esc_html__('Text', 'fsdriving'),
				"desc" => wp_kses_data( __('Plain text color on single page/post', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'text_light' => array(
				"title" => esc_html__('Light text', 'fsdriving'),
				"desc" => wp_kses_data( __('Color of the post meta: post date and author, comments number, etc.', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'text_dark' => array(
				"title" => esc_html__('Dark text', 'fsdriving'),
				"desc" => wp_kses_data( __('Color of the headers, strong text, etc.', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'text_link' => array(
				"title" => esc_html__('Links', 'fsdriving'),
				"desc" => wp_kses_data( __('Color of links and accented areas', 'fsdriving') ),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'text_hover' => array(
				"title" => esc_html__('Links hover', 'fsdriving'),
				"desc" => wp_kses_data( __('Hover color for links and accented areas', 'fsdriving') ),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
		
			'scheme_info_alter' => array(
				"title" => esc_html__('Colors for alternative blocks', 'fsdriving'),
				"desc" => wp_kses_data( __('Specify colors for alternative blocks - rectangular blocks with its own background color (posts in homepage, blog archive, search results, widgets on sidebar, footer, etc.)', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"type" => "info"
				),
		
			'alter_bg_color' => array(
				"title" => esc_html__('Alter background color', 'fsdriving'),
				"desc" => wp_kses_data( __('Background color of the alternative blocks', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'alter_bg_hover' => array(
				"title" => esc_html__('Alter hovered background color', 'fsdriving'),
				"desc" => wp_kses_data( __('Background color for the hovered state of the alternative blocks', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'alter_bd_color' => array(
				"title" => esc_html__('Alternative border color', 'fsdriving'),
				"desc" => wp_kses_data( __('Border color of the alternative blocks', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'alter_bd_hover' => array(
				"title" => esc_html__('Alternative hovered border color', 'fsdriving'),
				"desc" => wp_kses_data( __('Border color for the hovered state of the alter blocks', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'alter_text' => array(
				"title" => esc_html__('Alter text', 'fsdriving'),
				"desc" => wp_kses_data( __('Text color of the alternative blocks', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'alter_light' => array(
				"title" => esc_html__('Alter light', 'fsdriving'),
				"desc" => wp_kses_data( __('Color of the info blocks inside block with alternative background', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'alter_dark' => array(
				"title" => esc_html__('Alter dark', 'fsdriving'),
				"desc" => wp_kses_data( __('Color of the headers inside block with alternative background', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'alter_link' => array(
				"title" => esc_html__('Alter link', 'fsdriving'),
				"desc" => wp_kses_data( __('Color of the links inside block with alternative background', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'alter_hover' => array(
				"title" => esc_html__('Alter hover', 'fsdriving'),
				"desc" => wp_kses_data( __('Color of the hovered links inside block with alternative background', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
		
			'scheme_info_input' => array(
				"title" => esc_html__('Colors for the form fields', 'fsdriving'),
				"desc" => wp_kses_data( __('Specify colors for the form fields and textareas', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"type" => "info"
				),
		
			'input_bg_color' => array(
				"title" => esc_html__('Inactive background', 'fsdriving'),
				"desc" => wp_kses_data( __('Background color of the inactive form fields', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'input_bg_hover' => array(
				"title" => esc_html__('Active background', 'fsdriving'),
				"desc" => wp_kses_data( __('Background color of the focused form fields', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'input_bd_color' => array(
				"title" => esc_html__('Inactive border', 'fsdriving'),
				"desc" => wp_kses_data( __('Color of the border in the inactive form fields', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'input_bd_hover' => array(
				"title" => esc_html__('Active border', 'fsdriving'),
				"desc" => wp_kses_data( __('Color of the border in the focused form fields', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'input_text' => array(
				"title" => esc_html__('Inactive field', 'fsdriving'),
				"desc" => wp_kses_data( __('Color of the text in the inactive fields', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'input_light' => array(
				"title" => esc_html__('Disabled field', 'fsdriving'),
				"desc" => wp_kses_data( __('Color of the disabled field', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'input_dark' => array(
				"title" => esc_html__('Active field', 'fsdriving'),
				"desc" => wp_kses_data( __('Color of the active field', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
		
			'scheme_info_inverse' => array(
				"title" => esc_html__('Colors for inverse blocks', 'fsdriving'),
				"desc" => wp_kses_data( __('Specify colors for inverse blocks, rectangular blocks with background color equal to the links color or one of accented colors (if used in the current theme)', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"type" => "info"
				),
		
			'inverse_text' => array(
				"title" => esc_html__('Inverse text', 'fsdriving'),
				"desc" => wp_kses_data( __('Color of the text inside block with accented background', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'inverse_light' => array(
				"title" => esc_html__('Inverse light', 'fsdriving'),
				"desc" => wp_kses_data( __('Color of the info blocks inside block with accented background', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'inverse_dark' => array(
				"title" => esc_html__('Inverse dark', 'fsdriving'),
				"desc" => wp_kses_data( __('Color of the headers inside block with accented background', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'inverse_link' => array(
				"title" => esc_html__('Inverse link', 'fsdriving'),
				"desc" => wp_kses_data( __('Color of the links inside block with accented background', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'inverse_hover' => array(
				"title" => esc_html__('Inverse hover', 'fsdriving'),
				"desc" => wp_kses_data( __('Color of the hovered links inside block with accented background', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'accent2' => array(
				"title" => esc_html__('Accent 2', 'fsdriving'),
				"desc" => wp_kses_data( __('Accent 2 color', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'accent3' => array(
				"title" => esc_html__('Accent 3', 'fsdriving'),
				"desc" => wp_kses_data( __('Accent 3 color', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),
			'accent4' => array(
				"title" => esc_html__('Accent 4', 'fsdriving'),
				"desc" => wp_kses_data( __('Accent 4 color', 'fsdriving') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"std" => '$fsdriving_get_scheme_color',
				"refresh" => false,
				"type" => "color"
				),


			// Section 'Hidden'
			'post_icon' => array(
				"title" => esc_html__('Post icon', 'fsdriving'),
				"desc" => wp_kses_data( __('Used in a blogger classic layout', 'fsdriving') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Title', 'fsdriving')
				),
				"hidden" => true,
				"std" => '',
				"type" => "icon"
				),
			'media_title' => array(
				"title" => esc_html__('Media title', 'fsdriving'),
				"desc" => wp_kses_data( __('Used as title for the audio and video item in this post', 'fsdriving') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Title', 'fsdriving')
				),
				"hidden" => true,
				"std" => '',
				"type" => "text"
				),
			'media_author' => array(
				"title" => esc_html__('Media author', 'fsdriving'),
				"desc" => wp_kses_data( __('Used as author name for the audio and video item in this post', 'fsdriving') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Title', 'fsdriving')
				),
				"hidden" => true,
				"std" => '',
				"type" => "text"
				),


			// Internal options.
			// Attention! Don't change any options in the section below!
			'reset_options' => array(
				"title" => '',
				"desc" => '',
				"std" => '0',
				"type" => "hidden",
				),

		));


		// Prepare panel 'Fonts'
		$fonts = array(
		
			// Panel 'Fonts' - manage fonts loading and set parameters of the base theme elements
			'fonts' => array(
				"title" => esc_html__('* Fonts settings', 'fsdriving'),
				"desc" => '',
				"priority" => 1500,
				"type" => "panel"
				),

			// Section 'Load_fonts'
			'load_fonts' => array(
				"title" => esc_html__('Load fonts', 'fsdriving'),
				"desc" => wp_kses_data( __('Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'fsdriving') )
						. '<br>'
						. wp_kses_data( __('<b>Attention!</b> Press "Refresh" button to reload preview area after the all fonts are changed', 'fsdriving') ),
				"type" => "section"
				),
			'load_fonts_subset' => array(
				"title" => esc_html__('Google fonts subsets', 'fsdriving'),
				"desc" => wp_kses_data( __('Specify comma separated list of the subsets which will be load from Google fonts', 'fsdriving') )
						. '<br>'
						. wp_kses_data( __('Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'fsdriving') ),
				"refresh" => false,
				"std" => '$fsdriving_get_load_fonts_subset',
				"type" => "text"
				)
		);

		for ($i=1; $i<=fsdriving_get_theme_setting('max_load_fonts'); $i++) {
			$fonts["load_fonts-{$i}-info"] = array(
				"title" => esc_html(sprintf(esc_html__('Font %s', 'fsdriving'), $i)),
				"desc" => '',
				"type" => "info",
				);
			$fonts["load_fonts-{$i}-name"] = array(
				"title" => esc_html__('Font name', 'fsdriving'),
				"desc" => '',
				"refresh" => false,
				"std" => '$fsdriving_get_load_fonts_option',
				"type" => "text"
				);
			$fonts["load_fonts-{$i}-family"] = array(
				"title" => esc_html__('Font family', 'fsdriving'),
				"desc" => $i==1 
							? wp_kses_data( __('Select font family to use it if font above is not available', 'fsdriving') )
							: '',
				"refresh" => false,
				"std" => '$fsdriving_get_load_fonts_option',
				"options" => array(
					'inherit' => esc_html__("Inherit", 'fsdriving'),
					'serif' => esc_html__('serif', 'fsdriving'),
					'sans-serif' => esc_html__('sans-serif', 'fsdriving'),
					'monospace' => esc_html__('monospace', 'fsdriving'),
					'cursive' => esc_html__('cursive', 'fsdriving'),
					'fantasy' => esc_html__('fantasy', 'fsdriving')
				),
				"type" => "select"
				);
			$fonts["load_fonts-{$i}-styles"] = array(
				"title" => esc_html__('Font styles', 'fsdriving'),
				"desc" => $i==1 
							? wp_kses_data( __('Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'fsdriving') )
											. '<br>'
								. wp_kses_data( __('<b>Attention!</b> Each weight and style increase download size! Specify only used weights and styles.', 'fsdriving') )
							: '',
				"refresh" => false,
				"std" => '$fsdriving_get_load_fonts_option',
				"type" => "text"
				);
		}
		$fonts['load_fonts_end'] = array(
			"type" => "section_end"
			);

		// Sections with font's attributes for each theme element
		$theme_fonts = fsdriving_get_theme_fonts();
		foreach ($theme_fonts as $tag=>$v) {
			$fonts["{$tag}_section"] = array(
				"title" => !empty($v['title']) 
								? $v['title'] 
								: esc_html(sprintf(esc_html__('%s settings', 'fsdriving'), $tag)),
				"desc" => !empty($v['description']) 
								? $v['description'] 
								: wp_kses_post( sprintf(__('Font settings of the "%s" tag.', 'fsdriving'), $tag) ),
				"type" => "section",
				);
	
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				$options = '';
				$type = 'text';
				$title = ucfirst(str_replace('-', ' ', $css_prop));
				if ($css_prop == 'font-family') {
					$type = 'select';
					$options = fsdriving_get_list_load_fonts(true);
				} else if ($css_prop == 'font-weight') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'fsdriving'),
						'100' => esc_html__('100 (Light)', 'fsdriving'), 
						'200' => esc_html__('200 (Light)', 'fsdriving'), 
						'300' => esc_html__('300 (Thin)',  'fsdriving'),
						'400' => esc_html__('400 (Normal)', 'fsdriving'),
						'500' => esc_html__('500 (Semibold)', 'fsdriving'),
						'600' => esc_html__('600 (Semibold)', 'fsdriving'),
						'700' => esc_html__('700 (Bold)', 'fsdriving'),
						'800' => esc_html__('800 (Black)', 'fsdriving'),
						'900' => esc_html__('900 (Black)', 'fsdriving')
					);
				} else if ($css_prop == 'font-style') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'fsdriving'),
						'normal' => esc_html__('Normal', 'fsdriving'), 
						'italic' => esc_html__('Italic', 'fsdriving')
					);
				} else if ($css_prop == 'text-decoration') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'fsdriving'),
						'none' => esc_html__('None', 'fsdriving'), 
						'underline' => esc_html__('Underline', 'fsdriving'),
						'overline' => esc_html__('Overline', 'fsdriving'),
						'line-through' => esc_html__('Line-through', 'fsdriving')
					);
				} else if ($css_prop == 'text-transform') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'fsdriving'),
						'none' => esc_html__('None', 'fsdriving'), 
						'uppercase' => esc_html__('Uppercase', 'fsdriving'),
						'lowercase' => esc_html__('Lowercase', 'fsdriving'),
						'capitalize' => esc_html__('Capitalize', 'fsdriving')
					);
				}
				$fonts["{$tag}_{$css_prop}"] = array(
					"title" => $title,
					"desc" => '',
					"refresh" => false,
					"std" => '$fsdriving_get_theme_fonts_option',
					"options" => $options,
					"type" => $type
				);
			}
			
			$fonts["{$tag}_section_end"] = array(
				"type" => "section_end"
				);
		}

		$fonts['fonts_end'] = array(
			"type" => "panel_end"
			);

		// Add fonts parameters into Theme Options
		fsdriving_storage_merge_array('options', '', $fonts);

		// Add Header Video if WP version < 4.7
		if (!function_exists('get_header_video_url')) {
			fsdriving_storage_set_array_after('options', 'header_image_override', 'header_video', array(
				"title" => esc_html__('Header video', 'fsdriving'),
				"desc" => wp_kses_data( __("Select video to use it as background for the header", 'fsdriving') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'fsdriving')
				),
				"std" => '',
				"type" => "video"
				)
			);
		}
	}
}




// -----------------------------------------------------------------
// -- Create and manage Theme Options
// -----------------------------------------------------------------

// Theme init priorities:
// 2 - create Theme Options
if (!function_exists('fsdriving_options_theme_setup2')) {
	add_action( 'after_setup_theme', 'fsdriving_options_theme_setup2', 2 );
	function fsdriving_options_theme_setup2() {
		fsdriving_options_create();
	}
}

// Step 1: Load default settings and previously saved mods
if (!function_exists('fsdriving_options_theme_setup5')) {
	add_action( 'after_setup_theme', 'fsdriving_options_theme_setup5', 5 );
	function fsdriving_options_theme_setup5() {
		fsdriving_storage_set('options_reloaded', false);
		fsdriving_load_theme_options();
	}
}

// Step 2: Load current theme customization mods
if (is_customize_preview()) {
	if (!function_exists('fsdriving_load_custom_options')) {
		add_action( 'wp_loaded', 'fsdriving_load_custom_options' );
		function fsdriving_load_custom_options() {
			if (!fsdriving_storage_get('options_reloaded')) {
				fsdriving_storage_set('options_reloaded', true);
				fsdriving_load_theme_options();
			}
		}
	}
}

// Load current values for each customizable option
if ( !function_exists('fsdriving_load_theme_options') ) {
	function fsdriving_load_theme_options() {
		$options = fsdriving_storage_get('options');
		$reset = (int) get_theme_mod('reset_options', 0);
		foreach ($options as $k=>$v) {
			if (isset($v['std'])) {
				if (strpos($v['std'], '$fsdriving_')!==false) {
					$func = substr($v['std'], 1);
					if (function_exists($func)) {
						$v['std'] = $func($k);
					}
				}
				$value = $v['std'];
				if (!$reset) {
					if (isset($_GET[$k]))
						$value = $_GET[$k];
					else {
						$tmp = get_theme_mod($k, -987654321);
						if ($tmp != -987654321) $value = $tmp;
					}
				}
				fsdriving_storage_set_array2('options', $k, 'val', $value);
				if ($reset) remove_theme_mod($k);
			}
		}
		if ($reset) {
			// Unset reset flag
			set_theme_mod('reset_options', 0);
			// Regenerate CSS with default colors and fonts
			fsdriving_customizer_save_css();
		} else {
			do_action('fsdriving_action_load_options');
		}
	}
}

// Override options with stored page/post meta
if ( !function_exists('fsdriving_override_theme_options') ) {
	add_action( 'wp', 'fsdriving_override_theme_options', 1 );
	function fsdriving_override_theme_options($query=null) {
		if (is_page_template('blog.php')) {
			fsdriving_storage_set('blog_archive', true);
			fsdriving_storage_set('blog_template', get_the_ID());
		}
		fsdriving_storage_set('blog_mode', fsdriving_detect_blog_mode());
		if (is_singular()) {
			fsdriving_storage_set('options_meta', get_post_meta(get_the_ID(), 'fsdriving_options', true));
		}
	}
}


// Return customizable option value
if (!function_exists('fsdriving_get_theme_option')) {
	function fsdriving_get_theme_option($name, $defa='', $strict_mode=false, $post_id=0) {
		$rez = $defa;
		$from_post_meta = false;
		if ($post_id > 0) {
			if (!fsdriving_storage_isset('post_options_meta', $post_id))
				fsdriving_storage_set_array('post_options_meta', $post_id, get_post_meta($post_id, 'fsdriving_options', true));
			if (fsdriving_storage_isset('post_options_meta', $post_id, $name)) {
				$tmp = fsdriving_storage_get_array('post_options_meta', $post_id, $name);
				if (!fsdriving_is_inherit($tmp)) {
					$rez = $tmp;
					$from_post_meta = true;
				}
			}
		}
		if (!$from_post_meta && fsdriving_storage_isset('options')) {
			if ( !fsdriving_storage_isset('options', $name) ) {
				$rez = $tmp = '_not_exists_';
				if (function_exists('trx_addons_get_option'))
					$rez = trx_addons_get_option($name, $tmp, false);
				if ($rez === $tmp) {
					if ($strict_mode) {
						$s = debug_backtrace();
						$s = array_shift($s);
						echo '<pre>' . sprintf(esc_html__('Undefined option "%s" called from:', 'fsdriving'), $name);
						if (function_exists('dco')) dco($s);
						else print_r($s);
						echo '</pre>';
						wp_die();
					} else
						$rez = $defa;
				}
			} else {
				$blog_mode = fsdriving_storage_get('blog_mode');
				// Override option from GET or POST for current blog mode
				if (!empty($blog_mode) && isset($_REQUEST[$name . '_' . $blog_mode])) {
					$rez = $_REQUEST[$name . '_' . $blog_mode];
				// Override option from GET
				} else if (isset($_REQUEST[$name])) {
					$rez = $_REQUEST[$name];
				// Override option from current page settings (if exists)
				} else if (fsdriving_storage_isset('options_meta', $name) && !fsdriving_is_inherit(fsdriving_storage_get_array('options_meta', $name))) {
					$rez = fsdriving_storage_get_array('options_meta', $name);
				// Override option from current blog mode settings: 'home', 'search', 'page', 'post', 'blog', etc. (if exists)
				} else if (!empty($blog_mode) && fsdriving_storage_isset('options', $name . '_' . $blog_mode, 'val') && !fsdriving_is_inherit(fsdriving_storage_get_array('options', $name . '_' . $blog_mode, 'val'))) {
					$rez = fsdriving_storage_get_array('options', $name . '_' . $blog_mode, 'val');
				// Get saved option value
				} else if (fsdriving_storage_isset('options', $name, 'val')) {
					$rez = fsdriving_storage_get_array('options', $name, 'val');
				// Get ThemeREX Addons option value
				} else if (function_exists('trx_addons_get_option')) {
					$rez = trx_addons_get_option($name, $defa, false);
				}
			}
		}
		return $rez;
	}
}


// Check if customizable option exists
if (!function_exists('fsdriving_check_theme_option')) {
	function fsdriving_check_theme_option($name) {
		return fsdriving_storage_isset('options', $name);
	}
}

// Get dependencies list from the Theme Options
if ( !function_exists('fsdriving_get_theme_dependencies') ) {
	function fsdriving_get_theme_dependencies() {
		$options = fsdriving_storage_get('options');
		$depends = array();
		foreach ($options as $k=>$v) {
			if (isset($v['dependency'])) 
				$depends[$k] = $v['dependency'];
		}
		return $depends;
	}
}

// Return internal theme setting value
if (!function_exists('fsdriving_get_theme_setting')) {
	function fsdriving_get_theme_setting($name) {
		return fsdriving_storage_isset('settings', $name) ? fsdriving_storage_get_array('settings', $name) : false;
	}
}


// Set theme setting
if ( !function_exists( 'fsdriving_set_theme_setting' ) ) {
	function fsdriving_set_theme_setting($option_name, $value) {
		if (fsdriving_storage_isset('settings', $option_name))
			fsdriving_storage_set_array('settings', $option_name, $value);
	}
}
?>