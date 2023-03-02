<?php
  session_start();
  
  if(!(isset($_SESSION['email']))) {
    header("Location: pupil_login.php");
  }

  $email = $_SESSION['email'];
  $forename = $_SESSION['forename'];
  $surname = $_SESSION['surname'];
  $pupilID = $_SESSION['pupilID'];

  $servername = "localhost";
  $database = "logdb";
  $username = "username";
  $password = "Password";
    
  $conn = new mysqli($servername, $username, $password, $database);
    if ($conn -> connect_error) {
        die('Connection failed: ' .$conn -> connect_error);
    }
?>

<html>
  <head>
    <title>Leave</title>

    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <form method="POST">
      <div class="container">
        <h1>Please enter details below</h1>

        <label for="email"><b>Email</b></label> 
        <input
          type="text"
          placeholder="<?php echo $email; ?>"
          name="email"
          id="email"
  
        />

        <label for="forename"><b>Forename</b></label>
        <input
          type="text"
          placeholder="<?php echo $forename; ?>"
          name="forename"
          id="forename"
          disabled
        />

        <label for="surname"><b>Surname</b></label>
        <input
          type="text"
          placeholder="<?php echo $surname; ?>"
          name="surname"
          id="surname"
          disabled
        />

        <label for="subject"><b>Subject</b></label>
        <select
          name="subject"
          id="subject"
          required>
            <option selected hidden disabled>Please select the subject</option>
              <?php
                $sql = "SELECT DISTINCT subject FROM `Teacher` ORDER BY subject ASC";
                $all_subjects = mysqli_query($conn,$sql);

                while ($subject = mysqli_fetch_array(
                  $all_subjects,MYSQLI_ASSOC)):;
              ?>
              <option value="<?php echo $subject["subject"];?>"><?php echo $subject["subject"]?></option>
              <?php
                endwhile;
              ?>
        </select>

        <label for="teacher"><b>Teacher</b></label>
        <select
          name="teacher"
          id="teacher"
          required>
            <option selected hidden disabled>Please select a teacher</option>
              <?php
                $sql = "SELECT * FROM `Teacher` ORDER BY subject ASC";
                $all_teachers = mysqli_query($conn,$sql);

                while ($teacher = mysqli_fetch_array(
                  $all_teachers,MYSQLI_ASSOC)):;
              ?>
              <option value="<?php echo $teacher["teacherID"];?>"><?php echo $teacher["forename"].' '.$teacher["surname"]?></option>
              <?php
                endwhile;
              ?>
        </select>

        <button type="submit" value="submit" name="submit">Submit</button>
      </div>
        <?php
          $sql = "INSERT INTO Log (dateTime, subject, pupilID, teacherID) VALUES (NOW(), '".$_POST['subject']."', $pupilID, '".$_POST['teacher']."')";
          $submit = mysqli_query($conn, $sql);
        ?>
      <div>
        <p> <a href="logout.php">Log Out</a> <br> <a href="damages.php">Report a Damage</a> </p>
      </div>
    </form>
  </body>
</html>