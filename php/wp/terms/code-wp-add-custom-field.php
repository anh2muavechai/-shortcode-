<?php
// Add custom Theme Functions here
add_action ( 'edit_category_form_fields', function( $tag ){
    $_layout = get_term_meta( $tag->term_id, '_layout', true ); ?>
    <tr class='form-field'>
        <th scope='row'><label for='cat_page_title'><?php _e('Category layout'); ?></label></th>
        <td>
            <select name="_layout">
            	<option value="0" <?php echo (isset($_layout) && $_layout == '0' )?'selected':'' ?>>Layout 1</option>
            	<option value="1" <?php echo (isset($_layout) && $_layout == '1' )?'selected':'' ?>>Layout 2</option>
            	<option value="2" <?php echo (isset($_layout) && $_layout == '2' )?'selected':'' ?>>Layout 3</option>
            </select>
            <p class='description'><?php _e('Layout for the Category '); ?></p>
        </td>
    </tr> <?php
});
add_action ( 'edited_category', function() {
    if ( isset( $_POST['_layout'] ) )
        update_term_meta( $_POST['tag_ID'], '_layout', $_POST['_layout'] );
});