<?php

/**
 * Admin View: Page - Status Diff
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<script>
jQuery(function($){
	$(document).ready(function(){
		$(".diff-wrapper").hide();
		$("h3.trigger").click(function(){
			$(this).toggleClass("active").next(".diff-wrapper").slideToggle("normal");
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
		$core_version = TPLC_Admin_Status::get_file_content( get_template_directory() . '/' . $file );

		$theme_version = TPLC_Admin_Status::get_file_content( $theme_file );

		/* $args = array(
			'title'           => 'Differences',
			'title_left'      => 'Parent Theme',
			'title_right'     => 'Child Theme'
		); */

		$diff_table = wp_text_diff($core_version,$theme_version);
		echo '<h3 class="trigger">Diff for template file: ' . $file . '</h3>';

		if ($diff_table) {
			echo '<div class="diff-wrapper">';
			echo '<table class="diff diffheader"><tr><th>Parent Theme</th><th style="width: 4%;">&nbsp;</th><th>Child Theme</th></tr></table>';
			echo $diff_table;
			echo '</div>';
		} else {
			echo '<div class="diff-wrapper">';
			echo '<p class="diff">No differences.</p>';
			echo '</div>';
		}

		echo '<hr style="margin: 25px 0">';

	}
}
}
?>

	</div>
</div>
