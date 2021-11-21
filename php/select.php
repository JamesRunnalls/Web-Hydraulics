<?php

include("db.php");

// import username

// select data

$input = $_POST['query'];

if (count($input) == 1){
    if ($input[0] == "shapes"){
        $sql = $conn->prepare("SELECT * FROM shapes");
    } else if ($input[0] == "transition"){
        $sql = $conn->prepare("SELECT * FROM transition");
    } else if ($input[0] == "manningsn"){
        $sql = $conn->prepare("SELECT * FROM manningsn");
    } else if ($input[0] == "roughness"){
        $sql = $conn->prepare("SELECT * FROM roughness");
    } else if ($input[0] == "minorloss"){
        $sql = $conn->prepare("SELECT * FROM minorloss");
    }    
} else if (count($input) == 2){
    if ($input[0] == "inletcontrolcoefficients"){
        $sql = $conn->prepare("SELECT * FROM inletcontrolcoefficients WHERE inlettype = ?");
        $sql->bind_param('s', $input[1]);
    } else if ($input == "manningsn"){
        $sql = $conn->prepare("SELECT * FROM manningsn WHERE Detail = ?");
        $sql->bind_param('s', $input[1]);
    } else if ($input == "roughness"){
        $sql = $conn->prepare("SELECT * FROM roughness WHERE Detail = ?");
        $sql->bind_param('s', $input[1]);
    } else if ($input[0] == "minorloss"){
        $sql = $conn->prepare("SELECT * FROM minorloss WHERE Detail = ?");
        $sql->bind_param('s', $input[1]);
    }    
} 

$sql->execute();
$sql->store_result();
$out = [];
while($row = fetchAssocStatement($sql))
    {
        array_push($out,$row);
    }
echo json_encode($out);

$conn->close();
?>
