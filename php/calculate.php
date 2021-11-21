<?php

// Script for calculation hydraulic profiles in pipe systems
// Author: James Runnalls

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['user'])){
    ini_set('max_execution_time', 1000);
} else {
    ini_set('max_execution_time', 5);
}

// Load functions from external files

include("class_lib.php");
include("functions.php");

// Create output variables 

if (isset($_POST["report"])){
	$arr = array(); // Ouput variable
} else {
	$arr = array(); // Output variable
	$head = array(); // Head information for head discharge curve 
    $discharge = array(); // Discharge information for head discharge curve 
	$summarytable = array(); // Summary table details
}

// Import calculation variables

if (isset($_POST["report"])){

	// Retrieve parameters from database
	$Q_report = $_POST["reportflowrate"];
	$id = $_POST["id"];
	$username = $_SESSION["user"];
    include("db.php");

    $sql = $conn->prepare("SELECT * FROM pipeparameters WHERE User = ? and Folderid = ?");
    $sql->bind_param('ss', $username, $id);
    $sql->execute();
    $sql->store_result();
    $var = [];
    while ($row = fetchAssocStatement($sql)){
    	$var[$row['Name']] = $row['Value'];
    }
    $InputType = $var["InputType"];
    $InputDetails = $var["InputDetail"];
    $Type = varmultipleinputs($var,"Type");
    $Diameter = varmultipleinputs($var,"Diameter");
    $Height = varmultipleinputs($var,"Height");
    $Width = varmultipleinputs($var,"Width");
    $Length = varmultipleinputs($var,"Length");
    $US = varmultipleinputs($var,"US");
    $DS = varmultipleinputs($var,"DS");
    $Ks = varmultipleinputs($var,"Ks");
    $n = varmultipleinputs($var,"n");
    $K = varmultipleinputs($var,"K");
    $dstransition = varmultipleinputs($var,"dstransition");
    $dstype = $var["dstype"];
    $dswl = $var["dswl"];
    $dswidth = $var["dswidth"];
    $dssideslope = $var["dssideslope"];
    $uselev = $var["uselev"];
    $slope = $var["slope"];
    $manningsn = $var["manningsn"];
    $u = $var["u"];
    $Qmin = $var["Qmin"];
    $Qmax = $var["Qmax"];
    $Qstep = $var["Qstep"];
    
    $arr["inputs"] = $var;
    $arr["len"] = count($Type);
} else if (isset($_POST["softvar"])){
	$id = $_POST["id"];
	$username = $_SESSION["user"];
    include("db.php");

    $sql = $conn->prepare("SELECT * FROM pipeparameters WHERE User = ? and Folderid = ?");
    $sql->bind_param('ss', $username, $id);
    $sql->execute();
    $sql->store_result();
    $var = [];
    while ($row = fetchAssocStatement($sql)){
    	$var[$row['Name']] = $row['Value'];
    }
    $InputType = $var["InputType"];
    $InputDetails = $var["InputDetail"];
    $Type = varmultipleinputs($var,"Type");
    $Diameter = varmultipleinputs($var,"Diameter");
    $Height = varmultipleinputs($var,"Height");
    $Width = varmultipleinputs($var,"Width");
    $Length = varmultipleinputs($var,"Length");
    $US = varmultipleinputs($var,"US");
    $DS = varmultipleinputs($var,"DS");
    $Ks = varmultipleinputs($var,"Ks");
    $n = varmultipleinputs($var,"n");
    $K = varmultipleinputs($var,"K");
    $dstransition = varmultipleinputs($var,"dstransition");
    $dstype = $var["dstype"];
    $dswl = $var["dswl"];
    $dswidth = $var["dswidth"];
    $dssideslope = $var["dssideslope"];
    $uselev = $var["uselev"];
    $slope = $var["slope"];
    $manningsn = $var["manningsn"];
    $u = $var["u"];
    $Qmin = $var["Qmin"];
    $Qmax = $var["Qmax"];
    $Qstep = $var["Qstep"];
} else {
	// Save POST variables to database
	include("savevariables.php");

	// Retrieve parameters from post 
	$InputType = $_POST["InputType"];
	$InputDetails = $_POST["InputDetail"];
	$Type = multipleinputs("Type");
	$Diameter = multipleinputs("Diameter");
	$Height = multipleinputs("Height");
	$Width = multipleinputs("Width");
	$Length = multipleinputs("Length");
	$US = multipleinputs("US");
	$DS = multipleinputs("DS");
	$Ks = multipleinputs("Ks");
	$n = multipleinputs("n");
	$K = multipleinputs("K");
	$dstransition = multipleinputs("dstransition");
	$dstype = $_POST["dstype"];
	$dswl = $_POST["dswl"];
	$dswidth = $_POST["dswidth"];
	$dssideslope = $_POST["dssideslope"];
	$uselev = $_POST["uselev"];
	$slope = $_POST["slope"];
	$manningsn = $_POST["manningsn"];
	$u = $_POST["u"];
	$Qmin = $_POST["Qmin"];
	$Qmax = $_POST["Qmax"];
	$Qstep = $_POST["Qstep"];
}

