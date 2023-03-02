<?php
    session_start();

    if(isset($_SESSION['teacherID'])) {
        session_destroy();
        header('Location: teacher_login.php');
        exit;
    } elseif(isset($_SESSION['email'])) {
        session_destroy();
        header('Location: .pupil_login.php');
        exit; 
    }
?>