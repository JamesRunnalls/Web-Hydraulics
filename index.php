<?php
session_start();

# Check is user is alreadt logged in
if(isset($_SESSION['sig'])){
	header('Location: fileexplorer.php');
	exit(); 
}

?>
<!doctype html>
<html lang="en">
<head>
<meta name="description" content="Hydraulic calculations have never been more straightforward! With Web Hydraulics you can analyse, visualise and understand your system. There's nothing to install, and we sync everything to the cloud.">
<meta name="author" content="Web Hydraulics">
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta http-equiv="Content-Security-Policy" content="script-src 'self' cdnjs.cloudflare.com js.stripe.com ajax.googleapis.com;">
<meta name="google-site-verification" content="7v3GVkIr5i-or7p0rVPkUEDsvFU60kMpMoyUO5V_L4I" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
<link rel="manifest" href="img/site.webmanifest">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" integrity="sha384-AJ82o1PQz2xMlVWjJ+IdPSfyCVS/nJeYbLcpPhm/cEPrewaEdaYkaG6LCsquvogf" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js" integrity="sha384-l+e8/kt7mRYg7RUc/i3MsNwDJlWxkWkFDX10LF/iNglZLT96GBMAPrbaH2GP2lQy" crossorigin="anonymous"></script>


<title>Web Hydraulics | Online hydraulic calculators | Home</title>
</head>

<body>
	
<!-- Header -->
	
<header class="header top">
    <div class="wrapper ">
		<span class="logo">
			<a href="#home"></a>
		</span>
		<span class="menu">
			<ul>
				<li class="dropdown menu__item">
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
				<li class="menu__item">
				<a href="signup.php">sign up</a>
				</li>
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
                            <li><a href="#ourcompany">our company</a></li>
                            <li><a href="policies.php">policies</a></li>
                            <li><a href="softwareverification.php">software verification</a></li>
                            <li><a href="#getintouch">contact</a></li>
                        </ul>
                    </div>
                </li>
				<li class="start-calculation menu__item">
                    <a href="#calculators">start calculation</a>
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
							<li><a href="login.php">login</a></li>
							<li><a href="signup.php">sign up</a></li>
							<li><a class="ham_burger" href="#calculators">calculators</a></li>
							<li><a href="help.php">calculator guide</a></li>
                            <li><a class="ham_burger" href="#ourcompany">our company</a></li>
                            <li><a href="policies.php">policies</a></li>
                            <li><a href="softwareverification.php">software verification</a></li>
                            <li><a class="ham_burger" href="#getintouch">contact</a></li>
							<li style="padding-top:50px;"><a class="learn-more-button ham_burger" href="#calculators">start calculation</a></li>
						</ul>
					</div>
		</span>
	</div>
</header>
	
<!-- Front Page -->

<div class="top_page" id="home">
	<div class="content_top">
		<div class="main-wide">
			<table style="height:80%;width:100%;">
				<tr>
					<td class="title">
						<h1 style="margin-bottom:15px;">Hydraulic computations for the digital era.</h1>
						<p style="margin-top:0;">We provide online hydraulic calculators.</p> <br>
						<p><a class="learn-more-button" href="#learn_more">learn more</a></p>
					</td>
					<td>
						<img src="img/Laptop.png" class="laptop" alt="Image of Web Hydraulics running pipeflow calculator.">
					</td>
				</tr>
			</table>
		</div>
		<div class="main-thin">
			<table style="height:100%;margin:auto;">
				<tr>
					<td style="text-align:center;">
						<img src="img/Laptop.png" class="laptop" style="width:700px;max-width:70%;" alt="Image of Web Hydraulics running pipeflow calculator.">
						<h1 style="margin-bottom:15px;font-size:35px;line-height:36px;">Hydraulic computations for the digital era.</h1>
						<p style="margin-top:0;">We provide online hydraulic calculators.</p>
						<p style="text-align:center;"><a class="learn-more-button" href="#learn_more">learn more</a></p>
					</td>
				</tr>
			</table>
			
		</div>
	</div>	
</div>
	
<!-- Site Description -->

