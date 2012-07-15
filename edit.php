<?php
require_once 'lib/common.php';
$page_title = "Edit";
$page_body = "edit-post.php";


// TODO: Add form validation.

// REST style
// GET  ->  has(post_id) -> Edit
//      -> !has(post_id) -> Create
// POST -> Update/Create 

require_once 'models/post.class.php';
if(isset($_GET['post_id'])){
    // Edit article
    $post = Post::find($_GET['post_id']);
    $editing = true;
    $first_header = "Edit article '$post->title'";
} else {
    echo "Missing post_id";
    exit;
}

require_once "parts/default.php";
?>
