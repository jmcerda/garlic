<?php
/**
 * Formstack Form Widget
 *
 * @package Formstack
 * @author Formstack
 */

/**
 * Class Formstack_Widget
 */
class Formstack_Widget extends WP_Widget {

	private $fields = array( 'formkey', 'formstack_api_key' );

	/**
	 * Formstack_Widget constructor.
	 */
	public function __construct() {
		parent::__construct(
			'fs_wp_widget',
			esc_html__( 'Formstack', 'formstack' ),
			array( 'description' => esc_html__( 'Easily embed Formstack forms into your sidebar.', 'formstack' ) ),
			array( 'width' => 200 )
		);
	}

	/**
	 * Render our frontend output.
	 *
	 * @since unknown
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		if ( empty( $instance['formkey'] ) ) {
			return;
		}

		list( $form ) = explode( '-', $instance['formkey'] );
		$wp = wp_remote_get( "https://www.formstack.com/forms/wp-ad.php?form={$form}" );
		$script_url = "https://www.formstack.com/forms/js.php?{$instance['formkey']}";
		$noscript_url = "https://www.formstack.com/forms/?{$instance['formkey']}";
	    ?>

		<div class="fs_wp_sidebar">
			<script type="text/javascript" src="<?php echo esc_url( $script_url ); ?>"></script>
			<noscript>
				<a href="<?php echo esc_url( $noscript_url ); ?>" title="<?php esc_attr_e( 'Online Form', 'formstack' ); ?>"><?php esc_html_e( 'Online Form', 'formstack' ); ?></a>
			</noscript>
			<?php
				echo wp_remote_retrieve_body( $wp );
			?>
		</div>
	<?php

	}

	/**
	 * Save our widget settings.
	 *
	 * @since unknown
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		foreach ( $this->fields as $i => $field ) {
			$instance[ $field ] = strip_tags( $new_instance[ $field ] );
		}

		return $instance;
	}

	/**
	 * Render our admin side widget form.
	 *
	 * @since unknown
	 *
	 * @param array $instance
	 * @return mixed
	 */
	public function form( $instance ) {

		$api_key = isset( $instance['formstack_api_key'] ) ? $instance['formstack_api_key'] : '';

		if ( empty( $api_key ) ) {
			$api_key = get_option( 'formstack_api_key' );
		}

		$key_field_id   = $this->get_field_id( 'formstack_api_key' );
		$key_field_name = $this->get_field_name( 'formstack_api_key' );

		if ( empty( $api_key ) ) {
			echo $this->empty_api_key( $key_field_id, $key_field_name );
			return;
		}

		if ( false === ( $res = get_transient( 'formstack_api_response' ) ) ) {
			$res = Formstack_API::request( $api_key, 'forms' );
			set_transient( 'formstack_api_response', $res, 1800 );
		}

		if ( isset( $res->status ) && 'error' == $res->status ) {
			echo $this->empty_api_key( $key_field_id, $key_field_name );
			return;
		} elseif ( isset( $res->status ) && 'ok' != $res->status ) {
			echo $this->api_error();
			return;
		}

		$fields = array();
		foreach ( $this->fields as $i => $field ) {
			$fields[ $field ] = array(
				'id'    => $this->get_field_id( $field ),
				'name'  => $this->get_field_name( $field ),
				'value' => ( isset( $instance[ $field ] ) ) ? esc_attr( $instance[ $field ] ) : '',
			);
		}
		?>
		<p>
			<label for="<?php echo $fields['formkey']['id']; ?>">
				<?php esc_html_e( 'Choose a form to embed:', 'formstack' ); ?>
				<select class="widefat" name="<?php echo $fields['formkey']['name']; ?>" id="<?php echo $fields['formkey']['id']; ?>">
				<?php
				if ( '' == $fields['formkey']['value'] ) { ?>
					<option value=''></option>
				<?php
				}

				$forms = ( ! empty( $res->response->forms ) && is_array( $res->response->forms ) ) ? $res->response->forms : array();
				foreach ( $forms as $form ) {
					$sel = selected( $fields['formkey']['value'], "{$form->id}-{$form->viewkey}", false );
					?>
					<option <?php echo $sel; ?> value="<?php echo "{$form->id}-{$form->viewkey}"; ?>">
						<?php echo esc_html( $form->name ); ?></option>
					<?php
				}
				?>
				</select>
			</label>
			<input type="hidden" name="<?php echo $key_field_name; ?>" id="<?php echo $key_field_id; ?>" value="<?php echo $api_key; ?>" />
		</p>
		<?php
	}

	/**
	 * Output our empty API form element.
	 *
	 * @since 1.0.11
	 *
	 * @param string $key_field_id   Key field ID.
	 * @param string $key_field_name Key field name.
	 */
	public function empty_api_key( $key_field_id = '', $key_field_name = '' ) {
		?>
		<p>
			<label for="<?php echo esc_attr( $key_field_id ); ?>"><?php esc_html_e( 'API Key:', 'formstack' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $key_field_id ); ?>" name="<?php echo esc_attr( $key_field_name ); ?>" type="text" />
		</p>
	<?php
	}

	/**
	 * Output our API error markup.
	 *
	 * @since 1.0.11
	 */
	public function api_error() {
		?>
		<p>
			<strong><?php esc_html_e( 'An error has occured: It seems Formstack is unreachable. Please try again soon.', 'formstack' ); ?></strong>
		</p>
		<?php
	}
}

/**
 * Register our widget.
 *
 * @since unknown
 */
function formstack_widget_init() {
	register_widget( 'Formstack_Widget' );
}
add_action( 'widgets_init', 'formstack_widget_init' );
