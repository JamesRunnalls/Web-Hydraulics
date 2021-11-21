<?php
#Check if the user is logged in
session_start();
if(!isset($_SESSION['sig'])){
    header('Location: login.php');
    exit();		
}
?>
<!doctype html>
<html lang="en">
<head>
<meta name="description" content="Store your hydraulic calculations in the cloud.">
<meta name="author" content="Web Hydraulics">
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="google-site-verification" content="7v3GVkIr5i-or7p0rVPkUEDsvFU60kMpMoyUO5V_L4I" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Security-Policy" content="script-src 'self' cdnjs.cloudflare.com js.stripe.com ajax.googleapis.com;">
<link rel="stylesheet" href="css/style.css" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js" integrity="sha384-JUMjoW8OzDJw4oFpWIB2Bu/c6768ObEthBMVSiIx4ruBIEdyNSUQAjJNFqT5pnJ6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" integrity="sha384-Nlo8b0yiGl7Dn+BgLn4mxhIIBU6We7aeeiulNCjHdUv/eKHx59s3anfSUjExbDxn" crossorigin="anonymous" type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha384-Dziy8F2VlJQLMShA6FHWNul/veM9bCkRUaLqr199K94ntO5QUrLJBEbYegdSkkqX" crossorigin="anonymous"></script>
<script src="js/jquery.ui.touch-punch.min.js"></script>
<link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
<link rel="manifest" href="img/site.webmanifest">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<title>File Explorer | Web Hydraulics</title>
</head>

<body>
            
<!-- Context Menu's -->

<div class="contextmenu">
    <a class="contextmenu-option" id="contextmenurename">&nbsp Edit</a><br>
    <a class="contextmenu-option" id="contextmenumoveup">&nbsp Move Up</a><br>
    <a class="contextmenu-option" id="contextmenuduplicate">&nbsp Duplicate</a>
    <a class="contextmenu-option" id="contextmenudelete">&nbsp Delete</a>
</div>
    
<div class="contextmenu2">
    <a class="contextmenu-option" id="contextmenu2newfile">&nbsp New File</a><br>
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
                    <a href="profile.php">Profile</a>
                </li>
				<li class="dropdown menu__item">
                    <a href="help.php">Calculator Guide</a>
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
                    <a href="php/logout.php">Log Out</a>
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
							<li><a href="help.php">calculator guide</a></li>
							<li><a href="profile.php">profile</a></li>
                            <li><a href="policies.php">policies</a></li>
                            <li><a href="softwareverification.php">software verification</a></li>
							<li style="padding-top:50px;"><a class="learn-more-button" href="php/logout.php">log out</a></li>
						</ul>
					</div>
		</span>
	</div>
</header>  
 
<!-- Main Content -->
    
<div class="fileexplorer_page">
	<div class="fileexplorer_content">
    <div class="fileexplorerheader">
	    <div class="userareatitle"><h3 style="padding-left:10px;padding-top:3px;"></h3></div>
        <div id="up"><span title="Go up"><img class="up" src="img/up.png" alt="up"></span></div>
		<div id="plus"><span title="Add calculation"><img class="plus" src="img/plus.png" alt="plus"></span></div>
        <div class="location" id=location>Home</div>
    </div>
    <div id="fileexplorer" class="fileexplorer"></div>
    <div class="footer">
        Icons 
        <label class="switch">
          <input type="checkbox" id="checkbox" name="None">
          <span class="slider round"></span>
        </label>
        List
		</div>
    </div>
</div>
	
<!-- Welcome modal -->
	
<div id="welcome" class="modal">
    <div class="modal-content-hidden">
        <span id="close_w" class="close">&times;</span>
        <div class="modal-text" style="padding:30px;">
        <br><h2>Thanks for signing up to Web Hydraulics.</h2><br>
			<p>Welcome to the file explorer, use the plus icon or right click in the box to add your first file. </p>
        </div>
    </div>
</div>
    
    
<!-- New File/Folder Modal -->

<div id="addfolder" class="modal2">
    <div class="modal-content-hidden2">
        <span id="close_a" class="close">&times;</span>
        <div class="modal-text">
            <br><h4>New File/ Folder</h4>
            <br><select id="filetype" style="width:272px;">
			<option value="pipeflow">New Pipeflow</option>
			<option value="mannings">New Mannings</option>
			<option value="darcyweisbach">New Darcy-Weisbach</option>
			<option value="weir">New Weir</option>
			<option value="orifice">New Orifice</option>
			<option value="folder">New Folder</option>
			</select>
            <br><br><input id="filename" placeholder="Name" type="text" name="name" style="width:250px">
            <br><br><textarea id="description" placeholder="Description" type="text" name="name" style="width:250px;height:60px;"></textarea>
            <br><br><center><button type="button" class="fileexplorerbutton" name="None" id="newfileform">Create</button></center><br><br>
        </div>
    </div>
</div>
    
<!-- Rename File/Folder Modal -->

<div id="renamefolder" class="modal2">
    <div class="modal-content-hidden2">
        <span id="close_r" class="close">&times;</span>
        <div class="modal-text">
            <br><h4>Edit File/ Folder:</h4>
            <br>Name: <br><input id="renameinput" type="text" name="name" style="width:250px">
            <br><br>Description: <br><textarea id="renamedescription" type="text" name="name" style="width:250px;height:60px;"></textarea>
            <br><br><center><button type="button" class="fileexplorerbutton" id="renamefilebutton">Rename</button></center><br><br>
        </div>
    </div>
</div>
   
</body>
<script src="js/header.js"></script>
<script src="js/smoothscroll.js"></script>
<script src="js/filexplorer.js"></script>
</html>