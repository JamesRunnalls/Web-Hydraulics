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
    
    if ($row["Type"] != "mannings"){
        header('Location: fileexplorer.php#mannings');
		exit();
	}
} else if (isset($_SESSION['sig'])) {
	#User is already logged in
	header('Location: fileexplorer.php#mannings');
	exit();	
}
?>
<!doctype html>
<html lang="en">
<head>
<meta name="description" content="Use this free Manning's web calculator to analyse sections of open channel.">
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
<title>Manning's Equation Calculator | Web Hydraulics</title>
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
	
<!-- Mannings n modal -->

<div id="manningsmodal" class="modal">
    <div class="modal-content-hidden">
        <span id="close_mn" class="close">&times;</span>
        <div class="modal-text" style="padding:50px;">
		<h2>Mannings n</h2>
        
		This is the roughness factor of the channel. The dropdown below gives typical values.<br><br>
		
		<select id="manningsselect" class="modaltable"></select>
		<input type="text" id="n_modal" name="n_modal" value="0.01" class="modaltable">

            <br><br>
            <center><button type="button" id="fillmannings" class="submitbutton">Fill Manning's n</button></center>
        </div>
    </div>
</div>
    
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
		<h1 style="display:inline-block;padding-right:30px;">Mannings</h1><p style="display:inline-block;">OPEN CHANNEL CALCULATOR</p>
		<div style="width:fit-content;margin-bottom:40px;"><span title="See details."><img src="img/mn_eq.png" id="seedetails" style="height:40px;cursor:pointer;"></span></div>
		
		<div class="man_hidden" id="details" style="padding-bottom:50px;">
			<p>The Manning's equation is used to analyse open channel flows. For pressured pipes see the <b><a href="darcyweisbach.php">Darcy-Weisbach</a></b> calculator.</p>
			<ul style="list-style-type:none;">
				<li>A = Cross sectional area of pipe, culvert or channel.</li>
				<li>P = Wetted perimeter; the length of the circumference in contact with water.</li>
				<li>S = Slope of the bottom in the direction of flow.</li>
				<li>Q = Discharge (flow rate).</li>
				<li>V = Average velocity across the cross section.</li>
				<li>n = Manning's n; roughness co-efficient.</li>
			</ul>
			<b>Reference</b>
			Manning, R. (1891). "On the flow of water in open channels and pipes". Transactions of the Institution of Civil Engineers of Ireland. 20: 161–207. <br><br>
			
		</div>
		
		<form action="php/mannings_calculate.php" method="post" id="main" enctype="multipart/form-data" target="_top" style="width:100%;">
		<input type="hidden" name="sessionStorageID" id="sessionStorageID" value="none">
		<h2>I want to find the 
			<select id="iwantto" name="iwantto" class="man_sel">
				<option id="option_div_null" value="div_null"></option>
				<option id="option_div_vd" value="div_vd">flow velocity & discharge</option>
				<option id="option_div_s" value="div_s">slope</option>
				<option id="option_div_n" value="div_n">Mannings n</option>
				<option id="option_div_y" value="div_y">normal depth</option>
			</select> of my
			<select id="channeltype" name="channeltype" class="man_sel">
				<option id="option_type_null" value="type_null"></option>
				<option id="option_type_rec" value="type_rec">rectangular channel</option>
				<option id="option_type_tra" value="type_tra">trapezoidal channel</option>
				<option id="option_type_tri" value="type_tri">triangular channel</option>
				<option id="option_type_cir" value="type_cir">circular pipe</option>
				<option id="option_type_cus" value="type_cus">custom area</option>
			</select>
		</h2>
			
		<!-- Rectangular Channel -->
		<div id="type_rec" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Cross Section Input</h3>
				<table class="man_table">
					<tr>
						<th>Bottom Width</th>
						<td><input type="text" id="rec_b" name="rec_b"></td>
						<th>m</th>
					</tr>
				</table>
				<img class="shape" src="img/rectangular.png" alt="Rectangular channel diagram">
			</div>
		</div>	
			
		<!-- Trapezoidal Channel -->
		<div id="type_tra" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Cross Section Input</h3>
				<table class="man_table">
					<tr>
						<th>Bottom Width</th>
						<td><input type="text" id="tra_b" name="tra_b"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Left Side Slope (H:V)</th>
						<td><input type="text" id="tra_l" name="tra_l"></td>
						<th>m/m</th>
					</tr>
					<tr>
						<th>Right Side Slope (H:V)</th>
						<td><input type="text" id="tra_r" name="tra_r"></td>
						<th>m/m</th>
					</tr>
				</table>
				<img class="shape" src="img/trapeziodal.png" alt="Trapeziodal channel diagram">
			</div>
		</div>	
			
		<!-- Triangular Channel -->
		<div id="type_tri" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Cross Section Input</h3>
				<table class="man_table">
					<tr>
						<th>Bottom Angle</th>
						<td><input type="text" id="tri_a" name="tri_a"></td>
						<th>&#176;</th>
					</tr>
				</table>
				<img class="shape" src="img/triangular.png" alt="Triangular channel diagram">
			</div>
		</div>
			
		<!-- Circular Pipe -->
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
			</div>
		</div>
			
		<!-- Custom Area -->
		<div id="type_cus" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Cross Section Input</h3>
				<table class="man_table">
					<tr>
						<th>Area</th>
						<td><input type="text" id="cus_A" name="cus_A"></td>
						<th>m&sup2;</th>
					</tr>
					<tr>
						<th>Wetted Perimeter</th>
						<td><input type="text" id="cus_P" name="cus_P"></td>
						<th>m</th>
					</tr>
				</table>
			</div>
		</div>
		
		
		<!-- Solve for velocity and discharge -->
		<div id="div_vd" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Other Inputs</h3>
				<table class="man_table">
					<tr>
						<th>Flow Depth</th>
						<td><input type="text" id="vd_y" name="vd_y"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Channel Slope</th>
						<td><input type="text" id="vd_s" name="vd_s"></td>
						<th>m/m</th>
					</tr>
					<tr>
						<th>Manning's n <span title="See details">
							<img src="img/qm.png" class="qm mn" name="vd">
							</span></th>
						<td><input type="text" id="vd_n" name="vd_n"></td>
						<th></th>
					</tr>
				</table>
				<center><button class="submitbutton" type="submit">CALCULATE</button></center>
			</div>
			<div style="display:inline-block;vertical-align:top">
				<h3>Outputs</h3>
				<table  class="man_table">
					<tr>
						<th>Flow Velocity</th>
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

		<!-- Solve for slope -->
		<div id="div_s" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Inputs</h3>
				<table class="man_table">
					<tr>
						<th>Flow Depth</th>
						<td><input type="text" id="s_y" name="s_y"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Manning's n <span title="See details">
							<img src="img/qm.png" class="qm mn" name="s">
							</span></th>
						<td><input type="text" id="s_n" name="s_n"></td>
						<th></th>
					</tr>
					<tr>
						<th>Flow Discharge</th>
						<td><input type="text" id="s_Q" name="s_Q"></td>
						<th>m&sup3;/s</th>
					</tr>
				</table>
				<center><button class="submitbutton" type="submit">CALCULATE</button></center>
			</div>
			<div style="display:inline-block;vertical-align:top">
				<h3>Outputs</h3>
				<table  class="man_table">
					<tr>
						<th>Channel Slope</th>
						<td><input class="output" type="text" id="s_s" name="s_s"></td>
						<th>m/m</th>
					</tr>
				</table>
			</div>
		</div>		
			
		<!-- Solve for mannings n -->
		<div id="div_n" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Inputs</h3>
				<table class="man_table">
					<tr>
						<th>Flow Depth</th>
						<td><input type="text" id="n_y" name="n_y"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Channel Slope</th>
						<td><input type="text" id="n_s" name="n_s"></td>
						<th>m/m</th>
					</tr>
					<tr>
						<th>Flow Discharge</th>
						<td><input type="text" id="n_Q" name="n_Q"></td>
						<th>m&sup3;/s</th>
					</tr>
				</table>
				<center><button class="submitbutton" type="submit">CALCULATE</button></center>
			</div>
			<div style="display:inline-block;vertical-align:top">
				<h3>Outputs</h3>
				<table  class="man_table">
					<tr>
						<th>Manning's n</th>
						<td><input class="output" type="text" id="n_n" name="n_n"></td>
						<th></th>
					</tr>
				</table>
			</div>
		</div>
			
		<!-- Solve for normal depth -->
		<div id="div_y" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Other Inputs</h3>
				<table class="man_table">
					<tr>
						<th>Channel Slope</th>
						<td><input type="text" id="y_s" name="y_s"></td>
						<th>m/m</th>
					</tr>
					<tr>
						<th>Manning's n <span title="See details">
							<img src="img/qm.png" class="qm mn" name="y">
							</span></th>
						<td><input type="text" id="y_n" name="y_n"></td>
						<th></th>
					</tr>
					<tr>
						<th>Flow Discharge</th>
						<td><input type="text" id="y_Q" name="y_Q"></td>
						<th>m&sup3;/s</th>
					</tr>
				</table>
				<center><button class="submitbutton" type="submit">CALCULATE</button></center>
			</div>
			<div style="display:inline-block;vertical-align:top">
				<h3>Outputs</h3>
				<table  class="man_table">
					<tr>
						<th>Normal Depth</th>
						<td><input class="output" type="text" id="y_y" name="y_y"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Flow Velocity</th>
						<td><input class="output" type="text" id="y_V" name="y_V"></td>
						<th>m/s</th>
					</tr>	
				</table>
			</div>
		</div>	
			
		<!-- Find normal depth of custom area -->
		<div id="div_nd_ca" class="man_hidden" style="padding-bottom:50px;color:red;">
			<p>Sorry not possible. Please try another combination.</p>
		</div>
		<div id="signuphidden"></div>	
		</form>
	</div>
</div> 
       
</body>
<script src="js/header.js"></script>
<script src="js/mannings.js"></script>
<script src="js/smoothscroll.js"></script>
</html>