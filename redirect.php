<?php
require_once("functions/function.php");

$shortener = new UrlShortener();

if (isset($_GET['secret'])) {
    $get_code = $_GET['secret'];
    $get_url = $shortener->getUrl($get_code);
    header("Location: {$get_url}");
}

header("Location: index.php");
die();
?>
