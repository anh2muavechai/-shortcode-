<?php
add_action( "manage_edit-${taxonomy}_columns",          't5_add_col' );
add_filter( "manage_edit-${taxonomy}_sortable_columns", 't5_add_col' );
add_filter( "manage_${taxonomy}_custom_column",         't5_show_id', 10, 3 );
function t5_add_col( $columns ){
    return $columns + array ( 'tax_id' => 'ID' );
}
function t5_show_id( $v, $name, $id ){
    return 'tax_id' === $name ? $id : $v;
}
function t5_tax_id_style(){
    print '<style>#tax_id{width:4em}</style>';
}