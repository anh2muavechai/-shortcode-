<?php
//process
add_action("wp_ajax_{action_name}", "callback_function");
add_action("wp_ajax_nopriv_{action_name}", "callback_function");//user do not login
function callback_function() {
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "my_user_vote_nonce")) {
      exit("No naughty business please");
   }
   echo '<pre>';
   var_export( $_POST );
   die();
}

//script
add_action( 'init', 'my_script_enqueuer' );
function my_script_enqueuer() {
   wp_register_script( "script", 'script.js', array('jquery') );
   wp_localize_script( 'script', 'Ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'script' );
}