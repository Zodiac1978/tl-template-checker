<?php
/**
 * Admin View: Page Status
 *
 * @package TLTemplateChecker
 */

?>

<div class="wrap">
	<h1><?php echo esc_html_x( 'Child Theme Check', 'Page and Menu Title', 'child-theme-check' ); ?></h1>

<?php if ( ! is_child_theme() ) { ?>

	<div class="notice notice-error">
		<p><?php esc_html_e( 'There is no active child theme. You have to activate a child theme under Themes to use this plugin.', 'child-theme-check' ); ?></p>
		<p class="submit"><a class="button-primary" href="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>"><?php esc_html_e( 'Themes', 'child-theme-check' ); ?></a></p>
	</div>
</div>

<?php } else { ?>

		<h2 class="nav-tab-wrapper">
			<?php
			$tabs = array(
				'status' => __( 'Status', 'child-theme-check' ),
				'diff'   => __( 'Diff', 'child-theme-check' ),
			);
			foreach ( $tabs as $name => $label ) {
				printf( '<a href="%s" class="nav-tab %s">%s</a>',
					esc_url( admin_url( 'admin.php?page=tplc-status&amp;tab=' . $name ) ),
					$current_tab === $name ? 'nav-tab-active' : '',
					esc_html( $label )
				);
			}
			?>
		</h2><br/>
		<?php
		switch ( $current_tab ) {
			case 'diff':
				TPLC_Admin_Status::status_diff();
				break;
			default:
				TPLC_Admin_Status::status_report();
				break;
		}
		?>
	</div>

<?php } ?>
