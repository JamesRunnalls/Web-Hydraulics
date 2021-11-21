<?php

// Start session
session_start();

// Email to admin

$json = json_encode($_POST);

if (isset($_SESSION["user"])){
    include("db.php");
    $sql = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $sql->bind_param('s', $_SESSION["user"]);
    $sql->execute();
    $sql->store_result();
    $row = fetchAssocStatement($sql);
    $email = $row["email"];
    $sentfromname = $_SESSION["user"];
} else {
    $email = "Unknown";
    $sentfromname = 'Non-Premium User';
}

$sentfromemail = 'donotreply@webhydraulics.com';
require 'phpmailer/PHPMailerAutoload.php';


$mail = new PHPMailer;

$mail->isSMTP(); 
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);// Set mailer to use SMTP
$mail->Host = 'mail.webhydraulics.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;      
$mail->SMTPDebug = false; // Enable SMTP authentication
$mail->Username = 'donotreply@webhydraulics.com';                 // SMTP username
$mail->Password = 'emailpassword0612';                         
$mail->SMTPSecure = 'ssl';                 
$mail->Port = 465;                                    // TCP port to connect to

$mail->setFrom($sentfromemail, $sentfromname);    // Add a recipient
$mail->addAddress('contact@webhydraulics.com'); // Name is optiona
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Error Reporting';
$mail->Body    = "Attached error report from ".$email."<br><br> ".$json;
$mail->AltBody = "Attached error report from ".$email."\n \n".$json;

if(!$mail->send()) {};

// Add to error check account

$username = "error_log";

$date = getdate();
$errorname = $sentfromname."_".$date[hours].".".$date[minutes].".".$date[seconds]."_".$date["mday"]."/".$date["mon"]."/".$date["year"];

$sql = $conn->prepare("INSERT INTO `folder` (`id`, `Name`, `Parent`, `Type`, `Description`, `User`) VALUES (NULL, ?, 'None', 'pipeflow', ?, ?);");
$sql->bind_param('sss', $errorname,$email,$username);
$sql->execute();

$Folderid = $conn->insert_id;

foreach($_POST as $Name => $Value){
    $sql = $conn->prepare("INSERT INTO pipeparameters (Folderid,Name,Value,User) VALUES (?,?,?,?);");
    $sql->bind_param('ssss', $Folderid, $Name, $Value, $username);
    $sql->execute();
}








?>