<?php
require_once 'lib/common.php';
require_once 'models/user.class.php';

if(isset($_GET['user_id'])){
    $target_user_id = $_GET['user_id'];
} else if(isset($_SESSION['user_id'])) {
    $target_user_id = $_SESSION['user_id'];
} 

if(isset($target_user_id)){
    $user = User::find($target_user_id);
    $page_title = "User";
    $page_body = "parts/show-user.php";
    require_once "parts/default.php";
} else {
}
?>
