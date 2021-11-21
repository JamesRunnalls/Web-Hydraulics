<?php
// Start session
session_start();

// If Id has been passed and user is logged in
if (isset($_GET['id']) and isset($_SESSION['sig'])){
	include("php/db.php");
    // Varify Id is valid
    $username = $_SESSION['user'];
    $id = $_GET['id'];
    $sql = $conn->prepare("SELECT * FROM folder WHERE User = ? and id = ?");
    $sql->bind_param('ss', $username, $id);
    $sql->execute();
    $sql->store_result();
    $row = fetchAssocStatement($sql);
    
    if ($row["Type"] != "orifice"){
		header('Location: fileexplorer.php#orifice');
		exit();
	}
} else if (isset($_SESSION['sig'])) {
	#User is already logged in
	header('Location: fileexplorer.php#orifice');
	exit();	
}
?>
<!doctype html>
<html lang="en">
<head>
<meta name="description" content="Use this free Orifice web calculator to analyse the flow through orifices.">
<meta name="author" content="Web Hydraulics">
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="google-site-verification" content="7v3GVkIr5i-or7p0rVPkUEDsvFU60kMpMoyUO5V_L4I" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Security-Policy" content="script-src 'self' cdnjs.cloudflare.com js.stripe.com ajax.googleapis.com;">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js" integrity="sha384-JUMjoW8OzDJw4oFpWIB2Bu/c6768ObEthBMVSiIx4ruBIEdyNSUQAjJNFqT5pnJ6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" integrity="sha384-Nlo8b0yiGl7Dn+BgLn4mxhIIBU6We7aeeiulNCjHdUv/eKHx59s3anfSUjExbDxn" crossorigin="anonymous" type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha384-Dziy8F2VlJQLMShA6FHWNul/veM9bCkRUaLqr199K94ntO5QUrLJBEbYegdSkkqX" crossorigin="anonymous"></script>
<script src="js/jquery.ui.touch-punch.min.js"></script>
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
<link rel="manifest" href="img/site.webmanifest">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<title>Orifice Calculator | Web Hydraulics</title>
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
                    <a href="#calculators">calculators</a>
                    <div class="dropdown__content">
                        <ul>
							<li><a href="help.php">calculator guide</a></li>
                            <li><a href="pipeflow.php">pipe flow</a></li>
							<li><a href="mannings.php">mannings</a></li>
							<li><a href="darcyweisbach.php">darcy-weisbach</a>
							</li>
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
							<li id="login2"><a href="login.php">login</a></li>
							<li id="signup2"><a href="signup.php">sign up</a>
							</li>
							<li><a href="help.php">calculator guide</a></li>
                            <li><a href="pipeflow.php">pipe flow</a></li>
							<li><a href="mannings.php">mannings</a></li>
							<li><a href="darcyweisbach.php">darcy-weisbach</a></li>
							<li><a href="weir.php">weir</a></li>
							<li><a href="orifice.php">orifice</a></li>
							<li><a href="policies.php">policies</a></li>
                            <li><a href="softwareverification.php">software verification</a></li>
							<li style="padding-top:50px;"><a class="learn-more-button" href="index.php">back home</a></li>
						</ul>
					</div>
		</span>
	</div>
</header>
	    
<!-- Calculation error modal -->

<div id="calculationerror" class="modal">
    <div class="modal-content-hidden">
        <span id="close_ce" class="close">&times;</span>
        <div class="modal-text" style="padding:50px;">
        Apologies, the calculation failed please check your inputs or try refreshing the page.<br><br> If this error persists please contact us and we will endeavor to fix it ASAP.
            <br><br>
            <center><button type="button" class="submitbutton" id="close_ce2">Close</button></center>
        </div>
    </div>
</div>
     
<!-- Main Content -->
	
