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
		 * Cached template override data for the current request.
		 *
		 * @var array|null
		 */
		private static $template_overrides = null;

		/**
		 * Cached template scans for the current request.
		 *
		 * @var array
		 */
		private static $template_file_scans = array();

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
			$keyword   = apply_filters( 'tplc_version_keyword', '@version' );

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
		 * Get child theme template overrides and version metadata.
		 *
		 * @since 1.0.10
		 * @return array
		 */
		public static function get_template_overrides() {
			if ( null !== self::$template_overrides ) {
				return self::$template_overrides;
			}

			self::$template_overrides = array();
			$template_files           = self::get_parent_template_files();

			foreach ( $template_files as $file ) {
				if ( false === strpos( $file, '.php' ) ) {
					continue;
				}

				$child_path = get_stylesheet_directory() . '/' . $file;

				if ( ! file_exists( $child_path ) || 'functions.php' === basename( $file ) ) {
					continue;
				}

				$parent_path    = get_template_directory() . '/' . $file;
				$parent_version = self::get_file_version( $parent_path );
				$child_version  = self::get_file_version( $child_path );
				$status         = 'current';

				if ( $parent_version && $child_version && version_compare( $child_version, $parent_version, '<' ) ) {
					$status = 'outdated';
				} elseif ( ! $child_version && $parent_version ) {
					$status = 'missing_child_version';
				} elseif ( ! $parent_version ) {
					$status = 'missing_parent_version';
				}

				self::$template_overrides[] = array(
					'file'           => $file,
					'parent_path'    => $parent_path,
					'child_path'     => $child_path,
					'parent_version' => $parent_version,
					'child_version'  => $child_version,
					'status'         => $status,
				);
			}

			return self::$template_overrides;
		}

		/**
		 * Get cached parent theme template files.
		 *
		 * @since 1.0.10
		 * @return array
		 */
		private static function get_parent_template_files() {
			$theme     = wp_get_theme( get_template() );
			$cache_key = 'tplc_template_files_' . md5( get_template() . '|' . get_template_directory() . '|' . $theme->get( 'Version' ) );
			$files     = get_transient( $cache_key );

			if ( is_array( $files ) ) {
				return $files;
			}

			$files = self::scan_template_files( get_template_directory() . '/' );

			set_transient( $cache_key, $files, (int) apply_filters( 'tplc_template_files_cache_ttl', DAY_IN_SECONDS ) );

			return $files;
		}

		/**
		 * Check whether there are outdated child theme template overrides.
		 *
		 * @since 1.0.10
		 * @return bool
		 */
		public static function has_outdated_template_overrides() {
			foreach ( self::get_template_overrides() as $override ) {
				if ( 'outdated' === $override['status'] ) {
					return true;
				}
			}

			return false;
		}

		/**
		 * Scan the template files.
		 *
		 * @access public
		 * @param string $template_path Path to the template directory.
		 * @return array
		 */
		public static function scan_template_files( $template_path ) {
			if ( isset( self::$template_file_scans[ $template_path ] ) ) {
				return self::$template_file_scans[ $template_path ];
			}

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

			self::$template_file_scans[ $template_path ] = $result;

			return $result;
		}
	}

endif;

return new TPLC_Admin_Status();
