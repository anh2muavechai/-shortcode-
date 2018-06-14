<?php
//wp-config
define('AUTOSAVE_INTERVAL', 300 ); // seconds
define('WP_POST_REVISIONS', false );

//sql script
DELETE FROM wp_posts WHERE post_type = "revision";