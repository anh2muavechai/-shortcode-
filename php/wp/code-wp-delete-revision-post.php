define('AUTOSAVE_INTERVAL', 300 ); // seconds
define('WP_POST_REVISIONS', false );

DELETE FROM wp_posts WHERE post_type = "revision";