<?php
/**
 * WooCommerce Admin Functions
 *
 * @author      WooThemes
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Get all WooCommerce screen ids
 *
 * @return array
 */
function tplc_get_screen_ids() {

    $screen_ids   = array(
        'tools_page_tplc-status',
    );

    return $screen_ids;
}


