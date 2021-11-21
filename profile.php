<?php
// Start session
session_start();
if(!isset($_SESSION['sig'])){
	header('Location: index.php');
    exit();
} else {
	include("php/db.php"); 
	if (isset($_REQUEST['usernamesubmit'])){
		$sql = $conn->prepare("SELECT * FROM users WHERE username = ?");
		$sql->bind_param('s', $_POST['username']);
		$sql->execute();
		$sql->store_result();
		$row = fetchAssocStatement($sql);
		if(empty($row) and $_POST['username'] != ""){
			// Update users
			$sql = $conn->prepare("UPDATE users SET username = ? WHERE username = ?");
			$sql->bind_param('ss', $_POST['username'], $_SESSION['user']);
			$sql->execute();

			// Update folder
			$sql = $conn->prepare("UPDATE folder SET User = ? WHERE User = ?");
			$sql->bind_param('ss', $_POST['username'], $_SESSION['user']);
			$sql->execute();

			// Update report parameters
			$sql = $conn->prepare("UPDATE reportparameters SET User = ? WHERE User = ?");
			$sql->bind_param('ss', $_POST['username'], $_SESSION['user']);
			$sql->execute();

			// Update pipe parameters
			$sql = $conn->prepare("UPDATE pipeparameters SET User = ? WHERE User = ?");
			$sql->bind_param('ss', $_POST['username'], $_SESSION['user']);
			$sql->execute();

			// Update session username value
			$_SESSION['user'] = $_POST['username'];

			if (isset($_GET['err'])) {
				if ($_GET['err'] != 1){
					header('Location: profile.php?err=1');
    				exit();
				}
			} else {
				header('Location: profile.php?err=1');
    			exit();
			}
		} else {
			if (isset($_GET['err'])) {
				if ($_GET['err'] != 2){
					header('Location: profile.php?err=2');
    				exit();
				}
			} else {
				header('Location: profile.php?err=2');
    			exit();
			}
		}   
	} else if (isset($_REQUEST['emailsubmit'])){
		$sql = $conn->prepare("UPDATE users SET email = ? WHERE username = ?");
		$sql->bind_param('ss', $_POST['email'], $_SESSION['user']);
		$sql->execute();
		if (isset($_GET['err'])) {
				if ($_GET['err'] != 3){
					header('Location: profile.php?err=3');
    				exit();
				}
			} else {
				header('Location: profile.php?err=3');
    			exit();
			}
	} else if (isset($_REQUEST['passwordsubmit'])){
		if ($_POST["password"] == $_POST["confirmpassword"]){
			$passwordhash = password_hash($_POST["password"], PASSWORD_DEFAULT);
			$sql = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
			$sql->bind_param('ss', $passwordhash, $_SESSION['user']);
			$sql->execute();
			if (isset($_GET['err'])) {
				if ($_GET['err'] != 4){
					header('Location: profile.php?err=4');
    				exit();
				}
			} else {
				header('Location: profile.php?err=4');
    			exit();
			}
		} else {
			if (isset($_GET['err'])) {
				if ($_GET['err'] != 5){
					header('Location: profile.php?err=5');
    				exit();
				}
			} else {
				header('Location: profile.php?err=5');
    			exit();
			}
		}  
	}
}
?>
<!doctype html>
<html lang="en">
<head>
<meta name="description" content="Web Hydraulics user profile. Edit your personal data.">
<meta name="author" content="Web Hydraulics">
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta http-equiv="Content-Security-Policy" content="script-src 'self' cdnjs.cloudflare.com js.stripe.com ajax.googleapis.com;">
<meta name="google-site-verification" content="7v3GVkIr5i-or7p0rVPkUEDsvFU60kMpMoyUO5V_L4I" />
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
<title>Web Hydraulics | Profile</title>
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
				<li class="dropdown menu__item">
                    <a href="#calculators">calculators</a>
                    <div class="dropdown__content">
                        <ul>
							<li><a href="help.php">calculator guide</a></li>
                            <li><a href="pipeflow.php">pipe flow</a></li>
							<li><a href="mannings.php">mannings</a></li>
							<li><a href="darcyweisbach.php">darcy-weisbach</a></li>
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
                    <a href="fileexplorer.php">File Explorer</a>
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
							<li><a href="fileexplorer.php">file explorer</a></li>
							<li><a href="help.php">calculator guide</a></li>
                            <li><a href="policies.php">policies</a></li>
                            <li><a href="softwareverification.php">software verification</a></li>
							<li style="padding-top:50px;"><a class="learn-more-button" href="fileexplorer.php">file explorer</a></li>
						</ul>
					</div>
		</span>
	</div>
</header> 
            
<!-- Main Content -->

<div class="full_page">
	<div class="middle">
		<div class="center_box_profile">
        <h1>Profile</h1>
        <h3>Edit your details.</h3>
		<form method="post" action="profile.php" autocomplete="off" style="margin:0 auto;width:300px;">
            Current Username: <div style="display:inline" id="username_fill"></div><br><br>
            <input type="text" name="username" class="login" placeholder="New Username"> 
			<div id="usernamemessage" style="color:red;"></div>
            <button type="submit" name="usernamesubmit" value="usernamesubmit" class="blackbutton login">Update Username</button><br><br>
            Current Email Address: <div id="email_fill" style="display:inline"></div><br><br>
            <input type="email" autocomplete="new-email" name="email" class="login" placeholder="New Email Address"><br>
			<div id="emailmessage" style="color:red;"></div>
            <button type="submit" name="emailsubmit" value="emailsubmit" class="blackbutton login">Update Email</button><br><br>
            Set a new password <br><br>
            <input type="password" name="password" autocomplete="new-password" class="login" placeholder="New Password"><br><br>
            <input type="password" name="confirmpassword" autocomplete="new-password" class="login" placeholder="Confirm New Password"><br><br>
			<div id="passwordmessage" style="color:red;"></div>
            <button type="submit" name="passwordsubmit" value="passwordsubmit" class="blackbutton login">Update Password</button>
        </form>
        <a href="deleteaccount.php">Delete account.</a>
    </div>
	</div>
</div>
         
</body>
<script src="js/header.js"></script>
<script src="js/profile.js"></script>
</html>