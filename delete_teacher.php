<?php
    session_start();
  
    if($_SESSION['isAdmin'] != 1) {
      header("Location: all_teachers.php");
    }

    $servername = "localhost";
    $database = "logdb";
    $username = "username";
    $password = "Password";

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn -> connect_error) {
        die('Connection failed: ' .$conn -> connect_error);
    }

    $teacherID = $_GET['teacherID'];

    $sql = "DELETE FROM Teacher WHERE teacherID=".$teacherID."";
    $submit = mysqli_query($conn, $sql);

    header("Location: all_teachers.php");
?>