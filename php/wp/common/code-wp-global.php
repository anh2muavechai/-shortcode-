<?php
$GLOBALS['_menu_item_sort_prop'];
$GLOBALS['_wp_sidebars_widgets'];
$GLOBALS['blog_id'];
$GLOBALS['body_id'];
$GLOBALS['comment'];
$GLOBALS['comment_depth'];
$GLOBALS['content_width'];
$GLOBALS['current_site'];
$GLOBALS['current_user'];
$GLOBALS['custom_background'];
$GLOBALS['custom_image_header'];
$GLOBALS['debug_bar'];
$GLOBALS['editor_styles'];
$GLOBALS['is_winIE'];
$GLOBALS['link'];
$GLOBALS['login_grace_period'];
$GLOBALS['month'];
$GLOBALS['month_abbrev'];
$GLOBALS['more'];
$GLOBALS['post'];
$GLOBALS['post_type'];
$GLOBALS['posts'];
$GLOBALS['query_string'];
$GLOBALS['request'];
$GLOBALS['single'];
$GLOBALS['submenu'];
$GLOBALS['tab'];
$GLOBALS['type'];
$GLOBALS['weekday'];
$GLOBALS['weekday_abbrev'];
$GLOBALS['weekday_initial'];
$GLOBALS['wp_admin_bar'];
$GLOBALS['wp_filter'];
$GLOBALS['wp_object_cache'];
$GLOBALS['wp_post_types'];
$GLOBALS['wp_query'];
$GLOBALS['wp_styles'];
$GLOBALS['wp_taxonomies'];
$GLOBALS['wp_the_query'];
$GLOBALS['wp_version'];


add_action( 'shutdown', 'print_them_globals' );
function print_them_globals() {

    ksort( $GLOBALS );
    echo '<ol>';
    echo '<li>'. implode( '</li><li>', array_keys( $GLOBALS ) ) . '</li>';
    echo '</ol>';
}