<?php
// Start session
session_start();

// If Id has been passed and user is logged in
if (isset($_GET['id']) and isset($_SESSION['sig'])){
	include("php/db.php");
    // Verify Id is valid
    $username = $_SESSION['user'];
    $id = $_GET['id'];
    $sql = $conn->prepare("SELECT * FROM folder WHERE User = ? and id = ?");
    $sql->bind_param('ss', $username, $id);
    $sql->execute();
    $sql->store_result();
    $row = fetchAssocStatement($sql);
    if ($row["Type"] != "pipeflow"){
		header('Location: fileexplorer.php#pipeflow');
        exit();
	}
} else if (isset($_SESSION['sig'])) {
	#User is already logged in
	header('Location: fileexplorer.php#pipeflow');
    exit();	
}
?>
<!doctype html>
<html lang="en">
<head>
<meta name="description" content="Use this free Pipe Flow web calculator to analyse steady state pressurised & non-pressurised linear pipesystems.">
<meta name="author" content="Web Hydraulics">
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="google-site-verification" content="7v3GVkIr5i-or7p0rVPkUEDsvFU60kMpMoyUO5V_L4I" />
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta http-equiv="Content-Security-Policy" content="script-src 'self' cdnjs.cloudflare.com webhydraulics.com js.stripe.com cdnpub.websitepolicies.com ajax.googleapis.com;">
<script type="text/javascript"
  src="js/dygraph.min.js"></script>
<script type="text/javascript"
  src="js/synchronizer.js"></script>
<link rel="stylesheet" src="css/dygraph.css" />  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js" integrity="sha384-JUMjoW8OzDJw4oFpWIB2Bu/c6768ObEthBMVSiIx4ruBIEdyNSUQAjJNFqT5pnJ6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" integrity="sha384-Nlo8b0yiGl7Dn+BgLn4mxhIIBU6We7aeeiulNCjHdUv/eKHx59s3anfSUjExbDxn" crossorigin="anonymous" type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha384-Dziy8F2VlJQLMShA6FHWNul/veM9bCkRUaLqr199K94ntO5QUrLJBEbYegdSkkqX" crossorigin="anonymous"></script>
<script src="js/jquery.ui.touch-punch.min.js"></script>
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/printpf.css" type="text/css">
<link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
<link rel="manifest" href="img/site.webmanifest">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<link rel="stylesheet" href="https://cdnpub.websitepolicies.com/lib/cookieconsent/1.0.2/cookieconsent.min.css" integrity="sha384-CNcqRDJGVKYmDY2P2/pjP7sNuqUC3JT+KP+U8OjH7hNBuKJVvPjUuZsOMMp9ldr3" crossorigin="anonymous" type='text/css'><script src="https://cdnpub.websitepolicies.com/lib/cookieconsent/1.0.2/cookieconsent.min.js" integrity="sha384-gNaqAsLHf4qf+H76HtN+K++WIcDxMT8yQ3VSiYcRjmkwUKZeHXAqppXDBUtja174" crossorigin="anonymous"></script>
<title>Pipe Flow Calculator | Web Hydraulics</title>
</head>

<body>
    
<!-- Loading -->
    
<div id="loader-wrapper">
    <div id="loader"></div>
    <div id="loader-text">Preparing Your Workspace.</div>
</div>
	
<!-- Header -->
    
