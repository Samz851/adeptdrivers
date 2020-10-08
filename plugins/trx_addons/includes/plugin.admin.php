<?php
/**
 * Plugin's admin functions
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.17
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// AJAX: Get specified list's items
if ( !function_exists( 'trx_addons_callback_refresh_list' ) ) {
	add_action('wp_ajax_trx_addons_refresh_list', 		'trx_addons_callback_refresh_list');
	add_action('wp_ajax_nopriv_trx_addons_refresh_list','trx_addons_callback_refresh_list');
	function trx_addons_callback_refresh_list() {
		if ( !wp_verify_nonce( trx_addons_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			die();
		$list = apply_filters('trx_addons_filter_refresh_list_'.trim($_REQUEST['parent_type']), array(), $_REQUEST['parent_value']);
		// Make simple list to save sort order of items
		$new_list = array();
		foreach ($list as $k=>$v) 
			$new_list[] = array('key' => $k, 'value' => $v);
		$response = array(
			'error' => '',
			'data' => $new_list
		);
		echo json_encode($response);
		die();
	}
}

// Get list categories
if ( !function_exists( 'trx_addons_admin_refresh_list_categories' ) ) {
	add_filter('trx_addons_filter_refresh_list_categories', 'trx_addons_admin_refresh_list_categories', 10, 2);
	function trx_addons_admin_refresh_list_categories($list, $post_type) {
		return trx_addons_array_merge(
					array(0 => esc_html__('- Select category -', 'trx_addons')), 
					trx_addons_get_list_terms(false, trx_addons_get_post_type_taxonomy($post_type))
					);
	}
}
?>