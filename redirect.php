<?php
		require_once ("functions/function.php");
		$call = new makeitshort;
		if(isset($_GET['secret']))
		{
			$get_code = $_GET['secret'];
			$get_url = $call->geturl($get_code);
			header("Location: {$get_url}");
		}
		die();
		header("Location: index.php");
?>
