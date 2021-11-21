<?php
if (file_exists('./../config.php')) {
    $configs = include('./../config.php');
} else {
    $configs = include('./config.php');
}
// Start session
session_start();

# Check is user is alreadt logged in
if(isset($_SESSION['sig']))
{
	#User is already logged in
	header('Location: fileexplorer.php');
	exit();
}

#Check if the login form was submitted
if(isset($_REQUEST['submit']))
{
	#Perform login action
	$username=$_REQUEST['username'];
	$password=$_REQUEST['password'];
	
    // Create connection

    include("php/db.php");

    // select data
    
    $sql = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $sql->bind_param('s', $username);
    $sql->execute();
    $sql->store_result();
    $row = fetchAssocStatement($sql);
    
	if(empty($row))
	{
		#False Info / User doesn't exist
		if (isset($_GET['err'])) {
			if ($_GET['err'] != 1){
				header('Location: login.php?err=1');
				exit();
			}
		} else {
			header('Location: login.php?err=1');
			exit();
		}
		
	} else if (password_verify($password, $row["password"])){
        $_SESSION['sig']="main";
        $_SESSION['user']=$username;
		header('Location: fileexplorer.php');
		exit();
    } else {
        #False Info / User doesn't exist
		if (isset($_GET['err'])) {
			if ($_GET['err'] != 2){
				header('Location: login.php?err=2');
				exit();
			}
		} else {
			header('Location: login.php?err=2');
			exit();
		}
    }	
}

if(isset($_REQUEST['resetpassword'])){

	$username = $_POST["username"];
    $email = $_POST["email"];

    include("php/db.php"); #
    
    $sql = $conn->prepare("SELECT * FROM users WHERE username = ? AND email = ?;");
    $sql->bind_param('ss', $username, $email);
    $sql->execute();
    $sql->store_result();
    $row = fetchAssocStatement($sql);
    if (empty($row)){
		if (isset($_GET['err'])) {
			if ($_GET['err'] != 3){
				header('Location: login.php?err=3');
				exit();
			}
		} else {
			header('Location: login.php?err=3');
			exit();
		}
    } else {
        $password = rand(1000000,9999999);
        $passwordhash = password_hash($password, PASSWORD_DEFAULT);
        $sql = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $sql->bind_param('ss', $passwordhash, $username);
        $sql->execute();
        $conn->close();
        
        require 'php/phpmailer/PHPMailerAutoload.php';

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

        $mail->setFrom('donotreply@webhydraulics.com', 'Web Hydraulics');    // Add a recipient
        $mail->addAddress($email);               // Name is optiona
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Web Hydraulics Password Reset';
        $mail->Body    = "Dear ".$username.", <br><br> Your password has been reset. <br><br> Your temporary password is: ".$password."<br><br> Please login and change this password. <br><br> Thanks <br><br> Web Hydraulics";
        $mail->AltBody = "Dear ".$username.", \n \n Your password has been reset. \n \n Your temporary password is: ".$password."\n \n Please login and change this password. \n \n Thanks \n \n Web Hydraulics";

        if(!$mail->sexit()) {
			if (isset($_GET['err'])) {
			if ($_GET['err'] != 4){
				header('Location: login.php?err=4');
				exit();
			}
		} else {
			header('Location: login.php?err=4');
			exit();
		}
        } else {
			if (isset($_GET['err'])) {
			if ($_GET['err'] != 4){
				header('Location: login.php?err=5');
				exit();
			}
		} else {
			header('Location: login.php?err=4');
			exit();
		}
        }   
    } 
	
}


