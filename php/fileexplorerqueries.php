<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$username = $_SESSION["user"];
$input = $_POST['query'];
array_push($input[1],$username);
$allowable = ['SELECT * FROM folder where id = ? AND User = ?;',
              'UPDATE folder SET Parent = ? WHERE id = ? AND User = ?;',
              'SELECT * FROM folder where Parent = ? AND User = ?;',
              'SELECT * FROM folder where id = ? AND User = ?;',
              'UPDATE folder SET Name = ? WHERE id = ? AND User = ?;',
              'UPDATE folder SET Description = ? WHERE id = ? AND User = ?;',
              "INSERT INTO `folder` (`id`, `Name`, `Parent`, `Type`, `Description`, `User`) VALUES (NULL, ?, ?, ?, ?, ?);"];
 
if (in_array($input[0],$allowable)){
    include("db.php");
    $sql = $conn->prepare($input[0]);
    if (count($input) == 2) {
        $sql->bind_param(str_repeat("s",count($input[1])), ...$input[1]);
		$sql->execute();
		$sql->store_result();
		$out = [];
		while($row = fetchAssocStatement($sql))
			{
				array_push($out,$row);
			}
		echo json_encode($out);

		$conn->close();
    }
}    

?>
