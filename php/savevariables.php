<?php
// Start session

include("db.php");

// Get User
if (isset($_SESSION['user'])){
    $username = $_SESSION['user'];
    // Get calculation number
	
    $Folderid = $_POST["sessionStorageID"];
    
    // Delete old values
    $sql = $conn->prepare("DELETE FROM pipeparameters WHERE Folderid = ? and User = ?");
    $sql->bind_param('ss', $Folderid, $username);
    $sql->execute();
	
    $var = [];
    foreach($_POST as $Name => $Value){
        $sql = $conn->prepare("INSERT INTO pipeparameters (Folderid,Name,Value,User) VALUES (?,?,?,?);");
        $sql->bind_param('ssss', $Folderid, $Name, $Value, $username);
        $sql->execute();
    }
	
}

?>