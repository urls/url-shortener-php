<?php
	session_start();
	require_once 'function.php';
			$call = new makeitshort;

			if(isset($_POST['url']))
			{
				$url = $_POST['url'];
				if($code = $call->returncode($url))
				{
					$_SESSION['success'] = "<a href=\"http://urls.ml/{$code}\">http://urls.ml/{$code}</a>";
				}
				else
				{
					$_SESSION['error'] = "There was a problem. Invalid URL, perhaps?";
				}
			}
			header("Location: ../index.php");
?>