?>
<!doctype html>
<html lang="en">
<head>
<meta name="description" content="Login to get access to all of Web Hydraulics premium features.">
<meta name="author" content="Web Hydraulics">
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="google-site-verification" content="7v3GVkIr5i-or7p0rVPkUEDsvFU60kMpMoyUO5V_L4I" />
<meta http-equiv="Content-Security-Policy" content="script-src 'self' cdnjs.cloudflare.com js.stripe.com ajax.googleapis.com;">
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js" integrity="sha384-JUMjoW8OzDJw4oFpWIB2Bu/c6768ObEthBMVSiIx4ruBIEdyNSUQAjJNFqT5pnJ6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" integrity="sha384-Nlo8b0yiGl7Dn+BgLn4mxhIIBU6We7aeeiulNCjHdUv/eKHx59s3anfSUjExbDxn" crossorigin="anonymous" type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha384-Dziy8F2VlJQLMShA6FHWNul/veM9bCkRUaLqr199K94ntO5QUrLJBEbYegdSkkqX" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
<link rel="manifest" href="img/site.webmanifest">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<title>Log In | Web Hydraulics</title>
</head>

<body>
    
<!-- Header -->

 <header class="header top">
    <div class="wrapper ">
		<span class="logo">
			<a href="index.php"></a>
		</span>
		<span class="menu">
			<ul>
				<li class="menu__item" id="signup1">
				<a href="signup.php">sign up</a>
				</li>
				<li class="dropdown menu__item">
                    <a href="#calculators">calculators</a>
                    <div class="dropdown__content">
                        <ul>
							<li><a href="help.php">calculator guide</a></li>
                            <li><a href="pipeflow.php">pipe flow</a></li>
							<li><a href="mannings.php">mannings</a></li>
							<li><a href="darcyweisbach.php">darcy-weisbach</a>
							<li><a href="weir.php">weir</a></li>
							<li><a href="orifice.php">orifice</a></li>
                        </ul>
                    </div>
                </li>
				<li class="dropdown menu__item">
                    <a>about</a>
                    <div class="dropdown__content">
                        <ul>
                            <li><a href="policies.php">policies</a></li>
                            <li><a href="softwareverification.php">software verification</a></li>
                        </ul>
                    </div>
                </li>
				<li class="start-calculation menu__item">
                    <a href="index.php">back home</a>
                </li>
            </ul>
		</span>
		<span class="hamburger">
			<div class="hamburger_container" id="hamburger_container">
			  <div class="bar1"></div>
			  <div class="bar2"></div>
			  <div class="bar3"></div>
			</div>
					<div class="hamburger__content" id="hamburger_menu">
						<ul>
							<li id="signup2"><a href="signup.php">sign up</a>
							</li>
							<li><a href="policies.php">policies</a></li>
                            <li><a href="softwareverification.php">software verification</a></li>
							<li style="padding-top:50px;"><a class="learn-more-button" href="index.php">back home</a></li>
						</ul>
					</div>
		</span>
	</div>
</header>
              
<!-- Main Content -->

<div class="full_page">
	<div class="middle">
	<div class="center_box_login">
        <h1>Log In</h1>
        <form method="post" action="login.php" autocomplete="on" style="margin:0 auto;">
            <input type="text" name="username" class="login" id="username" placeholder="Username" autocomplete="username" required> <br><br>
            <input id="password" type="password" name="password" class="login" placeholder="Password" autocomplete="current-password" required><br>
			<div id="message" style="color:red;width:300px;padding-top:5px;"> </div>
			<button type="submit" name="submit" value="Login" class="blackbutton login">Log In</button>
        </form><br>
		Don't have an account? Sign up <a href="signup.php"><b>here</b>.</a>	<br><br>
		<a id="forgot" style="cursor:pointer;">Forgotten password?</a><br><br>
		<form method="post" action="login.php" id="forgottenpassword" autocomplete="on" style="display:none">
			<input id="usernamereset" type="text" name="username" placeholder="Username" class="login" autocomplete="username"><br><br>
			<input id="email" type="email" name="email" placeholder="Email" class="login" autocomplete="email"><br><br>
			<button type="submit" name="resetpassword" value="Reset Password" class="blackbutton login">Reset Password</button>
		</form>	
		</div>
	</div>
</div>
	
</body>
<script src="js/header.js"></script>
<script src="js/login.js"></script>
</html>