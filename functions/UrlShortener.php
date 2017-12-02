<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/database/Connection.php';

class UrlShortener
{
    function __construct(){}

    public function generateCode($num)
    {
        if($num){
            $num = $num + 10000000;
            return base_convert($num, 10, 36);
        }
        return false;
    }

    public function returnCode($url)
    {
        $url = trim($url);
        if(!filter_var($url, FILTER_VALIDATE_URL)){
            $_SESSION['error'] = 'Not a valid URL!';
            require $_SERVER['DOCUMENT_ROOT'] . '/index.php';
            die();
        } else {
            $result = $this->selectLink($url);
            if($result['numRows'] > 0){
                return $result['results']['code'];
            }
            $insert = $this->insertLink($url, 'CURDATE()');
            $id = $this->getUrl($url);
            $secret = $this->generateCode($id);
            $updateResult = $this->updateLink($secret, $url);
            return $secret;
        }
        // $url = trim($url);
        // if (!filter_var($url, FILTER_VALIDATE_URL)) {
        //     header("Location: ../index.php?error=inurl");
        //     die();
        // } else {
        //     $url = $this->db->real_escape_string($url);
        //     $exist = $this->db->query("SELECT * FROM link WHERE url ='{$url}'");
        //     if ($exist->num_rows) {
        //         $code = $exist->fetch_object()->code;
        //         return $code;
        //     }
        //     $insert = $this->db->query("INSERT INTO link (url,created) VALUES ('{$url}',CURDATE())");
        //     $fetch = $this->db->query("SELECT * FROM link WHERE url = '{$url}'");
        //     $get_id = $fetch->fetch_object()->id;
        //     $secret = $this->generateCode($get_id);
        //     $update = $this->db->query("UPDATE link SET code = '{$secret}' WHERE url = '{$url}'");
        //     return $secret;
        // }
    }

    /**
     * Insert url and custom short url on the database
     *
     * @param string $url Real Url
     * @param string $custom Custom short url wanted
     *
     * @return int 0 if it didn't work, 1 if it did work, or -1 if there is an error.
     */

    /*
     * inserts a link.
     * returns 0 if it didn't work, 1 if it did work, or -1 if there is an error.
     */
    public function returnCodeCustom($url, $custom)
    {
        $url = trim($url);
        $custom = trim($custom);
        if(!filter_var($url, FILTER_VALIDATE_URL)){
            $_SESSION['error'] = 'Not a valid URL!';
            require $_SERVER['DOCUMENT_ROOT'] . '/index.php';
            die();
        } else {

            //if the link is already in the database, return that link. Only
            $result = $this->selectLink($url);
            if($result['numRows'] > 0){
                return $result['results']['code'];
                die();
            }
            $insert = $this->insertLinkWithCode($url, $custom, 'CURDATE()');
            return $custom;
        }

        // if (filter_var($url, FILTER_VALIDATE_URL)) {
        //     $insert = $this->db->query("INSERT INTO link (url,code,created) VALUES ('{$url}','{$custom}',CURDATE())");
        //     return true;
        // }
        // return false;
    }

    public function getUrl($string)
    {
        $result = $this->selectUrl($string);
        //returns 0 if it didn't work, 1 if it did work, or -1 if there is an error. Check/handle output.
        if($result['noError']){
            return $result['results']['id'];
        } else {
            $_SESSION['error'] = 'Ok! So I got to know you love playing! But don\'t play here!!!';
            require $_SERVER['DOCUMENT_ROOT'] . '/index.php';
            exit();
//            header("Location: http://www.kylebirch.info/url-shortener/index.php?error=dnp");
            //return $result['results'] . '[Error: That url could not be found in the database]';
        }

        // $string = $this->db->real_escape_string(strip_tags(addslashes($string)));
        // $rows = $this->db->query("SELECT url FROM link WHERE code = '{$string}'");
        // if ($rows->num_rows) {
        //     return $rows->fetch_object()->url;
        // } else {
        //     header("Location: index.php?error=dnp");
        //     die();
        // }
    }

    // This function check if the custom url already exists on the database
    public function existsURL($short)
    {
        $result = $this->selectUrlFromCode($short);
        if($result['returnCode'] == 1){
            return ($result['numRows'] > 0);
        } else {
            throw new Exception('error attempting to get URL from database.');
        }

    }

    /*
     * Include the custom code provided by the user.
     *
     * return array:
     * ['noError'] indicates whether an exception was thrown when attempting to execute the SQL
     * ['returnCode'] the value indicating success/failure of the statement (-1, 0, or 1)
     */
    public function insertLinkWithCode($url, $code, $created) {
        //if $url does not end in /, add it here.
        if (substr($url, -1) !== '/'){
            $url .= '/';
        }
        try {
            $sql = "INSERT INTO link (url, code, created) "
                    . "VALUES (:url, :code, :created)";
            $stmt = Connection::dbUser()->prepare($sql);
            $stmt->bindParam(':url', $url, PDO::PARAM_STR);
            $stmt->bindParam(':code', $code, PDO::PARAM_STR);
            $stmt->bindParam(':created', $created, PDO::PARAM_STR);
            $worked = $stmt->execute();
            $stmt->closeCursor();
        } catch (Exception $ex) {
            return array('noError'=>false, 'returnCode'=>$worked);
        }
        return array('noError'=>true, 'returnCode'=>$worked);
    }

