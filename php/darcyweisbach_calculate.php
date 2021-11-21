<?php
session_start();

// Define output variable
$out = [];

// Head Loss
if ($_POST["iwantto"] == "div_h"){
	$L = $_POST["h_L"];
	$ks = $_POST["h_ks"];
	$K = $_POST["h_K"];
	$u = $_POST["h_u"];
	$AD = AD();
	$A = $AD[0];
	$D = $AD[1];
	if ($_POST["h_vd_select"] == "Q"){
		$Q = $_POST["h_vd"];
		$V = $Q / $A;
	} else if ($_POST["h_vd_select"] == "V"){
		$V = $_POST["h_vd"];
		$Q = $V * $A;
	}
	$Re = reynoldsnumber($V,$D,$u);
	$hf = darcyweisbach_head($K,$D,$L,$ks,$Re,$V);
	$h = $hf[0];
	$f = $hf[1];
	$out["id"] = "div_h";
	$out["h_h"] = round($h,5);
	$out["h_f"] = round($f,5);
	$out["h_Re"] = round($Re,5);
	if ($_POST["h_vd_select"] == "Q"){
		$out["h_vd_out"] = round($V,5);
	} else if ($_POST["h_vd_select"] == "V"){
		$out["h_vd_out"] = round($Q,5);
	}

// Velocity and Discarge
} elseif ($_POST["iwantto"] == "div_vd"){
	$L = $_POST["vd_L"];
	$ks = $_POST["vd_ks"];
	$K = $_POST["vd_K"];
	$h = $_POST["vd_h"];
	$u = $_POST["vd_u"];
	$AD = AD();
	$A = $AD[0];
	$D = $AD[1];
	$Q = darcyweisbach_flow($h,$K,$D,$A,$L,$ks,$u);
	$V = $Q/$A;
	$Re = reynoldsnumber($V,$D,$u);
	$f = darcyweisbach_head($K,$D,$L,$ks,$Re,$V)[1];
	$out["id"] = "div_vd";
	$out["vd_V"] = round($V,5);
	$out["vd_Re"] = round($Re,5);
	$out["vd_Q"] = round($Q,5);
	$out["vd_f"] = round($f,5);
	
// Length
} elseif ($_POST["iwantto"] == "div_L"){
	$h = $_POST["L_h"];
	$ks = $_POST["L_ks"];
	$K = $_POST["L_K"];
	$u = $_POST["L_u"];
	$AD = AD();
	$A = $AD[0];
	$D = $AD[1];
	if ($_POST["L_vd_select"] == "Q"){
		$Q = $_POST["L_vd"];
		$V = $Q / $A;
	} else if ($_POST["L_vd_select"] == "V"){
		$V = $_POST["L_vd"];
		$Q = $V * $A;
	}
	$Re = reynoldsnumber($V,$D,$u);
	$Lf = darcyweisbach_length($K,$D,$A,$h,$ks,$Q,$u);
	$L = $Lf[0];
	$f = $Lf[1];
	
	$out["id"] = "div_L";
	$out["L_L"] = round($L,5);
	$out["L_f"] = round($f,5);
	$out["L_Re"] = round($Re,5);
	if ($_POST["L_vd_select"] == "Q"){
		$out["L_vd_out"] = round($V,5);
	} else if ($_POST["L_vd_select"] == "V"){
		$out["L_vd_out"] = round($Q,5);
	}
	
// Hydraulic Diameter
} elseif ($_POST["iwantto"] == "div_D"){
	$h = $_POST["D_h"];
	$ks = $_POST["D_ks"];
	$K = $_POST["D_K"];
	$u = $_POST["D_u"];
	$L = $_POST["D_L"];	
	$Df = darcyweisbach_diameter($K,$L,$h,$ks,$u);
	$D = $Df[0];
	$f = $Df[1];
	if ($_POST["D_vd_select"] == "Q"){
		$A = (pi()*($D**2))/4;
		$Q = $_POST["D_vd"];
		$V = $Q/$A;
	} else if ($_POST["D_vd_select"] == "V"){
		$V = $_POST["D_vd"];
		if ($_POST["channeltype"] == "type_cir"){
			$A = (pi()*($D**2))/4;
			$Q = $V * $A;
		} 
	}
	$out["id"] = "div_D";
	if ($K*($V**2/19.62) > $h){
		$out["D_D"] = "N/A";
		$out["D_f"] = "N/A";
		$out["D_Re"] = "N/A";
		$out["D_vd_out"] = "N/A";
	} else {
		$Re = reynoldsnumber($V,$D,$u);
		$out["D_D"] = round($D,5);
		$out["D_f"] = round($f,5);
		$out["D_Re"] = round($Re,5);
		if ($_POST["D_vd_select"] == "Q"){
			$out["D_vd_out"] = round($V,5);
		} else if ($_POST["D_vd_select"] == "V"){
			if ($_POST["channeltype"] == "type_rec"){
				$out["D_vd_out"] = "N/A";
			} elseif ($_POST["channeltype"] == "type_cir"){
				$out["D_vd_out"] = round($Q,5);
			} 
		}
	}
	
// Roughness
} elseif ($_POST["iwantto"] == "div_ks"){
	$h = $_POST["ks_h"];
	$K = $_POST["ks_K"];
	$L = $_POST["ks_L"];
	$u = $_POST["ks_u"];
	$AD = AD();
	$A = $AD[0];
	$D = $AD[1];
	if ($_POST["ks_vd_select"] == "Q"){
		$Q = $_POST["ks_vd"];
		$V = $Q / $A;
	} else if ($_POST["ks_vd_select"] == "V"){
		$V = $_POST["ks_vd"];
		$Q = $V * $A;
	}
	$Re = reynoldsnumber($V,$D,$u);
	$ksf = dacryweisbach_roughness($L,$D,$A,$h,$K,$Q,$u);
	$ks = $ksf[0];
	$f = $ksf[1];
	$out["id"] = "div_ks";
	$out["ks_ks"] = $ks;
	$out["ks_f"] = round($f,5);
	$out["ks_Re"] = round($Re,5);
	if ($_POST["ks_vd_select"] == "Q"){
		$out["ks_vd_out"] = round($V,5);
	} else if ($_POST["ks_vd_select"] == "V"){
		$out["ks_vd_out"] = round($Q,5);
	}
	
// Minor loss
} elseif ($_POST["iwantto"] == "div_K"){
	$h = $_POST["K_h"];
	$ks = $_POST["K_ks"];
	$L = $_POST["K_L"];
	$u = $_POST["K_u"];
	$AD = AD();
	$A = $AD[0];
	$D = $AD[1];
	if ($_POST["K_vd_select"] == "Q"){
		$Q = $_POST["K_vd"];
		$V = $Q / $A;
	} else if ($_POST["K_vd_select"] == "V"){
		$V = $_POST["K_vd"];
		$Q = $V * $A;
	}
	$Re = reynoldsnumber($V,$D,$u);
	$Kf = darcyweisbach_minorloss($L,$D,$A,$h,$ks,$Q,$u);
	$K = $Kf[0];
	$f = $Kf[1];
	$out["id"] = "div_K";
	$out["K_K"] = round($K,5);
	$out["K_f"] = round($f,5);
	$out["K_Re"] = round($Re,5);
	if ($_POST["K_vd_select"] == "Q"){
		$out["K_vd_out"] = round($V,5);
	} else if ($_POST["K_vd_select"] == "V"){
		$out["K_vd_out"] = round($Q,5);
	}
}

