<?php

    if ( !isset($_POST['workout']) || trim($_POST['workout']) == '' 
    || !isset($_POST['muscle']) || trim($_POST['muscle']) == ''
    || !isset($_POST['equipment_id']) || trim($_POST['equipment_id']) == ''
    || !isset($_POST['difficulty_id']) || trim($_POST['difficulty_id']) == ''
    || !isset($_POST['type_id']) || trim($_POST['type_id']) == '') {
        $error = "Please fill out all required fields.";
    }
    else {
        $host = "303.itpwebdev.com";
        $user = "nlee5425_db_user";
        $pass = "Nathanlee_042003";
        $db = "nlee5425_workout_db";

        $mysqli = new mysqli($host , $user , $pass , $db);

        if ( $mysqli->connect_errno) {
            echo $mysqli->connect_error;
            exit();
        }
        $mysqli->set_charset('utf8');

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

        $sql = "INSERT INTO workout (workout_name, muscle , equipment_id, second_equipment_id, summary, form , type_id, difficulty_id)
				VALUES('$workout_name' , '$muscle' , $equipment , $second_equipment , $summary , $form , $type , $difficulty );";

		$result = $mysqli->query($sql);

		if ( !$result) {
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
        <title>Add Confirmation</title>

        <style>
            .buttons {
                color:#31d1d6;
                background-color: #273245;
                width: 120px;
                height: 60px;
                font-size: 15px;
            }
            body {
                font-family:'Times New Roman', Times, serif;
                color:#31d1d6;
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

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="workoutpage.php">Home</a></li>
            <li class="breadcrumb-item"><a href="add_form.php">Add</a></li>
            <li class="breadcrumb-item active">Confirmation</li>
        </ol>
        <div class="container">
        <div class = "row" >
                <div class = "col-11"> </div>
                <div class = "col-1" >
                <?php 
                        if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ) :
                           
                    ?>
                        <a href = "logout.php"> <h2> <?php echo $_SESSION['username']; ?>  </h2></a>

                    <?php else : ?>
                        <a href="login.php"><h2>Login </h2></a> 

                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <h1 class="col-12 mt-4">Add Workout Confirmation</h1>
            </div> <!-- .row -->
        </div> <!-- .container -->
        <div class="container">
            <div class="row mt-4">
                <div class="col-12">

                    <?php if ( isset($error) && !empty($error))  : ?>

                    <div class="text-danger font-italic"><?php  echo($error); ?></div>

                    <?php else : ?>

                    <div class="text-success"><span class="font-italic"> <?php echo($workout_name) ; ?></span> was successfully added.</div>

                    <?php endif; ?>

                </div> <!-- .col -->
            </div> <!-- .row -->
            <div class="row mt-4 mb-4">
                <div class="col-2">
                    <a href="add_form.php" role="button" class="btn btn-primary buttons">Go to Add Form</a>
                </div>
                <div class="col-1">
                    <a href="search_form.php" role="button" class="btn btn-primary buttons">Go to Search Form</a>
                </div> <!-- .col -->
            </div> <!-- .row -->
        </div> <!-- .container -->

    

    </body>
</html>