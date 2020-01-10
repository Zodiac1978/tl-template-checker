<?php
/**
 * Admin View: Notice - Template Check
 *
 * @package TLTemplateChecker
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div class="notice notice-warning is-dismissible">
	<p><?php _e( '<strong>The active child theme\'s parent has been updated and the child theme might have outdated copies of parent theme files</strong> &#8211; please ensure you update them manually. See the child theme check for more details.', 'child-theme-check' ); ?></p>
	<p class="submit"><a class="button-primary" href="<?php echo esc_url( admin_url( 'admin.php?page=tplc-status' ) ); ?>"><?php echo esc_html_x( 'Child Theme Check', 'Page and Menu Title', 'child-theme-check' ); ?></a> <a class="skip button-primary" href="<?php echo esc_url( add_query_arg( 'hide_template_files_notice', 'template_files' ) ); ?>"><?php esc_html_e( 'Hide this notice permanently', 'child-theme-check' ); ?></a></p>
</div>