// Verify Calculation
$v1_r = (($f*$L*($V**2))/($D*2*9.81)) + (($K*($V**2))/(2*9.81));
$v1_l = $h;
$v2_r = -2*log((2.51/($Re*($f**0.5))) + ($ks/(3.7*$D)),10);
$v2_l = 1/($f**0.5);
if (abs($v1_r - $v1_l) > 0.01 or abs($v2_r - $v2_l) > 0.01 or $K < 0 or $ks < 0){
	foreach($out as $i => $item) {
		if ($i != "id"){
			$out[$i] = "Err";
		}
	}
}

// Add outputs to POST
foreach($out as $key=>$value){
	$_POST[$key] = $value;
}

// Save POST variables to database
include("savevariables.php");

// Send back answers
echo json_encode($out);

function AD(){
	if ($_POST["channeltype"] == "type_rec"){
		$b = $_POST["rec_b"];
		$hi = $_POST["rec_hi"];
		$A = $b * $hi;
		$D = (2*$hi*$b)/($hi+$b);
		return array($A,$D);
	} elseif ($_POST["channeltype"] == "type_cir"){
		$D = $_POST["cir_D"];
		$A = (pi()*($D**2))/4;
		return array($A,$D);
	}
}

function fixedpoint($function,$args){
    $rtol=1e-7;
    $maxiter=50; 
    $e = 1;
    $it = 0;
    $x0 = $args[0];
    while ($e > $rtol AND $it < $maxiter){
        $x = call_user_func_array($function,$args);
        $e = abs($x - $x0)/abs($x);
        $args[0] = $x;
        $it = $it + 1;
    }
    return $x;
}

