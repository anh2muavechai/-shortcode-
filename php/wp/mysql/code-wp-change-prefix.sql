RENAME table `wp_test_commentmeta` TO `wp_demo_commentmeta`;
RENAME table `wp_test_comments` TO `wp_demo_comments`;
RENAME table `wp_test_links` TO `wp_demo_links`;
RENAME table `wp_test_options` TO `wp_demo_options`;
RENAME table `wp_test_postmeta` TO `wp_demo_postmeta`;
RENAME table `wp_test_posts` TO `wp_demo_posts`;
RENAME table `wp_test_terms` TO `wp_demo_terms`;
RENAME table `wp_test_termmeta` TO `wp_demo_termmeta`;
RENAME table `wp_test_term_relationships` TO `wp_demo_term_relationships`;
RENAME table `wp_test_term_taxonomy` TO `wp_demo_term_taxonomy`;
RENAME table `wp_test_usermeta` TO `wp_demo_usermeta`;
RENAME table `wp_test_users` TO `wp_demo_users`;

SELECT * FROM `wp_demo_options` WHERE `option_name` LIKE '%wp_%'
SELECT * FROM `wp_demo_usermeta` WHERE `meta_key` LIKE '%wp_%'