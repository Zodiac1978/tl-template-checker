<?php

/**
 * Admin View: Page - Status Report
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<table class="wc_status_table widefat" cellspacing="0" id="status">
	<thead>
	<tr>
		<th colspan="2"><?php _e( 'Templates', 'woocommerce' ); ?></th>
	</tr>
	</thead>
	<tbody>
<?php

$template_paths = array ( get_template_directory() . '/' );

$scanned_files = array();
$found_files = array();
foreach ( $template_paths as $plugin_name => $template_path ) {
	$scanned_files[ $plugin_name ] = TPLC_Admin_Status::scan_template_files( $template_path );
}
foreach ( $scanned_files as $plugin_name => $files ) {
	foreach ( $files as $file ) {
	if (! strpos($file, '.php') ) { continue; } // skip if no php file
	if ( file_exists( get_stylesheet_directory() . '/' . $file ) ) {
		$theme_file = get_stylesheet_directory() . '/' . $file;
	} else {
		$theme_file = false;
	}
	
	if ( $theme_file ) {
		$core_version = TPLC_Admin_Status::get_file_version( get_template_directory() . '/' . $file );

		$theme_version = TPLC_Admin_Status::get_file_version( $theme_file );

		if ( $core_version && $theme_version && ( version_compare( $theme_version, $core_version, '<' ) ) ) {
			$found_files[ $plugin_name ][] = sprintf( __( '<code>%s</code> version <strong style="color:red">%s</strong> is out of date. The parent theme version is <strong>%s</strong>', 'woocommerce' ), basename( $theme_file ), $theme_version ? $theme_version : '-', $core_version );
		} elseif ( ! $theme_version && $core_version ) {
			$found_files[ $plugin_name ][] = sprintf( __( '<code>%s</code> Child theme is missing @version info. The parent theme version is <strong>%s</strong>', 'woocommerce' ), basename( $theme_file ), $core_version );
		} elseif ( ! $core_version ) {
			$found_files[ $plugin_name ][] = sprintf( __( '<code>%s</code> Parent theme is missing @version info.', 'woocommerce' ), basename( $theme_file ) );
		} else {
			$found_files[ $plugin_name ][] = sprintf( '<code>%s</code>', basename( $theme_file ) );
		}
		}
	}
}
if ( $found_files ) {
	foreach ( $found_files as $plugin_name => $found_plugin_files ) {
	?>
		<tr>
		<!-- <td><?php _e( 'Child Theme Overrides', 'woocommerce' ); ?> (<?php echo $plugin_name; ?>):</td> -->
		<td><?php _e( 'Child Theme Overrides', 'woocommerce' ); ?> (<?php echo wp_get_theme(); ?>):</td>
		<td><?php echo implode( ', <br/>', $found_plugin_files ); ?></td>
		</tr>
	<?php
	}
} else {
?>
	<tr>
	<td><?php _e( 'Child Theme Overrides', 'woocommerce' ); ?>:</td>
	<td><?php _e( 'No overrides present in child theme.', 'woocommerce' ); ?></td>
	</tr>
<?php
}
?>
</tbody>
</table>