function reynoldsnumber($V,$D,$u){
    return ($V*$D)/$u;
}

function swameejain($D,$Re,$ks){
    return 0.25 / (log((($ks/1000)/(3.7*$D))+(5.74/($Re**0.9)),10)**2);
}

function colebrookwhite($f,$Re,$ks,$D){
    return 1/(-2*log((2.51/($Re*($f**0.5))) + ($ks/(3.7*$D)),10))**2; 
}

function darcyweisbach_head($K,$D,$L,$ks,$Re,$V) {
	if ($Re < 4000){
		$f = 64/$Re; 
	} else {
		$sj = swameejain($D,$Re,$ks);
		$args = array($sj,$Re,$ks,$D);
		$f = fixedpoint('colebrookwhite',$args);
	}
    return array((($f*($L*($V)**2))/($D*2*9.81))+((($K*($V)**2))/(2*9.81)),$f);
}

function darcyweisbach_flow($h,$K,$D,$A,$L,$ks,$u){
	$ht = 0;
	$Q = 0;
	$dQ = 10;
	for($i = 1; $i < 50; ++$i) {
		$dQ = $dQ/4;
		$loop = 1;
		while ($ht < $h and $loop < 200){
			$Q = $Q + $dQ;
			$V = $Q/$A;
			$Re = reynoldsnumber($V,$D,$u);
			$ht = darcyweisbach_head($K,$D,$L,$ks,$Re,$V)[0];
			$loop = $loop + 1;
		}
		$ht = 0;
		$Q = $Q - $dQ;
	}
	return $Q;
}

function darcyweisbach_length($K,$D,$A,$h,$ks,$Q,$u) {
	$Re = reynoldsnumber($Q/$A,$D,$u);
	if ($Re < 4000){
		$f = 64/$Re; 
	} else {
		$sj = swameejain($D,$Re,$ks);
		$args = array($sj,$Re,$ks,$D);
		$f = fixedpoint('colebrookwhite',$args);
	}
	$L = (($h - ((($K*($Q/$A)**2))/(2*9.81)))*2*9.81*$D)/($f*(($Q/$A)**2));
	return array($L,$f);	
}

function darcyweisbach_diameter($K,$L,$h,$ks,$u) {
	$ht = 2*$h;
	$D = 0;
	$dD = 1000;
	for($i = 1; $i < 50; ++$i) {
		$dD = $dD/4;
		$loop = 1;
		while ($ht > $h and $loop < 1000){
			$D = $D + $dD;
			
			if ($_POST["D_vd_select"] == "Q"){
				$A = (pi()*($D**2))/4;
				$Q = $_POST["D_vd"];
				$V = $Q/$A;
			} else if ($_POST["D_vd_select"] == "V"){
				$V = $_POST["D_vd"];
			}
			$Re = reynoldsnumber($V,$D,$u);
			$hf = darcyweisbach_head($K,$D,$L,$ks,$Re,$V);
			$ht = $hf[0];
			$f = $hf[1];
			$loop = $loop + 1;
		}
		$ht = 2*$h;
		$D = $D - $dD;
	}
	return array($D,$f);
}

function darcyweisbach_minorloss($L,$D,$A,$h,$ks,$Q,$u) {
	$Re = reynoldsnumber($Q/$A,$D,$u);
	if ($Re < 4000){
		$f = 64/$Re; 
	} else {
		$sj = swameejain($D,$Re,$ks);
		$args = array($sj,$Re,$ks,$D);
		$f = fixedpoint('colebrookwhite',$args);
	}
	$K = ((2*9.81*$h)-(($f*$L*(($Q/$A)**2))/($D)))/(($Q/$A)**2);
	return array($K,$f);	
}

function dacryweisbach_roughness($L,$D,$A,$h,$K,$Q,$u){
	$V = $Q/$A;
	$Re = reynoldsnumber($V,$D,$u);
	$f = (($h*$D*2*9.81)-($K*($V**2)))/($L*($V**2));
	$ks = 3.7*$D*((10**(-1/(2*($f**0.5))))-(2.51/($Re*($f**0.5))));
	return array($ks,$f);
}
?>