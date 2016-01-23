<?php
	session_start();
	include ("function.php");

	if(isset($_POST['url']))
	{
		$url = $_POST['url'];
		if($code = makecode($url))
		{
			$_SESSION['feedback'] = "Generated url is : <a href=\"http://urls.ml/".$code."\">http://urls.ml/".$code."</a>";
		}
		else
		{
			$_SESSION['feedback'] = "There was a problem. Invalid url, perhaps ?";
		}
	}

	header("Location: /project/url");
	?>		