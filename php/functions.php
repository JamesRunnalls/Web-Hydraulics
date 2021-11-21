<?php

// Processing data input

function multipleinputs($name){
    $x = array();
    for($i = 0; $i < 10000; ++$i) {
        $fullname = $name ."&". (string)$i;
        if (isset($_POST[$fullname])) {
            // the variable is defined
            $x[] = $_POST[$fullname];
        }
    }
    return $x;
}

function multipleinputslevel2($name){
    $out = array();
    for($i = 0; $i < 500; ++$i) {
        $t = array();
        for($x = 0; $x < 500; ++$x) {
            $fullname = $name . "&" . (string)$i . "&" . (string)$x;
            if (isset($_POST[$fullname])) {
                // the variable is defined
                $t[] = $_POST[$fullname];
            }   
        }
        if (count($t) > 0){
            $out[] = $t;
        }
    }
    return $out;
}

function varmultipleinputs($var,$name){
    $x = array();
    for($i = 0; $i < 10000; ++$i) {
        $fullname = $name ."&". (string)$i;
        if (isset($var[$fullname])) {
            // the variable is defined
            $x[] = $var[$fullname];
        }
    }
    return $x;
}

function varmultipleinputslevel2($var,$name){
    $out = array();
    for($i = 0; $i < 500; ++$i) {
        $t = array();
        for($x = 0; $x < 500; ++$x) {
            $fullname = $name . "&" . (string)$i . "&" . (string)$x;
            if (isset($var[$fullname])) {
                // the variable is defined
                $t[] = $var[$fullname];
            }   
        }
        if (count($t) > 0){
            $out[] = $t;
        }
    }
    return $out;
}

// Iterators

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

