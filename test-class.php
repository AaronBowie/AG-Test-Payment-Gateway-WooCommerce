<?php
# @Author: Aaron Bowie
# @Date:   Monday, September 10th 2018, 3:09:00 pm
# @Email:  support@weareag.co.uk
# @Filename: test-class.php
# @Last modified by:   Aaron Bowie
# @Last modified time: Tuesday, September 11th 2018, 2:30:07 pm


/* Test Payment Gateway Class */

defined('ABSPATH') or die("No script kiddies please!");

class ag_test_gateway extends WC_Payment_Gateway {

	function __construct() {
		$this->id = "ag_test_gateway";
		$this->method_title = __( "AG Test Payment Gateway", 'ag_test_gateway' );
		$this->title = __( "AG Test Payment Gateway", 'ag_test_gateway' );
		$this->has_fields = false;
		$this->init_form_fields();
		$this->init_settings();

		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
	} // End __construct()


	// Build the administration fields for this gateway
	function init_form_fields() {
		$this->form_fields = array(
			'enabled' => array(
				'title'		=> __( 'Enable / Disable', 'ag_test_gateway' ),
				'label'		=> __( 'Enable this payment gateway', 'ag_test_gateway' ),
				'type'		=> 'checkbox',
				'default'	=> 'yes',
			),
			'enabled_non_admin' => array(
				'title' => __( 'Enable for visitors', 'ag_test_gateway' ),
				'type' => 'checkbox',
				'label' => __( 'Allow non admins to use this gateway (for testing or for paymentless stores)', 'ag_test_gateway' ),
				'default' => 'no'
			),
		);
	}

	// Plugin settings page
	public function admin_options() {
		echo '	<h3>AG Test payment gateway</h3>
			<table class="form-table">';
				$this->generate_settings_html();
		echo '	</table>';
	}


	// Submit payment and handle response
	public function process_payment( $order_id ) {
		global $woocommerce;
		// Get this Order's information so that we know
		$customer_order = new WC_Order( $order_id );
		$customer_order->payment_complete();
		$customer_order->reduce_order_stock();
		$woocommerce->cart->empty_cart();

		// Order note
		$noteTitle = 'Test transaction is confirmed.';
		$customer_order->add_order_note($noteTitle);

		// Redirect after "payment".
		return array(
			'result' => 'success',
			'redirect' => $customer_order->get_checkout_order_received_url()
		);

	}

} // End of ag_test_gateway