<header class="header top">
    <div class="wrapper ">
		<span class="logo">
			<a href="index.php"></a>
		</span>
		<span class="menu">
			<ul>
				<li class="dropdown menu__item">
                    <a>navigate</a>
                    <div class="dropdown__content">
                        <ul>
                            <li><a href="#input_anchor">input</a></li>
                            <li><a href="#pipeprofile_anchor">pipe profile graph</a></li>
							<li><a href="#headdischarge_anchor">head discharge graph</a></li>
							<li><a href="#summarytable_anchor">summary table</a></li>
							<li><a href="#report_anchor">create report</a></li>
							<li><a style="cursor:pointer;" id="examplecalc1">example calculation</a></li>
                        </ul>
                    </div>
                </li>
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
							<li><a class="ham_burger" href="#input_anchor">input</a></li>
                            <li><a class="ham_burger" href="#pipeprofile_anchor">pipe profile graph</a></li>
							<li><a class="ham_burger" href="#headdischarge_anchor">head discharge graph</a></li>
							<li><a class="ham_burger" href="#summarytable_anchor">summary table</a></li>
							<li><a class="ham_burger" href="#report_anchor">create report</a></li>
							<li><a class="ham_burger" href="policies.php">policies</a></li>
							<li><a class="ham_burger" style="cursor:pointer;" id="examplecalc2">example calculation</a></li>
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
        <span name="calculationerror" class="close">&times;</span>
        <div class="modal-text" style="padding:50px;">
        Apologies, the calculation failed please check your inputs or try refreshing the page.<br><br> If this error persists please click the button below in order to report this and we will endeavor to fix it ASAP.
            <br><br>
            <center><button type="button" class="submitbutton" id="senderrorreport">Report Problem</button></center>
        </div>
    </div>
</div>
    
<!-- Premium features modal -->

<div id="premiumfeature" class="modal">
    <div class="modal-content-hidden">
        <span name="premiumfeature" class="close">&times;</span>
        <div class="modal-text" style="padding:30px;">
        <br><h1>Join Premium...</h1><br>
            <h7>To access this and many other great features including:
			<ul>
			<li>Downloads of all output data formatted in .csv format.</li>
			<li>Unlimited computation time.</li>
			<li>Store and manage you calculations.</li>
			<li>Export comprehensive calculation report for quality assurance.</li>
			</ul>
			Sign up at the link below.</h7>
            <br><br><br>
			<center><a class="learn-more-button" href="signup.php">Sign Up Here</a></center><br>
        </div>
    </div>
</div>
    
<!-- Calculation time exceeded -->

<div id="calculationtimeexceeded" class="modal">
    <div class="modal-content-hidden">
        <span name="calculationtimeexceeded" class="close">&times;</span>
        <div class="modal-text" style="padding:30px;">
        <br><h2>Calculation time exceeded.</h2><br>
            Please reduce the number of flow rates or sign up below for unlimited computation time. 
            <br><br>
            <center><a class="learn-more-button" href="signup.php">Sign Up Here</a></center>
        </div>
    </div>
</div>
     
<!-- Page 0 - Intro -->
	
<div class="top_page content" id="home">
	<div class="content_top" style="padding-top:15%;max-width:95%;margin:auto;">
    	<h1>Pipe Flow </h1>
   		<h2>Steady state pressurised & non-pressurised linear pipesystem calculator.</h2>
		<br>
		<div class="features">
			<ul>
			  <li>Interactive visualisations of surface profile and head discharge.</li><br>
			  <li>Full implementation of gradually varied flow equations and hydraulic jump.</li><br>
			  <li>Download all your results, including extensive quality assurance documentation (Premium users only).</li><br>
			</ul>
		</div>
		<br><a class="learn-more-button" href="#input_anchor">input data</a>
	</div>
</div>
    
<!-- Page 1 - Form for entering data -->
    
 

