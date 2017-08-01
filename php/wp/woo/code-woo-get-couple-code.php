<?php
$args = array(
    'posts_per_page'   => -1,
    'orderby'          => 'title',
    'order'            => 'asc',
    'post_type'        => 'shop_coupon',
    'post_status'      => 'publish',
);
$coupons = get_posts( $args );
$coupon_names = array();
foreach ( $coupons as $coupon ) {
    // Get the name for each coupon post
    $coupon_name = $coupon->post_title;
    array_push( $coupon_names, $coupon_name );
}
echo '<pre>';
print_r( $coupon_name );
echo '</pre>';
//lấy toàn bộ thông tin coupon code
// $coupon_obj = new WC_Coupon( $coupon->post_title );
//exit;