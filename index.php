<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>URL Shortner</title>
</head>
<body>
<br>
<center>
<h1>Shorten a url</h1>
	<?php
		if(isset($_SESSION['feedback']))
		{
			echo "<p>".$_SESSION['feedback']."</p>";
			unset($_SESSION['feedback']);
		}
	?>
	<form method="POST" action="functions/shorten.php">
		<input type="url" name="url" >
		<input type="submit" value="Shorten">
	</form>
</center>
</body>
</html>