<?php
require_once 'lib/common.php';
$page_title = "Edit";
$page_body = "edit-post.php";

require_once 'models/post.class.php';
if(isset($_GET['post_id'])){
    // Edit article
    $post = Post::find($_GET['post_id']);
    $editing = true;
    $first_header = "Edit article '$post->title'";
} else {
    $post = new Post();
    $editing = false;
    $first_header = "Create article";
}

require_once "parts/default.php";
?>
