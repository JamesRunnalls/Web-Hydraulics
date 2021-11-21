<?php
// Start session

include("db.php");

// Get User

if (isset($_SESSION['user'])){
    $username = $_SESSION['user'];
    // Get calculation number
    $Folderid = $_POST["sessionStorageID2"];

    // Delete old values
    $sql = $conn->prepare("DELETE FROM reportparameters WHERE Folderid = ? and User = ?");
    $sql->bind_param('ss', $Folderid, $username);
    $sql->execute();


    // Save all form variables to session
    $var = [];
    foreach($_POST as $Name => $Value){
        $sql = $conn->prepare("INSERT INTO reportparameters (Folderid,Name,Value,User) VALUES (?,?,?,?);");
        $sql->bind_param('ssss', $Folderid, $Name, $Value, $username);
        $sql->execute();
    }

}

?>