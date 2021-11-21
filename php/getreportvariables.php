<?php
// Start session
session_start();
include("db.php");

// Get User
if (isset($_SESSION['user'])){
    $username = $_SESSION['user'];
} else {
    $username = "None";
}

// Get folder id
$folderid = $_POST["sessionid"];


// Select rows from database
$sql = $conn->prepare("SELECT * FROM reportparameters WHERE User = ? and Folderid = ?");
$sql->bind_param('ss', $username, $folderid);
$sql->execute();
$sql->store_result();
$var = [];
while($row = fetchAssocStatement($sql))
    {
        $var[$row['Name']] = $row['Value'];
    }

echo json_encode($var);

?>