    /*
     * Insert link into the database. No code was provided by the user.
     *
     * return array:
     * ['noError'] indicates whether an exception was thrown when attempting to execute the SQL
     * ['returnCode'] the value indicating success/failure of the statement (-1, 0, or 1)
     */
    private function insertLink($url, $created) {
        //if $url does not end in /, add it here.
        if (substr($url, -1) !== '/'){
            $url .= '/';
        }
        try {
            $sql = "INSERT INTO link (url, created) "
                    . "VALUES (:url, :created)";
            $stmt = Connection::dbUser()->prepare($sql);
            $stmt->bindParam(':url', $url, PDO::PARAM_STR);
            $stmt->bindParam(':created', $created, PDO::PARAM_STR);
            $worked = $stmt->execute();
            $stmt->closeCursor();
        } catch (Exception $ex) {
            return array('noError'=>false, 'returnCode'=>$worked);
        }
        return array('noError'=>true, 'returnCode'=>$worked);
    }

    /*
     * Returns the selected URL
     *
     * return array:
     * ['noError'] indicates whether an exception was thrown when attempting to execute the SQL
     * ['results'] the result set from the query
     * ['numRows'] the number of rows returned
     * ['returnCode'] the value indicating success/failure of the statement (-1, 0, or 1)
     */
    private function selectUrl($url) {
        $worked = null;
        $item = null;
        $numRows = null;
        try {
            $sql = "SELECT id, url FROM link WHERE url=:url;";
            $stmt = Connection::dbUser()->prepare($sql);
            $stmt->bindParam(':url', $url, PDO::PARAM_STR);
            //returns 0 if it didn't work, 1 if it did work, or -1 if there is an error. 
            $worked = $stmt->execute();
            $numRows = $stmt->rowCount();
            $item = $stmt->fetch();
            $stmt->closeCursor();
        } catch (Exception $ex) {
            return array('noError'=>false, 'results'=>$item, 'numRows'=>null, 'returnCode'=>$worked);
        }
        return array('noError'=>true, 'results'=>$item, 'numRows'=>$numRows, 'returnCode'=>$worked);
    }

    /*
     * SELECT a link from the database based on the URL
     *
     * return array:
     * ['noError'] indicates whether an exception was thrown when attempting to execute the SQL
     * ['results'] the result set from the query
     * ['numRows'] the number of rows returned
     * ['returnCode'] the value indicating success/failure of the statement (-1, 0, or 1)
     */

    public function selectLink($url){
        $worked = null;
        $item = null;
        $numRows = null;
        try {
            $sql = "SELECT * FROM link WHERE url=:url;";
            $stmt = Connection::dbUser()->prepare($sql);
            $stmt->bindParam(':url', $url, PDO::PARAM_STR);
            //returns 0 if it didn't work, 1 if it did work, or -1 if there is an error. 
            $worked = $stmt->execute();
            $numRows = $stmt->rowCount();
            $item = $stmt->fetch();
            $stmt->closeCursor();

        } catch (Exception $ex) {
            return array('noError'=>false, 'results'=>$item, 'numRows'=>null, 'returnCode'=>$worked);
        }
        return array('noError'=>true, 'results'=>$item, 'numRows'=>$numRows, 'returnCode'=>$worked);
    }

    /*
     * return array:
     * ['noError'] indicates whether an exception was thrown when attempting to execute the SQL
     * ['results'] the result set from the query
     * ['numRows'] the number of rows returned
     * ['returnCode'] the value indicating success/failure of the statement (-1, 0, or 1)
     */
    public function selectUrlFromCode($code){
        // $rows = $this->db->query("SELECT url FROM link WHERE code = '{$short}' LIMIT 1");
        $worked = null;
        $item = null;
        $numRows = null;
        try {
            $sql = "SELECT url FROM link WHERE code=:code;";
            $stmt = Connection::dbUser()->prepare($sql);
            $stmt->bindParam(':code', $code, PDO::PARAM_STR);
            //$worked returns 0 if it didn't work, 1 if it did work, or -1 if there is an error.
            $worked = $stmt->execute();
            $numRows = $stmt->rowCount();
            $item = $stmt->fetch();
            $stmt->closeCursor();
        } catch (Exception $ex) {
            return array('noError'=>false, 'results'=>$item, 'numRows'=>null, 'returnCode'=>$worked);
        }
        return array('noError'=>true, 'results'=>$item, 'numRows'=>$numRows, 'returnCode'=>$worked);
    }

    /*
     * Update link in the database with a new code
     *
     * return array:
     * ['noError'] indicates whether an exception was thrown when attempting to execute the SQL
     * ['numRows'] the number of rows returned
     * ['returnCode'] the value indicating success/failure of the statement (-1, 0, or 1)
     */
    public function updateLink($code, $url){
        //UPDATE link SET code = '{$secret}' WHERE url = '{$url}'
        $worked = null;
        $item = null;
        $numRows = null;
        try {
            $sql = "UPDATE link SET code = :code WHERE url = :url;";
            $stmt = Connection::dbUser()->prepare($sql);
            $stmt->bindParam(':code', $code, PDO::PARAM_STR);
            $stmt->bindParam(':url', $url, PDO::PARAM_STR);
            //$worked returns 0 if it didn't work, 1 if it did work, or -1 if there is an error.
            $worked = $stmt->execute();
            $numRows = $stmt->rowCount();
            $stmt->closeCursor();
        } catch (Exception $ex) {
            return array('noError'=>false, 'numRows'=>$numRows, 'returnCode'=>$worked);
        }
        return array('noError'=>true, 'numRows'=>$numRows, 'returnCode'=>$worked);
    }
}
