<?php
/**
 * Shortcode: Display Login link
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.08
 */

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_layouts_login_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_layouts_login_load_scripts_front');
	function trx_addons_sc_layouts_login_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-sc_layouts_login', trx_addons_get_file_url('cpt/layouts/shortcodes/login/login.css'), array(), null );
		}
	}
}

	
// Merge shortcode specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_layouts_login_merge_styles' ) ) {
	add_action("trx_addons_filter_merge_styles", 'trx_addons_sc_layouts_login_merge_styles');
	function trx_addons_sc_layouts_login_merge_styles($list) {
		$list[] = 'cpt/layouts/shortcodes/login/login.css';
		return $list;
	}
}



// trx_sc_layouts_login
//-------------------------------------------------------------
/*
[trx_sc_layouts_login id="unique_id" text="Link text" title="link title"]
*/
if ( !function_exists( 'trx_addons_sc_layouts_login' ) ) {
	function trx_addons_sc_layouts_login($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_layouts_login', $atts, array(
			// Individual params
			"type" => "default",
			"text_login" => "",
			"text_logout" => "",
			"hide_on_mobile" => "0",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);

		ob_start();
		set_query_var('trx_addons_args_sc_layouts_login', $atts);
		if (($fdir = trx_addons_get_file_dir('cpt/layouts/shortcodes/login/tpl.'.trx_addons_esc($atts['type']).'.php')) != '') { include $fdir; }
		else if (($fdir = trx_addons_get_file_dir('cpt/layouts/shortcodes/login/tpl.default.php')) != '') { include $fdir; }
		$output = ob_get_contents();
		ob_end_clean();
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_layouts_login', $atts, $content);
	}
	if (trx_addons_exists_visual_composer()) add_shortcode("trx_sc_layouts_login", "trx_addons_sc_layouts_login");
}


// Add [trx_sc_layouts_login] in the VC shortcodes list
if (!function_exists('trx_addons_sc_layouts_login_add_in_vc')) {
	function trx_addons_sc_layouts_login_add_in_vc() {

		vc_map( apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_layouts_login",
				"name" => esc_html__("Layouts: Login link", 'trx_addons'),
				"description" => wp_kses_data( __("Insert Login/Logout link to the custom layout", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_layouts_login',
				"class" => "trx_sc_layouts_login",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "type",
							"heading" => esc_html__("Layout", 'trx_addons'),
							"description" => wp_kses_data( __("Select shortcodes's layout", 'trx_addons') ),
							"admin_label" => true,
							"class" => "",
							"std" => "default",
							"value" => apply_filters('trx_addons_sc_type', array(
								esc_html__('Default', 'trx_addons') => 'default',
							), 'trx_sc_layouts_login' ),
							"type" => "dropdown"
						),
						array(
							"param_name" => "text_login",
							"heading" => esc_html__("Login text", 'trx_addons'),
							"description" => wp_kses_data( __("Text of the Login link.", 'trx_addons') ),
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "text_logout",
							"heading" => esc_html__("Logout text", 'trx_addons'),
							"description" => wp_kses_data( __("Text of the Logout link.", 'trx_addons') ),
							"admin_label" => true,
							"type" => "textfield"
						)
					),
					trx_addons_vc_add_hide_param(),
					trx_addons_vc_add_id_param()
				)
			), 'trx_sc_layouts_login') );
			
		class WPBakeryShortCode_Trx_Sc_Layouts_Login extends WPBakeryShortCode {}

	}
	if (trx_addons_exists_visual_composer()) add_action('init', 'trx_addons_sc_layouts_login_add_in_vc', 15);
}
?>