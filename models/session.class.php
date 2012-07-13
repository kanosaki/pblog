<?php

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
    
    
}
?>
