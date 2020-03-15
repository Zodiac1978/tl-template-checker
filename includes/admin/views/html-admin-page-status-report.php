<?php
/**
 * Admin View: Page - Status Report
 *
 * @package TLTemplateChecker
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<table class="tplc_status_table widefat" id="status">
	<thead>
	<tr>
		<th><?php esc_html_e( 'Templates', 'child-theme-check' ); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php

	$template_paths = array( get_template_directory() . '/' );

	$scanned_files = array();
	$found_files   = array();
	foreach ( $template_paths as $plugin_name => $template_path ) {
		$scanned_files[ $plugin_name ] = TPLC_Admin_Status::scan_template_files( $template_path );
	}
	foreach ( $scanned_files as $plugin_name => $files ) {
		foreach ( $files as $file ) {

			// Skip if no php file.
			if ( ! strpos( $file, '.php' ) ) {
				continue;
			}

			$child_path = get_stylesheet_directory() . '/' . $file;

			// Exclude functions.php.
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
						'%1$s %2$s: %3$s %4$s',
						'<span class="dashicons dashicons-no-alt" style="color:red"></span>',
						'<code>' . basename( $theme_file ) . '</code>',
						sprintf(
							/* translators: %s Version number. */
							__( 'Child theme version %s is out of date.', 'child-theme-check' ),
							$child_version ? '<strong style="color:red">' . $child_version . '</strong>' : '-' 
						),
						sprintf(
							/* translators: %s Version number. */
							__( 'Parent theme version is %s.', 'child-theme-check' ),
							'<strong>' . $parent_version . '</strong>'
						)
					);
				} elseif ( ! $child_version && $parent_version ) {
					$found_files[ $plugin_name ][] = sprintf(
						'%1$s %2$s: %3$s %4$s',
						'<span class="dashicons dashicons-info" style="color:orange"></span>',
						'<code>' . basename( $theme_file ) . '</code>',
						__( 'Child theme is missing version keyword.', 'child-theme-check' ),
						sprintf(
							/* translators: %s Version number. */
							__( 'Parent theme version is %s.', 'child-theme-check' ),
							'<strong>' . $parent_version . '</strong>'
						)
					);
				} elseif ( ! $parent_version ) {
					$found_files[ $plugin_name ][] = sprintf(
						'%1$s %2$s: %3$s',
						'<span class="dashicons dashicons-minus"></span>',
						'<code>' . basename( $theme_file ) . '</code>',
						__( 'Parent theme is missing version keyword.', 'child-theme-check' )
					);
				} else {
					$found_files[ $plugin_name ][] = sprintf(
						'%1$s %2$s: %3$s',
						'<span class="dashicons dashicons-yes" style="color:green"></span>',
						'<code>' . basename( $theme_file ) . '</code>',
						sprintf(
							/* translators: %s Version number. */
							__( 'Child theme version %s matches parent theme.', 'child-theme-check' ),
							$child_version ? '<strong style="color:green">' . $child_version . '</strong>' : '-'
						)
					);
				}
			}
		}
	}
	if ( $found_files ) {
		foreach ( $found_files as $plugin_name => $found_plugin_files ) {
			$theme    = wp_get_theme();
			$template = wp_get_theme( $theme->template );
			?>
			<tr>
				<td>
				<?php
				printf(
					/* translators: %1$s Name of child theme, %2$s Name of parent theme. */
					__( 'Template overrides by %1$s for %2$s:', 'child-theme-check' ),
					'<abbr title="' . esc_attr__( 'Child Theme', 'child-theme-check' ) . '">' . esc_html( $theme ) . '</abbr>',
					'<abbr title="' . esc_attr__( 'Parent Theme', 'child-theme-check' ) . '">' . esc_html( $template ) . '</abbr>'
				);
				?>
				</td>
			</tr>
			<tr>
				<td><?php echo implode( '<br>', $found_plugin_files ); ?></td>
			</tr>

			<?php
		}
	} else {
		?>
		<tr>
			<td><?php esc_html_e( 'No overrides present in child theme.', 'child-theme-check' ); ?></td>
		</tr>
		<?php
	}
	?>
</tbody>
</table>
