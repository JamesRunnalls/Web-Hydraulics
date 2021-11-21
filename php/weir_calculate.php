<?php

session_start();

// Define output variable
$out = [];

//  Discharge
if ($_POST["iwantto"] == "div_vd"){
	if ($_POST["channeltype"] == "type_rec"){
		$B = $_POST["rec_B"];
		$b = $_POST["rec_b"];
		$p1 = $_POST["rec_p1"];
		$p2 = $_POST["rec_p2"];
		$h1 = $_POST["vd_h1"];
		if ($_POST["vd_C_in"] != null and $_POST["vd_C_in"] < 0.8 and $_POST["vd_C_in"] > 0.4){
			$C = $_POST["vd_C_in"];
		} else {
			$C = 0.589 - (0.008*($h1/$p1)) + ((($b/$B)**2)*(0.013+(0.083*($h1/$p1))));
		}
		// Drowned flow
		if ($_POST["rec_h2"] != null and $_POST["rec_h2"] != 0){
			$h2 = $_POST["rec_h2"];
			$fr = (1-(1.5*($h2/$h1)))**0.385;
		// Free discharge
		} else {
			$fr = 1;
		}
		$Q = $fr*$C*(2/3)*((2*9.81)**0.5)*$b*($h1**(3/2));
	} elseif ($_POST["channeltype"] == "type_tri"){
		$a = $_POST["tri_a"];
		$h1 = $_POST["vd_h1"];
		if ($_POST["vd_C_in"] != null and $_POST["vd_C_in"] < 0.8 and $_POST["vd_C_in"] > 0.4){
			$C = $_POST["vd_C_in"];
		} else {
			$C = 0.607165052-(0.000874466963*$a)+(0.0000061039334*($a**2));
		}
		$k = 0.0044166327 - (0.0001034965*$a) + (0.000001005288321144*($a**2)) - (0.00000000323744667216*($a**3));
		// Drowned flow
		if ($_POST["tri_h2"] != null and $_POST["tri_h2"] != 0){
			$h2 = $_POST["tri_h2"];
			$fr = (1-(1.5*($h2/$h1)))**0.385;
		// Free discharge
		} else {
			$fr = 1;
		}
		$Q = $fr*$C*(8/15)*((2*9.81)**0.5)*tan(deg2rad($a/2))*(($h1+$k)**(5/2));
	}
	$out["id"] = "div_vd";
	$out["vd_C"] = round($C,5);
	$out["vd_Q"] = round($Q,5);
// Head
} elseif ($_POST["iwantto"] == "div_h1"){
	if ($_POST["channeltype"] == "type_rec"){
		$B = $_POST["rec_B"];
		$b = $_POST["rec_b"];
		$p1 = $_POST["rec_p1"];
		$p2 = $_POST["rec_p2"];
		$Q = $_POST["h1_Q"];

		// Drowned flow
		if ($_POST["rec_h2"] != null and $_POST["rec_h2"] != 0){
			$h2 = $_POST["rec_h2"];
			$h1 = rec_drowned_h1($b,$B,$p1,$p2,$h2,$Q);
		// Free discharge
		} else {
			$h1 = rec_free_h1($b,$B,$p1,$p2,$Q);	
		}
		if ($_POST["h1_C_in"] != null and $_POST["h1_C_in"] < 0.8 and $_POST["h1_C_in"] > 0.4){
			$C = $_POST["h1_C_in"];
		} else {
			$C = 0.589 - (0.008*($h1/$p1)) + ((($b/$B)**2)*(0.013+(0.083*($h1/$p1))));
		}
	} elseif ($_POST["channeltype"] == "type_tri"){
		$a = $_POST["tri_a"];
		$Q = $_POST["h1_Q"];

		if ($_POST["h1_C_in"] != null and $_POST["h1_C_in"] < 0.8 and $_POST["h1_C_in"] > 0.4){
			$C = $_POST["h1_C_in"];
		} else {
			$C = 0.607165052-(0.000874466963*$a)+(0.0000061039334*($a**2));
		}

		$k = 0.0044166327 - (0.0001034965*$a) + (0.000001005288321144*($a**2)) - (0.00000000323744667216*($a**3));


		// Drowned flow
		if ($_POST["tri_h2"] != null and $_POST["tri_h2"] != 0){
			$h2 = $_POST["tri_h2"];
			$h1 = tri_drowned_h1($a,$h2,$C,$k,$Q);
		// Free discharge
		} else {
			$h1 = (($Q/($C*(8/15)*((2*9.81)**0.5)*tan(deg2rad($a/2))))**(2/5))-$k;
		}
	}
	$out["id"] = "div_h1";
	
	if ($h1 <= 0){
		$out["h1_h1"] = "Err";
		$out["h1_C"] = "Err";
	} else {
		$out["h1_h1"] = round($h1,5);
		$out["h1_C"] = round($C,5);
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

function rec_drowned_h1($b,$B,$p1,$p2,$h2,$Q){
	$Qt = 0;
    $y = 0;
    $dy = 0.5;
    for($i = 1; $i < 50; ++$i) {
        $dy = $dy/4;
        $loop = 1;
        while ($Qt < $Q and $loop < 50){
            $y = $y + $dy;
            $Qt = rec_drowned($b,$B,$p1,$p2,$h2,$Q,$y);
            if ($Qt == "False"){
                $Qt = 2*$Q;
            }
            $loop = $loop + 1;
        }
        $Qt = 0;
        $y = $y - $dy;
    }
	
	// Verify
	if (abs(rec_drowned($b,$B,$p1,$p2,$h2,$Q,$y) - $Q) > 0.01){
		$y = 0;
	}
		
    return $y;
}

function rec_free_h1($b,$B,$p1,$p2,$Q){
	$Qt = 0;
    $y = 0;
    $dy = 0.5;
    for($i = 1; $i < 50; ++$i) {
        $dy = $dy/4;
        $loop = 1;
        while ($Qt < $Q and $loop < 50){
            $y = $y + $dy;
            $Qt = rec_free($b,$B,$p1,$p2,$Q,$y);
            if ($Qt == "False"){
                $Qt = 2*$Q;
            }
            $loop = $loop + 1;
        }
        $Qt = 0;
        $y = $y - $dy;
    }
	
	if (abs(rec_free($b,$B,$p1,$p2,$Q,$y) - $Q) > 0.01){
		$y = 0;
	}
	
    return $y;
}

function tri_drowned_h1($a,$h2,$C,$k,$Q){
	$Qt = 0;
    $y = 0;
    $dy = 0.5;
    for($i = 1; $i < 50; ++$i) {
        $dy = $dy/4;
        $loop = 1;
        while ($Qt < $Q and $loop < 50){
            $y = $y + $dy;
            $Qt = tri_drowned($a,$y,$h2,$C,$k);
            if ($Qt == "False"){
                $Qt = 2*$Q;
            }
            $loop = $loop + 1;
        }
        $Qt = 0;
        $y = $y - $dy;
    }
	
	if (abs(tri_drowned($a,$y,$h2,$C,$k) - $Q) > 0.01){
		$y = 0;
	}
	
    return $y;
}

function tri_drowned($a,$h1,$h2,$C,$k){
	if ((1-(1.5*($h2/$h1))) < 0){
		$fr = 0.5;
	} else {
		$fr = (1-(1.5*($h2/$h1)))**0.385;
	}
	return $fr*$C*(8/15)*((2*9.81)**0.5)*tan(deg2rad($a/2))*(($h1+$k)**(5/2));	
}

function rec_drowned($b,$B,$p1,$p2,$h2,$Q,$h1){
	if ($_POST["h1_C_in"] != null and $_POST["h1_C_in"] < 0.8 and $_POST["h1_C_in"] > 0.4){
			$C = $_POST["h1_C_in"];
	} else {
		$C = 0.589 - (0.008*($h1/$p1)) + ((($b/$B)**2)*(0.013+(0.083*($h1/$p1))));
	}
	
	if ((1-(1.5*($h2/$h1))) < 0){
		$fr = 0.5;
	} else {
		$fr = (1-(1.5*($h2/$h1)))**0.385;
	}
	return $fr*$C*(2/3)*((2*9.81)**0.5)*$b*($h1**(3/2));
}

function rec_free($b,$B,$p1,$p2,$Q,$h1){
	if ($_POST["h1_C_in"] != null and $_POST["h1_C_in"] < 0.8 and $_POST["h1_C_in"] > 0.4){
			$C = $_POST["h1_C_in"];
	} else {
		$C = 0.589 - (0.008*($h1/$p1)) + ((($b/$B)**2)*(0.013+(0.083*($h1/$p1))));
	}
	return $C*(2/3)*((2*9.81)**0.5)*$b*($h1**(3/2));
}
?>