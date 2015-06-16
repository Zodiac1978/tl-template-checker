<?php
/**
 * TPLC Uninstall
 *
 * Uninstalling theme option
 *
 */

//if uninstall not called from WordPress exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// remove notice option
delete_option( 'tplc_admin_notices' );

// remove version info for current theme
remove_theme_mod( 'tl_latest_core_version' );

// should we remove other possible theme_mods from inactive themes?