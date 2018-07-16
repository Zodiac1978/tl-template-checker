<?php
/**
 * TPLC Uninstall: Uninstalling theme option
 *
 * @package TLTemplateChecker
 */

// If uninstall not called from WordPress exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Remove notice option.
delete_option( 'tplc_admin_notices' );

// Remove version info for current theme.
// TODO: Should we remove other possible theme_mods from inactive themes?
remove_theme_mod( 'tl_latest_core_version' );
