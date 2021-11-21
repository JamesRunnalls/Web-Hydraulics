<?php
session_start();
include("db.php");
$out = [];
$out["user"] = $_SESSION["user"];
$sql = $conn->prepare("SELECT * FROM users WHERE username = ?");
$sql->bind_param('s', $_SESSION['user']);
$sql->execute();
$sql->store_result();
$row = fetchAssocStatement($sql);
$conn->close();
$out["email"] = $row["email"];
echo json_encode($out);
?>