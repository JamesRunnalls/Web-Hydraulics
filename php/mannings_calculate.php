<?php
session_start();

// Define output variable
$out = [];

if ($_POST["iwantto"] != "div_y"){
	// Velocity & Discharge
	if ($_POST["iwantto"] == "div_vd"){
		$y = $_POST["vd_y"];
		$APT = logic_APT($y);
		$A = $APT[0];
		$P = $APT[1];
		$s = $_POST["vd_s"];
		$n = $_POST["vd_n"];
		$V = (1/$n)*(pow(($A/$P),(2/3)))*pow($s,0.5);
		$Q = $V * $A;
		$out["id"] = "div_vd";
		$out["vd_V"] = round($V,5);
		$out["vd_Q"] = round($Q,5);
	// Channel Slope
	} elseif ($_POST["iwantto"] == "div_s"){
		$y = $_POST["s_y"];
		$APT = logic_APT($y);
		$A = $APT[0];
		$P = $APT[1];
		$n = $_POST["s_n"];
		$Q = $_POST["s_Q"];
		$V = $Q/$A;
		$s = pow((($V*$n)/pow(($A/$P),(2/3))),2);
		$out["id"] = "div_s";
		$out["s_s"] = round($s,5);
	// Mannings n
	} elseif ($_POST["iwantto"] == "div_n"){
		$y = $_POST["n_y"];
		$APT = logic_APT($y);
		$A = $APT[0];
		$P = $APT[1];
		$s = $_POST["n_s"];
		$Q = $_POST["n_Q"];
		$V = $Q/$A;
		$n = (1/$V)*(pow(($A/$P),(2/3)))*pow($s,0.5);
		$out["id"] = "div_n";
		$out["n_n"] = round($n,5);
	}
} elseif ($_POST["iwantto"] == "div_y"){
	$s = $_POST["y_s"];
	$n = $_POST["y_n"];
	$Q = $_POST["y_Q"];
	$y = depthmannings($s,$n,$Q);
	$APT = logic_APT($y);
	$A = $APT[0];
	$V = $Q/$A;
	$out["id"] = "div_y";
	$out["y_y"] = round($y,5);
	$out["y_V"] = round($V,5);
}

// Verify Calculation
$v1_r = (1/$n)*$A*(($A/$P)**(2/3))*($s**0.5);
$v1_l = $Q;
if (abs($v1_r - $v1_l) > 0.01 or $s <= 0 or $n < 0){
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


function logic_APT($y){
	if ($_POST["channeltype"] == "type_rec"){
		$b = $_POST["rec_b"];
		return rectangular_APT($b,$y);
	} elseif ($_POST["channeltype"] == "type_tra"){
		$b = $_POST["tra_b"];
		$l = $_POST["tra_l"];
		$r = $_POST["tra_r"];
		return trapeziodal_APT($b,$l,$r,$y);
	} elseif ($_POST["channeltype"] == "type_tri"){
		$a = $_POST["tri_a"];
		return triangular_APT($a,$y);
	} elseif ($_POST["channeltype"] == "type_cir"){
		$D = $_POST["cir_D"];
		return circular_APT($D,$y);
	} elseif ($_POST["channeltype"] == "type_cus"){
		return array($_POST["cus_A"],$_POST["cus_P"],null);
	}
}
		
function circular_APT($D,$y){
	if ($y == $D/2){
		$A = (pi()*($D**2)) / 8;
		$P = pi()*($D/2);
		$T = $D;
		return array($A,$P,$T);
	} else if ($y < 0){
		return array(0,0,0);
	} else if ($y < ($D/2)){
		$r = $D/2;
		$theta = 2*acos(($r-$y)/$r);
		$A = (($r**2)*($theta-sin($theta)))/2;
		$P = $r * $theta;
		$T = $D*sin($theta/2);
		return array($A,$P,$T);
	} else if ($y > ($D/2) and $y <= $D){
		$h = $D - $y;
		$r = $D / 2;
		$theta = 2*acos(($r-$h)/$r);
		$A = pi()*($r**2) - ((($r**2)*($theta-sin($theta)))/2);
		$P = (pi()*$D) - ($r*$theta);
		$T = $D*sin($theta/2);
		return array($A,$P,$T);
	} else {
		$A = pi()*(($D/2)**2);
		$P = pi()*$D;
		$T = 0;
		return array($A,$P,$T);
	}    
}
	
function rectangular_APT($b,$y){
	$A = $b * $y;
	$P = $b + (2*$y);
	$T = $b;
	return array($A,$P,$T);
}

function triangular_APT($a,$y){
	$A = $y * $y * tan(deg2rad($a/2));
	$P = (2*$y)/cos(deg2rad($a/2));
	$T = 2 * $y * tan(deg2rad($a/2));
	return array($A,$P,$T);
}	
	
function trapeziodal_APT($b,$l,$r,$y){
	$T = $b + ($y * ($l + $r));
	$P = $b + ($y * (sqrt(1+($l**2))+sqrt(1+($r**2))));
	$A = ($y/2)*($b + $T);
	return array($A,$P,$T);
}	

function mannings($s,$n,$y){
	$APT = logic_APT($y);
	$A = $APT[0];
	$P = $APT[1];
	return (1/$n)*$A*(($A/$P)**(2/3))*($s**0.5);
}

function depthmannings($s,$n,$Q){   
    $Qt = 0;
    $y = 0;
    $dy = 0.5;
    for($i = 1; $i < 50; ++$i) {
        $dy = $dy/4;
        $loop = 1;
        while ($Qt < $Q and $loop < 50){
            $y = $y + $dy;
            $Qt = mannings($s,$n,$y);
            if ($Qt == "False"){
                $Qt = 2*$Q;
            }
            $loop = $loop + 1;
        }
        $Qt = 0;
        $y = $y - $dy;
    }
    return $y;
}
?>