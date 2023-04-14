<?php
    $error = "";
	if ( !isset($_GET['workout_id']) || trim($_GET['workout_id']) == '') { 
		$error = $error . "There is no Workout ID.";
	}
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
    
    var_dump($_GET['workout_id']);
    
    $sql = "SELECT summary, form , first_equipment.equipment AS first, second_equipment.equipment AS second , type, difficulty , muscle , workout_name, workout_id 
			FROM workout
			LEFT JOIN difficulties
				ON workout.difficulty_id = difficulties.difficulty_id
			LEFT JOIN types
				ON workout.type_id = types.type_id
			LEFT JOIN equipments AS first_equipment
				ON workout.equipment_id = first_equipment.equipment_id
            LEFT JOIN equipments AS second_equipment
				ON workout.second_equipment_id = second_equipment.equipment_id
			WHERE workout_id =" . $_GET['workout_id'];

    $sql = $sql . ";";

	$results = $mysqli->query($sql);

	if ( !$results ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	$mysqli->close();

?>

<!DOCTYPE html>
<html lang = "en">

    <head>
        <link rel="stylesheet" href="main.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">    
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Details</title>
        <style>
            .buttons {
                color:#31d1d6;
                background-color: #273245;
                width: 150px;
                height: 70px;
                font-size: 18px;
            }
            #button-edit{
                color:#31d1d6;
                background-color: #273245;
                width: 150px;
                height: 70px;
                font-size: 33px;
            }
            body {
                font-family:'Times New Roman', Times, serif;
                color:#31d1d6;
                background: linear-gradient(#8ee2ed, #73f0cc);
            }
            #title {
                color: black;
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
            <div class="row">
                <h1 class="col-12 mt-4" id = "title">Workout Details</h1>
            </div> <!-- .row -->
        </div> <!-- .container -->

        <div class="container">

            <div class="row mt-4">
                <div class="col-12">

                    <div class="text-danger font-italic"><?php echo($error)?></div>

                    <table class="table table-responsive">
                        <?php if ( $row = $results->fetch_assoc()) : ?>
                            <tr>
                                <th class="text-right">Workout Name:</th>
                                <td><?php echo $row['workout_name']; ?></td>
                            </tr>

                            <tr>
                                <th class="text-right">Muscles Used:</th>
                                <td><?php echo $row['muscle']; ?></td>
                            </tr>

                            <tr>
                                <th class="text-right">Equipment Used:</th>
                                <td><?php echo $row['first']; ?></td>
                            </tr>

                            <tr>
                                <th class="text-right">Second Equipment Used:</th>
                                <td><?php echo $row['second']; ?></td>
                            </tr>

                            <tr>
                                <th class="text-right">Type of Workout:</th>
                                <td><?php echo $row['type']; ?></td>
                            </tr>

                            <tr>
                                <th class="text-right">Difficulty:</th>
                                <td><?php echo $row['difficulty']; ?></td>
                            </tr>

                            <tr>
                                <th class="text-right">Form:</th>
                                <td><?php echo $row['form']; ?></td>
                            </tr>

                            <tr>
                                <th class="text-right">Summary:</th>
                                <td><?php echo $row['summary']; ?></td>
                            </tr>
                        <?php endif; ?>
                        

                    </table>


                </div> <!-- .col -->
            </div> <!-- .row -->
            <div class="row mt-4 mb-4">
                <div class="col-12">
                    <a href="search_results.php" role="button" class="btn btn-primary buttons"><i class="fa fa-fw fa-arrow-left"></i>Back to Search Results</a>
                    <a href="edit_form.php?workout_id=<?php echo $row['workout_id']; ?>" class="btn btn-outline-warning" id = "button-edit">Edit</a>
                </div> <!-- .col -->
            </div> <!-- .row -->
        </div> <!-- .container -->
        

    </body>
</html>