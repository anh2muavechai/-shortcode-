<?php
// change template cho single của 1 category
//change templatet for cat công trình
add_filter( 'single_template', function ( $template )
{
    // Get the current single post
    $post_id = $GLOBALS['wp_the_query']->get_queried_object_id();

    // Test to see if our post belongs to category 1
    if ( !in_category( 18, $post_id ) ) {
        return $template;
    }

    // Our post is attached to category 1, lets look for single-1.php
    $locate_template = locate_template( 'single-cong-trinh.php' );

    // Test if our template exist, if so, include it, otherwise bail
    if ( !$locate_template ) {
        return $template;
    }

    return $locate_template;
});