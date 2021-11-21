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
    
    if ($row["Type"] != "weir"){
		header('Location: fileexplorer.php#weir');
    	exit();
	}
} else if (isset($_SESSION['sig'])) {
	#User is already logged in
	header('Location: fileexplorer.php#weir');
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
<meta name="description" content="Use this free Weir web calculator to analyse the flow through a weir.">
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
<title>Weir Calculator | Web Hydraulics</title>
</head>

<body>
    
<!-- Loading -->
        
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
         
<!-- Main Content -->
	
<div class="top_page content" id="home">
	<div class="content_top" style="padding-top:10%;max-width:95%;margin:auto;">
		<h1 style="display:inline-block;padding-right:30px;">Weir</h1><p style="display:inline-block;">WEIR CALCULATOR</p>
		<div style="width:fit-content;margin-bottom:40px;"><span title="See details."><img src="img/wr_eq.png" id="seedetails" style="width:190px;cursor:pointer;"></span></div>
		
		<div class="man_hidden" id="details" style="padding-bottom:50px;">
			<h3>Rectangular Sharp Crested Weir</h3>
			<img src="img/wr1_eq.png" style="width:160px;display:block;max-width:100%;margin:auto;">
			
			<img src="img/wr2_eq.png" style="width:380px;display:block;max-width:100%;margin:auto;">


			Free discharge
			<img src="img/wr3_eq.png" style="width:70px;display:block;max-width:100%;margin:auto;">
			
			Drowned flow
			<img src="img/wr4_eq.png" style="width:160px;display:block;max-width:100%;margin:auto;">

			<ul style="list-style-type:none;">
				<li>Q = Discharge (flow rate).</li>
				<li>C<sub>d</sub> = Discharge coefficient</li>
				<li>b = Width of rectangular weir</li>
				<li>B = Width of channel</li>
				<li>h<sub>1</sub> = Upstream depth of water above weir</li>
				<li>h<sub>2</sub> = Downstream depth of water above weir</li>
				<li>p<sub>1</sub> = Upstream depth from weir crest to channel bed</li>
				<li>p<sub>2</sub> = Downstream depth from weir crest to channel bed</li>
			</ul>

			<b>References</b><br> <br>

			Fenton, J. D. (2015) Calculating flow over rectangular sharp-edged weirs, Alternative Hydraulics Paper 6, http://johndfenton.com/Papers/Calculating-flowover-rectangular-sharp-edged-weirs.pdf <br><br>
			Kindsvater, C. E. & Carter, R. W. C. (1957), Discharge characteristics of rectangular thin plate weirs, J. Hydraulics Div. ASCE 83(HY6), 1453/1–1453/36.
			
			<h3>Triangular Sharp Crested Weir</h3>
			
			<img src="img/wr5_eq.png" style="width:270px;display:block;max-width:100%;margin:auto;">
			
			<img src="img/wr6_eq.png" style="width:435px;display:block;max-width:100%;margin:auto;">
			
			<img src="img/wr7_eq.png" style="width:650px;display:block;max-width:100%;margin:auto;">

			Free discharge 
			<img src="img/wr3_eq.png" style="width:70px;display:block;max-width:100%;margin:auto;">
			Drowned flow 
			<img src="img/wr4_eq.png" style="width:160px;display:block;max-width:100%;margin:auto;">
			
			<ul style="list-style-type:none;">
				<li>Q = Discharge (flow rate).</li>
				<li>C = Discharge coefficient</li>
				<li>k = Head adjustment factor</li>
				<li>\theta = Angle of v-notch</li>
				<li>B = Width of channel</li>
				<li>h<sub>1</sub> = Upstream depth of water above v of weir</li>
				<li>p<sub>1</sub> = Upstream depth from weir v to channel bed</li>
				<li></li>
			</ul>			
			
			USBR (1997) suggests using the V-notch weir equations for the following conditions:
			
			<ul>
				<li>Head (h) should be measured at a distance of at least 4h upstream of the weir.</li>
				<li>It doesn't matter how thick the weir is except where water flows over the weir through the "V." The weir should be between 0.03 and 0.08 inches (0.8 to 2 mm) thick in the V. If the bulk of the weir is thicker than 0.08 inch, the downstream edge of the V can be chamfered at an angle greater than 45o (60o is recommended) to achieve the desired thickness of the edges. You want to avoid having water cling to the downstream face of the weir.</li>
				<li>Water surface downstream of the weir should be at least 0.2 ft. (6 cm) below the bottom of the V to allow a free flowing waterfall.</li>
				<li>Measured head (h) should be greater than 0.2 ft. (6 cm) due to potential measurement error at such small heads and the fact that the nappe (waterfall) may cling to the weir.</li>
				<li>The equations have been developed for h<1.25 ft. (38 cm) and h/P<2.4.</li>
				<li>The equations have been developed for fully contracted V-notch weirs which means h/B should be ≤ 0.2.</li>
				<li>The average width of the approach channel (B) should be > 3 ft. (91 cm).</li>
				<li>The bottom of the "V" should be at least 1.5 ft. (45 cm) above the bottom of the upstream channel.</li>
			</ul>
			
			<b>References</b><br> <br>
			Shen, J. (1981). Discharge characteristics of triangular-notch thin-plate weirs. Studies of flow of water over weirs and dams. Geological Survey Water-Supply Paper 1617-B, Washington D. C. <br><br>
			USBR. (1997). U.S. Department of the Interior, Bureau of Reclamation. Water Measurement Manual. 3ed. <br><br>
			LMNO Engineering. V-Notch (Triangular) Weir Calculator. https://www.lmnoeng.com/Weirs/vweir.php
			
		</div>
		
		<form action="php/weir_calculate.php" method="post" id="main" enctype="multipart/form-data" target="_top" style="width:100%;">
		<input type="hidden" name="sessionStorageID" id="sessionStorageID" value="none">
		<h2>I want to find the 
			<select id="iwantto" name="iwantto" class="man_sel">
				<option id="option_div_null" value="div_null"></option>
				<option id="option_div_vd" value="div_vd">flow discharge</option>
				<option id="option_div_h1" value="div_h1">water depth</option>
			</select> of my
			<select id="channeltype" name="channeltype" class="man_sel">
				<option id="option_type_null" value="type_null"></option>
				<option id="option_type_rec" value="type_rec">rectangular sharp crested weir</option>
				<option id="option_type_tri" value="type_tri">triangular sharp crested weir</option>
				<!--
				<option id="option_type_tra" value="type_bro">broad crested weir</option>
				<option id="option_type_tri" value="type_lab">labyrinth weir</option>
				<option id="option_type_tri" value="type_cru">crump weir</option>
				<option id="option_type_tri" value="type_fla">flat v weir</option>
				-->
			</select>
		</h2>			
			
		<!-- Rectangular Sharp Crested Weir -->
		<div id="type_rec" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Cross Section Input</h3>
				<table class="man_table">
					<tr>
						<th>Weir Width (b)</th>
						<td><input type="text" id="rec_b" name="rec_b"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Channel Width (B)</th>
						<td><input type="text" id="rec_B" name="rec_B"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Upstream depth to crest (P<sub>1</sub>)</th>
						<td><input type="text" id="rec_p1" name="rec_p1"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Downstream depth to crest (P<sub>2</sub>)</th>
						<td><input type="text" id="rec_p2" name="rec_p2"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Downstream depth of water above weir (h<sub>2</sub>) <br>(leave blank for free discharge)</th>
						<td><input type="text" id="rec_h2" name="rec_h2"></td>
						<th>m</th>
					</tr>
				</table>
				<img class="shape" src="img/rectangular3.png">
				<img class="shape" style="height:80px;" src="img/weir2.png">
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
					<tr>
						<th>Downstream depth of water above weir (h<sub>2</sub>)<br>(leave blank for free discharge)</th>
						<td><input type="text" id="tri_h2" name="tri_h2"></td>
						<th>m</th>
					</tr>
				</table>
				<img class="shape" src="img/triangular2.png">
				<img class="shape" style="height:80px;" src="img/weir2.png">
			</div>
		</div>
			
		<!-- Solve for velocity and discharge -->
		<div id="div_vd" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Other Inputs</h3>
				<table class="man_table">
					<tr>
						<th>Upstream depth of water above weir (h<sub>1</sub>)</th>
						<td><input type="text" id="vd_h1" name="vd_h1"></td>
						<th>m</th>
					</tr>
					<tr>
						<th>Coefficient of discharge (optional)</th>
						<td><input type="text" id="vd_C_in" name="vd_C_in"></td>
						<th></th>
					</tr>
				</table>
				<center><button class="submitbutton" type="submit">CALCULATE</button></center>
			</div>
			<div style="display:inline-block;vertical-align:top">
				<h3>Outputs</h3>
				<table  class="man_table">
					<tr>
						<th>Coefficient of Discharge</th>
						<td><input class="output" type="text" id="vd_C" name="vd_C"></td>
						<th></th>
					</tr>
					<tr>
						<th>Flow Discharge</th>
						<td><input class="output" type="text" id="vd_Q" name="vd_Q"></td>
						<th>m&sup3;/s</th>
					</tr>				
				</table>
			</div>
		</div>	

		<!-- Solve for upstream depth -->
		<div id="div_h1" class="man_hidden">
			<div style="display:inline-block;margin-right:80px;">
				<h3>Other Inputs</h3>
				<table class="man_table">
					<tr>
						<th>Flow Discharge</th>
						<td><input type="text" id="h1_Q" name="h1_Q"></td>
						<th>m&sup3;/s</th>
					</tr>	
					<tr>
						<th>Coefficient of discharge (optional)</th>
						<td><input type="text" id="h1_C_in" name="h1_C_in"></td>
						<th>m/m</th>
					</tr>
				</table>
				<center><button class="submitbutton" type="submit">CALCULATE</button></center>
			</div>
			<div style="display:inline-block;vertical-align:top">
				<h3>Outputs</h3>
				<table  class="man_table">
					<tr>
						<th>Coefficient of Discharge</th>
						<td><input class="output" type="text" id="h1_C" name="h1_C"></td>
						<th></th>
					</tr>
					<tr>
						<th>Upstream depth of water above weir (h<sub>1</sub>)</th>
						<td><input class="output" type="text" id="h1_h1" name="h1_h1"></td>
						<th>m</th>
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
<script src="js/weir.js"></script>
<script src="js/smoothscroll.js"></script>
</html>