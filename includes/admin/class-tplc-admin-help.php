<?php
/**
 * Add some content to the help tab.
 *
 * @package     TLTemplateChecker
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'TPLC_Admin_Help', false ) ) {
	return new TPLC_Admin_Help();
}

/**
 * TPLC_Admin_Help Class
 */
class TPLC_Admin_Help {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		add_action( 'current_screen', array( $this, 'add_tabs' ), 50 );
	}

	/**
	 * Add help tabs.
	 */
	public function add_tabs() {
		$screen = get_current_screen();

		if ( ! $screen || ! in_array( $screen->id, tplc_get_screen_ids(), true ) ) {
			return;
		}

		$screen->add_help_tab(
			array(
				'id'      => 'tplc_docs_tab',
				'title'   => __( 'Documentation', 'child-theme-check' ),
				'content' =>

					'<p>' . __( 'Thank you for using Child Theme Check :)', 'child-theme-check' ) . '</p>' .

					'<p>' . __( 'Much more documention needs to be done here.', 'child-theme-check' ) . '</p>' .

					'<p><a href="https://github.com/Zodiac1978/tl-template-checker/" class="button button-primary">' . __( 'Child Theme Check Github project', 'child-theme-check' ) . '</a></p>',
			)
		);

		$screen->add_help_tab(
			array(
				'id'      => 'tplc_bugs_tab',
				'title'   => __( 'Found a bug?', 'child-theme-check' ),
				'content' =>

					/* translators: %s: Github URL */
					'<p>' . sprintf( __( 'If you find a bug within Child Theme Check you can create a ticket via <a href="%s">Github issues</a>.', 'child-theme-check' ), 'https://github.com/Zodiac1978/tl-template-checker/issues?state=open' ) . '</p>' .

					'<a href="https://wordpress.org/support/plugin/child-theme-check/" class="button">' . __( 'Community Support', 'child-theme-check' ) . '</a>' .

					'<p><a href="https://github.com/Zodiac1978/tl-template-checker/issues?state=open" class="button button-primary">' . __( 'Report a bug', 'child-theme-check' ) . '</a></p>',
			)
		);

		$screen->set_help_sidebar(
			'<p><strong>' . __( 'For more information:', 'child-theme-check' ) . '</strong></p>' .
			'<p><a href="https://wordpress.org/plugins/child-theme-check/" target="_blank">' . __( 'Project on WordPress.org', 'child-theme-check' ) . '</a></p>' .
			'<p><a href="https://github.com/Zodiac1978/tl-template-checker/" target="_blank">' . __( 'Project on Github', 'child-theme-check' ) . '</a></p>'
		);
	}

}

return new TPLC_Admin_Help();
