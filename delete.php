<?php
    require 'config.php';
    if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_permission'] == 'admin') {
        if ( !isset($_GET['workout_id']) || trim($_GET['workout_id']) == '' ) {
            // Missing track_id;
            $error = "Invalid URL.";
        } else {
            // Valid URL w/ track_id.

            $host = "303.itpwebdev.com";
            $user = "nlee5425_db_user";
            $pass = "Nathanlee_042003";
            $db = "nlee5425_workout_db";

            // Establish MySQL Connection.
            $mysqli = new mysqli($host, $user, $pass, $db);

            // Check for any Connection Errors.
            if ( $mysqli->connect_errno ) {
                echo $mysqli->connect_error;
                exit();
            }

            $workout_id = $_GET['workout_id'];

            $sql = "DELETE FROM workout
                    WHERE workout_id = $workout_id;";


            // echo "<hr>$sql<hr>";

            $results = $mysqli->query($sql);

            if (!$results) {
                echo $mysqli->error;
                $mysqli->close();
                exit();
            }

            $mysqli->close();
        }
    }
    else {
        header('Location: permissionerror.html');
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
        <title>Delete</title>

        <style>
            .buttons {
                color:#31d1d6;
                background-color: #273245;
                width: 150px;
                height: 70px;
                font-size: 18px;
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

        <div class="container mt-4">
		<div class="row">
			<h1 class="col-12 mt-4">Delete a Workout</h1>
		</div> <!-- .row -->
        </div> <!-- .container -->
        <div class="container">
            <div class="row mt-4">
                <div class="col-12">

                <?php if (isset($error) && trim($error) != '') : ?>

                    <div class="text-danger">
                        <?php echo $error; ?>
                    </div>

                <?php else : ?>

                    <div class="text-success"><span class="font-italic" style="font-style: italic;">
                        <?php echo $_GET['workout_name']; ?>
                    </span> was successfully deleted.</div>

                <?php endif; ?>

                </div> <!-- .col -->
            </div> <!-- .row -->
            <div class="row mt-4 mb-4">
                <div class="col-12">
                    <a href="search_results.php" role="button" class="btn btn-primary buttons">Back to Search Results</a>
                </div> <!-- .col -->
            </div> <!-- .row -->
        </div> <!-- .container -->

    

    </body>
</html>