<?php
/**
 * Plugin Name: Child Theme Check
 * Description: This plugin can warn you about old template files in your child theme
 * Version:     1.0.6
 * Plugin URI:  https://github.com/Zodiac1978/tl-template-checker
 * Author:      Torsten Landsiedel
 * Author URI:  http://torstenlandsiedel.de
 * Text Domain: child-theme-check
 * Domain Path: /languages
 * License:     GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * GitHub Plugin URI: https://github.com/Zodiac1978/tl-template-checker
 * GitHub Branch: master
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'TLTemplateChecker' ) ) :

	/**
	 * Main TL-Template-Checker Class
	 *
	 * @class TLTemplateChecker
	 * @version 1.0.0
	 */
	final class TLTemplateChecker {

		/**
		 * @var string
		 */
		public $version = '1.0.6';

		/**
		 * @var TLTemplateChecker The single instance of the class
		 * @since 1.0.0
		 */
		protected static $_instance = null;

		/**
		 * Main TLTemplateChecker Instance
		 *
		 * Ensures only one instance of TLTemplateChecker is loaded or can be loaded.
		 *
		 * @since 1.0.0
		 * @static
		 * @return TLTemplateChecker - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * TLTemplateChecker Constructor.
		 */
		public function __construct() {
			$this->includes();
			$this->hooks();
		}

		/**
		 * Hook into actions and filters
		 *
		 * @since  1.0.0
		 */
		private function hooks() {
			add_action( 'init', array( $this, 'init' ), 0 );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_settings_link' ) );
		}

		/**
		 * Init TLTemplateChecker when WordPress Initialises.
		 *
		 * @since  1.0.0
		 */
		public function init() {
			// Set up localisation.
			$this->load_plugin_textdomain();
		}

		/**
		 * Include required files used in admin.
		 *
		 * @since  1.0.0
		 */
		public function includes() {
			if ( is_admin() ) {
				include_once 'includes/admin/class-tplc-admin.php';
			}
		}

		/**
		 * Load styles in admin.
		 *
		 * @since  1.0.0
		 */
		public function admin_styles() {
			if ( is_admin() ) {
				wp_enqueue_style( 'tplc_admin_styles', plugins_url( '/assets/css/admin.min.css', __FILE__ ), array() );
			}
		}

		/**
		 * Load plugin textdomain.
		 *
		 * @since 1.0.0
		 */
		private function load_plugin_textdomain() {
			if ( is_admin() ) {
				load_plugin_textdomain( 'child-theme-check', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
			}
		}

		/**
		 * Add link on plugin page
		 *
		 * @param Array $links Array of links for plugin list table view.
		 * @return mixed
		 * @since  1.0.0
		 */
		public function plugin_settings_link( $links ) {
			$settings_link = '<a href="tools.php?page=tplc-status">' . __( 'Status', 'tl-template-checker' ) . '</a>';
			array_unshift( $links, $settings_link );

			return $links;
		}

	}

endif;

/**
 * Returns the main instance of TLTPLC to prevent the need to use globals.
 *
 * @since  1.0.0
 */
function TLTPLC() {
	return TLTemplateChecker::instance();
}

// Global for backwards compatibility.
$GLOBALS['tl-template-checker'] = TLTPLC();
