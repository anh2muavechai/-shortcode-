<?php
if (!(is_admin() )) {
	add_filter( 'clean_url', function(){
		if ( FALSE === strpos( $url, '.js' ) ) return $url;
		if ( strpos( $url, 'jquery.js' ) ) return $url;
		return "$url' defer onload='";
	}, 11, 1 );
}