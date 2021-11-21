<?php

#Check if the user is logged in
session_start();
if(!isset($_SESSION['sig'])){
	header('Location: login.php');
    exit();	
} else {
	
	if(!isset($_POST['flowrate'])){
		// Redirect to index if form hasnt been submitted
		header('Location: index.php');
    	exit();

	} else {
		include("php/savereportdetails.php");

		$target_file = 'img/users/'.$_POST["sessionStorageID2"].".png";

		$file = basename ($_FILES["clogo"]["name"]);
		$filetype = strtolower(pathinfo($file,PATHINFO_EXTENSION));
		if ($filetype == 'png') {
			$check = getimagesize($_FILES["clogo"]["tmp_name"]);
			if($check !== false) {
				move_uploaded_file($_FILES["clogo"]["tmp_name"], $target_file);
			} else {
				if (file_exists($target_file) == false){
					copy("img/logo.png", $target_file);
				}	
			}
		} else {
			if (file_exists($target_file) == false){
				copy("img/logo.png", $target_file);
			}	
		}
		
		// Create data transfer
		$out = [];
		$out["jn"] = $_POST["jn"];
		$out["jt"] = $_POST["jt"];
		$out["a"] = $_POST["a"];
		$out["cd"] = $_POST["cd"];
		$out["r"] = $_POST["r"];
		$out["sessionStorageID2"] = $_POST["sessionStorageID2"];
		$out["flowrate"] = $_POST["flowrate"];
		$_SESSION["report_session"] = $out;
	}
}

?>
<!doctype html>
<html lang="en">
<head>
<meta name="description" content="Pipe flow web calculator quality assurance reporting.">
<meta name="author" content="Web Hydraulics">
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="google-site-verification" content="7v3GVkIr5i-or7p0rVPkUEDsvFU60kMpMoyUO5V_L4I" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Security-Policy" content="script-src 'self' cdnjs.cloudflare.com webhydraulics.com js.stripe.com cdnpub.websitepolicies.com ajax.googleapis.com;">
<script src="js/d3.v4.min.js"></script>
<script type="text/javascript"
  src="js/dygraph.min.js"></script>
<script type="text/javascript"
  src="js/synchronizer.js"></script>
<link rel="stylesheet" src="css/dygraph.css" />  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js" integrity="sha384-JUMjoW8OzDJw4oFpWIB2Bu/c6768ObEthBMVSiIx4ruBIEdyNSUQAjJNFqT5pnJ6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" integrity="sha384-Nlo8b0yiGl7Dn+BgLn4mxhIIBU6We7aeeiulNCjHdUv/eKHx59s3anfSUjExbDxn" crossorigin="anonymous" type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha384-Dziy8F2VlJQLMShA6FHWNul/veM9bCkRUaLqr199K94ntO5QUrLJBEbYegdSkkqX" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/print.css" type="text/css">
<link rel="apple-touch-icon" sizes="180x180" href="/img/logo/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/img/logo/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/img/logo/favicon-16x16.png">
<link rel="mask-icon" href="/img/logo/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#2b5797">
<meta name="msapplication-config" content="/img/logo/browserconfig.xml">
<meta name="theme-color" content="#ffffff">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="js/MathJax/MathJax.js"></script>
<title>Report | Web Hydraulics</title>
</head>
    
<body>
    
<!-- Headers and styling that will not be printed -->
    
<div class="no-print">
    
    <!-- Loading -->
    
    <div id="loader-wrapper">
        <div id="loader"></div>
        <div id="loader-text">Building your report...</div>
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
                            <li><a href="#Methodology">1. Methodology</a></li>
							<li><a href="#Assumptions">2. Assumptions</a></li>
							<li><a href="#Inputs">3. Inputs</a></li>
							<li><a href="#Calculations">4. Calculations</a></li>
							<li><a href="#Results">5. Results</a></li>
							<li><a href="#Results">Appendix</a></li> 
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
							<li><a class="ham_burger" href="#Methodology">1. Methodology</a></li>
							<li><a class="ham_burger" href="#Assumptions">2. Assumptions</a></li>
							<li><a class="ham_burger" href="#Inputs">3. Inputs</a></li>
							<li><a class="ham_burger" href="#Calculations">4. Calculations</a></li>
							<li><a class="ham_burger" href="#Results">5. Results</a></li>
							<li><a class="ham_burger" href="#Results">Appendix</a></li>
							<li style="padding-top:50px;"><a class="learn-more-button" href="index.php">back home</a></li>
						</ul>
					</div>
		</span>
	</div>
</header>
       
    <!-- Print button -->
    
    <img id="printreport" src="img/download.png" class="pdf">
    
    <!-- Form for calculation -->
    
    <form action="" method="post" id="main" enctype="multipart/form-data" target="_top">
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="reportflowrate" id="reportflowrate">
        <input type="hidden" name="report" id="report">
    </form>
<br><br><br> 
</div>
   
<!-- Main content to be printed -->
    
