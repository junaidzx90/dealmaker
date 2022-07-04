<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Dealmaker
 * @subpackage Dealmaker/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Dealmaker
 * @subpackage Dealmaker/includes
 * @author     Developer Junayed <admin@easeare.com>
 */
class Dealmaker_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	
		$dealmaker = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}dealmaker` (
			`ID` INT NOT NULL AUTO_INCREMENT,
			`title` VARCHAR(255) NOT NULL,
			`subtitle`  VARCHAR(255) NOT NULL,
			`logo_url`  VARCHAR(555) NOT NULL,
			`badge_url`  VARCHAR(555) NOT NULL,
			`description` TEXT NOT NULL,
			`disclaimer` TEXT NOT NULL,
			`date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`ID`)) ENGINE = InnoDB";
		dbDelta($dealmaker);
	}

}