<div class="other_page" id="input_anchor">
	<div class="content content_wrap_always" style="padding-top:100px;">
		<h1>Input</h1>
	<div class="section-pipeflow">
      <form action="php/calculate.php" method="post" id="main" enctype="multipart/form-data" target="_top" style="display:inline-block;">
        <input type="hidden" name="sessionStorageID" id="sessionStorageID" value="none"> 
        <div class="tooltip"><h4 style="margin:0;">Entrance Section Details</h4><span class="tooltiptext">This describes the inlet configuration to allow calculation of headwater and head loss at the entrance.</span></div><br><br>
        
        <table id="inlet">
          <tr>
              <th>Type</th>
              <th>Detail</th>
          </tr>
          <tr>
              <td><select id="InputType" name="InputType"></select></td> 
              <td><select id="InputDetail" name="InputDetail"></select></td>
          </tr>
          </table><br><br>

        <div class="tooltip"><h4 style="margin:0;">Section Input</h4><span class="tooltiptext">This describes the properties of the pipe section.</span></div><br><br>
      
        <table id="sections" style="text-align:center;">
          <tr>
            <th rowspan="2">Type</th>
            <th colspan="3">Size</th>
            <th rowspan="2">Length (m)</th>
            <th colspan="2">Elevation (mAOD)</th>
            <th rowspan="2"><div class="tooltip">Downstream Section <br> Transition<span class="tooltiptext">If there is a difference in downstream pipe size this describes the transition and is used to calculate the resulting minor loss coefficient. Warning if not set to none this automatically updates the Manning's n value to account for the additional minor loss.</span></div></th> 
            <th colspan="3">Roughness</th>
          </tr>
          <tr>
            <td>Diameter (m)</td>
            <td>Height (m)</td>
            <td>Width (m)</td>
            <td><div class="tooltip">US IL<span class="tooltiptext">Upstream Invert Level: Elevation of the bottom of the pipe at the pipe entrance</span></div></td>
            <td><div class="tooltip">DS IL<span class="tooltiptext">Downstream Invert Level: Elevation of the bottom of the pipe at the pipe exit</span></div></td>
            <td><div class="tooltip">Ks (m)<span class="tooltiptext">Absolute Roughness: a measure of surface roughness of a material</span></div></td>
            <td><div class="tooltip">n<span class="tooltiptext">Manning's Characteristic Roughness</span></div></td>
            <td><div class="tooltip">K<span class="tooltiptext">Minor Loss Coefficient: For approximating impact of bends, manholes, valves etc</span></div></td>
            <td></td>
          </tr>
          <tr>
            <td><select id="Type&0" name="Type&0" class="Type"></select></td>
            <td><input id="Diameter&0" name="Diameter&0" type="text" size="4" required></td>
            <td><input id="Height&0" name="Height&0" type="text" size="4" readOnly required></td>
            <td><input id="Width&0" name="Width&0" type="text" size="4" readOnly required></td>
            <td><input id="Length&0" name="Length&0" type="text" size="4" required></td>
            <td><input id="US&0" name="US&0" type="text" size="4" required></td>
            <td><input id="DS&0" name="DS&0" type="text" size="4" required></td>
            <td><select id="dstransition&0" name="dstransition&0"></select></td>  
            <td><input id="Ks&0" name="Ks&0" type="text" size="6" required></td>
            <td><input id="n&0" name="n&0" type="text" size="4" required></td>
            <td><input id="K&0" name="K&0" type="text" size="4" required></td>
            <td><button id="rw&0" class="rwclass" type="button" name="rw&0" style="width:150px;">Roughness Wizard</button></td>
          </tr>
        </table>
		  <br>
        <button type="button" id="addrow">+ Add Section</button>
        <button type="button" id="deleterow">- Delete Section</button><br><br>

        <div class="tooltip"><h4 style="margin:0;">Downstream Section Details</h4><span class="tooltiptext">This describes the properties downstream and allows the calculation of the tailwater.</span></div><br><br>

        <input type="radio" name="dstype" id="freedischarge" value="freedischarge" required checked> Free Discharge &nbsp; &nbsp; &nbsp; &nbsp;
        <input type="radio" name="dstype" id="fixedheight" value="fixedheight" required> 
        Fixed Height &nbsp; &nbsp; &nbsp; &nbsp;
        <input type="radio" name="dstype" id="section" value="section" required> 
        Trapezoidal Channel Section
        <div id="fixheight" style="display:none"><br>
        Downstream Water Level <input name="dswl" id="dswl" type="text" size="4"> mAOD</div>
        <div id="sect" style="display:none"><br>
		<img src="img/trap.png" style="width:250px;display:inline-block;padding-right:50px;margin-bottom:25px;" alt="Trapeziodal channel">	
		<table style="display:inline-block;">
			<tr>
				<td style="text-align:left;">Width</td>
				<td><input id="dswidth" name="dswidth" type="text" size="4"></td>
				<td style="text-align:left;">m</td>
			</tr>
			<tr>
				<td style="text-align:left;">Side Slope</td>
				<td><input id="dssideslope" name="dssideslope" type="text" size="4"></td>
			</tr>
			<tr>
				<td style="text-align:left;">US Elevation</td>
				<td><input id="uselev" name="uselev" type="text" size="4"></td>
				<td style="text-align:left;">mAOD</td>
			</tr>
			<tr>
				<td style="text-align:left;">Bottom Slope</td>
				<td><input id="slope" name="slope" type="text" size="4"></td>
				<td style="text-align:left;">m/m</td>
			</tr>
			<tr>
				<td style="text-align:left;">Manning's n</td>
				<td><input id="manningsn" name="manningsn" type="text" size="4"></td>
				<td></td>
			</tr>
		</table>
		<br><br></div><br><br>

        <div class="tooltip"><h4 style="margin:0;">Flow Details</h4><span class="tooltiptext">The allows control over the coverage of the head discharge curve, WARNING: the more flow rates the longer the calculations will take.</span></div><br><br>
      
        Kinematic Viscosity (m<sup>2</sup>/s):  <input name="u" id="u" type="text" size="6" value="0.000015"><br><br>
        Minimum Flow (m<sup>3</sup>/s):  <input name="Qmin" id="Qmin" type="text" size="5" value="0.005">&nbsp; &nbsp; 
        Maximum Flow (m<sup>3</sup>/s): <input name="Qmax" id="Qmax" type="text" size="5" value="0.015">&nbsp; &nbsp; 
        <div class="tooltip">Number of Flow Rates: <span class="tooltiptext">This is the total number of calculations to be undertaken and will produce n-2 flow rate calculations between the minimum and maximum.</span></div> <input name="Qstep" id="Qstep" type="text" size="3" value="10"><br><br>

        <button class="submitbutton" type="submit">CALCULATE</button>

        <div id="dynamicmodal"></div>
      </form>
	</div>
	</div>
