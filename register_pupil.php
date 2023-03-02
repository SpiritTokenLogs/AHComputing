<html>
  <head>
    <title>Register</title>

    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <form method ="post">
      <div class="container">
        <h1>Register</h1>

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

        <label for="house"><b>House group</b></label>
        <select
          name="house"
          id="house"
          required>
            <option selected hidden disabled>Please select your House group</option>
            <option value="arran">Arran</option>
            <option value="lewis">Lewis</option>
            <option value="mull">Mull</option>
            <option value="skye">Skye</option>
        </select>

        <label for="year"><b>Year group</b></label>
        <select
          name="year"
          id="year"
          required>
            <option selected hidden disabled>Please select your Year group</option>
            <option value="s1">S1</option>
            <option value="s2">S2</option>
            <option value="s3">S3</option>
            <option value="s4">S4</option>
            <option value="s5">S5</option>
            <option value="s6">S6</option>
        </select>

        <button value="submit" name="submit" type="submit">Register</button>
      </div>
      <div>
        <p>Already have an account? <a href="pupil_login.php">Log in</a>.</p>
      <div>
      <div>
        <p>
          Password Must Include at Least: <br>
          1 lowercase letter <br>
          1 uppoercase letter <br>
          1 number <br>
          1 special character <br>
          8 characters
        </p>
      </div>

      <?php
        $servername = "localhost";
        $database = "logdb";
        $username = "username";
        $password = "Password";

        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn -> connect_error) {
          die('Connection failed: ' .$conn -> connect_error);
        }

        $query = "SELECT email FROM Pupil WHERE email=$email";
        $result = mysqli_query($conn, $query);
        $rows = mysqli_num_rows($result);
        $row = mysqli_fetch_array($result);
        
        if ($rows == 1) {
          echo '<h1> Email already in use </h1>';
        } else {
          $query = "INSERT INTO Pupil (email, password, forename, surname, house, year) VALUES ('".$_POST['email']."', '".$_POST['pwd']."', '".$_POST['forename']."', '".$_POST['surname']."', '".$_POST['house']."', '".$_POST['year']."')";
          $submit = mysqli_query($conn, $query);
        }
      ?>
    </form>
  </body>
</html>