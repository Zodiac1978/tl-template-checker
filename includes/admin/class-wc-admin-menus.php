<?php
/**
 * Setup menus in WP admin.
 *
 * @author 		WooThemes
 * @category 	Admin
 * @package 	WooCommerce/Admin
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'TPLC_Admin_Menus' ) ) :

/**
 * TPLC_Admin_Menus Class
 */
class TPLC_Admin_Menus {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		// Add menus
		add_action( 'admin_menu', array( $this, 'status_menu' ), 60 );
	}

	/**
	 * Add menu item
	 */
	public function status_menu() {
		add_submenu_page( 'tools.php',  __( 'Child Theme Check', 'tl-template-checker' ), __( 'Child Theme Check', 'tl-template-checker' ), 'manage_options', 'wc-status', array( $this, 'status_page' ) );
	}

	/**
	 * Init the status page
	 */
	public function status_page() {
		$page = include( 'class-wc-admin-status.php' );
		$page->output();
	}

}

endif;

return new TPLC_Admin_Menus();