<?php
require_once '../lib/common.php';
header('Content-type', 'application/json; charset=utf-8');

$ret = array( 'status' => 'Failed' );

if(isset($_POST['username']) && isset($_POST['password'])){
    try{
        $session->signup($_POST['username'], $_POST['password']);
        $ret['message'] = "Welcome.";
        $ret['status'] = "OK";
    }catch(Exception $e){
        $ret['message'] = "Invalid username and password pair $e";
    }
} else {
    $ret['message'] = "username and password requried";
}

echo json_encode($ret);
?>
