<?php
require 'models/post.class.php';
if(isset($_GET['count']) && (int)$_GET['count']) $count = (int)$_GET['count'];
else $count = 10;

// Recet posts
$posts = Post::recent_posts($count);
$list_mode = "Recent $count posts.";

?>
    <h1>Articles <small><?php p($list_mode); ?></small></h1>

<?php foreach($posts as $post) { ?>
<div class="post-wrap">
    <div class="page-header post-title">
        <h2><?php p($post->getTitle()); ?></h2>
    </div>
    <div class="post-body">
    <?php p($post->getBody()); ?> 
    </div>
</div>

<?php } ?> 