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

		    	'<p>' . __( 'Thank you for using Child Theme Check :)', 'tl-template-checker' ) . '</p>' .

				'<p>' . __( 'Much more documention needs to be done here.', 'tl-template-checker' ) . '</p>' .		    	

		    	'<p><a href="' . 'https://github.com/Zodiac1978/tl-template-checker/' . '" class="button button-primary">' . __( 'Child Theme Check Github project', 'tl-template-checker' ) . '</a></p>'

		) );

		$screen->add_help_tab( array(
		    'id'	=> 'tplc_bugs_tab',
		    'title'	=> __( 'Found a bug?', 'tl-template-checker' ),
		    'content'	=>

		    	'<p>' . sprintf(__( 'If you find a bug within Child Theme Check you can create a ticket via <a href="%s">Github issues</a>.', 'tl-template-checker' ), 'https://github.com/Zodiac1978/tl-template-checker/issues?state=open' ) . '</p>' .

		    	//'<a href="' . 'http://wordpress.org/support/plugin/' . '" class="button">' . __( 'Community Support', 'tl-template-checker' ) . '</a> 

		    	'<p><a href="https://github.com/Zodiac1978/tl-template-checker/issues?state=open" class="button button-primary">' . __( 'Report a bug', 'tl-template-checker' ) . '</a></p>'

		) );


		$screen->set_help_sidebar(
			'<p><strong>' . __( 'For more information:', 'tl-template-checker' ) . '</strong></p>' .
			//'<p><a href="http://wordpress.org" target="_blank">' . __( 'Project on WordPress.org', 'tl-template-checker' ) . '</a></p>' .
			'<p><a href="https://github.com/Zodiac1978/tl-template-checker/" target="_blank">' . __( 'Project on Github', 'tl-template-checker' ) . '</a></p>'
		);
	}

}

endif;

return new TPLC_Admin_Help();