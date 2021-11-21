<?php
// Start session
session_start();
include("db.php");

function multipleinputs($var,$name){
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

function multipleinputslevel2($var,$name){
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

// Get User
if (isset($_SESSION['user'])){
    $username = $_SESSION['user'];
} else {
    $username = "None";
}

// Get folder id
$folderid = $_POST["sessionid"];


// Select rows from database
$sql = $conn->prepare("SELECT * FROM pipeparameters WHERE User = ? and Folderid = ?");
$sql->bind_param('ss', $username, $folderid);
$sql->execute();
$sql->store_result();
$var = [];
while($row = fetchAssocStatement($sql))
    {
        $var[$row['Name']] = $row['Value'];
    }

// Only for pipeflow
if (isset($var['InputType'])){
	// Save the length of the main form to session
	$var["Length"] = count(multipleinputs($var,"Type"));

	// Need to add the selected values as an array.
	$var["TYP"] = multipleinputs($var,"Type");
	$var["DST"] = multipleinputs($var,"dstransition");
	$var["MAN"] = multipleinputs($var,"manningslist");
	$var["RGH"] = multipleinputs($var,"colebrooklist");
	$var["MLT"] = multipleinputslevel2($var,"mltype");
}

echo json_encode($var);

?>