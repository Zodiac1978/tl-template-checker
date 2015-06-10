<?php
/**
 * Plugin Name: Child Theme Check
 * Description: This plugins can warn you about old template files in your child theme
 * Version:     0.1.0
 * Plugin URI:  https://github.com/Zodiac1978/tl-template-checker
 * Author:      Torsten Landsiedel
 * Author URI:  http://torstenlandsiedel.de
 * Text Domain: tl-template-checker
 * License:     GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */


/**
* Debug/Status page
*
* @since 0.1.0
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function tl_tlpc_add_template_check() {
    if ( is_admin() && is_child_theme() ) {
		include_once( 'includes/admin/class-tplc-admin.php' );
	}
}
add_action( 'after_setup_theme', 'tl_tlpc_add_template_check' );


function tl_tlpc_styles_template_check() {
    if ( is_admin() && is_child_theme() ) {
		wp_enqueue_style( 'tplc_admin_styles', plugins_url('/assets/css/admin.css', __FILE__), array() );
	}
}
add_action( 'admin_enqueue_scripts', 'tl_tlpc_styles_template_check' );


/**
 * Load plugin textdomain.
 *
 * @since 0.1.0
 */
function tl_tplc_load_plugin_textdomain() {
	if ( is_admin() ) {
  		load_plugin_textdomain( 'tl-template-checker', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
  	}
}
add_action( 'plugins_loaded', 'tl_tplc_load_plugin_textdomain' );
