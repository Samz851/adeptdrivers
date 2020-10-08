<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('fsdriving_storage_get')) {
	function fsdriving_storage_get($var_name, $default='') {
		global $FSDRIVING_STORAGE;
		return isset($FSDRIVING_STORAGE[$var_name]) ? $FSDRIVING_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('fsdriving_storage_set')) {
	function fsdriving_storage_set($var_name, $value) {
		global $FSDRIVING_STORAGE;
		$FSDRIVING_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('fsdriving_storage_empty')) {
	function fsdriving_storage_empty($var_name, $key='', $key2='') {
		global $FSDRIVING_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($FSDRIVING_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($FSDRIVING_STORAGE[$var_name][$key]);
		else
			return empty($FSDRIVING_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('fsdriving_storage_isset')) {
	function fsdriving_storage_isset($var_name, $key='', $key2='') {
		global $FSDRIVING_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($FSDRIVING_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($FSDRIVING_STORAGE[$var_name][$key]);
		else
			return isset($FSDRIVING_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('fsdriving_storage_inc')) {
	function fsdriving_storage_inc($var_name, $value=1) {
		global $FSDRIVING_STORAGE;
		if (empty($FSDRIVING_STORAGE[$var_name])) $FSDRIVING_STORAGE[$var_name] = 0;
		$FSDRIVING_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('fsdriving_storage_concat')) {
	function fsdriving_storage_concat($var_name, $value) {
		global $FSDRIVING_STORAGE;
		if (empty($FSDRIVING_STORAGE[$var_name])) $FSDRIVING_STORAGE[$var_name] = '';
		$FSDRIVING_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('fsdriving_storage_get_array')) {
	function fsdriving_storage_get_array($var_name, $key, $key2='', $default='') {
		global $FSDRIVING_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($FSDRIVING_STORAGE[$var_name][$key]) ? $FSDRIVING_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($FSDRIVING_STORAGE[$var_name][$key][$key2]) ? $FSDRIVING_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('fsdriving_storage_set_array')) {
	function fsdriving_storage_set_array($var_name, $key, $value) {
		global $FSDRIVING_STORAGE;
		if (!isset($FSDRIVING_STORAGE[$var_name])) $FSDRIVING_STORAGE[$var_name] = array();
		if ($key==='')
			$FSDRIVING_STORAGE[$var_name][] = $value;
		else
			$FSDRIVING_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('fsdriving_storage_set_array2')) {
	function fsdriving_storage_set_array2($var_name, $key, $key2, $value) {
		global $FSDRIVING_STORAGE;
		if (!isset($FSDRIVING_STORAGE[$var_name])) $FSDRIVING_STORAGE[$var_name] = array();
		if (!isset($FSDRIVING_STORAGE[$var_name][$key])) $FSDRIVING_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$FSDRIVING_STORAGE[$var_name][$key][] = $value;
		else
			$FSDRIVING_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Merge array elements
if (!function_exists('fsdriving_storage_merge_array')) {
	function fsdriving_storage_merge_array($var_name, $key, $value) {
		global $FSDRIVING_STORAGE;
		if (!isset($FSDRIVING_STORAGE[$var_name])) $FSDRIVING_STORAGE[$var_name] = array();
		if ($key==='')
			$FSDRIVING_STORAGE[$var_name] = array_merge($FSDRIVING_STORAGE[$var_name], $value);
		else
			$FSDRIVING_STORAGE[$var_name][$key] = array_merge($FSDRIVING_STORAGE[$var_name][$key], $value);
	}
}

// Add array element after the key
if (!function_exists('fsdriving_storage_set_array_after')) {
	function fsdriving_storage_set_array_after($var_name, $after, $key, $value='') {
		global $FSDRIVING_STORAGE;
		if (!isset($FSDRIVING_STORAGE[$var_name])) $FSDRIVING_STORAGE[$var_name] = array();
		if (is_array($key))
			fsdriving_array_insert_after($FSDRIVING_STORAGE[$var_name], $after, $key);
		else
			fsdriving_array_insert_after($FSDRIVING_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('fsdriving_storage_set_array_before')) {
	function fsdriving_storage_set_array_before($var_name, $before, $key, $value='') {
		global $FSDRIVING_STORAGE;
		if (!isset($FSDRIVING_STORAGE[$var_name])) $FSDRIVING_STORAGE[$var_name] = array();
		if (is_array($key))
			fsdriving_array_insert_before($FSDRIVING_STORAGE[$var_name], $before, $key);
		else
			fsdriving_array_insert_before($FSDRIVING_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('fsdriving_storage_push_array')) {
	function fsdriving_storage_push_array($var_name, $key, $value) {
		global $FSDRIVING_STORAGE;
		if (!isset($FSDRIVING_STORAGE[$var_name])) $FSDRIVING_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($FSDRIVING_STORAGE[$var_name], $value);
		else {
			if (!isset($FSDRIVING_STORAGE[$var_name][$key])) $FSDRIVING_STORAGE[$var_name][$key] = array();
			array_push($FSDRIVING_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('fsdriving_storage_pop_array')) {
	function fsdriving_storage_pop_array($var_name, $key='', $defa='') {
		global $FSDRIVING_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($FSDRIVING_STORAGE[$var_name]) && is_array($FSDRIVING_STORAGE[$var_name]) && count($FSDRIVING_STORAGE[$var_name]) > 0) 
				$rez = array_pop($FSDRIVING_STORAGE[$var_name]);
		} else {
			if (isset($FSDRIVING_STORAGE[$var_name][$key]) && is_array($FSDRIVING_STORAGE[$var_name][$key]) && count($FSDRIVING_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($FSDRIVING_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('fsdriving_storage_inc_array')) {
	function fsdriving_storage_inc_array($var_name, $key, $value=1) {
		global $FSDRIVING_STORAGE;
		if (!isset($FSDRIVING_STORAGE[$var_name])) $FSDRIVING_STORAGE[$var_name] = array();
		if (empty($FSDRIVING_STORAGE[$var_name][$key])) $FSDRIVING_STORAGE[$var_name][$key] = 0;
		$FSDRIVING_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('fsdriving_storage_concat_array')) {
	function fsdriving_storage_concat_array($var_name, $key, $value) {
		global $FSDRIVING_STORAGE;
		if (!isset($FSDRIVING_STORAGE[$var_name])) $FSDRIVING_STORAGE[$var_name] = array();
		if (empty($FSDRIVING_STORAGE[$var_name][$key])) $FSDRIVING_STORAGE[$var_name][$key] = '';
		$FSDRIVING_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('fsdriving_storage_call_obj_method')) {
	function fsdriving_storage_call_obj_method($var_name, $method, $param=null) {
		global $FSDRIVING_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($FSDRIVING_STORAGE[$var_name]) ? $FSDRIVING_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($FSDRIVING_STORAGE[$var_name]) ? $FSDRIVING_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('fsdriving_storage_get_obj_property')) {
	function fsdriving_storage_get_obj_property($var_name, $prop, $default='') {
		global $FSDRIVING_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($FSDRIVING_STORAGE[$var_name]->$prop) ? $FSDRIVING_STORAGE[$var_name]->$prop : $default;
	}
}
?>