<?php
// DeveWork.com
//这是一个可以修改woocommerce_get_price_html 函数默认输出的html代码的例子，
//作用是调换新旧价格的位置
//感谢http://wordpress.stackexchange.com/questions/83367/how-to-edit-the-get-price-html-on-woocommerce
add_filter( 'woocommerce_get_price_html', 'dw_change_default_price_html', 100, 2 );
function dw_change_default_price_html( $price,$product ){
    if ( $product->price > 0 ) {
      if ( $product->price && isset( $product->regular_price ) ) {
        $from = $product->regular_price;
        $to = $product->price;
        return '<ins><span class="amount">'.( ( is_numeric( $to ) ) ? woocommerce_price( $to ) : $to ) .'</span></ins>
        <del><span class="amount">'. ( ( is_numeric( $from ) ) ? woocommerce_price( $from ) : $from ) .' </span></del>';
      } else {
        $to = $product->price;
        return '<ins><span class="amount">' . ( ( is_numeric( $to ) ) ? woocommerce_price( $to ) : $to ) . '</span></ins>';
      }
   } else {
     return '免费';
   }
}
?>