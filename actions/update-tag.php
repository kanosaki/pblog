<?php

require_once '../lib/common.php';
require_once '../models/post.class.php';
header('Content-type', 'application/json; charset=utf-8');
$ret = array(
    "status" => "Failed"
);
if($session->is_logined()){
    if(isset($_POST['post_id'])){
        $value = $_POST['value'];
        $post = Post::find($_POST['post_id']);
        $post->setTags($value);
        $ret['status'] = "OK";
        $ret['msg'] = "Successfully updated!";
    } else {
        $ret['msg'] = 'Missing post_id';
    }
} else {
    $ret['msg'] = "You have to sign in.";
}

echo json_encode($ret);

?>
