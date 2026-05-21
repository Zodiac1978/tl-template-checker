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

		$tplc_template_paths = array( get_template_directory() . '/' );

		$tplc_scanned_files = array();
		$tplc_found_files   = array();
		foreach ( $tplc_template_paths as $tplc_plugin_name => $tplc_template_path ) {
			$tplc_scanned_files[ $tplc_plugin_name ] = TPLC_Admin_Status::scan_template_files( $tplc_template_path );
		}

		$tplc_message           = __( 'There are no differences between child theme templates and parent theme templates.', 'child-theme-check' );
		$tplc_allowed_icon_html = array(
			'span' => array(
				'class' => array(),
				'style' => array(),
			),
		);
		$tplc_allowed_diff_html = array(
			'table' => array(
				'class' => array(),
			),
			'tbody' => array(),
			'thead' => array(),
			'tr'    => array(),
			'th'    => array(
				'class' => array(),
				'colspan' => array(),
			),
			'td'    => array(
				'class' => array(),
				'colspan' => array(),
			),
			'div'   => array(
				'class' => array(),
			),
			'span'  => array(
				'class' => array(),
			),
			'del'   => array(),
			'ins'   => array(),
		);

		foreach ( $tplc_scanned_files as $tplc_plugin_name => $tplc_files ) {
			foreach ( $tplc_files as $tplc_file ) {

				// Skip if no php file.
				if ( ! strpos( $tplc_file, '.php' ) ) {
					continue;
				}

				$tplc_child_path = get_stylesheet_directory() . '/' . $tplc_file;

				// Exclude functions.php.
				if ( file_exists( $tplc_child_path ) && basename( $tplc_file ) !== 'functions.php' ) {
					$tplc_theme_file = $tplc_child_path;
				} else {
					$tplc_theme_file = false;
				}

				if ( $tplc_theme_file ) {

					$tplc_parent_content = TPLC_Admin_Status::get_file_content( get_template_directory() . '/' . $tplc_file );
					$tplc_child_content  = TPLC_Admin_Status::get_file_content( $tplc_theme_file );

					$tplc_parent_version = TPLC_Admin_Status::get_file_version( get_template_directory() . '/' . $tplc_file );
					$tplc_child_version  = TPLC_Admin_Status::get_file_version( $tplc_theme_file );

					$tplc_theme    = wp_get_theme();
					$tplc_template = wp_get_theme( $tplc_theme->template );

					if ( version_compare( $GLOBALS['wp_version'], '5.7' ) >= 0 ) {
						$tplc_args = array(
							'title_left'      => esc_html__( 'Parent Theme', 'child-theme-check' ) . ': ' . esc_html( $tplc_template ),
							'title_right'     => esc_html__( 'Child Theme', 'child-theme-check' ) . ': ' . esc_html( $tplc_theme ),
							'show_split_view' => true,
						);
					} else {
						$tplc_args = array( 'show_split_view' => true );
					}

					$tplc_diff_table = wp_text_diff( $tplc_parent_content, $tplc_child_content, $tplc_args );

					if ( $tplc_diff_table ) {

						$tplc_message = ''; // Reset message if diff found.

						if ( $tplc_parent_version && $tplc_child_version && ( version_compare( $tplc_child_version, $tplc_parent_version, '<' ) ) ) {
							$tplc_status = '<span class="alignright dashicons dashicons-no-alt" style="color:red"></span>';
						} elseif ( ! $tplc_child_version && $tplc_parent_version ) {
							$tplc_status = '<span class="alignright dashicons dashicons-info" style="color:orange"></span>';
						} elseif ( ! $tplc_parent_version ) {
							$tplc_status = '<span class="alignright dashicons dashicons-minus"></span>';
						} else {
							$tplc_status = '<span class="alignright dashicons dashicons-yes" style="color:green"></span>';
						}

						printf(
							'<h3 class="trigger">%s %s %s</h3>',
							esc_html__( 'Diff for template file:', 'child-theme-check' ),
							esc_html( $tplc_file ),
							wp_kses( $tplc_status, $tplc_allowed_icon_html )
						);

						if ( version_compare( $GLOBALS['wp_version'], '5.7' ) >= 0 ) {
							printf(
								'<div class="diff-wrapper" style="display: none;">%s</div>',
								wp_kses( $tplc_diff_table, $tplc_allowed_diff_html )
							);
						} else {
							printf(
								'<div class="diff-wrapper" style="display: none;"><table class="diff"><tr><th class="diffheader">%s: ' . esc_html( $tplc_template ) . '</th><th>&#160;</th><th class="diffheader">%s: ' . esc_html( $tplc_theme ) . '</th></tr></table>%s</div>',
								esc_html__( 'Parent Theme', 'child-theme-check' ),
								esc_html__( 'Child Theme', 'child-theme-check' ),
								wp_kses( $tplc_diff_table, $tplc_allowed_diff_html )
							);
						}

						echo '<hr class="tplc_diff_hr">';

					}
				}
			}
		}

		echo esc_html( $tplc_message );

		?>
	</div>
</div>
