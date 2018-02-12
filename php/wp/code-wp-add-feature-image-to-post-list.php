<?php
/************************************************************************************************************/
// GET FEATURED IMAGE
function ST4_get_featured_image($post_ID) {
    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
    if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');
        return $post_thumbnail_img[0];
    }
}
// ADD NEW COLUMN
function ST4_columns_head($defaults) {
	$column_tmp = $default;
	$default = array();
    $defaults['featured_image'] = 'Featured Image';
	$default = array_merge($column_tmp,$default);
    return $defaults;
}

// SHOW THE FEATURED IMAGE
function ST4_columns_content($column_name, $post_ID) {
    if ($column_name == 'featured_image') {
        $post_featured_image = ST4_get_featured_image($post_ID);
        if ($post_featured_image) {
            echo '<img style="max-height:100px;max-width:100%" src="' . $post_featured_image . '" />';
        }
    }
}
// ONLY WORDPRESS DEFAULT POSTS
add_filter('manage_post_posts_columns', 'ST4_columns_head');
add_action('manage_post_posts_custom_column', 'ST4_columns_content', 10, 2);
// ONLY WORDPRESS DEFAULT PAGES
//add_filter('manage_page_posts_columns', 'ST4_columns_head', 10);
//add_action('manage_page_posts_custom_column', 'ST4_columns_content', 10, 2);