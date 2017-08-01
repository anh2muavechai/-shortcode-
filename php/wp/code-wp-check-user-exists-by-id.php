<?php
function user_id_exists($user){
    global $wpdb;
    $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE ID = %d", $user));
    if($count == 1){ return true; }else{ return false; }
}
// Usage:
if(user_id_exists(1)){
    //it does exists
} else {
    //it doesn't
}