<?php
require_once 'lib/common.php';

// has('user_id])  -> Forward to index.php
// !has('user_id') -> Outer login ->
//      -> Rejected | Show error 
//      -> Accepted | already known -> Forward index.php
//      -> Accepted | first user    -> Enter username(user-profile.php)

if($session->is_logined()){
    header('Location: index.php');
}

$page_title = "Login";
require_once "parts/login.php";
?>
