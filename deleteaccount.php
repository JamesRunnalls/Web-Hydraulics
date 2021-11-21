<?php

// Start session
session_start();

# Check is user is alreadt logged in
if(!isset($_SESSION['sig'])){
	header('Location: index.php');
	exit();
}

#Check if the login form was submitted
if(isset($_REQUEST['submit']))
{
	
	#Perform login action
	$username=$_REQUEST['username'];
	$password=$_REQUEST['password'];
	$username2 = $_SESSION['user'];
	
	if ($username == $username2){
	
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
					header('Location: deleteaccount.php?err=1');
					exit();
				}
			} else {
				header('Location: deleteaccount.php?err=1');
				exit();
			}
		} else if (password_verify($password, $row["password"])){
			
			$userid = $row["account"];

			// Delete SQL files from "folder" and delete images and json files
			$sql = $conn->prepare("SELECT * FROM folder WHERE User = ?");
			$sql->bind_param('s', $username);
			$sql->execute();
			$sql->store_result();
			$out = [];
			while($row = fetchAssocStatement($sql)){
				array_push($out,$row);
			}

			for ($x = 0; $x < count($out); $x++) {
				$id = $out[$x]["id"];
				try {unlink("../json/".$id.".json");} catch (Exception $e) {};
				try {unlink("../img/users".$id.".png");} catch (Exception $e) {};
			}

			$sql = $conn->prepare("DELETE FROM folder WHERE User = ?;");
			$sql->bind_param('s', $username);
			$sql->execute();

			// Delete from pipeparameters
			$sql = $conn->prepare("DELETE FROM pipeparameters WHERE User = ?;");
			$sql->bind_param('s', $username);
			$sql->execute();

			// Delete from report parameters
			$sql = $conn->prepare("DELETE FROM reportparameters WHERE User = ?;");
			$sql->bind_param('s', $username);
			$sql->execute();

			// Delete from users
			$sql = $conn->prepare("DELETE FROM users WHERE username = ?;");
			$sql->bind_param('s', $username);
			$sql->execute();
			
			// Delete from payment system
			try{
				require_once("php/stripe_config.php"); 
				$customer = \Stripe\Customer::retrieve($userid);
				$customer->delete();
			} catch (Exception $e){}

			// Logout and return to homepage
			session_destroy();
			header('Location: index.php');
			exit();


		} else {
			#False Info / User doesn't exist
			if (isset($_GET['err'])) {
				if ($_GET['err'] != 2){
					header('Location: deleteaccount.php?err=2');
					exit();
				}
			} else {
				header('Location: deleteaccount.php?err=2');
				exit();

			}
		}
		
	} else {
		#False Info / User doesn't exist
		if (isset($_GET['err'])) {
				if ($_GET['err'] != 3){
					header('Location: deleteaccount.php?err=3');
					exit();
				}
			} else {
				header('Location: deleteaccount.php?err=3');
				exit();
			}
	}
}

?>
<!doctype html>
<html lang="en">
<head>
<meta name="description" content="Delete your Web Hydraulics account.">
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
<title>Delete Account | Web Hydraulics</title>
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
				<a href="php/logout.php">log out</a>
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
							<li id="signup2"><a href="php/logout.php">log out</a>
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
	<div class="center_box_delete">
        <h1>Delete Account</h1>
		<h7>We are sorry to see you go. If you are leaving because you have had problems with the site please contact us at contact@webhydraulics.com.</h7><br><br>
        <form method="post" action="deleteaccount.php" autocomplete="on" style="margin:0 auto;">
            <input type="text" name="username" class="signup" id="username" placeholder="Username" autocomplete="username" required> <br><br>
            <input id="password" type="password" name="password" class="signup" placeholder="Password" autocomplete="current-password" required><br><br>
			<div id="message" style="color:red"></div>
			<div style="color:red">Warning. Account deletion cannot be undone. If you continue all your calculations will be permanently deleted.</div><br>
			<button type="submit" name="submit" value="Login" class="submitbutton">Delete Account</button>
        </form><br>	
        </div>
    </div>
</div> 
	
</body>
<script src="js/header.js"></script>
<script src="js/deleteaccount.js"></script>
</html>