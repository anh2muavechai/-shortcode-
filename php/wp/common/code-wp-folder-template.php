<?php
function hocwp_theme_page_templates( $post_templates ) {
    $dir = HOCWP_THEME_CUSTOM_PATH . '/page-templates';
    if ( is_dir( $dir ) ) {
        $files = scandir( $dir );
        foreach ( $files as $file ) {
            $info = pathinfo( $file );
            if ( isset( $info['extension'] ) && 'php' == $info['extension'] ) {
                $full_path = trailingslashit( $dir ) . $file;
                if ( ! preg_match( '|Template Name:(.*)$|mi', file_get_contents( $full_path ), $header ) ) {
                    continue;
                }
                $post_templates[ 'custom/page-templates/' . $file ] = _cleanup_header_comment( $header[1] );
            }
        }
    }
    return $post_templates;
}
add_filter( 'theme_page_templates', 'hocwp_theme_page_templates' );