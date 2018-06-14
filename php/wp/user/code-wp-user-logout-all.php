<?php
/**
 * Log the current user out.
 *
 * @since 2.5.0
 */
add_action('init', 'wp_logout');
function wp_logout() {
    wp_destroy_current_session();
    wp_clear_auth_cookie();

    /**
     * Fires after a user is logged-out.
     *
     * @since 1.5.0
     */
    do_action( 'wp_logout' );
}