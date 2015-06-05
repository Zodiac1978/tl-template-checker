<div class="wrap">
	<h2 class="nav-tab-wrapper">
		<?php
			$tabs = array(
				'status' => __( 'Child Theme Check', 'tl-template-checker' ),
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