<!doctype html>
<html lang="en">
<head>
<meta name="description" content="See the software verification documentation for our calculators.">
<meta name="author" content="Web Hydraulics">
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="google-site-verification" content="7v3GVkIr5i-or7p0rVPkUEDsvFU60kMpMoyUO5V_L4I" />
<meta http-equiv="Content-Security-Policy" content="script-src 'self' cdnjs.cloudflare.com js.stripe.com ajax.googleapis.com;">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
<link rel="manifest" href="img/site.webmanifest">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">

<title>Software Verification | Web Hydraulics</title>
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
				<li class="menu__item" id="signup1">
				<a href="signup.php">sign up</a>
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
							<li id="login2"><a href="login.php">login</a></li>
							<li id="signup2"><a href="signup.php">sign up</a>
							<li><a href="policies.php">policies</a></li>
                            <li><a href="softwareverification.php">software verification</a></li>
							<li style="padding-top:50px;"><a class="learn-more-button" href="index.php">back home</a></li>
						</ul>
					</div>
		</span>
	</div>
</header>
	
<!-- Intro Page -->

<div class="other_page" id="tc">
	<div class="content content_wrap_always">
       <h1 style="margin-top:150px;">Software Verification</h1>
		
		
		<p>The developers of these programs make no warranties, expressed or implied, concerning the accuracy, completeness, reliability, or suitability of any program for any particular purpose. It is understood that the user proceeds at his/her own risk. </p> 
		<p>However Web Hydraulics makes all possible efforts to ensure the accuracy of its calculators. For complex calculators we verify the software against either; established programs, example in the literature or textbook examples.</p>
		<p>Listed below are our current verifications against external information sources.</p>
		
		

		<h2>Current Verifications</h2>
		<br>
		<h3>Pipeflow</h3>
		<ul>
			<li><a href="#ea"><b>Culvert Hydraulics: Comparison of Current Computer Models</b></a></li>
		</ul>
		
	</div>
	</div>
	
<!-- Pipeflow Verification -->
		
<div class="other_page" id="tc">
	<div class="content content_wrap_always">	
		<div class="main" id="pipeflow">
			<h2>Pipeflow Verification</h2>
			<div id="ea">
				<b>Culvert Hydraulics: Comparison of Current Computer Models</b><br><br>
				The pipeflow calculator is verified against the thesis: Thiele, Elizabeth Anne, "Culvert Hydraulics: Comparison of Current Computer Models" (2007). All Theses and Dissertations. 881. <br><br>

				This thesis has four test cases to test a range of flow regimes. They are shown in the table below. All units are imperial. <br><br>

				<table class="sv_table">
					<tr>
						<th>Case</th>
						<th>Q (cfs)</th>
						<th>Slope (%)</th>
						<th>Tailwater Depth (ft)</th>
					</tr>
					<tr>
						<td>A</td>
						<td>0-300</td>
						<td>1.0</td>
						<td>0.0</td>
					</tr>
					<tr>
						<td>B</td>
						<td>0-100</td>
						<td>0.2</td>
						<td>0.0</td>
					</tr>
					<tr>
						<td>C</td>
						<td>0-150</td>
						<td>0.3</td>
						<td>0.0</td>
					</tr>
					<tr>
						<td>D</td>
						<td>0-200</td>
						<td>0.5</td>
						<td>4.5</td>
					</tr>
					</table><br><br>

				<h3>Case A - Results</h3><br><br>

				<div id="CaseA" style="text-align:center"></div>

				<form action="" method="post" name="CaseA" enctype="multipart/form-data" target="_top">
				<input type="hidden" name="id" id="id" value="65">
				<input type="hidden" name="softvar" id="softvar">
				</form>

				<h3>Case B - Results</h3><br><br>

				<form action="" method="post" name="CaseB" enctype="multipart/form-data" target="_top">
				<input type="hidden" name="id" id="id" value="66">
				<input type="hidden" name="softvar" id="softvar">
				</form>

				<div id="CaseB" style="text-align:center"></div>

				<h3>Case C - Results</h3><br><br>

				<form action="" method="post" name="CaseC" enctype="multipart/form-data" target="_top">
				<input type="hidden" name="id" id="id" value="69">
				<input type="hidden" name="softvar" id="softvar">
				</form>

				<div id="CaseC" style="text-align:center"></div>

				<h3>Case D - Results</h3><br><br>

				<form action="" method="post" name="CaseD" enctype="multipart/form-data" target="_top">
				<input type="hidden" name="id" id="id" value="68">
				<input type="hidden" name="softvar" id="softvar">
				</form>

				<div id="CaseD" style="text-align:center"></div>
			</div>   
		</div> 
	</div>
</div>
</body>
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js" integrity="sha384-JUMjoW8OzDJw4oFpWIB2Bu/c6768ObEthBMVSiIx4ruBIEdyNSUQAjJNFqT5pnJ6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" integrity="sha384-Nlo8b0yiGl7Dn+BgLn4mxhIIBU6We7aeeiulNCjHdUv/eKHx59s3anfSUjExbDxn" crossorigin="anonymous" type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha384-Dziy8F2VlJQLMShA6FHWNul/veM9bCkRUaLqr199K94ntO5QUrLJBEbYegdSkkqX" crossorigin="anonymous"></script>
<script src="js/header.js"></script>
<script src="js/smoothscroll.js"></script>
<script src="js/softwareverification.js"></script>
</html>