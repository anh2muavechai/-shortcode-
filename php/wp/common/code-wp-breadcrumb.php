<?php
/**
 * Breadcrumbs
 */
function ken_Breadcrumbs() {
       
    // Settings
    $separator          = '&gt;';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Homepage';
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
           
        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
              
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end(array_values($category));
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
              
            } else {
                  
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }
       
        echo '</ul>';
           
    }   
}

function ft_custom_breadcrumbs(array $options = array() ) {
    // default values assigned to options
    $options = array_merge(array(
        'crumbId'       => 'nav_crumb', // id for the breadcrumb Div
        'crumbClass'    => 'nav_crumb', // class for the breadcrumb Div
        'beginningText' => 'You are here :', // text showing before breadcrumb starts
        'showOnHome'    => 1,// 1 - show breadcrumbs on the homepage, 0 - don't show
        'delimiter'     => ' &gt; ', // delimiter between crumbs
        'homePageText'  => 'Home', // text for the 'Home' link
        'showCurrent'   => 1, // 1 - show current post/page title in breadcrumbs, 0 - don't show
        'beforeTag'     => '<span class="current">', // tag before the current breadcrumb
        'afterTag'      => '</span>', // tag after the current crumb
        'showTitle'     => 1 // showing post/page title or slug if title to show then 1
    ), $options);
    $crumbId       = $options['crumbId'];
    $crumbClass    = $options['crumbClass'];
    $beginningText = $options['beginningText'] ;
    $showOnHome    = $options['showOnHome'];
    $delimiter     = $options['delimiter'];
    $homePageText  = $options['homePageText'];
    $showCurrent   = $options['showCurrent'];
    $beforeTag     = $options['beforeTag'];
    $afterTag      = $options['afterTag'];
    $showTitle     =  $options['showTitle'];
    global $post;
    $wp_query = $GLOBALS['wp_query'];
    $homeLink = get_bloginfo('url');
    echo '<div id="'.$crumbId.'" class="'.$crumbClass.'" >'.$beginningText;
    if (is_home() || is_front_page()) {
        if ($showOnHome == 1)
            echo $beforeTag . $homePageText . $afterTag;
    } else {
        echo '<a href="' . $homeLink . '">' . $homePageText . '</a> ' . $delimiter . ' ';
        if ( is_category() ) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
            echo $beforeTag . 'Archive by category "' . single_cat_title('', false) . '"' . $afterTag;
        } elseif ( is_tax() ) {
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            $parents = array();
            $parent = $term->parent;
            while ( $parent ) {
                $parents[] = $parent;
                $new_parent = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
                $parent = $new_parent->parent;
            }
            if ( ! empty( $parents ) ) {
                $parents = array_reverse( $parents );
                foreach ( $parents as $parent ) {
                    $item = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ));
                    echo   '<a href="' . get_term_link( $item->slug, get_query_var( 'taxonomy' ) ) . '">' . $item->name . '</a>'  . $delimiter;
                }
            }
            $queried_object = $wp_query->get_queried_object();
            echo $beforeTag . $queried_object->name . $afterTag;
        } elseif ( is_search() ) {
            echo $beforeTag . 'Search results for "' . get_search_query() . '"' . $afterTag;
        } elseif ( is_day() ) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
            echo $beforeTag . get_the_time('d') . $afterTag;
        } elseif ( is_month() ) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo $beforeTag . get_the_time('F') . $afterTag;
        } elseif ( is_year() ) {
            echo $beforeTag . get_the_time('Y') . $afterTag;
        } elseif ( is_single() && !is_attachment() ) {
            if($showTitle)
                $title = get_the_title();
            else
                $title =  $post->post_name;
                if ( get_post_type() == 'product' ) { // it is for custom post type with custome taxonomies like
                    //Breadcrumb would be : Home Furnishings > Bed Covers > Cotton Quilt King Kantha Bedspread
                    // product = Cotton Quilt King Kantha Bedspread, custom taxonomy product_cat (Home Furnishings -> Bed Covers)
                    // show  product with category on single page
                    if ( $terms = wp_get_object_terms( $post->ID, 'product_cat' ) ) {
                        $term = current( $terms );
                        $parents = array();
                        $parent = $term->parent;
                        while ( $parent ) {
                            $parents[] = $parent;
                            $new_parent = get_term_by( 'id', $parent, 'product_cat' );
                            $parent = $new_parent->parent;
                        }
                        if ( ! empty( $parents ) ) {
                            $parents = array_reverse($parents);
                            foreach ( $parents as $parent ) {
                                $item = get_term_by( 'id', $parent, 'product_cat');
                                echo  '<a href="' . get_term_link( $item->slug, 'product_cat' ) . '">' . $item->name . '</a>'  . $delimiter;
                            }
                        }
                        echo  '<a href="' . get_term_link( $term->slug, 'product_cat' ) . '">' . $term->name . '</a>'  . $delimiter;
                    }
                    echo $beforeTag . $title . $afterTag;
                }  elseif ( get_post_type() != 'post' ) {
                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;
                    echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
                    if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $beforeTag . $title . $afterTag;
                } else {
                    $cat = get_the_category(); $cat = $cat[0];
                    $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                    if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
                    echo $cats;
                    if ($showCurrent == 1) echo $beforeTag . $title . $afterTag;
                }
        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
            $post_type = get_post_type_object(get_post_type());
            echo $beforeTag . $post_type->labels->singular_name . $afterTag;
        } elseif ( is_attachment() ) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID); $cat = $cat[0];
            echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
            echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
            if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $beforeTag . get_the_title() . $afterTag;
        } elseif ( is_page() && !$post->post_parent ) {
            $title =($showTitle)? get_the_title():$post->post_name;
            if ($showCurrent == 1) echo $beforeTag .  $title . $afterTag;
        } elseif ( is_page() && $post->post_parent ) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo $breadcrumbs[$i];
                if ($i != count($breadcrumbs)-1) echo ' ' . $delimiter . ' ';
            }
            $title =($showTitle)? get_the_title():$post->post_name;
            if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $beforeTag . $title . $afterTag;
        } elseif ( is_tag() ) {
            echo $beforeTag . 'Posts tagged "' . single_tag_title('', false) . '"' . $afterTag;
        } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata($author);
            echo $beforeTag . 'Articles posted by ' . $userdata->display_name . $afterTag;
        } elseif ( is_404() ) {
            echo $beforeTag . 'Error 404' . $afterTag;
        }
        if ( get_query_var('paged') ) {
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_tax() ) echo ' (';
            echo __('Page') . ' ' . get_query_var('paged');
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_tax() ) echo ')';
        }
    }
    echo '</div>';
}

