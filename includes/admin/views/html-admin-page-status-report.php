<?php
/**
 * Admin View: Page - Status Report
 *
 * @package TLTemplateChecker
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<table class="tplc_status_table widefat" id="status">
	<thead>
	<tr>
		<th><?php esc_html_e( 'Templates', 'child-theme-check' ); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php

	$tplc_found_files = array();

	foreach ( TPLC_Admin_Status::get_template_overrides() as $tplc_override ) {
		$tplc_template_file  = '<code>' . esc_html( basename( $tplc_override['child_path'] ) ) . '</code>';
		$tplc_parent_version = $tplc_override['parent_version'];
		$tplc_child_version  = $tplc_override['child_version'];

		if ( 'outdated' === $tplc_override['status'] ) {
			$tplc_found_files[] = sprintf(
				'%1$s %2$s: %3$s %4$s',
				'<span class="dashicons dashicons-no-alt" style="color:red"></span>',
				$tplc_template_file,
				sprintf(
					/* translators: %s Version number. */
					__( 'Child theme version %s is out of date.', 'child-theme-check' ),
					'<strong style="color:red">' . esc_html( $tplc_child_version ) . '</strong>'
				),
				sprintf(
					/* translators: %s Version number. */
					__( 'Parent theme version is %s.', 'child-theme-check' ),
					'<strong>' . esc_html( $tplc_parent_version ) . '</strong>'
				)
			);
		} elseif ( 'missing_child_version' === $tplc_override['status'] ) {
			$tplc_found_files[] = sprintf(
				'%1$s %2$s: %3$s %4$s',
				'<span class="dashicons dashicons-info" style="color:orange"></span>',
				$tplc_template_file,
				__( 'Child theme is missing version keyword.', 'child-theme-check' ),
				sprintf(
					/* translators: %s Version number. */
					__( 'Parent theme version is %s.', 'child-theme-check' ),
					'<strong>' . esc_html( $tplc_parent_version ) . '</strong>'
				)
			);
		} elseif ( 'missing_parent_version' === $tplc_override['status'] ) {
			$tplc_found_files[] = sprintf(
				'%1$s %2$s: %3$s',
				'<span class="dashicons dashicons-minus"></span>',
				$tplc_template_file,
				__( 'Parent theme is missing version keyword.', 'child-theme-check' )
			);
		} else {
			$tplc_found_files[] = sprintf(
				'%1$s %2$s: %3$s',
				'<span class="dashicons dashicons-yes" style="color:green"></span>',
				$tplc_template_file,
				sprintf(
					/* translators: %s Version number. */
					__( 'Child theme version %s matches parent theme.', 'child-theme-check' ),
					$tplc_child_version ? '<strong style="color:green">' . esc_html( $tplc_child_version ) . '</strong>' : '-'
				)
			);
		}
	}

	if ( $tplc_found_files ) {
		$tplc_allowed_status_html = array(
			'br'     => array(),
			'code'   => array(),
			'strong' => array(
				'style' => array(),
			),
			'span'   => array(
				'class' => array(),
				'style' => array(),
			),
		);

		$tplc_theme    = wp_get_theme();
		$tplc_template = wp_get_theme( $tplc_theme->template );
		?>
		<tr>
			<td>
			<?php
			printf(
				/* translators: %1$s Name of child theme, %2$s Name of parent theme. */
				esc_html__( 'Template overrides by %1$s for %2$s:', 'child-theme-check' ),
				'<abbr title="' . esc_attr__( 'Child Theme', 'child-theme-check' ) . '">' . esc_html( $tplc_theme ) . '</abbr>',
				'<abbr title="' . esc_attr__( 'Parent Theme', 'child-theme-check' ) . '">' . esc_html( $tplc_template ) . '</abbr>'
			);
			?>
			</td>
		</tr>
		<tr>
			<td><?php echo wp_kses( implode( '<br>', $tplc_found_files ), $tplc_allowed_status_html ); ?></td>
		</tr>

		<?php
	} else {
		?>
		<tr>
			<td><?php esc_html_e( 'No overrides present in child theme.', 'child-theme-check' ); ?></td>
		</tr>
		<?php
	}
	?>
</tbody>
</table>
