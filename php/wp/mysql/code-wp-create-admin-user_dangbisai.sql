SET @username = 'admin';
SET @password = 'admin';
SET @nicename = 'admin';
SET @email_address = 'anh2muavechai@gmail.com';
SET @fullname = 'admin';
SET @wpdb_prefix = 'wpdemo_';
SET @wpdb_users_table = CONCAT(@wpdb_prefix,'', 'users');
SET @wpdb_usermeta_table = CONCAT(@wpdb_prefix,'', 'usermeta');

INSERT INTO @wpdb_users_table (`user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES (@username, MD5(@password), @nicename, @email_address, '', NOW(), '', '0', @fullname);

SET @user_id = LAST_INSERT_ID();

INSERT INTO @wpdb_usermeta_table (`user_id`, `meta_key`, `meta_value`) VALUES (@user_id, 'wp_capabilities', 'a:1:{s:13:"administrator";s:1:"1";}');
INSERT INTO @wpdb_usermeta_table (`user_id`, `meta_key`, `meta_value`) VALUES (@user_id, 'wp_user_level', '10');
INSERT INTO @wpdb_usermeta_table (`user_id`, `meta_key`, `meta_value`) VALUES (@user_id, 'rich_editing', 'true');
INSERT INTO @wpdb_usermeta_table (`user_id`, `meta_key`, `meta_value`) VALUES (@user_id, 'show_admin_bar_front', 'true');

SET @create_user      = CONCAT('INSERT INTO', @abcd);
SET @set_capabilities = CONCAT('INSERT INTO', @abcd);
SET @set_user_level   = CONCAT('INSERT INTO', @abcd);


PREPARE create_user FROM @create_user;
PREPARE set_capabilities FROM @set_capabilities;
PREPARE set_user_level FROM @set_user_level;

EXECUTE create_user USING @user_login, @user_password, @user_nicename, @user_email;
EXECUTE set_capabilities USING @user_login;
EXECUTE set_user_level USING @user_login;

DEALLOCATE PREPARE create_user;
DEALLOCATE PREPARE set_capabilities;
DEALLOCATE PREPARE set_user_level;
/*----------------------------------------------------------------------------------------------------------*/