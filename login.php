<?php
	//session_start();
	require "config.php";

	if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ) {
		// User IS logged in.
		header('Location: workoutpage.php');
	} else {
		// User is NOT logged in.

		if ( isset($_POST['username']) && isset($_POST['password']) ) {
			// The form was submitted.

			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
			if ( $mysqli->connect_errno ) {
					echo $mysqli->connect_error;
					exit();
			}

			$username = $_POST['username'];
			$password = hash('sha256', $_POST['password']);

			$sql = "SELECT username , password, email , user_permission
					FROM user
                    LEFT JOIN user_permission 
                        ON user.user_permission_id = user_permission.user_permission_id
					WHERE username = '$username'
					AND password = '$password';";

			$results = $mysqli->query($sql);

			if ( !$results ) {
				echo $mysqli->error;
				$mysqli->close();
				exit();
			}

			$mysqli->close();


			if ( $results->num_rows == 1 ) {
				// Valid credentials.

				$_SESSION['logged_in'] = true;
				$_SESSION['username'] = $_POST['username'];
                $row = $results->fetch_assoc();
                $_SESSION['user_permission'] = $row['user_permission'];

				header('Location: workoutpage.php');

			} else {
				// Invalid credentials.

				$error = "Invalid credentials.";

			}

		}

	}

?>
<!DOCTYPE html>
<html lang = "en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login | Song Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background: linear-gradient(#8ee2ed, #73f0cc);
        }
    
    </style>
</head>
<body style="font-family:Times New Roman, Times, serif;">

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Login</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<form action="login.php" method="POST">

			<div class="row mb-3">
				<div class="font-italic text-danger col-sm-9 ml-sm-auto">
					<!-- Show errors here. -->
					<?php

						if ( !empty($error) ) {
							echo $error;
						}

					?>
				</div>
			</div> <!-- .row -->
			

			<div class="form-group row">
				<label for="username-id" class="col-sm-3 col-form-label text-sm-right">Username:</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="username-id" name="username">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="password-id" class="col-sm-3 col-form-label text-sm-right">Password:</label>
				<div class="col-sm-9">
					<input type="password" class="form-control" id="password-id" name="password">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Login</button>
					<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light">Cancel</a>
				</div>
			</div> <!-- .form-group -->
		</form>

		<div class="row">
			<div class="col-sm-9 ml-sm-auto">
				<a href="register_form.php">Create an account</a>
			</div>
		</div> <!-- .row -->

		<div class = "row">
			<div class = "col-12">
				<a href="final.html" role="button" class="btn btn-light"><i class="fa fa-fw fa-home"></i>Main Page</a>
			</div>
		</div>

	</div> <!-- .container -->
</body>
</html>