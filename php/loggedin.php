<?php
session_start();
if(isset($_SESSION['sig'])){
	echo "True";
} else {
	echo "False";
}
?>