<div class="wrap">
	<h2><?php _e( 'Child Theme Check', 'tl-template-checker' ); ?></h2>

<?php if ( ! is_child_theme() ) { ?>

	<div id="message" class="updated">
		<p><?php _e( 'There is no active child theme. You have to activate a child theme under Themes to use this plugin.', 'tl-template-checker' ); ?></p>
		<p class="submit"><a class="button-primary" href="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>"><?php _e( 'Themes', 'tl-template-checker' ); ?></a></p>
	</div>
</div>

<?php } else { ?>

		<h2 class="nav-tab-wrapper">
			<?php
				$tabs = array(
					'status' => __( 'Status', 'tl-template-checker' ),
					'diff'  => __( 'Diff', 'tl-template-checker' ),
				);
				foreach ( $tabs as $name => $label ) {
					printf( '<a href="%s" class="nav-tab %s">%s</a>',
						esc_url( admin_url( 'admin.php?page=tplc-status&amp;tab=' . $name ) ),
						$current_tab == $name ? 'nav-tab-active' : '',
						$label
					);
				}
			?>
		</h2><br/>
		<?php
			switch ( $current_tab ) {
				case "diff" :
	                TPLC_Admin_Status::status_diff();
				break;
				default :
	                TPLC_Admin_Status::status_report();
				break;
			}
		?>
	</div>

<?php } ?>