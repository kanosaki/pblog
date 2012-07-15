<?php
require_once 'lib/common.php';

// has('user_id])  -> Forward to index.php
// !has('user_id') -> Outer login ->
//      -> Rejected | Show error 
//      -> Accepted | already known -> Forward index.php
//      -> Accepted | first user    -> Enter username(user-profile.php)

if(DEBUG && !$session->is_logined()){
    $_SESSION['user_id'] = 1;
    $_SESSION['user_name'] = 'Admin';
    header("Location: index.php");
}
$page_title = "Login";
require_once "parts/login.php";
?>
