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
  echo "Connection failed! <br>";
}

$genres = $time = "All";
$order = "HotDegree";

if ($order == "HotDegree") {
	$orderText = " Most Popular";
}
else {
	$orderText = " Highest Rating";
}

if ($genres == "All") {
	$genresText = "";
}
else {
	$genresText = " of " . $genres ;
}

if ($time == "All") {
	$timeText = "";
}
elseif ($time == "1900") {
	$timeText = " From 1900 - 2000";
}
elseif ($time == "2000") {
	$timeText = " From 2000 - 2010";
}
else {
	$timeText = " From 2010 - Now";
}

$title = "Top 10" . $orderText . " Movies" . $genresText . $timeText;

$tops = array("", "", "", "", "", "", "", "", "", "");
$ratings = array("", "", "", "", "", "", "", "", "", "");

if ($genres == "All") {
	$genresSql = "";
}
else {
	$genresSql = " where genres like '%$genres%'";
}

if ($time == "All") {
	$timeSql = "";
}
elseif ($time == "1900") {
	$timeSql = " where startYear < 2000";
}
elseif ($time == "2000") {
	$timeSql = " where startYear < 2010 and startYear >= 2000";
}
else {
	$timeSql = " where startYear >= 2010";
}

if ($order == "HotDegree") {
	$orderSql = " order by numVotes desc";
}
else {
	$orderSql = " order by averageRating desc";
}

$sql = "select * from (title_basics_mini inner join title_ratings_mini on title_basics_mini.tconst = title_ratings_mini.tconst)" . $genresSql . $timeSql . $orderSql . " limit 0, 10";

$result = $conn->query($sql);
$len = $result->num_rows;

for ($i = 0; $i < $len; $i++) {
	$row = $result->fetch_assoc();
	$tops[$i] = $row["primaryTitle"];
	$ratings[$i] = $row["averageRating"];
}

