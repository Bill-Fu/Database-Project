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
$title = $year = $runtime = $genres = $rating = $vote = $id = "";

?>

<!DOCTYPE HTML>  
<html>
<head>
  <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
  <style>
  .error {color: #FF0000;}
  </style>
</head>
<body style="position: relative; 
  width: 50%;
  margin: 0 auto;
  padding: 10px;
  background-image: url(bg.jpg);
  background-size: 100% 620px;
  background-repeat: repeat;">  
<h2 style="text-align: center; 
  font-family: 'Josefin Sans', cursive;
  display: block;
  color: #000066;
  font-size: 58px;
  font-weight: bold;"> Movier Management System </h2>
<hr>
<h2 style="text-align: center; font-family: 'Josefin Sans', cursive; color: #FF6600;font-size: 30px;">Insert</h2>
<hr>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
  Title:
  <input type="text" name="title" value="<?php echo $title;?>">
  
  Year:
  <input type="text" name="year" value="<?php echo $year;?>">

  Runtime:
  <input type="text" name="runtime" value="<?php echo $runtime;?>">
  <br>

  Genres:
  <input type="text" name="genres" value="<?php echo $genres;?>">
  
  Rating:
  <input type="text" name="rating" value="<?php echo $rating;?>">

  Number of Vote:
  <input type="text" name="vote" value="<?php echo $vote;?>">

  <br>
  <input type="submit" name="submit" value="Insert">  
</form>

<h2 style="text-align: center; font-family: 'Josefin Sans', cursive; color: #FF6600;font-size: 30px;">Delete</h2>
<hr>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
  id:
  <input type="text" name="id" value="<?php echo $id;?>">

  <br>
  <input type="submit" name="submit" value="Delete">  
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	if ($_POST["submit"] == "Insert") {
		$sql = "select max(tconst) from title_basics_mini;";

		$result = $conn->query($sql);

		while ($row = $result->fetch_assoc()) {
			$maxId = $row["max(tconst)"];
		}

		$newId = substr($maxId, 0, 2) . ((string)((int)substr($maxId, 2) + 1));

		$title = $_POST["title"];
		$year = $_POST["year"];
		$runtime = $_POST["runtime"];
		$genres = $_POST["genres"];
		$rating = $_POST["rating"];
		$vote = $_POST["vote"];

		$sql = "insert into title_basics_mini values('$newId', 'movie', '$title', '$title', 0, '$year', null, $runtime, '$genres');";

		$result1 = $conn->query($sql);

		$sql = "insert into title_ratings_mini values('$newId', $rating, $vote);";

		$result2 = $conn->query($sql);

		if ($result1 === TRUE and $result2 === TRUE) {
			echo "New record created successfully";
		}
		else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	else {
		$id = $_POST["id"];
		$sql = "delete from title_basics_mini where tconst = '$id'";

		$result1 = $conn->query($sql);

		$sql = "delete from title_ratings_mini where tconst = '$id'";

		$result2 = $conn->query($sql);

		if ($result1 === TRUE and $result2 === TRUE) {
			echo "Record deleted successfully";
		}
		else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

  // $inputUsername = $_POST["inputUsername"];
  // $inputPassword = $_POST["inputPassword"];
  // //echo $inputUsername . "<br>";

  // $sql = "select * from Login where username = '$inputUsername'";
  // // HINT: your SQL Query to get the row with given username
  // // Is it Select or Insert or Delete or Alter? 


  // $result = $conn->query($sql);


  // if ($result->num_rows > 0) 
  // {
  //     // output data of each row -- here we have one or 0 rows because username is primary key
  //     while($row = $result->fetch_assoc()) 
  //     {
  //       $pwd = $row["password"];
  //     }
  // }



  // if($pwd == $inputPassword)
  //   //HINT: Which variable did you use to store your password obtained from the SQL query 
  // {
  // echo "Connection success!";
  // // you can add code to jump to welcome page
  // }
  // else
  // {
  // echo "Password or username is incorrect";
  // }

}
?>


<?php
mysqli_close($conn); // HINT: This statement closes the connection with the database

ob_end_flush();
?>






















