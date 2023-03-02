<?php
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
    <title>Teacher Register</title>

    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <form method ="post">
      <div class="container">
        <h1>Teacher Register</h1>

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
          pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,}$"
          required
        />

        <label for="forename"><b>Forename</b></label>
        <input
          type="text"
          placeholder="Enter Forename"
          name="forename"
          id="forename"
          required
        />

        <label for="surname"><b>Surname</b></label>
        <input
          type="text"
          placeholder="Enter Surname"
          name="surname"
          id="surname"
          required
        />

        <label for="isAdmin"><b>Admin?</b></label>
        <select
          name="isAdmin"
          id="isAdmin"
          required>
            <option selected hidden disabled>Is this Teacher an admin?</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>

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

        <button value="submit" name="submit" type="submit">Register</button>
      </div>

      <?php
        $query = "INSERT INTO Teacher (email, passwword, forename, surname, isAdmin, subject) VALUES ('".$_POST['email']."', '".$_POST['pwd']."', '".$_POST['forename']."', '".$_POST['surname']."', '".$_POST['isAdmin']."', '".$_POST['subject']."')";
        $submit = mysqli_query($conn, $query);
      ?> 

    </form>
  </body>
</html>