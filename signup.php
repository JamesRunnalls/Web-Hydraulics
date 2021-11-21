<?php
// Start session
session_start();

# Check is user is alreadt logged in
if(isset($_SESSION['sig']))
{
	#User is already logged in
	echo("<script>window.location='fileexplorer.php'</script>");	
}

if(isset($_REQUEST['register']))
{
    #Perform Registration Action	
    $username=$_REQUEST['username'];
    $password=$_REQUEST['password'];
    $confirmpassword=$_REQUEST['confirmpassword'];
    $passwordhash = password_hash($password, PASSWORD_DEFAULT);
    $guestpasswordhash = "public";
    $email = $_REQUEST['inemail'];
    
    if ($username==null or $password==null or $email==null ){
        echo('<script>sessionStorage.setItem("message","Please complete all the fields before submitting the form.");</script>');
    } else if ($password != $confirmpassword) {
        echo('<script>sessionStorage.setItem("message","Passwords do not match please try again.");</script>');
    } else {

    // Create connection

    include("php/db.php");
        
    $sql = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $sql->bind_param('s', $username);
    $sql->execute();
    $sql->store_result();
    $row = fetchAssocStatement($sql);
    $account = "PRO";
    
    if(empty($row)){
        $sql = $conn->prepare("INSERT INTO users (email, password,username,account) VALUES (?,?,?,?)");
        $sql->bind_param('ssss',$email,$passwordhash,$username,$account);
        $sql->execute();
        $_SESSION['sig']="main";
        $_SESSION['user']=$username;
		echo('<script>sessionStorage.setItem("message","Success!");</script>');
		echo('<script>window.location="fileexplorer.php"</script>');
        
	} else {
        #False Info / User doesn't exist
		echo('<script>sessionStorage.setItem("message","Sorry user name already exists. Please try another name.");</script>');
    }

    }
    
}


?>
<!doctype html>
<html lang="en">
<head>
<meta name="description" content="Hydraulics Engineering">
<meta name="google-site-verification" content="7v3GVkIr5i-or7p0rVPkUEDsvFU60kMpMoyUO5V_L4I" />
<meta name="author" content="James Runnalls">
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<script src="https://js.stripe.com/v3/"></script>

<title>Web Hydraulics | Sign Up</title>
</head>

<body>
	
<header class="header top">
    <div class="wrapper ">
		<span class="logo">
			<a href="index.php"></a>
		</span>
		<span class="menu">
			<ul>
				<li class="dropdown menu__item" id="login1">
                    <a href="login.php">login</a>
                    <div class="dropdown__content" id="login">
						<form method="post" action="login.php" autocomplete="on">
							<ul>
								<li><input id="username" type="text" name="username" placeholder="username" class="login-input" autocomplete="username"></li>
								<li><input id="password" type="password" name="password" placeholder="password" class="login-input" autocomplete="current-password"></li>
								<li><input type="submit" name="submit" value="sign in" class="blackbutton"></li>
							</ul>
						</form>
                    </div>
                </li>
				<li class="dropdown menu__item">
                    <a href="#calculators">calculators</a>
                    <div class="dropdown__content">
                        <ul>
							<li><a href="help.php">calculator guide</a></li>
                            <li><a href="pipeflow.php">pipe flow</a></li>
							<li><a href="mannings.php">mannings</a></li>
							<li><a href="darcyweisbach.php">darcy-weisbach</a></li>
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
			<div class="hamburger_container" onclick="hamburger()" id="hamburger_container">
			  <div class="bar1"></div>
			  <div class="bar2"></div>
			  <div class="bar3"></div>
			</div>
					<div class="hamburger__content" id="hamburger_menu">
						<ul>
							<li id="login2"><a href="login.php">login</a></li>
							<li><a href="policies.php">policies</a></li>
                            <li><a href="softwareverification.php">software verification</a></li>
							<li style="padding-top:50px;"><a class="learn-more-button" href="index.php">back home</a></li>
						</ul>
					</div>
		</span>
	</div>
</header>

<div class="top_page" id="home">
	<div class="content_top">
		<div class="main-wide">
			<table style="height:80%;width:100%;">
				<tr>
					<td class="title">
						<h1 style="margin-bottom:15px;">Free access for Beta users.</h1>
						<p style="margin-bottom:60px;">
						Dowloads of all output data formatted in .csv format.<br>
						Unlimited computation time.<br>
						Store and manange you calculations.<br>
						Export comprehensive calculation report for quality assurance.
						</p>
					</td>
					<td>
						<form method="post" action="signup.php" autocomplete="off" style="margin:0 auto;width:320px;max-width:100%;box-sizing: border-box;">
							<h2>Enter your details.</h2>
							
							<input type="text" name="username" class="signup" placeholder="Username" style="width:90%" autocomplete="username"> <br><br>
							
							<input type="email" style="width:90%" name="inemail" class="signup" placeholder="Email" autocomplete="email"><br><br>
							
							<input type="password" style="width:90%" name="password" class="signup" placeholder="Password" autocomplete="new-password"><br><br>
							
							<input type="password" style="width:90%" name="confirmpassword" class="signup" placeholder="Confirm Password" autocomplete="new-password"><br><br>
							
							By signing up, you agree to our <br><a href="policies.php"><u>Terms & Conditions and Privacy Policy.</u></a><br><br>
							<center><button type="submit" name="register" value="Register" class="submitbutton">Register</button></center><br><br>
							<div id="message" style="color:red;"></div>

							Already have an account? Log in <a href="login.php"><b>here</b>.</a>	<br><br>
					</form>
						
					
						
					</td>
				</tr>
			</table>
		</div>
		<div class="main-thin">
			<table style="height:100%;margin:auto;">
				<tr>
					<td style="text-align:center;">
						<h1 style="margin-bottom:15px;font-size:35px;line-height:36px;">Free access for Beta users.</h1>
					
						<form method="post" action="signup.php" autocomplete="off" style="margin:0 auto;width:320px;max-width:90%;">
							<h2>Enter your details.</h2>
							
							<input type="text" name="username" class="signup" placeholder="Username" style="width:90%" autocomplete="username"> <br><br>
							
							<input type="email" style="width:90%" name="inemail" class="signup" placeholder="Email" autocomplete="email"><br><br>
							
							<input type="password" style="width:90%" name="password" class="signup" placeholder="Password" autocomplete="new-password"><br><br>
							
							<input type="password" style="width:90%" name="confirmpassword" class="signup" placeholder="Confirm Password" autocomplete="new-password"><br><br>
							
							By signing up, you agree to our <br><a href="policies.php"><u>Terms & Conditions and Privacy Policy.</u></a><br><br>
							<center><button type="submit" name="register" value="Register" class="submitbutton">Register</button></center><br><br>
							<div id="message" style="color:red;"></div>

							Already have an account? Log in <a href="login.php"><b>here</b>.</a>	<br><br>
					</form>
						
					</td>
				</tr>
			</table>
			
		</div>	
	</div>	
</div>	
</body>
<script src="js/jquery.min.js"></script>
<link href='css/jquery-ui.css' rel='stylesheet' type='text/css'>
<script src="js/jquery-ui.js"></script>
<script src="js/header.js"></script>
<script src="js/smoothscroll.js"></script>
<script src="js/contactform.js"></script>
<script>
	var message = sessionStorage.getItem("message");
	document.getElementById("message").innerHTML = message;
	sessionStorage.setItem("message","");
	sessionStorage.removeItem("message");
</script>
</html>