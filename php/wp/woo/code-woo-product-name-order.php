<?php
//1
// Tạo Label Colum Danh sach sản phẩm
add_filter( 'manage_edit-shop_order_columns', function( $columns ) {
//add columns
	$columns['product-name'] = __( 'Tên sản phẩm','Fox');
	return $columns;
}, 11 );

//2
// Thêm nội dung Gọi danh sách sản phẩm
add_action( 'manage_shop_order_posts_custom_column', function( $column ) {
//Biến toàn cầu
	global $post, $woocommerce, $item_id;
	$order = wc_get_order( $post->ID );
	switch ( $column ) {
		case 'product-name' :
		foreach ( $order->get_items() as $key => $item ) {
			$data = wc_get_order_item_meta( $key, '_product_id' );
			echo '<p style="font-size: 14px;font-weight: 500;"><a href="'.esc_url( get_permalink($data) ).'">#'.esc_attr( get_the_title( $data ) ).'</a></p>';
		}
	}
}, 10, 2 );