<?php
	session_start();
	require_once 'function.php';
			$insertCustom = false;
			$errors = false;
			$call = new makeitshort;

			if(($_POST['onoffswitch'] == 'on') && (isset($_POST['custom'])))
			{
				$custom = $_POST['custom'];

				if(!$call->existsURL($custom))
				{
					$insertCustom = true;
				}
				else
				{
					$errors = true;
					$_SESSION['error'] = "The custom URL <a href='http://urls.ml/".$_POST['custom']."'>http://urls.ml/".$_POST['custom']."</a> already exists";
				}
			}

			if(isset($_POST['url']) && !errors)
			{
				$url = $_POST['url'];

				if(!$insertCustom)
				{
					if($code = $call->returncode($url))
					{
						$_SESSION['success'] = "<a href=\"http://urls.ml/{$code}\">http://urls.ml/{$code}</a>";
					}
					else
					{
						$_SESSION['error'] = "There was a problem. Invalid URL, perhaps?";
					}
				}
				else
				{
					if($code = $call->returncodeCustom($url,$custom))
					{
						$_SESSION['success'] = "<a href=\"http://urls.ml/{$code}\">http://urls.ml/{$code}</a>";
					}
					else
					{
						$_SESSION['error'] = "There was a problem. Invalid URL, perhaps?";
					}
				}

			}

			header("Location: ../index.php");
?>
