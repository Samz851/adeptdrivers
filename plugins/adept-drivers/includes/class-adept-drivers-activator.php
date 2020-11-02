<?php

/**
 * Fired during plugin activation
 *
 * @link       https://samiscoding.com
 * @since      1.0.0
 *
 * @package    Adept_Drivers
 * @subpackage Adept_Drivers/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Adept_Drivers
 * @subpackage Adept_Drivers/includes
 * @author     Samer Alotaibi <sam@samiscoding.com>
 */
class Adept_Drivers_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// require_once plugin_dir_path( __FILE__  ) . '../includes/class-adept-drivers-zcrm.php';
		// $ad_zcrm = new Adept_Drivers_ZCRM;
		// add_action( 'rest_api_init', array($ad_zcrm, 'zcrm_resapi'));
	}

}
