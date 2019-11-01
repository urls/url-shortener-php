<?php

require_once("UrlShortener.php");

$urlShortener = new UrlShortener();

if (isset($_GET['secret'])) {
    $uniqueCode = $_GET['secret'];
    $orignalUrl = $urlShortener->getOrignalURL($uniqueCode);
    header("Location: {$orignalUrl}");
    die();
}

header("Location: index.php");
die();

?>