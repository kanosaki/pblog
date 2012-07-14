<?php
require_once 'lib/common.php';
require_once 'models/post.class.php';
if(isset($_GET['post_id'])){
    $post = Post::find($_GET['post_id']);
    if($post){
        $tit = $post->getTitle();
        $page_title = "Artile | $tit";
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}
$page_body = "parts/post.php";
require_once "parts/default.php";
?>