<div class="other_page" id="learn_more">
	<div class="color_box"></div>
	<div class="content">
		<div class="main-wide">
			<table style="padding-top:60px;width:100%;">
				<tr>
					<td class="title" valign="top" style="padding-top:60px;width:600px;">
						<h1 style="margin-bottom:15px;font-size:40px;line-height:42px;">Are you frustrated by hydraulic design processes stuck in the last century?</h1>
						<p style="margin-top:0;">We provide online hydraulic calculators without the disadvantages of excel or outdated software programs.</p> <br>
						
						<table>
						<tr>
							<td class="tablealign"><img src="img/cloud.png" class="designimage" alt="cloud"></td>
							<td>Store calculations in the cloud and access them from anywhere. </td>
						</tr>
						<tr>
							<td class="tablealign"><img src="img/int.png" class="designimage" alt="no training"></td>
							<td>Calculators are designed to be intuitive. No training required.</td>
						</tr>
						<tr>
							<td class="tablealign"><img src="img/inter.png" class="designimage" alt="interactive"></td>
							<td>Interact with your results and truly understand your system. </td>
						</tr>
						<tr>
							<td class="tablealign"><img src="img/calc.png" class="designimage" alt="fast calculations"></td>
							<td>Get results in seconds and apply advanced calculations to any project.</td>
						</tr>
						<tr>
							<td class="tablealign"><img src="img/report.png" class="designimage" alt="export reports"></td>
							<td>Export reports for easy quality assurance, no more black boxes. </td>
						</tr>
						
						</table>						
						
						<p><a class="learn-more-button" href="#calculators">view calculators</a></p>
					</td>
					<td style="text-align:right;">
						<img src="img/Ipad.png" class="tablet" alt="Ipad showing pipeflow report.">
					</td>
				</tr>
			</table>
		</div>
		<div class="main-thin">
			<table style="height:auto;width:100%">
				<tr>
					<td class="title" valign="top" style="padding-top:120px;width:700px;max-width:100%;">
						<h1 style="margin-bottom:15px;font-size:35px;line-height:36px;">Are you frustrated by hydraulic design processes stuck in the last century?</h1>
						<p style="margin-top:0;">We provide online hydraulic calculators without the disadvantages of excel or outdated software programs.</p>
						<p><a class="learn-more-button" href="#calculators">view calculators</a></p>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
	
<!-- Calculators -->
	
<div class="other_page" id="calculators">
	<div class="content content_wrap_always" style="padding-top:100px;">
		<h1 style="margin-bottom:15px;">Calculators</h1><br>
		
		<div class="grid-container">
		  <a href="pipeflow.php" class="item1 grid_shrink">
			  <table class="calculator_table" style="background-color:#007090">
				  <tr>
					<td><img class="calculator_image" src="img/Laptop2.png" alt="Pipeflow calculator"></td>
				  </tr>
				  <tr style="height:0;">
					<td>Pipe Flow</td>  
				  </tr>
				  <tr style="height:0;">
					<td class="calculator_text">STEADY STATE PRESSURISED & NON-PRESSURISED LINEAR PIPESYSTEM CALCULATOR.</td>  
				  </tr>
			  </table>			
		  </a>
		  <div class="item2 grid_shrink">
		    <div class="grid_inner">
			  Need help finding the most appropriate calculator for your application?
		      <p><a class="learn-more-button" href="help.php">get help</a></p>
		    </div>
		  </div>
		  <div class="item3 grid_shrink">
			<h1>Get Premium Features</h1>
			  <ul style="font-size:15px;text-align:left;margin:auto;margin-bottom:30px;width:550px;">
				<li>Store and manage your calculations.</li>
				<li>Download all output data formatted in .csv format.</li>
				<li>Extended computation time.</li>
				<li>Export comprehensive calculation reports for quality assurance.</li>
				</ul>
				<center><a href="signup.php" class="learn-more-button">Sign Up Here</a></center>
		  </div>  
		  <div class="item5 grid_shrink">
			<div class="grid_inner">
			  Find out more about our verification process for the calculators. 
		      <p><a class="learn-more-button" href="softwareverification.php">Verification</a></p>
		    </div>	
		  </div>
		  <a href="mannings.php" class="item6 grid_shrink">
			  <table class="calculator_table" style="background-color:#006989">
				  <tr>
					<td><img class="calculator_image" src="img/Laptop_man.png" alt="Mannings Calculator"></td>
				  </tr>
				  <tr style="height:0;">
					<td>Manning's Equation</td>  
				  </tr>
				  <tr style="height:0;">
					<td class="calculator_text">OPEN CHANNEL FLOW CALCULATOR.</td>  
				  </tr>
			  </table>			
		  </a>
		  <a href="darcyweisbach.php" class="item7 grid_shrink">
			  <table class="calculator_table" style="background-color:#01A7C2;">
				  <tr>
					<td><img class="calculator_image" src="img/Laptop_dar.png" alt="DarcyWeisbach Calculator"></td>
				  </tr>
				  <tr style="height:0;">
					<td>Darcy-Weisbach</td>  
				  </tr>
				  <tr style="height:0;">
					<td class="calculator_text">PRESSURISED PIPE CALCULATOR.</td>  
				  </tr>
			  </table>			
		  </a>
		  <div class="item8 grid_shrink">
		    <div class="grid_inner">
			  Want us to develop new calculators? Get in touch to request new calculators.
		      <p><a class="learn-more-button" href="#getintouch">get in touch</a></p>
		    </div>	
		  </div>  
		</div>
	
	</div>
