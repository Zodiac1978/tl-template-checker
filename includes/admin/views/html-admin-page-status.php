<div class="wrap woocommerce">
	<div class="icon32 icon32-woocommerce-status" id="icon-woocommerce"><br /></div>
	<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
		<?php
			$tabs = array(
				'status' => __( 'Template Check', 'tl-template-checker' ),
				'diff'  => __( 'Diff', 'tl-template-checker' ),
			);
			foreach ( $tabs as $name => $label ) {
				echo '<a href="' . admin_url( 'admin.php?page=wc-status&amp;tab=' . $name ) . '" class="nav-tab ';
				if ( $current_tab == $name ) echo 'nav-tab-active';
				echo '">' . $label . '</a>';
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