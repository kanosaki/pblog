<?php

require_once '../lib/common.php';
$ret = array(
    "status" => "Failed"
);
if($session->is_logined()){
    if(isset($_POST['name'])){
        $name = $_POST['name'];
        $user = User::find($session->user_id());
        $user->name = $name;
        $session->set_user_name($name);
        $user->apply();
        $ret['status'] = 'OK';
        $ret['msg'] = 'Successfully applied changes.';
    } else {
        $ret['msg'] = "'Name' field has not been supplied.";
    }
} else {
    $ret['msg'] = "You have to sign in.";
}

echo json_encode($ret);

?>
