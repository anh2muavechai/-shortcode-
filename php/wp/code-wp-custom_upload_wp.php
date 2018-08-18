<?php
/**
 * Custom upload folder
 */
add_filter('wp_handle_upload_prefilter', 'wpse_25894_handle_upload_prefilter');
add_filter('wp_handle_upload', 'wpse_25894_handle_upload');

function wpse_25894_handle_upload_prefilter( $file ) {
    add_filter('upload_dir', 'wpse_25894_custom_upload_dir');
    return $file;
}

function wpse_25894_handle_upload( $fileinfo ) {
    remove_filter('upload_dir', 'wpse_25894_custom_upload_dir');
    return $fileinfo;
}

function wpse_25894_custom_upload_dir($path) {
    /*
     * Determines if uploading from inside a post/page/cpt - if not, default Upload folder is used
     */
    $use_default_dir = ( isset($_REQUEST['post_id'] ) && $_REQUEST['post_id'] == 0 ) ? true : false; 
    if( !empty( $path['error'] ) || $use_default_dir )
        return $path; //error or uploading not from a post/page/cpt 

    /*
     * Save uploads in ID based folders 
     *
     */

    /*
     $customdir = '/' . $_REQUEST['post_id'];
    */


    /*
     * Save uploads in SLUG based folders 
     *
     */

     /*$the_post = get_post($_REQUEST['post_id']);
     $customdir = '/' . $the_post->post_name;*/


    /*
     * Save uploads in AUTHOR based folders 
     *
     * ATTENTION, CAUTION REQUIRED: 
     * This one may have security implications as you will be exposing the user names in the media paths
     * Here, the *display_name* is being used, but normally it is the same as *user_login*
     *
     * The right thing to do would be making the first/last name mandatories
     * And use:
     * $customdir = '/' . $the_author->first_name . $the_author->last_name;
     *
     */

    /* 
      $the_post = get_post($_REQUEST['post_id']);
      $the_author = get_user_by('id', $the_post->post_author);
      $customdir = '/' . $the_author->data->display_name;
    */

    $user_id = get_current_user_id();
    $customdir = '/' . $user_id;

    /*
     * Save uploads in FILETYPE based folders 
     * when using this method, you may want to change the check for $use_default_dir
     *
     */

    /*
     $extension = substr( strrchr( $_POST['name'], '.' ), 1 );
     switch( $extension )
     {
        case 'jpg':
        case 'png':
        case 'gif':
            $customdir = '/images';
            break;

        case 'mp4':
        case 'm4v':
            $customdir = '/videos';
            break;

        case 'txt':
        case 'doc':
        case 'pdf':
            $customdir = '/documents';
            break;

        default:
            $customdir = '/others';
            break;
     }
    */

    $path['path']    = str_replace($path['subdir'], '', $path['path']); //remove default subdir (year/month)
    $path['url']     = str_replace($path['subdir'], '', $path['url']);      
    $path['subdir']  = $customdir;
    $path['path']   .= $customdir; 
    $path['url']    .= $customdir;  

    return $path;
}
/*----------------------------------------------------------------------------------------------------------*/
/**
 * Chỉ cho user thấy hình mình đã up
 */
add_action('pre_get_posts','ml_restrict_media_library');
function ml_restrict_media_library( $wp_query_obj ) {
    global $current_user, $pagenow;
    if( !is_a( $current_user, 'WP_User') )
    return;
    if( 'admin-ajax.php' != $pagenow || $_REQUEST['action'] != 'query-attachments' )
    return;
    if( !current_user_can('manage_media_library') )
    $wp_query_obj->set('author', $current_user->ID );
    return;
}
/*----------------------------------------------------------------------------------------------------------*/
/**
 * Code Giới hạn dung lượng upload cho 1 file
 */
add_filter( 'upload_size_limit', 'wpse_163236_change_upload_size' ); 
function wpse_163236_change_upload_size() {
    // if ( ! current_user_can( 'manage_options' ) ) {
        // 10 MB.
        $size = 1024 * 1000;
    // }
    return $size;
}
/*----------------------------------------------------------------------------------------------------------*/
/*
-   Code giới hạn dung lượng upload file cho phép
-   Code chưa test
add_filter( 'wp_handle_upload', 'wpse47580_update_upload_stats' );
function wpse47580_update_upload_stats( $args ) {
    $file = $args['file'];
    $size = filesize( $file ); // bytes

    $user_id = get_current_user_id();

    $upload_count = get_user_meta( $user_id, 'upload_count', $single = true );
    $upload_bytes = get_user_meta( $user_id, 'upload_bytes', $single = true );

    update_user_meta( $user_id, 'upload_count', $upload_count + 1 );
    update_user_meta( $user_id, 'upload_bytes', $upload_bytes + $size );
}

add_filter( 'wp_handle_upload_prefilter', 'wpse47580_check_upload_limits' );
function wpse47580_check_upload_limits( $file ) {
    $user_id = get_current_user_id();

    $upload_count = get_user_meta( $user_id, 'upload_count', $single = true );
    $upload_bytes = get_user_meta( $user_id, 'upload_bytes', $single = true );

    // $filesize = get filesize from $file array /;
    $upload_bytes_limit_reached = apply_filters( 'wpse47580_upload_bytes_limit_reached', 1024*1024*10 ) > ( $filesize + $upload_bytes );
    $upload_count_limit_reached = apply_filters( 'wpse47580_upload_count_limit_reached', 100 ) > ( $upload_count + 1 );

    if ( $upload_count_limit_reached || $upload_bytes_limit_reached )
        $file['error'] = 'Upload limit has been reached for this account!';

    return $file;
}
*/