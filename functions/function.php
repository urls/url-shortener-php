<?php

class makeitshort {
		protected $db;

		public function __construct()
		{
			$this->db = new mysqli('localhost','root','','urls');
			if($this->db->connect_errno)
			{
				header("Location: ../index.php?error=db");
				die();
			}
		}

		public function generatecode($num)
		{
			$num = $num + 10000000;
			return base_convert($num, 10, 36);
		}

		public function returncode($url)
		{
			$url = trim($url);
			if(!filter_var($url,FILTER_VALIDATE_URL))
			{
				header("Location: ../index.php?error=inurl");
				die();
			}
			else
			{
				$url = $this->db->real_escape_string($url);
				$exist = $this->db->query("SELECT * FROM link WHERE url ='{$url}'");
				if($exist->num_rows)
				{
					$code = $exist->fetch_object()->code;
					return $code;
				}
				else
				{
					$insert = $this->db->query("INSERT INTO link (url,created) VALUES ('{$url}',NOW())");
					$fetch = $this->db->query("SELECT * FROM link WHERE url = '{$url}'");
					$get_id = $fetch->fetch_object()->id;
					$secret = $this->generatecode($get_id);
					$update = $this->db->query("UPDATE link SET code = '{$secret}' WHERE url = '{$url}'");
					return $secret;
				}
			}
		}
		
		/**
		 * Insert url and custom short url on the database
		 *
		 * @param string 			 $url        	Real Url
		 * @param string             $custom	    Custom short url wanted
		 *
		 * @return bool
		 */
		public function returncodeCustom($url,$custom)
		{
			$url = trim($url);
			$custom = trim($custom);
			if(filter_var($url,FILTER_VALIDATE_URL)){
				$insert = $this->db->query("INSERT INTO link (url,code,created) VALUES ('{$url}','{$custom}',NOW())");
				return true;
			}
			
			return false;
		}

		public function geturl($string)
		{
			$string = $this->db->real_escape_string(strip_tags(addslashes($string)));
			$rows = $this->db->query("SELECT url FROM link WHERE code = '{$string}'");
			if($rows->num_rows)
			{
				return $rows->fetch_object()->url;
			}
			else
			{
				header("Location: index.php?error=dnp");
				die();
			}
		}

		//This function check if the custom url already exists on the database
		public function existsURL($short)
		{
			$short = $this->db->real_escape_string(strip_tags(addslashes($short)));
			$rows = $this->db->query("SELECT url FROM link WHERE code = '{$short}' limit 1");
			if($rows->num_rows > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
}
?>
