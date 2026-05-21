<?php
/**
 * Plugin Name: Child Theme Check
 * Description: This plugin can warn you about old template files in your child theme
 * Version:     1.0.10
 * Plugin URI:  https://github.com/Zodiac1978/tl-template-checker
 * Author:      Torsten Landsiedel
 * Author URI:  https://torstenlandsiedel.de
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
		public $version = '1.0.9';

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
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_settings_link' ) );
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
				wp_enqueue_style( 'tplc_admin_styles', plugins_url( '/assets/css/admin.min.css', __FILE__ ), array(), $this->version );
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
			$settings_link = '<a href="tools.php?page=tplc-status">' . __( 'Status', 'child-theme-check' ) . '</a>';
			array_unshift( $links, $settings_link );

			return $links;
		}

	}

endif;

/**
 * Returns the main instance of TPLC to prevent the need to use globals.
 *
 * @since 1.0.10
 */
function tplc() {
	return TLTemplateChecker::instance();
}

$GLOBALS['tplc_template_checker'] = tplc();
