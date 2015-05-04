<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WooCommerce Admin.
 *
 * @class 		TPLC_Admin 
 * @author 		WooThemes
 * @category 	Admin
 * @package 	WooCommerce/Admin
 * @version     2.1.0 
 */
class TPLC_Admin {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'includes' ) );
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {
		
		// Functions
		include_once( 'wc-admin-functions.php' );

		// Menus
		include( 'class-wc-admin-menus.php' );

		// Help
		include( 'class-wc-admin-help.php' );
		
	}

}

return new TPLC_Admin();