<div class="wrap">
	<form method="post" action="options.php">
		<?php
		settings_fields( 'formstack_plugin' );

		do_settings_sections( 'formstack_plugin_do_options' );

		submit_button( esc_attr__( 'Save Changes', 'formstack' ) ); ?>
	</form>

	<?php
	$api_key = get_option( 'formstack_api_key' );
	if ( $api_key ) {
		?>

		<h3 class="formstack-status">
			<?php esc_html_e( 'Status', 'formstack' ); ?>
		</h3>
		<?php

		if ( false === ( $res = get_transient( 'formstack_api_response_options' ) ) ) {
			$res = wp_remote_get( "https://www.formstack.com/api/forms?api_key={$api_key}&type=json", array( 'timeout' => 30 ) );
			set_transient( 'formstack_api_response_options', $res, 1800 );
		}

		if ( ! is_wp_error( $res ) ) {
			$res    = json_decode( wp_remote_retrieve_body( $res ) );
			$status = isset( $res->status ) ? esc_html( $res->status ) : '';
			$error  = isset( $res->error ) ? esc_html( $res->error ) : '';
			$form_count = isset( $res->response->forms ) ? count( $res->response->forms ) : '0';
			?>

			<ul>
				<?php
				printf(
					'<li>%s</li>',
					sprintf(
						__( 'API Key: %s', 'formstack' ),
						sprintf(
							'<strong>%s</strong>',
							$status
						)
					)
				);
				if ( $error ) {
					printf(
						'<li class="error">%s</li>',
						sprintf(
							__( 'API Error: %s', 'formstack' ),
							sprintf(
								'<strong>%s</strong>',
								$error
							)
						)
					);
				}
				printf(
					sprintf(
						'<li>%s</li>',
						sprintf(
							__( 'Available Forms: %s', 'formstack' ),
							sprintf(
								'<strong>%d</strong>',
								$form_count
							)
						)
					)
				);
				printf(
					'<li>%s</li>',
					sprintf(
						__( 'PHP Version: %s', 'formstack' ),
						sprintf(
							'<strong>%s</strong>',
							PHP_VERSION
						)
					)
				);
			?>
			</ul>
		<?php
		}
	}
?>

</div>
