<?php
session_start();
include("db.php");

$id = (int)$_POST['query'];
$username = $_SESSION["user"];

deletechildren($id,$username,$conn);

$conn->close();


function findchildren($id,$username,$conn){
    $to_search = array($id);
    $searched = array();
    $x = 0;
    while (count($to_search) > 0 and $x < 10){
        $x = $x + 1;
        // Select id from to_search
        $search_id = (int)$to_search[0];
        // Add to searched array
        array_push($searched,$search_id);
        // Delete selected from array
        unset($to_search[0]);
        $sql = $conn->prepare('SELECT * FROM folder where Parent = ? AND User = ?');
        $sql->bind_param('is', $search_id, $username);
        $sql->execute();
        $sql->store_result();
        while($row = fetchAssocStatement($sql)){
            array_push($to_search,$row['id']);
        }
        $to_search = array_values($to_search);
        
    }
    return $searched;
}

function deletechildren($id,$username,$conn){
    $arr = findchildren($id,$username,$conn);
    // Delete files
    for ($x = 0; $x < count($arr); $x++){
        $sql = $conn->prepare('SELECT * FROM folder where id = ? AND User = ?');
        $sql->bind_param('is', $arr[$x], $username);
        $sql->execute();
        $sql->store_result();
        $out = array();
        while($row = fetchAssocStatement($sql)){
            array_push($out,$row);
        }
        if ($out[0]['Type'] == 'folder'){
            deletefolder($arr[$x],$username,$conn);
        } else if (is_string($out[0]['Type'])){
            print_r($arr[$x]);
            deletefile($arr[$x],$username,$conn);
        }
    } 
}

function deletefolder($id,$username,$conn){
    $id = (int)$id;
    $sql = $conn->prepare("DELETE FROM folder WHERE folder.id = ? AND User = ?;");
    $sql->bind_param('is', $id, $username);
    $sql->execute();        
}

function deletefile($id,$username,$conn){
    $id = (int)$id;
    // Delete from folder
    $sql = $conn->prepare("DELETE FROM folder WHERE folder.id = ? AND User = ?;");
    $sql->bind_param('is', $id, $username);
    $sql->execute();
    
    // Delete from pipeparameters
    $sql = $conn->prepare("DELETE FROM pipeparameters WHERE pipeparameters.id = ? AND User = ?;");
    $sql->bind_param('is', $id, $username);
    $sql->execute();
    
    // Delete from report parameters
    $sql = $conn->prepare("DELETE FROM reportparameters WHERE reportparameters.id = ? AND User = ?;");
    $sql->bind_param('is', $id, $username);
    $sql->execute();
    
    
    // Delete report logo
    try {
        unlink('../img/users/'.$id.'.png');
    } catch (Exception $e){
        echo 'Message: ' .$e->getMessage();    
    }
    
    
    // Delete report text file
    try {
        unlink('../reports/'.$id.'.txt');
    } catch (Exception $e){
        echo 'Message: ' .$e->getMessage();    
    }
    
    // Delete json files
    try {
        unlink('../json/'.$id.'.json'); 
    } catch (Exception $e){
        echo 'Message: ' .$e->getMessage();    
    }
}

?>