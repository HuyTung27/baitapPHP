<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<input type="submit" name="cr_db" value="create_db">
</form>
<?php
$servername = "localhost";
$username = "root";
$password = "";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	try {
	  $conn = new PDO("mysql:host=$servername", $username, $password);
	  // set the PDO error mode to exception
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  $sql = "CREATE DATABASE employee_db";
	  // use exec() because no results are returned
	  $conn->exec($sql);
	  echo "Database created successfully<br>";
	} catch(PDOException $e) {
	  echo $sql . "<br>" . $e->getMessage();
	}

	$conn = null;
}
?>




</body>
</html>