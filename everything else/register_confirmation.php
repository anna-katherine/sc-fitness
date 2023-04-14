<?php

require 'config.php';

if ( !isset($_POST['email']) || trim($_POST['email'] == '')
	|| !isset($_POST['username']) || trim($_POST['username'] == '')
	|| !isset($_POST['password']) || trim($_POST['password'] == '') ) {
	$error = "Please fill out all required fields.";
} else {
	// All required fields present.
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
	}

	$email = $mysqli->escape_string($_POST['email']);
	$username = $mysqli->escape_string($_POST['username']);
	$password = $mysqli->escape_string($_POST['password']);

	$password = hash('sha256', $password);

	$sql_registered = "SELECT * 
						FROM user
						WHERE username = '$username'
						OR email = '$email';";

	$results_registered = $mysqli->query($sql_registered);

	if ( !$results_registered ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	if ($results_registered->num_rows > 0) {
		$error = "Username or email already registered.";
	} else {
		$sql = "INSERT INTO user (username, email, password , user_permission_id)
			VALUES ('$username','$email','$password' , 1);";

		$results = $mysqli->query($sql);

		if ( !$results ) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}
	}

	$mysqli->close();
}

?>
<!DOCTYPE html>
<html lang = "en">
<head >
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registration Confirmation | Song Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(#8ee2ed, #73f0cc);
        }
    
    </style>
</head>
<body style="font-family:Times New Roman, Times, serif;">

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">User Registration</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<div class="row mt-4">
			<div class="col-12">
				<?php if ( isset($error) && trim($error) != '' ) : ?>
					<div class="text-danger"><?php echo $error; ?></div>
				<?php else : ?>
					<div class="text-success"><?php echo $username; ?> was successfully registered.</div>
				<?php endif; ?>
		</div> <!-- .col -->
	</div> <!-- .row -->

	<div class="row mt-4 mb-4">
		<div class="col-12">
			<a href="login.php" role="button" class="btn btn-primary">Login</a>
			<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light">Back</a>
		</div> <!-- .col -->
	</div> <!-- .row -->

</div> <!-- .container -->

</body>
</html>