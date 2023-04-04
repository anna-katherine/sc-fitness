<?php
    require 'config.php';
    if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
		// User IS logged in.
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
        <title>Add Form</title>

        <style>
            #add-form{
            position: absolute;
            top: 100px;
            left: 0px;
            right: 0px;
            text-align: center;
            font-family:"Times New Roman", Times, serif;
            color: #31d1d6;
            font-size: 30px;
        }
        .buttons {
            color:#31d1d6;
            background-color: #273245;
            width: 130px;
            height: 70px;
            font-size: 30px;
        }
        #b-img{
            height: 1500px;
            width: 100%;
            object-fit:cover;
            overflow:hidden;
        }
        #back-button{
            color:#31d1d6;
            background-color: #273245;
            width: 150px;
            height: 70px;
            font-size: 20px;
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
        <div>
            <img src ="img/add-form-img.jpeg" id = "b-img" alt = "front-image">  
        </div>


        <div class = "container" id ="add-form">
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

            <div class="container">
                <div class="row">
                    <h1 class="col-12 mt-4 mb-4" style="font-size:100px;">Workout Add Form</h1>
                </div> <!-- .row -->
            </div> <!-- .container -->
            <div class = "row">
                <div class = "col-1"> </div>
                <a href = "workoutpage.php" role="button" class="btn btn-primary" id ="back-button"> <i class="fa fa-fw fa-arrow-left"></i>Go Back to Main Page</a>
            </div>

            <div class="container mt-4">
            
                <form action="add_confirmation.php" method="POST">
                    <!-- Workout name search -->
                    <div class="form-group row">
                        <label for="workout-id" class="col-sm-3 col-form-label text-sm-right">Workout Name: <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="workout-id" name="workout">
                        </div>
                    </div> 

                    <!-- Muscle name search -->
                    <div class="form-group row">
                        <label for="muscle-id" class="col-sm-3 col-form-label text-sm-right">Muscle: <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="muscle-id" name="muscle" placeholder = "Ex: Abs, Lat, Bicep, Tricep, Shoulder, Chest, Quad, Hamstring, Calves, etc.">
                        </div>
                    </div> <!-- .form-group -->

                    <!-- Equipment used -->
                    <div class="form-group row">
                        <label for="equipment-id" class="col-sm-3 col-form-label text-sm-right">Equipment Used: <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="equipment_id" id="equipment-id" class="form-control">
                                <option value="" selected>-- Select One --</option>

                                <?php
                                    while (	$row = $results_equipment->fetch_assoc() ) :
                                            
                                ?>

                                    <option value='<?php echo$row['equipment_id']; ?>' ><?php echo$row['equipment']; ?></option>


                                <?php
                                    endwhile;
                                ?>


                            </select>
                        </div>
                    </div> <!-- .form-group -->

                    <div class="form-group row">
                        <label for="second-equipment-id" class="col-sm-3 col-form-label text-sm-right">Second Equipment Used:</label>
                        <div class="col-sm-9">
                            <select name="second_equipment_id" id="second-equipment-id" class="form-control">
                                <option value="" selected>-- Select One --</option>

                                <?php
                                    while (	$row = $results_second_equipment->fetch_assoc() ) :
                                            
                                ?>

                                    <option value='<?php echo$row['equipment_id']; ?>' ><?php echo$row['equipment']; ?></option>


                                <?php
                                    endwhile;
                                ?>


                            </select>
                        </div>
                    </div> <!-- .form-group -->

                    <!-- Difficult level -->
                    <div class="form-group row">
                        <label for="difficulty-id" class="col-sm-3 col-form-label text-sm-right">Difficulty Level: <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="difficulty_id" id="difficulty-id" class="form-control">
                                <option value="" selected>-- Select One --</option>

                                <?php
                                    while (	$row = $results_difficulty->fetch_assoc() ) :
                                            
                                ?>

                                    <option value='<?php echo$row['difficulty_id']; ?>' ><?php echo$row['difficulty']; ?></option>


                                <?php
                                    endwhile;
                                ?>


                            </select>
                        </div>
                    </div> <!-- .form-group -->
                    
                    <!-- Type of workout -->
                    <div class="form-group row">
                        <label for="type-id" class="col-sm-3 col-form-label text-sm-right">Type of Workout: <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="type_id" id="type-id" class="form-control">
                                <option value="" selected>-- Select One --</option>

                                <?php
                                    while (	$row = $results_type->fetch_assoc() ) :
                                            
                                ?>

                                    <option value='<?php echo$row['type_id']; ?>' ><?php echo$row['type']; ?></option>


                                <?php
                                    endwhile;
                                ?>


                            </select>
                        </div>
                    </div> <!-- .form-group -->

                    <div class="form-group row">
                        <label for="summary" class="col-sm-3 col-form-label text-sm-right">Summary of Workout:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="summary" name="summary">
                        </div>
                    </div> <!-- .form-group -->

                    <div class="form-group row">
                        <label for="form" class="col-sm-3 col-form-label text-sm-right">Workout Form:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="form" name="form">
                        </div>
                    </div> <!-- .form-group -->

                    <div class="form-group row">
                        <div class = "col-3"></div>
                        <div class="col-2">
                            <span class="text-danger font-italic">* Required</span>
                        </div>
                    </div> <!-- .form-group -->


                    <div class="form-group row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6 mt-2">
                            <button type="submit" class="btn btn-primary buttons">Submit</button>
                            <button type="reset" class="btn btn-light buttons"><i class="fa fa-fw fa-refresh"></i></button>
                        </div>
                    </div> <!-- .form-group -->

                </form>
            </div>

        </div>

    

    </body>
</html>