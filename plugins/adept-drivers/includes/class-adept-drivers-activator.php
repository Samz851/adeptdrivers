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
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'ad_bookings';
		// $sql = "DROP TABLE IF EXISTS $table_name";
		// dbDelta( $sql );
		$foreign_table = $wpdb->prefix . 'users';
		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			student_id mediumint(9) NOT NULL,
			tookan_id mediumint(12) NOT NULL,
			booking_date datetime NULL,
			instructor smallint(64) NULL,
			status BOOLEAN,
			PRIMARY KEY (id),
			FOREIGN KEY (student_id) REFERENCES $foreign_table(ID)
		) $charset_collate;";
			dbDelta( $sql );

	}

}
