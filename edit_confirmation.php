<?php
	// Check to see if any required fields are missing.

	if ( !isset($_POST['workout']) || trim($_POST['workout']) == ''
    || !isset($_POST['muscle']) || trim($_POST['muscle']) == ''
    || !isset($_POST['equipment_id']) || trim($_POST['equipment_id']) == ''
    || !isset($_POST['difficulty_id']) || trim($_POST['difficulty_id']) == ''
    || !isset($_POST['type_id']) || trim($_POST['type_id']) == '') {
		$error = "Please fill out all required fields.";
		$workout_id = $_POST['workout_id'];
	} 
	else {
		// All required fields provided. Continue with the ADD workflow.

		$host = "303.itpwebdev.com";
		$user = "nlee5425_db_user";
		$pass = "Nathanlee_042003";
		$db = "nlee5425_workout_db";

		// DB Connection.
		$mysqli = new mysqli($host, $user, $pass, $db);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		$workout_id = $_POST['workout_id'];

		$workout_name = $_POST['workout'];
        $muscle = $_POST['muscle'];
        $equipment = $_POST['equipment_id'];
        $difficulty = $_POST['difficulty_id'];
        $type = $_POST['type_id'];

		if ( isset($_POST['second_equipment_id']) && trim($_POST['second_equipment_id']) != '') {
			$second_equipment = $_POST['second_equipment_id'];
		}
		else {
			$second_equipment = "null";
		}
		if ( isset($_POST['summary']) && trim($_POST['summary']) != '') {
			$summary = "'" . $_POST['summary'] . "'";
		}
        else {
			$summary = "null";
		}
        if ( isset($_POST['form']) && trim($_POST['form']) != '') {
			$form = "'" . $_POST['form'] . "'";
		}
        else {
			$form = "null";
		}


		$sql = "UPDATE workout
				SET workout_name = '$workout_name',
					muscle = '$muscle',
					equipment_id = $equipment,
					difficulty_id = $difficulty,
					type_id = $type,
					second_equipment_id = $second_equipment,
					summary = $summary,
					form = $form
				WHERE workout_id = $workout_id;";


		$results = $mysqli->query($sql);

		if (!$results) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}


		$mysqli->close();

	}

?>

<!DOCTYPE html>
<html lang = "en">

    <head>
        <link rel="stylesheet" href="main.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">    
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Edit Confirmation</title>

        <style>
            body {
                font-family:'Times New Roman', Times, serif;
                color:#31d1d6;
            }
            #button-back {
                color:#31d1d6;
                background-color: #273245;
                width: 150px;
                height: 70px;
                font-size: 21px;
            }
            #button-edit {
                color:#31d1d6;
                background-color: #273245;
                width: 150px;
                height: 70px;
                font-size: 33px;
            }
            #title {
                margin-top: 60px;
            }
        
        
        </style>

    </head>

    <body>
        <div id = "header" style="font-family:Times New Roman, Times, serif;">
        <ul id="navbar">
                    <li><a href="final.html"><i class="fa fa-fw fa-home"></i></a>
                    
                        <!-- <ul>
                            
                            <li><a href="projects.html">Projects</a></li>
        
                        </ul> -->
                    </li>
                    <li><a href="experience.html"><i class="fa fa-fw fa-bars"></i>Experience</a>
                        <ul>
                            <li><a href="projects.html">Projects</a></li>
                        </ul>
        
                    </li>
        
                    <li><a href="passions.html"><i class="fa fa-fw fa-bars"></i>Passions</a>
                        <ul>
                            <li><a href="workoutpage.php">Workout</a></li>
                        </ul>
                    </li>
                </ul>
        </div>

        <div class="container mt-4">
            <div class="row" id = "title">
                <h1 class="col-12 mt-4">Edit Workout Confirmation</h1>
            </div> <!-- .row -->
        </div> <!-- .container -->
        <div class="container">
            <div class="row mt-4">
                <div class="col-12">

                <?php if ( isset($error) && trim($error) != '' ) : ?>

                    <div class="text-danger font-italic">
                            
                            <?php echo $error; ?>
                    </div>

                <?php else : ?>

                    <div class="text-success">
                        <span class="font-italic" style = "font-style: italic;"><?php echo $workout_name;?></span> was successfully edited.
                    </div>

                <?php endif; ?>
                    
                </div> <!-- .col -->
            </div> <!-- .row -->
            <div class="row mt-4 mb-4">
                <div class="col-12">
                    <a href="details.php?workout_id=<?php echo $workout_id ?>" role="button" class="btn btn-primary" id="button-back">Back to Details</a>
                    <a href="edit_form.php?workout_id=<?php echo $workout_id ?>" class="btn btn-outline-warning buttons" id="button-edit">Edit</a>
                </div> <!-- .col -->
            </div> <!-- .row -->
        </div> <!-- .container -->

    

    </body>
</html>