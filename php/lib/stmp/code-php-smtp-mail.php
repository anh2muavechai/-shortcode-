<?php
//sendmail
require(get_stylesheet_directory().'/visa/PHPMailer-5.2.16/PHPMailerAutoload.php');
$result['status'] = 0;
// $email           = get_bloginfo( 'admin_email' );
$email              = 'info@atevietnam.com';
$mail = new PHPMailer();
$body = 'Hi admin, 1 Thanh toán cho payone đã được hoàn tất';

$mail->IsSMTP();
// $mail->SMTPDebug  = 2;
$mail->SMTPAuth   = true;
$mail->Host       = "smtp.gmail.com";
$mail->SMTPSecure = 'tls';//ssl
$mail->Port       = 587;//468
$mail->Username   = "kaneki.test@gmail.com";
$mail->Password   = "jbbrriukvcewugnx";
$mail->SetFrom(get_bloginfo('admin_email'), get_bloginfo('name'));
$mail->addAddress('info@atevietnam.com');    // Add a recipient (gửi tới)
$mail->addAddress('datluong@atevietnam.com');    // Add a recipient (gửi tới)

$mail->Subject    = 'Visa register Update status';
$mail->MsgHTML($body);

if(!$mail->Send()) {
  // echo "Mailer Error: " . $mail->ErrorInfo;
  $result['msg'] = 'There is an error, please check your input and try again';
  // $result['debug'] = $mail->ErrorInfo;
} else {
	$result['status'] = 1;
  // echo "Message sent!";
}