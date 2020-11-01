<?php

$request = explode('/', $_SERVER['REQUEST_URI']);
$name = end($request);

if (file_exists($name)) {

    $value = $_SERVER['HTTP_REFERER'];
    setcookie("referer", $value);

    header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
    header('Content-Type: application/force-download');
    header('Content-Transfer-Encoding: binary');
    header('Content-Disposition: attachment; name=' . $name);
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Content-Length: ' . filesize($name));

    readfile($name);
    exit;
}