/**
 * Display breadcrumbs.
 * 
 * @since  1.0.0.
 * @param  array  $args
 * @return string $html
 */
function anva_get_breadcrumbs( $args = array() ) {
    if ( is_front_page() ) {
        return;
    }
    global $post;
    $defaults  = array(
        'separator_icon'      => '/',
        'breadcrumbs_id'      => 'breadcrumb',
        'breadcrumbs_classes' => 'breadcrumb-trail breadcrumb',
        'home_title'          => __( 'Home', 'anva' )
    );
    $args      = apply_filters( 'anva_get_breadcrumbs_args', wp_parse_args( $args, $defaults ) );
    $separator = '<li class="separator"> ' . esc_attr( $args['separator_icon'] ) . ' </li>';
    
    // Open the breadcrumbs
    $html = '<ol id="' . esc_attr( $args['breadcrumbs_id'] ) . '" class="' . esc_attr( $args['breadcrumbs_classes'] ) . '">';
    
    // Add Homepage link & separator (always present)
    $html .= '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . esc_attr( $args['home_title'] ) . '">' . esc_attr( $args['home_title'] ) . '</a></li>';
    $html .= $separator;
    
    // Post
    if ( is_singular( 'post' ) ) {
        
        $category = get_the_category();
        $category_values = array_values( $category );
        $last_category = end( $category_values );
        $cat_parents = rtrim( get_category_parents( $last_category->term_id, true, ',' ), ',' );
        $cat_parents = explode( ',', $cat_parents );
        foreach ( $cat_parents as $parent ) {
            $html .= '<li class="item-cat">' . wp_kses( $parent, wp_kses_allowed_html( 'a' ) ) . '</li>';
            $html .= $separator;
        }
        $html .= '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';
    
    } elseif ( is_singular( 'page' ) ) {
        if ( $post->post_parent ) {
            $parents = get_post_ancestors( $post->ID );
            $parents = array_reverse( $parents );
            foreach ( $parents as $parent ) {
                $html .= '<li class="item-parent item-parent-' . esc_attr( $parent ) . '"><a class="bread-parent bread-parent-' . esc_attr( $parent ) . '" href="' . esc_url( get_permalink( $parent ) ) . '" title="' . get_the_title( $parent ) . '">' . get_the_title( $parent ) . '</a></li>';
                $html .= $separator;
            }
        }
        $html .= '<li class="item-current item-' . $post->ID . '"><span title="' . get_the_title() . '"> ' . get_the_title() . '</span></li>';
    } elseif ( is_singular( 'attachment' ) ) {
        $parent_id        = $post->post_parent;
        $parent_title     = get_the_title( $parent_id );
        $parent_permalink = esc_url( get_permalink( $parent_id ) );
        
        $html .= '<li class="item-parent"><a class="bread-parent" href="' . esc_url( $parent_permalink ) . '" title="' . esc_attr( $parent_title ) . '">' . esc_attr( $parent_title ) . '</a></li>';
        $html .= $separator;
        $html .= '<li class="item-current item-' . $post->ID . '"><span title="' . get_the_title() . '"> ' . get_the_title() . '</span></li>';
    } elseif ( is_singular() ) {
        $post_type         = get_post_type();
        $post_type_object  = get_post_type_object( $post_type );
        $post_type_archive = get_post_type_archive_link( $post_type );
        $html .= '<li class="item-cat item-custom-post-type-' . esc_attr( $post_type ) . '"><a class="bread-cat bread-custom-post-type-' . esc_attr( $post_type ) . '" href="' . esc_url( $post_type_archive ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '">' . esc_attr( $post_type_object->labels->name ) . '</a></li>';
        $html .= $separator;
        $html .= 'li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . $post->post_title . '">' . $post->post_title . '</span></li>';
    } elseif ( is_category() ) {
        $parent = get_queried_object()->category_parent;
        if ( $parent !== 0 ) {
            $parent_category = get_category( $parent );
            $category_link   = get_category_link( $parent );
            $html .= '<li class="item-parent item-parent-' . esc_attr( $parent_category->slug ) . '"><a class="bread-parent bread-parent-' . esc_attr( $parent_category->slug ) . '" href="' . esc_url( $category_link ) . '" title="' . esc_attr( $parent_category->name ) . '">' . esc_attr( $parent_category->name ) . '</a></li>';
            $html .= $separator;
        }
        
        $html .= '<li class="item-current item-cat"><span class="bread-current bread-cat" title="' . $post->ID . '">' . single_cat_title( '', false ) . '</span></li>';
    } elseif ( is_tag() ) {
        $html .= '<li class="item-current item-tag"><span class="bread-current bread-tag">' . single_tag_title( '', false ) . '</span></li>';
    } elseif ( is_author() ) {
        $html .= '<li class="item-current item-author"><span class="bread-current bread-author">' . get_queried_object()->display_name . '</span></li>';
    } elseif ( is_day() ) {
        $html .= '<li class="item-current item-day"><span class="bread-current bread-day">' . get_the_date() . '</span></li>';
    } elseif ( is_month() ) {
        $html .= '<li class="item-current item-month"><span class="bread-current bread-month">' . get_the_date( 'F Y' ) . '</span></li>';
    } elseif ( is_year() ) {
        $html .= '<li class="item-current item-year"><span class="bread-current bread-year">' . get_the_date( 'Y' ) . '</span></li>';
    } elseif ( is_archive() ) {
        $custom_tax_name = get_queried_object()->name;
        $html .= '<li class="item-current item-archive"><span class="bread-current bread-archive">' . esc_attr( $custom_tax_name ) . '</span></li>';
    } elseif ( is_search() ) {
        $html .= '<sliclass="item-current item-search"><span class="bread-current bread-search">Search results for: ' . get_search_query() . '</span></li>';
    } elseif ( is_404() ) {
        $html .= '<li>' . __( 'Error 404', 'ignite' ) . '</li>';
    } elseif ( is_home() ) {
        $html .= '<li>' . get_the_title( get_option( 'page_for_posts' ) ) . '</li>';
    }
    $html .= '</ol>';
    
    $html = apply_filters( 'anva_get_breadcrumbs', $html );
    
    echo wp_kses_post( $html );
}