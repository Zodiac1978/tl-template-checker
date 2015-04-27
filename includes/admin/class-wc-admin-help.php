<?php
/**
 * Add some content to the help tab.
 *
 * @author 		WooThemes
 * @category 	Admin
 * @package 	WooCommerce/Admin
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'TPLC_Admin_Help' ) ) :

/**
 * TPLC_Admin_Help Class
 */
class TPLC_Admin_Help {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		add_action( "current_screen", array( $this, 'add_tabs' ), 50 );
	}

	/**
	 * Add help tabs
	 */
	public function add_tabs() {
		$screen = get_current_screen();

		if ( ! in_array( $screen->id, tplc_get_screen_ids() ) )
			return;

		$screen->add_help_tab( array(
		    'id'	=> 'tplc_docs_tab',
		    'title'	=> __( 'Documentation', 'tl-template-checker' ),
		    'content'	=>

		    	'<p>' . __( 'Thank you for using WooCommerce :) Should you need help using or extending WooCommerce please read the documentation.', 'tl-template-checker' ) . '</p>' .

		    	'<p><a href="' . 'http://docs.woothemes.com/documentation/plugins/woocommerce/' . '" class="button button-primary">' . __( 'WooCommerce Documentation', 'tl-template-checker' ) . '</a> <a href="' . 'http://docs.woothemes.com/wc-apidocs/' . '" class="button">' . __( 'Developer API Docs', 'tl-template-checker' ) . '</a></p>'

		) );

		$screen->add_help_tab( array(
		    'id'	=> 'tplc_support_tab',
		    'title'	=> __( 'Support', 'tl-template-checker' ),
		    'content'	=>

		    	'<p>' . sprintf(__( 'After <a href="%s">reading the documentation</a>, for further assistance you can use the <a href="%s">community forum</a>, or if you have access as a WooThemes customer, <a href="%s">our support desk</a>.', 'woocommerce' ), 'http://docs.woothemes.com/documentation/plugins/woocommerce/', 'http://wordpress.org/support/plugin/woocommerce', 'http://support.woothemes.com' ) . '</p>' .

		    	'<p>' . __( 'Before asking for help we recommend checking the status page to identify any problems with your configuration.', 'woocommerce' ) . '</p>' .

		    	'<p><a href="' . admin_url('admin.php?page=wc-status') . '" class="button button-primary">' . __( 'System Status', 'woocommerce' ) . '</a> <a href="' . 'http://wordpress.org/support/plugin/woocommerce' . '" class="button">' . __( 'Community Support', 'woocommerce' ) . '</a> <a href="' . 'http://support.woothemes.com' . '" class="button">' . __( 'Customer Support', 'woocommerce' ) . '</a></p>'

		) );

		$screen->add_help_tab( array(
		    'id'	=> 'tplc_bugs_tab',
		    'title'	=> __( 'Found a bug?', 'tl-template-checker' ),
		    'content'	=>

		    	'<p>' . sprintf(__( 'If you find a bug within WooCommerce core you can create a ticket via <a href="%s">Github issues</a>. Ensure you read the <a href="%s">contribution guide</a> prior to submitting your report. Be as descriptive as possible and please include your <a href="%s">system status report</a>.', 'tl-template-checker' ), 'https://github.com/woothemes/woocommerce/issues?state=open', 'https://github.com/woothemes/woocommerce/blob/master/CONTRIBUTING.md', admin_url( 'admin.php?page=wc-status' ) ) . '</p>' .

		    	'<p><a href="https://github.com/woothemes/woocommerce/issues?state=open" class="button button-primary">' . __( 'Report a bug', 'tl-template-checker' ) . '</a> <a href="' . admin_url('admin.php?page=wc-status') . '" class="button">' . __( 'System Status', 'tl-template-checker' ) . '</a></p>'

		) );


		$screen->set_help_sidebar(
			'<p><strong>' . __( 'For more information:', 'tl-template-checker' ) . '</strong></p>' .
			'<p><a href="http://www.woothemes.com/woocommerce/" target="_blank">' . __( 'About WooCommerce', 'tl-template-checker' ) . '</a></p>' .
			'<p><a href="http://wordpress.org/extend/plugins/woocommerce/" target="_blank">' . __( 'Project on WordPress.org', 'tl-template-checker' ) . '</a></p>' .
			'<p><a href="https://github.com/woothemes/woocommerce" target="_blank">' . __( 'Project on Github', 'tl-template-checker' ) . '</a></p>' .
			'<p><a href="http://www.woothemes.com/product-category/woocommerce-extensions/" target="_blank">' . __( 'Official Extensions', 'tl-template-checker' ) . '</a></p>' .
			'<p><a href="http://www.woothemes.com/product-category/themes/woocommerce/" target="_blank">' . __( 'Official Themes', 'tl-template-checker' ) . '</a></p>'
		);
	}

}

endif;

return new TPLC_Admin_Help();