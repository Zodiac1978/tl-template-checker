<?php
/**
 * TLTemplateChecker Admin Functions
 *
 * @package     TLTemplateChecker
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Get all TLTemplateChecker screen ids
 *
 * @return array
 */
function tplc_get_screen_ids() {

	$screen_ids = array(
		'tools_page_tplc-status',
	);

	return $screen_ids;
}
