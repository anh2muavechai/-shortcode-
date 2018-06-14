<?php
/**
 * @param int  $post_id
 * @param WP_Post $post
 * @internal
 */
function _action_theme_save_recipe_post($post_id, $post) {
    if (
        $post->post_type
        !==
        'your-post-type-name' // fixme
    ) {
        return;
    }

    // fixme: maybe some verification, for e.g. check if current user is allowed to save these options
    {
        $allowed = ...;

        if (!$allowed) {
            return;
        }
    }

    /**
     * fixme: get option values from POST
     *
     * important: values structure must have the same structure as option types in backend http://static.md/180cfe2fc57017dd4ac6e8b5539f4042.png
     *            in order for fw_get_options_values_from_input() to work and extract option values correctly
     */
    $raw_POST_values = FW_Request::POST('some_key...');

    $old_values = (array)fw_get_db_post_option($post_id);
    $new_values = fw_get_options_values_from_input(
        fw()->theme->get_post_options($post->post_type),
        $raw_POST_values
    );

    fw_set_db_post_option(
        $post_id,
        null, // this means it will replace all option values, not only a specific option_id
        array_merge($old_values, $new_values)
    );
}
add_action('save_post', array($this, '_action_theme_save_recipe_post'), 11, 2);