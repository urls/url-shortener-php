<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/main.css">
	<title>URL Shortner</title>
</head>
<body>
	<h1>Shorten a URL</h1>
	<hr>
	<div class="container">
		<center>
<?php

	if(isset($_SESSION['feedback']))
	{
		echo "<p>".$_SESSION['feedback']."</p>";
		unset($_SESSION['feedback']);
	}

?>
			<form method="POST" action="functions/shorten.php">
				<input type="url" class="form-control" name="url" placeholder="Enter your Long URL here" autofocus /><br>
				<input type="submit" value="Shorten" class="btn btn-primary btn-lg">
			</form>
		</center>
	</div>
</body>
</html>