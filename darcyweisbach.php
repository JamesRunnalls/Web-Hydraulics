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
    
    if ($row["Type"] != "darcyweisbach"){
        header('Location: fileexplorer.php#darcyweisbach');
		exit();
    }
} else if (isset($_SESSION['sig'])) {
	#User is already logged in
	header('Location: fileexplorer.php#darcyweisbach');
	exit();	
}
?>
<!doctype html>
<html lang="en">
<head>
<meta name="description" content="Use this free Darcy-Weisbach web calculator to analyse sections of pressurised pipes.">
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

<title>Darcy-Weisbach Calculator | Web Hydraulics</title>
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
	
<!-- Roughness modal -->

<div id="roughnessmodal" class="modal">
    <div class="modal-content-hidden">
        <span id="close_rm" class="close">&times;</span>
        <div class="modal-text" style="padding:50px;">
		<h2>Effective roughness height (m)</h2>
        
		This is the roughness factor in the Colebrook-White equation and is required in order to solve for the Darcy friction factor. The dropdown below gives typical values.<br><br>
		
		<select id="roughnessselect" class="modaltable"></select>
		<input type="text" id="ks_modal" name="ks_modal" value="0.0000015" class="modaltable">

            <br><br>
            <center><button type="button" id="fillroughness" class="submitbutton">Fill Roughness</button></center>
        </div>
    </div>
</div>
	
<!-- Minor loss modal -->

<div id="minorlossmodal" class="modal">
    <div class="modal-content-hidden">
        <span id="close_ml" class="close">&times;</span>
        <div class="modal-text" style="padding:50px;">
		<h2>Minor Loss</h2>
        
		This is the minor loss factor and represents the head losses due to irregularities in the pipe, for example connections and bends. The dropdown below gives typical values.<br><br>
		
		<select id="minorlossselect" class="modaltable"></select>
		<input type="text" id="K_modal" name="K_modal" value="0.2" class="modaltable">

            <br><br>
            <center><button type="button" id="fillminorloss" class="submitbutton" >Fill Minor Loss</button></center>
        </div>
    </div>
</div>
         
<!-- Main Content -->

