<?php
/**
 * Setup menus in WP admin.
 *
 * @package     TLTemplateChecker
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'TPLC_Admin_Menus', false ) ) {
	return new TPLC_Admin_Menus();
}

/**
 * TPLC_Admin_Menus Class.
 */
class TPLC_Admin_Menus {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		// Add menus.
		add_action( 'admin_menu', array( $this, 'status_menu' ), 60 );
	}

	/**
	 * Add menu item.
	 */
	public function status_menu() {
		add_submenu_page( 'tools.php', _x( 'Child Theme Check', 'Page and Menu Title', 'child-theme-check' ), _x( 'Child Theme Check', 'Page and Menu Title', 'child-theme-check' ), 'manage_options', 'tplc-status', array( $this, 'status_page' ) );
	}

	/**
	 * Init the status page
	 */
	public function status_page() {
		$page = include 'class-tplc-admin-status.php';
		$page->output();
	}

}

return new TPLC_Admin_Menus();
