<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WooCommerce Admin.
 *
 * @class 		TPLC_Admin 
 * @author 		WooThemes
 * @version     1.0.0 
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
		include_once( 'tplc-admin-functions.php' );

		// Menus
		include_once( 'class-tplc-admin-menus.php' );
		
		// Notices
		include_once( 'class-tplc-admin-notices.php' ); 

		// Help
		include_once( 'class-tplc-admin-help.php' );
		
	}

}

return new TPLC_Admin();