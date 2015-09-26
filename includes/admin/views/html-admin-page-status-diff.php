<?php

/**
 * Admin View: Page - Status Diff
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<script>
jQuery( function($) {
	$(document).ready( function() {
		$( '.diff-wrapper' ).hide();
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

		$template_paths = array ( get_template_directory() . '/' );

		$scanned_files = array();
		$found_files   = array();
		foreach ( $template_paths as $plugin_name => $template_path ) {
			$scanned_files[ $plugin_name ] = TPLC_Admin_Status::scan_template_files( $template_path );
		}
		
		$message = __( 'There are no differences between child theme templates and parent theme templates.', 'child-theme-check' );

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

					$parent_content = TPLC_Admin_Status::get_file_content( get_template_directory() . '/' . $file );
					$child_content  = TPLC_Admin_Status::get_file_content( $theme_file );

					$parent_version = TPLC_Admin_Status::get_file_version( get_template_directory() . '/' . $file );
					$child_version  = TPLC_Admin_Status::get_file_version( $theme_file );

					/* Broken table if used: @link https://core.trac.wordpress.org/ticket/25473

					$args = array(
						'title'           => 'Differences',
						'title_left'      => 'Parent Theme',
						'title_right'     => 'Child Theme'
					); */

					// This is important and is missing in codex :(
					$args = array( 'show_split_view' => true );

					$diff_table = wp_text_diff( $parent_content, $child_content, $args );

					$theme = wp_get_theme();
					$template = wp_get_theme( $theme->template );

					if ( $diff_table ) {
						
						$message = ''; // reset message if diff found

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
							__('Diff for template file:', 'child-theme-check'),
							$file,
							$status
						);
						
						printf(
							'<div class="diff-wrapper"><table class="diff"><tr><th class="diffheader">%s:' . $template . '</th><th>&#160;</th><th class="diffheader">%s:' . $theme . '</th></tr></table>%s</div>',
							__( 'Parent Theme', 'child-theme-check'),
							__( 'Child Theme', 'child-theme-check'),
							$diff_table
						);

						echo '<hr class="tplc_diff_hr">';

					} 

				}

			}
		}

		echo $message;

		?>
	</div>
</div>