?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$genres = $_POST["genres"];
	$time = $_POST["time"];
	$order = $_POST["order"];

	if ($order == "HotDegree") {
		$orderText = " Most Popular";
	}
	else {
		$orderText = " Highest Rating";
	}

	if ($genres == "All") {
		$genresText = "";
	}
	else {
		$genresText = " of " . $genres ;
	}

	if ($time == "All") {
		$timeText = "";
	}
	elseif ($time == "1900") {
		$timeText = " From 1900 - 2000";
	}
	elseif ($time == "2000") {
		$timeText = " From 2000 - 2010";
	}
	else {
		$timeText = " From 2010";
	}

	$title = "Top 10" . $orderText . " Movies" . $genresText . $timeText;

	if ($genres == "All" and $time == "All") {
		$where = "";
	}
	else {
		$where = " where";
	}

	if ($genres != "All" and $time != "All") {
		$and = " and";
	}
	else {
		$and = "";
	}

	if ($genres == "All") {
		$genresSql = "";
	}
	elseif ($genres == "Science-Fiction") {
		$genresSql = " genres like '%Sci-Fi%'";
	}
	else {
		$genresSql = " genres like '%$genres%'";
	}

	if ($time == "All") {
		$timeSql = "";
	}
	elseif ($time == "1900") {
		$timeSql = " startYear < 2000";
	}
	elseif ($time == "2000") {
		$timeSql = " startYear < 2010 and startYear >= 2000";
	}
	else {
		$timeSql = " startYear >= 2010";
	}

	if ($order == "HotDegree") {
		$orderSql = " order by numVotes desc";
	}
	else {
		$orderSql = " order by averageRating desc";
	}

	$sql = "select * from (title_basics_mini inner join title_ratings_mini on title_basics_mini.tconst = title_ratings_mini.tconst)" . $where . $genresSql . $and . $timeSql . $orderSql . " limit 0, 10";

	$result = $conn->query($sql);

	for ($i = 0; $i < 10; $i++) {
		$row = $result->fetch_assoc();
		$tops[$i] = $row["primaryTitle"];
		$ratings[$i] = $row["averageRating"];
	}	
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
						<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
							<div class="filters">
								<select name="genres" placeholder="Choose Category">
									<option value="All">All</option>
									<option value="Action">Action</option>
									<option value="Adventure">Adventure</option>
									<option value="Animation">Animation</option>
									<option value="Biography">Biography</option>
									<option value="Comedy">Comedy</option>
									<option value="Crime">Crime</option>
									<option value="Drama">Drama</option>
									<option value="Family">Family</option>
									<option value="Fantasy">Fantasy</option>
									<option value="History">History</option>
									<option value="Horror">Horror</option>
									<option value="Musical">Musical</option>
									<option value="Mystery">Mystery</option>
									<option value="Romance">Romance</option>
									<option value="Science-Fiction">Science-Fiction</option>
									<option value="Thriller">Thriller</option>
									<option value="War">War</option>
								</select>
								<select name="time">
									<option value="All">All</option>
									<option value="1900">1900-2000</option>
									<option value="2000">2000-2010</option>
									<option value="2010">2010-</option>
								</select>
								<select name="order">
									<option value="HotDegree">Hot Degree</option>
									<option value="Rating">Rating</option>
								</select>
								<input type="submit" name="submit" value="Select">
							</div>
						</form>
						<div class="row">
							<div class="col-md-10">
								<h2 class="section-title"><?php echo $title;?></h2>
								<ul class="movie-schedule">
									<li>
										<div class="date">Ranking</div>
										<div class="date">Rating</div>
										<h2 class="entry-title">Title</h2>
									</li>
									<li>
										<div class="date">1</div>
										<div class="date"><?php echo $ratings[0];?></div>
										<h2 class="entry-title" name="1"><a href="#"><?php echo $tops[0];?></a></h2>
									</li>
									<li>
										<div class="date">2</div>
										<div class="date"><?php echo $ratings[1];?></div>
										<h2 class="entry-title" name="2"><a href="#"><?php echo $tops[1];?></a></h2>
										<!-- <h2 class="entry-title"><?php echo $ratings[1];?></h2> -->
									</li>
									<li>
										<div class="date">3</div>
										<div class="date"><?php echo $ratings[2];?></div>
										<h2 class="entry-title" name="3"><a href="#"><?php echo $tops[2];?></a></h2>
										<!-- <h2 class="entry-title"><?php echo $ratings[2];?></h2> -->
									</li>
									<li>
										<div class="date">4</div>
										<div class="date"><?php echo $ratings[3];?></div>
										<h2 class="entry-title" name="4"><a href="#"><?php echo $tops[3];?></a></h2>
										<!-- <h2 class="entry-title"><?php echo $ratings[3];?></h2> -->
									</li>
									<li>
										<div class="date">5</div>
										<div class="date"><?php echo $ratings[4];?></div>
										<h2 class="entry-title" name="5"><a href="#"><?php echo $tops[4];?></a></h2>
										<!-- <h2 class="entry-title"><?php echo $ratings[4];?></h2> -->
									</li>
									<li>
										<div class="date">6</div>
										<div class="date"><?php echo $ratings[5];?></div>
										<h2 class="entry-title" name="6"><a href="#"><?php echo $tops[5];?></a></h2>
										<!-- <h2 class="entry-title"><?php echo $ratings[5];?></h2> -->
									</li>
									<li>
										<div class="date">7</div>
										<div class="date"><?php echo $ratings[6];?></div>
										<h2 class="entry-title" name="7"><a href="#"><?php echo $tops[6];?></a></h2>
										<!-- <h2 class="entry-title"><?php echo $ratings[6];?></h2> -->
									</li>
									<li>
										<div class="date">8</div>
										<div class="date"><?php echo $ratings[7];?></div>
										<h2 class="entry-title" name="8"><a href="#"><?php echo $tops[7];?></a></h2>
										<!-- <h2 class="entry-title"><?php echo $ratings[7];?></h2> -->
									</li>
									<li>
										<div class="date">9</div>
										<div class="date"><?php echo $ratings[8];?></div>
										<h2 class="entry-title" name="9"><a href="#"><?php echo $tops[8];?></a></h2>
										<!-- <h2 class="entry-title"><?php echo $ratings[8];?></h2> -->
									</li>
									<li>
										<div class="date">10</div>
										<div class="date"><?php echo $ratings[9];?></div>
										<h2 class="entry-title" name="10"><a href="#"><?php echo $tops[9];?></a></h2>
<!-- 										<h2 class="entry-title"><?php echo $ratings[9];?></h2> -->
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