<?php
session_start();
// more portable. It should work with any dev environment.


require $_SERVER['DOCUMENT_ROOT'] . '/functions/UrlShortener.php';

$insertCustom = false;
$errors = false;
$shortener = new UrlShortener();

if (isset($_POST['custom'])) {
    $custom = $_POST['custom'];
}

if ($_POST['onoffswitch'] == 'on') {
    try{
        if (!$shortener->existsURL($custom)) {
            $insertCustom = true;
        } else {
            $errors = true;
            $_SESSION['error'] = "The custom URL <a href='http://www.url-shortener.kylebirch.info/" . $_POST['custom'] . "'>http://url-shortener.kylebirch.info/" . $_POST['custom'] . "</a> already exists";
            header("Location: http://url-shortener.kylebirch.info/index.php");
            die();
        }
    } catch (Exception $ex) {
        $_SESSION['error'] = $ex;
        header("Location: http://url-shortener.kylebirch.info/index.php");
        die();
    }
}

if (isset($_POST['url']) && !$errors) {
    $url = $_POST['url'];

    if (!$insertCustom) {
        $result = $shortener->returnCode($url);
        if ($result === false) {
            $_SESSION['error'] = "There was a problem. Invalid URL, perhaps?";
            header("Location: http://url-shortener.kylebirch.info/index.php");
            die();
        } else {
            $_SESSION['success'] = generateUrl($result);
            header("Location: http://url-shortener.kylebirch.info/index.php");
            die();
        }
    } else {
            $var = $shortener->returnCodeCustom($url, $custom);
            $_SESSION['success'] = generateUrl($var);
            header("Location: http://url-shortener.kylebirch.info/index.php");
            die();
    }
}

function generateUrl($urlSuffix = '')
{
    return '<a href="http://www.url-shortener.kylebirch.info/' . $urlSuffix . '">Your url is: http://www.url-shortener.kylebirch.info/' . $urlSuffix . '</a>';
}

require $_SERVER['DOCUMENT_ROOT'] . '/index.php';
die();
