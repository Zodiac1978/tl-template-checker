<?php
/**
 * Debug/Status page
 *
 * @package     TLTemplateChecker
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'TPLC_Admin_Status' ) ) :

	/**
	 * TPLC_Admin_Status Class
	 */
	class TPLC_Admin_Status {

		/**
		 * Handles output of the reports page in admin.
		 */
		public static function output() {
			$tplc_current_tab = ! empty( $_REQUEST['tab'] ) ? sanitize_title( $_REQUEST['tab'] ) : 'status'; // @codingStandardsIgnoreLine.

			include_once 'views/html-admin-page-status.php';
		}

		/**
		 * Handles output of report
		 */
		public static function status_report() {

			include_once 'views/html-admin-page-status-report.php';

		}

		/**
		 * Handles output of diff
		 */
		public static function status_diff() {

			include_once 'views/html-admin-page-status-diff.php';

		}


		/**
		 * Retrieve complete content from a file. Based on WP Core's get_file_data function
		 *
		 * @since  1.0.0
		 * @param  string $file Path to the file.
		 */
		public static function get_file_content( $file ) {

			// Avoid notices if file does not exist or cannot be read.
			if ( ! is_file( $file ) || ! is_readable( $file ) ) {
				return '';
			}

			$content = file_get_contents( $file ); // @codingStandardsIgnoreLine.

			return false === $content ? '' : $content;
		}


		/**
		 * Retrieve metadata from a file. Based on WP Core's get_file_data function
		 *
		 * @since 1.0.0
		 * @param string $file Path to the file.
		 */
		public static function get_file_version( $file ) {

			// Avoid notices if file does not exist or cannot be read.
			if ( ! is_file( $file ) || ! is_readable( $file ) ) {
				return '';
			}

			// Pull only the first 8kiB of the file in.
			$file_data = file_get_contents( $file, false, null, 0, 8192 ); // @codingStandardsIgnoreLine.

			if ( false === $file_data ) {
				return '';
			}

			// Make sure we catch CR-only line endings.
			$file_data = str_replace( "\r", "\n", $file_data );
			$version   = '';
			$keyword   = apply_filters( 'tl_tplc_version_keyword', '@version' );

			if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( $keyword, '/' ) . '(.*)$/mi', $file_data, $match ) && $match[1] ) {
				$version = self::cleanup_header_comment( $match[1] );
			}

			return $version;
		}

		/**
		 * Clean trailing comment close tags from parsed file header values.
		 *
		 * @since 1.0.10
		 * @param string $str Header value.
		 * @return string
		 */
		private static function cleanup_header_comment( $str ) {
			return trim( preg_replace( '/\s*(?:\*\/|\?>).*/', '', $str ) );
		}

		/**
		 * Scan the template files.
		 *
		 * @access public
		 * @param string $template_path Path to the template directory.
		 * @return array
		 */
		public static function scan_template_files( $template_path ) {
			$files  = @scandir( $template_path ); // @codingStandardsIgnoreLine.
			$result = array();

			if ( ! empty( $files ) ) {

				foreach ( $files as $key => $value ) {

					if ( ! in_array( $value, array( '.', '..' ), true ) ) {

						if ( is_dir( $template_path . DIRECTORY_SEPARATOR . $value ) ) {
							$sub_files = TPLC_Admin_Status::scan_template_files( $template_path . DIRECTORY_SEPARATOR . $value );
							foreach ( $sub_files as $sub_file ) {
								$result[] = $value . DIRECTORY_SEPARATOR . $sub_file;
							}
						} else {
							$result[] = $value;
						}
					}
				}
			}
			return $result;
		}
	}

endif;

return new TPLC_Admin_Status();
