<?php

if (file_exists('./../config.php')) {
    $configs = include('./../config.php');
} else {
    $configs = include('./config.php');
}

if (isset($_POST["email"])){
   
	$sentfromemail = 'contact@webhydraulics.com';
	require 'phpmailer/PHPMailerAutoload.php';
	$email = $_POST['email'];
	$sentfromname = $_POST['name'];

	$mail = new PHPMailer;

	$mail->isSMTP(); 
	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);// Set mailer to use SMTP
	$mail->Host = $configs['mail_host'];  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;      
	$mail->SMTPDebug = false; // Enable SMTP authentication
	$mail->Username = 'donotreply@webhydraulics.com';                 // SMTP username
	$mail->Password = $configs['mail_password'];                         
	$mail->SMTPSecure = 'ssl';                 
	$mail->Port = 465;                                    // TCP port to connect to

	$mail->setFrom($sentfromemail, $sentfromname);    // Add a recipient
	$mail->addAddress('contact@webhydraulics.com'); // Name is optiona
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'Homepage Contact Form';
	$mail->Body    = $_POST['message'].$email;
	$mail->AltBody = $_POST['message'].$email;
	$mail->send();

}
?>