<?php
add_filter( 'gettext', function( $translated_text, $text, $domain ) {
	switch ( strtolower( $translated_text ) ) {
		case 'View Cart' :
		$translated_text = __( 'Đổi tên của cái Nút Đó ở đây', 'woocommerce' );
		break;
	}
	return $translated_text;
}, 20, 3 );