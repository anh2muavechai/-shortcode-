<?php
// GET FEATURED IMAGE
function ST4_get_featured_image($post_ID) {
    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
    if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');//full
        return $post_thumbnail_img[0];
    }
}

wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

echo get_post_meta($post->ID, 'featured_image', true);