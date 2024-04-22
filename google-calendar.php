<?php
/**
 * Plugin Name: Google Calendar
 * Plugin URI: https://github.com/mdrejon/google-calendar
 * Description: A simple WordPress plugin to demonstrate how to create a CRUD operation in WordPress.
 * Version: 1.0.0
 * Author: Sydur Rahman
 * Author URI: https://sydurrahman.com/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: google-calendar
 * Domain Path: /languages
 */

/**
 * WP Database CRUD main class
 */
class WTD_GOOGLE_CALENDAR {

	/**
	 *  __construct
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct() {

		// Define constant.
		$this->wtddb_constant();

		// Load plugin textdomain.
		// add_action( 'plugins_loaded', array( $this, 'wtddb_load_textdomain' ) );

		// Load admin class.
		require_once WTDDB_PATH . 'admin/admin.php';

		// Run admin class.
		new WTDGC_ADMIN();
	}

	/**
	 * Load plugin textdomain.
	 *
	 * @since 1.0.0
	 * @author Sydur Rahman <sydurrahmant1@gmail.com>
	 * @return void
	 */
	public function wtdgc_load_textdomain() {

		load_plugin_textdomain( 'wp-database-crud', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}



	/**
	 * Define constant.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function wtddb_constant() {

		// Define constant.
		define( 'WTDDB_VERSION', '1.0.0' );
		define( 'WTDDB_FILE', plugin_dir_url( __FILE__ ) );
		define( 'WTDDB_PATH', plugin_dir_path( __FILE__ ) );
	}
}

// Run the plugin.

new WTD_GOOGLE_CALENDAR();
