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
					<tbody><tr>
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
					</tbody></table><br><br>

				<h3>Case A - Results</h3><br><br>

				<div id="CaseA" style="text-align:center"><table class="stripetable" style="min-width:700px;"><tbody><tr><th rowspan="2">Q</th><th colspan="2">Thesis Headwater (ft)</th><th colspan="2">Web Hydraulics Headwater (ft)</th></tr><tr><th>Inlet Control</th><th>Outlet Control</th><th>Inlet Control</th><th>Outlet Control</th></tr><tr><td>30</td><td>2.07</td><td>N/A</td><td>2.0672</td><td>2.4514</td></tr><tr><td>60</td><td>3.07</td><td>N/A</td><td>3.0741</td><td>3.6262</td></tr><tr><td>90</td><td>3.96</td><td>N/A</td><td>3.9568</td><td>4.6945</td></tr><tr><td>120</td><td>4.81</td><td>N/A</td><td>4.8088</td><td>6.1229</td></tr><tr><td>150</td><td>5.67</td><td>N/A</td><td>5.6692</td><td>8.7614</td></tr><tr><td>180</td><td>6.67</td><td>N/A</td><td>6.6697</td><td>11.3672</td></tr><tr><td>210</td><td>7.88</td><td>N/A</td><td>7.8775</td><td>14.2010</td></tr><tr><td>240</td><td>9.27</td><td>N/A</td><td>9.2712</td><td>17.3320</td></tr><tr><td>270</td><td>10.85</td><td>N/A</td><td>10.8506</td><td>20.7940</td></tr><tr><td>300</td><td>12.62</td><td>N/A</td><td>12.6159</td><td>24.6087</td></tr></tbody></table><br>Inlet Control Verified = <div style="color:green;display:inline-block;">True</div>   Outlet Control Verified = <div style="color:green;display:inline-block;">True</div><br><br><br><br></div>

				<form action="" method="post" name="CaseA" enctype="multipart/form-data" target="_top">
				<input type="hidden" name="id" id="id" value="65">
				<input type="hidden" name="softvar" id="softvar">
				</form>

				<h3>Case B - Results</h3><br><br>

				<form action="" method="post" name="CaseB" enctype="multipart/form-data" target="_top">
				<input type="hidden" name="id" id="id" value="66">
				<input type="hidden" name="softvar" id="softvar">
				</form>

				<div id="CaseB" style="text-align:center"><table class="stripetable" style="min-width:700px;"><tbody><tr><th rowspan="2">Q</th><th colspan="2">Thesis Headwater (ft)</th><th colspan="2">Web Hydraulics Headwater (ft)</th></tr><tr><th>Inlet Control</th><th>Outlet Control</th><th>Inlet Control</th><th>Outlet Control</th></tr><tr><td>10</td><td>1.16</td><td>1.3</td><td>1.1641</td><td>1.2954</td></tr><tr><td>20</td><td>1.68</td><td>1.86</td><td>1.6766</td><td>1.8602</td></tr><tr><td>30</td><td>2.09</td><td>2.31</td><td>2.0872</td><td>2.3069</td></tr><tr><td>40</td><td>2.45</td><td>2.69</td><td>2.4483</td><td>2.6937</td></tr><tr><td>50</td><td>2.78</td><td>3.04</td><td>2.7805</td><td>3.0433</td></tr><tr><td>60</td><td>3.09</td><td>3.38</td><td>3.0941</td><td>3.3674</td></tr><tr><td>70</td><td>3.39</td><td>3.67</td><td>3.3955</td><td>3.6731</td></tr><tr><td>80</td><td>3.69</td><td>3.96</td><td>3.6888</td><td>3.9654</td></tr><tr><td>90</td><td>3.98</td><td>4.25</td><td>3.9768</td><td>4.2476</td></tr><tr><td>100</td><td>4.26</td><td>4.52</td><td>4.2617</td><td>4.5223</td></tr></tbody></table><br>Inlet Control Verified = <div style="color:green;display:inline-block;">True</div>   Outlet Control Verified = <div style="color:green;display:inline-block;">True</div><br><br><br><br></div>

				<h3>Case C - Results</h3><br><br>

				<form action="" method="post" name="CaseC" enctype="multipart/form-data" target="_top">
				<input type="hidden" name="id" id="id" value="69">
				<input type="hidden" name="softvar" id="softvar">
				</form>

				<div id="CaseC" style="text-align:center"><table class="stripetable" style="min-width:700px;"><tbody><tr><th rowspan="2">Q</th><th colspan="2">Thesis Headwater (ft)</th><th colspan="2">Web Hydraulics Headwater (ft)</th></tr><tr><th>Inlet Control</th><th>Outlet Control</th><th>Inlet Control</th><th>Outlet Control</th></tr><tr><td>15</td><td>1.44</td><td>N/A</td><td>1.4370</td><td>1.6267</td></tr><tr><td>30</td><td>2.08</td><td>N/A</td><td>2.0847</td><td>2.3429</td></tr><tr><td>45</td><td>2.61</td><td>N/A</td><td>2.6147</td><td>2.9167</td></tr><tr><td>60</td><td>3.09</td><td>N/A</td><td>3.0916</td><td>3.4216</td></tr><tr><td>75</td><td>3.54</td><td>3.88</td><td>3.5404</td><td>3.8787</td></tr><tr><td>90</td><td>3.97</td><td>4.3</td><td>3.9743</td><td>4.2954</td></tr><tr><td>105</td><td>4.4</td><td>4.69</td><td>4.4011</td><td>4.6916</td></tr><tr><td>120</td><td>4.83</td><td>5.08</td><td>4.8263</td><td>5.0775</td></tr><tr><td>135</td><td>5.25</td><td>5.46</td><td>5.2538</td><td>5.4599</td></tr><tr><td>150</td><td>5.69</td><td>5.84</td><td>5.6867</td><td>5.8442</td></tr></tbody></table><br>Inlet Control Verified = <div style="color:green;display:inline-block;">True</div>   Outlet Control Verified = <div style="color:green;display:inline-block;">True</div><br><br><br><br></div>

				<h3>Case D - Results</h3><br><br>

				<form action="" method="post" name="CaseD" enctype="multipart/form-data" target="_top">
				<input type="hidden" name="id" id="id" value="68">
				<input type="hidden" name="softvar" id="softvar">
				</form>

				<div id="CaseD" style="text-align:center"><table class="stripetable" style="min-width:700px;"><tbody><tr><th rowspan="2">Q</th><th colspan="2">Thesis Headwater (ft)</th><th colspan="2">Web Hydraulics Headwater (ft)</th></tr><tr><th>Inlet Control</th><th>Outlet Control</th><th>Inlet Control</th><th>Outlet Control</th></tr><tr><td>20</td><td>1.67</td><td>4.03</td><td>1.6691</td><td>4.0337</td></tr><tr><td>40</td><td>2.44</td><td>4.13</td><td>2.4408</td><td>4.1346</td></tr><tr><td>60</td><td>3.09</td><td>4.3</td><td>3.0866</td><td>4.3025</td></tr><tr><td>80</td><td>3.68</td><td>4.54</td><td>3.6813</td><td>4.5371</td></tr><tr><td>100</td><td>4.25</td><td>4.84</td><td>4.2542</td><td>4.8375</td></tr><tr><td>120</td><td>4.82</td><td>5.2</td><td>4.8213</td><td>5.2024</td></tr><tr><td>140</td><td>5.39</td><td>5.63</td><td>5.3923</td><td>5.6288</td></tr><tr><td>160</td><td>6</td><td>6.11</td><td>6.0964</td><td>6.1108</td></tr><tr><td>180</td><td>6.68</td><td>6.63</td><td>6.6822</td><td>6.6354</td></tr><tr><td>200</td><td>7.47</td><td>7.18</td><td>7.4668</td><td>7.1837</td></tr></tbody></table><br>Inlet Control Verified = <div style="color:green;display:inline-block;">False</div>   Outlet Control Verified = <div style="color:green;display:inline-block;">True</div><br><br><br><br></div>
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
</html>