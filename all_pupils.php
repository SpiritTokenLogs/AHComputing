<?php
  // Start a session to persist user data
  session_start();

  // If the user is not logged in as an admin, redirect them to the dashboard
  if($_SESSION['isAdmin'] != 1) {
    header("Location: dashboard.php");
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
  
  // Query the database to get all the pupil data
  $sql = "SELECT * FROM Pupil";
  $result = mysqli_query($conn, $sql);
?>

<html>
    <head>
        <title>Pupils</title>
        
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
                <a class="nav-item nav-link" href="all_damages.php">Damages</a>

                <!-- If user is an admin, display links to view all teachers and pupils -->
                <?php
                    if($_SESSION['isAdmin'] == 1) {
                        echo '<a class="nav-item nav-link" href="all_teachers.php">Teachers</a>';
                        echo '<a class="nav-item nav-link active" href="all_pupils.php">Pupils</a>';
                    }
                ?>

                <!-- Log out link -->
                <a class="nav-item nav-link" href="logout.php">Log Out</a>
            </div>
        </nav>
        <br>
        <h1>All Pupils</h1>

        <!-- Table to display pupils information -->
        <div class=tbl">
            <table class="table table-striped table-bordered table-hover table-sm">
                <thead>
                    <!-- Table headings -->
                    <td scope="col">PupilID</td>
                    <td scope="col">Email</td>
                    <td scope="col">Password</td>
                    <td scope="col">Name</td>
                    <td scope="col">House</td>
                    <td scope="col">Year</td>
                    <td scope="col">Control</td>
                </thhead>
                <tbody>
                    <?php
                        // Loop through each row of results returned by the SQL query and output them in the table
                        while($row = mysqli_fetch_array($result)) {
                            echo "<tr>
                                <td>".$row['pupilID']."</td>
                                <td>".$row['email']."</td>
                                <td>".$row['password']."</td>
                                <td>".$row['forename'].' '.$row['surname']."</td>
                                <td>".$row['house']."</td>
                                <td>".$row['year']."</td>
                                display a button to delete the damage report
                                <td>
                                    <div style='display:flex'>
                                        <form action='delete_pupil.php' method='GET'>
                                            <button class='my-button btn btn-default' value='".$row['pupilID']."' type='submit' name='pupilID'>
                                                <img src='trash.svg'/>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>