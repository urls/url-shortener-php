<?php
mysql_connect("{HOST_NAME}","{DB_NAME}","{DB_PASSWORD}");
mysql_select_db("{DB_NAME}");

function generatecode($num)
{
	$num = $num + 10000000;
	return base_convert($num, 10, 36);
}

function makecode($url)
{
	$url = trim($url);
	if(!filter_var($url,FILTER_VALIDATE_URL))
	{
		return '';
	}
	else
	{
		$url = mysql_real_escape_string($url);
		$exist = mysql_query("SELECT * FROM `link` WHERE `url` = '".$url."'")or die(mysql_error());
		$code = mysql_fetch_assoc($exist);
		if(mysql_num_rows($exist))
		{
			return $code['code'];
		}
		else
		{
			$insert = mysql_query("INSERT INTO `link` (`url`,`created`) VALUES ('".$url."','".time()."')") or die(mysql_error());
			$fetch = mysql_query("SELECT * FROM `link` WHERE `url` = '".$url."'")or die(mysql_error());
			$get_id = mysql_fetch_assoc($fetch);
			$secret = generatecode($get_id['id']);
			$update = mysql_query("UPDATE `link` SET `code` = '".$secret."' WHERE `url` = '".$url."'") or die(mysql_error());
			return $secret;
		}

	}
}

function geturl($string)
{

	$string = mysql_real_escape_string(strip_tags(addslashes($string)));
	$rows = mysql_query("SELECT `url` FROM `link` WHERE `code` = '".$string."'")or die(mysql_error());
	if(mysql_num_rows($rows))
	{
		$url_return = mysql_fetch_assoc($rows);
		return $url_return['url'];
	}
	else
	{
		return "";
	}
}

?>
