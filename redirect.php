<?php
require $_SERVER['DOCUMENT_ROOT'] . '/functions/UrlShortener.php';
$shortener = new UrlShortener();

if (isset($_GET['secret'])) {
    $get_code = $_GET['secret'];
    $get_url = $shortener->selectUrlFromCode($get_code);
    //var_dump($get_url);
    //echo "code: [$get_code]\nurl:[" . $get_url['url'] . "]";
//    die();
    header("Location: " . $get_url['results']['url']);
}

$_SESSION['error'] = 'Error: sorry, something went wrong when I tried to get that route';
include $_SERVER['DOCUMENT_ROOT'] . '/index.php';
die();
