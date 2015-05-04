<div class="wrap">
	<h2 class="nav-tab-wrapper">
		<?php
			$tabs = array(
				'status' => __( 'Template Check', 'tl-template-checker' ),
				'diff'  => __( 'Diff', 'tl-template-checker' ),
			);
			foreach ( $tabs as $name => $label ) {
				printf( '<a href="%s" class="nav-tab %s">%s</a>',
					esc_url( admin_url( 'admin.php?page=wc-status&amp;tab=' . $name ) ),
					$current_tab == $name ? 'nav-tab-active' : '',
					$label
				);
			}
		?>
	</h2><br/>
	<?php
		switch ( $current_tab ) {
			case "diff" :
				$this->status_diff();
			break;
			default :
				$this->status_report();
			break;
		}
	?>
</div>