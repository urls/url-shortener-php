<?php
	session_start();
	require_once 'function.php';
			$insertCustom = false;
			$errors = false;
			$shortener = new UrlShortener();

			if(($_POST['onoffswitch'] == 'on') && (isset($_POST['custom'])))
			{
				$custom = $_POST['custom'];

				if(!$shortener->existsURL($custom))
				{
					$insertCustom = true;
				}
				else
				{
					$errors = true;
					$_SESSION['error'] = "The custom URL <a href='http://urls.ml/".$_POST['custom']."'>http://urls.ml/".$_POST['custom']."</a> already exists";
				}
			}

			if(isset($_POST['url']) && !$errors)
			{
				$url = $_POST['url'];

				if(!$insertCustom)
				{
					if($code = $shortener->returnCode($url))
					{
						$_SESSION['success'] = generateUrl($code);
					}
					else
					{
						$_SESSION['error'] = "There was a problem. Invalid URL, perhaps?";
					}
				}
				else
				{
					if($shortener->returnCodeCustom($url,$custom))
					{
						$_SESSION['success'] = generateUrl($custom);
					}
					else
					{
						header("Location: ../index.php?error=inurl");
						die();
					}
				}

			}

			function generateUrl($urlSuffix = ''){
				return "<a href='http://urls.ml/{$urlSuffix}'>http://urls.ml/{$urlSuffix}</a>";
			}

			header("Location: ../index.php");
?>
