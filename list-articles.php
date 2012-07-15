<?php
require_once 'lib/common.php';
$page_title = "Posts";
$page_body = "postlist.php";

require 'models/post.class.php';
if(isset($_GET['count']) && (int)$_GET['count']) $count = (int)$_GET['count'];
else $count = 10;

// Recet posts
$posts = Post::recent_posts($count);
$list_mode = "Recent $count posts.";

require_once "parts/default.php";
?>
