<?php
//với phpmailer
add_action( 'phpmailer_init', 'my_phpmailer_example' );
function my_phpmailer_example( $phpmailer ) {
    $phpmailer->isSMTP();
    //$phpmailer->Host = 'smtp.example.com';
    //    $phpmailer->SMTPAuth = true; // Force it to use Username and Password to authenticate
    $phpmailer->Port = 25;
    //    $phpmailer->Username = 'yourusername';
    //    $phpmailer->Password = 'yourpassword';

    // Additional settings…
    //$phpmailer->SMTPSecure = "tls"; // Choose SSL or TLS, if necessary for your server
    $phpmailer->setFrom( "fromemail@bla.com", "From Name" );
    $phpmailer->addAddress( "youremail@bla.com", "Your name" );
    $phpmailer->Subject    = "Testing PHPMailer";           
    $phpmailer->Body     = "Hurray! \n\n Great.";
    if( !$phpmailer->send() ) {
        echo "Mailer Error: " . $phpmailer->ErrorInfo;
    } else {
        echo "Message sent!";
    }                       

} 

//với wp_mail thông thường
function mv_optin_mail( $id, $data ) {
    $mailResult = false;
    $mailResult = wp_mail( 'youremail@bla.com', 'test if mail works', 'hurray' );
    echo $mailResult;
}