$('body').on( 'added_to_cart', function( ev, fragmentsJSON, cart_hash, button ){

	if( typeof fragmentsJSON == 'undefined' )
		fragmentsJSON = $.parseJSON( sessionStorage.getItem( wc_cart_fragments_params.fragment_name ) );

		$.each( fragmentsJSON, function( key, value ) {
		console.log(key);

	});
});