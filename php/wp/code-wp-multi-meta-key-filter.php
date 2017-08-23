$args = array(

    'post_type'        => POST_TYPE,
    'posts_per_page'   => 20,
    'no_found_rows'    => true,
    'suppress_filters' => false,
    //Se the meta query
    'meta_query'       => array(
        //comparison between the inner meta fields conditionals
        'relation'    => 'AND',
        //meta field condition one
        array(
            'key'          => 'is_hot',
            'value'        => '1',
            'compare'      => '=',
        ),
        //meta field condition one
        array(
            'key'          => 'offer_type',
            'value'        => 'deal',
            //I think you really want != instead of NOT LIKE, fix me if I'm wrong
            //'compare'      => 'NOT LIKE',
            'compare'      => '!=',
        )
    ),

);

$query = new WP_Query( $args );