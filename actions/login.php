<?php
require_once '../lib/common.php';

$ret = array( 'status' => 'Failed' );

if(isset($_POST['username']) && isset($_POST['password'])){
    try{
        $session->login($_POST['username'], $_POST['password']);
        $ret['message'] = "Authorized.";
        $ret['status'] = "OK";
    }catch(Exception $e){
        $ret['message'] = "Invalid username and password pair";
    }
} else {
    $ret['message'] = "username and password requried";
}

echo json_encode($ret);

?>
