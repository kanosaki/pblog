<?php
require_once '../lib/common.php';
require_once '../models/post.class.php';
require_once '../models/tag.class.php';


$ret = array("status" => "Failed");

function edit_post(){
    global $session;
    global $ret;
    
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $body  = $_POST['body'];
    $tags = $_POST['tags'];
    $user = $session->user_id();

    $post = Post::find($post_id);
    if(!$post){
        $ret['msg'] = "Application Error! No such articles!";
        return;
    }
    $post->title = $title;
    $post->body  = $body;
    $post->apply();
    $post->setTags($tags);

    $ret['msg'] = 'Successfully edited! <a href="show-article.php?post_id=' . $post_id .  '">Show article</a>';
    $ret['status'] = 'OK';
}

function create_post(){
    global $session;
    global $ret;
    $title = $_POST['title'];
    $body  = $_POST['body'];
    $tags = $_POST['tags'];
    $user = $session->user_id();
    
    $post = Post::create($user, $title, $body);
    $post->apply();
    $post->setTags($tags);
    $ret['msg'] = 'Successfully created! <a href="show-article.php?post_id=' . $post->id .  '">Show article</a>';
    $ret['status'] = 'OK';
}

if($session->is_logined()){
    if(isset($_POST['post_id'])){
        edit_post();
    } else {
        create_post();
    }
} else {
    $ret['msg'] = "You have to login to edit.";

}

echo json_encode($ret);

?>
