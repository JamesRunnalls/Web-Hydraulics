<?php
session_start();

// Define output variable
$out = [];
	
// Velocity & Discharge
if ($_POST["iwantto"] == "div_vd"){
	$H2 = $_POST["vd_H2"];
	$C = $_POST["vd_C"];
	$h = $_POST["vd_h"];
	$D = getdiameter();
	$H1 = $H2 - $D;
	// Free discharge
	if ($h >= $H2){
		$h = $H2 - ($D/2);
		if ($_POST["channeltype"] == "type_rec"){
			$Q = (2/3)*$C*$_POST["rec_b"]*((2*9.81)**0.5)*(($H2**1.5)-($H1**1.5));
		} elseif ($_POST["channeltype"] == "type_cir"){
			$Q = (pi()/4)*$C*($D**2)*((2*9.81*$h)**0.5);
		} 
	// Fully drowned
	} elseif ($h <= $H1){
		if ($_POST["channeltype"] == "type_rec"){
			$Q = $C*$_POST["rec_b"]*($H2-$H1)*((2*9.81*$h)**0.5);
		} elseif ($_POST["channeltype"] == "type_cir"){
			$Q = (pi()/4)*$C*($D**2)*((2*9.81*$h)**0.5);
		} 
	// Partially drowned
	} else {
		if ($_POST["channeltype"] == "type_rec"){
			$Q = ((2/3)*$C*$_POST["rec_b"]*((2*9.81)**0.5)*(($h**1.5)-($H1**1.5))) + ($C*$_POST["rec_b"]*($H2-$h)*((2*9.81*$h)**0.5));
		} elseif ($_POST["channeltype"] == "type_cir"){
			$h = min($h,$H2 - ($D/2));
			$Q = (pi()/4)*$C*($D**2)*((2*9.81*$h)**0.5);
		} 
	}
	// Area
	if ($_POST["channeltype"] == "type_rec"){
		$A = $D * $_POST["rec_b"];
	} elseif ($_POST["channeltype"] == "type_cir"){
		$A = (pi()*($D**2)) / 4;
	} 
	$V = $Q/$A;
	
	if ($D*5 > $H2 and $_POST["channeltype"] == "type_cir") {
		$V = "N/A";
		$Q = "N/A";
	} else {
		$V = round($V,5);
		$Q = round($Q,5);
	}
	$out["id"] = "div_vd";
	$out["vd_V"] = $V;
	$out["vd_Q"] = $Q;
// Coefficient of discharge
} elseif ($_POST["iwantto"] == "div_C"){
	$H2 = $_POST["C_H2"];
	$Q = $_POST["C_Q"];
	$h = $_POST["C_h"];
	$D = getdiameter();
	$H1 = $H2 - $D;
	// Free discharge
	if ($h >= $H2){
		$h = $H2 - ($D/2);
		if ($_POST["channeltype"] == "type_rec"){
			$C = $Q/((2/3)*$_POST["rec_b"]*((2*9.81)**0.5)*(($H2**1.5)-($H1**1.5)));
		} elseif ($_POST["channeltype"] == "type_cir"){
			$C = $Q/((pi()/4)*($D**2)*((2*9.81*$h)**0.5));
		} 
	// Fully drowned
	} elseif ($h <= $H1){
		if ($_POST["channeltype"] == "type_rec"){
			$C = $Q/($_POST["rec_b"]*($H2-$H1)*((2*9.81*$h)**0.5));
		} elseif ($_POST["channeltype"] == "type_cir"){
			$C = $Q/((pi()/4)*($D**2)*((2*9.81*$h)**0.5));
		} 
	// Partially drowned
	} else {
		if ($_POST["channeltype"] == "type_rec"){
			$Q = $Q/(((2/3)*$_POST["rec_b"]*((2*9.81)**0.5)*(($h**1.5)-($H1**1.5))) + ($_POST["rec_b"]*($H2-$h)*((2*9.81*$h)**0.5)));
		} elseif ($_POST["channeltype"] == "type_cir"){
			$h = min($h,$H2 - ($D/2));
			$C = $Q/((pi()/4)*($D**2)*((2*9.81*$h)**0.5));
		} 
	}
	if ($D*5 > $H2 and $_POST["channeltype"] == "type_cir") {
		$C = "N/A";
	} else {
		$C = round($C,2);
	}
	$out["id"] = "div_C";
	$out["C_C"] = $C;
// Cross-sectional area
} elseif ($_POST["iwantto"] == "div_A"){
	$H2 = $_POST["A_H2"];
	$Q = $_POST["A_Q"];
	$h = $_POST["A_h"];
	$C = $_POST["A_C"];
	$D = ($Q/(pi()*0.25*$C*((2*9.81*$h)**0.5)))**0.5;
	$A = (pi()*($D**2))/4;
	if ($D*5 > $H2) {
		$D = "N/A";
		$A = "N/A";
	} else {
		$D = round($D,5);
		$A = round($A,5);
	}
	$out["id"] = "div_A";
	$out["A_A"] = $A;
	$out["A_D"] = $D;
// Time to empty
} elseif ($_POST["iwantto"] == "div_t"){
	$out = [];
	$At = $_POST["t_At"];
	$C = $_POST["t_C"];
	$h1 = $_POST["t_h1"];
	$h2 = $_POST["t_h2"];
	if ($_POST["channeltype"] == "type_rec"){
		$A = $_POST["rec_b"] * $_POST["rec_h"];
	} elseif ($_POST["channeltype"] == "type_cir"){
		$A = (pi()/4)*($_POST["cir_D"]**2);
	} 
	$t = (2*$At*(($h1**0.5)-($h2**0.5)))/($C*$A*((2*9.81)**0.5));	
	$out["id"] = "div_t";
	$out["t_t"] = round($t,5);
} 

// Add outputs to POST
foreach($out as $key=>$value){
	$_POST[$key] = $value;
}

// Save POST variables to database
include("savevariables.php");

// Send back answers
echo json_encode($out);
		
function getdiameter(){
	if ($_POST["channeltype"] == "type_rec"){
		return $_POST["rec_h"];
	} elseif ($_POST["channeltype"] == "type_cir"){
		return $_POST["cir_D"];
	} 
}

function getarea(){
	if ($_POST["channeltype"] == "type_rec"){
		return $_POST["rec_h"]*$_POST["rec_b"];
	} elseif ($_POST["channeltype"] == "type_cir"){
		return (pi()/4)*($_POST["cir_D"]**2);
	} 
}





























	
?>