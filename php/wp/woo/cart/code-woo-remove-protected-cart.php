<?php
global $woocommerce;
$items = $woocommerce->cart->get_cart();
foreach ( $items as $item_key => $item_values ){
    // We set the cart item data in an array
	$wc_get_cart[$item_key] = $item_values;
		    // We remove the WC_Product object from this array
	unset($wc_get_cart[$item_key]['data']);
		    // We set the data with WC_Data get_data() method in a variable (array)
	$product_data = $item_values['data']->get_data();
		    // We set back this data
	$wc_get_cart[$item_key]['data'] = $product_data;
}