UPDATE `wp_users` SET `user_pass` = MD5( 'admin' ) WHERE `wp_users`.`user_login` = "admin"