// Create input and output classes

$inlet = new Generic;
$inlet->setType($InputType);
$inlet->setDetail($InputDetails);
$outlet = new Generic;
$outlet->setType($dstype);
if ($dstype == "freedischarge"){
    $outlet->settailwater('None');
} else if ($dstype == "fixedheight"){
    $outlet->settailwater($dswl);
} else if ($dstype == "section"){
    $outlet->setw($dswidth);
    $outlet->setz($dssideslope);
    $outlet->setus($uselev);
    $outlet->setS($slope);
    $outlet->setn($manningsn);
	$outlet->seth(2);
}

// Set up flow rates to run

if (isset($_POST["report"])){
	$flowrange = [$Q_report];
} else {
	// Sort flow ranges for low rates
	if (strval($Qstep) !== strval(intval($Qstep))) {if ($Qmax !== $Qmin){$Qstep = 2;} else {$Qstep = 1;}}
	$flowrange = steprange($Qmin,$Qmax,($Qstep-1));
}

// Iterate over the flow rates
for ($Qi = 0; $Qi < count($flowrange); $Qi++) {
	// Set flow rate value
	$Q = (float)$flowrange[$Qi];
    //echo "Q: ".$Q."<br>";
	// Create blank array for pipes
	$pipes = array();

	// Iterate over pipes and create class for each section
	for ($x = 0; $x < count($Type); $x++) {

		// Initiate pipe class
        $pipe = new Generic;
        // Add generic pipe parameters
        $pipe->setType($Type[$x]);
        $pipe->setL($Length[$x]);
        $pipe->setKs($Ks[$x]);
        $pipe->setn($n[$x]);
        $pipe->setK($K[$x]);
        $pipe->setdst($dstransition[$x]);
        $pipe->setu($u);
        $pipe->setus($US[$x]);
        $pipe->setds($DS[$x]);
        $pipe->setde($US[$x]-$DS[$x]);
        $pipe->setS(($US[$x]-$DS[$x])/$Length[$x]);
        $pipe->setflowcurve("");

        // Add geometric parameters
        if ($Type[$x] == "Rectangular"){
            $pipe->setD((2*$Height[$x]*$Width[$x])/($Height[$x]+$Width[$x]));
            $pipe->seth($Height[$x]);
            $pipe->setw($Width[$x]);
            $pipe->setA($Height[$x]*$Width[$x]);
            $pipe->setP((2*$Width[$x]) + (2*$Height[$x])); 
        } else if ($Type[$x] == "Circular"){
            $pipe->setD($Diameter[$x]);
            $pipe->seth($Diameter[$x]);
            $pipe->setw($Diameter[$x]);
            $pipe->setA((pi()*($Diameter[$x]**2))/4);
            $pipe->setP(pi()*$Diameter[$x]);
        }

        // Add pipe to pipe array
        $pipes[] = $pipe;
	}
	// Add flow rate dependant parameters for each pipe section
	flowparameters($pipes,$Q);

	// Create false US section and calculate intial headwater properties
    $inlet_fake = createfakeinlet($pipes[0],$inlet,$Q);

    // Create false DS section and calculate tailwater properties
    $outlet_fake = createfakeoutlet(end($pipes),$outlet,$Q,totallength($pipes));
	
    // Create array including inlet & outlet and rearrange outlet to inlet
    array_push($pipes,$outlet_fake);
    array_unshift($pipes , $inlet_fake);
    $pipes = array_reverse($pipes);
    
    // Set initial water levels for GVF computations and run first attempt at profile
    initialwaterlevels($pipes);
    
    for ($x = 1; $x < (count($pipes)-1); $x++){
        flowprofile($pipes[$x],$pipes[$x-1],$Q,"False");
    }
    
    updateheadwater($pipes[count($pipes)-2],end($pipes),$inlet,$Q);
    
    // Check for discrepancies in flow profile and update water levels and re-run if necessary
    $lim = 0;
    while (continuitycheck($pipes) == "False" and $lim < 10){
        updatewaterlevels($pipes,$Q);
        for ($x = 1; $x < (count($pipes)-1); $x++){
            flowprofile($pipes[$x],$pipes[$x-1],$Q,"False");
        }
        updateheadwater($pipes[count($pipes)-2],end($pipes),$inlet,$Q);
        $lim = $lim + 1;
    }
    
    // Check for discrepancies in flow profile due to RVF and update water levels and re-run if necessary
    $lim = 0;
    $init = 1;
    while (continuitycheckHJ($pipes) == "False" and $lim < 10 or $init == 1){
        for ($x = 1; $x < (count($pipes)-1); $x++){
            updatewaterlevelsHJ($pipes,$Q);
            flowprofile($pipes[$x],$pipes[$x-1],$Q,"True");
        }
        $headwater = updateheadwater($pipes[count($pipes)-2],end($pipes),$inlet,$Q);
        $lim = $lim + 1;
        $init = 0;
    }
	
	// Check for jump in tailwater and adjust
	tailwaterprofile($pipes);
   
    if (isset($_POST["report"])){
    	$arr["HW"] = $headwater;
		 
		// Add direct step method details
		directstepmethoddetails($pipes,$Q);
		
		// Add points for rapidly varied flow
		rapidlyvariedflowpoints($pipes,$Q);
		
	}
	
    // Add velocity, froude no, bottom of pipe, top of pipe, water surface
    addplotdetails($pipes,$outlet,$Q);

    if (isset($_POST["report"])){

    	$arr["pipe"] = joinprofilereport($pipes);

	} else {
		// Join pipes into single profile
	    $arr[(string)$Q] = joinprofile($pipes);

	    // Record Head Level for Head Discharge curve
	    $head[] = $headwater;
        $discharge[] = $Q;
	    
	    // Add pipe properties for summary table
	    $summarytable[(string)$Q] = summarytable($pipes); 
	}
    
}

if (isset($_POST["report"])){
    $class = [];
    $pipes = array_reverse($pipes);
    for ($x = 0; $x < count($pipes); $x++) {
        $class[] = (array) $pipes[$x];
    }
	$arr["class"] = $class;
    $arr["inlet"] = (array) $inlet;
    echo json_encode($arr);
	
} else if (isset($_POST["softvar"])){
	$out = [];
	$inlet = array();
	$outlet = array();
	$flow = array();
	for ($x = 0; $x < count($discharge); $x++) {
		$inlet[] = $head[$x][0] * 3.28084;
		$outlet[] = $head[$x][1] * 3.28084;
		$flow[] = $discharge[$x] * 35.314666212661;
	}   
	$out["hd"] = array($flow,$inlet,$outlet);
	echo json_encode($out);
} else {
	$arr["hd"] = array($head,$discharge);
	$arr["st"] = $summarytable;

    if (isset($_SESSION['user'])){
        // write to output file
        $ID = $_POST["sessionStorageID"];
        $fp = fopen('../json/'.$ID.'.json', 'w');
        fwrite($fp, json_encode($arr));
        fclose($fp);
        echo json_encode(0);
    } else {
        echo json_encode($arr);
    }
}
?>