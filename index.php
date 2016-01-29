<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="url shortener">
	<title>MakeItShort!</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
<br>
<center>
<h1>Make It Short</h1>
	<?php
		if(isset($_SESSION['success']))
		{
			echo "<p class='success'>".$_SESSION['success']."</p>";
			unset($_SESSION['success']);
		}
		if(isset($_SESSION['error']))
		{
			echo "<p class='alert'>".$_SESSION['error']."</p>";
			unset($_SESSION['error']);
		}
		if(isset($_GET['error']) && $_GET['error'] == 'db')
		{
			echo "<p class='alert'>Error in connecting to Database!</p>";
		}
		if(isset($_GET['error']) && $_GET['error'] == 'inurl')
		{
			echo "<p class='alert'>Not a valid url!</p>";
		}
		if(isset($_GET['error']) && $_GET['error'] == 'dnp')
		{
			echo "<p class='alert'>Ok! so i got to know you love playing! But don't play here!!</p>";
		}
	?>
	<form method="POST" action="functions/shorten.php">
		<input type="url" name="url" class="input" placeholder="Enter a url here"><br>
		<input type="submit" value="Go" class="submit">
	</form>
</center>
</body>
</html>
