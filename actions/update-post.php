<?php
require_once '../lib/common.php';

$ret = array("status" => "Failed");

if($session->is_logined()){
    $post_id = $_POST['post_id'];
    $post = Post::find($post_id)
    $ret['msg'] = 'Successfully edited! <a href="show-article.php?post_id=' . $post_id .  '">Show article</a>';

} else {
    $ret['msg'] = "You have to login to edit.";

}

echo json_encode($ret);

?>
