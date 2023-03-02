<?php
    session_start();
  
    if($_SESSION['isAdmin'] != 1) {
      header("Location: admin.php");
    }

    $servername = "localhost";
    $database = "logdb";
    $username = "username";
    $password = "Password";

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn -> connect_error) {
        die('Connection failed: ' .$conn -> connect_error);
    }

    $logID = $_GET['logID'];

    $sql = "DELETE FROM Log WHERE logID=".$logID."";
    $submit = mysqli_query($conn, $sql);

    header("Location: dashboard.php");
?>