<table id="reporttable" class="reporttext">
    
    <!-- Header for each page -->
    
   <thead><tr><td>
       <div id="reportheader">           
            <table class="headertable" style="width:100%;">
              <tr>
                  <th rowspan="2"><div id="img"><img src="" style="width:100px;"></div></th>
                  <td><b><div style="width:80px;display:inline-block">Job No:</div></b> <div id="jobno" style="display:inline-block"></div></td>
              </tr>
              <tr>
                  <td><b><div style="width:80px;display:inline-block">Revision:</div></b> <div id="rev" style="display:inline-block"></div></td>
              </tr>
              <tr>
                  <td><b><div style="width:100px;display:inline-block">Job Title:</div></b> <div id="title" style="display:inline-block"></div></td>
                  <td><b><div style="width:80px;display:inline-block">Author:</div></b> <div id="author" style="display:inline-block"></div></td>
              </tr>
              <tr>
                  <td><b><div style="width:100px;display:inline-block">Calculation:</div></b> <div id="calcdesc" style="display:inline-block"></div></td>
                  <td><b><div style="width:80px;display:inline-block">Date:</div></b> <div id="date" style="display:inline-block"></div> </td>
              </tr> 
            </table><br><br>
        </div>  
    </td></tr></thead>
   
    <tbody>
     <tr>
        <td style="text-align:left;">

            <!-- Inner Report Content -->
			
			<div class="printspace" style="margin-top:450px;"></div>
			<center><img id="img2" style="display:none;width:150px;max-height:150px;" src=""></center>
            <br><br><center><h2>Pipe Flow Hydraulic Calculation </h2></center><br><br>

            <table style="width:595px;padding-left:50px;" class="blanktable">
                <tr>
                    <th style="width:150px;">JOB TITLE</th>
                    <td><div id="2title" style="display:inline-block"></div></td>
                </tr>
                <tr>
                    <th>JOB NUMBER</th>
                    <td><div id="2jobno" style="display:inline-block"></div></td>
                </tr>
                <tr>
                    <th>MADE BY</th>
                    <td><div id="2author" style="display:inline-block"></div></td>
                </tr>
                <tr>
                    <th>DESCRIPTION</th>
                    <td><div id="2calcdesc" style="display:inline-block"></div></td>
                </tr>
                <tr>
                    <th>DATE</th>
                    <td><div id="2date" style="display:inline-block"></div></td>
                </tr>

            </table>     
         	<div class="printspace" style="margin-top:450px;"></div>

            <br><h2>Authorisation of Latest Version </h2><br>
            <table class="blanktable">
                <tr>
                    <td style="width:195px;">Type and method of check</td>
                    <td colspan=5 style="border:1px solid black;"></td>
                </tr>
				<tr></tr>
				<tr></tr>
				<tr>
                    <td colspan=2></td>
					<th style="text-align:center;">Name</th>
					<th style="text-align:center;">Signature</th>
                    <th style="text-align:center">Date</th>
                </tr>
                <tr>
                    <td>Signatures & dates</td>
                    <td style="width:150px;">Made by</td>
					<td style="width:250px;border:1px solid black;"></td>
                    <td style="width:250px;border:1px solid black;"></td>
                    <td style="width:100px;border:1px solid black;"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Checked by</td>
                    <td style="border:1px solid black;"></td>
                    <td style="border:1px solid black;"></td>
					<td style="border:1px solid black;"></td>
                </tr>
            </table>  
			<div class="printspace" style="margin-top:100px;"></div>
			 <div style="page-break-after: always;"></div><div>&nbsp;</div>
			
            <br><h2>Contents </h2><br> 
            
            <div style="padding-left:35px;padding-bottom:40px;">
			<a href="#Methodology" class="contents"><b>1. Methodology</b></a><br>
				<a href="#Scope" style="padding-left:20px"  class="contents">1.1 Scope</a><br>
				<a href="#CodesandStandards" style="padding-left:20px"   class="contents">1.2 Codes and Standards</a><br>
			<a href="#Assumptions"  class="contents"><b>2. Assumptions</b></a><br>
			<a href="#Inputs"  class="contents"><b>3. Inputs</b></a><br>
				 <a href="#EntranceSectionDetails" style="padding-left:20px"  class="contents">3.1 Entrance Section Details</a><br>
				 <a href="#SectionInput" style="padding-left:20px"  class="contents">3.2 Section Input</a><br>
				 <a href="#MinorLossParameters" style="padding-left:20px"  class="contents">3.3 Minor Loss Parameters</a><br>
				 <a href="#DownstreamSectionDetails" style="padding-left:20px" class="contents">3.4 Downstream Section Details</a><br>
				 <a href="#FlowDetails" style="padding-left:20px" class="contents">3.5 Flow Details</a><br>
			<a href="#Calculations" class="contents"><b>4. Calculations</b></a><br>
				<a href="#FlowParameters" style="padding-left:20px" class="contents">4.1 Flow Parameters</a><br>
				<a href="#SurfaceProfile" style="padding-left:20px" class="contents">4.2 Surface Profile</a><br>
				<a href="#Headwater" style="padding-left:20px" class="contents">4.3 Headwater</a><br>
			<a href="#Results"   class="contents"><b>5. Results</b></a><br>
				<a href="#PipeProfile" style="padding-left:20px" class="contents">5.1 Pipe Profile</a><br>
				<a href="#HeadDischarge" style="padding-left:20px" class="contents">5.2 Head Discharge</a><br>
			<a href="#Results" class="contents"><b>Appendix</b></a><br>
				<a href="#Equations" style="padding-left:20px" class="contents">A1 Equations</a><br>          
            </div>
			
            <!-- Methodology -->
            
            <div id="Methodology">
            <h2>1. Methodology </h2>
                
                <div id="Scope"></div>
                <h3>1.1 Scope</h3>
				
				<p>This calculator performs a complete pressurised and non-pressuring (open channel) set of hydraulic calculations in order to calculate surface profiles and headwater levels.</p>
				
				<p>This calculator has appropriate applications in culvert, drainage and pressurised pipe system design and analysis.</p>
            
                <div id="CodesandStandards"></div>
                <h3>1.2 Codes and Standards</h3>
				
				<p>The code is built on the best practice from the following publications. </p>
				
				<ul>
					<li>Hydraulic Design of Highway Culverts, Third Edition. U.S. Department of Transportation Federal Highway Administration.</li>
					<li>Culvert design and operation guide. CIRIA C689.</li>
				</ul>
				
			</div>
            
            <!-- Assumptions -->
            
            <div id="Assumptions">
            <br><h2>2. Assumptions </h2>
				
				<ol>
					<li>The calculator is dependent on assumption made in the development of the underlying equations that it uses. A full referenced list of all the equations used by the software can be found in Appendix A1.</li>
					<li>When there is a difference in critical depth between two sections the calculator assumes and instantaneous change in surface profile from one critical depth to the other. The author of the software is not aware of formulas available to accurately quantify this transition.</li>
				</ol>
				
			</div>
            
            <div style="page-break-after: always;"></div><div>&nbsp;</div>
            
            <!-- Inputs -->
            <div id="Inputs"></div>
            <h2>3. Inputs </h2>
            
                <div id="EntranceSectionDetails">
                <h3>3.1 Entrance Section Details</h3>
					
					This describes the inlet configuration and facilitates calculation of headwater level.

                    <table id="reportinlet" class="blanktable">
                      <tr>
                          <th>Type: </th>
                          <td><div id="InputType" name="InputType"></div></td> 
                      </tr>
                      <tr>
                          <th>Detail: </th>
                          <td><div id="InputDetail" name="InputDetail"></div></td>
                      </tr>
                    </table>
					
				</div>
            
                <div id="SectionInput">
                <h3>3.2 Section Input</h3>
					
					This describes the pipe properties. 

                    <table id="reportsections" class="stripetable" style="width:100%;">
                      <tr>
                        <th rowspan="2">Pipe Section</th>
                        <th rowspan="2">Type</th>
                        <th colspan="3">Size</th>
                        <th rowspan="2">Length (m)</th>
                        <th colspan="2">Elevation (mAOD)</th>
                        <th rowspan="2">Downstream Section <br> Transition</th> 
                        <th colspan="3">Roughness</th>
                      </tr>
                      <tr>
                        <td>Diameter (m)</td>
                        <td>Height (m)</td>
                        <td>Width (m)</td>
                        <td>US IL</td>
                        <td>DS IL</td>
                        <td>Ks (m)</td>
                        <td>n</td>
                        <td>K</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><div id="Section&0" name="Section&0">0</div></td>  
                        <td><div id="Type&0" name="Type&0"></div></td>
                        <td><div id="Diameter&0" name="Diameter&0"></div></td>
                        <td><div id="Height&0" name="Height&0"></div></td>
                        <td><div id="Width&0" name="Width&0"></div></td>
                        <td><div id="Length&0" name="Length&0"></div></td>
                        <td><div id="US&0" name="US&0"></div></td>
                        <td><div id="DS&0" name="DS&0"></div></td>
                        <td><div id="dstransition&0" name="dstransition&0"></div></td>  
                        <td><div id="Ks&0" name="Ks&0"></div></td>
                        <td><div id="n&0" name="n&0"></div></td>
                        <td><div id="K&0" name="K&0"></div></td>
                      </tr>
                    </table>
					<div class="tablelabel">Table 1. Pipe details.</div>
				</div>

                <div id="MinorLossParameters">
                <h3>3.3 Minor Loss Parameters</h3>
					
					The section lists the minor loss parameters entered. This does not necessarily relate to the final total minor loss used for the calculation. <br><br>

                    <table id="minorloss" class="stripetable">
                      <tr>
                        <th>Pipe Section</th>
                        <th>Type</th>
                        <th>Minor Loss Coefficient</th>
                        <th>Quantity</th>
                      </tr>
                      <tr>
                        <td><div id="mlpipesection&0&0" name="mlpipesection&0&0">0</div></td>
                        <td><div id="mltype&0&0" name="mltype&0&0"></div></td>
                        <td><div id="mlvalue&0&0" name="mlvalue&0&0"></div></td>
                        <td><div id="mlquanity&0&0" name="mlquanity&0&0"></div></td>
                      </tr>

                    </table><br>
					<div class="tablelabel">Table 2. Minor loss parameters.</div><br><br>
				</div>

                <div id="DownstreamSectionDetails">
                <h3>3.4 Downstream Section Details</h3>

                    <div id="downstream"></div><br>
					
				</div>

                <div id="Flowdetails">
                <h3>3.5 Flow Details</h3><br>

                    <table id="flowdetails" class="blanktable">
                        <tr>
                          <th>Kinematic Viscosity (m<sup>2</sup>/s): </th>
                          <td><div  name="u" id="u"></div></td> 
                        </tr>
                         <tr>
                          <th>Minimum Flow (m<sup>3</sup>/s): </th>
                          <td><div name="Qmin" id="Qmin"></div></td> 
                        </tr>
                         <tr>
                          <th>Maximum Flow (m<sup>3</sup>/s): </th>
                          <td><div name="Qmax" id="Qmax"></div></td> 
                        </tr>
                         <tr>
                          <th>Number of Flow Rates: </th>
                          <td> <div name="Qstep" id="Qstep"></div></td> 
                        </tr>
                         <tr>
                          <th>Report Flow Rate (m<sup>3</sup>/s):</th>
                             <td><div id="reportQ" name="reportQ"></div></td> 
                        </tr>
                    </table>
			</div>
           
            
            <!-- Calculations -->
			<div style="page-break-after: always;"></div><div>&nbsp;</div>
            <div id="Calculations"></div>
            <br><h2>4. Calculations </h2>
            
                <div id="FlowParameters"></div>
                <h3>4.1 Flow Parameters </h3>
                    
                    
                    <div id="NormalDepth">
                    <h4>4.1.1 Normal Depth</h4>
            
                        <p>Normal depth is the depth of flow in a section where the slope of the section is equal to the slope of the water surface. Gravitational force of water is equal to the frictional force from the surface. The normal depth is solved iteratively using the Mannings equation. For circular sections any depth above the maximum open channel flow depth will have a lower flow capacity, hence normal depth are never selected from this region. </p>
                        $$ Q = \frac{1}{n}A \left( \frac{A}{P} \right) ^{\frac{2}{3}}\sqrt S $$
                        <p style="text-align:center;">Mannings Equation. See Appendix A1 for full equation details.</p>
                        <p>The table below allows the verification of the normal depth flow calculations.</p>
            
                        <table id="ND" class="stripetable">
                            <tr>
                                <th>Pipe Section</th>
                                <th>Normal Depth (m)</th>
                            </tr>
                            <tr>
                                <td><div id="ND&pipesection&0" name="ND&pipesection&0">0</div></td>
                                <td><div id="ND&normaldepth&0" name="ND&normaldepth&0"></div></td>
                            </tr>    
                        </table><br>
						<div class="tablelabel">Table 3. Normal depth for pipe sections.</div>
						
					</div>
            
            
                    <div id="CriticalDepth">
                    <br><h4>4.1.2 Critical Depth</h4>
            
                        <p>Critical depth is defined as the depth of flow at which a given discharge occurs with minimum specific energy. This is characterised by a Froude number equal to one.</p>
                        $$ Fr = \frac{u}{\sqrt{gL}} $$
                        <p style="text-align:center;">Froude Equation. See Appendix A1 for full equation details.</p>
                        <p>The table below allows the verification of the critical depth flow calculations.</p>

                        <table id="CD" class="stripetable">
                            <tr>
                                <th>Pipe Section</th>
                                <th>Critical Depth (m)</th>
                            </tr>
                            <tr>
                                <td><div id="CD&pipesection&0" name="CD&pipesection&0">0</div></td>
                                <td><div id="CD&yc&0" name="CD&yc&0"></div></td>
                            </tr>    
                         </table><br>
						<div class="tablelabel">Table 4. Critical depth for pipe sections.</div>
            		</div>
            
                    <div id="FlowTypes">
                    <br><h4>4.1.3 Flow Type</h4>
            
                        <p>Flow type is the normal flow characteristics in a section. If the normal depth is equal to or greater than section height the flow type is "full" and the section operates under pressurised conditions. If the normal depth is less than section height but greater than critical depth the flow type is characterised as subcritical. If the normal depth is equal to or less than the critical depth the flow type is characterised as supercritical.</p>
                        <p>The table below allows the verification of the flow type calculations.</p>

                        <table id="FT" class="stripetable">
                            <tr>
                                <th>Pipe Section</th>
                                <th>Normal Depth (m)</th>
                                <th>Critical Depth (m)</th>
                                <th>Section Height (m)</th>
                                <th>Flow Type</th>
                            </tr>
                            <tr>
                                <td><div id="FT&pipesection&0" name="FT&pipesection&0">0</div></td>
                                <td><div id="FT&normaldepth&0" name="FT&normaldepth&0"></div></td>
                                <td><div id="FT&yc&0" name="FT&yc&0"></div></td>
                                <td><div id="FT&h&0" name="FT&h&0"></div></td>
                                <td><div id="FT&type&0" name="FT&type&0"></div></td>
                            </tr>    
                         </table><br>
						<div class="tablelabel">Table 5. Summary of flow type calculations.</div><br><br>
            		</div>
			
                    <div id="CalculatedMinorLosses">
                    <h4>4.1.4 Calculated Minor Losses</h4>
            
                        <p>The total minor loss over the section is a combination of section minor losses such as bends or valves and minor losses due to pipe size changes. Full equations for calculating the K value for pipe size changes are available in Appendix A1.</p>
                        <p>The table below allows the verification of the minor loss calculations.</p>

                        <table id="ML" class="stripetable">
                                <tr>
                                    <th rowspan="2">Pipe Section</th>
                                    <th colspan="3">Minor Loss</th>
                                </tr>
                                <tr>
                                    <td>User</td>
                                    <td>Pipe Size Change</td>
                                    <td>Total</td>
                                </tr>
                                <tr>
                                    <td><div id="FG&pipesection&0" name="FG&pipesection&0">0</div></td>
                                    <td><div id="FG&Ku&0" name="FG&Ku&0"></div></td>
                                    <td><div id="FG&Kp&0" name="FG&Kp&0"></div></td>
                                    <td><div id="FG&K&0" name="FG&K&0"></div></td>
                                </tr>    
                            </table><br>
						<div class="tablelabel">Table 6. Calculated minor losses.</div><br>
            		</div>
			
                    <div id="UpdatedManningsn">
                    <h4>4.1.5 Updated Mannings n</h4>
            
                        <p>Mannings n and the roughness factor are matched at the input stage. However the addition of flow rate dependent minor losses, which cannot be included in the user inputs, means the Mannings n value needs to be updated where minor losses are increased. The flow rate at the boundary between open channel flow and pressurised pipe flow is calculated using both Darcy-Weisbach Equation and Mannings Equation, if there is a discrepancy, due to the increased minor losses, the Mannings n value is iteratively increased until the values match.</p>
            
                        <table id="MN" class="stripetable">
                                <tr>
                                    <th rowspan="2">Pipe Section</th>
                                    <th colspan="2">Manning's n</th>
                                </tr>
                                <tr>
                                    <td>User</td>
                                    <td>Calculated</td>
                                </tr>
                                <tr>
                                    <td><div id="MN&pipesection&0" name="MN&pipesection&0">0</div></td>
                                    <td><div id="MN&n_user&0" name="MN&n_user&0"></div></td>
                                    <td><div id="MN&n&0" name="MN&n&0"></div></td>
                                </tr>    
                            </table><br>
						<div class="tablelabel">Table 7. Updated mannings n.</div><br><br>
            		</div>
			
                    <div id="MaximumOpenChannelFlow">
                   <h4>4.1.6 Maximum Open Channel Flow</h4>
            
                        <p>Maximum open channel flow defines the maximum flow rate at which the section operates under open channel flow (non-pressurised) conditions. This occurs at the maximum depth for rectangular sections and at around 94% of the diameter for circular sections. The maximum open channel flow is solved iteratively using the Manning's equation.</p>
                        $$Q = \frac{1}{n}A \left( \frac{A}{P} \right) ^{\frac{2}{3}}\sqrt S $$
                        <p style="text-align:center;">Manning's Equation. See Appendix A1 for full equation details.</p>
                        <p>The table below allows the verification of the maximum open channel flow calculations.</p>
            
                        <table id="MOCF" class="stripetable">
                            <tr>
                                <th rowspan="2">Pipe Section</th>
                                <th colspan="2">Max Open Channel Flow</th>
                            </tr>
                            <tr>
                                <td>Depth (m)</td>
                                <td>Flow (m&sup3;/s)</td>
                                
                            </tr>
                            <tr>
                                <td><div id="MOCF&pipesection&0" name="MOCF&pipesection&0">0</div></td>
                                <td><div id="MOCF&maxflowdepth&0" name="MOCF&maxflowdepth&0"></div></td>
                                <td><div id="MOCF&maxflow&0" name="MOCF&maxflow&0"></div></td>
                            </tr>    
                        </table><br>
						<div class="tablelabel">Table 8. Maximum open channel flow.</div><br>
                    </div>
            
                    <div id="FrictionGradient">
                    <h4>4.1.7 Friction Gradient</h4>
            
                        <p>The friction gradient is the head loss per m when the section is operating under pressurised conditions. This is required for sections that run completely or partially full. The friction gradient is solved by calculating the head loss at section full flow, using the Darcy-Weisbach and Colebrook-White equations, and dividing it by the section length. The friction factor is solved for iteratively.</p>
                        $$ h_{L} = f \frac{L}{D} \frac{V^2}{2g} + K \frac{V^{2}}{2g} $$
                        <p style="text-align:center;">Darcy-Weisbach Equation. See Appendix A1 for full equation details.</p>
                        $$ \frac{1}{\sqrt f} = -2log_{10} \left( \frac{\epsilon}{3.7D} + \frac{2.51}{Re \sqrt f} \right) $$
                        <p style="text-align:center;">Colebrook-White Equation. See Appendix A1 for full equation details.</p>
                        <p>The table below allows the verification of the friction gradient calculations.</p>

                        <table id="FG" class="stripetable">
                            <tr>
                                <th>Pipe Section</th>
                                <th>Darcy Friction Factor</th>
                                <th>Friction Gradient (m/m)</th>
                            </tr>
                            <tr>
                                <td><div id="FG&pipesection&0" name="FG&pipesection&0">0</div></td>
                                <td><div id="FG&f&0" name="FG&f&0"></div></td>
                                <td><div id="FG&dy&0" name="FG&dy&0"></div></td>
                            </tr>    
                        </table><br>
						<div class="tablelabel">Table 9. Friction gradients.</div><br>
            		</div>
                
                <div id="SurfaceProfile"></div>
                <h3>4.2 Surface Profile </h3>
			
				<p>Surface profile are determined iteratively by their upstream and downstream water levels. Type of flow curves depending on upstream and downstream water levels are shown below.</p>
			
				<img src="img/gvfp.png" style="display:block;width:500px;margin:auto;">
			
				<p>The table below gives the flow curves for each section.</p>
            
            
                    <table id="SP" class="stripetable">
                        <tr>
                            <th rowspan="2">Pipe Section</th>
                            <th colspan="2">Water Depth (m)</th>
                            <th rowspan="2">Normal Depth (m)</th>
                            <th rowspan="2">Critical Depth (m)</th>
                            <th rowspan="2">Type of Varied Flow</th>
                            <th rowspan="2">Flow Curves</th>
                        </tr>
                        <tr>
                            <td>Upstream</td>
                            <td>Downstream</td>
                        </tr>
                        <tr>
                            <td><div id="SP&pipesection&0" name="SP&pipesection&0">0</div></td>
                            <td><div id="SP&USwl&0" name="SP&USwl&0"></div></td>
                            <td><div id="SP&DSwl&0" name="SP&DSwl&0"></div></td>
                            <td><div id="SP&normaldepth&0" name="SP&normaldepth&0"></div></td>
                            <td><div id="SP&yc&0" name="SP&yc&0"></div></td>
                            <td><div id="SP&variedflow&0" name="SP&variedflow&0"></div></td>
                            <td><div id="SP&flowcurve&0" name="SP&flowcurve&0"></div></td>
                        </tr>    
                    </table><br>
					<div class="tablelabel">Table 10. Summary of surface profiles.</div>
            
            
                    <div id="GraduallyVariedFlow"></div>
                    <h4>4.2.1 Gradually Varied Flow </h4>
			
					<P>Gradually varied flow is the gradual progression of surface profile to normal depth. As the sections are prismatic the gradually varied flow surface profiles are calculated using the direct step method, available in Appendix A1.</P>
					<p>If the profile includes any gradually varied flow profiles they will be summarised in tables below. </p>

					<div id="GVFT"></div>
            
                    <div id="RapidlyVariedFlow">
                    <h4>4.2.2 Rapidly Varied Flow </h4><br>
                    
                    <p>Rapidly Varied Flow (RVF) is characterised by a rapid change in water depth or velocity. RVF often occurs near the inlet and outlets and at hydraulic jumps. Hydraulic jumps are identified at the intersection of sub and supercritical flow regimes. There are three types of hydraulic jump:</p>
						<ul>
							<li>Type A: Jump starts in subcritical section and completes in subcritical section.</li>
							<li>Jump B: Jump starts in supercritical section and completes in subcritical section.</li>
							<li>Type C: Jump starts in supercritical section and completes in supercritical section.</li>
						</ul>
					<p>The software differentiates between types by using the sequent depth at the intersection between super and sub critical sections. For Types B and C, the hydraulic jump is located at the intersection between the upstream S1 curve and the sequent depth. For Type A, the hydraulic jump is located at either Froude number = 1.7 or the intersection between the upstream S1 curve and the sequent depth, which ever occurs first.</p>
						
					<p>Sequent depth is calculated using the sequent depth equations available in Appendix A1. The hydraulic jump length is calculated using the hydraulic jump length formulas also available in Appendix A1.</p>
                            
                    <p>If the profile includes any hydraulic jumps they will be shown graphically below. </p>
            		</div>
                    <div id="RVF"></div>
            
                <div id="Headwater">
                <br><h3>4.3 Headwater </h3>
            
                    <p>Headwater is the upstream head level required to drive the system for a given flow rate. Pipe systems are defined according to which end controls the discharge capacity, the inlet or outlet.</p>
                    <p><b>Inlet Control:</b> The barrel can pass more flow than the inlet. This occurs when the upstream section of a pipe system has supercritical flow.</p>
                    <p><b>Outlet Control:</b> The inlet can pass more flow than the barrel. This occurs when the upstream section of a pipe system has subcritical or pressurised flow.</p>
                    <p>Both inlet and outlet control headwater levels are calculated for all flow rates, however the appropriate level is selected based on the flow parameters.</p>
				</div>

                    <div id="InletControl">
                    <h4>4.3.1 Inlet Control</h4>

                        <p>The headwater level for inlet control is calculated using the equations developed by the Federal Highway Administration in the US, available in Appendix A1. It is first determined if the inlet is unsubmerged (Q/AD<sup>0.5</sup> < 3.5), submerged (Q/AD<sup>0.5</sup> > 4) or transition (3.5 < Q/AD<sup>0.5</sup> < 4). The equations for unsubmered and submerged inlets are available in Appendix A1. For transition flow depths the headwater depth is calculated at the extremes of unsubmerged and submerged and linearly interpolated between the two. </p>

                        <p>The table below allows the verification of the inlet control calculations.</p>

                        <table id="IC" class="stripetable">
                            <tr>
                                <th rowspan="2">Inlet Type</th>
                                <th rowspan="2">Inlet Detail</th>
                                <th colspan="5">Coefficients</th>
                                <th rowspan="2">Q/AD<sup>0.5</sup></th>
                                <th rowspan="2">Critical Depth (m)</th>
                                <th rowspan="2">Type</th>
                                <th rowspan="2">Headwater (m)</th>
                                
                            </tr>
                            <tr>
                                <td>K</td>
                                <td>M</td>
                                <td>Y</td>
                                <td>c</td>
                                <td>Eq. Form</td>
                                
                            </tr>
                            <tr>
                                <td><div id="IC&InletType" name="IC&InletType"></div></td>
                                <td><div id="IC&InletDetail" name="IC&InletDetail"></div></td>
                                <td><div id="IC&K" name="IC&K"></div></td>
                                <td><div id="IC&M" name="IC&M"></div></td>
                                <td><div id="IC&Y" name="IC&Y"></div></td>
                                <td><div id="IC&c" name="IC&c"></div></td>
                                <td><div id="IC&form" name="IC&form"></div></td>
                                <td><div id="IC&par" name="IC&par"></div></td>
                                <td><div id="IC&yc" name="IC&yc"></div></td>
                                <td><div id="IC&type" name="IC&type"></div></td>
                                <td><div id="IC&hw" name="IC&hw"></div></td>
                            </tr>    
                        </table><br>
						<div class="tablelabel">Table 11. Inlet control headwater level.</div><br>
					</div>
    
                    <div id="OutletControl">
                    <h4>4.3.2 Outlet Control</h4>
                    
                    
                        <p>The headwater level for outlet control is calculated using the Darcy-Weisbach Equation.  </p>
                        $$ HW = y + Ke \frac{V^{2}}{2g} $$
                        <p style="text-align:center;">Minor loss section of the Darcy-Weisbach Equation. See Appendix A1 for full equation details.</p>
                        <p>The table below allows the verification of the outlet control calculations.</p>
                    </div>
                        <table id="OC" class="stripetable">
                            <tr>
                                <th>Inlet Type</th>
                                <th>Inlet Detail</th>
                                <th>Coefficient</th>
                                <th>Depth at Entrance (m)</th>
                                <th>Entrance Head Loss (m)</th>
                                <th>Headwater (m)</th>
                                
                            </tr>
                            <tr style="background-color:#f2f2f2;">
                                <td><div id="OC&InletType" name="OC&InletType"></div></td>
                                <td><div id="OC&InletDetail" name="OC&InletDetail"></div></td>
                                <td><div id="OC&Ke" name="OC&Ke"></div></td>
                                <td><div id="OC&y" name="OC&y"></div></td>
                                <td><div id="OC&Hl" name="OC&Hl"></div></td>
                                <td><div id="OC&HW" name="OC&HW"></div></td>
                            </tr>    
                        </table><br>
						<div class="tablelabel">Table 12. Outlet control headwater level.</div><br>
    
                    <div id="HeadwaterSummary">
                    <h4>4.3.3 Headwater Summary</h4>
						
						<p>Sections are determined to have inlet control if the upstream section has supercritical flow and to have outlet control if the upstream section has subcritical flow. However some designers may prefer the more conservative option of selecting the highest value of the two. </p>
    
                        <table id="HW" class="stripetable">
                            <tr>
                                <th colspan="4">Headwater</th>
                                <th rowspan="3">Control Type</th>
                            </tr>
                            <tr>
                                <td colspan="2">Inlet Control</td>
                                <td colspan="2">Outlet Control</td>
                            </tr>
                            <tr style="background-color:white;">
                                <td>(m)</td>
                                <td>(mAOD)</td>
                                <td>(m)</td>
                                <td>(mAOD)</td>
                            </tr>
                            <tr style="background-color:#f2f2f2;">
                                <td><div id="HW&IHW" name="HW&IHW"></div></td>
                                <td><div id="HW&IHWA" name="HW&IHWA"></div></td>
                                <td><div id="HW&OHW" name="HW&OHW"></div></td>
                                <td><div id="HW&OHWA" name="HW&OHWA"></div></td>
                                <td><div id="HW&CT" name="HW&CT"></div></td>
                            </tr>    
                        </table><br>
						<div class="tablelabel">Table 13. Summary of headwaters.</div>
                </div>
            
            <br>
            <!-- Results -->
			<div style="page-break-after: always;"></div><div>&nbsp;</div>
            <div id="Results"></div>
            <br><h2>5. Results </h2>
                
                <div id="PipeProfile"></div>
                <h3>5.1 Pipe Profile </h3><br>
            
                    <div id="graphdiv1" style="width: 95%; height: 400px;padding-left:2%;"></div>
                    <div id="legend" style="text-align:center;">
                      <div style="display:inline-block;color:#0095D1;">Hydraulic Grade Line: <div id="hydraulicgradeline" style="display: inline">0.000</div> mAOD </div> &nbsp &nbsp &nbsp
                      <div style="display:inline-block;">Normal Depth: <div id="normaldepth" style="display: inline">0.000</div> mAOD </div> &nbsp &nbsp &nbsp
                      <div style="display:inline-block;color:grey">Critical Depth: <div id="criticaldepth" style="display: inline;">0.000</div> mAOD </div> &nbsp &nbsp &nbsp
                      <div style="display:inline-block;">Depth: <div id="depth" style="display: inline">0.000</div> m </div><br>
                      <div style="display:inline-block;;color:red;">Velocity: <div id="velocity" style="display: inline">0.000</div> m/s </div>&nbsp &nbsp &nbsp
                      <div style="display:inline-block;;color:green;">Froude No: <div id="froudeno" style="display: inline">0.000</div> </div></div>
                    <div id="graphdiv2" style="width: 95%; height: 150px;padding-left:2%;"></div>
					<button type="button" id="downloadpipeprofile" style="line-height:20px;vertical-align:top;">&nbsp<img src="img/download.png" style="height:20px;vertical-align:bottom;">&nbsp &nbsp Download Pipe Profile</button>
            
                <div id="HeadDischarge"></div>
                <br><h3>5.2 Head Discharge </h3><br>
            
                    <div id="graphdiv3" style="width: 95%; height: 400px;"></div>
                    <div id="legend2" style="text-align:right;">
                        <div style="display:inline-block;"><br>Head: <div id="head" style="display: inline">0.000</div> m </div> &nbsp &nbsp &nbsp
                        <div style="display:inline-block;color:#0095D1;"><br>Inlet Control: <div id="headic" style="display: inline">0.000</div> m </div> &nbsp &nbsp &nbsp
                        <div style="display:inline-block;color:grey;"><br>Outlet Control: <div id="headoc" style="display: inline">0.000</div> m </div> &nbsp &nbsp &nbsp
                        <div style="display:inline-block;"><br>Discharge: <div id="discharge" style="display: inline">0.000</div> m&sup3;/s </div> &nbsp &nbsp &nbsp
                    </div>
					<button type="button" id="downloadheaddischarge" style="line-height:20px;vertical-align:top;">&nbsp<img src="img/download.png" style="height:20px;vertical-align:bottom;">&nbsp &nbsp Download Head Discharge</button>
            
            <!-- Appendix -->
			<div style="page-break-after: always;"></div><div>&nbsp;</div>
            <div id="Appendix"></div>
            <br><h2>Appendix</h2>
            
                <div id="Equations"></div>
                <h3>A1 Equations</h3>
	
	
			<h4>Contents </h4>
            	<a href="#ManningsEquation"  class="contents">1. Manning's Equation</a><br>
				<a href="#ReynoldsNumber"  class="contents">2. Reynolds Number</a><br>
				<a href="#FroudeNumber"  class="contents">3. Froude Number</a><br>
				<a href="#SwameeJainEquation"  class="contents">4. Swamee-Jain Equation</a><br>
				<a href="#ColebrookWhiteEquation"  class="contents">5. Colebrook-White Equation