<div class="top_page content" id="home">
	<div class="content_top" style="padding-top:10%;max-width:95%;margin:auto;">
		<h1 style="display:inline-block;padding-right:30px;">Darcy-Weisbach</h1><p style="display:inline-block;">PRESSURISED PIPE CALCULATOR</p>
		<div style="width:fit-content;margin-bottom:40px;"><span title="See details."><img src="img/dw_eq.png" id="seedetails" style="height:40px;cursor:pointer;"></span></div>
		
		<div class="man_hidden" id="details" style="padding-bottom:50px;">
			<p>The darcy-weisbach equation is used to analyse pressurised pipes. For open channel flow see the <b><a href="mannings.php">Mannings </a></b>calculator.</p>
			<ul style="list-style-type:none;">
				<li>h<sub>L</sub> = Head loss (m) </li>
				<li>f = Darcy friction factor </li>
				<li>K = Minor loss factor </li>
				<li>L = Pipe length (m) </li>
				<li>D = Hydraulic diameter (m) </li>
				<li>V = Average flow velocity (m/2) </li>
				<li>g = Acceleration due to gravity (m/s&sup2;) </li>
			</ul>

			<b>Reference</b>
			Brown, Glenn. "The Darcy–Weisbach Equation". Oklahoma State University–Stillwater. <br><br>
		</div>
		
		<form action="php/darcyweisbach_calculate.php" method="post" id="main" enctype="multipart/form-data" target="_top" style="width:100%;">
		<input type="hidden" name="sessionStorageID" id="sessionStorageID" value="none">
		<h2>I want to find the 
			<select id="iwantto" name="iwantto" class="man_sel">
				<option id="option_div_null" value="div_null"></option>
				<option id="option_div_h" value="div_h">head loss</option>
				<option id="option_div_vd" value="div_vd">velocity & discharge</option>
				<option id="option_div_L" value="div_L">length</option>
				<option id="option_div_D" value="div_D">hydraulic diameter</option>
				<option id="option_div_ks" value="div_ks">roughness</option>
				<option id="option_div_K" value="div_K">minor losses</option>
			</select> of my
			<select id="channeltype" name="channeltype" class="man_sel">
				<option id="option_type_null" value="type_null"></option>
				<option id="option_type_cir" value="type_cir">circular culvert</option>
				<option id="option_type_rec" value="type_rec">rectangular culvert</option>
			</select>
		</h2>
		
		<!-- Rectangular Culvert -->
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
						<td><input type="text" id="rec_hi" name="rec_hi"></td>
						<th>m</th>
					</tr>
				</table>
				<img class="shape" src="img/rectangular2.png">
			</div>
		</div>	
			
		<!-- Circular Culvert -->
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
				<img class="shape" src="img/circular.png">
			</div>
		</div>
		
		
		<!-- Solve for velocity and discharge -->
		<div id="div_vd" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Other Inputs</h3>
				<table class="man_table">
					<tr>
						<th>Length</th>
						<td><input type="text" id="vd_L" name="vd_L"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Head Loss</th>
						<td><input type="text" id="vd_h" name="vd_h"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Roughness Ks <span title="See details">
							<img src="img/qm.png" class="qm rm" name="vd">
							</span></th>
						<td><input type="text" id="vd_ks" name="vd_ks"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Minor Loss K <span title="See details">
							<img src="img/qm.png" class="qm ml" name="vd">
							</span></th>
						<td><input type="text" id="vd_K" name="vd_K"></td>
						<th></th>
					</tr>
					<tr>
						<th>Kinematic Viscosity</th>
						<td><input type="text" id="vd_u" name="vd_u" value="0.000015"></td>
						<th>m&sup2;/s</th>
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
					<tr>
						<th>Reynolds Number</th>
						<td><input class="output" type="text" id="vd_Re" name="vd_Re"></td>
						<th></th>
					</tr>
					<tr>
						<th>Friction Factor</th>
						<td><input class="output" type="text" id="vd_f" name="vd_f"></td>
						<th></th>
					</tr>
				</table>
			</div>
		</div>	
			
		<!-- Solve for head loss -->
		<div id="div_h" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Other Inputs</h3>
				<table class="man_table">
					<tr>
						<th>Length</th>
						<td><input type="text" id="h_L" name="h_L"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>
							<select class="man_sel2" id="h_vd_select" name="h_vd_select">
								<option id="h_vd_select_Q" value="Q">Flow Discharge</option>
								<option id="h_vd_select_V" value="V">Flow Velocity</option>
							</select>
						</th>
						<td><input type="text" id="h_vd" name="h_vd"></td>
						<th><div id="h_units">m&sup3;/s</div></th>
					</tr>
					<tr>
						<th>Roughness Ks <span title="See details">
							<img src="img/qm.png" class="qm rm" name="h">
							</span></th>
						<td><input type="text" id="h_ks" name="h_ks"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Minor Loss K <span title="See details">
							<img src="img/qm.png" class="qm ml" name="h">
							</span></th>
						<td><input type="text" id="h_K" name="h_K"></td>
						<th></th>
					</tr>
					<tr>
						<th>Kinematic Viscosity</th>
						<td><input type="text" id="h_u" name="h_u" value="0.000015"></td>
						<th>m&sup2;/s</th>
					</tr>
				</table>
				<center><button class="submitbutton" type="submit">CALCULATE</button></center>
			</div>
			<div style="display:inline-block;vertical-align:top">
				<h3>Outputs</h3>
				<table  class="man_table">				
					<tr>
						<th>Head Loss</th>
						<td><input class="output" type="text" id="h_h" name="h_h"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Friction Factor</th>
						<td><input class="output" type="text" id="h_f" name="h_f"></td>
						<th></th>
					</tr>
					<tr>
						<th>Reynolds Number</th>
						<td><input class="output" type="text" id="h_Re" name="h_Re"></td>
						<th></th>
					</tr>
					<tr>
						<th><div id="h_label">Flow Velocity</div></th>
						<td><input class="output" type="text" id="h_vd_out" name="h_vd_out"></td>
						<th><div id="h_units2">m/s</div></th>
					</tr>
				</table>
			</div>
		</div>
			
		<!-- Solve for length -->
		<div id="div_L" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Other Inputs</h3>
				<table class="man_table">
					<tr>
						<th>
							<select class="man_sel2" id="L_vd_select" name="L_vd_select">
								<option id="L_vd_select_Q" value="Q">Flow Discharge</option>
								<option id="L_vd_select_V" value="V">Flow Velocity</option>
							</select>
						</th>
						<td><input type="text" id="L_vd" name="L_vd"></td>
						<th><div id="L_units">m&sup3;/s</div></th>
					</tr>
					<tr>
						<th>Head Loss</th>
						<td><input type="text" id="L_h" name="L_h"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Roughness Ks <span title="See details">
							<img src="img/qm.png" class="qm rm" name="L">
							</span></th>
						<td><input type="text" id="L_ks" name="L_ks"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Minor Loss K <span title="See details">
							<img src="img/qm.png" class="qm ml" name="L">
							</span></th>
						<td><input type="text" id="L_K" name="L_K"></td>
						<th></th>
					</tr>
					<tr>
						<th>Kinematic Viscosity</th>
						<td><input type="text" id="L_u" name="L_u" value="0.000015"></td>
						<th>m&sup2;/s</th>
					</tr>
				</table>
				<center><button class="submitbutton" type="submit">CALCULATE</button></center>
			</div>
			<div style="display:inline-block;vertical-align:top">
				<h3>Outputs</h3>
				<table  class="man_table">
					<tr>
						<th>Length</th>
						<td><input class="output" type="text" id="L_L" name="L_L"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Friction Factor</th>
						<td><input class="output" type="text" id="L_f" name="L_f"></td>
						<th></th>
					</tr>
					<tr>
						<th>Reynolds Number</th>
						<td><input class="output" type="text" id="L_Re" name="L_Re"></td>
						<th></th>
					</tr>
					<tr>
						<th><div id="L_label">Flow Velocity</div></th>
						<td><input class="output" type="text" id="L_vd_out" name="L_vd_out"></td>
						<th><div id="L_units2">m/s</div></th>
					</tr>
				</table>
			</div>
		</div>
			
		<!-- Solve for diameter -->
		<div id="div_D" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Other Inputs</h3>
				<table class="man_table">
					<tr>
						<th>
							<select class="man_sel2" id="D_vd_select" name="D_vd_select">
								<option id="D_vd_select_V" value="V">Flow Velocity</option>
								<option id="D_vd_select_Q" value="Q">Flow Discharge</option>
							</select>
						</th>
						<td><input type="text" id="D_vd" name="D_vd"></td>
						<th><div id="D_units">m/s</div></th>
					</tr>
					<tr>
						<th>Length</th>
						<td><input type="text" id="D_L" name="D_L"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Head Loss</th>
						<td><input type="text" id="D_h" name="D_h"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Roughness Ks <span title="See details">
							<img src="img/qm.png" class="qm rm" name="D">
							</span></th>
						<td><input type="text" id="D_ks" name="D_ks"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Minor Loss K <span title="See details">
							<img src="img/qm.png" class="qm ml" name="D">
							</span></th>
						<td><input type="text" id="D_K" name="D_K"></td>
						<th></th>
					</tr>
					<tr>
						<th>Kinematic Viscosity</th>
						<td><input type="text" id="D_u" name="D_u" value="0.000015"></td>
						<th>m&sup2;/s</th>
					</tr>
				</table>
				<center><button class="submitbutton" type="submit">CALCULATE</button></center>
			</div>
			<div style="display:inline-block;vertical-align:top">
				<h3>Outputs</h3>
				<table  class="man_table">
					<tr>
						<th>Hydraulic Diameter</th>
						<td><input class="output" type="text" id="D_D" name="D_D"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Friction Factor</th>
						<td><input class="output" type="text" id="D_f" name="D_f"></td>
						<th></th>
					</tr>
					<tr>
						<th>Reynolds Number</th>
						<td><input class="output" type="text" id="D_Re" name="D_Re"></td>
						<th></th>
					</tr>
					<tr>
						<th><div id="D_label">Flow Discharge</div></th>
						<td><input class="output" type="text" id="D_vd_out" name="D_vd_out"></td>
						<th><div id="D_units2">m&sup3;/s</div></th>
					</tr>
				</table>
			</div>
		</div>
			
		<!-- Solve for minor loss -->
		<div id="div_K" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Other Inputs</h3>
				<table class="man_table">
					<tr>
						<th>
							<select class="man_sel2" id="K_vd_select" name="K_vd_select">
								<option id="K_vd_select_V" value="V">Flow Velocity</option>
								<option id="K_vd_select_Q" value="Q">Flow Discharge</option>
							</select>
						</th>
						<td><input type="text" id="K_vd" name="K_vd"></td>
						<th><div id="K_units">m/s</div></th>
					</tr>
					<tr>
						<th>Length</th>
						<td><input type="text" id="K_L" name="K_L"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Head Loss</th>
						<td><input type="text" id="K_h" name="K_h"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Roughness Ks <span title="See details">
							<img src="img/qm.png" class="qm rm" name="K">
							</span></th>
						<td><input type="text" id="K_ks" name="K_ks"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Kinematic Viscosity</th>
						<td><input type="text" id="K_u" name="K_u" value="0.000015"></td>
						<th>m&sup2;/s</th>
					</tr>
				</table>
				<center><button class="submitbutton" type="submit">CALCULATE</button></center>
			</div>
			<div style="display:inline-block;vertical-align:top">
				<h3>Outputs</h3>
				<table  class="man_table">
					<tr>
						<th>Minor Loss K</th>
						<td><input class="output" type="text" id="K_K" name="K_K"></td>
						<th></th>
					</tr>
					<tr>
						<th>Friction Factor</th>
						<td><input class="output" type="text" id="K_f" name="K_f"></td>
						<th></th>
					</tr>
					<tr>
						<th>Reynolds Number</th>
						<td><input class="output" type="text" id="K_Re" name="K_Re"></td>
						<th></th>
					</tr>
					<tr>
						<th><div id="K_label">Flow Discharge</div></th>
						<td><input class="output" type="text" id="K_vd_out" name="K_vd_out"></td>
						<th><div id="K_units2">m&sup3;/s</div></th>
					</tr>
				</table>
			</div>
		</div>
			
		<!-- Solve for roughness -->
		<div id="div_ks" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Other Inputs</h3>
				<table class="man_table">
					<tr>
						<th>
							<select class="man_sel2" id="ks_vd_select" name="ks_vd_select">
								<option id="ks_vd_select_V" value="V">Flow Velocity</option>
								<option id="ks_vd_select_Q" value="Q">Flow Discharge</option>
							</select>
						</th>
						<td><input type="text" id="ks_vd" name="ks_vd"></td>
						<th><div id="ks_units">m/s</div></th>
					</tr>
					<tr>
						<th>Length</th>
						<td><input type="text" id="ks_L" name="ks_L"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Head Loss</th>
						<td><input type="text" id="ks_h" name="ks_h"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Minor Loss K <span title="See details">
							<img src="img/qm.png" class="qm ml" name="ks">
							</span></th>
						<td><input type="text" id="ks_K" name="ks_K"></td>
						<th></th>
					</tr>
					<tr>
						<th>Kinematic Viscosity</th>
						<td><input type="text" id="ks_u" name="ks_u" value="0.000015"></td>
						<th>m&sup2;/s</th>
					</tr>
				</table>
				<center><button class="submitbutton" type="submit">CALCULATE</button></center>
			</div>
			<div style="display:inline-block;vertical-align:top">
				<h3>Outputs</h3>
				<table  class="man_table">
					<tr>
						<th>Roughness Ks</th>
						<td><input class="output" type="text" id="ks_ks" name="ks_ks"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Friction Factor</th>
						<td><input class="output" type="text" id="ks_f" name="ks_f"></td>
						<th></th>
					</tr>
					<tr>
						<th>Reynolds Number</th>
						<td><input class="output" type="text" id="ks_Re" name="ks_Re"></td>
						<th></th>
					</tr>
					<tr>
						<th><div id="ks_label">Flow Discharge</div></th>
						<td><input class="output" type="text" id="ks_vd_out" name="ks_vd_out"></td>
						<th><div id="ks_units2">m&sup3;/s</div></th>
					</tr>
				</table>
			</div>
		</div>	
		<div id="signuphidden"></div>	
		</form>
	</div>
</div> 
	
</body>
<script src="js/header.js"></script>
<script src="js/darcyweisbach.js"></script>
<script src="js/smoothscroll.js"></script>
</html>