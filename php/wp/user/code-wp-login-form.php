<?php 
    $login  = (isset($_GET['login']) ) ? $_GET['login'] : 0;
    if ( $login === "failed" ) {  
        echo '<p class="error text-center">Tên đăng nhập hoặc mật khẩu không đúng !</p>';  
    } elseif ( $login === "empty" ) {  
        echo '<p class="error text-center">Tên đăng nhập hoặc mật khẩu không được để trống !</p>';  
    } elseif ( $login === "false" ) {  
        echo '<p class="error text-center">Bạn đã đăng xuất !</p>';  
    }
    $args = array(  
        'redirect'       => site_url( $_SERVER['REQUEST_URI']),   
        'id_username'    => 'user',
        'id_password'    => 'pass',
        'label_username' => false,
        'label_password' => false,
        'label_remember' => 'Ghi nhớ tài khoản',      
        'label_log_in'   => 'Đăng nhập',
        'echo'           => false
    );
    $form = wp_login_form($args); 
    $form = str_replace('name="log"', 'name="log" placeholder="Tên đăng nhập *" class="form-control style-input"', $form);
    $form = str_replace('name="pwd"', 'name="pwd" placeholder="Mật khẩu *" class="form-control style-input"', $form);
    echo $form;
?>