</div>
	
<!-- About and Contact -->
	
<div class="end_page" >
	<div class="color_box2"></div>
	<div class="content content_wrap" style="padding-top:100px;height:100%;">
		<div class="ourcompany" id="ourcompany">
			<h1>Our Company</h1>
			<p>Web Hydraulics has been developed by James Runnalls. James is a Hydraulic Engineer passionate about leveraging technology to improve both the accuracy of hydraulic calculations and the user experience of undertaking them.</p><br><br>
			<p><a class="learn-more-button" href="policies.php">view policies</a></p>
		
		</div>
		<div class="getintouch" id="getintouch">
			<h1>Get in Touch</h1>
			<form id="contactform" class="contactform" method="post">
				<div id="success" style="display:none;">Your form was submitted successfully. We will be in touch shortly.<br><br></div><div id="failure" style="display:none;">Apologies the form failed. Please refresh the page and try again.<br><br></div>
				<input type="text" id="name" name="name" placeholder="Name" class="contactform"><br><br>

				<input type="text" id="email" name="email" placeholder="Email" class="contactform"><br><br>

				<textarea id="message" name="message" placeholder="Message" class="contactform" style="height:100px;"></textarea><br>

				<input type="submit" value="Submit Form" class="submitbutton">
				  <br><br>
		

			  </form>
		</div>	
	</div>
	<div class="socialfooter">
		<a href="https://linkedin.com/company/webhydraulics" target="_blank" rel="noopener" ><img src="img/in.png" class="social" alt="linkedin"></a>
		<a href="https://twitter.com/webhydraulics" target="_blank" rel="noopener" ><img src="img/tw.png" class="social" alt="twitter"></a>
		<a href="https://www.facebook.com/webhydraulics" target="_blank" rel="noopener" ><img src="img/fb.png" class="social" alt="facebook"></a>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js" integrity="sha384-JUMjoW8OzDJw4oFpWIB2Bu/c6768ObEthBMVSiIx4ruBIEdyNSUQAjJNFqT5pnJ6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" integrity="sha384-Nlo8b0yiGl7Dn+BgLn4mxhIIBU6We7aeeiulNCjHdUv/eKHx59s3anfSUjExbDxn" crossorigin="anonymous" type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha384-Dziy8F2VlJQLMShA6FHWNul/veM9bCkRUaLqr199K94ntO5QUrLJBEbYegdSkkqX" crossorigin="anonymous"></script>
<script src="js/header.js"></script>
<script src="js/index.js"></script>
<script src="js/smoothscroll.js"></script>
<script src="js/contactform.js"></script>
	
</body>

</html>