<?php

//-----DB Connection code------
$servername = "localhost";
$serverUsername = "hf6bb";                         //computing id
$serverPassword = "ILEK7P2x";                   //---- your password
$database = "moviedb";              // computing id



// Create connection
$conn = new mysqli($servername, $serverUsername, $serverPassword, $database);
// Check connection
if ($conn->connect_error)
{
  die ("Connection failed: ". $conn->connect_error);
}


// ---- VARIABLE DECLARATIONS ----
$nameErr = $passErr = "";
$inputUsername = $inputPassword = $pwd= "";

$ids = array("", "", "", "", "", "", "", "", "", "");
$titles = array("", "", "", "", "", "", "", "", "", "");
$startYears = array("", "", "", "", "", "", "", "", "", "");
$runtimes = array("", "", "", "", "", "", "", "", "", "");
$genres = array("", "", "", "", "", "", "", "", "", "");
$ratings = array("", "", "", "", "", "", "", "", "", "");
$directors = array("", "", "", "", "", "", "", "", "", "");
$writers = array("", "", "", "", "", "", "", "", "", "");
$actors = array("", "", "", "", "", "", "", "", "", "");
$characters = array("", "", "", "", "", "", "", "", "", "");

$search = $_GET["search"];

$sqlBase = "select title_basics_mini.tconst as id, title_basics_mini.primaryTitle as title, title_basics_mini.startYear as startYear, title_basics_mini.runtimeMinutes as 
            runtime, title_basics_mini.genres, title_ratings_mini.averageRating as rating, director.primaryName as director, writer.primaryName as writer, actor.primaryName as 
            actor, title_principals_mini.characters as characters 
            from ((((((title_basics_mini inner join title_ratings_mini on title_basics_mini.tconst = title_ratings_mini.tconst)
            left outer join title_crew_mini on title_basics_mini.tconst = title_crew_mini.tconst)
            left outer join title_principals_mini on title_basics_mini.tconst = title_principals_mini.tconst)
            left outer join director on title_crew_mini.directors = director.nconst)
            left outer join writer on title_crew_mini.directors = writer.nconst)
            left outer join actor on title_principals_mini.nconst = actor.nconst)
            where";

$sql = $sqlBase . " primaryTitle like '%$search%' limit 0, 10;";
// HINT: your SQL Query to get the row with given username
// Is it Select or Insert or Delete or Alter? 

$result = $conn->query($sql);
$len = $result->num_rows;

