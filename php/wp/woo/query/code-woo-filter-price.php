<?php
$query = array(
    'post_status' => 'publish',
    'post_type' => 'product',
    'posts_per_page' => 10,
    'meta_query' => array(
        array(
            'key' => '_price',
            'value' => array(50, 100),
            'compare' => 'BETWEEN',
            'type' => 'NUMERIC'
        )
    )
);