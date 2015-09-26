<?php

/**
 * Admin View: Page - Status Report
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<table class="tplc_status_table widefat" id="status">
	<thead>
	<tr>
		<th><?php _e( 'Templates', 'child-theme-check' ); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php

	$template_paths = array ( get_template_directory() . '/' );

	$scanned_files = array();
	$found_files   = array();
	foreach ( $template_paths as $plugin_name => $template_path ) {
		$scanned_files[ $plugin_name ] = TPLC_Admin_Status::scan_template_files( $template_path );
	}
	foreach ( $scanned_files as $plugin_name => $files ) {
		foreach ( $files as $file ) {

			// skip if no php file
			if ( ! strpos( $file, '.php' ) )
				continue;

			$child_path = get_stylesheet_directory() . '/' . $file;

			// Exclude functions.php
			if ( file_exists( $child_path ) && basename( $file ) !== 'functions.php' ) {
				$theme_file = $child_path;
			} else {
				$theme_file = false;
			}

			if ( $theme_file ) {
				$parent_version = TPLC_Admin_Status::get_file_version( get_template_directory() . '/' . $file );
				$child_version  = TPLC_Admin_Status::get_file_version( $theme_file );

				if ( $parent_version && $child_version && ( version_compare( $child_version, $parent_version, '<' ) ) ) {
					$found_files[ $plugin_name ][] = sprintf(
						__( '%s <code>%s</code>: Child theme version <strong style="color:red">%s</strong> is out of date. The parent theme version is <strong>%s</strong>.', 'child-theme-check' ),
						'<span class="dashicons dashicons-no-alt" style="color:red"></span>',
						basename( $theme_file ),
						$child_version ? $child_version : '-',
						$parent_version
					);
				} elseif ( ! $child_version && $parent_version ) {
					$found_files[ $plugin_name ][] = sprintf(
						__( '%s <code>%s</code>: Child theme is missing version keyword. The parent theme version is <strong>%s</strong>.', 'child-theme-check' ),
						'<span class="dashicons dashicons-info" style="color:orange"></span>',
						basename( $theme_file ),
						$parent_version
					);
				} elseif ( ! $parent_version ) {
					$found_files[ $plugin_name ][] = sprintf(
						__( '%s <code>%s</code>: Parent theme is missing version keyword.', 'child-theme-check' ),
						'<span class="dashicons dashicons-minus"></span>',
						basename( $theme_file )
					);
				} else {
					$found_files[ $plugin_name ][] = sprintf(
						__( '%s <code>%s</code>: Child theme version <strong style="color:green">%s</strong> matches parent theme.', 'child-theme-check' ),
						'<span class="dashicons dashicons-yes" style="color:green"></span>',
						basename( $theme_file ),
						$child_version ? $child_version : '-',
						$parent_version
					);
				}
			}
		}
	}
	if ( $found_files ) {
		foreach ( $found_files as $plugin_name => $found_plugin_files ) {
			$theme = wp_get_theme();
			$template = wp_get_theme( $theme->template );
		?>
			<tr>
				<td><?php printf(
					__( 'Template overrides by <abbr title="Child theme">%s</abbr> for <abbr title="Parent theme">%s</abbr>:', 'child-theme-check' ),
					$theme,
					$template
				); ?></td>
			</tr>
			<tr>
				<td><?php echo implode( '<br>', $found_plugin_files ); ?></td>
			</tr>
			
		<?php
		}
	} else {
	?>
		<tr>
			<td><?php _e( 'No overrides present in child theme.', 'child-theme-check' ); ?></td>
		</tr>
	<?php
	}
	?>
</tbody>
</table>
