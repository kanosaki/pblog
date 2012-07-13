<?php
session_start();
require_once 'config.php';
require_once 'url_to_absolute.php';
require_once 'models/session.class.php';
$GLOBALS['current_filename'] = basename($_SERVER['PHP_SELF'], ".php");
$GLOBALS['root_prefix'] = "";
$GLOBALS['session'] = Session::create();

function p($str){
    echo htmlspecialchars($str);
}

function root_url($scheme='http'){
    // TODO: Use 'SERVER_NAME'
    $http_host = $_SERVER['HTTP_HOST'];
    return "$scheme://$http_host/";
}

function absolute_url($url){
    return url_to_absolute(root_url(), $url);
}
?>