function depthmannings($pipe,$Q){   
    $Qt = 0;
    $y = 0;
    $dy = $pipe->geth()/2;
    for($i = 1; $i < 50; ++$i) {
        $dy = $dy/4;
        $loop = 1;
        while ($Qt < $Q and $loop < 50){
            $y = $y + $dy;
            $Qt = mannings($pipe,$y);
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

function iteratormannings($z,$pipe){
    $y = 2*$z;
    $a = 0;
    $x = 0.01;
    $it = 0;
    $maxiter=50; 
    for($i = 1; $i < 50; ++$i) {
        $x = $x/2;
        while ($y > $z AND $it < $maxiter){
            $a = $a + $x;
            $y = fullpipemanning($pipe,$a);
            if ($a > $pipe->geth()){
                $y = 2*$z;
            }
            $it = $it + 1;
        }
        $y = 2*$z;
        $a = $a - $x;
    }
    return $a;
}

// Physical Equations

function fullpipemanning($pipe,$var) {
    if (isset($var)){
        $n = $var;
    } else{
        $n = $pipe->getn();
    }
    $A = $pipe->getA();
    $P = $pipe->getP();
    $S = $pipe->getS();   
    return (1/$n)*$A*(($A/$P)**(2/3))*($S**0.5);  
}

function fullpipecolebrook($pipe){
    $args = array(0.01,$pipe);
    return fixedpoint('darceyweisbachfullpipe',$args);
}

function darceyweisbachfullpipe($Q,$pipe){
    $sj = swameejain($pipe,$Q);
    $args = array($sj,$Q,$pipe);
    $f = fixedpoint('colebrookwhite',$args);
    $D = $pipe->getD();
    $A = $pipe->getA();
    $Ks = $pipe->getKs();
    $de = $pipe->getde();
    $K = $pipe->getK();
    $L = $pipe->getL();
    $u = $pipe->getu();
    $Re = reynoldsnumber(($Q/$A),$D,$u); 
    return $A * (((2*9.81*$de)/(($f*($L/$D))+($K)))**0.5);
}

function reynoldsnumber($V,$D,$u){
    return ($V*$D)/$u;
}

function froudeno($pipe,$y,$Q){
    $h = $pipe->geth();
    if ($y == 0){
        return "False";
    } else if ($y <= $h){
        $pp = partialparameters($pipe,$y);
        $A = $pp[0];
        $P = $pp[1];
        $T = $pp[2];
        if ($T == 0){
            // Pipe full
            return "False";
        } else {
            return ($Q/$A)/(((9.81*$A)/$T)**0.5);
        }
    } else {
        return "False";
    }
}

function swameejain($pipe,$Q){
    $D = $pipe->getD();
    $A = $pipe->getA();
    $Ks = $pipe->getKs();
    $u = $pipe->getu();
    $Re = reynoldsnumber(($Q/$A),$D,$u);
    return 0.25 / (log((($Ks/1000)/(3.7*$D))+(5.74/($Re**0.9)),10)**2);
}

function mannings($pipe,$y){
    $h = $pipe->geth();
    if ($y == 0){
        return 0;
    } else {
        $pp = partialparameters($pipe,$y);
        $A = $pp[0];
        $P = $pp[1];
        $n = $pipe->getn();
        $S = $pipe->getS();
        return (1/$n)*$A*(($A/$P)**(2/3))*($S**0.5);
    } 
}

function colebrookwhite($f,$Q,$pipe){
    $Ks = $pipe->getKs();
    $D = $pipe->getD();
    $A = $pipe->getA();
    $u = $pipe->getu();
    $Re = reynoldsnumber(($Q/$A),$D,$u);
    return 1/(-2*log((2.51/($Re*($f**0.5))) + ($Ks/(3.7*$D)),10))**2; 
}

function darcyweisbach($pipe,$Q) {
    $K = $pipe->getK();
    $D = $pipe->getD();
    $A = $pipe->getA();
    $L = $pipe->getL();
    $sj = swameejain($pipe,$Q);
    $args = array($sj,$Q,$pipe);
    $f = fixedpoint('colebrookwhite',$args);
    return array((($f*($L*($Q/$A)**2))/($D*2*9.81))+((($K*($Q/$A)**2))/(2*9.81)),$f);
}

function criticaldepth($pipe,$Q) {
    if ($pipe->getType() == "Rectangular"){
        $w = $pipe->getw();
        $yc = ((($Q/$w)**2)/9.81)**(1/3);
        if ($yc > $pipe->geth()){
            $yc = $pipe->geth();
        }
        return $yc;
    } else if ($pipe->getType() == "Circular"){
        $k = range(0,2*pi(),((2*pi())/1000));
        $err = array();
        for ($x = 0; $x < count($k); $x++) {
            $err[] = abs(thetas($pipe,$Q,$k[$x])); 
        }
        $err[0] = 10000;
        $D = $pipe->getD();
        $theta = $k[array_search(min($err),$err)];
        $yc = ($D/2)*(1-cos($theta/2));
        return $yc;
    }
}

function thetas($pipe,$Q,$theta){
    $D = $pipe->getD();
    return (16*$Q*(((2/9.81)*sin($theta/2))**0.5)) - (($D**(5/2))*(($theta-sin($theta))**(3/2)));
}

function pipesizechangeloss($pipe,$Q){
    if ($dsD = $pipe->getdsD() == "End"){
        if ($pipe->getdst() == "None"){
            return 0;
        } else {
            return 1;
        }
    } else {
        $A = $pipe->getA();
            $D = $pipe->getD();
            $dsD = $pipe->getdsD();
            $u = $pipe->getu();
            $Re = reynoldsnumber(($Q/$A),$D,$u);
            $sj = swameejain($pipe,$Q);
            $args = array($sj,$Q,$pipe);
            $f = fixedpoint('colebrookwhite',$args);
        
        if ($pipe->getdst() == "Squared"){
            if ($D == $dsD){
                $K = 0;
                return $K;
            } else if ($D > $dsD){
                if ($Re < 2500){
                    $K = (1.2+(160/$Re))*((($D/$dsD)**4)-1);
                    return $K;
                } else {
                    $K = (0.6 + (0.48*$f))*(($D/$dsD)**2)*((($D/$dsD)**2)-1);
                    return $K;
                }
            } else if ($D < $dsD){
                if ($Re < 4000){
                    $K = 2*(1-(($D/$dsD)**4));
                    return $K;
                } else {
                    $K = (1+(0.8*$f))*((1-(($D/$dsD)**2))**2);
                    return $K;
                }
            }
        } else if ($pipe->getdst() == "Rounded"){
            if ($D == $dsD){
                $K = 0;
                return $K;
            } else if ($D > $dsD){
                $K = (0.1+(50/$Re))*((($D/$dsD)**4)-1);
                return $K;
            } else if ($D < $dsD){
                if ($Re < 4000){
                    $K = 2*(1-(($D/$dsD)**4));
                    return $K;
                } else {
                    $K = (1+(0.8*$f))*((1-(($D/$dsD)**2))**2);
                    return $K;
                }
            }
        } else if ($pipe->getdst() == "None"){
            return 0;
        } else {
            $taper = $pipe->getdst();
            if ($D == $dsD){
                $K = 0;
                return $K;
            } else if ($D > $dsD){
                if ($taper < 45){
                    $factor = 1.6*sin(deg2rad($taper)/2);
                } else {
                    $factor = sin(deg2rad($taper)/2)**0.5;
                }
                if ($Re < 2500){
                    $K = (1.2+(160/$Re))*((($D/$dsD)**4)-1)*$factor;
                    return $K;
                } else {
                    $K = (0.6 + (0.48*$f))*(($D/$dsD)**2)*((($D/$dsD)**2)-1)*$factor;
                    return $K;
                }
            } else if ($D < $dsD){
                if ($taper > 45){
                    $factor = 1;
                } else {
                    $factor = 2.6*sin(deg2rad($taper)/2);
                }
                if ($Re < 4000){
                    $K = 2*(1-(($D/$dsD)**4))*$factor;
                    return $K;
                } else {
                    $K = (1+(0.8*$f))*((1-(($D/$dsD)**2))**2)*factor;
                    return $K;
                }
            }
        }
    }
}

function specificenergy($y,$Q,$A){
    return $y + ((($Q/$A)**2)/(2*9.81));
}

function frictionslope($n,$Q,$A,$P){
    return (($n*$Q)/($A*(($A/$P)**(2/3))))**2;
}

function sequentdepth($Q,$y1,$pipe){
    if ($pipe->getType() == "Rectangular"){
        // Calc dimensionless parameters
        $y1_dash = $y1/$pipe->geth();
        // Calc froude number
        $Fr1 = $Q/((9.81*($pipe->getw()**2)*($y1**3))**0.5);
        // Calc transitional froude number
        $Frt = (((1+$y1_dash)/(2*($y1_dash**2)))**0.5);
        if ($Fr1 < $Frt){
            // Complete jump forms
            $y2_dash = ($y1_dash/2)*(((1+(8*($Fr1**2)))**0.5)-1);
            $sqfr = array($y2_dash*$pipe->geth(),$Fr1);
            return $sqfr;
        } else if ($Fr1 >= $Frt){
             // Incomplete jump forms
            $y2_dash = 0.5 + ((($Fr1**2)+0.5)*($y1_dash**2)) - (($Fr1**2)*($y1_dash**3));
            $sqfr = array($y2_dash*$pipe->geth(),$Fr1);
            return $sqfr;
        }  
    } else if ($pipe->getType() == "Circular"){
        // Calc dimensionless parameters
        $D = $pipe->getD();
        $A = $pipe->getA();
        $y1_dash = $y1/$D;
        $theta1 = 2*acos(1-(2*$y1_dash));
        $T1_dash = sin($theta1/2);
        $A1_dash = ($theta1-sin($theta1))/8;
        $Af_dash = $A/($D**2);
        $zA1_dash = ((3*sin($theta1/2))-(sin($theta1/2)**3)-(3*($theta1/2)*cos($theta1/2)))/24;
        $zAf_dash = (($D/2)*$A)/($D**3);
        
        // Calc froude number
        $Fr1 = $Q/(((9.81*($D**5)*($A1_dash**3))/$T1_dash)**0.5);
        
        // Calc transitional froude number
        $Frt = (($T1_dash*$Af_dash*($zAf_dash-$zA1_dash))/(($A1_dash**2)*($Af_dash-$A1_dash)))**0.5;
        
        if ($Fr1 < $Frt){ 
            // Complete jump forms
            $err = array();
            $k = steprange(0.001,pi()*2,1000);
            for($i = 0; $i < count($k); ++$i){
                $err[] = abs(circcompletejump($k[$i],$T1_dash,$A1_dash,$zA1_dash,$Fr1));
            }
            $theta = $k[array_keys($err, min($err))[0]];
            $sqfr = array(($D-($D*cos($theta/2)))/2,$Fr1);
            return $sqfr;
        } else if ($Fr1 >= $Frt){
            $y2_dash = 1 + ((1/($T1_dash*($Af_dash**2)))*((($Fr1**2)*($A1_dash**2)*($Af_dash - $A1_dash))-($T1_dash*$Af_dash*($zAf_dash - $zA1_dash))));
            $sqfr = array($y2_dash*$D,$Fr1);
            return $sqfr;
        }
    }
}

function circcompletejump($theta,$T1_dash,$A1_dash,$zA1_dash,$Fr1){
    $A2_dash = ($theta-sin($theta))/8;
    $zA2_dash = ((3*sin($theta/2))-(sin($theta/2)**3)-(3*($theta/2)*cos($theta/2)))/24;
    return (($T1_dash*$A2_dash*($zA2_dash-$zA1_dash))/(($A1_dash**2)*($A2_dash-$A1_dash)))-($Fr1**2);
}

// Partial Parameters

function partialparameters($pipe,$y){
    if ($pipe->getType() == "Circular"){
        $D = $pipe->getD();
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
    } else if ($pipe->getType() == "Rectangular"){
        $w = $pipe->getw();
        $A = $w*$y;
        $P = $w + 2*$y;
        $T = $w;
        return array($A,$P,$T);        
    } else if ($pipe->getType() == "section"){
        $w = $pipe->getw();
        $z = $pipe->getz();
        $A = ($w + ($z*$y))*$y;
        $P = $w + (2*$y*((1+($z**2))**0.5));
        $T = $w + (2*$z*$y);
        return array($A,$P,$T);
    }
}

// Properties

function totallength($pipes){
    $L = 0;
    for($i = 0; $i < count($pipes); ++$i) {
        $L = $L + $pipes[$i]->getL();
    }
    return $L;
}

function depthtoelevation($pipe,$out){
    $dt = $out[0];
    $k = $out[1];
    $us = $pipe->getus();
    $ds = $pipe->getds();
    $L = $pipe->getL();
    $xx = $pipe->getx();
    $m = ($ds-$us)/$L;
    $c = $us - ($m*$xx);
    $y = array();
    for($i = 0; $i < count($dt); ++$i){
        $y[] = ($m*$dt[$i])+$c+$k[$i];
    }
    return array($dt,$y);
}

function elevationtodepth($pipe,$out){
    $dt = $out[0];
    $k = $out[1];
    $us = $pipe->getus();
    $ds = $pipe->getds();
    $L = $pipe->getL();
    $xx = $pipe->getx();
    $m = ($ds-$us)/$L;
    $c = $us - ($m*$xx);
    $y = array();
    for($i = 0; $i < count($dt); ++$i){
        $y[] = $k[$i]-(($m*$dt[$i])+$c);
    }
    return array($dt,$y);
}

// Maximum flow capacity under open channel flow

function maxopenchannelflow($pipe){
    $h = $pipe->geth();
    $step = ($h - ($h*0.75))/1000;
    $y = range($h*0.75,$h,$step);
    $Q = array();
    for($i = 0; $i < count($y); ++$i) {
        $Q[] = mannings($pipe,$y[$i]);        
    }
    //echo max($Q);
    return array(max($Q),$y[array_search(max($Q),$Q)]);
}

function roughnessrecalculate($pipe){
    $mf = fullpipemanning($pipe,$pipe->getn());
    $cf = fullpipecolebrook($pipe,$pipe->getKs());
    if (abs($cf-$mf) > 0.001){
        if ($cf < $mf){
            $n = iteratormannings($cf,$pipe);
            $pipe->setn($n);
        } 
    }  
}

// Calculating functions

function steprange($start,$end,$steps){
    if ($steps == 0){
        return array($start);
    } else {
        $step = ($end - $start) / $steps;
        $steprange = array($start);
        for($i = 0; $i < $steps; ++$i) {
            $steprange[] = $steprange[$i] + $step;
        }
        return $steprange;
    }
}

function subtractarray($arr,$var){
    for($i = 0; $i < count($arr); ++$i) {
        $arr[$i] =  $var - $arr[$i];
    }
    return $arr;
}

function addarray($arr,$var){
    for($i = 0; $i < count($arr); ++$i) {
        $arr[$i] =  $arr[$i] + $var;
    }
    return $arr;
}

function timesarray($arr,$var){
    for($i = 0; $i < count($arr); ++$i) {
        $arr[$i] =  $arr[$i] * $var;
    }
    return $arr;
}

function arrayabs($arr){
    for($i = 0; $i < count($arr); ++$i) {
        $arr[$i] =  abs($arr[$i]);
    }
    return $arr;
}
    
function arraycumsum($arr){
    for($i = 1; $i < count($arr); ++$i) {
        $arr[$i] = $arr[$i-1] + $arr[$i];       
    }
    return $arr;
}

function intersect($out1,$out2){
    $dt = $out1[0];
    $k = $out1[1];
    $dtn = $out2[0];
    $kn = $out2[1];
    $a = min($dt);
    $x = 1;
    for($i = 1; $i < 20; ++$i) {
        $x = $x/2;
        if ($k[0] < $kn[0]){
            $y = 0;
            $z = 1;
            while ($y < $z){
                $a = $a + $x;
                $y = interpolate($a,$dt,$k);
                $z = interpolate($a,$dtn,$kn);
            }
            $a = $a - $x;
        } else {
            $y = 1;
            $z = 0;
            while ($y > $z){
                $a = $a + $x;
                $y = interpolate($a,$dt,$k);
                $z = interpolate($a,$dtn,$kn);
            }
            $a = $a - $x;
        }
    }
    if (($a == min($dt) or abs($a-end($dt))) < 0.001){
        return "False";
    } else {
        // Create new line
        $dtf = array();
        $kf = array();
        for($i = 0; $i < count($dt); ++$i){
            if ($dt[$i] < $a){
                $dtf[] = $dt[$i];
                $kf[] = $k[$i];
            }
        }
        $dtf[] = $a;
        $kf[] = interpolate($a,$dt,$k);
        for($i = 0; $i < count($dtn); ++$i){
            if ($dtn[$i] > $a){
                $dtf[] = $dtn[$i];
                $kf[] = $kn[$i];
            }
        }
        $out = array($dtf,$kf);
        return $out;
    }
}

function interpolate($a,$dt,$k){
    if (count($dt) == 2){
        $ind = 0;
    } else {
        for($i = 0; $i < count($dt); ++$i){
            $y = $a - $dt[$i];
            if ($y < 0){
                $y = 1000000000;
            }
            $x[] = $y;
        }
        $ind = array_keys($x,min($x))[0];
    }
    if ($ind == (count($dt)-1)){
        return "False";
    } else {
        $m = ($k[$ind+1]-$k[$ind])/($dt[$ind+1]-$dt[$ind]);
        $c = $k[$ind] - ($m*$dt[$ind]);
        return ($m*$a) + $c;
    }
}

function interpolateFr($a,$Fr,$dt){
    if (count($dt) == 2){
        $ind = 0;
    } else {
        $ind = (count($dt)-1);
        for($i = 0; $i < count($dt); ++$i){
            if ($Fr[$i] <= $a){
                $ind = $i;
                break;
            }
        }
    }
    if ($ind == (count($dt)-1)){
        // No intercept
        return end($dt)*2;
    } else if ($ind == 0){
        // Already less than 1.7
        return $dt[0];
    } else {
        // interpolate
        $m = ($Fr[$ind]-$Fr[$ind-1])/($dt[$ind]-$dt[$ind-1]);
        $c = $Fr[$ind] - ($m*$dt[$ind]);
        return ($a - $c)/$m;
    }
}

// Gradually Varied Flow

function directstepmethod($pipe,$Q,$us,$ds,$dir,$L,$e){
    $nosteps = 200; // Number of steps in pipe   
    if ($dir == "us"){
        $pp = partialparameters($pipe,$ds);
        $k = steprange($ds,$us,$nosteps);
        $A = $pp[0];
        $P = $pp[1];
        $Et = array(specificenergy($ds,$Q,$A));
    } else if ($dir == "ds"){
        $pp = partialparameters($pipe,$us);
        $k = steprange($us,$ds,$nosteps);
        $A = $pp[0];
        $P = $pp[1];
        $Et = array(specificenergy($us,$Q,$A));
    }
    $n = $pipe->getn();
    $S = $pipe->getS();
    $xx = $pipe->getx();
    $At = array($A);
    $Vt = array($Q/$A);
    $Rt = array($A/$P);
    $Sft = array(frictionslope($n,$Q,$A,$P));
    $dt = array(0);
    for($i = 1; $i < count($k); ++$i) {
        $pp = partialparameters($pipe,$k[$i]);
        $A = $pp[0];
        $P = $pp[1];
        $At[] = $A;
        $Vt[] = $Q/$A;
        $Rt[] = $A/$P;
        $Et[] = specificenergy($k[$i],$Q,$A);
        $Sft[] = frictionslope($n,$Q,$A,$P);
        $dt[] = $e*(($Et[$i]-$Et[$i-1])/($S-(($Sft[$i]+$Sft[$i-1])/2)));
    }
    $dt_sum = array_sum(arrayabs($dt));
    if ($dir == "us"){
        $dt = arrayabs($dt);
        $dt = arraycumsum($dt);
        $dt = subtractarray($dt,$L);
        $dt = array_reverse($dt);
        $k = array_reverse($k);
        if ($L >= $dt_sum){
            array_unshift($dt,0);
            array_unshift($k,$us);
        } else if ($L < $dt_sum){
            $ddt = 0;
            $ddk = $us;
            while ($dt[0] < 0) {
                $ddk = $k[0];
                $ddt = $dt[0];
                array_shift($dt);
                array_shift($k);
            }
            $int = $k[0] + (($dt[0]/($dt[0]-$ddt))*($ddk-$k[0]));
            array_unshift($dt,0);
            array_unshift($k,$int);
        }
    } else if ($dir == "ds"){
        $dt = arrayabs($dt);
        $dt = arraycumsum($dt);
        if ($L > $dt_sum){
            array_push($dt, $L);
            array_push($k, $ds);
        } else if ($L < $dt_sum){
            $ddt = $L;
            $ddk = $ds;
            while (end($dt) > $L) {
                $ddk = end($k);
                $ddt = end($dt);
                array_pop($dt);
                array_pop($k);
            }
            $int = end($k) + ((($L-end($dt))/($ddt-end($dt)))*($ddk-end($k)));
            array_push($dt,$L);
            array_push($k,$int);  
        }  
    }
    $dt = addarray($dt,$xx);
    return array($dt,$k);
}

function directstepmethoddetails($pipes,$Q){
	for ($x = 1; $x < count($pipes)-1; $x++) {
		$out = elevationtodepth($pipes[$x],array($pipes[$x]->getdt(),$pipes[$x]->getk()));
		$dt = $out[0];
		$k = $out[1];
		$n = $pipes[$x]->getn();
		$S = $pipes[$x]->getS();
		
		$y = [$k[0]];
		$pp = partialparameters($pipes[$x],$k[0]);
		$A = [$pp[0]];
		$V = [$Q/$pp[0]];
		$R = [$pp[0]/$pp[1]];
		$E = [specificenergy($k[0],$Q,$pp[0])];
		$Sf = [frictionslope($n,$Q,$pp[0],$pp[1])];
		$dl = [null];
		
		for ($i = 1; $i < count($k); $i++) {
			$y[] = $k[$i];
			$pp = partialparameters($pipes[$x],$k[$i]);
			$A[] = $pp[0];
			$V[] = $Q/$pp[0];
			$R[] = $pp[0]/$pp[1];
			$E[] = specificenergy($k[$i],$Q,$pp[0]);
			$Sf[] = frictionslope($n,$Q,$pp[0],$pp[1]);		
			$dl[] = ($E[$i]-$E[$i-1])/($S-(($Sf[$i]+$Sf[$i-1])/2));
		}
		
		$dt = $pipes[$x]->getdt();
		$k = $pipes[$x]->getk();
		$fc = $pipes[$x]->getflowcurve();
		if (strpos($fc,"M") !== false){
			$y = array_reverse($y);
			$A = array_reverse($A);
			$V = array_reverse($V);
			$R = array_reverse($R);
			$E = array_reverse($E);
			$Sf = array_reverse($Sf);
			$dl = array_reverse($dl);
			$k = array_reverse($k);
			$dt = array_reverse($dt);
			
			$dl = timesarray(arrayabs($dl),-1);
			array_unshift($dl,null);
			array_pop($dl);
			#$dl = array_unshift($dl,"NaN");
			
		}
		
		$DSM = array($y,$A,$V,$R,$E,$Sf,$dl,$k,$dt);
		$pipes[$x]->setDSM($DSM);
	}
}

// Rapidly Varied Flow

function mildhydraulicjump($pipe,$Q,$out,$us){
    $pipe->setflowcurve("M3-HJ-S1");
    // Parameters
    $L = $pipe->getL();
    $xx = $pipe->getx();
    
    // US GVF curve
    $dt1 = $out[0];
    $k1 = $out[1];
    
    $pipe->setHJ_US($out);
    
    // DS M3 GVF curve
    $ds = $pipe->getyc(); // M3 curve tends to critical depth
    $out2 = directstepmethod($pipe,$Q,$us,$ds,"ds",$L,1);
    $dt2 = $out2[0];
    $k2 = $out2[1];
    
    $pipe->setHJ_DS($out2);
    
    // Create sequent depth
    $k3 = array();
    $Frl = array();
    $dt3 = $dt2; // Use same sampling as DS GVF curve
    for($i = 0; $i < count($k2); ++$i){
       $sdfr = sequentdepth($Q,$k2[$i],$pipe);
       $k3[] = $sdfr[0];
       $Frl[] = $sdfr[1];           
    }
    $pipe->setsequent(array($dt3,$k3));
    
    // Find location of Fr = 1.7
    if ($Frl[0] <= 1.7){
        $a = $xx;
    } else {
        $dt17 = interpolateFr(1.7,$Frl,$dt3);
        $k17 = interpolate($dt17,$dt3,$k3);
        if ($k17 > interpolate($dt17,$dt1,$k1)){
           $a = $dt17;
        } else {
           $a = $xx;
           $y = 0;
           $x = 1;
           $z = 1;
           for($i = 0; $i < 20; ++$i){
               $x = $x/2;
               while ($y <= $z){
                   $a = $a + $x;
                   $y = interpolate($a,$dt1,$k1);
                   $z = interpolate($a,$dt3,$k3);
                   if ($y == "False" or $z == "False"){
                       break;
                   }
               }
               $y = 0;
               $a = $a - $x;
           }
        }
    }
    
    // Froude number
    $ya = interpolate($a,$dt2,$k2);
    $Fr1 = froudeno($pipe,$ya,$Q);
    
    // Hydraulic jump length
    $Lj = hydraulicjumplength($k3[0],end($k3),$Fr1,end($k3),"N/A",$pipe,"A");
    
    if ($a + $Lj >= ($L + $xx - 0.001)){
	   $pipe->setflowcurve("M3");
       $dtf = $dt2;
       $kf = $k2;
    } else {
       $dtf = array();
       $kf = array();
       for($i = 0; $i < count($dt2); ++$i){
           if ($dt2[$i] < $a){
               $dtf[] = $dt2[$i];
               $kf[] = $k2[$i];
           }
       }
       $dtf[] = $a;
       $kf[] = interpolate($a,$dt2,$k2);
       $dtf[] = $a + $Lj;
       $kf[] = interpolate(($a+$Lj),$dt1,$k1);
       for($i = 0; $i < count($dt1); ++$i){
           if ($dt1[$i] > $a + $Lj){
               $dtf[] = $dt1[$i];
               $kf[] = $k1[$i];
           }
       }  
    }
    $si = soffitintersectHJ($pipe,array($dtf,$kf));
    $pipe->setHJ_end($si);
    return $si;
}

function steephydraulicjump($pipe,$dspipe,$Q,$out,$ds){
    // Parameters
    $L = $pipe->getL();
    $h = $pipe->geth();
    $us = $pipe->getyc();
    $xx = $pipe->getx();
    $US = $pipe->getus();
    $DS = $pipe->getds();
    $dy = $pipe->getdy();
    $Y = $DS + $ds + ($dy*$L);
    
    // Full pipe
    if ($ds >= $h and $Y > $US + $h){
        $dtf = array($xx,$xx+$L);
        $kf = array($Y-$US,$ds);
        $pipe->setfull("True");
        $pipe->setflowcurve("F");
        return array($dtf,$kf);
        
    // Open channel or partially full pipe
    } else {
        
        // DS GVF curve
        $dt2 = $out[0];
        $k2 = $out[1];
        
        $pipe->setHJ_DS($out);
        
        // Set flow curves
        if ($k2[0] > $us){
            $pipe->setflowcurve("S2-HJ-S1");
        } else {
            $pipe->setflowcurve("S3-HJ-S1");
        }

        // Create sequent depth
        $k3 = array();
        $Frl = array();
        $dt3 = $dt2; // Use same sampling as DS GVF curve
        for($i = 0; $i < count($k2); ++$i){
           $sdfr = sequentdepth($Q,$k2[$i],$pipe);
           $k3[] = $sdfr[0];
           $Frl[] = $sdfr[1];           
        }
        $pipe->setsequent(array($dt3,$k3));
        
        // Find out if ds is full
        if ($ds <= $h){
            // DS pipe not full or just full S1 curve from DS to CD
            $out1 = directstepmethod($pipe,$Q,$us,$ds,"us",$L,1);
            $dt1 = $out1[0];
            $k1 = $out1[1];
			if ($out1[1][0] > $pipe->getnormaldepth()){
				$pipe->setflowcurve("S1");
			}

        } else if ($ds > $h){
            // DS pipe full S1 curve from soffit intersect

            // Find soffit intersect
            $m1 = ($ds + $DS - $Y)/$L;
            $c1 = $Y - ($m1*$xx);
            $m2 = ($DS - $US)/$L;
            $c2 =  $US + $h - ($m2*$xx);
            $xp = (($c2 - $c1)/($m1 - $m2));
            $yp = ($m1*$xx) + $c1;

            // Get partially full length of pipe
            $Lp = $xp - $xx;

            // S1 gradually varied flow curve
            $out1 = directstepmethod($pipe,$Q,$pipe->getnormaldepth(),$h,"us",$Lp,1);

            // Join partially full and full sections
            $dt1 = $out1[0];
            $k1 = $out1[1];
            $dt1[] = $xx + $L;
            $k1[] = $ds;
			
			if ($out1[1][0] > $pipe->getnormaldepth()){
				$pipe->setflowcurve("S1");
			}

        }
		
		
        
        $pipe->setHJ_US(array($dt1,$k1));

        // Find intersect a between S1 and sequent
        $a = $xx + $L;
        $y = 1;
        $x = 1;
        $z = 0;
        for($i = 0; $i < 20; ++$i){
           $x = $x/2;
           while ($y > $z){
               $a = $a - $x;
               $y = interpolate($a,$dt1,$k1);
               $z = interpolate($a,$dt3,$k3);
               if ($a < $xx){
                   break;
               }
           }
           $z = 0;
           $a = $a + $x;
        }
        
        if ($a < 5.00001){
            // No jump
            return $out1;
        } else if ($a > $xx + $L - 0.001){
            return $out;
        } else {
            // Find froude number
            $ya = interpolate($a,$dt2,$k2);
            $Fr1 = froudeno($pipe,$ya,$Q);
            
            // Join DS curve to US at intersect with sequent
            $z1 = abs(($L - ($a-$xx)) * (($DS-$US)/$L));
            $Lj = hydraulicjumplength($k3[0],end($k3),$Fr1,end($k3),$z1,$pipe,"C");
            // Hydraulic Jump crosses pipe intersect
            if ($Lj + $a > $xx + $L){
                $Lj = max(hydraulicjumplength($k3[0],end($k3),$Fr1,end($k3),$z1,$pipe,"B"),$Lj);
                $dtf = array();
                $kf = array();
                $dtd = $dspipe->getdt();
                $kd = $dspipe->getk();
                $xxd = $dspipe->getx();
                $Ld = $dspipe->getL();

                // HJ distance into DS pipe
                $dsa = $a + $Lj - $xxd;

                if ($dsa > $Ld){
                    // Hydraulic jump washed out as cant complete
                    // Find pipe intersect intersect
                    $outus = depthtoelevation($pipe,array($dt2,$k2));
                    $int = interpolate($a,$outus[0],$outus[1]);
                    $m = (end($kd) - $int)/(($xxd + $Ld) - $a);
                    $c = end($kd) - ($m * ($xxd + $Ld));
                    $y = ($m * $xxd) + $c - $DS;

                    // Update DS section
                    $dspipe->setk(array($y+$DS,end($kd)));
                    $dspipe->setdt(array($xxd,$xxd+$Ld));

                    // Create profile steep section
                    for($i = 0; $i < count($dt2); ++$i){
                       if ($dt2[$i] < $a){
                           $dtf[] = $dt2[$i];
                           $kf[] = $k2[$i];
                       }
                    }
                    $dtf[] = $a;
                    $kf[] = interpolate($a,$dt2,$k2);
                    $dtf[] = $xx + $L;
                    $kf[] = $y;
                } else {
                    // Hydraulic jump completes in ds section
                    // Find intersect
                    
                    $outus = depthtoelevation($pipe,array($dt2,$k2));
                    $intds = interpolate($a+$Lj,$dtd,$kd);
                    $intus = interpolate($a,$outus[0],$outus[1]);
                    $m = ($intds - $intus)/($Lj);
                    $c = $intus - ($m * $a);
                    $y = ($m * $xxd) + $c - $DS;
                    // Create profile (Steep section)
                    for($i = 0; $i < count($dt2); ++$i){
                       if ($dt2[$i] < $a){
                           $dtf[] = $dt2[$i];
                           $kf[] = $k2[$i];
                       }
                    }
                    $dtf[] = $a;
                    $kf[] = interpolate($a,$dt2,$k2);
                    $dtf[] = $xx + $L;
                    $kf[] = $y;
                    

                    // Update DS section
                    $dtdf = array($xxd);
                    $kdf = array($y+$DS);
                    
                    // Top of pipe
                    $mp = ($dspipe->getds() - $dspipe->getus())/($Ld);
                    $cp = $dspipe->getus() + $dspipe->geth() - ($mp * $xxd);
                    
                    // Add the intersect with the pipe roof 
                    if (interpolate($a+$Lj,$dtd,$kd) > (($mp * ($a+$Lj)) + $cp) and $y < $pipe->geth()){
                        // Find intersect with pipe roof
                        $x_int = ($cp - $c)/($m - $mp);
                        $y_int = (($mp * $x_int) + $cp);
                        $dtdf[] = $x_int;
                        $kdf[] = $y_int;  
                    }
                    
                    $dtdf[] = $a+$Lj;
                    $kdf[] = interpolate($a+$Lj,$dtd,$kd);
                    
                    for($i = 0; $i < count($dtd); ++$i){
                        if ($dtd[$i] > $a + $Lj){
                            $dtdf[] = $dtd[$i];
                            $kdf[] = $kd[$i];
                        }
                    }      
                    $dspipe->setUSwl($y+$DS);
                    $dspipe->setdt($dtdf);
                    $dspipe->setk($kdf);  
                }
            } else {
                // Hydraulic jump contained within steep section
                $dtf = array();
                $kf = array();
                for($i = 0; $i < count($dt2); ++$i){
                   if ($dt2[$i] < $a){
                       $dtf[] = $dt2[$i];
                       $kf[] = $k2[$i];
                   }
                }
                $dtf[] = $a;
                $kf[] = interpolate($a,$dt2,$k2);
                $dtf[] = $a + $Lj;
                $kf[] = interpolate(($a + $Lj),$dt1,$k1);
                for($i = 0; $i < count($dt1); ++$i){
                   if ($dt1[$i] > ($a+$Lj)){
                       $dtf[] = $dt1[$i];
                       $kf[] = $k1[$i];
                   }
                }                
            }
            $si = soffitintersectHJ($pipe,array($dtf,$kf));
            $pipe->setHJ_end($si);
            return $si;
        }   
    }
}

function hydraulicjumplength($y1,$y2,$Fr1,$h2,$z1,$pipe,$Letter){
	$pipe->setHJ_Fr($Fr1);
    $Type = $pipe->getType();
    if ($Type == "Circular"){
        $Lj_star = 6*$y2;
    } else if ($Type == "Rectangular"){
        $Lj_star = 220 * $y1 * (tanh(($Fr1-1)/22));
    }
    if ($Letter == "A"){
        $pipe->setJt("A");
        $pipe->setLj($Lj_star);
		$pipe->setHJ_flow("Decelerating");
        return $Lj_star;
    } else if ($Letter == "B"){
        $pipe->setJt("B");
		$pipe->setHJ_flow("Decelerating");
        $Fr1t = 11.3 * (1 - ((2/3)*(($h2 - $z1)/$h2)));
        if ($Fr1 > $Fr1t){
            $pipe->setLj($Lj_star);
            return $Lj_star;
        } else {
            $E = ($h2 - $z1)/$h2;
            $Lj = max($h2*((7/3)*(2+((6*$E)*exp(1-(6*$E))))-((1/20)*(1+(5*(6*$E*exp(1 - (6*$E)))))*($Fr1 -2))),$Lj_star);
            $pipe->setLj($Lj);
            return $Lj;
        }
    }else if ($Letter == "C"){
        $us = $pipe->getus();
        $ds = $pipe->getds();
        $L = $pipe->getL();
        $theta = atan(($ds-$us)/$L);
        $Lj = $Lj_star * exp(-(4/3)*$theta);
        $pipe->setLj($Lj);
        $pipe->setJt("C");
		$pipe->setHJ_flow("Accelerating");
        return $Lj;
    }
}

// Logic functions

function flowparameters($pipes,$Q){
    $xl = 5;
    for ($x = 0; $x < count($pipes); $x++) {
        
        // Update K value with loss due to pipe size changes
        if ($x == (count($pipes)-1)){
            $pipes[$x]->setdsD("End");
        } else {
            $pipes[$x]->setdsD($pipes[$x+1]->getD());
        }
        $K_psc = pipesizechangeloss($pipes[$x],$Q);
        $K_user = $pipes[$x]->getK();
        $K_t = $K_psc + $K_user;
        $pipes[$x]->setK($K_t);
        $pipes[$x]->setKu($K_user);
        $pipes[$x]->setKp($K_psc);
        
        // Recalculate Ks and n values for new total minor loss
         if ($K_t != $K_user){
             roughnessrecalculate($pipes[$x]);
        }
        
        // Maximum open channel flow parameters
        $mocf = maxopenchannelflow($pipes[$x]);
        $pipes[$x]->setmaxflow($mocf[0]);
        $pipes[$x]->setmaxflowdepth($mocf[1]);
        
        // Other parameters
        $yc = criticaldepth($pipes[$x],$Q); // Critical depth
        $dw = darcyweisbach($pipes[$x],$Q);
        $dy = $dw[0]/$pipes[$x]->getL(); // Full pipe friction flow
        $f = $dw[1];
        
        // Open Channel Flow
        if ($Q < $pipes[$x]->getmaxflow()){
            $full = "False";
            $normaldepth = depthmannings($pipes[$x],$Q);
            $uswl = $pipes[$x]->getus() + $normaldepth;
            $dswl = $pipes[$x]->getds() + $normaldepth;
			$flowcurve = "Nd";
            // Check froude number to see if supercritical
            if (froudeno($pipes[$x],$normaldepth,$Q) > 1) {
                $supercritical = "True";
            } else {
                $supercritical = "False";
            }
            
        // Pressurised Pipe Flow
        } else {
            $full = "True";
			$flowcurve = "F";
            $normaldepth = $pipes[$x]->geth(); // Pipe depth
            $supercritical = "False";
            $uswl = $pipes[$x]->getds() + max($pipes[$x]->geth(), ($dy*$pipes[$x]->getL()));
            $dswl = $pipes[$x]->getds() + $normaldepth;
        }

        // Add parameters to class
        $pipes[$x]->setfull($full);
        $pipes[$x]->setnormaldepth($normaldepth);
        $pipes[$x]->setsupercritical($supercritical);
        $pipes[$x]->setyc($yc);
        $pipes[$x]->setdy($dy);
        $pipes[$x]->setf($f);
        $pipes[$x]->setx($xl);
        $pipes[$x]->setk(array($uswl,$dswl));
        $pipes[$x]->setdt(array($xl,$xl+$pipes[$x]->getL()));
		$pipes[$x]->setflowcurve($flowcurve);
        
        // Update distance along pipe. 
        $xl = $xl + $pipes[$x]->getL(); 
    }
}

function flowprofile($pipe,$dspipe,$Q,$hj){
    // Get US and DS water depths
    $us = $pipe->getUSwl() - $pipe->getus();
    $ds = $pipe->getDSwl() - $pipe->getds();
    
    // Split between steep and mild or full
    if ($pipe->getsupercritical() == "False"){
        // Logic for mild and full pipes
        
        // For mild and full pipes ds depth dominates and us will always tend to normal depth
        $out = mildpipe($pipe,$Q,$ds);
        $pipe->setvariedflow("Gradual");
        
        if ($hj == "True"){
            // Find out if there is a hydraulic jump
            $yc = $pipe->getyc(); // Critical depth
            $y2 = $out[1][0]; // Depth at pipe entrance
            $sq = sequentdepth($Q,$us,$pipe); // Sequent depth at entrance
            
            if ($us <= $yc and $sq[0] >= $y2){
                $out = mildhydraulicjump($pipe,$Q,$out,$us);
                $pipe->setvariedflow("Rapid");
            }
        }
  
    } else if ($pipe->getsupercritical() == "True"){
        // Logic for steep pipe

        // For steep pipes us depth dominates and ds will always tend to normal depth
        $out = steeppipe($pipe,$Q,$us,$ds);
        $pipe->setvariedflow("Gradual");
        
        if ($hj == "True" and $ds >= $pipe->getyc()){
            // Find out if there is a hydraulic jump
            $y1 = end($out[1]); // Depth at pipe exit
            $sq = sequentdepth($Q,$y1,$pipe); // Sequent depth at exit
            if ($ds >= $sq[0]){
                $out = steephydraulicjump($pipe,$dspipe,$Q,$out,$ds);
                $pipe->setvariedflow("Rapid");
            }
        }
    }
    
    // Update pipe
    $out = depthtoelevation($pipe,$out);
    $pipe->setdt($out[0]);
    $pipe->setk($out[1]);
    $pipe->setUSwl($out[1][0]);
    $pipe->setDSwl(end($out[1]));
}

function mildpipe($pipe,$Q,$ds){
    // Get parameters
    $h = $pipe->geth();
    $L = $pipe->getL();
    $x = $pipe->getx();
    $dy = $pipe->getdy();
    $us = $pipe->getnormaldepth();
    $yc = $pipe->getyc();
    $US = $pipe->getus();
    $DS = $pipe->getds();
    
    // Ensure $ds is valid and set to critical depth if not
    if ($ds < $yc){
        $ds = $yc;
    }
    
    // Split between ds >= h or <= h
	if ($ds == $h){
		$pipe->setflowcurve("F");
		$dt = array($x,$x+$L);
        $k = array($ds+($dy*$L),$ds);
	} else if ($ds < $h){
        // Downstream level less than section height.
        
        // Create gradually varied flow curve
        $out = directstepmethod($pipe,$Q,$us,$ds,"us",$L,1);
        
        // Set Flow Curves
        if ($ds > $us){
            $pipe->setflowcurve("M1");
        } else if ($ds < $us){
            $pipe->setflowcurve("M2");
        } else {
            $pipe->setflowcurve("Nd");
        }

        // Find out if intersects soffit
        $dt = $out[0];
        $k = $out[1];
        if ($h - max($k) < 0.0001){
            // Full -> partially full pipe
            $pipe->setflowcurve("F-M2");
            $dtn = array();
            $kn = array();
            for($i = 0; $i < count($dt); ++$i){
                if ($h - $k[$i] < 0.0001){
                    $index = $i;
                } else {
                    $kn[] = $k[$i];
                    $dtn[] = $dt[$i];
                }
            }
            if (count($kn) < 1){
                $kn[] = $h;
                $dtn[] = $x + $L;
            }
            $hf = $dy * ($dt[$index]-$x);
            array_unshift($kn,($h + $hf));
            array_unshift($dtn,$x);
			
            $dt = $dtn;
            $k = $kn;
			
        }
    } else if ($ds >= $h){
        // Partially full -> full pipe or full pipe
        
        // Split between pipe full and mild pipe
        $Y = $US + $ds + ($dy*$L); // US HGL elevation
        $H = $US + $h; // US soffit elevation
        
        if ($Y >= $H){
            // Full pipe
            $dt = array($x,$x+$L);
            $k = array($ds+($dy*$L),$ds);
			$pipe->setflowcurve("F");
            
        } else if ($full = "False"){
            // Partially full -> full pipe
            $pipe->setflowcurve("S1-F");
            // Find soffit intersect
            $m1 = ($ds + $DS - $Y)/$L;
            $c1 = $Y - ($m1*$x);
            $m2 = ($DS - $US)/$L;
            $c2 =  $US + $h - ($m2*$x);
            $xp = (($c2 - $c1)/($m1 - $m2));
            $yp = ($m1*$x) + $c1;
            
            // Get partially full length of pipe
            $Lp = $xp - $x;
            
            // S1 gradually varied flow curve
            $out = directstepmethod($pipe,$Q,$us,$h,"us",$Lp,1);
            
            // Join partially full and full sections
            $dt = $out[0];
            $k = $out[1];
            $dt[] = $x + $L;
            $k[] = $ds;
        }
    }
    
    // Return result
    return array($dt,$k);
}

function steeppipe($pipe,$Q,$us){
    $ds = $pipe->getnormaldepth();
	$yc = $pipe->getyc();
    $L = $pipe->getL();
	
	if ($us > $yc){
		$us = $yc;
	}
    
    // Set Flow Curves
    if ($ds > $us){
        $pipe->setflowcurve("S3");
    } else if ($ds < $us){
        $pipe->setflowcurve("S2");
    } else {
        $pipe->setflowcurve("Nd");
    }
	$pipe->setHJ_end(directstepmethod($pipe,$Q,$us,$ds,"ds",$L,1));
    return directstepmethod($pipe,$Q,$us,$ds,"ds",$L,1);
}

function continuitycheck($pipes){
    $cont = "True";
    for ($x = 1; $x < (count($pipes)-1); $x++){
        if ($pipes[$x]->getsupercritical() == "True" and $pipes[$x+1]->getsupercritical() == "True"){
            if ($pipes[$x]->getUSwl() != $pipes[$x+1]->getDSwl()){
                $cont = "False";
            }
        } else if ($pipes[$x]->getsupercritical() == "False" and $pipes[$x-1]->getsupercritical() == "False"){
            if ($pipes[$x]->getDSwl() != $pipes[$x-1]->getUSwl()){
                $cont = "False";
            }
        }
    }
    return $cont;
}

function continuitycheckHJ($pipes){
    $cont = "True";
    for ($x = 1; $x < (count($pipes)-1); $x++){
        if ($pipes[$x]->getsupercritical() == "True" and $pipes[$x-1]->getsupercritical() == "False"){
            if ($pipes[$x-1]->getUSwl() != $pipes[$x]->getDSwl()){
                $cont = "False";
            }
        }
		if ($pipes[$x]->getsupercritical() == "True" and $pipes[$x+1]->getsupercritical() == "False"){
            if ($pipes[$x+1]->getDSwl() != $pipes[$x]->getUSwl()){
                $cont = "False";
            }
        }
    }
    return $cont;
}

function updatewaterlevels($pipes){
    for ($x = 1; $x < (count($pipes)-1); $x++) {
        if ($pipes[$x]->getsupercritical() == "True" and $pipes[$x+1]->getsupercritical() == "True"){
            $pipes[$x]->setUSwl($pipes[$x+1]->getDSwl());
        } else if ($pipes[$x]->getsupercritical() == "False" and $pipes[$x-1]->getsupercritical() == "False"){
            $pipes[$x]->setDSwl($pipes[$x-1]->getUSwl());
        } 
    }
}

function updatewaterlevelsHJ($pipes){
    for ($x = 1; $x < (count($pipes)-1); $x++) {
        if ($pipes[$x]->getsupercritical() == "False" and $pipes[$x+1]->getsupercritical() == "True"){
            $k = $pipes[$x+1]->getk();
            $pipes[$x]->setUSwl(end($k));
            if ($pipes[$x-1]->getk()[0] >= $pipes[$x]->getyc()){
                $k2 = $pipes[$x-1]->getk()[0];
                $pipes[$x]->setDSwl($k2);
            } else {
                $yc = $pipes[$x]->getyc();
                $pipes[$x]->setDSwl($yc);
            }
            $kk = $pipes[$x]->getk();
            if (end($kk) < $pipes[$x]->getyc() + $pipes[$x]->getus() and $pipes[$x-1]->getsupercritical() == "True"){
                $pipes[$x-1]->setUSwl(end($kk));
            }
        } else if ($pipes[$x]->getsupercritical() == "True" and $pipes[$x-1]->getsupercritical() == "False"){
            $k = $pipes[$x-1]->getk();
            $pipes[$x]->setDSwl($k[0]);
        } else if ($pipes[$x]->getfull() == "True" and $pipes[$x-1]->getfull() == "True"){
            $pipes[$x]->setDSwl($pipes[$x-1]->getk()[0]);
        }
    }
}

function initialwaterlevels($pipes){
    for ($x = 1; $x < (count($pipes)-1); $x++) {
        if ($pipes[$x]->getfull() == "True"){
            // Pipe full
            if ($pipes[$x+1]->getsupercritical() == "True"){
                // If upstream is supercritical set to us normal depth
                $pipes[$x]->setUSwl($pipes[$x+1]->getds() + $pipes[$x+1]->getnormaldepth());
            } else {
                // Set us to full pipe
                $pipes[$x]->setUSwl($pipes[$x]->getus() + $pipes[$x]->geth());
            }
             
            // Upstream supercritical means hydraulic jump
            if ($pipes[$x-1]->getfull() == "True"){
                // Full pipe DS: normal pipe full
                $pipes[$x]->setDSwl($pipes[$x]->getds() + $pipes[$x]->geth());
            } else if ($pipes[$x-1]->getsupercritical() == "True"){
                // Supercritical pipe DS: drawndown to DS critical depth
                // Fudge see nappe flow in Chow 
                $pipes[$x]->setDSwl(max($pipes[$x-1]->getUSwl(),$pipes[$x]->getds()+$pipes[$x]->getyc()));
            } else {
                // Subcritical pipe DS: DS section USwl
                // Fudge see nappe flow in Chow 
                $pipes[$x]->setDSwl(max($pipes[$x-1]->getUSwl(),$pipes[$x]->getds()+$pipes[$x]->getyc()));
            }
            
        } else if ($pipes[$x]->getsupercritical() == "True"){
            // Pipe supercritical
            $pipes[$x]->setDSwl($pipes[$x]->getds() + $pipes[$x]->getnormaldepth());
            
            if ($pipes[$x+1]->getfull() == "True"){
                // If upstream pipe is full USwl = min of critical depth and height of section
                $pipes[$x]->setUSwl(min(($pipes[$x]->getus() + $pipes[$x]->getyc()),($pipes[$x]->getus() + $pipes[$x]->geth())));
            }  else if ($pipes[$x+1]->getsupercritical() == "True"){
                // US depth = normal depth for US supercritical 
                $pipes[$x]->setUSwl($pipes[$x+1]->getds() + $pipes[$x+1]->getnormaldepth());
            } else {
                // US depth = critical depth for section
                $pipes[$x]->setUSwl($pipes[$x]->getus() + $pipes[$x]->getyc());
            }
        } else {
            // Pipe subcritical
            // Downstream water level
            if ($pipes[$x-1]->getfull() == "True"){
                // If DS is full go for min of sections heights
                $pipes[$x]->setDSwl(min(($pipes[$x]->getds() + $pipes[$x]->geth()),($pipes[$x-1]->getus() + $pipes[$x-1]->geth())));
            } else if ($pipes[$x-1]->getUSwl() < $pipes[$x]->getds()){
                // If free discharge reduce to critical depth
                // Reduce to yc/1.4 as per Hunter Rouse - Discharge Characteristics of a free overfall
                $pipes[$x]->setDSwl($pipes[$x]->getds() + (($pipes[$x]->getyc())));
            } else {
                // For both sub and supercritical downstream set DSwl to USwl of DS section
                // Fudge see nappe flow in Chow
                $pipes[$x]->setDSwl(max($pipes[$x-1]->getUSwl(),$pipes[$x]->getds()+$pipes[$x]->getyc()));
            }
            if ($pipes[$x+1]->getfull() == "True"){
                // If upstream is full assume drawdown to normal depth or critical depth (higher value) mins adjust for changing pipe heights    
                $pipes[$x]->setUSwl(max((min(($pipes[$x+1]->getds() + $pipes[$x+1]->geth()),($pipes[$x]->getus() + $pipes[$x]->getnormaldepth()))),(min(($pipes[$x]->getus() + $pipes[$x]->geth()),($pipes[$x+1]->getds() + $pipes[$x+1]->getyc())))));
                
            } else if ($pipes[$x+1]->getsupercritical() == "True"){
                // Hydraulic jump use the normal depth from US
                $pipes[$x]->setUSwl($pipes[$x+1]->getds() + $pipes[$x+1]->getnormaldepth());
            } else {
                // Upstream subcritical hence normal depth
                 $pipes[$x]->setUSwl($pipes[$x]->getus() + $pipes[$x]->getnormaldepth());
            }
            
            
        }
    }
    
}

// Loss functions

function entranceloss($pipe,$inlet,$Q){
    $type = $inlet->getType();
    $detail = $inlet->getDetail();
    include("db.php");
    $sql = $conn->prepare("SELECT * FROM polynomialcoefficient WHERE inlettype = ? AND inletconfig = ?");
    $sql->bind_param('ss', $type, $detail);
    $sql->execute();
    $sql->store_result();
    $row = fetchAssocStatement($sql);
    $ke = $row["Ke"];
    if ($pipe->getk() != "Unknown variable."){
        if ($pipe->getk()[0] - $pipe->getus() > $pipe->geth()){
            $us = $pipe->geth();
        } else {
            $us = $pipe->getk()[0] - $pipe->getus();
        }
    } else {
        $us = $pipe->getnormaldepth();
    }
    $args = partialparameters($pipe,$us);
    $V = $Q/$args[0];
    // (ke+1) because you assume 0 velocity in upstream reservoir so hydraulic grade line = energy grade line.
    $Hl = ($ke+1)*(($V**2)/(2*9.81));
    
    // Save coefficients
    $inlet->setsubcoef(array("Ke"=>$row["Ke"],"HWA"=>$pipe->getk()[0]+$Hl,"HL"=>$Hl,"y"=>$pipe->getk()[0]-$pipe->getus(),"HW"=>$pipe->getk()[0]+$Hl-$pipe->getus()));
    
    return $Hl;
    
    
    
}

function supercriticalheadwater($pipe,$inlet,$Q){
    include("db.php");
    $sql = $conn->prepare("SELECT * FROM inletcontrolcoefficients WHERE inlettype = ? AND inletconfig = ?");
    $Type = $inlet->getType();
    $Detail = $inlet->getDetail();
    $sql->bind_param('ss', $Type, $Detail);
    $sql->execute();
    $sql->store_result();
    $row = fetchAssocStatement($sql);
    $S = $pipe->getS();
    $A = 10.764 * $pipe->getA(); // Convert area to imperial
    $D = (1/0.3048) * $pipe->geth(); // Convert height to imperial
    $Q = $Q * 35.314667; // Convert flow rate to imperial
    $par = $Q/($A*($D**0.5));
    
    if ($par < 3.5){
        $ft = "Unsubmerged";
        $yc = $pipe->getyc(); 
        // Unsubmerged flow
        if ($row['Form'] == 2){
            $HWD = $row['K']*($par**$row['M']);
        } else {
            $dc = $yc; 
            $pp = partialparameters($pipe,$dc);
            $Adc = 10.764 * $pp[0]; // Convert area to imperial
            $vc = $Q/$Adc;
            $Hc = ($dc * (1/0.3048)) + (($vc**2)/(2*32.17405)); // Convert critical depth to imperial
            $HWD = ($Hc/$D) + ($row['K']*($par**$row['M'])) - (0.5*$S);
        }
        if ($HWD * $pipe->geth() > $yc){
            $HW = $HWD * $pipe->geth();
        } else {
            $HW = $yc;
        }
        
    } else if ($par > 4) {
        $ft = "Submerged";
        // Submerged flow
        $HWD = $row['CS']*($par**2) + $row['Y'] - (0.5*$S);
        $HW = $HWD * $pipe->geth();
    } else {
        $ft = "Transitional";
        // Transitional flow
        $x1 = 3.5;
        $x2 = 4;
        
        if ($row['Form'] == 2){
            $y1 = $row['K']*($x1**$row['M']);
        } else {
            $dc = $pipe->getyc(); 
            $pp = partialparameters($pipe,$dc);
            $Adc = 10.764 * $pp[0]; // Convert area to imperial
            $vc = $Q/$Adc;
            $Hc = ($dc * (1/0.3048)) + (($vc**2)/(2*32.17405)); // Convert critical depth to imperial
            $y1 = ($Hc/$D) + ($row['K']*($x1**$row['M'])) - (0.5*$S);
        }
        $y2 = $row['CS']*($x2**2) + $row['Y'] - (0.5*$S);
        $HWD = ((($y2-$y1)/($x2-$x1))*($par-$x1)) + $y1;
        $HW = $HWD * $pipe->geth();

    }
    
    // Save coefficients
    $inlet->setsupcoef(array("par"=>$par,"ft"=>$ft,"Form"=>$row['Form'],"yc"=>$pipe->getyc(),"K"=>$row['K'],"M"=>$row['M'],"CS"=>$row['CS'],"Y"=>$row['Y'],"HW"=>$HW,"HWA"=>$HW+$pipe->getus()));
    
    return $HW;
    
    
    
}

function updateheadwater($pipe,$inlet_fake,$inlet,$Q){
    $he = entranceloss($pipe,$inlet,$Q);
    $wl = $pipe->getk()[0] - $pipe->getus();
    $yc = $pipe->getyc();
    $h = $pipe->geth();
    
    $inlet->sethwt("Outlet Control");
    if ($wl >= $h){
        $inlet_fake->setfull("True");
        $uswl = $pipe->getus() + $wl + $he;
    } else if ($wl <= $yc + 0.001){
        $uswl = supercriticalheadwater($pipe,$inlet,$Q) + $pipe->getus();
        $inlet->sethwt("Inlet Control");
        if ($uswl >= ($pipe->geth()+$pipe->getus())){
             $inlet_fake->setfull("True");
        } else {
            $inlet_fake->setfull("False");
        }
    } else {
        $inlet_fake->setfull("False");
        $uswl = $wl + $pipe->getus() + $he;
    }
    $inlet_fake->setk(array($uswl,$uswl));
    $inlet_fake->setDSwl($uswl);
    $inlet_fake->setUSwl($uswl);
    
    
    return array(supercriticalheadwater($pipe,$inlet,$Q),$wl + $he,$uswl-$pipe->getus());
}

// Create boundary conditions

function createfakeinlet($pipe,$inlet,$Q){
    $inlet_fake = new Generic;
    $inlet_fake->setus($pipe->getus());
    $inlet_fake->setds($pipe->getus());
    $inlet_fake->seth($pipe->geth());
    $inlet_fake->setL(5);
    $inlet_fake->setx(0);
    $inlet_fake->setyc($pipe->getyc());
    $inlet_fake->setsupercritical("False");
    $inlet_fake->setdt(array(0,5));
    updateheadwater($pipe,$inlet_fake,$inlet,$Q);
    return $inlet_fake;
}

function createfakeoutlet($pipe,$outlet,$Q,$TL){
    $outlet_fake = new Generic;
    $outlet_fake->setL(5);
    if ($outlet->getType() == "section"){
        $tailwater = depthmannings($outlet,$Q) + $outlet->getus();
        $outlet_fake->setus($outlet->getus());
        $outlet_fake->setds($outlet->getus());
        $outlet_fake->setUSwl($tailwater);
    } else if ($outlet->getType() == "freedischarge") {
        $tailwater = '';
        $outlet_fake->setus('');
        $outlet_fake->setds('');
        $outlet_fake->setUSwl(min($pipe->getds()+$pipe->getyc(),$pipe->getds()+$pipe->getnormaldepth()));
    } else {
        $tailwater = $outlet->gettailwater();
        $outlet_fake->setus($pipe->getds());
        $outlet_fake->setds($pipe->getds());
        $outlet_fake->setUSwl($tailwater);
    }
    if ($tailwater >= $pipe->getds() + $pipe->geth()){
        $outlet_fake->setfull("True");
        $outlet_fake->setsupercritical("False");
    } else if ($tailwater <= $pipe->getds() + $pipe->getyc()){
        $outlet_fake->setfull("False");
        $outlet_fake->setsupercritical("True");
    } else {
        $outlet_fake->setfull("False");
        $outlet_fake->setsupercritical("False");
    }
    $outlet_fake->setk(array($tailwater,$tailwater));
    $outlet_fake->setdt(array($TL+5,$TL+10));
    $outlet_fake->setx($TL+5);
    $outlet_fake->setyc($pipe->getyc());
    $outlet_fake->seth($pipe->geth());
    
    return $outlet_fake;
}

// Graphing functions

function rapidlyvariedflowpoints($pipes,$Q){
	for ($x = 1; $x < count($pipes)-1; $x++) {
		
		if (strpos($pipes[$x]->getflowcurve(), 'HJ') !== false){
			$US = $pipes[$x]->getHJ_US();
			$US_dt = $US[0];
			$US_k = $US[1];
			$DS = $pipes[$x]->getHJ_DS();
			$DS_dt = $DS[0];
			$DS_k = $DS[1];
			$SQ = $pipes[$x]->getsequent();
			$SQ_dt = $SQ[0];
			$SQ_k = $SQ[1];
			$HGL = $pipes[$x]->getHJ_end();
			$HGL_dt = $HGL[0];
			$HGL_k = $HGL[1];
			$dt = array_unique(array_merge($US_dt,$DS_dt,$SQ_dt,$HGL_dt));
			sort($dt);
			$dt = array_values($dt);
			$us = array();
			$ds = array();
			$sq = array();
			$hgl = array();
			
			for ($i = 0; $i < count($dt); $i++) {
				$us[] = interpolate($dt[$i],$US_dt,$US_k);
				$ds[] = interpolate($dt[$i],$DS_dt,$DS_k);
				$sq[] = interpolate($dt[$i],$SQ_dt,$SQ_k);
				$hgl[] = interpolate($dt[$i],$HGL_dt,$HGL_k);	
			}
			
			$pipes[$x]->setHJ_US(array($dt,$us));
			$pipes[$x]->setHJ_DS(array($dt,$ds));
			$pipes[$x]->setsequent(array($dt,$sq));
			$pipes[$x]->setHJ_end(array($dt,$hgl));
		}
	}
}

function tailwaterprofile($pipes){
	$tw = $pipes[0]->getk();
	$ls = $pipes[1]->getk();
	if ($tw[0] != end($ls)){
		$pipes[0]->setk(array(end($ls),end($tw)));
	}
}

function systemxy($pipes){
    $dtt = array();
    $kt = array();
    $dtb = array();
    $kb = array();
    
    for ($x = 1; $x < count($pipes)-1; $x++) {
        
        $dtb[] = $pipes[$x]->getx();
        $dtb[] = $pipes[$x]->getx() + $pipes[$x]->getL();
        
        $kb[] = $pipes[$x]->getus();
        $kb[] = $pipes[$x]->getds();
        
        $dtt[] = $pipes[$x]->getx();
        
        $dtt[] = $pipes[$x]->getx() + $pipes[$x]->getL();
        $kt[] = $pipes[$x]->getus() + $pipes[$x]->geth();
        $kt[] = $pipes[$x]->getds() + $pipes[$x]->geth();
        
    }
    
    return array($dtb,$kb,$dtt,$kt);
}

function addplotdetails($pipes,$outlet,$Q){
    // Outlet
    $pipes[0]->setv(array(null,null));
    $pipes[0]->setfr(array(null,null));
    $pipes[0]->sett(array(null,null));
    if ($outlet->getType() == "freedischarge"){
        $pipes[0]->setb(array(null,null));
        $pipes[0]->setws(array(null,null));
        $pipes[0]->setk(array(null,null));
    } else {
        $pipes[0]->setb(array($pipes[0]->getus(),$pipes[0]->getds()));
        $pipes[0]->setws($pipes[0]->getk());
    }
        
    // Inlet
    $v = array();
    $fr = array();
    $b = array();
    $t = array();
    $var = end($pipes)->getus() - 0.5;
    for ($i = 0; $i < count(end($pipes)->getdt()); $i++) {
        $v[] = null;
        $fr[] = null;
        $t[] = null;
        $b[] = $var;
    }
    end($pipes)->setv($v);
    end($pipes)->setfr($fr);
    end($pipes)->setb($b);
    end($pipes)->sett($t);
    end($pipes)->setws(end($pipes)->getk());
        
    // Sections    
    for ($j = 1; $j < count($pipes)-1; $j++) {
        $dt = $pipes[$j]->getdt();
        $k = $pipes[$j]->getk();
        $x1 = $pipes[$j]->getx();
        $x2 = $pipes[$j]->getx() + $pipes[$j]->getL();
        $y1 = $pipes[$j]->getus();
        $y2 = $pipes[$j]->getds();
        $h1 = $pipes[$j]->getus() + $pipes[$j]->geth();
        $h2 = $pipes[$j]->getds() + $pipes[$j]->geth();
        $v = array();
        $fr = array();
        $b = array();
        $t = array();
        $ws = array();
        for ($i = 0; $i < count($dt); $i++){
            $b[] = (($dt[$i] - $x1)*(($y2-$y1)/($x2-$x1))) + $y1;
            $t[] = (($dt[$i] - $x1)*(($h2-$h1)/($x2-$x1))) + $h1;
            if ($k[$i] <= $t[$i]){
                $ws[] = $k[$i];
            } else {
                $ws[] = $t[$i];
            }
            $depth = $ws[$i] - $b[$i];
            $pp = partialparameters($pipes[$j],$depth);
            $A = $pp[0];
            if ($A == 0){
                $v[] = null;
                $fr[] = null;
            } else {
                $v[] = $Q/$A;
                $fr[] = froudeno($pipes[$j],$depth,$Q);   
            }
                     
        }
        $pipes[$j]->setv($v);
        $pipes[$j]->setfr($fr);
        $pipes[$j]->setb($b);
        $pipes[$j]->sett($t);
        $pipes[$j]->setws($ws);   
    }
}

function joinprofilereport($pipes){ 
    
    // Outlet
    $pipes[0]->setnda(array(null,null));
    $pipes[0]->setyca(array(null,null));
    
    // Inlet
    $nda = array();
    $yca = array();
    for ($i = 0; $i < count(end($pipes)->getdt()); $i++) {
        $nda[] = null;
        $yca[] = null;
    }
    end($pipes)->setnda($nda);
    end($pipes)->setyca($yca);
    
    // Sections    
    for ($j = 1; $j < count($pipes)-1; $j++) {
        $nda = addarray($pipes[$j]->getb(),$pipes[$j]->getnormaldepth());
        $yca = addarray($pipes[$j]->getb(),$pipes[$j]->getyc());
        $pipes[$j]->setnda($nda);
        $pipes[$j]->setyca($yca);    
    }
    
    $pipes = array_reverse($pipes);
    $dt = array();
    $k = array();
    $v = array();
    $fr = array();
    $b = array();
    $t = array();
    $ws = array();
    $nd = array();
    $yc = array();
    for ($x = 0; $x < count($pipes); $x++){
        $dt = array_merge($dt,$pipes[$x]->getdt());
        $k = array_merge($k,$pipes[$x]->getk());
        $v = array_merge($v,$pipes[$x]->getv());
        $fr = array_merge($fr,$pipes[$x]->getfr());
        $b = array_merge($b,$pipes[$x]->getb());
        $t = array_merge($t,$pipes[$x]->gett());
        $ws = array_merge($ws,$pipes[$x]->getws());
        $nd = array_merge($nd,$pipes[$x]->getnda());  
        $yc = array_merge($yc,$pipes[$x]->getyca());
        
    }
    
     $dt = addarray($dt,-5); // Remove false 5m from left
    
    return  array('dt' => $dt, 'k' => $k, 'v' => $v, 'fr' => $fr, 'b' => $b, 't' => $t, 'ws' => $ws, 'nd' => $nd, 'yc' => $yc);
}

function joinprofile($pipes){
    $pipes = array_reverse($pipes);
    $dt = array();
    $k = array();
    $v = array();
    $fr = array();
    $b = array();
    $t = array();
    $ws = array();
    for ($x = 0; $x < count($pipes); $x++){
        $dt = array_merge($dt,$pipes[$x]->getdt());
        $k = array_merge($k,$pipes[$x]->getk());
        $v = array_merge($v,$pipes[$x]->getv());
        $fr = array_merge($fr,$pipes[$x]->getfr());
        $b = array_merge($b,$pipes[$x]->getb());
        $t = array_merge($t,$pipes[$x]->gett());
        $ws = array_merge($ws,$pipes[$x]->getws());   
    }
     $dt = addarray($dt,-5); // Remove false 5m from left
    return  array('dt' => $dt, 'k' => $k, 'v' => $v, 'fr' => $fr, 'b' => $b, 't' => $t, 'ws' => $ws);
}

function summarytable($pipes){
    $pipes = array_reverse($pipes);
    $summary = array();
    for ($x = 1; $x < (count($pipes)-1); $x++){
        $ppt = $pipes[$x]->getType();
        $ppl = $pipes[$x]->getL();
        $ppnd = $pipes[$x]->getnormaldepth();
        $ppyc = $pipes[$x]->getyc();
        $pph = $pipes[$x]->geth();
        $ppsc = $pipes[$x]->getsupercritical();
        $fc = $pipes[$x]->getflowcurve();
        $ppfull = $pipes[$x]->getfull();
        if ($ppfull == "True"){
            $Slope = 'Pipe Full';
        } else if ($ppsc == "True"){
            $Slope = 'Steep';
        } else {
            $Slope = 'Mild';
        }
        $summary[(string)$x] = array('Type' => $ppt, 'Length' => $ppl, 'normaldepth' => $ppnd, 'criticaldepth' => $ppyc, 'h' => $pph, 'Slope' => $Slope, 'flowcurve'=>$fc);
    }
    return $summary;
}

function soffitintersect($pipe,$out){
    $dt = $out[0];
    $k = $out[1];
    $m1 = ((end($k) - $k[count($k)-2])/(end($dt) - $dt[count($dt)-2]));
    $c1 = end($k) - ($m1*end($dt));
    $m2 = (($pipe->getds() - $pipe->getus())/($pipe->getL()));
    $c2 =  ($pipe->getus() + $pipe->geth()) - ($m2*$pipe->getx());
    $x = (($c2 - $c1)/($m1 - $m2));
    $y = ($m1*$x) + $c1;
    $dta = array($dt[0]);
    $ka = array($k[0]);
    $param = 0;
    for($i = 1; $i < count($dt); ++$i) {
        if ($param == 0 and $dt[$i] > $x){
            $dta[] = $x;
            $ka[] = $y;
            $param = 1;
        }
        $dta[] = $dt[$i];
        $ka[] = $k[$i];
    } 
    return array($dta,$ka);
}

function soffitintersectHJ($pipe,$out){
    $dt = $out[0];
    $k = $out[1];
    $dtf = array($dt[0]);
    $kf = array($k[0]);
    $stop = 0;
    
    for($i = 1; $i < count($dt); ++$i) {        
        if ($k[$i] > $pipe->geth() and $stop == 0){
            $m1 = (($k[$i] - $k[$i-1])/($dt[$i] - $dt[$i-1]));
            $c1 = $k[$i] - ($m1*$dt[$i]);
            $x = (($pipe->geth() - $c1)/($m1));
            $y = ($m1*$x) + $c1;
            
            $dtf[] = $x;
            $kf[] = $y;

            $stop = 1;
        }
        $dtf[] = $dt[$i];
        $kf[] = $k[$i];
    }
    return array($dtf,$kf);
}

function headwatercurve($pipes){
    if ($pipes[count($pipes)-2]->getk()[0] < $pipes[count($pipes)-2]->getus() + $pipes[count($pipes)-2]->geth()){
        if ($pipes[count($pipes)-2]->getsupercritical() == "True"){
            $kin = $pipes[count($pipes)-2]->getk();
            $dtin = $pipes[count($pipes)-2]->getdt();
            $m = ($kin[1]-$kin[0])/($dtin[1]-$dtin[0]);
            $c = $kin[0] - ($m * $dtin[0]);
            $h1 = $pipes[count($pipes)-2]->getk()[0];
            $h2 = end($pipes)->getk()[0];
            $x = ($h2 - $c)/$m;
            end($pipes)->setdt(array(0,$x,5));
            end($pipes)->setk(array($h2,$h2,$h1));
        } else {
            $h1 = $pipes[count($pipes)-2]->getk()[0];
            $h2 = end($pipes)->getk()[0];
            end($pipes)->setdt(array(0,4.5,5));
            end($pipes)->setk(array($h2,$h2,$h1));
        }
    }    
}

?>