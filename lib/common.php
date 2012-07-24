<?php
session_start();
set_include_path(get_include_path() . PATH_SEPARATOR . realpath(__DIR__ . '/..'));
require_once 'config.php';
require_once 'json_encode.php';
require_once 'url_to_absolute.php';
require_once 'models/user.class.php';
class Session {
    static function create(){
        return new Session();
    }

    function is_logined(){
        return isset($_SESSION['user_id']);
    }

    function user_id(){
        return $_SESSION['user_id'];
    }

    function user_name(){
        return $_SESSION['user_name'];
    }

    function set_user_name($val){
        $_SESSION['user_name'] = $val; 
    }

    function login($name, $pass){
        $user = User::auth($name, $pass);
        if($user){
            $_SESSION['user_id'] =  $user->id;
            $_SESSION['user_name'] = $user->name;
        }
        return $user;
    }
    
    function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
    }

    function signup($name, $pass){
        $user = User::create($name, $pass);
        $user->apply();
        if($user){
            $_SESSION['user_id'] =  $user->id;
            $_SESSION['user_name'] = $user->name;
        }
        return $user;
    }

}    
$GLOBALS['current_filename'] = basename($_SERVER['PHP_SELF'], ".php");
$GLOBALS['root_prefix'] = "";
$GLOBALS['session'] = Session::create();

function p($str){
    echo htmlspecialchars($str);
}

function getCurrentPageID(){
    if(isset($GLOBALS['page_id'])){
        return $GLOBALS['page_id'];
    } else {
        return $GLOBALS['current_filename'];
    }
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
