<?php
session_start();

if (isset($_SESSION["report_session"])){
	echo json_encode($_SESSION["report_session"]);
} else {
    echo 'Fail';
}
?>