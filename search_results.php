<?php
    require 'config.php';
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
			WHERE 1 = 1";

            
    if ( isset($_GET['muscle']) && !empty($_GET['muscle'])) {
		$muscle = $_GET['muscle'];
		$sql = $sql . " AND workout.muscle LIKE '%$muscle%'";
	}
    if ( isset($_GET['equipment_id']) && !empty($_GET['equipment_id'])) {
		$equipment_id = $_GET['equipment_id'];
		$sql = $sql . " AND workout.equipment_id = $equipment_id";
        $sql = $sql . " OR workout.second_equipment_id = $equipment_id";
	}
    // if ( isset($_GET['equipment_id']) && !empty($_GET['equipment_id'])) {
	// 	$equipment_id = $_GET['equipment_id'];
		
	// }
    if ( isset($_GET['difficulty_id']) && !empty($_GET['difficulty_id'])) {
		$difficulty_id = $_GET['difficulty_id'];
		$sql = $sql . " AND workout.difficulty_id = $difficulty_id";
	}
    if ( isset($_GET['type_id']) && !empty($_GET['type_id'])) {
		$type_id = $_GET['type_id'];
		$sql = $sql . " AND workout.type_id = $type_id";
	}

    $sql = $sql . ";";

	$results = $mysqli->query($sql);

	if ( !$results ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

    $total_results = $results->num_rows;
	$results_per_page = 10;
	$last_page = ceil($total_results / $results_per_page);

	if ( isset($_GET['page']) && trim($_GET['page']) != '') {
		$current_page = $_GET['page'];
	} else {
		$current_page = 1;
	}

	if ( $current_page < 1 || $current_page > $last_page) {
		$current_page = 1;
	}
	

	$start_index = ($current_page - 1) * $results_per_page;

	$sql = rtrim($sql, ';');

	$sql = $sql . " LIMIT $start_index, $results_per_page;";

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

        <title>Search Results</title>


        <style>
            #overall {
                margin-top: 60px;
                font-family: "Times New Roman", Times, serif;
            }
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

        

        <div class="container" id = "overall">


        <div class="container">
        <div class = "row"  >
                <div class = "col-11"> </div>
                <div class = "col-1"  >
                    <?php 
                        if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ) :
                           
                    ?>
                        <a href = "logout.php"> <h2> <?php echo $_SESSION['username']; ?>  </h2></a>

                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <h1 id = "title" class="col-12 mt-4">Workout Search Results</h1>
            </div> <!-- .row -->
	    </div> <!-- .container -->
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 mt-4">
                    <a href="search_form.php" role="button" class="btn btn-primary buttons"><i class="fa fa-fw fa-arrow-left"></i>Back to Search Form</a>
                </div> <!-- .col -->
            </div> <!-- .row -->
            <div class="row">

                <div class="col-12" style = "color: black;">

                    Showing <?php echo $results->num_rows; ?> workout(s).

                </div> <!-- .col -->
                <div class="col-12">
                    <table class="table table-hover table-responsive mt-4">
                        <thead>
                            <tr>
                                <th>Delete</th>
                                <th>Edit</th>
                                <th>Workout Name</th>
                                <th>Muscles Used</th>
                                <th>Equipment Used</th>
                                <th>Second Equipment Used</th>
                                <th>Type of Workout</th>
                                <th>Difficulty</th>
                                <th>Form</th>
                                <th>Summary</th>

                            </tr>
                            <?php while( $row = $results->fetch_assoc()) : ?>
                                <tr>
                                    <td>
                                        <a href="delete.php?workout_id=<?php echo $row['workout_id'];?>&workout_name=<?php echo $row['workout_name'];?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this workout?');"><i class="fa fa-fw fa-trash"></i></a>
                                    </td>
                                    <td>
                                        <a href="edit_form.php?workout_id=<?php echo $row['workout_id'];?>" class="btn btn-outline-warning">Edit</a>
                                    </td>
                                    <td> <a href="details.php?workout_id=<?php echo($row['workout_id'])?>"> <?php echo$row['workout_name'];?></a></td>
                                    <td> <?php echo $row['muscle']; ?>  </td>
                                    <td> <?php echo $row['first']; ?> </td>
                                    <td> <?php echo $row['second']; ?> </td>
                                    <td> <?php echo $row['type']; ?> </td>
                                    <td> <?php echo $row['difficulty']; ?> </td>
                                    <td> <?php echo $row['form']; ?> </td>
                                    <td> <?php echo $row['summary']; ?> </td>

                                </tr>
                            <?php endwhile; ?>

                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div> <!-- .col -->
            </div> <!-- .row -->
            <div class="col-12">
				<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-center">
						<li class="page-item <?php if ( $current_page <= 1 ) { echo 'disabled';} ?>">
							<a class="page-link" href="<?php 
								$_GET['page'] = 1;
								echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
							?>"><i class="fa fa-fw fa-arrow-left"></i><i class="fa fa-fw fa-arrow-left"></i></a>
						</li>
						<li class="page-item <?php if ( $current_page <= 1 ) { echo 'disabled';} ?>">
							<a class="page-link" href="<?php 
								$_GET['page'] = $current_page - 1;
								echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
							?>"><i class="fa fa-fw fa-arrow-left"></i></a>
						</li>
						<li class="page-item active">
							<a class="page-link" href="">
								<?php echo $current_page; ?>
							</a>
						</li>
						<li class="page-item <?php if ( $current_page >= $last_page ) { echo 'disabled';} ?>">
							<a class="page-link" href="<?php 
								$_GET['page'] = $current_page + 1;
								echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
							?>"><i class="fa fa-fw fa-arrow-right"></i></a>
						</li>
						<li class="page-item <?php if ( $current_page >= $last_page ) { echo 'disabled';} ?>">
							<a class="page-link" href="<?php 
								$_GET['page'] = $last_page;
								echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
							?>"><i class="fa fa-fw fa-arrow-right"></i><i class="fa fa-fw fa-arrow-right"></i></a>
						</li>
					</ul>
				</nav>
			</div> <!-- .col -->
            <!-- <div class="row mt-4 mb-4">
                <div class="col-12">
                    <a href="search_form.php" role="button" class="btn btn-primary buttons">Back to Workout Search Form</a>
                </div> .col 
            </div> .row -->
        </div> <!-- .container -->
        </div>
    

    </body>
</html>