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

  // Query the database to get all the teacher data
  $sql = "SELECT * FROM Teacher";
  $result = mysqli_query($conn, $sql);
?>

<html>
    <head>
        <title>Teachers</title>

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

                <!-- If user is an admin, display links to view all teachers, pupils and add a teacher -->
                <?php
                    if($_SESSION['isAdmin'] == 1) {
                        echo '<a class="nav-item nav-link active" href="all_teachers.php">Teachers</a>';
                        echo '<a class="nav-item nav-link" href="all_pupils.php">Pupils</a>';
                        echo '<a class="nav-item nav-link" href="register_teacher.php">Add a Teacher</a>';
                    }
                ?>

                <!-- Log out link -->
                <a class="nav-item nav-link" href="logout.php">Log Out</a>
            </div>
        </nav>
        <br>
        <h1>All Teachers</h1>

        <!-- Table to display teacher information -->
        <div class=tbl">
            <table class="table table-striped table-bordered table-hover table-sm">
                <thead>
                    <!-- Table headings -->
                    <td scope="col">TeacherID</td>
                    <td scope="col">Email</td>
                    <td scope="col">Password</td>
                    <td scope="col">Name</td>
                    <td scope="col">Admin?</td>
                    <td scope="col">Subject</td>
                    <td scope="col">Control</td>
                </thhead>
                <tbody>
                    <?php
                        // Loop through each row of results returned by the SQL query and output them in the table
                        while($row = mysqli_fetch_array($result)) {
                            echo "<tr>
                                <td>".$row['teacherID']."</td>
                                <td>".$row['email']."</td>
                                <td>".$row['passwword']."</td>
                                <td>".$row['forename'].' '.$row['surname']."</td>";
                                if($row['isAdmin']) { echo '<td>Yes</td>';} else {echo '<td>No</td>';};
                            echo "
                                <td>".$row['subject']."</td>
                                <td>
                                    <div style='display:flex'>
                                        <form action='delete_teacher.php' method='GET'>
                                            <button class='my-button btn btn-default' value='".$row['teacherID']."' type='submit' name='teacherID'>
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
