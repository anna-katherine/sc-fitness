<?php
    require 'config.php';
    if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_permission'] == 'admin') {
        if ( !isset($_GET['workout_id']) || empty($_GET['workout_id'])) {
            echo "Invalid URL";
            exit();
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

        $sql_equipment = "SELECT * FROM equipments;";

        $results_equipment = $mysqli->query($sql_equipment);

        if ( $results_equipment == false) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }

        $sql_second_equipment = "SELECT * FROM equipments;";

        $results_second_equipment = $mysqli->query($sql_second_equipment);

        if ( $results_second_equipment == false) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }

        $sql_type = "SELECT * FROM types;";

        $results_type = $mysqli->query($sql_type);

        if ( $results_type == false) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }

        $sql_difficulty = "SELECT * FROM difficulties;";

        $results_difficulty = $mysqli->query($sql_difficulty);

        if ( $results_difficulty == false) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }

        $workout_id = $_GET['workout_id'];

        $sql_workout = "SELECT *
                    FROM workout
                    WHERE workout_id = $workout_id;";

        $results_workout = $mysqli->query($sql_workout);

        $row_workout = $results_workout->fetch_assoc();

        // Close DB Connection
        $mysqli->close();
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
        <title>Edit Form</title>

        <style>
            #edit-form {
                margin-top: 80px;
            }
            body {
                font-family:'Times New Roman', Times, serif;
                color:#31d1d6;
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

        <div class="container mt-4" >
            <div class="row" id = "title">
                <h1 class="col-12 mt-4">Edit a Workout</h1>
            </div> <!-- .row -->
        </div> <!-- .container -->

        <div class="container mt-4" id = "edit-form">
            
                <form action="edit_confirmation.php" method="POST">
                    <!-- Workout name search -->
                    <!-- <div class="form-group row">
                        <label for="workout-id" class="col-sm-3 col-form-label text-sm-right">Workout Name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="workout-id" name="workout">
                        </div>
                    </div> .form-group -->

                    <input type="hidden" name="workout_id" value="<?php echo $workout_id; ?>">

                    <div class="form-group row">
                        <label for="title-id" class="col-sm-3 col-form-label text-sm-right">Workout Name: <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="workout-id" name="workout" value = "<?php echo $row_workout['workout_name']; ?>">
                        </div>
                    </div> <!-- .form-group -->

                    <div class="form-group row mt-2">
                        <label for="release-date-id" class="col-sm-3 col-form-label text-sm-right">Muscles Used: <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="test" class="form-control" id="muscle-id" name="muscle" value = "<?php echo $row_workout['muscle']; ?>">
                        </div>
                    </div> <!-- .form-group -->

                    <!-- Equipment used -->
                    <div class="form-group row mt-2">
                        <label for="equipment_id" class="col-sm-3 col-form-label text-sm-right">Equipment Used: <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="equipment_id" id="equipment-id" class="form-control">
                                <option value="" selected>-- Select One --</option>

                                <?php while( $row = $results_equipment->fetch_assoc() ): ?>

                                <?php if ( $row['equipment_id'] == $row_workout['equipment_id']) : ?>

                                    <option value="<?php echo $row['equipment_id']; ?>" selected>
                                        <?php echo $row['equipment']; ?>
                                    </option>

                                <?php else : ?>

                                    <option value="<?php echo $row['equipment_id']; ?>">
                                        <?php echo $row['equipment']; ?>
                                    </option>

                                <?php endif; ?>

                                <?php endwhile; ?>


                            </select>
                        </div>
                    </div> <!-- .form-group -->

                    <div class="form-group row mt-2">
                        <label for="second_equipment_id" class="col-sm-3 col-form-label text-sm-right">Second Equipment Used:</label>
                        <div class="col-sm-9">
                            <select name="second_equipment_id" id="second-equipment-id" class="form-control">
                                <option value="" selected>-- Select One --</option>

                                <?php while( $row = $results_second_equipment->fetch_assoc() ): ?>

                                <?php if ( $row['equipment_id'] == $row_workout['second_equipment_id']) : ?>

                                    <option value="<?php echo $row['equipment_id']; ?>" selected>
                                        <?php echo $row['equipment']; ?>
                                    </option>

                                <?php else : ?>

                                    <option value="<?php echo $row['equipment_id']; ?>">
                                        <?php echo $row['equipment']; ?>
                                    </option>

                                <?php endif; ?>

                                <?php endwhile; ?>


                            </select>
                        </div>
                    </div> <!-- .form-group -->

                    <!-- Difficult level -->
                    <div class="form-group row mt-2">
                        <label for="difficulty-id" class="col-sm-3 col-form-label text-sm-right">Difficulty Level: <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="difficulty_id" id="difficulty-id" class="form-control">
                                <option value="" selected>-- Select One --</option>

                                <?php while( $row = $results_difficulty->fetch_assoc() ): ?>

                                <?php if ( $row['difficulty_id'] == $row_workout['difficulty_id']) : ?>

                                    <option value="<?php echo $row['difficulty_id']; ?>" selected>
                                        <?php echo $row['difficulty']; ?>
                                    </option>

                                <?php else : ?>

                                    <option value="<?php echo $row['difficulty_id']; ?>">
                                        <?php echo $row['difficulty']; ?>
                                    </option>

                                <?php endif; ?>

                                <?php endwhile; ?>


                            </select>
                        </div>
                    </div> <!-- .form-group -->
                    
                    <!-- Type of workout -->
                    <div class="form-group row mt-2">
                        <label for="type-id" class="col-sm-3 col-form-label text-sm-right">Type of Workout: <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="type_id" id="type-id" class="form-control">
                                <option value="" selected>-- Select One --</option>

                                <?php while( $row = $results_type->fetch_assoc() ): ?>

                                <?php if ( $row['type_id'] == $row_workout['type_id']) : ?>

                                    <option value="<?php echo $row['type_id']; ?>" selected>
                                        <?php echo $row['type']; ?>
                                    </option>

                                <?php else : ?>

                                    <option value="<?php echo $row['type_id']; ?>">
                                        <?php echo $row['type']; ?>
                                    </option>

                                <?php endif; ?>

                                <?php endwhile; ?>


                            </select>
                        </div>
                    </div> <!-- .form-group -->

                    <div class="form-group row mt-2">
                        <label for="title-id" class="col-sm-3 col-form-label text-sm-right">Form:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="form" name="form" value = "<?php echo $row_workout['form']; ?>">
                        </div>
                    </div> <!-- .form-group -->

                    <div class="form-group row mt-2">
                        <label for="release-date-id" class="col-sm-3 col-form-label text-sm-right">Summary:</label>
                        <div class="col-sm-9">
                            <input type="test" class="form-control" id="summary" name="summary" value = "<?php echo $row_workout['summary']; ?>">
                        </div>
                    </div> <!-- .form-group -->


                    <div class="form-group row mt-2">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6 mt-2">
                            <button type="submit" class="btn btn-primary buttons">Confirm</button>
                            <button type="reset" class="btn btn-light buttons">Reset</button>
                        </div>
                    </div> <!-- .form-group -->

                </form>
        </div>

    

    </body>
</html>