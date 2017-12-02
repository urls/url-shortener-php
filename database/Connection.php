<?php
/*
Use this to store database connections
*/

class Connection
{
	public static function dbUser() {
	    $server = '{HOST_NAME}';
	    $dbname = '{DB_NAME}';
	    $username = '{USER_NAME}';
	    $password = '{USER_PASSWORD}';
	    $dsn = 'mysql:host=' . $server . ';dbname=' . $dbname;
	    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
	    try {
	        $link = new PDO($dsn, $username, $password, $options);
	    } catch (Exception $ex) {
	        return false;
	    }
	    return $link;
	}
}