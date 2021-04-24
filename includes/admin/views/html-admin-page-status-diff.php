<?php
/**
 * Admin View: Page - Status Diff
 *
 * @package TLTemplateChecker
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<script>
jQuery( function($) {
	$(document).ready( function() {
		$( 'h3.trigger' ).click( function() {
			$(this).toggleClass( 'active' ).next( '.diff-wrapper' ).slideToggle( 'fast' );
			return false; //Prevent the browser jump to the link anchor
		});
	});
});
</script>

<div class="revisions-diff-frame">
	<div class="revisions-diff">
		<?php

		$template_paths = array( get_template_directory() . '/' );

		$scanned_files = array();
		$found_files   = array();
		foreach ( $template_paths as $plugin_name => $template_path ) {
			$scanned_files[ $plugin_name ] = TPLC_Admin_Status::scan_template_files( $template_path );
		}

		$message = __( 'There are no differences between child theme templates and parent theme templates.', 'child-theme-check' );

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

					$parent_content = TPLC_Admin_Status::get_file_content( get_template_directory() . '/' . $file );
					$child_content  = TPLC_Admin_Status::get_file_content( $theme_file );

					$parent_version = TPLC_Admin_Status::get_file_version( get_template_directory() . '/' . $file );
					$child_version  = TPLC_Admin_Status::get_file_version( $theme_file );

					$theme    = wp_get_theme();
					$template = wp_get_theme( $theme->template );

					if ( version_compare( $GLOBALS['wp_version'], '5.7' ) >= 0 ) {
						$args = array(
							'title_left'      => esc_html__( 'Parent Theme', 'child-theme-check' ) . ': ' . esc_html( $template ),
							'title_right'     => esc_html__( 'Child Theme', 'child-theme-check' ) . ': ' . esc_html( $theme ),
							'show_split_view' => true,
						);
					} else {
						$args = array( 'show_split_view' => true );
					}

					$diff_table = wp_text_diff( $parent_content, $child_content, $args );

					if ( $diff_table ) {

						$message = ''; // Reset message if diff found.

						if ( $parent_version && $child_version && ( version_compare( $child_version, $parent_version, '<' ) ) ) {
							$status = '<span class="alignright dashicons dashicons-no-alt" style="color:red"></span>';
						} elseif ( ! $child_version && $parent_version ) {
							$status = '<span class="alignright dashicons dashicons-info" style="color:orange"></span>';
						} elseif ( ! $parent_version ) {
							$status = '<span class="alignright dashicons dashicons-minus"></span>';
						} else {
							$status = '<span class="alignright dashicons dashicons-yes" style="color:green"></span>';
						}

						printf(
							'<h3 class="trigger">%s %s %s</h3>',
							esc_html__( 'Diff for template file:', 'child-theme-check' ),
							esc_html( $file ),
							$status
						);

						if ( version_compare( $GLOBALS['wp_version'], '5.7' ) >= 0 ) {
							printf(
								'<div class="diff-wrapper" style="display: none;">%s</div>',
								$diff_table
							);
						} else {
							printf(
								'<div class="diff-wrapper" style="display: none;"><table class="diff"><tr><th class="diffheader">%s: ' . esc_html( $template ) . '</th><th>&#160;</th><th class="diffheader">%s: ' . esc_html( $theme ) . '</th></tr></table>%s</div>',
								esc_html__( 'Parent Theme', 'child-theme-check' ),
								esc_html__( 'Child Theme', 'child-theme-check' ),
								$diff_table
							);
						}

						echo '<hr class="tplc_diff_hr">';

					}
				}
			}
		}

		echo $message;

		?>
	</div>
</div>
