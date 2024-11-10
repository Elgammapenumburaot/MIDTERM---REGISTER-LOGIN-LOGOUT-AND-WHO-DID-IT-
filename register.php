<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register</title>
	<link rel="stylesheet" href="register.css"> <!-- Link to external CSS file -->
</head>
<body>
	<div class="form-container">
		<?php  
		if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
			if ($_SESSION['status'] == "200") {
				echo "<h1 style='color: green;'>{$_SESSION['message']}</h1>";
			} else {
				echo "<h1 style='color: red;'>{$_SESSION['message']}</h1>";	
			}
		}
		unset($_SESSION['message']);
		unset($_SESSION['status']);
		?>
		
		<form action="core/handleForms.php" method="POST">
			<h1>Sign up Here!</h1>
			<p>
				<label for="username">Username</label>
				<input type="text" name="username" required>
			</p>
			<p>
				<label for="first_name">First Name</label>
				<input type="text" name="first_name" required>
			</p>
			<p>
				<label for="last_name">Last Name</label>
				<input type="text" name="last_name" required>
			</p>
			<p>
				<label for="password">Password</label>
				<input type="password" name="password" required>
			</p>
			<p>
				<label for="confirm_password">Confirm Password</label>
				<input type="password" name="confirm_password" required>
			</p>
			<p>
				<input type="submit" name="insertNewUserBtn" value="Sign up">
			</p>
		</form>

		<!-- Back button to Login -->
		<div style="margin-top: 20px;">
			<a href="login.php" class="back-button">Back to Login</a>
		</div>
	</div>
</body>
</html>
