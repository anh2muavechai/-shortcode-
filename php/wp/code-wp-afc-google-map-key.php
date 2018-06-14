/**
 * ACF Google Map Custom Field.
 */
function my_acf_google_map_api( $api ){
	$api['key'] = 'AIzaSyAcAuoQXUJ7nXZ5lyeTcOzfow_HKmVekuo';
	return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');