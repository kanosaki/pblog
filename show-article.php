<?php
require_once 'lib/common.php';
require_once 'models/post.class.php';
if(isset($_GET['post_id'])){
    $posts = Post::find($_GET['post_id']);
    if(count($posts) == 1){
        $post = $posts[0];
        $tit = $post->getTitle();
        $page_title = "Artile | $tit";
    } else {
        $post = null;
        $page_title = "Artile | ERROR";
    }
} else {
    $post = null;
    $page_title = "Artile | ERROR";
}
$page_body = "parts/post.php";
require_once "parts/default.php";
?>

