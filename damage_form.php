<?php
	// Start a session to persist user data
	session_start();
	
	// If the user is not logged in as a pupil, redirect them to the login page
	if(!(isset($_SESSION['email']))) {
		header("Location: pupil_login.php");
	}

	// Get user data from the session
	$email = $_SESSION['email'];
	$forename = $_SESSION['forename'];
	$surname = $_SESSION['surname'];
	$pupilID = $_SESSION['pupilID'];

	// Connect to the database
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

		<!-- Include custom stylesheet -->
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
				
				<label for="toilet">Which Toilet?</label>
				<select
					name="toilet"
					id="toilet"
					required>
						<option selected hidden disabled>Please select a toilet</option>>
						<option value="boys">Boys</option>
						<option value="girls">Girls</option>
						<option value="senior_boys">Senior Boys</option>
						<option value="senior_girls">Senior Girls</option>
				</select>

				<label for="report">Description of Damage</label>
				<textarea
						name="report"
						id="report"
						placeholder="Please give some details"
						required
						style="overflow:auto; resize:none" 
						rows="5" 
						cols="20"
						></textarea>

				<br>

				<button type="submit" value="submit" name="submit">Submit</button>
			</div>
				<?php
					$sql = "INSERT INTO Damages (dateTime, toilet, report, pupilID) VALUES (NOW(), '".$_POST['toilet']."', '".$_POST['report']."', $pupilID)";
					$submit = mysqli_query($conn, $sql);
				?>
			<div>
				<!-- Log out link -->
				<p> <a href="logout.php">Log Out</a> <br> <a href="leave_formm.php">Submit a Leave</a> </p>
			</div>
		</form>
	</body>
</html>