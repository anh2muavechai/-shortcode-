<?php
/*
 * Create order dynamically
 */
add_action( 'woocommerce_before_checkout_form', 'create_order' );
function create_order() {

	global $woocommerce;

	$address = array(
		'first_name' => 'Remi',
		'last_name'  => 'Corson',
		'company'    => 'Automattic',
		'email'      => 'no@spam.com',
		'phone'      => '123-123-123',
		'address_1'  => '123 Main Woo st.',
		'address_2'  => '100',
		'city'       => 'San Francisco',
		'state'      => 'Ca',
		'postcode'   => '92121',
		'country'    => 'US'
	);

	// Now we create the order
	$order = wc_create_order();

	// The add_product() function below is located in /plugins/woocommerce/includes/abstracts/abstract_wc_order.php
	$order->add_product( get_product( 99 ), 1); // Use the product IDs to add

	// Set addresses
	$order->set_address( $address, 'billing' );
	$order->set_address( $address, 'shipping' );

	// Set payment gateway
	$payment_gateways = WC()->payment_gateways->payment_gateways();
	$order->set_payment_method( $payment_gateways['bacs'] );

	// Calculate totals
	$order->calculate_totals();
	$order->update_status( 'Completed', 'Order created dynamically - ', TRUE);
}
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
$address = array(
    'first_name' => $customer_name,
    'last_name'  => '',
    'company'    => '',
    'email'      => $customer_email,
    'phone'      => $customer_phone,
    'address_1'  => '',
    'address_2'  => '',
    'city'       => '',
    'state'      => '',
    'postcode'   => '',
    'country'    => ''
  );

$order = wc_create_order();

// add products from cart to order
$items = WC()->cart->get_cart();
foreach($items as $item => $values) {
    $product_id = $values['product_id'];
    $product = wc_get_product($product_id);
    $var_id = $values['variation_id'];
    $var_slug = $values['variation']['attribute_pa_weight'];
    $quantity = (int)$values['quantity'];
    $variationsArray = array();
    $variationsArray['variation'] = array(
        'pa_weight' => $var_slug
    );
    $var_product = new WC_Product_Variation($var_id);
    $order->add_product($var_product, $quantity, $variationsArray);
}

$order->set_address( $address, 'billing' );
$order->set_address( $address, 'shipping' );

$order->calculate_totals();
$order->update_status( 'processing' );

WC()->cart->empty_cart();