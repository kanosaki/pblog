<?php

require_once '../lib/common.php';
require_once '../models/post.class.php';
header('Content-type', 'application/json; charset=utf-8');

$ret = array("status" => "Failed");

if(isset($_POST['post_id'])){
    $post = Post::find($_POST['post_id']);
    if($post){
        $post->delete(); 
        $ret['message'] = "Successfully deleted!";
        $ret['status'] = 'OK';
    } else {
        $ret['message'] = "Article not found!!";
    }
} else {
    $ret['message'] = "Missing post_id";
}


echo json_encode($ret);

?>
