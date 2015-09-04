<?php
/**
 * Plugin Name: Child Theme Check
 * Description: This plugin can warn you about old template files in your child theme
 * Version:     0.1.0
 * Plugin URI:  https://github.com/Zodiac1978/tl-template-checker
 * Author:      Torsten Landsiedel
 * Author URI:  http://torstenlandsiedel.de
 * Text Domain: tl-template-checker
 * Domain Path: /languages
 * License:     GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */



if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'TLTemplateChecker' ) ) :



/**
 * Main TL-Template-Checker Class
 *
 * @class WooCommerce
 * @version	2.3.0
 */
final class TLTemplateChecker {

	/**
	 * @var string
	 */
	public $version = '0.1.0';

	/**
	 * @var WooCommerce The single instance of the class
	 * @since 2.1
	 */
	protected static $_instance = null;

	/**
	 * Main WooCommerce Instance
	 *
	 * Ensures only one instance of WooCommerce is loaded or can be loaded.
	 *
	 * @since 2.1
	 * @static
	 * @see WC()
	 * @return WooCommerce - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * WooCommerce Constructor.
	 */
	public function __construct() {
		$this->includes();
		$this->hooks();
	}

	/**
	 * Hook into actions and filters
	 * @since  2.3
	 */
	private function hooks() {
		add_action( 'init', array( $this, 'init' ), 0 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
	}

	/**
	 * Init WooCommerce when WordPress Initialises.
	 */
	public function init() {
		// Set up localisation
		$this->load_plugin_textdomain();
	}

	/**
	 * Include required core files used in admin.
	 */
	public function includes() {
		if ( is_admin() ) {
			include_once( 'includes/admin/class-tplc-admin.php' );
		}
	}

	public function admin_styles() {
	    if ( is_admin() ) {
			wp_enqueue_style( 'tplc_admin_styles', plugins_url('/assets/css/admin.css', __FILE__), array() );
		}
	}


	/**
	 * Load plugin textdomain.
	 *
	 * @since 0.1.0
	 */
	private function load_plugin_textdomain() {
		if ( is_admin() ) {
	  		load_plugin_textdomain( 'tl-template-checker', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
	  	}
	}

}

endif;

/**
 * Returns the main instance of WC to prevent the need to use globals.
 *
 * @since  2.1
 * @return WooCommerce
 */
function TLTPLC() {
	return TLTemplateChecker::instance();
}

// Global for backwards compatibility.
$GLOBALS['tl-template-checker'] = TLTPLC();
