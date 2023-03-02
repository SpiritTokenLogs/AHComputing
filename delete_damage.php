<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	session_start();
	
	if($_SESSION['isAdmin'] != 1) {
		header("Location: dashboard.php");
	}

	$servername = "localhost";
	$database = "logdb";
	$username = "username";
	$password = "Password";

	$conn = new mysqli($servername, $username, $password, $database);
	if ($conn -> connect_error) {
			die('Connection failed: ' .$conn -> connect_error);
	}

	$damageID = $_GET['damageID'];

	$sql = "DELETE FROM Damages WHERE damageID=".$damageID."";
	$submit = mysqli_query($conn, $sql);

	header("Location: all_damages.php");
?>