<?php
/**
 * Plugin Name: Child-Theme-Template-Checker
 * Description: This plugins can warn you about old template files in your child theme
 * Version:     1.0.0
 * Author:      Torsten Landsiedel
 * Author URI:  http://torstenlandsiedel.de
 * Plugin URI:  http://torstenlandsiedel.de
 * Text Domain: child-theme-template-checker
 * License:     GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0
 */


/**
* Debug/Status page
*
* @author WooThemes
* @category Admin
* @package WooCommerce/Admin/System Status
* @version 2.2.0
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function tl_add_template_check() {
    if ( is_admin() && is_child_theme() ) {
		include_once( 'includes/admin/class-wc-admin.php' );
	}
}
add_action( 'after_setup_theme', 'tl_add_template_check' );

function tl_styles_template_check() {
    if ( is_admin() && is_child_theme() ) {
		wp_enqueue_style( 'woocommerce_admin_styles', plugins_url('/assets/css/admin.css', __FILE__), array() );
	}
}
add_action( 'admin_enqueue_scripts', 'tl_styles_template_check' );



/*

ToDo:
--------------------------
* Übersetzungsdatei hinzufügen / Textdomain anpassen

*/
