<?php
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
	
	unset($fields['billing']['billing_country']);
	unset($fields['billing']['billing_state']);
	unset($fields['billing']['billing_address_1']);
	unset($fields['billing']['billing_address_2']);
	unset($fields['billing']['billing_city']);
	unset($fields['billing']['billing_postcode']);
	
	unset($fields['shipping']['shipping_country']);
	unset($fields['shipping']['shipping_state']);
	unset($fields['shipping']['shipping_postcode']);
	unset($fields['shipping']['shipping_address_1']);
	unset($fields['shipping']['shipping_address_2']);
	unset($fields['shipping']['shipping_city']);
	
	return $fields;
}

//add
$fields['shipping']['shipping_phone'] = array(
	'label' => __('Phone', 'woocommerce'),
	'placeholder' => _x('Phone', 'placeholder', 'woocommerce'),
	'required' => false,
	'class' => array('form-row-wide'),
	'clear' => true
);