for ($i = 0; $i < $len; $i++) {
  $row = $result->fetch_assoc();
  $ids[$i] = $row["id"];
  $titles[$i] = $row["title"];
  $startYears[$i] = $row["startYear"];
  $runtimes[$i] = $row["runtime"];
  $genres[$i] = $row["genres"];
  $ratings[$i] = $row["rating"];
  $directors[$i] = $row["director"];
  $writers[$i] = $row["writer"];
  $actors[$i] = $row["actor"];
  $characters[$i] = $row["characters"];
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
    
    <title>Movie Review</title>

    <!-- Loading third party fonts -->
    <link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
    <link href="fonts/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Loading main css file -->
    <link rel="stylesheet" href="style.css">
    
    <!--[if lt IE 9]>
    <script src="js/ie-support/html5.js"></script>
    <script src="js/ie-support/respond.js"></script>
    <![endif]-->

  </head>


  <body>
    <div id="site-content">
      <header class="site-header">
        <div class="container">
          <a href="home.php" id="branding">
            <img src="images/logo.png" alt="" class="logo">
            <div class="logo-copy">
              <h1 class="site-title">Movier</h1>
              <small class="site-description">Find your favorite movie!</small>
            </div>
          </a> <!-- #branding -->

          <div class="main-navigation">
            <button type="button" class="menu-toggle"><i class="fa fa-bars"></i></button>
            <ul class="menu">
              <li class="menu-item current-menu-item"><a href="home.php">Home</a></li>
              <li class="menu-item current-menu-item"><a href="login.php">Login</a></li>
            </ul> <!-- .menu -->

            <form method="GET" action="search.php">
              <input type="text" name="search" placeholder="Search...">
              <button><i class="fa fa-search"></i></button>
            </form>
          </div> <!-- .main-navigation -->

          <div class="mobile-navigation"></div>
        </div>
      </header>
      <main class="main-content">
        <div class="container">
          <div class="page">
            <div class="row">
              <div class="col-md-12">
                <h2 class="section-title">Search Result</h2>
                <ul class="movie-schedule">
                  <li>
                    <div class="date">Id</div>
                    <div class="date">Title</div>
                    <div class="date">Year</div>
                    <div class="date">Runtime</div>
                    <div class="date">Genres</div>
                    <div class="date">Rating</div>
                    <div class="date">Director</div>
                    <div class="date">Writer</div>
                    <div class="date">Crew</div>
                    <div class="date">Character</div>
                  </li>
                  <li>
                    <div class="date"><?php echo $ids[0];?></div>
                    <div class="date"><?php echo $titles[0];?></div>
                    <div class="date"><?php echo $startYears[0];?></div>
                    <div class="date"><?php echo $runtimes[0];?></div>
                    <div class="date"><?php echo str_replace(",", " ", $genres[0]);?></div>
                    <div class="date"><?php echo $ratings[0];?></div>
                    <div class="date"><?php echo $directors[0];?></div>
                    <div class="date"><?php echo $writers[0];?></div>
                    <div class="date"><?php echo $actors[0];?></div>
                    <div class="date"><?php echo $characters[0];?></div>
                  </li>
                  <li>
                    <div class="date"><?php echo $ids[1];?></div>
                    <div class="date"><?php echo $titles[1];?></div>
                    <div class="date"><?php echo $startYears[1];?></div>
                    <div class="date"><?php echo $runtimes[1];?></div>
                    <div class="date"><?php echo str_replace(",", " ", $genres[1]);?></div>
                    <div class="date"><?php echo $ratings[1];?></div>
                    <div class="date"><?php echo $directors[1];?></div>
                    <div class="date"><?php echo $writers[1];?></div>
                    <div class="date"><?php echo $actors[1];?></div>
                    <div class="date"><?php echo $characters[1];?></div>
                  </li>
                  <li>
                    <div class="date"><?php echo $ids[2];?></div>
                    <div class="date"><?php echo $titles[2];?></div>
                    <div class="date"><?php echo $startYears[2];?></div>
                    <div class="date"><?php echo $runtimes[2];?></div>
                    <div class="date"><?php echo str_replace(",", " ", $genres[2]);?></div>
                    <div class="date"><?php echo $ratings[2];?></div>
                    <div class="date"><?php echo $directors[2];?></div>
                    <div class="date"><?php echo $writers[2];?></div>
                    <div class="date"><?php echo $actors[2];?></div>
                    <div class="date"><?php echo $characters[2];?></div>
                  </li>
                  <li>
                    <div class="date"><?php echo $ids[3];?></div>
                    <div class="date"><?php echo $titles[3];?></div>
                    <div class="date"><?php echo $startYears[3];?></div>
                    <div class="date"><?php echo $runtimes[3];?></div>
                    <div class="date"><?php echo str_replace(",", " ", $genres[3]);?></div>
                    <div class="date"><?php echo $ratings[3];?></div>
                    <div class="date"><?php echo $directors[3];?></div>
                    <div class="date"><?php echo $writers[3];?></div>
                    <div class="date"><?php echo $actors[3];?></div>
                    <div class="date"><?php echo $characters[3];?></div>
                  </li>
                  <li>
                    <div class="date"><?php echo $ids[4];?></div>
                    <div class="date"><?php echo $titles[4];?></div>
                    <div class="date"><?php echo $startYears[4];?></div>
                    <div class="date"><?php echo $runtimes[4];?></div>
                    <div class="date"><?php echo str_replace(",", " ", $genres[4]);?></div>
                    <div class="date"><?php echo $ratings[4];?></div>
                    <div class="date"><?php echo $directors[4];?></div>
                    <div class="date"><?php echo $writers[4];?></div>
                    <div class="date"><?php echo $actors[4];?></div>
                    <div class="date"><?php echo $characters[4];?></div>
                  </li>
                  <li>
                    <div class="date"><?php echo $ids[5];?></div>
                    <div class="date"><?php echo $titles[5];?></div>
                    <div class="date"><?php echo $startYears[5];?></div>
                    <div class="date"><?php echo $runtimes[5];?></div>
                    <div class="date"><?php echo str_replace(",", " ", $genres[5]);?></div>
                    <div class="date"><?php echo $ratings[5];?></div>
                    <div class="date"><?php echo $directors[5];?></div>
                    <div class="date"><?php echo $writers[5];?></div>
                    <div class="date"><?php echo $actors[5];?></div>
                    <div class="date"><?php echo $characters[5];?></div>
                  </li>
                  <li>
                    <div class="date"><?php echo $ids[6];?></div>
                    <div class="date"><?php echo $titles[6];?></div>
                    <div class="date"><?php echo $startYears[6];?></div>
                    <div class="date"><?php echo $runtimes[6];?></div>
                    <div class="date"><?php echo str_replace(",", " ", $genres[6]);?></div>
                    <div class="date"><?php echo $ratings[6];?></div>
                    <div class="date"><?php echo $directors[6];?></div>
                    <div class="date"><?php echo $writers[6];?></div>
                    <div class="date"><?php echo $actors[6];?></div>
                    <div class="date"><?php echo $characters[6];?></div>
                  </li>
                  <li>
                    <div class="date"><?php echo $ids[7];?></div>
                    <div class="date"><?php echo $titles[7];?></div>
                    <div class="date"><?php echo $startYears[7];?></div>
                    <div class="date"><?php echo $runtimes[7];?></div>
                    <div class="date"><?php echo str_replace(",", " ", $genres[7]);?></div>
                    <div class="date"><?php echo $ratings[7];?></div>
                    <div class="date"><?php echo $directors[7];?></div>
                    <div class="date"><?php echo $writers[7];?></div>
                    <div class="date"><?php echo $actors[7];?></div>
                    <div class="date"><?php echo $characters[7];?></div>
                  </li>
                  <li>
                    <div class="date"><?php echo $ids[8];?></div>
                    <div class="date"><?php echo $titles[8];?></div>
                    <div class="date"><?php echo $startYears[8];?></div>
                    <div class="date"><?php echo $runtimes[8];?></div>
                    <div class="date"><?php echo str_replace(",", " ", $genres[8]);?></div>
                    <div class="date"><?php echo $ratings[8];?></div>
                    <div class="date"><?php echo $directors[8];?></div>
                    <div class="date"><?php echo $writers[8];?></div>
                    <div class="date"><?php echo $actors[8];?></div>
                    <div class="date"><?php echo $characters[8];?></div>
                  </li>
                  <li>
                    <div class="date"><?php echo $ids[9];?></div>
                    <div class="date"><?php echo $titles[9];?></div>
                    <div class="date"><?php echo $startYears[9];?></div>
                    <div class="date"><?php echo $runtimes[9];?></div>
                    <div class="date"><?php echo str_replace(",", " ", $genres[9]);?></div>
                    <div class="date"><?php echo $ratings[9];?></div>
                    <div class="date"><?php echo $directors[9];?></div>
                    <div class="date"><?php echo $writers[9];?></div>
                    <div class="date"><?php echo $actors[9];?></div>
                    <div class="date"><?php echo $characters[9];?></div>
                  </li>
                </ul> <!-- .movie-schedule -->
              </div>
            </div>
          </div>
        </div> <!-- .container -->
      </main>
    </div>
    <!-- Default snippet for navigation -->
    


    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/app.js"></script>
    
  </body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET")
{

}
?>


<?php
mysqli_close($conn); // HINT: This statement closes the connection with the database

ob_end_flush();
?>
