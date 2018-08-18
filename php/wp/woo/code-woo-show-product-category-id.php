<?php
/**
 * Show ID in category product woo
 */
add_action( "manage_edit-product_cat_columns",          't5_add_col' );
add_filter( "manage_edit-product_cat_sortable_columns", 't5_add_col' );
add_filter( "manage_product_cat_custom_column",         't5_show_id', 10, 3 );
function t5_add_col( $columns ) {
    return $columns + array ( 'tax_id' => 'ID' );
}
function t5_show_id( $v, $name, $id ) {
    return 'tax_id' === $name ? $id : $v;
}
function t5_tax_id_style() {
    print '<style>#tax_id{width:4em}</style>';
}