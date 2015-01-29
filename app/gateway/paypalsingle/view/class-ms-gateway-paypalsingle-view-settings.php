<?php

class MS_Gateway_Paypalsingle_View_Settings extends MS_View {

	public function to_html() {
		$fields = $this->prepare_fields();
		$gateway = $this->data['model'];

		ob_start();
		/** Render tabbed interface. */
		?>
		<div class="ms-wrap">
			<form class="ms-gateway-settings-form ms-form wpmui-ajax-update" data-ajax="<?php echo esc_attr( $gateway->id ); ?>">
				<?php
				$description = '';

				MS_Helper_Html::settings_box_header( '', $description );
				foreach ( $fields as $field ) {
					MS_Helper_Html::html_element( $field );
				}
				MS_Helper_Html::settings_box_footer();
				?>
			</form>
			<div class="buttons">
				<?php
				MS_Helper_Html::html_element(
					array(
						'type' => MS_Helper_Html::INPUT_TYPE_BUTTON,
						'value' => __( 'Close', MS_TEXT_DOMAIN ),
						'class' => 'close',
					)
				);

				MS_Helper_Html::html_element(
					array(
						'type' => MS_Helper_Html::INPUT_TYPE_SUBMIT,
						'value' => __( 'Save Changes', MS_TEXT_DOMAIN ),
						'class' => 'ms-submit-form',
						'data' => array(
							'form' => 'ms-gateway-settings-form',
						)
					)
				);
				?>
			</div>
		</div>
		<?php
		$html = ob_get_clean();
		return $html;
	}

	protected function prepare_fields() {
		$gateway = $this->data['model'];
		$action = MS_Controller_Gateway::AJAX_ACTION_UPDATE_GATEWAY;
		$nonce = wp_create_nonce( $action );


		$fields = array(
			'merchant_id' => array(
				'id' => 'paypal_email',
				'type' => MS_Helper_Html::INPUT_TYPE_TEXT,
				'title' => __( 'PayPal Email', MS_TEXT_DOMAIN ),
				'value' => $gateway->paypal_email,
				'class' => 'ms-text-large',
			),

			'paypal_site' => array(
				'id' => 'paypal_site',
				'type' => MS_Helper_Html::INPUT_TYPE_SELECT,
				'title' => __( 'PayPal Site', MS_TEXT_DOMAIN ),
				'field_options' => $gateway->get_paypal_sites(),
				'value' => $gateway->paypal_site,
				'class' => 'ms-text-large',
			),

			'mode' => array(
				'id' => 'mode',
				'type' => MS_Helper_Html::INPUT_TYPE_SELECT,
				'title' => __( 'PayPal Mode', MS_TEXT_DOMAIN ),
				'value' => $gateway->mode,
				'field_options' => $gateway->get_mode_types(),
				'class' => 'ms-text-large',
			),

			'pay_button_url' => array(
				'id' => 'pay_button_url',
				'type' => MS_Helper_Html::INPUT_TYPE_TEXT,
				'title' => __( 'Payment button label or url', MS_TEXT_DOMAIN ),
				'value' => $gateway->pay_button_url,
				'class' => 'ms-text-large',
			),

			'dialog' => array(
				'type' => MS_Helper_Html::INPUT_TYPE_HIDDEN,
				'name' => 'dialog',
				'value' => 'Gateway_' . ucfirst( $gateway->id ) . '_View_Dialog',
			),

			'gateway_id' => array(
				'type' => MS_Helper_Html::INPUT_TYPE_HIDDEN,
				'name' => 'gateway_id',
				'value' => $gateway->id,
			),
		);

		return $fields;
	}

}