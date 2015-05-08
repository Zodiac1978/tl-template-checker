<?php
/**
 * WooCommerce Admin Functions
 *
 * @author      WooThemes
 * @category    Core
 * @package     WooCommerce/Admin/Functions
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Get all WooCommerce screen ids
 *
 * @return array
 */
function tplc_get_screen_ids() {

    $screen_ids   = array(
        'tools_page_wc-status',
    );

    return $screen_ids;
}


