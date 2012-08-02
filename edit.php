<?php
require_once 'lib/common.php';
$page_title = "Edit";
$page_body = "edit-post.php";

require_once 'models/post.class.php';
if($session->is_logined()){
  if(isset($_GET['post_id'])){
      // Edit article
      $post = Post::find($_GET['post_id']);
      if($post->author_id != $session->user_id()){
        abort_with_message("You are not owner of this article.");
      }
      $editing = true;
      $first_header = "Edit article '$post->title'";
  } else {
      $post = new Post();
      $editing = false;
      $first_header = "Create article";
  }
} else {
  abort_with_message("Authentication required.");
}

require_once "parts/default.php";
?>
