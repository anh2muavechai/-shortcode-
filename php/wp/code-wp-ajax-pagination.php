<?php
add_action( 'wp_ajax_demo-pagination-load-posts', 'cvf_demo_pagination_load_posts' );

add_action( 'wp_ajax_nopriv_demo-pagination-load-posts', 'cvf_demo_pagination_load_posts' );

function cvf_demo_pagination_load_posts() {

    global $wpdb;
    // Set default variables
    $msg = '';

    if(isset($_POST['page'])){
        // Sanitize the received page
        $page = sanitize_text_field($_POST['page']);
        $cur_page = $page;
        $page -= 1;
        // Set the number of results to display
        $per_page = 3;
        $previous_btn = true;
        $next_btn = true;
        $first_btn = true;
        $last_btn = true;
        $start = $page * $per_page;

        // Set the table where we will be querying data
        $table_name = $wpdb->prefix . "posts";

        // Query the necessary posts
        $all_blog_posts = $wpdb->get_results($wpdb->prepare("
            SELECT * FROM " . $table_name . " WHERE post_type = 'post' AND post_status = 'publish' ORDER BY post_date DESC LIMIT %d, %d", $start, $per_page ) );

        // At the same time, count the number of queried posts
        $count = $wpdb->get_var($wpdb->prepare("
            SELECT COUNT(ID) FROM " . $table_name . " WHERE post_type = 'post' AND post_status = 'publish'", array() ) );

        /**
         * Use WP_Query:
         *
        $all_blog_posts = new WP_Query(
            array(
                'post_type'         => 'post',
                'post_status '      => 'publish',
                'orderby'           => 'post_date',
                'order'             => 'DESC',
                'posts_per_page'    => $per_page,
                'offset'            => $start
            )
        );

        $count = new WP_Query(
            array(
                'post_type'         => 'post',
                'post_status '      => 'publish',
                'posts_per_page'    => -1
            )
        );
        */

        // Loop into all the posts
        foreach($all_blog_posts as $key => $post):

            // Set the desired output into a variable
            $msg .= '
            <div class = "col-md-12">
                <h2><a href="' . get_permalink($post->ID) . '">' . $post->post_title . '</a></h2>
                <p>' . $post->post_excerpt . '</p>
                <p>' . $post->post_content . '</p>
            </div>';

        endforeach;

        // Optional, wrap the output into a container
        $msg = "<div class='cvf-universal-content'>" . $msg . "</div><br class = 'clear' />";

        // This is where the magic happens
        $no_of_paginations = ceil($count / $per_page);

        if ($cur_page >= 7) {
            $start_loop = $cur_page - 3;
            if ($no_of_paginations > $cur_page + 3)
                $end_loop = $cur_page + 3;
            else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
                $start_loop = $no_of_paginations - 6;
                $end_loop = $no_of_paginations;
            } else {
                $end_loop = $no_of_paginations;
            }
        } else {
            $start_loop = 1;
            if ($no_of_paginations > 7)
                $end_loop = 7;
            else
                $end_loop = $no_of_paginations;
        }

        // Pagination Buttons logic
        $pag_container .= "
        <div class='cvf-universal-pagination'>
            <ul>";

        if ($first_btn && $cur_page > 1) {
            $pag_container .= "<li p='1' class='active'>First</li>";
        } else if ($first_btn) {
            $pag_container .= "<li p='1' class='inactive'>First</li>";
        }

        if ($previous_btn && $cur_page > 1) {
            $pre = $cur_page - 1;
            $pag_container .= "<li p='$pre' class='active'>Previous</li>";
        } else if ($previous_btn) {
            $pag_container .= "<li class='inactive'>Previous</li>";
        }
        for ($i = $start_loop; $i <= $end_loop; $i++) {

            if ($cur_page == $i)
                $pag_container .= "<li p='$i' class = 'selected' >{$i}</li>";
            else
                $pag_container .= "<li p='$i' class='active'>{$i}</li>";
        }

        if ($next_btn && $cur_page < $no_of_paginations) {
            $nex = $cur_page + 1;
            $pag_container .= "<li p='$nex' class='active'>Next</li>";
        } else if ($next_btn) {
            $pag_container .= "<li class='inactive'>Next</li>";
        }

        if ($last_btn && $cur_page < $no_of_paginations) {
            $pag_container .= "<li p='$no_of_paginations' class='active'>Last</li>";
        } else if ($last_btn) {
            $pag_container .= "<li p='$no_of_paginations' class='inactive'>Last</li>";
        }

        $pag_container = $pag_container . "
            </ul>
        </div>";

        // We echo the final output
        echo
        '<div class = "cvf-pagination-content">' . $msg . '</div>' .
        '<div class = "cvf-pagination-nav">' . $pag_container . '</div>';

    }
    // Always exit to avoid further execution
    exit();
}
?>
//Frontend------------------------------------------------------------------------
<style>
	.cvf_pag_loading {padding: 20px;}
	.cvf-universal-pagination ul {margin: 0; padding: 0;}
	.cvf-universal-pagination ul li {display: inline; margin: 3px; padding: 4px 8px; background: #FFF; color: black; }
	.cvf-universal-pagination ul li.active:hover {cursor: pointer; background: #1E8CBE; color: white; }
	.cvf-universal-pagination ul li.inactive {background: #7E7E7E;}
	.cvf-universal-pagination ul li.selected {background: #1E8CBE; color: white;}
</style>
<div class="col-md-12 content">
    <div class = "inner-box content no-right-margin darkviolet">
        <script type="text/javascript">
        jQuery(document).ready(function($) {
            // This is required for AJAX to work on our page
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

            function cvf_load_all_posts(page){
                // Start the transition
                $(".cvf_pag_loading").fadeIn().css('background','#ccc');

                // Data to receive from our server
                // the value in 'action' is the key that will be identified by the 'wp_ajax_' hook
                var data = {
                    page: page,
                    action: "demo-pagination-load-posts"
                };

                // Send the data
                $.post(ajaxurl, data, function(response) {
                    // If successful Append the data into our html container
                    $(".cvf_universal_container").append(response);
                    // End the transition
                    $(".cvf_pag_loading").css({'background':'none', 'transition':'all 1s ease-out'});
                });
            }

            // Load page 1 as the default
            cvf_load_all_posts(1);

            // Handle the clicks
            $('.cvf_universal_container .cvf-universal-pagination li.active').live('click',function(){
                var page = $(this).attr('p');
                cvf_load_all_posts(page);

            });

        });
        </script>
        <div class = "cvf_pag_loading">
            <div class = "cvf_universal_container">
                <div class="cvf-universal-content"></div>
            </div>
        </div>

    </div>
</div>