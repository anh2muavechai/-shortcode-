<?php
$args = array(
    'meta_query' => array(
        'relation' => 'AND',
        'query_one' => array(
            'key' => 'key_one',
            'value' => 'value_one', // Optional
        ),
        'query_two' => array(
            'key' => 'key_two',
            'compare' => 'EXISTS', // Optional
        ),
    ),
    'orderby' => array(
        'query_one' => 'ASC',
        'query_two' => 'DESC',
    ),
);