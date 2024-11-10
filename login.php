<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link rel="stylesheet" href="login.css"> <!-- Link to external CSS file -->
</head>
<body>
	<?php  
	if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
		if ($_SESSION['status'] == "200") {
			echo "<h1 style='color: green; position: fixed; bottom: 0; width: 100%; text-align: center; background-color: #f8f8f8;'>{$_SESSION['message']}</h1>";
		} else {
			echo "<h1 style='color: red; position: fixed; bottom: 0; width: 100%; text-align: center; background-color: #f8f8f8;'>{$_SESSION['message']}</h1>";	
		}
	}
	unset($_SESSION['message']);
	unset($_SESSION['status']);
	?>
	
	<form action="core/handleForms.php" method="POST">
		<h1>Sign In Here!</h1> <!-- Positioning the title at the top of the form -->
		<p>
			<label for="username">Username</label>
			<input type="text" name="username" required>
		</p>
		<p>
			<label for="password">Password</label>
			<input type="password" name="password" required>
		</p>
		<p>
			<input type="submit" name="loginUserBtn" value="Login">
		</p>
		<p>Don't have an account? You may Sign up <a href="register.php">here</a></p> <!-- Positioning below the submit button -->
	</form>
</body>
</html>
