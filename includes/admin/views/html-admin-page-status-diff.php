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
		foreach ( $scanned_files as $plugin_name => $files ) {
			foreach ( $files as $file ) {

				// skip if no php file
				if ( ! strpos( $file, '.php' ) )
					continue;

				$child_path = get_stylesheet_directory() . '/' . $file;

				// Exclude functions.php
				if ( file_exists( $child_path ) && basename( $file ) !== 'functions.php' ) {
					$theme_file = get_stylesheet_directory() . '/' . $file;
				} else {
					$theme_file = false;
				}

				if ( $theme_file ) {
					$core_version = TPLC_Admin_Status::get_file_content( get_template_directory() . '/' . $file );

					$theme_version = TPLC_Admin_Status::get_file_content( $theme_file );

					/* Broken table if used: @link https://core.trac.wordpress.org/ticket/25473

					$args = array(
						'title'           => 'Differences',
						'title_left'      => 'Parent Theme',
						'title_right'     => 'Child Theme'
					); */

					// This is important and is missing in codex :(
					$args = array( 'show_split_view' => true );

					$diff_table = wp_text_diff( $core_version, $theme_version, $args );
					printf(
						'<h3 class="trigger">%s %s</h3>',
						__('Diff for template file:', 'tl-template-checker'),
						$file
					);

					if ( $diff_table ) {
						printf(
							'<div class="diff-wrapper"><table class="diff diffheader"><tr><th>%s</th><th>&#160;</th><th>%s</th></tr></table>%s</div>',
							__( 'Parent Theme', 'tl-template-checker'),
							__( 'Child Theme', 'tl-template-checker'),
							$diff_table
						);
					} else {
						printf(
							'<div class="diff-wrapper"><div class="diff nodiff">%s</div></div>',
							__( 'No differences.', 'tl-template-checker')
						);
					}

					echo '<hr class="tplc_diff_hr">';

				}
			}
		}
		?>
	</div>
</div>
