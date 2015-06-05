<?php

/**
 * Admin View: Notice - Template Check
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div id="message" class="updated">
	<p><?php _e( '<strong>The active child theme\'s parent has been updated and the child theme might have outdated copies of parent theme files</strong> &#8211; please ensure you update them manually. See the child theme check for more details.', 'tl-template-checker' ); ?></p>
	<p class="submit"><a class="button-primary" href="<?php echo esc_url( admin_url( 'admin.php?page=wc-status' ) ); ?>"><?php _e( 'Child Theme Check', 'tl-template-checker' ); ?></a> <a class="skip button-primary" href="<?php echo esc_url( add_query_arg( 'hide_template_files_notice', 'template_files' ) ); ?>"><?php _e( 'Hide this notice', 'tl-template-checker' ); ?></a></p>
</div>
