<?php

    require 'config.php';
    if ( !isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false  ) {
        header('Location: databaseerror.html');
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

        <title>Workout Page</title>
        <style>

            #b-img{
                height: 100%;
                width: 100%;
                object-fit:cover;
                overflow:hidden;
            }
            /* #b-img2{
                width: auto;
                height: 2000px;
                width: 1500px;
                object-fit:cover;
                overflow:hidden;
            } */
            #search {
                position: absolute;
                top: 200px;;
                left: 0px;
                right: 0px;
                bottom: 0px;
                font-family:"Times New Roman", Times, serif;
            }
            #title {
                color: #31d1d6;
            }
            .buttons {
                color:#31d1d6;
                background-color: #273245;
                width: 200px;
                height: 110px;
                font-size: 30px;
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
            <img src ="img/workout-img.jpeg" id = "b-img" alt = "front-image">  
        </div>
        <!-- <div>
            <img src ="img/workout-img3.jpeg" id = "b-img2" alt = "front-image">  
        </div> -->

        <div class = "container" id ="search">
            <div class = "row"> 
                <div class = "col-10"></div>
                <div class = "col-2">
                    
                    <?php 
                        if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ) :
                           
                    ?>
                        <a href = "logout.php"> <h2> <?php echo $_SESSION['username']; ?>  </h2></a>

                    <?php endif; ?>

                </div>
            </div>
            
            <div class="container" id = "title" >
                <div class="row" style ="text-align: center;">
                    <!-- <div class = "col-3"> </div> -->
                    <h1 class="col-12 mt-4 mb-4" style="font-size:150px;">Workout Database</h1>
                </div> <!-- .row -->
            </div> <!-- .container -->
            <div class="container">
                <div class="row">
                    <div class = "col-3"> </div>
                    <div class="col-3">
                        <a href="search_form.php" class="btn btn-primary btn-lg btn-block mt-4 mt-md-2 buttons" role="button"><i class="fa fa-fw fa-search"></i>Search Workouts</a>
                    </div>
                    <div class="col-3">
                        <a href="add_form.php" class="btn btn-primary btn-lg btn-block mt-4 mt-md-2 buttons" role="button">Add a Workout</a>
                    </div>
                </div> <!-- .row -->
            </div> <!-- .container -->
        </div>
        

    
    </body>





</html>