</a><br>
				<a href="#DarcyWeisbachEquation"  class="contents">6. Darcy-Weisbach Equation
</a><br>
				<a href="#MinorLossesfromPipeSizeChanges"  class="contents">7. Minor Losses from Pipe Size Changes
</a><br>
				<a href="#BernoulliEquation"  class="contents">8. Bernoulli's Equation</a><br>
				<a href="#SequentDepthsinClosedConduits"  class="contents">9. Sequent Depths in Closed Conduits</a><br>
				<a href="#DirectStepMethod"  class="contents">10. Direct Step Method</a><br>
				<a href="#HydraulicJumpLength"  class="contents">11. Hydraulic Jump Length</a><br>
				<a href="#HeadwaterSupercriticalEntrance"  class="contents">12. Headwater - Supercritical Entrance</a><br>
				<a href="#HeadwaterSubcriticalEntrance"  class="contents">13. Headwater - Subcritical Entrance</a><br>
	
            
            <!-- Mannings Eqution -->

            <br><br><div id="ManningsEquation"><h4>1. Mannings Equation</h4>	

             $$ Q = \frac{1}{n}A \left( \frac{A}{P} \right) ^{\frac{2}{3}}\sqrt S $$

             Q = Flow rate (m3/s) <br>
             n = Mannings n <br>
             A = Cross sectional area of flow (m2) <br>
             P = Wetted Perimeter (m) <br>
             S = Slope (m/m) <br>

            <br><b>Reference</b>
             Manning, R. (1891). "On the flow of water in open channels and pipes". Transactions of the Institution of Civil Engineers of Ireland. 20: 161–207. <br><br></div>

            <!-- Reynolds No -->

            <br><br><div id="ReynoldsNumber"><h4>2. Reynolds Number</h4>	

             $$ Re = \frac{uL}{\nu} $$

             Re = Reynolds number <br>
             u = Velocity (m/s) <br>
             L = Characteristic length (m) - diameter/ equaivalent diameter for circular/ rectangular condiuts. <br>
            &nu; = Kinematic viscosity of fluid (m2/s) <br>

            <br><b>Reference</b>
             Reynolds, Osborne (1883). "An experimental investigation of the circumstances which determine whether the motion of water shall be direct or sinuous, and of the law of resistance in parallel channels". Philosophical Transactions of the Royal Society. 174 (0): 935–982. doi:10.1098/rstl.1883.0029. JSTOR 109431. <br><br></div>

             <!-- Froude No -->

            <br><br><div id="FroudeNumber"><h4>3. Froude Number</h4>	

             $$ Fr = \frac{u}{\sqrt{gL}} $$

            Fr = Froude number <br>
             u = Velocity (m/s) <br>
             L = Characteristic length (m) - diameter/ equaivalent diameter for circular/ rectangular condiuts. <br>
            g = Acceleration due to gravity (m/s2) <br>

            <br><b>Reference</b>
             Frank M. White, Fluid Mechanics, 4th edition, McGraw-Hill (1999), 294. <br><br></div>

             <!-- Swamee-Jain Equation -->

            <br><br><div id="SwameeJainEquation"><h4>4. Swamee-Jain Equation</h4>	


            $$ f = \frac{0.25}{log_{10} \left( \frac{\epsilon /D}{3.7} + \frac{5.74}{Re^0.9} \right) ^2} $$

            f = Darcy friction factor <br>
            &epsilon; = Effective roughness height (m) <br>
            D = Diameter (m) <br>
            Re = Reynolds number <br>

            <br><b>Reference</b>
             Swamee, P.K.; Jain, A.K. (1976). "Explicit equations for pipe-flow problems". Journal of the Hydraulics Division. 102 (5): 657–664. <br><br></div>


             <!-- Colebrook-White Equation -->

            <br><br><div id="ColebrookWhiteEquation"><h4>5. Colebrook-White Equation</h4>	


            $$ \frac{1}{\sqrt f} = -2log_{10} \left( \frac{\epsilon}{3.7D} + \frac{2.51}{Re \sqrt f} \right) $$

            f = Darcy friction factor <br>
            &epsilon; = Effective roughness height (m) <br>
            D = Hydraulic diameter (m) <br>
            Re = Reynolds number <br>

            <br><b>Reference</b>
            Colebrook, C F (1939). "Turbulent flow in pipes, with particular reference to the transition region between the smooth and rough pipe laws". Journal of the Institution of Civil Engineers. 11 (4): 133–156. doi:10.1680/ijoti.1939.13150. ISSN 0368-2455. <br><br></div>


            <!-- Darcy-Weisbach Equation -->

            <br><br><div id="DarcyWeisbachEquation"><h4>6. Darcy-Weisbach Equation</h4>	


            $$ h_{L} = f \frac{L}{D} \frac{V^2}{2g} + K \frac{V^{2}}{2g} $$

            h<sub>L</sub> = Head loss (m) <br>
            f = Darcy friction factor <br>
            K = Minor loss factor <br>
            L = Pipe length (m) <br>
            D = Hydraulic diameter (m) <br>
            V = Average flow velocity (m/2) <br>
            g = Acceleration due to gravity (m/s2) <br>

            <br><b>Reference</b>
            Brown, Glenn. "The Darcy–Weisbach Equation". Oklahoma State University–Stillwater. <br><br></div>


            <!-- Minor Losses from Pipe Size Changes -->

            <br><br><div id="MinorLossesfromPipeSizeChanges"><h4>7. Minor Losses from Pipe Size Changes</h4>	

            <br><b>Minor head loss equation</b><br><br>
            $$ h_{M} = K \frac{V^2}{2g} $$

            <b>Square Reduction </b><br><br>

            Re<sub>1</sub> < 2500

            $$ K = \left( 1.2 + \frac{160}{Re_{1}} \right) \left[ \left( \frac{D_{1}}{D_{2}} \right)^4 -1 \right] $$

            Re<sub>1</sub> > 2500

            $$ K = \left( 0.6 + 0.48 f_{1} \right) \left( \frac{D_{1}}{D_{2}} \right)^2 \left[ \left( \frac{D_{1}}{D_{2}} \right)^2 -1 \right] $$

            <b>Tapered Reduction </b><br><br>

            For 45&deg; < &theta; < 180&deg;, Multiply K from "square reduction" by:
            $$ \sqrt{\sin\left(\frac{\theta}{2}\right)} $$
            ​
            ​For &theta; < 45&deg;, Multiply K from "square reduction" by:
            $$ 1.6\sin\left(\frac{\theta}{2}\right) $$

            <b>Rounded Reduction </b><br><br>

            $$ K=\left(0.1+\frac{50}{Re_{1}}\right)\left[\left(\frac{D_{1}}{D_{2}}\right)^{4}-1\right] $$
			</div><div>
            <b>Square Expansion </b><br><br>

            For Re<sub>1</sub> < 4000
            $$ K=2\left[1-\left(\frac{D_{1}}{D_{2}}\right)^{4}\right] $$

            For Re<sub>1</sub> > 4000
            $$ K=\left(1+0.8f_{1}\right)\left[1-\left(\frac{D_{1}}{D_{2}}\right)^{2}\right]^{2} $$​​

            <b>Tapered Expansion </b><br><br>

            For &theta; > 45&deg; Use K for Square Expansion <br><br>

            For &theta; < 45&deg; Multiply K for a Square Expansion by,
            $$ 2.6\sin\left(\frac{\theta}{2}\right) $$

            <b>Rounded Expansion </b><br><br>

            Use K for square expansion. <br><br>

            h<sub>M</sub> = Head loss - minor losses (m) <br>
            K = Minor loss coefficient <br>
            Re<sub>1</sub> = Reynolds number upstream pipe <br>
            f<sub>1</sub> = Darcy friction factor upstream pipe <br>
            L = Pipe length (m) <br>
            D = Internal pipe diameter (m) <br>
            D<sub>1</sub> = Upstream pipe diameter (m) <br>
            D<sub>2</sub> = Downstream pipe diameter (m) <br>
            V = Average flow velocity (m/2) <br>
            &theta; = Taper angle (degrees) <br>

            <br><b>Reference</b>
            Native Dynamics (2012). Pressure Loss from Fittings – Expansion and Reduction in Pipe Size – Neutrium. [online] Neutrium.net. Available at: https://neutrium.net/fluid_flow/pressure-loss-from-fittings-expansion-and-reduction-in-pipe-size/ [Accessed 18 Sep. 2018]. <br><br></div>


            <!-- Bernoulli's Equation -->

            <br><br><div id="BernoulliEquation"><h4>8. Bernoulli's Equation</h4>	

            $$ H = z + \frac{p}{\rho g} + \frac{V^2}{2g} $$

            H = Energy Head (m) <br>
            z = Elevation of point above reference plane (m) <br>
            P = Pressure at given point (N/m2) <br>
            &rho; = Density of the fluid (kg/m3) <br>
            V = Average flow velocity (m/2) <br>
            g = Acceleration due to gravity (m/s2) <br>

             <br><br></div>


            <!-- Sequent Depths in Closed Conduits -->

            <br><br><div id="SequentDepthsinClosedConduits"><h4>9. Sequent Depths in Closed Conduits</h4>	

            <br><b>Rectangular Section</b><br><br>

            If Fr<sub>1</sub> < (Fr<sub>1</sub>)<sub>T</sub> (Complete jump forms)

            $$ y_{2} = y'_{2} = \frac{y'_{1}}{2} \left( \sqrt{1 + 8 Fr_{1}^{2}} - 1 \right) $$

            If Fr<sub>1</sub> &ge; (Fr<sub>1</sub>)<sub>T</sub> (Incomplete jump forms)

            $$ y_{2} = y'_{2} = \frac{1}{2} + \left( Fr_{1} ^{2} + \frac{1}{2} \right) y'{}_{1} ^{2} - Fr_{1}^{2} y'{}_{1} ^{3} $$

            Transitional Froude Number

            $$ (Fr_{1})_{T} = \sqrt{\frac{1 + y'_{1}}{2y'{}_{1}^2}} $$

            Froude Number

            $$ Fr_{1} = \frac{Q}{\sqrt{gB^{2}y_{1}^{3}}} $$
			</div><div>
            <b>Circular Section</b><br><br>

            If Fr<sub>1</sub> < (Fr<sub>1</sub>)<sub>T</sub> (Complete jump forms) <br><br>

            This needs to be solved iteratively to find Sd.

            $$ Fr_{1}^{2} = \frac{T'_{1}A'_{2} \left[ \left( \overline{z}A \right)'_{2} - \left( \overline{z}A \right)'_{1} \right]}{A'{}_{1}^{2} \left( A'_{2} - A'_{1} \right)} $$

            If Fr<sub>1</sub> &ge; (Fr<sub>1</sub>)<sub>T</sub> (Incomplete jump forms)

            $$ y_{2} = y'_{2} = 1 + \frac{1}{T'_{1}A'{}_{f}^{2}} \left( Fr_{1}^{2} A'{}_{1}^{2} \left( A'_{f} - A'_{1} \right) - T'_{1} A'_{f} \left[ \left( \overline{z}A \right)'_{f} - \left( \overline{z}A \right)'_{1}  \right] \right) $$

            Transitional Froude Number

            $$ (Fr_{1})_{T} = \sqrt{ \frac{T'_{1}A'_{f} \left[ \left( \overline{z}A \right)'_{f} - \left( \overline{z}A \right)'_{1} \right]}{A'{}_{1}^{2} \left( A'_{f} - A'_{1} \right)} } $$

            Froude Number

            $$ Fr_{1} = \frac{Q}{\sqrt{ \frac{gB^{2}D^{3}A'{}_{1}^{3}}{T'_{1}}}} $$

            Internal Flow Angle

            $$ \theta = 2 cos^{-1} \left( 1 - 2y' \right) $$

            Dimensionless Top Width

            $$ T' = \frac{T}{B} = sin \left( \frac{\theta}{2} \right) $$

            Dimensionless Area

            $$ A' = \frac{A_{i}}{D^{2}} = \frac{1}{8} \left( \theta - sin \theta \right) $$

            Dimensionless Centroid-Area

            $$ \left( \overline{z}A \right)' = \frac{\overline{z}A}{D^{3}} = \frac{1}{24} \left[ 3sin\left(\frac{\theta}{2} \right) - sin^{3}\left(\frac{\theta}{2} \right) - 3\frac{\theta}{2}cos\left(\frac{\theta}{2} \right)\right] $$

			</div><div>

            <b>Notation</b><br>
            y = Fluid depth (m) <br>
            y' = Dimentionless ratio of fluid depth <br>
            Fr = Froude number <br>
            (Fr)<sub>T</sub> = Transitional froude number <br>
            Q = Flow rate (m3/s) <br>
            g = Acceleration due to gravity (m/s2) <br>
            B = Span of conduit (m);
            T = Free surface width (m) <br>
            T' = Dimentionless ratio of free surface width <br>
            A = Cross sectional area (m2) <br>
            A'= Dimensionless cross sectional area (m2) <br>
            D = Rise of conduit (m) <br>
            <SPAN STYLE="text-decoration:overline">z</SPAN>  = Distance from the water surface to the centroid of cross-sectional area (m) <br>
            &theta; = Internal flow angle (rad)

            <br><b>Subscripts</b><br>
            1 = Parameter at input depth <br>
            2 = Parameter at sequent depth <br>
            f = Parameter at pipe full depth <br>

            <br><b>Reference</b>
            J. Lowe, Nathan & Hotchkiss, Rollin & James Nelson, E. (2011). Theoretical Determination of Sequent Depths in Closed Conduits. Journal of Irrigation and Drainage Engineering. 137. 801-810. 10.1061/(ASCE)IR.1943-4774.0000349.  <br><br></div>


            <!-- Direct Step Method -->

            <br><br><div id="DirectStepMethod"><h4>10. Direct Step Method</h4>	

            <br><b>Distance between changes in depth</b>

            $$ \Delta x = \frac{E_{2}-E_{1}}{S_{0}- \overline{S_{f}}} $$

            <b>Specific Energy </b>

            $$ E = y + \frac{V^{2}}{2g} $$ 

            <b>Friction Slope</b>

            $$ S_{f} = \left( \frac{nQ}{A \frac{A}{P}^{2/3}} \right)^{2} $$

            <b>Average Friction Slope</b>

            $$ \overline{S_{f}} = \frac{S_{f2}+S_{f1}}{2} $$

            &Delta;x = Distance between two depths <br>
            E<sub>1</sub> = Specfic energy at first point (m) <br>
            E<sub>2</sub> = Specfic energy at second point (m) <br>
            S<sub>0</sub> = Bottom slope of conduit (m/m) <br>
            <SPAN STYLE="text-decoration:overline">S</SPAN><sub>f</sub> = Average friction slope (m/m) <br>
            S<sub>f1</sub> = Friction slope at first point (m/m) <br>
            S<sub>f2</sub> = Friction slope at second point (m/m) <br>
            y = Fluid depth at point (m) <br>
            V = Average velocity at point (m/s) <br>
            g = Acceleration due to gravity (m/s2) <br>
            n = Mannings n <br>
            Q = Flow rate (m3/s) <br>
            A = Cross sectional area at point (m2) <br>
            P = Wetted perimiter (m) <br>

            <br><b>Reference</b>
            CHOW, V. T. (1959). Open-channel hydraulics. New York, McGraw-Hill. <br><br></div>


            <!-- Hydraulic Jump Length -->

            <br><br><div id="HydraulicJumpLength"><h4>11. Hydraulic Jump Length</h4>	

            <br><b>Rectangular Section</b><br><br>

            Flat Slope (Type A) - Start of jump in downstream section

            $$ L^{*}_{j} = 220(y_{1}) \left( tanh \left( \frac{Fr_{1}-1}{22} \right) \right) $$

            Jump over slope break (Type B) - Start of jump in upstream section end of jump in downstream section <br><br>

            &nbsp; &nbsp; If Fr<sub>1</sub> > Fr<sub>1t</sub>

            $$ L_{j} = L^{*}_{j} $$

            &nbsp; &nbsp; If Fr<sub>1</sub> &le; Fr<sub>1t</sub>

            $$ L_{j} = h_{2} \left[ \frac{7}{3} \left( 2+\left[6E * exp(1-6E) \right] \right) - \frac{1}{20} \left( 1+5\left[ 6E * exp(1-6E) \right] \right) \left(Fr_{1} -2 \right) \right] $$

            &nbsp; &nbsp; Where

            $$ E = \frac{\left( h_{2} - z_{1} \right)}{h_{2}} $$

            &nbsp; &nbsp; Transitional Froude No

            $$ Fr_{1t} = 11.3 \left( 1 - \frac{2}{3} \left[ \frac{h_{2} - z_{1}}{h_{2}} \right] \right) $$

            Sloped Culvert (Type C) - Jump contained in upstream section

            $$ L_{j} = L^{*}_{j} * exp \left( -\frac{4}{3} \theta\right) $$
			</div><div>
            <b>Circular Section</b><br><br>

            Flat Slope (Type A) - Start of jump in downstream section

            $$ L^{*}_{j} = 6y_{2} $$

            Jump over slope break (Type B) - Start of jump in upstream section end of jump in downstream section <br><br>

            &nbsp; &nbsp; If Fr<sub>1</sub> > Fr<sub>1t</sub>

            $$ L_{j} = L^{*}_{j} $$

            &nbsp; &nbsp; If Fr<sub>1</sub> &le; Fr<sub>1t</sub>

            $$ L_{j} = h_{2} \left[ \frac{7}{3} \left( 2+\left[6E * exp(1-6E) \right] \right) - \frac{1}{20} \left( 1+5\left[ 6E * exp(1-6E) \right] \right) \left(Fr_{1} -2 \right) \right] $$

            &nbsp; &nbsp; Where

            $$ E = \frac{\left( h_{2} - z_{1} \right)}{h_{2}} $$

            &nbsp; &nbsp; Transitional Froude No

            $$ Fr_{1t} = 11.3 \left( 1 - \frac{2}{3} \left[ \frac{h_{2} - z_{1}}{h_{2}} \right] \right) $$

            Sloped Culvert (Type C) - Jump contained in upstream section

            $$ L_{j} = L^{*}_{j} * exp \left( -\frac{4}{3} \theta\right) $$

            L*<sub>j</sub> = Length of hydraulic jump on flat slope (m) <br>
            L<sub>j</sub> = Length of the hydraulic jump on a sloping channel (m) <br>
            y<sub>1</sub> = Sequent depth at the upstream end of the hydraulic jump (m) <br>
            y<sub>2</sub> = Sequent depth at the downstream end of the hydraulic jump (m) <br>
            Fr<sub>1</sub> = Froude number at the upstream end of the hydraulic jump <br>
            &theta; = Channel angle of repose (rad) <br>
            z<sub>1</sub> = Distance from the invert of the flat part of the channel to the channel invert at the beginning of the jump (m) <br>
            h<sub>2</sub> = Depth of water on a flat slope after the jump (m) <br>

            <br><b>Reference</b>
            Bradley, J.N., Peterka, A. J., “Hydraulic Design of Stilling Basins,” Journal of A.S.C.E., Hydraulic Engg, 83 (5), 1401-1406, 1957. <br>
            Hager  WH  (1992).  “Energy  dissipators  and  hydraulic  jump”,  Kluwer Academic  Publications,  Dordrecht, The  Netherlands.  <br><br></div>


            <!-- Headwater - Supercritical Entrance -->

            <br><br><div id="HeadwaterSupercriticalEntrance"><h4>12. Headwater - Supercritical Entrance</h4>	

            <br><b>Unsubmerged Inlet</b> Q/AD<sup>0.5</sup> < 3.5

            $$ \frac{HW_{i}}{D} = \frac{H_{c}}{D} + K \left[ \frac{Q}{AD^{0.5}} \right]^{M} - 0.5S $$

            $$ \frac{HW_{i}}{D} = K \left[ \frac{Q}{AD^{0.5}} \right]^{M} $$

            &nbsp; &nbsp; Specific head at critical depth

            $$ H_{c} = d_{c} + \frac{V_{c}^{2}}{2g} $$

            <br><b>Submerged Inlet</b> Q/AD<sup>0.5</sup> > 4.0

            $$ \frac{HW_{i}}{D} = c \left[ \frac{Q}{AD^{0.5}} \right]^{2} + Y - 0.5S $$

            HW<sub>i</sub> = Headwater for supercritical entrance (ft) <br>
            H<sub>c</sub> = Specific head at critical depth (ft) <br>
            d<sub>c</sub> = Critical depth (ft) <br>
            V<sub>c</sub> = Average flow velocity at critical depth <br>
            g = Acceleration due to gravity (m/s2) <br>
            Q = Flow rate (ft3/s) <br>
            A = Cross sectional area (ft2) <br>
            D = Rise of conduit (ft) <br>
            K, M, c, Y = Constants <br>

            <br><b>Reference</b>
            Thiele, Elizabeth Anne, "Culvert Hydraulics: Comparison of Current Computer Models" (2007). All Theses and Dissertations. 881. https://scholarsarchive.byu.edu/etd/881 <br><br></div>


            <!-- Headwater - Subcritical Entrance -->

            <br><br><div id="HeadwaterSubcriticalEntrance"><h4>13. Headwater - Subcritical Entrance</h4>	

            $$ HW = y + Ke \frac{V^{2}}{2g} $$

            HW = Headwater for subcritical entrance (m) <br>
            y = Fluid depth at entrance (m) <br>
            Ke = Minor loss coefficient (m) <br>
            V = Average flow velocity (m/2) <br>
            g = Acceleration due to gravity (m/s2) <br>

            <br><br><br></div>
            </div>

            
         
     </td>
    </tr>
   </tbody>
    
    <!-- Footer for each page -->
    
   <tfoot>
       <tr>
           <td>    
           </td>
       </tr>
    </tfoot>
</table>
<br><br><br>
</body>
<script src="js/report.js"></script>
<script src="js/header.js"></script>
<script src="js/smoothscroll.js"></script>
</html>