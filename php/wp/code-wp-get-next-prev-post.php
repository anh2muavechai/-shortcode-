<?php
$post_id = $post->ID; // current post ID
$cat = get_the_category();
$current_cat_id = $cat[0]->cat_ID; // current category ID

$args = array(
    'category' => $current_cat_id,
    'orderby'  => 'post_date',
    'order'    => 'DESC'
);
$posts = get_posts( $args );
// get IDs of posts retrieved from get_posts
$ids = array();
foreach ( $posts as $thepost ) {
    $ids[] = $thepost->ID;
}
// get and echo previous and next post in the same category
$thisindex = array_search( $post_id, $ids );
$previd    = isset( $ids[ $thisindex - 1 ] ) ? $ids[ $thisindex - 1 ] : 0;
$nextid    = isset( $ids[ $thisindex + 1 ] ) ? $ids[ $thisindex + 1 ] : 0;

if ( $previd ) {
    ?><a rel="prev" href="<?php echo get_permalink($previd) ?>">Previous</a><?php
}
if ( $nextid ) {
    ?><a rel="next" href="<?php echo get_permalink($nextid) ?>">Next</a><?php
}