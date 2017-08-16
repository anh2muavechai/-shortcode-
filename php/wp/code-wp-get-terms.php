 //Array of taxonomies to get terms for
 $taxonomies = array('tin-tuc-bds');
 $Catalog = get_category( get_query_var( 'tin-tuc-bds' ) );
 //Set arguments - don't 'hide' empty terms.
 $args = array(
     'hide_empty' => 0
 );

 $terms = get_terms( $taxonomies, $args);
 echo '<pre>';
 print_r($Catalog);
 print_r( $terms );
 echo '</pre>';
 exit;