</div>
    
<!-- Page 2: Pipe profile graph -->

<div class="other_page" id="pipeprofile_anchor">
	<div class="content content_wrap_always" style="padding-top:100px;z-index:0;">
		<h1>Pipe Profile Graph</h1>
		<div style="text-align:center;margin-left:25px;margin-right:25px">Adjust the flow rate using the slider &rarr; Use shift to pan &rarr; Click and drag to zoom &rarr; Double click to refresh view.</div><br>
		<center><div id="slider" style="width:75%;margin-top:30px;">
			  <div id="custom-handle" class="ui-slider-handle"></div>
		</div></center><br>

		<div id="graphdiv" style="width: 95%; height: 400px"></div>

		<div id="legend" style="text-align:center;">
		  <div style="display:inline-block;">Hydraulic Grade Line: <div id="hydraulicgradeline" style="display: inline">0.000</div> mAOD </div> &nbsp; &nbsp; &nbsp;
		  <div style="display:inline-block;">Depth: <div id="depth" style="display: inline">0.000</div> m </div>&nbsp; &nbsp; &nbsp;
		  <div style="display:inline-block;">Velocity: <div id="velocity" style="display: inline">0.000</div> m/s </div>&nbsp; &nbsp; &nbsp;
		  <div style="display:inline-block;">Froude No: <div id="froudeno" style="display: inline">0.000</div> </div></div>

		<div id="graphdiv2" style="width: 95%; height: 150px;"></div><br>
		<button type="button" id="downloadpipeprofile" style="margin-left:60px;line-height:20px;vertical-align:top;">&nbsp;<img src="img/download.png" style="height:20px;vertical-align:bottom;" alt="download">&nbsp; &nbsp; PIPE PROFILE</button><br><br>
		<div style="padding-left:60px;">Get a result you suspect may be erroneous? Try refreshing the page <a href=""><b>here</b></a>. <br>Still suspicious? Report it <a id="senderrorreport2"><b>here</b></a>.</div>
	</div> 
</div>
    
<!-- Page 3: Head discharge graph -->
    
