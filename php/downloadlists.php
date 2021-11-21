<?php

include("db.php");


$arr = array(
    "shape" => "SELECT * FROM shapes",
    "manningsn" => "SELECT * FROM manningsn",
    "transition" => "SELECT * FROM transition",
    "roughness" => "SELECT * FROM roughness",
    "minorloss" => "SELECT * FROM minorloss",
    "inlet" => "SELECT * FROM inletcontrolcoefficients"
);

$all = array();

foreach ($arr as $key => $value) {
    $sql = $conn->prepare($value);
    $sql->execute();
    $sql->store_result();
    $out = [];
    while($row = fetchAssocStatement($sql))
        {
            array_push($out,$row);
        }
    $all[$key] = $out;   
}

echo json_encode($all);
$conn->close();
?>