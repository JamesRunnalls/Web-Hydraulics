<?php
session_start();
include("db.php");

$id = (int)$_POST['query'];
$username = $_SESSION["user"];

duplicatechildren($id,$username,$conn);

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
        // duplicate selected from array
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

function duplicatechildren($id,$username,$conn){
    $arr = findchildren($id,$username,$conn);
    $arrn = array();
    // duplicate files
    for ($x = 0; $x < count($arr); $x++){
        array_push($arrn,duplicatefile($arr[$x],$username,$conn));
    }
    
    // update parents and copy rest of files
    for ($x = 0; $x < count($arr); $x++){
        
        // Select the new file
        $sql = $conn->prepare('SELECT * FROM folder where id = ? AND User = ?');
        $sql->bind_param('is', $arrn[$x], $username);
        $sql->execute();
        $sql->store_result();
        $out = array();
        while($row = fetchAssocStatement($sql)){
            array_push($out,$row);
        }
        // Check if the parent needs updating
        if (in_array($out[0]['Parent'],$arr)){
            $new_parent = $arrn[array_search($out[0]['Parent'],$arr)];
            $sql = $conn->prepare('UPDATE folder SET Parent = ? WHERE id = ? AND User = ?');
            $sql->bind_param('iis', $new_parent, $arrn[$x], $username);
            $sql->execute();
        }
    }    
}

function duplicatefile($id,$username,$conn){
    $id = (int)$id;
    $sql = $conn->prepare('INSERT into folder(Name, Parent, Type, Description, User) SELECT Name, Parent, Type, Description, User from folder where id = ? AND User = ?;');
    $sql->bind_param('is', $id, $username);
    $sql->execute();
    $sql = $conn->prepare('SELECT LAST_INSERT_ID();');
    $sql->execute();
    $sql->store_result();
    $new_id = (int)fetchAssocStatement($sql)['LAST_INSERT_ID()'];
    $sql = $conn->prepare('SELECT * FROM folder where id = ? AND User = ?');
    $sql->bind_param('is', $new_id, $username);
    $sql->execute();
    $sql->store_result();
    $out = array();
    while($row = fetchAssocStatement($sql)){
        array_push($out,$row);
    }
    if ($out[0]['Type'] != 'folder' and is_string($out[0]['Type'])){
        duplicateotherfiles($id,$new_id,$username,$conn);
    }
    return $new_id;
}

function duplicateotherfiles($id,$idn,$username,$conn){
    // duplicate pipeparameters
    $sql = $conn->prepare('SELECT * FROM pipeparameters where Folderid = ? AND User = ?');
    $sql->bind_param('is', $id, $username);
    $sql->execute();
    $sql->store_result();
    $out = array();
    while($row = fetchAssocStatement($sql)){
        array_push($out,$row);
    }
    
    if (count($out) > 0){
        $query = 'INSERT INTO pipeparameters (Folderid, Name, Value, User) VALUES ';
        for ($x = 0; $x < count($out); $x++){
            $query = $query.'("'.$idn.'","'.$out[$x]['Name'].'","'.$out[$x]['Value'].'","'.$out[$x]['User'].'"),';
        }
        $query = substr($query, 0, -1);
        $query = $query.";";
        $sql = $conn->prepare($query);
        $sql->execute();
    }
    
    // duplicate report parameters
    $sql = $conn->prepare('SELECT * FROM reportparameters where Folderid = ? AND User = ?');
    $sql->bind_param('is', $id, $username);
    $sql->execute();
    $sql->store_result();
    $out = array();
    while($row = fetchAssocStatement($sql)){
        array_push($out,$row);
    }
    
    if (count($out) > 0){
        $query = 'INSERT INTO pipeparameters (Folderid, Name, Value, User) VALUES ';
        for ($x = 0; $x < count($out); $x++){
            $query = $query.'("'.$idn.'","'.$out[$x]['Name'].'","'.$out[$x]['Value'].'","'.$out[$x]['User'].'"),';
        }
        $query = substr($query, 0, -1);
        $query = $query.";";
        $sql = $conn->prepare($query);
        $sql->execute();
    }
    
    // duplicate report logo
    try {
        copy('../img/users/'.$id.'.png','../img/users/'.$idn.'.png');
    } catch (Exception $e){
        echo 'Message: ' .$e->getMessage();    
    }
    
    
    // duplicate report text file
    try {
        copy('../reports/'.$id.'.txt','../reports/'.$idn.'.txt');
    } catch (Exception $e){
        echo 'Message: ' .$e->getMessage();    
    }
    
    // duplicate json files
    try {
        copy('../json/'.$id.'.json','../json/'.$idn.'.json'); 
    } catch (Exception $e){
        echo 'Message: ' .$e->getMessage();    
    }
}

?>