<div class="other_page" id="headdischarge_anchor">
	<div class="content content_wrap_always" style="padding-top:100px;">
		<h1>Head Discharge Graph</h1>
		<div style="text-align:center;margin-left:25px;margin-right:25px">
			Use shift to pan &rarr; Click and drag to zoom &rarr; Double click to refresh view.</div>
			  <br><br><br><br>
			<div id="graphdiv3" style="width: 100%; height: 400px;margin:auto;"></div>
		  <div id="legend2" style="text-align:right;">
				<div style="display:inline-block;"><br>Head: <div id="head" style="display: inline">0.000</div> m </div> &nbsp; &nbsp; &nbsp;
				<div style="display:inline-block;color:#0095D1;"><br>Inlet Control: <div id="headic" style="display: inline">0.000</div> m </div> &nbsp; &nbsp; &nbsp;
				<div style="display:inline-block;color:grey;"><br>Outlet Control: <div id="headoc" style="display: inline">0.000</div> m </div> &nbsp; &nbsp; &nbsp;
				<div style="display:inline-block;"><br>Discharge: <div id="discharge" style="display: inline">0.000</div> m&sup3;/s </div> &nbsp; &nbsp; &nbsp;
			</div><br>
		  <button type="button" id="downloadheaddischarge" style="margin-left:60px;line-height:20px;vertical-align:top;">&nbsp;<img src="img/download.png" style="height:20px;vertical-align:bottom;" alt="download">&nbsp; &nbsp; HEAD DISCHARGE</button> 
	   <div id="headdischarge"></div> 
	</div>   
</div>
    
<!-- Page 4: Summary Table -->
    
 <div class="other_page" id="summarytable_anchor">
	<div class="content content_wrap_always" style="padding-top:100px;">			
		<h1>Summary Table</h1>
		  <div style="text-align:center;margin-left:25px;margin-right:25px">Adjust the flow rate using the slider </div>
			<br><center><div id="slider2" style="width:75%;margin-top:30px;">
				<div id="custom-handle2" class="ui-slider-handle"></div>
			</div></center>
			<br><br><br>
		  <center>
		  <div id="summarytable">
			<table class='st'>
			  <tr>
				<th>Section</th>
				<th>Type</th>
				<th>Length (m)</th>
				<th>Rise (m)</th>
				<th>Slope</th>
				<th>Normal Depth (m)</th>
				<th>Critical Depth (m)</th>
				<th>Flow Profile</th>
			  </tr>
			  <tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			  </tr>
			</table>
		  </div>
		  </center>
		  <br><br>
		 <button type="button" id="downloadsummarytable" style="line-height:20px;vertical-align:top;">&nbsp;<img src="img/download.png" style="height:20px;vertical-align:bottom;" alt="download">&nbsp; &nbsp; SUMMARY TABLE</button> 
	 </div>
</div>   

<!-- Page 5: Report -->

<div class="other_page" id="report_anchor">
		<div class="content content_wrap_always" style="padding-top:100px;"><h1>Create Report</h1>
		<br><center><h5>Customise quality assurance report header. </h5></center>
		<form action="report.php" method="post" id="report" enctype="multipart/form-data" target="_top">
		<input type="hidden" name="sessionStorageID2" id="sessionStorageID2" value="none">
		<div id="reportheader" style="width: 100%;min-width: 550px;">      
		<table style="width:100%;">
		  <tr>
			  <th rowspan="2"><img src="img/logo.png" id="clogos" class="report_logos" alt="logo"><br><input type="file" name="clogo" id="clogo" accept="image/*" style="border:none;padding-left:0;"><h6 style="margin:0;">(Logo updated on generation of report.)</h6></th>
			  <td><b>Job No:</b> <input class="report_input" name="jn" id="jn" type="text"></td>
		  </tr>
		  <tr>
			  <td><b>Revision:</b> <input name="r" id="r" type="text" class="report_input"></td>
		  </tr>
		  <tr>
			  <td><b>Job Title:</b> <input name="jt" id="jt" type="text" class="report_input"></td>
			  <td><b>Author:</b> <input name="a" id="a" type="text" class="report_input"></td>
		  </tr>
		  <tr>
			  <td><b>Calculation:</b> <textarea id="cd" type="text" name="cd" class="report_input" style="display:table-cell; width:95%;resize: none;"></textarea></td>
			  <td><b>Date:</b></td>
		  </tr>
		</table>
			</div>
			<br><br><center><h5>Enter desired flow rate:</h5><br><input name="flowrate" id="flowrate" type="text" size="4" value="1"> m&sup3;/s</center>
		</form>
		<br><center><button type="button" class="submitbutton" id="createreport">Generate Report</button></center><br><br>
	</div>
</div>  

   
</body>
<script src="js/header.js"></script>
<script src="js/pipeflow.js"></script>
<script src="js/smoothscroll.js"></script>
</html>