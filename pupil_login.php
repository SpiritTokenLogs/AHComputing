<?php
  session_start();

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
    <title>Log in</title>

    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <form method="POST">
      <div class="container">
        <h1>Log in</h1>

        <!--
          EMAIL
          The 'pattern' attribute uses Regex to ensure the email ends in "@glow.sch.uk"
        -->
        <label for="email"><b>Email</b></label> 
        <input
          type="email"
          placeholder="Enter Email"
          name="email"
          id="email"
          pattern="^\w+([-+.']\w+)*@glow.sch.uk"
          required
        />

        <!--
          Password
          The 'pattern' attribute uses Regex to ensure the password has:
              At least 1 lowercase letter
              At least 1 uppercase letter
              At least 1 number
              At least 1 special character
              A minimum of 8 characters
        -->
        <label for="pwd"><b>Password</b></label>
        <input
          type="password"
          placeholder="Enter Password"
          name="pwd"
          id="pwd"
          required
        />
        <!-- pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,}$" -->

        <button type="submit" value="submit" name="submit">Login</button>
      </div>
      <?php
        if (isset($_POST['submit'])) {
          $email = $_POST['email'];
          $password = $_POST['pwd'];

          $query = "SELECT * FROM `Pupil` WHERE email='$email' AND password='$password'";

          $result = mysqli_query($conn, $query);
          $rows = mysqli_num_rows($result);
          $row = mysqli_fetch_array($result);
          if ($rows == 1) {
            $_SESSION['email'] = $email;
            $_SESSION['forename'] = $row['forename'];
            $_SESSION['surname'] = $row['surname'];
            $_SESSION['pupilID'] = $row['pupilID'];
            header("Location: leave_form.php");
          }
        }
      ?>
      <div>
        <p>Don't have an account? <a href="register_pupil.php">Sign up</a>.</p>
      </div>
    </form>
  </body>
</html>