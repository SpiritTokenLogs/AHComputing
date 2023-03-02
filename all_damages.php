<?php
  // Start a session to persist user data
  session_start();
  
  // If the user is not logged in as an admin, redirect them to the dashboard
  if(!(isset($_SESSION['teacherID']))) {
    header("Location: teacher_login.php");
  }

  // Get user data from the session
  $email = $_SESSION['email'];
  $forename = $_SESSION['forename'];
  $surname = $_SESSION['surname'];

  // Connect to the database
  $servername = "localhost";
  $database = "logdb";
  $username = "username";
  $password = "Password";
    
  $conn = new mysqli($servername, $username, $password, $database);
  if ($conn -> connect_error) {
      die('Connection failed: ' .$conn -> connect_error);
  }

  // Query the database to get all damages and their associated pupil data
  $sql = "SELECT damageID, report, Damages.PupilID, Pupil.pupilID, dateTime, toilet, Pupil.forename, Pupil.surname FROM Damages, Pupil WHERE Pupil.PupilID = Damages.PupilID;";
  $result = mysqli_query($conn, $sql);
?>

<html>
    <head>
        <title>Damages</title>
        
        <!-- Include custom stylesheet -->
        <link rel="stylesheet" href="styles.css">
        
        <!-- Include Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    
        <!-- Navigation bar -->
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <div class="navbar-nav">
                
                <!-- Display user's forename and surname -->
                <a class="nav-item nav-link disabled" href="#"><?php echo 'Welcome ' .$forename. ' ' .$surname; ?></a>
                
                <!-- Navigation links -->
                <a class="nav-item nav-link" href="dashboard.php">Home</a>
                <a class="nav-item nav-link active" href="damages.php">Damages</a>
                
                <!-- If user is an admin, display links to view all teachers and pupils -->
                <?php
                    if($_SESSION['isAdmin'] == 1) {
                        echo '<a class="nav-item nav-link" href="all_teachers.php">Teachers</a>';
                        echo '<a class="nav-item nav-link" href="all_pupils.php">Pupils</a>';
                    }
                ?>
                
                <!-- Log out link -->
                <a class="nav-item nav-link" href="logout.php">Log Out</a>
            </div>
        </nav>
        
        <br>
        <h1>All Damages</h1>
        
        <!-- Table to display damages information -->
        <div class=tbl">
            <table class="table table-striped table-bordered table-hover table-sm">
                <thead>
                    <!-- Table headings -->
                    <td scope="col">DamageID</td>
                    <td scope="col">Date & Time</td>
                    <td scope="col">Pupil</td>
                    <td scope="col">Report</td>
                    <td scope="col">Toilet</td>
                    <td scope="col">Control</td>
                </thhead>
                <tbody>
                    <?php
                        // Loop through each row of results returned by the SQL query and output them in the table
                        while($row = mysqli_fetch_array($result)) {
                            echo "<tr>
                                <td>".$row['damageID']."</td>
                                <td>".$row['dateTime']."</td>
                                <td>".$row['forename'].' '.$row['surname']."</td>
                                <td>".$row['report']."</td>
                                <td>".$row['toilet']."</td>";                                        
                                
                                // If user is an admin, display a button to delete the damage report
                                if($_SESSION['isAdmin'] == 1) {
                                    echo "<td>
                                        <div style='display:flex'>
                                            <form action='delete_damage.php' method='GET'>
                                                <button class='my-button btn btn-default' value='".$row['damageID']."' type='submit' name='damageID'>
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