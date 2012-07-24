<?php

require_once '../lib/common.php';
require_once '../models/user.class.php';
header('Content-type', 'application/json; charset=utf-8');


$ret = array();

if(isset($_POST['username'])){
    $username = $_POST['username'];
    $user = User::findByName($username);
    if($user != null){
        $ret['found'] = 1;
    } else {
        $ret['found'] = 0;
    }
} else {
    echo "Invalid request!!";
    exit;
}

echo json_encode($ret);

?>
