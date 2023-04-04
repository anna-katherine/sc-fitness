<?php 


	if ( empty($_FILES["file_name"]) ) {
		$error = "Missing file";
	} else if ($_FILES['file_name']['error'] > 0) {
		$error = "File upload error # " . $_FILES['file_name']['error'];
	} else {
		// No error

		// move_uploaded_file($source, $destination)

		$source = $_FILES['file_name']['tmp_name'];
		$destination = "img_uploads/" . uniqid() . $_FILES['file_name']["name"];

		$destination = preg_replace('/\s/', '_', $destination);

		move_uploaded_file($source, $destination);
	}

?>
<!DOCTYPE html>
<html>
<head lang = "en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>File Upload</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
</head>
<body class="py-5" style="font-family:Times New Roman, Times, serif;">

	<div class="container">
		<div class="row">
			<h1 class="col-12">File Confirmation</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container mt-4">
		<div class="row">

			<?php if ( !empty($error) ) : ?>

				<p class="col-12 text-danger">
					<?php echo $error; ?>
				</p>


			<?php else : ?>
				
				<p class="col-12">
					Your file was successfully uploaded <a href="<?php echo $destination; ?>" target="_blank">here</a>.
				</p>

			<?php endif; ?>


	    </div> <!-- .row -->
        <div class = "row">
            
            <a href="passions.html" role="button" class="btn btn-primary buttons">Go Back</a>

        </div>
	</div> <!-- .container -->

</body>
</html>