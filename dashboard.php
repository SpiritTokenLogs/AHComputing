<?php
  session_start();
  
  if(!(isset($_SESSION['teacherID']))) {
    header("Location: teacher_login.php");
  }

  $email = $_SESSION['email'];
  $forename = $_SESSION['forename'];
  $surname = $_SESSION['surname'];

  $servername = "localhost";
  $database = "logdb";
  $username = "username";
  $password = "Password";
    
  $conn = new mysqli($servername, $username, $password, $database);
    if ($conn -> connect_error) {
        die('Connection failed: ' .$conn -> connect_error);
    }

  $sql = "SELECT logID, dateTime, Log.subject, Pupil.forename, Pupil.surname, Teacher.forename AS Tforename, Teacher.surname AS Tsurname FROM Log, Pupil, Teacher WHERE Pupil.PupilID = Log.PupilID AND Teacher.teacherID = Log.teacherID;";
  $result = mysqli_query($conn, $sql);
?>

<html>
    <head>
        <title>Dashboard</title>
        
        <link rel="stylesheet" href="styles.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <div class="navbar-nav">
                <a class="nav-item nav-link disabled" href="#"><?php echo 'Welcome ' .$forename. ' ' .$surname; ?></a>
                <a class="nav-item nav-link active" href="dashboard.php">Home</a>
                <a class="nav-item nav-link" href="all_damages.php">Damages</a>
                <?php
                    if($_SESSION['isAdmin'] == 1) {
                        echo '<a class="nav-item nav-link" href="all_teachers.php">Teachers</a>';
                        echo '<a class="nav-item nav-link" href="all_pupils.php">Pupils</a>';
                    }
                ?>
                <a class="nav-item nav-link" href="logout.php">Log Out</a>
            </div>
        </nav>
        <br>
        <h1>All Leaves</h1>
        <div class=tbl">
            <table class="table table-striped table-bordered table-hover table-sm">
                <thead>
                    <td scope="col">LogID</td>
                    <td scope="col">Date & Time</td>
                    <td scope="col">Subject</td>
                    <td scope="col">Pupil</td>
                    <td scope="col">Teacher</td>
                    <?php 
                        if($_SESSION['isAdmin'] == 1] {
                            echo "<td scope="col">Teacher</td>
                        }
                    ?>
                    <td scope="col">Control</td>
                </thhead>
                <tbody>
                    <?php
                        while($row = mysqli_fetch_array($result)) {
                            echo "<tr>
                                <td>".$row['logID']."</td>
                                <td>".$row['dateTime']."</td>
                                <td>".$row['subject']."</td>
                                <td>".$row['forename'].' '.$row['surname']."</td>
                                <td>".$row['Tforename'].' '.$row['Tsurname']."</td>";
                                if($_SESSION['isAdmin'] == 1) {
                                    echo "<td>
                                        <div style='display:flex'>
                                            <form action='delete_log.php' method='GET'>
                                                <button class='my-button btn btn-default' value='".$row['logID']."' type='submit' name='logID'>
                                                    <img src='trash.svg'/>
                                                </button>
                                            </form>
                                        </div>
                                    </td>";
                                }
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