<div class="top_page content" id="home">
	<div class="content_top" style="padding-top:10%;max-width:95%;margin:auto;">
		<h1 style="display:inline-block;padding-right:30px;">Orifice</h1><p style="display:inline-block;">ORIFICE CALCULATOR</p>
		<div style="width:fit-content;margin-bottom:40px;"><span title="See details."><img src="img/or_eq.png" id="seedetails" style="height:40px;cursor:pointer;"></span></div>
		
		<div class="man_hidden" id="details" style="padding-bottom:50px;">
			<p>The orifice equation is used to analyse the flow through a hole through the side of a vessel.
			<ul style="list-style-type:none;">
				<li>Q = Discharge (flow rate).</li>
				<li>Cd = Co-efficient of discharge (difference between theoretical and real discharge).</li>
				<li>A = Cross sectional area</li>
				<li>h = Depth from center of orifice to upstream water level (free discharge orifice) or difference between upstream and downstream water level (drowned orifice).</li>
			</ul>
			<p>However for large orifices (Height greater than depth/5) <b>under free discharge </b> the equation above is no longer considered valid due to the variation in flow velocity across the orifice. For rectangular orifices the following equation can be used as it integrates over the orifice's height. No easy integration is available for large circular orifice's and as such they are not included in the calculator. 
			
			<img src="img/ro_eq.png" style="width:500px;cursor:pointer;display:block;max-width:100%;">
			
			</p>
			<ul style="list-style-type:none;">
				<li>b = Rectangular orifice width.</li>
				<li>H2 = Depth from bottom of orifice to upstream water level </li>
				<li>H1 = Depth from top of orifice to upstream water level </li>
			</ul>
			<br><br>
			
		</div>
		
		<form action="php/mannings_calculate.php" method="post" id="main" enctype="multipart/form-data" target="_top" style="width:100%;">
		<input type="hidden" name="sessionStorageID" id="sessionStorageID" value="none">
		<h2>I want to find the 
			<select id="iwantto" name="iwantto" class="man_sel">
				<option id="option_div_null" value="div_null"></option>
				<option id="option_div_vd" value="div_vd">discharge</option>
				<option id="option_div_C" value="div_C">coefficient of discharge</option>
				<option id="option_div_A" value="div_A">cross sectional area</option>
				<option id="option_div_t" value="div_t">time to empty tank out</option>
			</select> of my
			<select id="channeltype" name="channeltype" class="man_sel">
				<option id="option_type_null" value="type_null"></option>
				<option id="option_type_cir" value="type_cir">circular orifice</option>
				<option id="option_type_rec" value="type_rec">rectangular orifice</option>
			</select>
		</h2>			
			
		<!-- Rectangular Orifice -->
		<div id="type_rec" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Cross Section Input</h3>
				<table class="man_table">
					<tr>
						<th>Width</th>
						<td><input type="text" id="rec_b" name="rec_b"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Height</th>
						<td><input type="text" id="rec_h" name="rec_h"></td>
						<th>m</th>
					</tr>
				</table>
				<img class="shape" src="img/rectangular2.png" alt="Rectangular channel diagram">
				<img class="shape" src="img/orifice2.png" alt="Orifice diamgram">
			</div>
		</div>	
			
		<!-- Circular Orifice -->
		<div id="type_cir" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Cross Section Input</h3>
				<table class="man_table">
					<tr>
						<th>Pipe Diameter</th>
						<td><input type="text" id="cir_D" name="cir_D"></td>
						<th>m</th>
					</tr>
				</table>
				<img class="shape" src="img/circular.png" alt="Circular channel diagram">
				<img class="shape" src="img/orifice2.png" alt="Orifice diagram">
			</div>
		</div>		
			
		
		<!-- Solve for velocity and discharge -->
		<div id="div_vd" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Other Inputs</h3>
				Small orifice only for circular orifice.<br><br>
				<table class="man_table">
					<tr>
						<th>Depth to Bottom of Orifice</th>
						<td><input type="text" id="vd_H2" name="vd_H2"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Depth to Downstream Water Level</th>
						<td><input type="text" id="vd_h" name="vd_h"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Coefficient of Discharge</th>
						<td><input type="text" id="vd_C" name="vd_C" value="0.61"></td>
						<th></th>
					</tr>
				</table>
				<center><button class="submitbutton" type="submit">CALCULATE</button></center>
			</div>
			<div style="display:inline-block;vertical-align:top">
				<h3>Outputs</h3>
				<table  class="man_table">
					<tr>
						<th>Average Velocity</th>
						<td><input class="output" type="text" id="vd_V" name="vd_V"></td>
						<th>m/s</th>
					</tr>
					<tr>
						<th>Flow Discharge</th>
						<td><input class="output" type="text" id="vd_Q" name="vd_Q"></td>
						<th>m&sup3;/s</th>
					</tr>				
				</table>
			</div>
		</div>
			
		<!-- Solve for coefficient of discharge -->
		<div id="div_C" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Other Inputs</h3>
				Small orifice only for circular orifice.<br><br>
				<table class="man_table">
					<tr>
						<th>Depth to Bottom of Orifice</th>
						<td><input type="text" id="C_H2" name="C_H2"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Depth to Downstream Water Level</th>
						<td><input type="text" id="C_h" name="C_h"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Flow Discharge</th>
						<td><input type="text" id="C_Q" name="C_Q"></td>
						<th>m&sup3;/s</th>
					</tr>
					
				</table>
				<center><button class="submitbutton" type="submit">CALCULATE</button></center>
			</div>
			<div style="display:inline-block;vertical-align:top">
				<h3>Outputs</h3>
				<table  class="man_table">
					<tr>
						<th>Coefficient of Discharge</th>
						<td><input class="output" type="text" id="C_C" name="C_C"></td>
						<th></th>
					</tr>				
				</table>
			</div>
		</div>
				
		<!-- Solve for cross-sectional area -->
		<div id="div_A" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Other Inputs</h3>
				Small orifice only.<br><br>
				<table class="man_table">
					<tr>
						<th>Coefficient of Discharge</th>
						<td><input type="text" id="A_C" name="A_C" value="0.61"></td>
						<th></th>
					</tr>
					<tr>
						<th>Depth to Downstream Water Level</th>
						<td><input type="text" id="A_h" name="A_h"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Flow Discharge</th>
						<td><input type="text" id="A_Q" name="A_Q"></td>
						<th>m&sup3;/s</th>
					</tr>
					<tr>
						<th>Depth to Middle of Orifice</th>
						<td><input type="text" id="A_H2" name="A_H2"></td>
						<th>m</th>
					</tr>
				</table>
				<center><button class="submitbutton" type="submit">CALCULATE</button></center>
			</div>
			<div style="display:inline-block;vertical-align:top">
				<h3>Outputs</h3>
				<table  class="man_table">
					<tr>
						<th>Area</th>
						<td><input class="output" type="text" id="A_A" name="A_A"></td>
						<th>m&sup2;</th>
					</tr>
					<tr>
						<th>Diameter</th>
						<td><input class="output" type="text" id="A_D" name="A_D"></td>
						<th>m</th>
					</tr>
				</table>
			</div>
		</div>
		
		<!-- Solve for time to drain -->
		<div id="div_t" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Other Inputs</h3>
				Small orifice only. Accuracy reduced if orifice size x 5 is less than water depth.<br><br>
				<table class="man_table">
					<tr>
						<th>Coefficient of Discharge</th>
						<td><input type="text" id="t_C" name="t_C" value="0.61"></td>
						<th></th>
					</tr>
					<tr>
						<th>Cross-sectional area of the tank</th>
						<td><input type="text" id="t_At" name="t_At"></td>
						<th>m&sup2;</th>
					</tr>
					<tr>
						<th>Initial Depth to Bottom of Orifice</th>
						<td><input type="text" id="t_h1" name="t_h1"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Final Depth to Bottom of Orifice</th>
						<td><input type="text" id="t_h2" name="t_h2"></td>
						<th>m</th>
					</tr>
				</table>
				<center><button class="submitbutton" type="submit">CALCULATE</button></center>
			</div>
			<div style="display:inline-block;vertical-align:top">
				<h3>Outputs</h3>
				<table  class="man_table">
					<tr>
						<th>Time</th>
						<td><input class="output" type="text" id="t_t" name="t_t"></td>
						<th>s</th>
					</tr>
				</table>
			</div>
		</div>	
			
		<!-- Find cross-sectional area of rectangular orifice -->
		<div id="div_nd_ca" class="man_hidden" style="padding-bottom:50px;color:red;">
			<p>Sorry not possible. Please try another combination.</p>
		</div>	
			
		<div id="signuphidden"></div>	
			
		</form>
	</div>
</div>
         
</body>
<script src="js/header.js"></script>
<script src="js/orifice.js"></script>
<script src="js/smoothscroll.js"></script>
</html>